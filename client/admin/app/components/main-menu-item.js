import React, { Component } from 'react';
import { connect } from 'react-redux';
import _ from 'lodash';
import cn from 'classnames';
import { MENU_ITEM_TOGGLE_ACTIVE } from '../actions/types';
// import { menuItemToggleActive } from '../actions/menu-item-actions';
import MainMenu from './main-menu';

class MainMenuItem extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isActive: false
    }
    
    this.onClickBtn = this.onClickBtn.bind(this);
  }

  onClickBtn(e) {
    this.props.dispatch({
      type: MENU_ITEM_TOGGLE_ACTIVE,
      payload: this.props.className
    });
  }

  render() {
    let className = cn('menu-item', ('menu-item--'+this.props.className), { 'is-active' : this.props.isActive });
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

function mapStateToProps(state, ownProps) {
  if ( state.btnKey == ownProps.className ) {
    return {
      isActive : state.isActive
    };
  }

  return {};
}

export default connect(mapStateToProps, null)(MainMenuItem);