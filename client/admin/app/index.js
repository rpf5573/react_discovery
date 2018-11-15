// defaults
import React from 'react';
import ReactDom from 'react-dom';

import 'babel-polyfill'; // for async error
import App from './components/app';

ReactDom.render(
  <App/>,
  document.querySelector('#app')
);