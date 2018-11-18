// utils
import 'whatwg-fetch';
import _ from 'lodash';

// react & redux
import React, { Component } from 'react';
import { Provider } from 'react-redux';

// components
import MainMenu from './main-menu';
import MainBoard from './main-board';
import Modals from './modals';

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

    return result;
  }

  componentDidMount() {
    // let result = this.fetchInitialSettings();
    // this.props.updateInitialState( result );
  }

  render() {
    return (
      <Provider store={this.props.store}>
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

export default App;