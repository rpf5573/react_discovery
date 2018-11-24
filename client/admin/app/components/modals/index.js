import React, { Component } from 'react';
import TeamSettingModal from './team-setting';
import Maps from './maps';

class Modals extends Component {
  state = {  }
  render() { 
    return (
      <div className="modals">
        <TeamSettingModal className="modal--team-setting"></TeamSettingModal>
        <Maps className="modal--maps"></Maps>
      </div>
    );
  }
}
 
export default Modals