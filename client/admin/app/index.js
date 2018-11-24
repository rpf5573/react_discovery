// defaults
import React from 'react';
import ReactDom from 'react-dom';

import 'babel-polyfill'; // for using async await syntex
import App from './components/app';
import configureStore from './store';

async function fetchInitialSettings () {
  let response = await fetch('/admin/state');
  let initialState = await response.json();

  return initialState;
}

async function firstRender() {
  let initialState = await fetchInitialSettings();
  let store = await configureStore(initialState);
  ReactDom.render(
    <App store={store}></App>,
    document.querySelector('#app')
  );
}

firstRender();