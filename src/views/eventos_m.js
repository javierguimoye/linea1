import React, { Component } from "react";
import {
  Alert,
  Button,
  Col,
  Input,
  Modal,
  ModalBody,
  ModalFooter,
  ModalHeader,
  Row
} from "reactstrap";

import { Tab, Tabs, TabList, TabPanel } from "react-tabs";
import { Api } from "../inc/api";
import { toast } from "react-toastify";
import Select from "react-select";

const options = [
  { value: "1", label: "Notificacion" },
  { value: "2", label: "Email" }
];

export default class EventosM extends Component {
  state = {
    item: {
      id: 0,
      id_station: 0,
      direction: "",
      name: "",
      date: ""
    },
    type_notifications: [],
    stations: [],
    messages: [],
    message: {},
    tabIndex: 0,
    loading: false,
    error: "",
    modal: false
  };

  toggle = () => {
    this.setState({
      ...this.state,
      modal: !this.state.modal
    });
  };
  /*
    add = () => {
        this.setState({
            ...this.state,
            loading: false,
            modal: true,
            item: {
                id: 0,
                name: '',
                cost: ''
            }
        });
    };
*/
  add = () => {
    this.dataForm(0);
  };

  edit = id => this.dataForm(id);

  dataForm = id => {
    this.setState({
      ...this.state,
      modal: false,
      loading: true,
      station: {},
      messageType: {},
      message: {},
      chunk: "",
      item: {
        id: 0,
        id_station: 0,
        direction: "",
        type: 0,
        name: "",
        date: ""
      },

      type_notifications: [],
      stations: [],
      allMessages: [],
      messages: [],
      messageTypes: []
    });

    Api.get("/events/dataForm", { id: id }, rsp => {
      if (rsp.ok) {
        let options = [];
        rsp.type_notifications.map(o =>
          options.push({
            value: o.id,
            label: o.placa
          })
        );

        this.mapDataToState(rsp);

        this.setState({
          loading: false,
          modal: true
        });
      } else {
        this.setState({
          ...this.state,
          loading: false,
          error: rsp.msg
        });
      }
    });
  };

  save = e => {
    e.preventDefault();
    this.setState({
      ...this.state,
      loading: true,
      error: ""
    });

    Api.post("/events/create", this.state.item, rsp => {
      if (rsp.ok) {
        toast.success("Guardado correctamente");
        this.toggle();
        if (typeof this.props.callback === "function") this.props.callback();
      } else {
        this.setState({
          ...this.state,
          loading: false,
          error: rsp.msg
        });
      }
    });
  };

  remove = () => {
    if (window.confirm("¿Seguro que quieres borrar?")) {
      this.setState({
        ...this.state,
        loading: true,
        error: ""
      });
      Api.get(
        "/events/remove",
        { id: this.state.item.id },
        rsp => {
          if (rsp.ok) {
            toast.success("Eliminado correctamente");
            this.toggle();
            if (typeof this.props.callback === "function")
              this.props.callback();
          } else {
            toast.error("Se produjo un error");
          }
        },
        "Eliminando..."
      );
    }
  };

  changed = e => {
    const target = e.target;
    const value = target.type === "checkbox" ? target.checked : target.value;
    const name = target.name;

    this.setState({
      ...this.state,
      item: {
        ...this.state.item,
        [name]: value
      }
    });
  };

  // Mappers
  mapDataToState = data => {
    this.mapStationsToState(data.stations);
    this.mapMessagesToState(data.messages);
    this.mapMessageTypesToState(data.type_notifications);
  };

  mapStationsToState = data => {
    let stations = [];
    data.map(current => {
      stations.push({
        id: current.id,
        label: current.name,
        address: current.address
      });
    });

    this.setState({ stations });
  };

  mapMessagesToState = data => {
    let allMessages = [];
    data.map(current => {
      allMessages.push({
        id: current.id,
        label: current.message,
        message: current.message,
        notification: current.notificacion,
        parent_type: current.parent_type,
        select: current.select
      });
    });

    this.setState({ allMessages });
  };

  mapMessageTypesToState = data => {
    let messageTypes = [];
    data.map(current => {
      messageTypes.push({
        id: current.id,
        label: current.notificacion,
        notification: current.notificacion
      });
    });

    this.setState({ messageTypes });
  };

  // Event Handlers
  handleSelectStation = station => {
    this.setState({ station });
  };

