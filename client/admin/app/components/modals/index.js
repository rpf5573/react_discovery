import React, { Component } from 'react';
import TimerModal from './timer';
import TeamSettingModal from './team-setting';

class Modals extends Component {
  state = {  }
  render() { 
    return (
      <div className="modals">
        <TeamSettingModal className="modal--team-setting"></TeamSettingModal>
        <TimerModal className="modal--timer"></TimerModal>
      </div>
    );
  }
}
 
export default Modals