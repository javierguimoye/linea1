import React from 'react';
import {
    Button, Card, CardBody, CardHeader
} from 'reactstrap';
import Fils from "./widgets/fils";
import KitsM from "./kits_m";

export default class Kits extends React.Component {

    componentDidMount() {
        this.modal.add();
    }

    render() {
        return (
            <div>
                <Card>
                    <CardHeader>
                        <span className="text-uppercase bold">Equipos</span>
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
                                  {name: 'name', value: 'Nombre equipo'},
                                  {name: 'brand', value: 'Marca'},
                                  {name: 'model', value: 'Modelo'},
                                  {name: 'serie', value: 'N. Serie'},
                                  {width: '1%'}
                              ]}
                              row={(o, i) => (
                                  <tr key={i}>
                                      <td>{o.id}</td>
                                      <td>{o.name}</td>
                                      <td>{o.brand}</td>
                                      <td>{o.model}</td>
                                      <td>{o.serie}</td>
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

                <KitsM ref={ins => this.modal = ins}
                       callback={() => this.fils.loadData()}/>

            </div>)
    }
}