import React from 'react';
import {Link} from "react-router-dom";

export default class Ots extends React.Component {

    state = {
        modal: false,
    };

    render() {
        return (
            <div>

                <div className="pg-title clearfix">
                    <h1>Todas las OTS</h1>
                    <div className="pg-title-tools">
                        los ots
                    </div>
                </div>

                <div className="ots-items clearfix">
                    <div className="ots-item">
                        <div className="ots-item-title">Nombre de la OT registrada</div>
                        <div className="ots-item-container">
                            <p className="ots-item-p">Nombre Cliente</p>
                            <p className="ots-item-p odd">Mineria Buenavntura</p>
                            <p className="ots-item-p">Número de OT</p>
                            <p className="ots-item-p odd">#000934059</p>
                            <p className="ots-item-p">Lugar</p>
                            <p className="ots-item-p odd">Calle San Luis, Arequipa</p>
                            <Link to="/mmm" className="btn btn-outline-primary btn-block mrg-t-15">EDITAR</Link>
                            <Link to="/mmm" className="btn btn-primary btn-block">PROGRAMAR</Link>
                            <Link to="/mmm" className="btn btn-primary btn-block">EXPORTAR</Link>
                        </div>
                    </div>
                    <div className="ots-item add">
                        <Link to="/ots/form" className="btn btn-primary bold">
                            <i className="fa fa-plus"/> Crear nueva OT...
                        </Link>
                    </div>
                </div>

            </div>
        )
    }
}