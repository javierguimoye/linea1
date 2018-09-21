import React, {Component} from 'react';
import {
    Alert, Button, Col, Input, Modal, ModalBody, ModalFooter, ModalHeader, Row
} from 'reactstrap';
import {Api} from "../inc/api";
import {toast} from "react-toastify";

export default class UsersM extends Component {

    state = {
        item: {
            id: 0,
            id_role: 0,
         //   id_management: 0,
            name: '',
            surname: '',
            username: '',
            password: ''
        },
        roles: [],
     //   managements: [],
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
            item: {
                id: 0,
                id_role: 0,
              //  id_management: 0,
                name: '',
                surname: '',
                username: '',
                password: ''
            },
        });
        Api.get('/users/dataForm', {id: id}, (rsp) => {
            if (rsp.ok) {
                this.setState({
                    loading: false,
                    item: rsp.item ? {
                        ...rsp.item,
                        password: ''
                    } : this.state.item,
                    roles: rsp.roles,
                    managements: rsp.managements
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

        Api.post('/users/create', this.state.item, (rsp) => {

            if (rsp.ok) {
                toast.success('Guardado correctamente');
                this.toggle();
                if (typeof this.props.callback === 'function') this.props.callback();
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
            Api.get('/users/remove', {id: this.state.item.id}, (rsp) => {
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
        return (
            <Modal isOpen={this.state.modal} className={this.props.className} backdrop="static" keyboard={false}>
                <fieldset disabled={this.state.loading}>
                    <ModalHeader toggle={this.toggle}>
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} usuario
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>

                        <Row className="form-group">
                            <Col md="4">Perfil</Col>
                            <Col md="8">
                                <select className="form-control" name="id_role" value={this.state.item.id_role}
                                        onChange={this.changed}>
                                    <option value="">Elegir...</option>
                                    {this.state.roles.map((o, i) =>
                                        <option value={o.id} key={i}>{o.name}</option>
                                    )}
                                </select>
                            </Col>
                        </Row>

                    

                        <Row className="form-group">
                            <Col md="4">Nombre</Col>
                            <Col md="8">
                                <Input name="name" value={this.state.item.name} onChange={this.changed}/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Apellido</Col>
                            <Col md="8">
                                <Input name="surname" value={this.state.item.surname} onChange={this.changed}/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Usuario</Col>
                            <Col md="8">
                                <input className="form-control" name="username" value={this.state.item.username}
                                       readOnly={this.state.item.username === 'root'}
                                       onChange={this.changed}/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Contraseña</Col>
                            <Col md="8">
                                <input className="form-control" name="password" value={this.state.item.password}
                                       onChange={this.changed} type="password"/>
                            </Col>
                        </Row>

                    </ModalBody>
                    <ModalFooter>
                        <Button color="danger" style={{marginRight: 'auto'}}
                                className={this.state.item.id > 0 ? '' : 'none'}
                                hidden={this.state.item.id <= 0 || this.state.item.username === 'root'}
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