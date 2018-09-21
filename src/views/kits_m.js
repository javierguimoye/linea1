import React, {Component} from 'react';
import {
    Alert, Table, Button, Col, Input, Modal, ModalBody, ModalFooter, ModalHeader, Row, FormGroup, Label
} from 'reactstrap';
import {Api} from "../inc/api";
import {toast} from "react-toastify";
import Select from 'react-select'
import Dropzone from "react-dropzone";

export default class KitsM extends Component {

    state = {
        item: {
            id: 0,
            id_compekit: 0,
            id_management: 0,
            name: '',
            serie: '',
            brand: '',
            model: '',
            dua: '',
            date_maintenance: '',
            date_reviewed: '',
            reviewed_pic_url: '',
            project_name: '',
            project_date: '',
            soat_date: '',
            soat_pic_url: '',
            revision_date: '',
            revision_pic_url: '',
            compekits: [],
            items: [],
            project_logs: []
        },
        compekits: [],
        managements: [],
        loading: false,
        error: null,
        modal: false,
        management_selected: {},
        compekit_selected: null,
        file_reviewed: null
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
            item: {
                id: 0,
                id_compekit: 0,
                id_management: 0,
                name: '',
                serie: '',
                brand: '',
                model: '',
                dua: '',
                date_maintenance: '',
                date_reviewed: '',
                reviewed_pic_url: '',
                project_name: '',
                project_date: '',
                soat_date: '',
                soat_pic_url: '',
                revision_date: '',
                revision_pic_url: '',
                compekits: [],
                items: [],
                project_logs: []
            },
            management_selected: {},
            compekit_selected: null,
            file_reviewed: null,
            file_soat: null,
            file_revision: null,
        });
        Api.get('/kits/dataForm', {id: id}, (rsp) => {
            
            if (rsp.ok) {

                let options = [];

                let item = rsp.item ? rsp.item : this.state.item;

                let management_selected = {value: '', label: 'Almacén central'};
                let compekit_selected = null;

                let _compekits = [];
                rsp.compekits.map((o) => {

                    let _o = {value: o.id, label: o.name};

                    _compekits.push(_o);

                    if (o.id == item.id_compekit) {
                        compekit_selected = _o;
                    }

                });

                let _managements = [];
                _managements.push(management_selected);
                rsp.managements.map((o) => {

                    let _mng_itm = {
                        value: o.id,
                        label: o.name
                    };
                    _managements.push(_mng_itm);

                    if (o.id == item.id_management) {
                        management_selected = _mng_itm;
                    }

                });

                this.setState({
                    loading: false,
                    item: item,
                    compekits: _compekits,
                    managements: _managements,
                    management_selected: management_selected,
                    compekit_selected: compekit_selected
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

        let item = this.state.item;
        item.ids_compekits = [];
        this.state.item.compekits.map((o) => item.ids_compekits.push(o.id));

        const data = new FormData();
        data.append('file_reviewed', this.state.file_reviewed);
        data.append('file_soat', this.state.file_soat);
        data.append('file_revision', this.state.file_revision);
        data.append('id_management', this.state.management_selected.value);
        Object.keys(item).map(key => data.append(key, item[key]));

        Api.post('/kits/create', data, (rsp) => {

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
            Api.get('/kits/remove', {id: this.state.item.id}, (rsp) => {
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

    removeKitItem = (o, i) => {
        if (o.id > 0) {
            if (window.confirm('¿Estás seguro que quieres eliminar esto?')) {

                this.setState({
                    ...this.state,
                    loading: true
                });
                Api.get('/kits/removeItem', {id: o.id}, (rsp) => {
                    this.setState({
                        ...this.state,
                        loading: false
                    });
                    if (rsp.ok) {
                        toast.success('Eliminado');
                        this.state.item.items.splice(i, 1);
                        this.setState(this.state);
                    } else {
                        toast.error('Error al eliminar');
                    }
                }, 'Eliminando...');

            }
        } else {
            this.state.item.items.splice(i, 1);
            this.setState(this.state);
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
            <Modal isOpen={this.state.modal} className="_frm" backdrop="static" keyboard={false}
                   size="lg">
                <fieldset disabled={this.state.loading}>
                    <ModalHeader toggle={this.toggle}>
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} equipo
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>

                        <Row>
                            <Col md="6">

                                <FormGroup className="bold">SOAT </FormGroup>

                                <FormGroup row>
                                    <Col md={4}>Fecha de venc.</Col>
                                    <Col md={8}>
                                        <Input name="soat_date" type="date" onChange={this.changed}
                                               value={this.state.item.soat_date}/>
                                    </Col>
                                </FormGroup>

                                <FormGroup row>
                                    <Col md={4}>Archivo</Col>
                                    <Col md={8}>

                                        <a className="btn btn-outline-primary btn-block btn-sm mrg-b-10 bold"
                                           target="_blank"
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

                                <FormGroup className="bold">Revisión técnica</FormGroup>

                                <FormGroup row>
                                    <Col md={4}>Fecha de venc.</Col>
                                    <Col md={8}>
                                        <Input name="revision_date" type="date" onChange={this.changed}
                                               value={this.state.item.revision_date}/>
                                    </Col>
                                </FormGroup>

                                <FormGroup row>
                                    <Col md={4}>Archivo</Col>
                                    <Col md={8}>

                                        <a className="btn btn-outline-primary btn-block btn-sm mrg-b-10 bold"
                                           target="_blank"
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

                                <FormGroup>
                                    <Label>Serie</Label>
                                    <Input name="serie" value={this.state.item.serie} onChange={this.changed}/>
                                </FormGroup>

                                <FormGroup>
                                    <Label>Nombre</Label>
                                    <Input name="name" value={this.state.item.name} onChange={this.changed}/>
                                </FormGroup>

                                <FormGroup>
                                    <Label>Marca</Label>
                                    <Input name="brand" value={this.state.item.brand} onChange={this.changed}/>
                                </FormGroup>

                                <FormGroup>
                                    <Label>Modelo</Label>
                                    <Input name="model" value={this.state.item.model} onChange={this.changed}/>
                                </FormGroup>

                                <FormGroup>
                                    <Label>DUA</Label>
                                    <Input name="dua" value={this.state.item.dua} onChange={this.changed}/>
                                </FormGroup>

                                <FormGroup>
                                    <Label>Fecha de mantenimiento</Label>
                                    <Input name="date_maintenance" type="date" value={this.state.item.date_maintenance}
                                           onChange={this.changed}/>
                                </FormGroup>

                                <FormGroup>
                                    <Label>Fecha de calibración</Label>
                                    <Input name="date_reviewed" type="date" value={this.state.item.date_reviewed}
                                           onChange={this.changed}/>
                                </FormGroup>

                                <FormGroup>

                                    <a className="btn btn-outline-primary btn-sm mrg-b-10 bold" target="_blank"
                                       hidden={!this.state.item.reviewed_pic_url}
                                       href={this.state.item.reviewed_pic_url}>
                                        <i className="fa fa-file-o"/> Ver archivo <i className="fa fa-angle-right"/>
                                    </a>

                                    <Dropzone
                                        className="_dropzone"
                                        activeClassName="active"
                                        onDrop={(files) => {
                                            console.log('onDrop', files);
                                            this.setState({
                                                ...this.state,
                                                file_reviewed: files.length > 0 ? files[0] : null
                                            });
                                        }}
                                        multiple={false}>
                                        {this.state.file_reviewed == null
                                            ? ''
                                            : <div className="bold mrg-b-10">{this.state.file_reviewed.name}</div>}
                                        <span className="btn btn-outline-dark">Examinar...</span>
                                    </Dropzone>

                                </FormGroup>

                                <FormGroup>
                                    <Label>Proyecto</Label>
                                    <Input name="project_name" value={this.state.item.project_name}
                                           onChange={this.changed}/>
                                </FormGroup>

                                <FormGroup>
                                    <Label>Fecha de proyecto</Label>
                                    <Input name="project_date" type="date" value={this.state.item.project_date}
                                           onChange={this.changed}/>
                                </FormGroup>
                                <FormGroup>
                                    <Label>Historial de proyectos</Label>
                                    <div className="_tbl_croll_v">
                                        <Table bordered responsive className="mdl-td _tbl">
                                            <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th width="1%">Fecha</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {this.state.item.project_logs.map((o, i) => (
                                                <tr key={i}>
                                                    <td>{o.name}</td>
                                                    <td className="nowrap">{o.date}</td>
                                                </tr>
                                            ))}
                                            </tbody>
                                        </Table>
                                    </div>
                                </FormGroup>

                            </Col>
                            <Col md="6">
                                <FormGroup>
                                    <Label className="bold">Método</Label>
                                    <Select
                                        options={this.state.compekits}
                                        placeholder="Elegir..."
                                        value={this.state.compekit_selected}
                                        onChange={(o) => {
                                            this.setState({
                                                ...this.state,
                                                compekit_selected: o,
                                                item: {
                                                    ...this.state.item,
                                                    id_compekit: o.value
                                                }
                                            });
                                        }}/>
                                </FormGroup>
                                <FormGroup>
                                    <Label className="bold">Competencias</Label>
                                    <Select
                                        name="compekits"
                                        options={this.state.compekits}
                                        placeholder="Buscar..."
                                        onChange={(o) => {
                                            this.state.item.compekits.push({
                                                id: o.value,
                                                name: o.label
                                            });
                                            this.setState(this.state);
                                        }}/>
                                </FormGroup>
                                <FormGroup>
                                    <div className="_tbl_croll_v">
                                        <Table bordered responsive className="mdl-td _tbl">
                                            <thead>
                                            <tr>
                                                <th width="1%">#</th>
                                                <th>Nombre</th>
                                                <th width="1%"/>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {this.state.item.compekits.map((o, i) => (
                                                <tr key={i}>
                                                    <td>{o.id}</td>
                                                    <td>{o.name}</td>
                                                    <td>
                                                        <Button size="sm" onClick={() => {
                                                            this.state.item.compekits.splice(i, 1);
                                                            this.setState(this.state);
                                                        }}>
                                                            <i className="fa fa-times"/>
                                                        </Button>
                                                    </td>
                                                </tr>
                                            ))}
                                            </tbody>
                                        </Table>
                                    </div>
                                </FormGroup>
                                <FormGroup>
                                    <Label className="bold">Ubicación</Label>
                                    <Select
                                        options={this.state.managements}
                                        value={this.state.management_selected}
                                        onChange={(o) => {
                                            this.setState({
                                                ...this.state,
                                                management_selected: o
                                            });
                                        }}/>
                                </FormGroup>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4" className="bold">Items</Col>
                            <Col md="6">
                            </Col>
                            <Col md="12">
                                <Table bordered responsive className="mrg-t-10 mdl-td _tbl">
                                    <thead>
                                    <tr>
                                        <th width="1%"/>
                                        <th>Nombre</th>
                                        <th width="80px">Cantidad</th>
                                        <th width="120px">Marca</th>
                                        <th width="120px">Modelo</th>
                                        <th width="150px">Serie</th>
                                        <th width="1%"/>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {this.state.item.items.map((o, i) => (
                                        <tr key={i}>
                                            <td className="ctr">
                                                {i + 1}
                                            </td>
                                            <td>
                                                <Input value={o.name} placeholder="Nombre"
                                                       onChange={(e) => {
                                                           o.name = e.target.value;
                                                           this.setState(this.state);
                                                       }}/>
                                            </td>
                                            <td>
                                                <Input value={o.quantity} placeholder="0" type="number"
                                                       onChange={(e) => {
                                                           o.quantity = e.target.value;
                                                           this.setState(this.state);
                                                       }}/>
                                            </td>
                                            <td>
                                                <Input value={o.brand} placeholder="Marca"
                                                       onChange={(e) => {
                                                           o.brand = e.target.value;
                                                           this.setState(this.state);
                                                       }}/>
                                            </td>
                                            <td>
                                                <Input value={o.model} placeholder="Modelo"
                                                       onChange={(e) => {
                                                           o.model = e.target.value;
                                                           this.setState(this.state);
                                                       }}/>
                                            </td>
                                            <td>
                                                <Input value={o.serie} placeholder="Serie"
                                                       onChange={(e) => {
                                                           o.serie = e.target.value;
                                                           this.setState(this.state);
                                                       }}/>
                                            </td>
                                            <td>
                                                <Button onClick={() => this.removeKitItem(o, i)}>
                                                    <i className="fa fa-times"/>
                                                </Button>
                                            </td>
                                        </tr>
                                    ))}
                                    </tbody>
                                </Table>

                                <Button outline color="dark" onClick={() => {
                                    this.state.item.items.push({
                                        id: 0,
                                        name: '',
                                        quantity: '',
                                        brand: '',
                                        model: '',
                                        serie: ''
                                    });
                                    this.setState(this.state);
                                }}>
                                    <i className="fa fa-plus"/> Agregar
                                </Button>

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
        )
            ;
    }
}