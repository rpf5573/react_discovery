<!-- Mapping Points Modal -->
<div class="modal fade modal--manager_passwords" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> 관리자 비밀번호 변경 </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-manager_password" action="<?php echo $controller_url; ?>" method="POST">
          <div class="modal--manager_passwords__manager">
            <h6>관리자 비밀번호</h6>
            <div class="row">
              <div class="col-8">
                <input type="number" name="password" class="form-control" placeholder="<?php echo '현재: '.$passwords->manager; ?>">
                <input type="hidden" name="update_manager_password">
              </div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary">확인</button>
              </div>
            </div>
          </div>
        </form>

        <form id="form-assistant_password" action="<?php echo $controller_url; ?>" method="POST">
          <div class="modal--manager_passwords__assistant">
            <h6>보조 관리자 비밀번호</h6>
            <div class="row">
              <div class="col-8">
                <input type="number" name="password" class="form-control" placeholder="<?php echo '현재: '.$passwords->assistant; ?>">
                <input type="hidden" name="update_assistant_password">
              </div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary">확인</button>
              </div>
            </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>