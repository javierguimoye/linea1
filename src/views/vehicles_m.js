import React, {Component} from 'react';
import {
    Alert,
    Button, Col, FormGroup, Input, Modal, ModalBody, ModalFooter, ModalHeader,
    Row
} from 'reactstrap';
import {Api} from "../inc/api";
import {toast} from "react-toastify";
import Dropzone from "react-dropzone";

export default class VehiclesM extends Component {

    state = {
        item: {
            id: 0,
            brand: '',
            model: '',
            plate: ''
        },
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

    add = () => {
        this.setState({
            ...this.state,
            loading: false,
            modal: true,
            item: {
                id: 0,
                brand: '',
                model: '',
                plate: ''
            }
        });
    };

    edit = (id) => {
        this.setState({
            ...this.state,
            modal: true,
            loading: true,
            item: {
                id: 0,
                brand: '',
                model: '',
                plate: ''
            }
        });
        Api.get('/vehicles/dataForm', {id: id}, (rsp) => {
            if (rsp.ok) {
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

        Api.post('/vehicles/create', this.state.item, (rsp) => {

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
            Api.get('/vehicles/remove', {id: this.state.item.id}, (rsp) => {
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
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} vehículo
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>

                        <FormGroup row>
                            <Col md="4">Marca</Col>
                            <Col md="8">
                                <Input name="brand" value={this.state.item.brand} onChange={this.changed}/>
                            </Col>
                        </FormGroup>

                        <FormGroup row>
                            <Col md="4">Modelo</Col>
                            <Col md="8">
                                <Input name="model" value={this.state.item.model} onChange={this.changed}/>
                            </Col>
                        </FormGroup>

                        <FormGroup row>
                            <Col md="4">Placa</Col>
                            <Col md="8">
                                <Input name="plate" value={this.state.item.plate} onChange={this.changed}/>
                            </Col>
                        </FormGroup>

                        <FormGroup row>
                            <Col md="4">SOAT</Col>
                            <Col md="8">
                                <Input name="soat_date" type="date" value={this.state.item.soat_date} onChange={this.changed}/>
                            </Col>
                        </FormGroup>

                        <FormGroup row>
                            <Col md="4"/>
                            <Col md="8">

                                <a className="btn btn-outline-primary btn-sm mrg-b-10 bold" target="_blank"
                                   hidden={!this.state.item.soat_pic_url}
                                   href={this.state.item.soat_pic_url}>
                                    <i className="fa fa-file-o"/> Ver archivo <i className="fa fa-angle-right"/>
                                </a>

                                <Dropzone
                                    className="_dropzone"
                                    activeClassName="active"
                                    onDrop={(files) => {
                                        console.log('onDrop', files);
                                        this.setState({
                                            ...this.state,
                                            file_soat: files.length > 0 ? files[0] : null
                                        });
                                    }}
                                    multiple={false}>
                                    {this.state.file_soat == null
                                        ? ''
                                        : <div className="bold mrg-b-10">{this.state.file_soat.name}</div>}
                                    <span className="btn btn-outline-dark">Examinar...</span>
                                </Dropzone>

                            </Col>
                        </FormGroup>

                        <FormGroup row>
                            <Col md="4">Revisión técnica</Col>
                            <Col md="8">
                                <Input name="revision_date" type="date" value={this.state.item.revision_date} onChange={this.changed}/>
                            </Col>
                        </FormGroup>

                        <FormGroup row>
                            <Col md="4"/>
                            <Col md="8">

                                <a className="btn btn-outline-primary btn-sm mrg-b-10 bold" target="_blank"
                                   hidden={!this.state.item.revision_pic_url}
                                   href={this.state.item.revision_pic_url}>
                                    <i className="fa fa-file-o"/> Ver archivo <i className="fa fa-angle-right"/>
                                </a>

                                <Dropzone
                                    className="_dropzone"
                                    activeClassName="active"
                                    onDrop={(files) => {
                                        console.log('onDrop', files);
                                        this.setState({
                                            ...this.state,
                                            file_revision: files.length > 0 ? files[0] : null
                                        });
                                    }}
                                    multiple={false}>
                                    {this.state.file_revision == null
                                        ? ''
                                        : <div className="bold mrg-b-10">{this.state.file_revision.name}</div>}
                                    <span className="btn btn-outline-dark">Examinar...</span>
                                </Dropzone>

                            </Col>
                        </FormGroup>

                    </ModalBody>
                    <ModalFooter>
                        <Button color="danger" style={{marginRight: 'auto'}}
                                className={this.state.item.id > 0 ? '' : 'none'}
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