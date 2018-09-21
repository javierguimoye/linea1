import './inc/polyfill'
import React from 'react';
import ReactDOM from 'react-dom';
import {HashRouter, Redirect, Route} from "react-router-dom";
import Switch from "react-router-dom/es/Switch";

//import '@coreui/icons/css/coreui-icons.min.css';
import 'font-awesome/css/font-awesome.min.css';
//import 'simple-line-icons/css/simple-line-icons.css';
import './scss/style.css'
import DefaultLayout from "./views/layouts/DefaultLayout";
import registerServiceWorker from "./inc/registerServiceWorker";
import Login from "./views/auth/Login";
import {User} from "./inc/user";
import store from "./inc/store";
import {Provider} from "react-redux";

User.init();

ReactDOM.render((
    <Provider store={store}>
        <HashRouter>
            <Switch>
                <Route path="/login" component={Login}/>
                {
                    User.logged() ? <Route path="/" component={DefaultLayout}/> : <Redirect to="./login"/>
                }
            </Switch>
        </HashRouter>
    </Provider>
), document.getElementById('root'));

registerServiceWorker();