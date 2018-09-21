import React, {Component} from 'react';
import {
    Alert, Button, Col, Input, Modal, ModalBody, ModalFooter, ModalHeader, Row,Label,FormGroup,Table
} from 'reactstrap';
import Select from 'react-select'
import {Api} from "../inc/api";
import {toast} from "react-toastify";
let nViatico=0;
let nMovilidad=0;
let nHotel=0;
let nCochera=0;
let ntotal=0;
let valooor;
let labeeel;
export default class RutasM extends Component {

    state = {
        item: {
            id: 0,
            id_tipo_unidad: '',
            id_chofer: '',
            nombre: '',
            distancia: '',
            viatico: '',
            movilidad: '',
            hotel: '',
            cochera: '',
            total_dia: '',
            clientes: [],
        },
        tipo_unidad: [],
        choferes: [],
        clientes: [],
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
            currentOption:  null,
            item: {
                id: 0,
                id_tipo_unidad: '',
                id_chofer: '',
                nombre: '',
                distancia: '',
                viatico: '',
                movilidad: '',
                hotel: '',
                cochera: '',
                total_dia: '',
                clientes: [],
            },
            tipo_unidad: [],
            choferes: [],
            clientes: [],
        });
        Api.get('/rutas/dataForm', {id: id}, (rsp) => {

                if (rsp.ok) {
                    //console.log(rsp.tipo_unidad);
                    let optionsChoferes = [];
                    let optionsClientes = [];
                   
    
                    rsp.choferes.map((o) => optionsChoferes.push({
                        value: o.id,
                        label: o.dni
                    }));
                    rsp.clientes.map((o) => optionsClientes.push({
                        value: o.id,
                        label: o.ruc,
                        nombre: o.nombre
                    }));
    
                 
                    for (var i in optionsChoferes) {
                        if (optionsChoferes.hasOwnProperty(i)) {
                           // console.log('opcioness '+rsp.item);
                            if(rsp.item!=null){
                              // console.log(optionsChoferes[i].value)
                               
                               if(optionsChoferes[i].value == rsp.item.id_chofer){
                                valooor=optionsChoferes[i].value;
                                labeeel=optionsChoferes[i].label;
                                  //  console.log(valooor+" objeto: "+ labeeel);
                                }
                              
                            }
                          
                        }
                    }
    
    
                    this.setState({
                        loading: false,
                        currentOption:  { value: valooor, label: labeeel },
                        item: rsp.item ? rsp.item : this.state.item,
                        choferes: optionsChoferes,
                        clientes: optionsClientes,
                        tipo_unidad:rsp.tipo_unidad
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
        data.ids_clients = [];
        this.state.item.clientes.map((o) => data.ids_clients.push(o.id_cliente));

        Api.post('/rutas/create', data, (rsp) => {

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
            Api.get('/rutas/remove', {id: this.state.item.id}, (rsp) => {
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
      
        if(name=='viatico'){
            nViatico=value;
            ntotal=parseFloat(nViatico)+parseFloat(nMovilidad)+parseFloat(nHotel)+parseFloat(nCochera);
        }else{
            if(name=='movilidad'){
                nMovilidad=value;
                ntotal=parseFloat(nViatico)+parseFloat(nMovilidad)+parseFloat(nHotel)+parseFloat(nCochera);
            }else{
                if(name=='hotel'){
                    nHotel=value;
                    ntotal=parseFloat(nViatico)+parseFloat(nMovilidad)+parseFloat(nHotel)+parseFloat(nCochera);
                }else{
                    if(name=='cochera'){
                        nCochera=value;
                        ntotal=parseFloat(nViatico)+parseFloat(nMovilidad)+parseFloat(nHotel)+parseFloat(nCochera);
                    }
                }
            }
        }

        this.setState({
            ...this.state,
            item: {
                ...this.state.item,
                [name]: value,
                total_dia: ntotal
            }
        });

    };

    handleSelectOption = (selectedOption) => {
        this.state.item.id_chofer=selectedOption.value;
        this.setState({ currentOption:  selectedOption });
        //  this.addToArray(selectedOption);
      }
   

    render() {
        const { currentOption } = this.state;
        return (
            <Modal isOpen={this.state.modal} className={this.props.className} backdrop="static" 
            keyboard={false} size="lg">
                <fieldset disabled={this.state.loading}>
                    <ModalHeader toggle={this.toggle}>
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} Ruta
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>

                <Row>
                <Col md="6">
                    <Row className="form-group">
                            <Col md="4">Tipo de Unidad</Col>
                            <Col md="8">
                                <select className="form-control" name="id_tipo_unidad" value={this.state.item.id_tipo_unidad}
                                    onChange={this.changed}>
                                    <option value="">Elegir...</option>
                                    {
                                        this.state.tipo_unidad.map((o, i) =>
                                        <option value={o.id} key={i}>{o.nombre}</option>
                                    )}
                                </select>
                                
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Nombre</Col>
                            <Col md="8">
                                <Input name="nombre" value={this.state.item.nombre} onChange={this.changed}/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Distancia</Col>
                            <Col md="8">
                                <Input name="distancia" value={this.state.item.distancia} onChange={this.changed}/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Viatico</Col>
                            <Col md="8">
                                <Input name="viatico" value={this.state.item.viatico} 
                                onChange={this.changed} type="number"/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Movilidad</Col>
                            <Col md="8">
                                <Input name="movilidad" value={this.state.item.movilidad} 
                                onChange={this.changed} type="number"/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Hotel</Col>
                            <Col md="8">
                                <Input name="hotel" value={this.state.item.hotel} 
                                onChange={this.changed} type="number"/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Cochera</Col>
                            <Col md="8">
                                <Input name="cochera" value={this.state.item.cochera} 
                                onChange={this.changed} type="number"/>
                            </Col>
                        </Row>
                
                        <Row className="form-group">
                            <Col md="4">Total del Dia</Col>
                            <Col md="8">
                                <Input name="total_dia" value={this.state.item.total_dia} 
                                onChange={this.changed} type="number" disabled/>
                            </Col>
                        </Row>

  </Col>

    <Col md="6">

        <Row className="form-group">
        
        <Col md="4">Choferes</Col>
            <Col md="8">
                <Select
                    name="id_chofer"
                    value={currentOption}
                    options={this.state.choferes}
                    placeholder="Buscar..."
                    onChange={this.handleSelectOption}
                    /*onChange={(o) => {
                        this.state.item.id_chofer=o.value;
                        this.setState(this.state);
                    }}
                    */
                   
                />
            </Col>                

        </Row>


        <FormGroup>
            <Label className="bold">Clientes</Label>
                <Select
                name="id_cliente"
                options={this.state.clientes}
                placeholder="Buscar..."
                onChange={(o) => {

                    var exist = false;
                        this.state.item.clientes.map((cp) => {
                            if (cp.id_cliente == o.value) {
                                exist = true;
                            }
                        });
    
                        if (!exist) {
                            this.state.item.clientes.push({
                                id_cliente: o.value,
                                nombre:  o.nombre
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
                                            {//console.log(this.state.item.clientes)
                                            }
                                        {this.state.item.clientes.map((o, i) => (
                                          
                                            <tr key={i}>
                                                <td>{o.id_cliente}</td>
                                                <td>{o.nombre}</td>
                                                <td>
                                                    <Button size="sm" onClick={() => {
                                                        this.state.item.clientes.splice(i, 1);
                                                        this.setState(this.state);
                                                    }}>
                                                        <i className="fa fa-times"/>
                                                    </Button>
                                                </td>
                                            </tr>
                                        )
                                        )}
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