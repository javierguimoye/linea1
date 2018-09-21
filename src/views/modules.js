import React, {Component} from 'react';
import {Card, CardBody, CardHeader} from 'reactstrap';
import {Api} from "../inc/api";
import Nestable from "react-nestable";
import ModulesM from "./modules_m";
import {BarLoader} from "react-spinners";
import {User} from "../inc/user";

export default class Modules extends Component {

    state = {
        loading: false,
        items: []
    };

    componentDidMount() {
        this.loadData();
        //this.modal.add();
    }

    loadData = () => {
        this.setState({
            ...this.state,
            loading: true
        });
        Api.get('/modules', {}, (rsp) => {
            if (rsp.ok) {
                this.setState({
                    items: rsp.menu_all,
                    loading: false
                });
            }
        });
    };

    itemsChanged = (items) => {
        Api.post('/modules/resort', {items: items}, () => {
            User.verify();
        }, 'Guardando...');
    };

    render() {
        return (
            <div>
                <Card className="mini">
                    <CardHeader className="text-uppercase bold">
                        <span className="text-uppercase bold">Modulos</span>
                        <div className="card-header-actions">
                            <button className="bold text-uppercase btn btn-primary" onClick={() => this.modal.add()}>
                                <i className="fa fa-plus"/> Nuevo
                            </button>
                        </div>
                    </CardHeader>
                    <div hidden={!this.state.loading}>
                        <BarLoader width={-1}/>
                    </div>
                    <CardBody className="pdg-10">

                        <Nestable
                            items={this.state.items}
                            maxDepth={2}
                            renderItem={({item}) => <div>
                                {item.name}
                                <button className="btn btn-outline-dark btn-sm edit" onClick={() => {
                                    this.modal.edit(item.id);
                                }}>
                                    <i className="fa fa-pencil"/>
                                </button>
                            </div>}
                            onChange={this.itemsChanged}/>

                    </CardBody>
                </Card>

                <ModulesM ref={ins => this.modal = ins}
                          callback={this.loadData}/>

            </div>
        );
    }
}