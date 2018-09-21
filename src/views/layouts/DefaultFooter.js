import React, {Component} from 'react';
import {Link} from "react-router-dom";

class DefaultFooter extends Component {
    render() {
        return (
            <React.Fragment>
                <span>
                    <Link to="/home">Linea1</Link> &copy; 2018.
                </span>
                <span className="ml-auto float-right">
                    Powered by <a href="http://focusit.pe/" target="_blank" rel="noopener noreferrer">FocusIT</a>
                </span>
            </React.Fragment>
        );
    }
}

export default DefaultFooter;