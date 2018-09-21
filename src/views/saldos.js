import React from 'react';
import {
    Button, Card, CardBody, CardHeader
} from 'reactstrap';
import Fils from "./widgets/fils";
import DocumentSigsM from "./saldos_m";

export default class DocumentSigs_saldos extends React.Component {

    componentDidMount() {
        //this.modal.add();
    }

    render() {
        return (
            <div>
                <Card className="medi">
                    <CardHeader>
                        <span className="text-uppercase bold">Saldos</span>
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
                                 // {name: 'name', value: 'Nombre'},
                                  {name: 'file', value: 'Archivo', width: '1%'},
                                  {name: 'date_created', value: 'Fecha de creación', width: '1%'},
                                  {width: '1%'}
                             
                              ]}
                              row={(o, i) => (
                                  <tr key={i}>
                                      <td>{o.id}</td>
                                      <td>{o.file_url ?
                                          <a className="btn btn-outline-dark btn-sm" href={o.file_url} target="_blank">
                                              <i className="fa fa-file-o"/> Ver <i className="fa fa-angle-right"/>
                                          </a>
                                          : ''}
                                      </td>
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

                <DocumentSigsM ref={instance => this.modal = instance}
                               callback={() => this.fils.loadData()}/>

            </div>)
    }
}