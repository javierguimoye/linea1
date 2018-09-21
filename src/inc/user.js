import {Api} from "./api";
import store from "./store";
import Util from "./utils";

export class User {

    static KEY_USER = 'user.v3_';

    static id = 0;
    static id_role = 0;
    static token = '';
    static _name = '';
    static surname = '';
    static menu = {};
    static stg = {};
    static verified_time = 0;

    static init() {
        let user = JSON.parse(localStorage.getItem(User.KEY_USER));
        if (user) {

            User.id = user.id;
            User.id_role = user.id_role;
            User.token = user.token;
            User._name = user.name;
            User.surname = user.surname;
            User.menu = user.menu;
            User.stg = user.stg;

            if (user.verified_time) {
                User.verified_time = user.verified_time;
            }

        }
    }

    static logged() {
        return User.id > 0;
    };

    static login(user) {
        localStorage.setItem(User.KEY_USER, JSON.stringify(user));
    }

    static logout() {
        localStorage.removeItem(User.KEY_USER);
    }

    /**
     * Verificar info del servidor
     * Solo se verifica si la ultima verificacion fue hace mas de 60 SEGUNDOS
     * @param callback
     */
    static verifyListener = null;

    static verify(callback) {

        // debe verificar cara 10 minutos, no es automatico, solo cuanfo refresca la pagina

        let time_delay = 600;
        //let time_delay = 1;

        let diff = Util.time() - User.verified_time;

        if (diff > time_delay) {

            console.log('verificando porque paso ', diff, 'segundos');

            Api.get('/verify', (rsp) => {

                if (rsp.ok) {
                    let shortcuts = [];

                    function sanite(items) {
                        items.map((o) => {

                            if (o.url === '#' || o.url === '') {
                                o.url = '#';
                            }
                            if (o.children.length === 0) {
                                delete o.children;
                            } else {
                                sanite(o.children);
                            }
                            o.url = '/' + o.url;

                            if (o.shortcut === '1') {
                                shortcuts.push(o);
                            }

                            return true;
                        });
                    }

                    sanite(rsp.menu);

                    let login = rsp.user;
                    login.verified_time = Util.time();
                    login.menu = {
                        home: '/' + rsp.home,
                        items: rsp.menu,
                        shortcuts: shortcuts
                    };

                    User.menu = login.menu;

                    User.login(login);

                    store.dispatch({
                        type: 'SET_LOGIN',
                        login: login
                    });
                }

                if (callback) callback();

                if (User.verifyListener) User.verifyListener();

            }, 'Verificando...');

        } else {

            //console.log('ya fue verificado hace', diff, 'segundos', User.verified_time);

        }

    }

}