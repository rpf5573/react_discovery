import React from 'react';
import { connect } from 'react-redux';
import classnames from 'classnames';
import _ from 'lodash';
import { Button, Modal, ModalHeader, ModalBody, ModalFooter, Alert, Input, TabContent, TabPane, Nav, NavItem, NavLink, Row, Col, InputGroup, InputGroupAddon, InputGroupText, FormGroup, Label } from 'reactstrap';
import { closeModal } from '../../actions';
import 'whatwg-fetch';

class Maps extends React.Component {

  constructor(props) {
    super(props);
    this.passwordInputFields = [];
    this.state = {
      companyImage: null,
      map: null
    };
    this.close = this.close.bind(this);
    this.companyImageFileSelectHandler = this.companyImageFileSelectHandler.bind(this);
  }

  close() {
    this.props.closeModal();
  }

  async companyImageFileSelectHandler(e) {
    const companyImage = e.target.files[0];
    console.log( 'companyImage : ', companyImage );
    const fd = new FormData();
    fd.append('companyImage', companyImage, companyImage.name);
    const response = await fetch('/admin/upload', {
      method: 'POST',
      body: fd
    });

    console.log( 'response : ', response );

    if ( response.status == 201 ) {
      alert("성공");
    } else {
      alert("알 수 없는 에러가 발생하였습니다");
    }
  }

  render() {
    return (
      <Modal isOpen={ (this.props.activeModalClassName == this.props.className) ? true : false } toggle={this.close} className={this.props.className} size="md">
        <ModalHeader toggle={this.close}>
          <span>이미지 설정</span>
        </ModalHeader>
        <ModalBody>
          <Row>
            <FormGroup>
              <Col>
                <Label>회사 이미지 업로드</Label>
              </Col>
              <Col>
                <input style={{display:'none'}} className="form-control" type="file" onChange={this.companyImageFileSelectHandler} ref={fileInput => this.fileInput = fileInput}/>
                <Button color="success" onClick={() => this.fileInput.click()}>파일 선택</Button>
              </Col>
            </FormGroup>
          </Row>
          <Row></Row>
        </ModalBody>
      </Modal>
    );
  }
}

function mapStateToProps(state, ownProps) {
  return { 
    activeModalClassName : state.activeModalClassName,
  };
}

export default connect(mapStateToProps, { closeModal })(Maps);