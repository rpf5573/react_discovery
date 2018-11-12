<!-- Team Setting Modal -->
<div class="modal fade modal--team_settings" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="form-team_settings" class="modal-content" action="<?php echo $controller_url; ?>" method="POST">
      <div class="modal-header">
        <h5 class="modal-title d-flex justify-content-between align-items-center w-100 pr-4" id="exampleModalLabel">
          <span> 팀 설정 </span>
          <div class="d-flex align-items-center">
            <label class="mr-3 mb-0" for="inlineFormInput"> 팀 인원수 : </label>
            <input type="number" name="united_team_player_count" class="form-control" id="inlineFormInput" placeholder="<?php echo $united_team_player_count; ?>">
            <input type="hidden" name="update_united_team_player_count" value="yes">
          </div>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="modal--team_settings__notice">
          팀설정에서 딥마인드 1사용시 각 팀의<span class="modal--team_settings__notice__highlight"> 비번앞자리가 1 </span>로 시작되어야합니다.
        </h4>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tab-pane--team_passwords" role="tab">비밀번호</a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content modal--team_settings__tab-content">
          <div class="tab-pane active" id="tab-pane--team_passwords" role="tabpanel">
            <div class="row">
              <?php for ($i=0; $i < 20; $i++) { $team = $i + 1; ?>
              <div class="col-3 mt-3 team_passwords__input_container">
                <div class="input-group w-100">
                  <span class="input-group-addon w-20 p-0" data-team="<?php echo $team; ?>"> <?php echo $team; ?> </span>
                  <input type="number" class="form-control w-80" name="team_passwords[]" placeholder="<?php echo $team_passwords[$i]; ?>">
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer text-right">
        <!-- <button type="button" class="btn btn-danger">Reset</button> -->
        <button type="submit" class="btn btn-success">확인</button>
      </div>
    </form>
  </div>
</div>