  handleSelectMessageType = selectedOption => {
    let messages = this.state.allMessages.filter(
      item => selectedOption.id == item.parent_type
    );

    this.setState({
      messageType: selectedOption,
      messages
    });
  };

  handleSelectMessage = message => {
    this.setState({ message });
    this.evaluateChunk(message.select);
  };

  handleSelectOption = chunk => {
    this.setState({ chunk });
  };

  handleSubmit = () => {
    let data = { 
      id_station: this.state.station.id,
      type: this.state.messageType.id,
      direction: this.state.station.address,
      name: this.buildMessage(),
    };
    
    Api.get(
      "/events/create", data,
      rsp => {
        if (rsp.ok) {
          toast.success("Guardado correctamente");
          this.toggle();
          if (typeof this.props.callback === "function")
            this.props.callback();
        } else {
          toast.error(rsp.msg);
        }
      },
      "Guardando..."
    );

    console.log(data);
  }

  // Builders 
  buildMessage = () => {
    let aux = this.state.message.label || '';
    return aux.replace('XXX', this.state.chunk);
  }

  evaluateChunk = select => {
    let aux = select || ''; 
    let chunk = aux.length > 0 ? select.split(',')[0] : '';
    this.setState({ chunk });
  }

  // Renders
  renderMessages = () => {
    let aux = [];

    this.state.messages.forEach(element => {
      let classes = element == this.state.message ? "active" : "";
      aux.push(
        <p
          className={`list ${classes}`}
          onClick={() => this.handleSelectMessage(element)}
        >
          {element.message}
        </p>
      );
    });

    return (
      <Row className="form-group" style={{ display: aux.length > 0 ? "block" : "none" }}>
        <Col md="12">       
          Mensajes <br />
        </Col>
        <Col md="12">
          <div className="messages-box">{aux}</div>
        </Col>
      </Row>
    );
  };

  renderOptions = () => {
    let aux = [];
    let iterator = this.state.message.select || "";
    iterator = iterator.length > 0 ? iterator.split(",") : [];
    
    iterator.forEach(element => {
      let classes = element == this.state.chunk ? "active" : "";
      aux.push(
        <button
          className={`btn btn-outline-secondary btn-select ${classes}`}
          onClick={() => this.handleSelectOption(element)}
        >
          {element}
        </button>
      );
    });

    return (
      <Row className="form-group" style={{ display: iterator.length > 0 ? "block" : "none" }}>
        <Col md="12"> 
          Opciones <br />
        </Col>
        <Col md="12" className="text-center"> 
          {aux}
        </Col>
      </Row>
    );
  };

  render() {
    return (
      <Modal
        isOpen={this.state.modal}
        className={this.props.className}
        backdrop="static"
        keyboard={false}
        size="lg"
      >
        <fieldset disabled={this.state.loading}>
          <ModalHeader toggle={this.toggle}>
            {this.state.item.id > 0 ? "Editar" : "Agregar"} Eventos
          </ModalHeader>
          <ModalBody className="form-horizontal">
            <Alert color="danger" isOpen={this.state.error != ""} fade={true}>
              {this.state.error}
            </Alert>

            <Row className="form-group">
              <Col md="4">Estacion</Col>
              <Col md="8">
                <Select
                  name="station_id"
                  value={this.state.currentOption}
                  options={this.state.stations}
                  onChange={this.handleSelectStation}
                  isMulti={false}
                  placeholder="Buscar..."
                />
              </Col>
            </Row>

            <Row className="form-group">
              <Col md="4">Opcion de envio </Col>
              <Col md="8">
                <Select
                  name="send_option_id"
                  value={this.state.messageType}
                  options={this.state.messageTypes}
                  onChange={this.handleSelectMessageType}
                  isMulti={false}
                  placeholder="Buscar..."
                />
              </Col>
            </Row>

            { this.renderMessages() }

            { this.renderOptions() }

          </ModalBody>
          <ModalFooter>
            <Button
              color="danger"
              style={{ marginRight: "auto" }}
              className={this.state.item.id > 0 ? "" : "none"}
              outline
              onClick={this.remove}
            >
              Eliminar
            </Button>
            <Button color="secondary" outline onClick={this.toggle}>
              Cancelar
            </Button>
            <Button color="primary" onClick={this.handleSubmit}>
              <i className="fa fa-check" /> Guardar
            </Button>
          </ModalFooter>
        </fieldset>
      </Modal>
    );
  }
}
