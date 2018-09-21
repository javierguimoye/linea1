import React, {Component} from 'react';
import {Redirect, Route, Switch} from 'react-router-dom';
import {Container} from 'reactstrap';
import 'react-toastify/dist/ReactToastify.css';

import {
    AppBreadcrumb,
    AppFooter,
    AppHeader,
    AppSidebar,
    AppSidebarFooter,
    AppSidebarForm,
    AppSidebarHeader,
    AppSidebarMinimizer,
    AppSidebarNav,
} from '@coreui/react';

import {User} from "../../inc/user";
import store from "../../inc/store";

import routes from '../../routes';
import DefaultFooter from './DefaultFooter';
import DefaultHeader from './DefaultHeader';
import {ToastContainer} from "react-toastify";

class DefaultLayout extends Component {

    state = {
        login: {},
        menu: User.menu
    };

    constructor() {
        super();

        store.subscribe((state) => {

        });
    }

    componentDidMount() {
        User.verifyListener = () => {
            this.setState({
                ...this.state,
                menu: User.menu
            });
            console.log('verifyListener.CALLED', User.id_role);
        };
        User.verify();
    }

    render() {
        return (
            <div className="app">
                <AppHeader fixed>
                    <DefaultHeader/>
                </AppHeader>
                <div className="app-body">
                    <AppSidebar fixed display="lg">
                        <AppSidebarHeader/>
                        <AppSidebarForm/>
                        <AppSidebarNav navConfig={this.state.menu} {...this.props} />
                        <AppSidebarFooter/>
                        <AppSidebarMinimizer/>
                    </AppSidebar>
                    <main className="main">
                        <AppBreadcrumb appRoutes={routes}/>
                        <Container fluid>
                            <Switch>
                                {routes.map((o, i) => <Route exact {...o} key={i}/>)}
                                <Redirect from="/" exact={true} to={User.menu.home}/>
                                <Redirect from="/" exact={false} to='/404'/>
                            </Switch>
                        </Container>
                    </main>
                </div>
                <AppFooter>
                    <DefaultFooter/>
                </AppFooter>

                <ToastContainer/>

            </div>
        );
    }
}

export default DefaultLayout;