// defaults
import React from 'react';
import ReactDom from 'react-dom';

import 'babel-polyfill'; // for using async await syntex
import App from './components/app';
import configureStore from './store';

async function fetchInitialSettings () {
  let response = await fetch('/admin/state');
  let json = await response.json();
  console.log( 'json : ', json );

  var result = {};
  _.forEach(json['state'], function(row){
    let key = row['meta_key'];
    let value = row['meta_value'];
    Object.assign(result, { [key]: value});
  });

  return result;
}

async function firstRender() {
  let initialState = {
    meta : await fetchInitialSettings()
  };
  console.log( 'initialState : ', initialState );
  let store = await configureStore(initialState);
  ReactDom.render(
    <App store={store}></App>,
    document.querySelector('#app')
  );
}

firstRender();