import React from 'react';
import { connect } from 'react-redux';
import classnames from 'classnames';
import _ from 'lodash';
import { Button, Modal, ModalHeader, ModalBody, ModalFooter, Alert, Input, Label, TabContent, TabPane, Nav, NavItem, NavLink, Row, Col, InputGroup, InputGroupAddon, InputGroupText } from 'reactstrap';
import { closeModal } from '../../actions';
import 'whatwg-fetch';

class TeamSettingModal extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      activeTab: '1',
      backdrop: true,
      passwords: [11, 12, 13, 14, 15, 16, 17, 18, 19, 110, 111, 112, 113, 114]
    };
    this.close = this.close.bind(this);
  }

  componentDidMount() {
    
  }

  close() {
    this.props.closeModal();
  }

  renderPasswordInputs(passwords) {
    var inputList = [];
    for( var i = 1; i <= passwords.length; i++ ) {
      inputList.push(
        <Col sm="3" key={i}>
          <InputGroup>
            <InputGroupAddon addonType="prepend">
              <InputGroupText>
                {i}
              </InputGroupText>
            </InputGroupAddon>
            <Input placeholder={passwords[i-1]} />
          </InputGroup>
        </Col>
      );
    }

    return inputList;
  }

  render() {
    return (
      <Modal isOpen={ (this.props.activeModalClassName == this.props.className) ? true : false } toggle={this.close} className={this.props.className} size="lg">
        <form id="form-team-setting">
          <ModalHeader toggle={this.close}>
            <span>팀설정</span>
            <div className="d-flex align-items-center">
              <Label className="mr-3 mb-0" for="inlineFormInput"> 팀 인원수 : </Label>
              <Input type="number" name="united_team_player_count" id="inlineFormInput" placeholder="0" />
              <Input type="hidden" name="update_united_team_player_count" value="yes" />
            </div>
          </ModalHeader>
          <ModalBody>
            <Alert color="danger">
              주의 : 딥마인드 1을 사용한다면 비밀번호 앞자리가 1로 시작되어야 하며, 2를 사용한다면 2로 시작되어야 합니다
            </Alert>
            <Nav tabs>
              <NavItem>
                <NavLink className={classnames({ active: true })} >
                  비밀번호
                </NavLink>
              </NavItem>
            </Nav>
            <TabContent activeTab={this.state.activeTab}>
              <TabPane tabId="1">
                <Row>
                  { this.renderPasswordInputs(this.state.passwords) }
                </Row>
              </TabPane>
            </TabContent>
          </ModalBody>
          <ModalFooter>
            <Button color="primary" onClick={this.close}>적용</Button>{' '}
            <Button color="secondary" onClick={this.close}>취소</Button>
          </ModalFooter>
        </form>
      </Modal>
    );
  }
}

function mapStateToProps(state, ownProps) {
  return { activeModalClassName : state.activeModalClassName };
}

export default connect(mapStateToProps, { closeModal })(TeamSettingModal);