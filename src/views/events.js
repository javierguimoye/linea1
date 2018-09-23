import React from 'react';
import {
    Button, Card, CardBody, CardHeader
} from 'reactstrap';
import Fils from "./widgets/fils";
import EventosM from "./eventos_m";

export default class Events extends React.Component {

    render() {
        return (
            <div>
                <Card className="medi">
                    <CardHeader>
                        <span className="text-uppercase bold">Eventos</span>
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
                                  {name: 'direction', value: 'Estacion'},
                                  {name: 'notificacion', value: 'Notificacion', width: '1%'},
                                  {name: 'name', value: 'Mensaje'},
                                  {name: 'date_created', value: 'Fecha', width: '1%'},
                                  {width: '1%'}
                              ]}
                              row={(o, i) => (
                                  <tr key={i}>
                                      <td>{o.id}</td>
                                      <td>{o.direction}</td>
                                      <td>{o.notificacion}</td>
                                      <td>{o.name}</td>
                                      <td>{o.date_created}</td>
                                      <td>
                                          <Button color="primary" size="sm" onClick={() => this.modal.edit(o.id)}>
                                              <i className="fa fa-pencil"/>
                                          </Button>
                                      </td>
                                  </tr>
                              )}
                        />

                    </CardBody>
                </Card>

                <EventosM ref={ins => this.modal = ins}
                              callback={() => this.fils.loadData()}/>

            </div>)
    }
}