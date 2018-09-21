import React, {Component} from 'react';
import {
    Alert, Button, Col, Input, Modal, ModalBody, ModalFooter, ModalHeader, Row
} from 'reactstrap';
import {Api} from "../inc/api";
import {toast} from "react-toastify";
import Select from 'react-select'
let valooor;
let labeeel;
export default class ChoferesM extends Component {

    state = {
        currentOption:  null,
        item: {
            id: 0,
            id_unidad: '',
            placa:'',
            nombre: '',
            apellido: '',
            dni: '',
        },
        unidades: [],
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
        this.dataForm(0);
    };

    edit = (id) => this.dataForm(id);

    dataForm = (id) => {
        this.setState({
            ...this.state,
            modal: true,
            loading: true,
            currentOption:  null,
            item: {
                id: 0,
                id_unidad: '',
                placa:'',
                nombre: '',
                apellido: '',
                dni: '',
            },
            unidades: [],
            valores: [],
        });
        Api.get('/choferes/dataForm', {id: id}, (rsp) => {
            
            if (rsp.ok) {
                let options = [];
        
                rsp.unidades.map((o) => options.push({
                    value: o.id,
                    label: o.placa
                }));
           
                
                for (var i in options) {
                    if (options.hasOwnProperty(i)) {
                       // console.log('opcioness '+rsp.item);
                        if(rsp.item!=null){
                            if(options[i].value == rsp.item.id_unidad){
                                valooor=options[i].value;
                                labeeel=options[i].label;
                             
                            }
                        }
                      
                    }
                }

       //  console.log(valooor+" objeto: "+ labeeel);

                this.setState({
                    ...this.state,
                    loading: false,
                    currentOption:  { value: valooor, label: labeeel },
                    item: rsp.item ? rsp.item : this.state.item,
                    unidades: options
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
    /*
    edit = (id) => {
        this.setState({
            ...this.state,
            modal: true,
            loading: true,
            item: {
                id: 0,
                placa:'',
                id_unidad: '',
                nombre: '',
                apellido: '',
                dni: '',
            }
        });
        Api.get('/choferes/dataForm', {id: id}, (rsp) => {
            if (rsp.ok) {

                let options = [];

                rsp.unidades.map((o) => options.push({
                    value: o.id,
                    label: o.placa
                }));

                this.setState({
                    loading: false,
                    item: rsp.item ? rsp.item : this.state.item,
                    unidades: options
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
    */

    save = (e) => {
        e.preventDefault();
        this.setState({
            ...this.state,
            loading: true,
            error: null
        });

        Api.post('/choferes/create', this.state.item, (rsp) => {

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
            Api.get('/choferes/remove', {id: this.state.item.id}, (rsp) => {
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
        this.state.item.id_unidad=selectedOption.value;
        this.setState({ currentOption:  selectedOption });
      //  this.addToArray(selectedOption);
      }

    render() {
        const { currentOption } = this.state;
        return (
            <Modal isOpen={this.state.modal} className={this.props.className} backdrop="static" keyboard={false}>
                <fieldset disabled={this.state.loading}>
                    <ModalHeader toggle={this.toggle}>
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} Chofer
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>
                                <Row className="form-group">
                                    <Col md="4">Placa de Vehiculo</Col>
                                    <Col md="8">
                                    
                                        <Select
                                            name="id_unidad"
                                            value={currentOption}
                                            options={this.state.unidades}
                                            placeholder="Buscar..."
                                            onChange={this.handleSelectOption}
                                            /*onChange={(o) => {
                                                console.log(o.value);
                                                this.state.item.id_unidad=o.value;
                                               // this.setState(this.state);
                                                this.setState({ currentOption:  selectedOption });
               
                                        }}*/
                                        
                                        />

                                    </Col>
                                </Row>

                        <Row className="form-group">
                            <Col md="4">Nombre</Col>
                            <Col md="8">
                                <Input name="nombre" value={this.state.item.nombre} onChange={this.changed}/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Apellido</Col>
                            <Col md="8">
                                <Input name="apellido" value={this.state.item.apellido} onChange={this.changed}/>
                            </Col>
                        </Row>
                
                        <Row className="form-group">
                            <Col md="4">DNI</Col>
                            <Col md="8">
                                <Input type="number" maxLength='9' name="dni" value={this.state.item.dni} onChange={this.changed}/>
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