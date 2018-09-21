import React, {Component} from 'react';
import {
    Alert, Button, Col, Input, Modal, ModalBody, ModalFooter, ModalHeader, Row,Label,FormGroup,Table
} from 'reactstrap';
import {Api} from "../inc/api";
import {toast} from "react-toastify";
import Select from 'react-select'

export default class ProveedoresM extends Component {

    state = {
        item: {
            id: 0,
            proveedor: '',
            ruc: '',
            concepto: '',
            tipo_gastos: [],
        },
        tipo_gastos: [],
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
                proveedor: '',
                ruc: '',
                concepto: '',
            }
        });
    };*/
    add = () => this.edit(0);

    edit = (id) => {
        this.setState({
            ...this.state,
            modal: true,
            loading: true,
            currentOption:  null,
            item: {
                id: 0,
                proveedor: '',
                ruc: '',
                concepto: '',
                tipo_gastos: [],
            },
            tipo_gastos: []
        });
        Api.get('/proveedores/dataForm', {id: id}, (rsp) => {
            if (rsp.ok) {
                let optionsClientes = [];
                rsp.tipo_gastos.map((o) => optionsClientes.push({
                    value: o.id,
                    label: o.nombre
                }));

                this.setState({
                    loading: false,
                    item: rsp.item ? rsp.item : this.state.item,
                    tipo_gastos: optionsClientes,
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

        let data = this.state.item;
        data.ids_tipos = [];
        this.state.item.tipo_gastos.map((o) => data.ids_tipos.push(o.id_tipo_gasto));

        Api.post('/proveedores/create', data, (rsp) => {

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
            Api.get('/proveedores/remove', {id: this.state.item.id}, (rsp) => {
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

        if(target.type=="number"){
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
    };
    handleSelectOption = (selectedOption) => {
       // this.state.item.id_chofer=selectedOption.value;
        this.setState({ currentOption:  selectedOption });
        //  this.addToArray(selectedOption);
      }
    render() {
        return (
            <Modal isOpen={this.state.modal} className={this.props.className} backdrop="static" keyboard={false} size="lg">
                <fieldset disabled={this.state.loading}>
                    <ModalHeader toggle={this.toggle}>
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} Proveedor
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>
                        <Row>

                            <Col md="6">
                            <Row className="form-group">
                            <Col md="4">Proveedor</Col>
                            <Col md="8">
                                <Input name="proveedor" value={this.state.item.proveedor} onChange={this.changed}/>
                            </Col>
                        </Row>

                    <Row className="form-group">
                            <Col md="4">RUC</Col>
                            <Col md="8">
                                <Input type="number" maxLength='12' name="ruc" value={this.state.item.ruc} onChange={this.changed}/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">concepto</Col>
                            <Col md="8">
                                <Input name="concepto" value={this.state.item.concepto} onChange={this.changed}/>
                            </Col>
                        </Row>
                
                            </Col>
                            
                            <Col md="6">
                            
        <FormGroup>
            <Label className="bold">Tipo de Gastos</Label>
                <Select
                name="id_cliente"
                options={this.state.tipo_gastos}
                placeholder="Buscar..."
                onChange={(o) => {
                    var exist = false;
                    this.state.item.tipo_gastos.map((cp) => {
                        if (cp.id_tipo_gasto == o.value) {
                            exist = true;
                        }
                    });

                    if (!exist) {
                        this.state.item.tipo_gastos.push({
                            id_tipo_gasto: o.value,
                            nombre:  o.label
                        });
                        this.setState(this.state);
                    }

                }}/>
        </FormGroup>

    

                  <FormGroup>
                                    <Table bordered responsive className="mdl-td _tbl">
                                        <thead>
                                        <tr>
                                            <th width="1%">#</th>
                                            <th>Nombre</th>
                                            <th width="1%"/>
                                        </tr>
                                        </thead>
                                        <tbody>
                                         
                                        {this.state.item.tipo_gastos.map((o, i) => (
                                          
                                            <tr key={i}>
                                                <td>{o.id_tipo_gasto}</td>
                                                <td>{o.nombre}</td>
                                                <td>
                                                    <Button size="sm" onClick={() => {
                                                        this.state.item.tipo_gastos.splice(i, 1);
                                                        this.setState(this.state);
                                                    }}>
                                                        <i className="fa fa-times"/>
                                                    </Button>
                                                </td>
                                            </tr>
                                        )) }
                                        </tbody>
                                    </Table>
                    </FormGroup>


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