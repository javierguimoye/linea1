import React from 'react';
import { Col, Row } from 'reactstrap';

export default class E404 extends React.Component {

    state = {
        modal: false,
    };

    render() {
        return (
            <div>
                <Row className="justify-content-center">
                    <Col md="6">
                        <div className="clearfix">
                            <h1 className="float-left display-3 mr-4">404</h1>
                            <h4 className="pt-3">Oops! You're lost.</h4>
                            <p className="text-muted float-left">The page you are looking for was not found.</p>
                        </div>
                    </Col>
                </Row>
            </div>
        )
    }
}