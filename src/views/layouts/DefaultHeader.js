import React, {Component} from 'react';
import {DropdownItem, DropdownMenu, DropdownToggle, Nav, NavItem, NavLink} from 'reactstrap';

import {AppHeaderDropdown, AppNavbarBrand, AppSidebarToggler} from '@coreui/react';
import {User} from "../../inc/user";

import menu from '../../inc/_nav';

class DefaultHeader extends Component {

    logout = () => {
        User.logout();
        window.location.href = './';
    };

    render() {

        //const logo = './img/logo.jpg';

        return (
            <React.Fragment>
                <AppSidebarToggler className="d-lg-none" display="md" mobile/>
              { /* <AppNavbarBrand
                    full={{src: logo, width: 34, height: 34, alt: 'Logo'}}
                    minimized={{src: logo, width: 30, height: 30, alt: 'Logo'}}/>
                <AppSidebarToggler className="d-md-down-none" display="lg"/>
              */}
                <Nav className="d-md-down-none" navbar>
                    {
                        User.menu.shortcuts.map((o, i) => (
                            <NavItem className="pl-3" key={i}>
                                <NavLink href={"#" + o.url}>
                                    <i className={o.icon == '' ? 'fa fa-star' : o.icon}/> {o.name}
                                </NavLink>
                            </NavItem>
                        ))
                    }
                </Nav>
                <Nav className="ml-auto" navbar>
                    <AppHeaderDropdown direction="down">
                        <DropdownToggle nav>
                            <img src={'img/user.png'}
                                 alt=""
                                 className="img-avatar"/>
                            Hola, {User._name}
                            <i className="fa fa-angle-down" style={{fontSize: 20, marginLeft: 10, marginRight: 10}}/>
                        </DropdownToggle>
                        <DropdownMenu>
                            <DropdownItem disabled>
                                {User._name} {User.surname}
                            </DropdownItem>
                            <DropdownItem header>Cuenta</DropdownItem>
                            <DropdownItem disabled>
                                <i className="fa fa-user"/> Mi cuenta
                            </DropdownItem>
                            <DropdownItem onClick={() => {
                                window.location.href = "mailto:soporte@focusit.pe"
                            }}>
                                <i className="fa fa-support"/> Soporte
                            </DropdownItem>
                            <DropdownItem onClick={this.logout}>
                                <i className="fa fa-power-off"/> Cerrar sesión
                            </DropdownItem>
                        </DropdownMenu>
                    </AppHeaderDropdown>
                </Nav>
            </React.Fragment>
        );
    }
}

export default DefaultHeader;
