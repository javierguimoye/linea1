import React from 'react';
import {
    Button, Card, CardBody, CardHeader
} from 'reactstrap';
import Fils from "./widgets/fils";
import UnidadesM from "./unidades_m";

export default class Unidades extends React.Component {

    render() {
        return (
        
            <div>   {console.log(...this.props+"")} 
                <Card>
                    <CardHeader>
                        <span className="text-uppercase bold">Unidades</span>
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
                                  {name: 'nombre_movilidad', value: 'Movilidad'},
                                  {name: 'tracto_unidad', value: 'Tracto/Unidad'},
                                  {name: 'botella', value: 'Botella'},
                                  {name: 'date_created', value: 'Fecha de Creación', width: '1%'},
                                  {width: '1%'}
                              ]}

                              row={(o, i) => (
                                  <tr key={i}>
                                      <td>{o.id}</td>
                                      <td>{o.nombre_movilidad}</td>
                                      <td>{o.tracto_unidad}</td>
                                      <td>{o.botella}</td>
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

                <UnidadesM ref={instance => this.modal = instance}
                         callback={() => this.fils.loadData()}/>

            </div>)
    }
}