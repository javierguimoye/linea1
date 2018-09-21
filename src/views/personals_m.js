import React, {Component} from 'react';
import {
    Alert,
    Button, Col, Input, Modal, ModalBody, ModalFooter, ModalHeader,
    Row
} from 'reactstrap';
import {Api} from "../inc/api";
import {toast} from "react-toastify";
import Select from 'react-select'

export default class PersonalsM extends Component {

    state = {
        item: {
            id: 0,
            name: '',
            surname: '',
            document: '',
            competences: []
        },
        competences: [],
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
            item: {
                id: 0,
                name: '',
                surname: '',
                document: '',
                competences: []
            }
        });
        Api.get('/personals/dataForm', {id: id}, (rsp) => {
            if (rsp.ok) {

                let options = [];

                rsp.competences.map((o) => options.push({
                    value: o.id,
                    label: o.name
                }));

                this.setState({
                    loading: false,
                    item: rsp.item ? rsp.item : this.state.item,
                    competences: options
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
        data.ids_competences = [];
        this.state.item.competences.map((o) => data.ids_competences.push(o.id));

        Api.post('/personals/create', data, (rsp) => {

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
            Api.get('/personals/remove', {id: this.state.item.id}, (rsp) => {
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
                        {this.state.item.id > 0 ? 'Editar' : 'Agregar'} personal
                    </ModalHeader>
                    <ModalBody className="form-horizontal">

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>

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
                            <Col md="4">DNI</Col>
                            <Col md="8">
                                <Input name="document" value={this.state.item.document} onChange={this.changed}/>
                            </Col>
                        </Row>

                        <Row className="form-group">
                            <Col md="4">Competencias</Col>
                            <Col md="8">

                                <Select
                                    name="competences"
                                    options={this.state.competences}
                                    onChange={(o) => {
                                        this.state.item.competences.push({
                                            id: o.value,
                                            name: o.label
                                        });
                                        this.setState(this.state);
                                    }}
                                />

                                <table className="table mrg-t-10">
                                    <thead>
                                    <tr>
                                        <th width="1%">#</th>
                                        <th>Nombre</th>
                                        <th width="1%"/>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {this.state.item.competences.map((o, i) => (
                                        <tr key={i}>
                                            <td>{o.id}</td>
                                            <td>{o.name}</td>
                                            <td>
                                                <Button size="sm" onClick={() => {
                                                    this.state.item.competences.splice(i, 1);
                                                    this.setState(this.state);
                                                }}>
                                                    <i className="fa fa-times"/>
                                                </Button>
                                            </td>
                                        </tr>
                                    ))}
                                    </tbody>
                                </table>

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