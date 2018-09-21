import React, {Component} from 'react';
import {
    Alert, Button, Col, Input, Modal, ModalBody, ModalFooter, ModalHeader, Row
} from 'reactstrap';
import {Api} from "../inc/api";
import {toast} from "react-toastify";

export default class UnidadesM extends Component {

    state = {
        item: {
            id: 0,
            id_tipo_movilidad: '',
            tracto_unidad: '',
            botella: '',
        },
        tipo_movilidad: [],
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
                id_tipo_movilidad: '',
                tracto_unidad: '',
                botella: '',
            }
        });
        Api.get('/unidades/dataForm', {id: id}, (rsp) => {
            if (rsp.ok) {
                this.setState({
                    loading: false,
                    item: rsp.item ? 
                    rsp.item : this.state.item,
                    tipo_movilidad: rsp.tipo_movilidad
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

        Api.post('/unidades/create', this.state.item, (rsp) => {

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
            Api.get('/unidades/remove', {id: this.state.item.id}, (rsp) => {
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
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} Unidad
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>
                                
                          <Row className="form-group">
                            <Col md="4">Movilidad</Col>
                            <Col md="8">
                               
                                <select className="form-control" name="id_tipo_movilidad" value={this.state.item.id_tipo_movilidad}
                                    onChange={this.changed}>
                                    <option value="">Elegir...</option>
                                    {
                                        this.state.tipo_movilidad.map((o, i) =>
                                        <option value={o.id} key={i}>{o.nombre}</option>
                                    )}
                                </select>
                                
                            </Col>
                        </Row>
                                

                    <Row className="form-group">
                            <Col md="4">Tracto/Unidad</Col>
                            <Col md="8">
                                <Input name="tracto_unidad" value={this.state.item.tracto_unidad} onChange={this.changed}/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Botella</Col>
                            <Col md="8">
                                <Input name="botella" value={this.state.item.botella} onChange={this.changed}/>
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