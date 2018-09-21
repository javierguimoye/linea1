import moment from "moment";

const $loading = document.getElementById('loading');

export default class Util {

    static loading(show) {
        if (show) {

            if (typeof show === 'string') {
                $loading.innerHTML = show;
            } else {
                $loading.innerHTML = 'Cargando...';
            }
            $loading.style.display = 'block';

        } else {
            $loading.style.display = 'none';
        }

    }

    static time() {
        return parseInt(new Date().getTime() / 1000, 10);
    }

}


// protos

String.prototype.date = function () {
    return moment(this).format('DD/MM/Y');
};

String.prototype.datetime = function () {
    return moment(this).format('DD/MM/Y HH:mm A');
};