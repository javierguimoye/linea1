import React, {Component} from 'react';
import {
    Button, Form, FormGroup, Input, Label, Pagination, PaginationItem, PaginationLink, Table
} from 'reactstrap';
import {Api} from "../../inc/api";
import * as queryString from "query-string";
import {BarLoader} from "react-spinners";
import {Link} from "react-router-dom";
import {toast} from "react-toastify";

export default class Fils extends Component {

    state = {
        loading: false,
        fils: {
            page: 1,
            word: ''
        },
        items: []
    };

    constructor(props) {
        super(props);

        let params = queryString.parse(props.location.search);
        Object.keys(params).map((k) => this.state.fils[k] = params[k]);
    }

    clickPrev = () => {

        let _state = this.state;
        _state.fils.page = --_state.fils.page;
        this.setState(_state);

        this.loadData();
    };

    clickNext = () => {

        let _state = this.state;
        _state.fils.page = ++_state.fils.page;
        this.setState(_state);

        this.loadData();
    };

    loadData() {

        this.setState({
            ...this.state,
            loading: true
        });

        Api.get(this.props.endpoint, this.state.fils, (rsp) => {

            if (rsp.ok) {
                this.setState({
                    ...this.state,
                    loading: false,
                    items: rsp.items
                });
            }

        });
    }

    componentDidMount() {
        this.loadData();
    }

    handleChange = (event) => {

        let _state = this.state;
        _state.fils[event.target.name] = event.target.value;

        this.setState(_state);

    };

    clickColumn = (o) => {
        if (o.name) {
            //console.log('this.clickColumn', o);
        }
    };

    clickRemove = (id) => {
        if (window.confirm('¿Seguro que quieres borrar?')) {
            Api.get(this.props.endpoint + '/remove', {id: id}, (rsp) => {
                if (rsp.ok) {
                    toast.success('Eliminado correctamente');
                    this.loadData();
                } else {
                    toast.error('Se produjo un error');
                }
            }, 'Eliminando...')
        }
    };

    render() {

        //const query = queryString.stringify(this.state.fils);
        //window.history.pushState(null, null, '#' + this.props.endpoint + '?' + query);

        return (
            <div>
                <Form inline className="pdg-10"
                      hidden={typeof this.props.no_filters === 'boolean' && this.props.no_filters}
                      onSubmit={(e) => {
                          e.preventDefault();
                          this.loadData();
                      }}>

                    {typeof this.props.form === 'function' ? this.props.form() : ''}

                    <FormGroup className="mb-2 mr-sm-2 mb-sm-0">
                        <Label className="mr-sm-2">Búsqueda</Label>
                        <Input name="word"
                               value={this.state.fils.word}
                               onChange={this.handleChange}
                               placeholder="Buscar..."/>
                    </FormGroup>

                    <Button color="primary">Aplicar</Button>

                </Form>


                <div hidden={!this.state.loading}
                     style={{marginBottom: '-4px', background: 'white', position: 'relative', zIndex: 3}}>
                    <BarLoader width={-1}/>
                </div>

                <Table bordered striped responsive className="mdl-td _tbl mrg-0">
                    <thead>
                    <tr>
                        {
                            this.props.cols.map((_o, i) => {

                                let o = Object.assign({
                                    name: '',
                                    value: '',
                                    width: '',
                                    className: ''
                                }, _o);

                                if (o.width === '1%') o.className += ' nowrap';

                                //if (o.name !== '') o.className += ' pointer';

                                return (
                                    <th
                                        width={o.width}
                                        key={i}
                                        className={o.className}
                                        onClick={() => this.clickColumn(o)}>
                                        {o.value}
                                    </th>
                                )
                            })
                        }
                    </tr>

                    </thead>
                    <tbody>
                    {this.state.items.map(
                        typeof this.props.row === 'function'
                            ? this.props.row
                            : (o, i) => {
                                return <tr key={i}>
                                    {this.props.cols.map((_o, i) => {

                                        let td = '';

                                        switch (_o.name) {
                                            case '__remove':
                                                td = <button onClick={() => this.clickRemove(o.id)}
                                                             className="btn btn-danger mrg-0 btn-sm">
                                                    <i className="fa fa-trash"/>
                                                </button>;
                                                break;
                                            case '__edit':
                                                td = <Link to={this.props.endpoint + "/form/" + o.id}
                                                           className="btn btn-primary btn-sm">
                                                    <i className="fa fa-pencil"/>
                                                </Link>;
                                                break;
                                            default:
                                                td = o[_o.name];
                                                break;
                                        }

                                        return <td key={i}>{td}</td>;
                                    })}
                                </tr>
                            }
                    )}
                    </tbody>
                </Table>

                <div hidden={typeof this.props.no_pager === 'boolean' && this.props.no_pager}>
                    <Pagination  className="mrg-t-10">
                        {this.state.fils.page > 1 ? (
                            <PaginationItem>
                                <PaginationLink onClick={this.clickPrev} previous tag="button"/>
                            </PaginationItem>
                        ) : ''}
                        <PaginationItem active>
                            <PaginationLink tag="button">{this.state.fils.page}</PaginationLink>
                        </PaginationItem>
                        <PaginationItem>
                            <PaginationLink onClick={this.clickNext} next tag="button"/>
                        </PaginationItem>
                    </Pagination>
                </div>
            </div>
        );
    }
}