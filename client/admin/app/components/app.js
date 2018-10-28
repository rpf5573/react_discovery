import React, { Component } from 'react';

// redux
import { BrowserRouter, Route } from 'react-router-dom';
import { Provider } from 'react-redux';
import store from '../store';

// components
import { Container, Row, Col } from 'reactstrap';
import MainMenu from './main-menu';
import MainBoard from './main-board';

// actions
import actions from '../actions';

// css
import 'bootstrap/dist/css/bootstrap.css';
import '../scss/style.scss';

export default class App extends Component {

  render() {
    return (
      <Provider store={store}>
        <div className="page">
          <div className="sidebar">
            <MainMenu></MainMenu>
          </div>
          <div className="main">
            <MainBoard></MainBoard>
          </div>
        </div>
      </Provider>
    );
  }

}