import React, { Component } from 'react';
import { connect } from 'react-redux';
import _ from 'lodash';
import cn from 'classnames';
import { menuItemToggleActive } from '../actions/menu-item-actions';
import MainMenu from './main-menu';

class MainMenuItem extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isActive: false
    }

    this.toggleActive = this.toggleActive.bind(this);
  }

  toggleActive(e) {
    console.log( 'e : ', e );
  }

  render() {
    let className = cn('menu-item', ('menu-item'+this.props.className));
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
 
export default connect(null, { menuItemToggleActive })(MainMenuItem);