import React from 'react';
import { connect } from 'react-redux';
import classnames from 'classnames';
import _ from 'lodash';
import { Button, Modal, ModalHeader, ModalBody, ModalFooter, Alert, Input, TabContent, TabPane, Nav, NavItem, NavLink, Row, Col, InputGroup, InputGroupAddon, InputGroupText } from 'reactstrap';
import { closeModal } from '../../actions';
import 'whatwg-fetch';

class TeamSetting extends React.Component {

  constructor(props) {
    super(props);
    this.passwordInputFields = [];
    this.state = {
      activeTab: '1',
      backdrop: true,
    };
    this.close = this.close.bind(this);
    this.toggle = this.toggle.bind(this);
    this.handleFormSubmit = this.handleFormSubmit.bind(this);
    this.handleInput = this.handleInput.bind(this);
  }

  close() {
    this.props.closeModal();
  }

  toggle(tab) {
    if (this.state.activeTab !== tab) {
      this.setState({
        activeTab: tab
      });
    }
  }

  updatePasswords() {
  }

  async handleFormSubmit(e) {
    e.preventDefault();
    if ( this.passwordInputFields.length > 0 ) {
      // validation
      // 중복 검사 - placeholder도 검사해 줘야합니다
      for( var i = 0; i < this.passwordInputFields.length; i++ ) {
        let input = this.passwordInputFields[i];
        var l = parseInt(input.placeholder);
        if ( input.value > 0 ) {
          l = input.value;
        }
        if ( l > 0 ) {
          for( var z = i+1; z < this.passwordInputFields.length; z++ ) {
            let nextInput = this.passwordInputFields[z];
            var r = nextInput.placeholder;
            if ( nextInput.value > 0 ) {
              r = nextInput.value;
            }
            // placeholder끼리 비교하는 경우도 있지만,,, 뭐 어때 ! 그 둘은 절대 같을 일이 없을 텐데 ㅎㅎ
            if ( l == r ) {
              alert('중복된 비밀번호가 있습니다. 다시 확인해 주시기 바랍니다');
              return;
            }
          } 
        }
      }

      // 이제 값 추출
      var team_passwords = [];
      for( var i = 0; i < this.passwordInputFields.length; i++ ) {
        if ( this.passwordInputFields[i].value > 0 ) {
          team_passwords.push({
            team: (i+1),
            password: this.passwordInputFields[i].value
          });
        }
      }

      let response = await fetch('/admin/post/team_passwords', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          team_passwords: team_passwords
        })
      });

      if ( response.status == 201 ) {
        for ( var i = 0; i < team_passwords.length; i++ ) {
          let index = team_passwords[i].team - 1;
          let value = team_passwords[i].password;
          this.passwordInputFields[index].placeholder = value;
          this.passwordInputFields[index].value = '';
        }

        alert( "성공" );
        return;
      }

      alert("알수없는 에러가 발생하였습니다");

    }
  }

  handleInput(e) {

  }

  renderPasswordInputs(passwords) {
    console.log( 'passwords : ', passwords );
    var inputList = [];
    if ( typeof passwords !== 'undefined' ) {
      for( var i = 1; i <= passwords.length; i++ ) {
        inputList.push(
          <Col sm="3" key={i}>
            <InputGroup>
              <InputGroupAddon addonType="prepend">
                <InputGroupText>
                  {i}
                </InputGroupText>
              </InputGroupAddon>
              <input type="number" className="form-control" placeholder={passwords[i-1].password} ref={(input) => this.passwordInputFields.push(input)} />
            </InputGroup>
          </Col>
        );
      }
    }

    return inputList;
  }

  render() {

    console.log( 'props : ', this.props );

    return (
      <Modal isOpen={ (this.props.activeModalClassName == this.props.className) ? true : false } toggle={this.close} className={this.props.className} size="lg">
        <form id="form-team-setting" onSubmit={this.handleFormSubmit}>
          <ModalHeader toggle={this.close}>
            <span>팀설정</span>
          </ModalHeader>
          <ModalBody>
            <Alert color="danger">
              주의 : 딥마인드 1을 사용한다면 비밀번호 앞자리가 1로 시작되어야 하며, 2를 사용한다면 2로 시작되어야 합니다
            </Alert>
            <Nav tabs>
              <NavItem>
                <NavLink 
                  className={classnames({ active: this.state.activeTab === '1' })} 
                  onClick={() => { this.toggle('1'); }}
                >
                  비밀번호
                </NavLink>
              </NavItem>
            </Nav>
            <TabContent activeTab={this.state.activeTab}>
              <TabPane tabId="1">
                <Row>
                  { this.renderPasswordInputs(this.props.team_passwords) }
                </Row>
              </TabPane>
            </TabContent>
          </ModalBody>
          <ModalFooter>
            <Button color="primary" type="submit">적용</Button>{' '}
            <Button color="secondary" onClick={this.close}>취소</Button>
          </ModalFooter>
        </form>
      </Modal>
    );
  }
}

function mapStateToProps(state, ownProps) {
  return { 
    activeModalClassName : state.activeModalClassName,
    team_passwords : state.team_passwords
  };
}

export default connect(mapStateToProps, { closeModal })(TeamSetting);