<!-- Timer Modal -->
<div class="modal fade modal--timer" tabindex="-1" role="dialog" aria-hidden="true">
  <?php 
  $timer_deadline = (TB_Meta::get_timer_deadline())->value;
  $timer_deadline_minute = intval($timer_deadline/60 );
  $timer_deadline_second = $timer_deadline%60;
  ?>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title d-flex justify-content-between align-items-center pr-4" id="exampleModalLabel" style="flex: 1;">
          <span>타이머</span>
          <form role="form" class="mb-0">
            <div class="d-flex">
              <span class="mr-2">
                딥마인드 교육 :
              </span>
              <div class="radio abc-radio abc-radio-primary">
                <input type="radio" name="checkbox-game_state" id="checkbox-on-game_state" value="option1" <?php if ( $game_state ) { echo 'checked'; } ?>>
                <label for="checkbox-on-game_state">시작</label>
              </div>
              <div class="radio abc-radio abc-radio-danger">
                <input type="radio" name="checkbox-game_state" id="checkbox-off-game_state" value="option2" <?php if ( !$game_state ) { echo 'checked'; } ?>>
                <label for="checkbox-off-game_state">종료</label>
              </div>
            </div>
          </form>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container d-none">
          <div class="row mb-5 mt-1 flex-nowrap justify-content-end">
            <div class="modal--timer__deadline_setting">
            </div>
            <div class="modal--timer__all_control d-flex" style="<?php if ( $total_team_count == 0 ) { echo 'display: none;'; } ?>">
              <button type="button" class="btn btn-success btn-all-start mr-2">전체 시작</button>
              <button type="button" class="btn btn-danger btn-all-end">전체 종료</button>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row modal--timer__controls">
            <?php 
            if ( $total_team_count > 0 ) {
              for ($i=1; $i <= $total_team_count; $i++) {
                $display = 'none';
                $state = $timer_infos[$i-1]['state'];
                if ( $state ) {
                  $display = 'block';
                } ?>

                <div class="col-3 mt-3 mb-3 timer_control__container">
                  <div class="btn-group modal--timer__each_team_control w-100" role="group" aria-label="Basic example">
                    <span class="input-group-addon modal--timer__each_team_control__team w-20 p-0" data-team="<?php echo $i; ?>"> <?php echo $i; ?> </span>

                    <!-- 각 팀별로는 타이머 종료하지 않습니다 -->
                    <!-- <button type="button" class="btn <?php if ( $state ) { echo 'btn-danger'; } else { echo 'btn-secondary'; } ?> modal--timer__each_team_control__control w-62""><?php if ( $state ) { echo 'End'; } else { echo '준비중'; } ?></button> -->

                    <button type="button" class="btn <?php if ( $state ) { echo 'btn-info'; } else { echo 'btn-secondary'; } ?> modal--timer__each_team_control__control w-62""><?php if ( $state ) { echo '가동중'; } else { echo '준비중'; } ?></button>

                    <button type="button" class="btn btn-secondary modal--timer__each_team_control__clock w-18" style="display: <?php echo $display; ?>; ">
                      <div class="cssload-clock"></div>
                    </button>
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
        </div>
      </div>
    </div>
  </div>
</div>