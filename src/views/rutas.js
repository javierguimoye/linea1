import React from 'react';
import {
    Button, Card, CardBody, CardHeader
} from 'reactstrap';
import Fils from "./widgets/fils";
import RutasM from "./rutas_m";

export default class Rutas extends React.Component {

    render() {
        return (
        
            <div>   {console.log(...this.props+"")} 
                <Card>
                    <CardHeader>
                        <span className="text-uppercase bold">Rutas</span>
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
                                  {name: 'nombre_unidad', value: 'Unidad'},
                                  {name: 'nombre', value: 'Nombre'},
                                  {name: 'distancia', value: 'Distancia'},
                                  {name: 'viatico', value: 'Viatico'},
                                  {name: 'movilidad', value: 'Movilidad'},
                                  {name: 'hotel', value: 'Hotel'},
                                  {name: 'cochera', value: 'Cochera'},
                                  {name: 'total_dia', value: 'Total del Dia'},
                                  {name: 'date_created', value: 'Fecha de creación', width: '1%'},
                                  {width: '1%'}
                              ]}

                              row={(o, i) => (
                                  <tr key={i}>
                                      <td>{o.id}</td>
                                      <td>{o.nombre_unidad}</td>
                                      <td>{o.nombre}</td>
                                      <td>{o.distancia}</td>
                                      <td>{"S/ "+o.viatico}</td>
                                      <td>{"S/ "+o.movilidad}</td>
                                      <td>{"S/ "+o.hotel}</td>
                                      <td>{"S/ "+o.cochera}</td>
                                      <td>{"S/ "+o.total_dia}</td>

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

                <RutasM ref={instance => this.modal = instance}
                         callback={() => this.fils.loadData()}/>

            </div>)
    }
}