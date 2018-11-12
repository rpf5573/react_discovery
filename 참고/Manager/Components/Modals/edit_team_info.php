<!-- Team Setting Modal -->
<div class="modal fade modal--edit_team_info" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <span> 각팀의 입력 명단 초기화 </span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <?php 
            if ( $total_team_count > 0 ) {
              for ($i=1; $i <= $total_team_count; $i++) {
                $display = 'none';
                $state = $timer_infos[$i-1]['state'];
                if ( $state ) {
                  $display = 'block';
                } ?>

                <div class="col-3 mt-3 mb-3">
                  <div class="btn-group w-100" role="group" aria-label="Basic example">
                    <span class="input-group-addon modal--edit_team_info__team w-20 p-0" data-team="<?php echo $i; ?>"> <?php echo $i; ?> </span>
                    <button type="button" class="btn btn-danger modal--edit_team_info__trigger" data-team="<?php echo $i; ?>">명단 초기화</button>
                  </div>
                </div>

                <!-- End for -->
                <?php } ?>

                <!-- End if -->
                <?php } else { ?>

                <div style="text-align: center; line-height: 100px; font-size: 2em; font-weight: 500; width: 100%;">
                  전체 팀 수를 먼저 설정해 주세요
                </div>

                <?php } ?>
          </div>
        </div>
      </div>
      <div class="modal-footer text-right">
        <!-- <button type="button" class="btn btn-danger">Reset</button> -->
        <button type="submit" class="btn btn-success">확인</button>
      </div>
    </div>
  </div>
</div>