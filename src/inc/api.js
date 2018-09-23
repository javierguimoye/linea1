import axios from "axios";
import {User} from "./../inc/user";
import Util from "./utils";

export class Api {

    static URL_BASE = process.env.NODE_ENV === 'production'
        ? 'http://beta.focusit.pe/linea-1/api'
        : 'http://67be3659.ngrok.io/linea1-api';
      
    static get(url, data, callback, loading, cache) {

        //console.log("URL_BASE", Api.URL_BASE);

        if (typeof data === 'function') {
            cache = loading;
            loading = callback;
            callback = data;
            data = {};
        }

        cache = !(typeof cache === 'undefined') && cache;

        if (typeof loading === 'undefined') {
            loading = true;
            Util.loading(true);
        } else if (loading) {
            Util.loading(loading);
        }

        Api.getAxios().get(url, {params: data})
            .then(function (response) {

                let data = response.data;

                if (loading) Util.loading(false);
                if (callback) callback(data);

            })
            .catch(function (error) {
                if (loading) Util.loading(false);
                if (callback) callback({ok: false, msg: error.toString()});
            });
    }

    static post(url, data, callback, loading, cache) {

        if (typeof data === 'function') {
            cache = loading;
            loading = callback;
            callback = data;
            data = {};
        }

        cache = !(typeof cache === 'undefined') && cache;

        if (typeof loading === 'undefined') {
            loading = true;
            Util.loading(true);
        } else if (loading) {
            Util.loading(loading);
        }

        Api.getAxios().post(url, data)
            .then(function (response) {

                let data = response.data;

                if (loading) Util.loading(false);
                if (callback) callback(data);

            })
            .catch(function (error) {
                if (loading) Util.loading(false);
                if (callback) callback({ok: false, msg: error.toString()});
            });
    }

    static getAxios() {
        return axios.create({
            baseURL: Api.URL_BASE,
            headers: {'Authorization': 'Bearer ' + User.token}
        });
    }

}

/*
export const api = (url, data, callback, loading, cache) => {
    if (typeof data === 'function') {
        cache = loading;
        loading = callback;
        callback = data;
        data = {};
    }

    cache = !(typeof cache === 'undefined') && cache;

    // Solo si guarda cache agrega parametros get en url, para evitar url larga
    if (cache && !$.isEmptyObject(data)) url += '?' + $.param(data);

    if (cache && Cache.exist(url)) {
        console.warn("API:cache: ", url);
        if (loading) Loading.hide();
        if (callback) callback(Cache.get(url));
    } else {
        console.log('API:url: ', url);
        if (typeof loading === 'undefined') {
            loading = true;
            Loading.show();
        } else if (loading) {
            Loading.show(loading);
        }
        $.post(url, data, function (rsp) {
            /!*if(cache)*!/
            Cache.set(url, rsp);//actualizamos cache incluso si no lo pidio

            if (loading) Loading.hide();
            if (callback) callback(rsp);

            //console.log(this);
        }, 'JSON')
            .fail(function () {
                if (loading) Loading.hide();
                if (callback) {
                    callback({
                        ok: false,
                        msg: 'Se produjo un error, por favor vuelve a intentarlo.'
                    });
                }
            });
    }
};*/
