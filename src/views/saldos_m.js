import React, {Component} from 'react';
import {
    Alert,
    Button, Col, Modal, ModalBody, ModalFooter, ModalHeader,
    Row
} from 'reactstrap';
import {Api} from "../inc/api";
import {toast} from "react-toastify";
import Dropzone from "react-dropzone";

export default class DocumentSigsM extends Component {

    state = {
        item: {
            id: 0,
           // name: '',
            file: '',
            file_url: ''
        },
        loading: false,
        error: null,
        modal: false,
        file: null
    };

    toggle = () => {
        this.setState({
            ...this.state,
            modal: !this.state.modal,
            file: null
        });
    };

    add = () => {
        this.setState({
            ...this.state,
            loading: false,
            modal: true,
            item: {
                id: 0,
               // name: '',
                file: '',
                file_url: ''
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
                //name: '',
                file: '',
                file_url: ''
            }
        });
        Api.get('/saldos/dataForm', {id: id}, (rsp) => {
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

        const formData = new FormData();
        formData.append('id', this.state.item.id);
      //  formData.append('name', this.state.item.name);
        formData.append('file', this.state.file);
       // console.log(formData);
        /*const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }
        return  post(url, formData,config);*/

        Api.post('/saldos/create', formData, (rsp) => {

            if (rsp.ok) {
                toast.success('Guardado correctamente');
                this.toggle();
                if (typeof this.props.callback === 'function') this.props.callback();
            } else {
                this.setState({
                    ...this.state,
                    loading: false,
                    error: rsp.msg,
                    file: null
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
            Api.get('/saldos/remove', {id: this.state.item.id}, (rsp) => {
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

    onDrop = (files) => {
        console.log('onDrop', files);
        if (files.length > 0) {
            this.setState({
                ...this.state,
                file: files[0]
            });
        } else {
            this.setState({
                ...this.state,
                file: null
            });
        }
    };

    render() {
        return (
            <Modal isOpen={this.state.modal} className={this.props.className} backdrop="static" keyboard={false}>
                <fieldset disabled={this.state.loading}>
                    <ModalHeader toggle={this.toggle}>
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} Saldos
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>
                        <Row className="form-group">
                            <Col md="4">Archivo</Col>
                            <Col md="8">

                                {this.state.item.file_url === ''
                                    ? ''
                                    :
                                    <a className="btn btn-outline-primary mrg-b-10 bold" target="_blank"
                                       href={this.state.item.file_url} style={{width: 200}}>
                                        <i className="fa fa-file-o"/> Ver archivo <i className="fa fa-angle-right"/>
                                    </a>}

                                <Dropzone onDrop={this.onDrop.bind(this)} multiple={false}>
                                    <div className="ctr pdg-15">
                                        {this.state.file == null
                                            ? 'Prueba a soltar algunos archivos aquí, o haz clic para seleccionar los archivos para cargar.'
                                            : <div className="bold">{this.state.file.name}</div>}
                                        <span className="btn btn-outline-dark mrg-t-10">Examinar...</span>
                                    </div>
                                </Dropzone>
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