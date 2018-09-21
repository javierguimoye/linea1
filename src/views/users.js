import React from 'react';
import {Card, CardBody, CardHeader, Button} from 'reactstrap';
import Fils from "./widgets/fils";
import UsersM from "./users_m";

export default class Users extends React.Component {

    render() {
        return (
            <div>
                <Card>
                    <CardHeader>
                        <span className="text-uppercase bold">Usuarios</span>
                        <div className="card-header-actions">
                            <button className="bold text-uppercase btn btn-primary" onClick={() => this.modal.add()}>
                                <i className="fa fa-plus"/> Nuevo
                            </button>
                        </div>
                    </CardHeader>
                    <CardBody className="pdg-5">

                        <Fils {...this.props}
                              ref={ins => this.fils = ins}
                              endpoint={this.props.match.url}
                              cols={[
                                  {name: 'id', value: '#', width: '1%'},
                                  {name: 'name', value: 'Nombre'},
                                  {name: 'surname', value: 'Apellido'},
                                  {name: 'ro_name', value: 'Perfil'},
                                  {name: 'date_created', value: 'Fecha de Creación', width: '1%'},
                                  {width: '1%'}
                              ]}
                              row={(o, i) => (
                                  <tr key={i}>
                                      <td>{o.id}</td>
                                      <td>{o.name}</td>
                                      <td>{o.surname}</td>
                                      <td>{o.ro_name}</td>
                                      <td className="nowrap">{o.date_created.datetime()}</td>
                                      <td>
                                          <Button color="primary" size="sm" onClick={() => this.modal.edit(o.id)}>
                                              <i className="fa fa-pencil"/>
                                          </Button>
                                      </td>
                                  </tr>
                              )}/>

                    </CardBody>
                </Card>

                <UsersM ref={ins => this.modal = ins} callback={() => this.fils.loadData()}/>

            </div>
        )
    }
}