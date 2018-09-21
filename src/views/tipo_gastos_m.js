import React, {Component} from 'react';
import {
    Alert, Button, Col, Input, Modal, ModalBody, ModalFooter, ModalHeader, Row
} from 'reactstrap';
import {Api} from "../inc/api";
import {toast} from "react-toastify";

export default class Tipo_gastosM extends Component {

    state = {
        item: {
            id: 0,
            nombre: '',
            descripcion: '',
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
                nombre: '',
                descripcion: '',
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
                nombre: '',
                descripcion: '',
            }
        });
        Api.get('/tipo_gastos/dataForm', {id: id}, (rsp) => {
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

        Api.post('/tipo_gastos/create', this.state.item, (rsp) => {

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
            Api.get('/tipo_gastos/remove', {id: this.state.item.id}, (rsp) => {
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
        
        if(target.maxLength!=-1){
            if(value.length<=target.maxLength){
                this.setState({
                    ...this.state,
                    item: {
                        ...this.state.item,
                        [name]: value
                    }
                });
            }
        }else{
            this.setState({
                ...this.state,
                item: {
                    ...this.state.item,
                    [name]: value
                }
            });
        }
       
        /*
        this.setState({
            ...this.state,
            item: {
                ...this.state.item,
                [name]: value
            }
        });
        */
    };

    render() {
        return (
            <Modal isOpen={this.state.modal} className={this.props.className} backdrop="static" keyboard={false}>
                <fieldset disabled={this.state.loading}>
                    <ModalHeader toggle={this.toggle}>
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} Tipo de Gasto
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>

                        <Row className="form-group">
                            <Col md="4">Nombre</Col>
                            <Col md="8">
                                <Input name="nombre" value={this.state.item.nombre} onChange={this.changed} maxLength='5'/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Descripcion</Col>
                            <Col md="8">
                                <Input name="descripcion" value={this.state.item.descripcion} onChange={this.changed}/>
                            </Col>
                        </Row>
                
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