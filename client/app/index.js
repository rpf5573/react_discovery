const React = require('react');
const ReactDOM = require('react-dom');
require('./index.css');

class App extends React.Component {
  render() {
    return(
      <div>
        Nice To Meet You !
      </div>
    );
  }
}

ReactDOM.render(
  <App />,
  document.getElementById('app')
);