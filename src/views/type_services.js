import React from 'react';
import {
    Button, Card, CardBody, CardHeader
} from 'reactstrap';
import Fils from "./widgets/fils";
import TypeServicesM from "./type_services_m";

export default class TypeServices extends React.Component {

    render() {
        return (
            <div>
                <Card className="mini">
                    <CardHeader>
                        <span className="text-uppercase bold">Tipos de servicios</span>
                        <div className="card-header-actions">
                            <button className="bold text-uppercase btn btn-primary" onClick={() => this.modal.add()}>
                                <i className="fa fa-plus"/> Nuevo
                            </button>
                        </div>
                    </CardHeader>
                    <CardBody className="pdg-5">

                        <Fils {...this.props}
                              ref={instance => this.fils = instance}
                              endpoint={this.props.match.url}
                              cols={[
                                  {name: 'id', value: '#', width: '1%'},
                                  {name: 'name', value: 'Nombre'},
                                  {name: 'date_created', value: 'Fecha de creación', width: '1%'},
                                  {width: '1%'}
                              ]}
                              row={(o, i) => (
                                  <tr key={i}>
                                      <td>{o.id}</td>
                                      <td>{o.name}</td>
                                      <td className="nowrap">{o.date_created.datetime()}</td>
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

                <TypeServicesM ref={instance => this.modal = instance}
                               callback={() => this.fils.loadData()}/>

            </div>)
    }
}