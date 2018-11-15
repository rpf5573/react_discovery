// utils
import 'whatwg-fetch';
import _ from 'lodash';

// react & redux
import React, { Component } from 'react';
import { BrowserRouter, Route } from 'react-router-dom';
import { Provider, connect } from 'react-redux';
import store from '../store';

// components
import { Container, Row, Col } from 'reactstrap';
import MainMenu from './main-menu';
import MainBoard from './main-board';
import Modals from './modals';

// actions
import { updateInitialState } from '../actions/initial-state-actions';

// css
import 'bootstrap/dist/css/bootstrap.css';
import '../scss/style.scss';

class App extends Component {

  async fetchInitialSettings() {
    let response = await fetch('/admin/state');
    let json = await response.json();

    var result = {};
    _.forEach(json, function(row){
      let key = row['meta_key'];
      let value = row['meta_value'];
      Object.assign(result, {key: value});
    });

    console.log( 'result : ', result );

    return result;
  }

  componentDidMount() {
    let result = this.fetchInitialSettings();
    this.props.updateInitialState( result );
  }

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
          <Modals></Modals>
        </div>
      </Provider>
    );
  }

}

export default connect(null, { updateInitialState })(App);