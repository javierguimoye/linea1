import React, {Component} from 'react';
import {DropdownItem, DropdownMenu, DropdownToggle, UncontrolledButtonDropdown} from "reactstrap";

export default class Dashboard extends Component {

    render() {
        return (
            <div>

                <UncontrolledButtonDropdown>
                    <DropdownToggle caret>
                        Opciones
                    </DropdownToggle>
                    <DropdownMenu>
                        <DropdownItem><i className="fa fa-pencil"/> Editar</DropdownItem>
                        <DropdownItem><i className="fa fa-trash"/> Eliminar</DropdownItem>
                    </DropdownMenu>
                </UncontrolledButtonDropdown>

            </div>
        );
    }
}