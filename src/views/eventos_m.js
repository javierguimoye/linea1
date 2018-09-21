import React, { Component } from 'react';
import {
    Alert,
    Button, Col, Input, Modal, ModalBody, ModalFooter, ModalHeader,
    Row
} from 'reactstrap';

import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import { Api } from "../inc/api";
import { toast } from "react-toastify";
import Select from 'react-select'

const options = [
    { value: '1', label: 'Notificacion' },
    { value: '2', label: 'Email' },
];

export default class EventosM extends Component {

    state = {
        item: {
            id: 0,
            id_station: 0,
            direction: '',
            type: 0,
            name: '',
            date: '',
        },
        type_notifications: [],
        stations: [],
        messages: [],
        tabIndex: 0 ,
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
/*
    add = () => {
        this.setState({
            ...this.state,
            loading: false,
            modal: true,
            item: {
                id: 0,
                name: '',
                cost: ''
            }
        });
    };
*/
    add = () => {
      this.dataForm(0);
    };

    edit = (id) => this.dataForm(id);

    dataForm = (id) => {

        this.setState({
            ...this.state,
            modal: true,
            loading: true,
            currentOption:  null,
            currentOption2:  null,
            item: {
                id: 0,
                id_station: 0,
                direction: '',
                type: 0,
                name: '',
                date: '',
            },
            type_notifications: [],
            stations: [],
            messages: [],
        });
        Api.get('/events/dataForm', { id: id }, (rsp) => {
            //     Api.get('/compekits/dataForm', {id: id}, (rsp) => {
            if (rsp.ok) {

                let options = [];
                let options2 = [];
                rsp.type_notifications.map((o) => options.push({
                    value: o.id,
                    label: o.placa
                }));

                this.setState({
                    loading: false,
                    item: rsp.item ? rsp.item : this.state.item,
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

        Api.post('/events/create', this.state.item, (rsp) => {

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
            Api.get('/events/remove', { id: this.state.item.id }, (rsp) => {
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
/*
        const title = this.state.post.map((x) => {
            return (<Tab key={x.id}> {x.title} </Tab>)
        });
        const text = this.state.post.map((x) => {
            return (<TabPanel key={x.id}> {x.title} </TabPanel>)
        });

        const displayPosts = (

            <Tabs defaultIndex={1} onSelect={index => console.log(index)}>
                <TabList>
                    {title};
                </TabList>

                {text};
            </Tabs>
        );
        */
        return (
            <Modal isOpen={this.state.modal} className={this.props.className} backdrop="static" keyboard={false} 
            size="lg">
                <fieldset disabled={this.state.loading}>
                    <ModalHeader toggle={this.toggle}>
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} Eventos
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>



                        <Row className="form-group">
                            <Col md="4">Estacion</Col>
                            <Col md="8">


                                <Select
                                    name="id_cliente"
                                    options={options}
                                    onChange={this.handleSelectOption}
                                    placeholder="Buscar..."
                                />
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Opcion de envio </Col>
                            <Col md="8">


                                <Select
                                    name="id_cliente"
                                    options={options}
                                    onChange={this.handleSelectOption}
                                    placeholder="Buscar..."
                                />
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Titulo</Col>
                            <Col md="8">
                                <Input name="name" value={this.state.item.name} onChange={this.changed} />
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Mensaje</Col>
                            <Col md="8">
                                <Input name="cost" value={this.state.item.cost} onChange={this.changed}
                                    type="number" />
                            </Col>
                        </Row>


                    </ModalBody>
                    <ModalFooter>
                        <Button color="danger" style={{ marginRight: 'auto' }}
                            className={this.state.item.id > 0 ? '' : 'none'}
                            outline onClick={this.remove}>
                            Eliminar
                        </Button>
                        <Button color="secondary" outline onClick={this.toggle}>
                            Cancelar
                        </Button>
                        <Button color="primary" onClick={this.save}>
                            <i className="fa fa-check" /> Guardar
                        </Button>
                    </ModalFooter>
                </fieldset>
            </Modal>
        );
    }
}