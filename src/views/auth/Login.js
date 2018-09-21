import React, {Component} from 'react';
import {
    Button, Card, CardBody, CardGroup, Col, Container, Input, InputGroup, InputGroupAddon, InputGroupText, Row
} from 'reactstrap';

import {Api} from "../../inc/api";
import {User} from "../../inc/user";
import {Alert} from "reactstrap/lib/index";
import {Link} from "react-router-dom";

export default class Login extends Component {

    state = {
        username: '',
        password: '',
        loading: false,
        error: null,
    };

    handleChange = (event) => {
        this.setState({[event.target.name]: event.target.value});
    };

    login = (event) => {
        event.preventDefault();

        this.setState({
            loading: true,
            error: null
        });

        const data = {
            username: this.state.username,
            password: this.state.password
        };

        Api.get('/login/login', data, (rsp) => {
            if (rsp.ok) {

                User.token = rsp.token;
                User.verify(function () {
                    window.location.href = './';
                });

            } else {
                this.setState({
                    loading: false,
                    error: rsp.msg
                });
            }
        });

    };

    render() {
        return (
            <div className="app flex-row align-items-center">

                <Container>
                    <Row className="justify-content-center">
                        <Col md="8">
                            <CardGroup>
                                <Card className="p-4">

                                    <form onSubmit={this.login}>
                                        <CardBody>
                                            <h1>Iniciar sesión</h1>
                                            <p className="text-muted">Inicia sesión en tu cuenta</p>

                                            <Alert hidden={this.state.error == null}
                                                   color="danger">{this.state.error}</Alert>

                                            <InputGroup className="mb-3">
                                                <InputGroupAddon addonType="prepend">
                                                    <InputGroupText>
                                                        <i className="icon-user"/>
                                                    </InputGroupText>
                                                </InputGroupAddon>
                                                <Input type="text"
                                                       placeholder="Usuario"
                                                       name="username"
                                                       value={this.state.username}
                                                       onChange={this.handleChange}
                                                       autoFocus/>
                                            </InputGroup>
                                            <InputGroup className="mb-4">
                                                <InputGroupAddon addonType="prepend">
                                                    <InputGroupText>
                                                        <i className="icon-lock"/>
                                                    </InputGroupText>
                                                </InputGroupAddon>
                                                <Input type="password" placeholder="Contraseña"
                                                       name="password"
                                                       value={this.state.password}
                                                       onChange={this.handleChange}/>
                                            </InputGroup>
                                            <Row>
                                                <Col xs="6">
                                                    <Button disabled={this.state.loading}
                                                            color="primary"
                                                            className="px-4">
                                                        Ingresar
                                                    </Button>
                                                </Col>
                                                <Col xs="6" className="text-right">
                                                    <Link to="/forgot" className="btn btn-link px-0" hidden={true}>
                                                        ¿Contraseña olvidada?
                                                    </Link>
                                                </Col>
                                            </Row>
                                        </CardBody>
                                    </form>
                                </Card>
                                <Card className="text-white bg-primary py-5 d-md-down-none"
                                      style={{width: 44 + '%'}}>
                                    <CardBody className="text-center">
                                        <div>
                                          
{
/*
  <img src="img/logo-login.jpg"
                                                 alt="logo"
                                                 style={{maxWidth: '100%', marginTop: 40}}/>
*/
}
                                            {/*<h2>¿Si una cuenta?</h2>
                                            <p>
                                                Si aún no tiene una cuenta, regístrese ahora.
                                            </p>
                                            <Button color="primary" className="mt-3" active>
                                                Registrarme
                                            </Button>*/}

                                        </div>
                                    </CardBody>
                                </Card>
                            </CardGroup>
                        </Col>
                    </Row>
                </Container>
            </div>
        );
    }

}