import React, {Component} from 'react';
import {
    Alert,
    Button, Col, Input, Modal, ModalBody, ModalFooter, ModalHeader,
    Row, Table
} from 'reactstrap';
import {Api} from "../inc/api";
import {toast} from "react-toastify";
import {User} from "../inc/user";

export default class RolesM extends Component {

    state = {
        item: {
            id: 0,
            id_module: 0,
            name: '',
            roles: []
        },
        modules: [],
        all_see: false,
        all_edit: false,
        loading: false,
        error: null,
        modal: false,
    };

    toggle = () => {
        this.setState({
            ...this.state,
            modal: !this.state.modal,
        });
    };

    add = () => this.edit(0);

    edit = (id) => {
        this.setState({
            ...this.state,
            modal: true,
            loading: true,
            modules: [],
            item: {
                id: 0,
                id_module: 0,
                name: '',
                roles: []
            }
        });
        Api.get('/roles/dataForm', {id: id}, (rsp) => {
            if (rsp.ok) {

                let all_see = true;
                let all_edit = true;

                rsp.modules.map((o) => {
                    if (!o.see) all_see = false;
                    if (!o.edit) all_edit = false;
                });

                this.setState({
                    loading: false,
                    item: rsp.item ? rsp.item : this.state.item,
                    modules: rsp.modules,
                    all_see: all_see,
                    all_edit: all_edit
                });
            } else {
                this.setState({
                    ...this.state,
                    loading: false,
                    error: rsp.msg
                });
            }
        });
    };

    save = (e) => {
        e.preventDefault();
        this.setState({
            ...this.state,
            loading: true,
            error: null
        });

        this.state.item.perms = [];

        this.state.modules.map((o) => {
            if (o.see || o.edit || o.shortcut) {
                this.state.item.perms.push({
                    id_module: o.id,
                    see: o.see ? 1 : 0,
                    edit: o.edit ? 1 : 0,
                    shortcut: o.shortcut ? 1 : 0
                });
            }
        });

        Api.post('/roles/create', this.state.item, (rsp) => {

            if (rsp.ok) {
                toast.success('Guardado correctamente');
                this.toggle();
                if (typeof this.props.callback === 'function') this.props.callback();

                if (User.id_role == rsp.id) User.verify();

            } else {
                this.setState({
                    ...this.state,
                    loading: false,
                    error: rsp.msg
                });
            }

        });
    };

    remove = () => {
        if (window.confirm('¿Seguro que quieres borrar?')) {
            this.setState({
                ...this.state,
                loading: true,
                error: null
            });
            Api.get('/roles/remove', {id: this.state.item.id}, (rsp) => {
                if (rsp.ok) {
                    toast.success('Eliminado correctamente');
                    this.toggle();
                    if (typeof this.props.callback === 'function') this.props.callback();
                } else {
                    toast.error('Se produjo un error');
                }
            }, 'Eliminando...')
        }
    };

    changed = (e) => {
        const target = e.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;

        this.setState({
            ...this.state,
            item: {
                ...this.state.item,
                [name]: value
            }
        });
    };

    render() {
        const {item} = this.state;
        return (
            <Modal isOpen={this.state.modal} className={this.props.className} backdrop="static" keyboard={false}>
                <fieldset disabled={this.state.loading}>
                    <ModalHeader toggle={this.toggle}>
                        {item.id > 0 ? 'Editar' : 'Agregar'} perfil de acceso
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>

                        <Row className="form-group">
                            <Col md="3">Nombre</Col>
                            <Col md="9">
                                <Input name="name" value={item.name} onChange={this.changed}/>
                            </Col>
                        </Row>

                        <Table bordered className="mrg-0 _tbl">
                            <thead>
                            <tr>
                                <th rowSpan="2">Modulo</th>
                                <th width="1%">Leer</th>
                                <th width="1%">Editar</th>
                                <th rowSpan="2" width="1%"><i className="fa fa-home"/></th>
                                <th rowSpan="2" width="1%"><i className="fa fa-hand-o-up"/></th>
                            </tr>
                            <tr>
                                <th width="1%" className="ctr">
                                    <input type="checkbox" checked={this.state.all_see} onChange={(e) => {
                                        this.state.all_see = e.target.checked;
                                        this.state.modules.map((o) => {
                                            o.see = this.state.all_see;
                                        });
                                        this.setState(this.state);
                                    }}/>
                                </th>
                                <th width="1%" className="ctr">
                                    <input type="checkbox" checked={this.state.all_edit} onChange={(e) => {
                                        this.state.all_edit = e.target.checked;
                                        this.state.modules.map((o) => {
                                            o.edit = this.state.all_edit;
                                        });
                                        this.setState(this.state);
                                    }}/>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            {this.state.modules.map((o, i) =>
                                <tr key={i} style={{
                                    background: o.level === '0' ? '#F9F9F9' : '#FFFFFF'
                                }}>
                                    <td>
                                        {'\u00A0\u00A0'.repeat(o.level)}
                                        <i className={o.icon}/> {o.name}
                                    </td>
                                    <td className="ctr">
                                        <input type="checkbox" checked={o.see} onChange={(e) => {
                                            o.see = e.target.checked;

                                            if (o.level === '0') {
                                                this.state.modules.map((p) => {
                                                    if (p.id_parent == o.id) {
                                                        p.see = o.see;
                                                    }
                                                });
                                            } else if (o.see) {
                                                this.state.modules.map((p) => {
                                                    if (p.id == o.id_parent) {
                                                        p.see = true;
                                                    }
                                                });
                                            }

                                            this.setState(this.state);
                                        }}/>
                                    </td>
                                    <td className="ctr">
                                        <input type="checkbox" checked={o.edit} onChange={(e) => {
                                            o.edit = e.target.checked;

                                            if (o.level === '0') {
                                                this.state.modules.map((p) => {
                                                    if (p.id_parent == o.id) {
                                                        p.edit = o.edit;
                                                    }
                                                });
                                            } else if (o.edit) {
                                                this.state.modules.map((p) => {
                                                    if (p.id == o.id_parent) {
                                                        p.edit = true;
                                                    }
                                                });
                                            }

                                            this.setState(this.state);
                                        }}/>
                                    </td>
                                    <td className="ctr">
                                        <input type="radio" checked={item.id_module == o.id}
                                               hidden={o.url === ''}
                                               onChange={() => {
                                                   item.id_module = o.id;
                                                   this.setState(this.state);
                                               }}/>
                                    </td>
                                    <td className="ctr">
                                        <input type="checkbox" checked={o.shortcut}
                                               hidden={o.url === ''}
                                               onChange={(e) => {
                                                   o.shortcut = e.target.checked;
                                                   this.setState(this.state);
                                               }}/>
                                    </td>
                                </tr>
                            )}
                            </tbody>
                        </Table>

                    </ModalBody>
                    <ModalFooter>
                        <Button color="danger" style={{marginRight: 'auto'}}
                                className={item.id > 0 ? '' : 'none'}
                                outline onClick={this.remove}>
                            Eliminar
                        </Button>
                        <Button color="secondary" outline onClick={this.toggle}>
                            Cancelar
                        </Button>
                        <Button color="primary" onClick={this.save}>
                            <i className="fa fa-check"/> Guardar
                        </Button>
                    </ModalFooter>
                </fieldset>
            </Modal>
        );
    }
}