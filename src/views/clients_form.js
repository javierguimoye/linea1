import React from 'react';
import {Link} from "react-router-dom";
import {BarLoader} from "react-spinners";
import {Api} from "../inc/api";

export default class ClientsForm extends React.Component {

    state = {
        loading: false,
        client: {
            id: 0,
            name: '',
            document: '',
            address: ''
        }
    };

    componentDidMount() {

        if (this.props.match.params.id) {
            this.setState({loading: true});
            Api.get('/clients/dataForm', {id: this.props.match.params.id}, (rsp) => {
                if (rsp.ok) {
                    this.setState({
                        loading: false,
                        client: rsp.client ? rsp.client : this.state.client
                    });
                } else {
                    this.setState({loading: false});
                }
            });
        }
    }

    save = (e) => {
        e.preventDefault();
        this.setState({
            ...this.state,
            loading: true
        });
    };

    render() {
        console.log('ClientsAdd.render(...');
        return (
            <form className="card medi form-horizontal" onSubmit={this.save}>
                <fieldset disabled={this.state.loading}>
                    <div className="card-header bold text-uppercase">
                        {this.state.id > 0 ? 'Editar' : 'Agregar'} cliente
                    </div>
                    <div hidden={!this.state.loading} style={{height: 2, marginTop: '-2px', background: 'white'}}>
                        <BarLoader width={-1}/>
                    </div>
                    <div className="card-body form-horizontal">

                        <div className="row form-group">
                            <div className="col-md-3">
                                <label>Razón social *</label>
                            </div>
                            <div className="col-md-9">
                                <input className="form-control" name="name" value={this.state.client.name}/>
                            </div>
                        </div>

                        <div className="row form-group">
                            <div className="col-md-3">
                                <label>RUC</label>
                            </div>
                            <div className="col-md-9">
                                <input className="form-control" name="document" value={this.state.client.document}/>
                            </div>
                        </div>

                        <div className="row form-group">
                            <div className="col-md-3">
                                <label>Dirección fiscal</label>
                            </div>
                            <div className="col-md-9">
                                <input className="form-control" name="address" value={this.state.client.address}/>
                            </div>
                        </div>

                    </div>
                    <div className="card-footer">
                        <Link className="bold text-uppercase btn btn-outline-secondary" to="/clients">
                            Cancelar
                        </Link>{' '}
                        <button className="bold text-uppercase btn btn-primary">
                            <i className="fa fa-check"/> Guardar
                        </button>
                    </div>
                </fieldset>
            </form>
        )
    }
}