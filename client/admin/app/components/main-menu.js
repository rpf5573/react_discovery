import React, { Component } from 'react';
import _ from 'lodash';
import { connect } from 'react-redux';
import MainMenuItem from './main-menu-item';

export default class MainMenu extends Component {

  constructor(props) {
    super(props);
    
  }

  createMenu() {
    let menuList = [
      {label: "팀설정", className: "team-setting"},
      {label: "교육시작/종료", className: "timer"},
      {label: "옵션설정", className: "options"},
      {label: "지도설정", className: "maps"},
      {label: "본부 점수 제공", className: "points"},
      {label: "최종결과", className: "result-page"},
      {label: "점수배정표", className: "mapping-point"},
      {label: "관리자 비밀번호", className: "manager-password"},
      {label: "초기화", className: "reset"},
    ];

    var tagList = [];
    _.forEach(menuList, (menuItem) => {
      tagList.push(
        <MainMenuItem className={menuItem.className} label={menuItem.label} key={menuItem.className}></MainMenuItem>
      );
    });
    return tagList;
  }

  render() {
    return (
      <ul className="main-menu list-unstyled">
        {this.createMenu()}
      </ul>
    );
  }
}