import React from 'react';
import {
    Card, CardBody, CardHeader, Col, Row, Input, Label, FormGroup, Alert
} from 'reactstrap';
import {Api} from "../inc/api";
import {AppSwitch} from "@coreui/react";
import {toast} from "react-toastify";

export default class Settings extends React.Component {

    state = {
        loading: false,
        error: null,
        item: {
            brand: '',
            name: '',
            email: '',
            phone: '',
            ruc: '',
            address: '',
            coin: '',
            coin_name: '',
            coin_short: '',
            mail_auth: '0',
            mail_host: '',
            mail_username: '',
            mail_password: '',
            mail_sender: '',
            mail_bcc: ''
        }
    };

    componentDidMount() {
        //this.modal.add();
        this.loadData();
    }

    loadData = () => {
        this.setState({
            ...this.state,
            loading: true
        });
        Api.get('/settings', {}, (rsp) => {
            if (rsp.ok) {

                this.setState({
                    loading: false,
                    item: rsp.item
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

    save = () => {

        this.setState({
            ...this.state,
            loading: true,
            error: null
        });

        Api.post('/settings/saveAll', this.state.item, (rsp) => {

            if (rsp.ok) {
                toast.success('Guardado correctamente');
                this.setState({
                    ...this.state,
                    loading: false,
                    error: null
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
        const {item} = this.state;

        return (
            <fieldset disabled={this.state.loading}>
                <Card className="medi _frm">
                    <CardHeader>
                        <span className="text-uppercase bold">Ajustes de sistema</span>
                        <div className="card-header-actions">
                            <button className="bold text-uppercase btn btn-primary" onClick={this.save}>
                                <i className="fa fa-check"/> Guardar
                            </button>
                        </div>
                    </CardHeader>
                    <CardBody>

                        <Alert color="danger" isOpen={this.state.error != null} fade={true}>
                            {this.state.error}
                        </Alert>

                        <Row>
                            <Col md={12}>
                                <FormGroup>
                                    <Label className="bold">Empresa</Label>
                                </FormGroup>
                            </Col>
                            <Col md={5}>
                                <FormGroup>
                                    <Label>Marca</Label>
                                    <Input name="brand" value={item.brand} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={7}>
                                <FormGroup>
                                    <Label>Nombre</Label>
                                    <Input name="name" value={item.name} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={5}>
                                <FormGroup>
                                    <Label>Email</Label>
                                    <Input name="email" value={item.email} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={3}>
                                <FormGroup>
                                    <Label>Teléfono</Label>
                                    <Input name="phone" value={item.phone} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={4}>
                                <FormGroup>
                                    <Label>RUC</Label>
                                    <Input name="ruc" value={item.ruc} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={12}>
                                <FormGroup>
                                    <Label>Dirección</Label>
                                    <Input name="address" value={item.address} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={12}>
                                <FormGroup>
                                    <Label className="bold">Moneda</Label>
                                </FormGroup>
                            </Col>
                            <Col md={5}>
                                <FormGroup>
                                    <Label>Nombre</Label>
                                    <Input name="coin_name" value={item.coin_name} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={3}>
                                <FormGroup>
                                    <Label>Símbolo</Label>
                                    <Input name="coin" value={item.coin} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={4}>
                                <FormGroup>
                                    <Label>Corto</Label>
                                    <Input name="coin_short" value={item.coin_short}
                                           onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                        </Row>

                        <Row>
                            <Col md={12}>
                                <FormGroup>
                                    <Label className="bold">Correos</Label>
                                </FormGroup>
                            </Col>
                            <Col md={4}>
                                <FormGroup>
                                    <div style={{height: 20}}/>
                                    <Label>
                                        <AppSwitch
                                            className="mdl"
                                            color="primary"
                                            variant="pill"
                                            checked={item.mail_auth === '1'}
                                            onChange={(e) => {
                                                this.setState({
                                                    ...this.state,
                                                    item: {
                                                        ...this.state.item,
                                                        mail_auth: e.target.checked ? '1' : '0'
                                                    }
                                                });
                                            }}
                                        /> Auth SMTP
                                    </Label>
                                </FormGroup>
                            </Col>
                            <Col md={8}>
                                <FormGroup>
                                    <Label>Host</Label>
                                    <Input name="mail_host" value={item.mail_host}
                                           readOnly={item.mail_auth !== '1'} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={6}>
                                <FormGroup>
                                    <Label>Usuario</Label>
                                    <Input name="mail_username" value={item.mail_username}
                                           readOnly={item.mail_auth !== '1'} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={6}>
                                <FormGroup>
                                    <Label>Contraseña</Label>
                                    <Input name="mail_password" value={item.mail_password}
                                           readOnly={item.mail_auth !== '1'} onChange={this.changed}/>
                                </FormGroup>
                            </Col>
                            <Col md={6}>
                                <FormGroup>
                                    <Label>Remitente</Label>
                                    <Input name="mail_sender" value={item.mail_sender} onChange={this.changed}
                                           placeholder="Email remitente"/>
                                </FormGroup>
                            </Col>
                            <Col md={6}>
                                <FormGroup>
                                    <Label>Copia oculta</Label>
                                    <Input name="mail_bcc" value={item.mail_bcc} onChange={this.changed}
                                           placeholder="Correo para ser enviado copia oculta"/>
                                </FormGroup>
                            </Col>
                        </Row>

                    </CardBody>
                </Card>
            </fieldset>)
    }
}