import React, { Component } from 'react';
import { connect } from 'react-redux';
import _ from 'lodash';
import cn from 'classnames';
import { OPEN_MODAL } from '../actions/types';
import { openModal, makeAllInActive } from '../actions/menu-item-actions';
import MainMenu from './main-menu';

class MainMenuItem extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isActive: false
    }

    this.onClickBtn = this.onClickBtn.bind(this);
    this.toggleActive = this.toggleActive.bind(this);
  }

  onClickBtn(e) {
    this.props.makeAllInActive();
    // this.props.openModal();
    this.toggleActive();
  }

  toggleActive(e) {
    this.setState({
      isActive: !this.state.isActive
    });
  }

  render() {
    console.log( 'render', ' is called' );
    let className = cn('menu-item', ('menu-item--'+this.props.className), { 'is-active' : this.state.isActive });
    return (
      <li className={className} key={this.props.className}>
        <button onClick={this.onClickBtn}>
          {this.props.label}
          <div className="ripple js-ripple">
            <span className="ripple__circle"></span>
          </div>
        </button>
      </li>
    );
  }
}

function mapStateToProps(state, action) {
  console.log( 'state in mapStateToProps: ', state );
  return { isActive : state.isActive };
}


export default connect(mapStateToProps, { openModal, makeAllInActive })(MainMenuItem);