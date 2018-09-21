import {createStore} from 'redux';

const reducer = (state, action) => {

    if (action.type === 'SET_LOGIN') {
        return {
            ...state,
            login: state.login
        }
    }

};

export default createStore(reducer, {login: {}});