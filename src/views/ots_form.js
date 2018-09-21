import React from 'react';
import {Col, Row} from "reactstrap";

export default class OtsForm extends React.Component {
    render() {
        return (
            <Row>
                <Col md={3}>

                    <ul className="list-group">
                        <button className="list-group-item-action list-group-item text-uppercase active">
                            <i className="fa fa-folder"/> Datos personales
                        </button>
                        <button className="list-group-item-action list-group-item text-uppercase">
                            <i className="fa fa-folder-open"/> Detalles de servicio
                        </button>
                        <button className="list-group-item-action list-group-item text-uppercase">
                            <i className="fa fa-database"/> Recursos de servicio
                        </button>
                    </ul>

                </Col>
                <Col md={9}>
                    rggg
                </Col>
            </Row>
        )
    }
}