<!-- Options Modal -->
<div class="modal fade modal--options" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">옵션 설정</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Player List -->
        <div class="modal--options__player_list mb-5">
          <div class="modal--options__player_list__header d-flex justify-content-between align-items-center mb-5 pb-2">
            <h6 class="text-left"> 명단 입력 </h6>
            <form role="form" class="mb-0">
              <div class="d-flex">
                <div class="radio abc-radio abc-radio-primary">
                  <input type="radio" name="checkbox-player_list" id="checkbox-on-player_list" value="option7" <?php if ( $options->player_list
                  ) { echo 'checked'; } ?>>
                  <label for="checkbox-on-player_list">ON</label>
                </div>
                <div class="radio abc-radio abc-radio-danger">
                  <input type="radio" name="checkbox-player_list" id="checkbox-off-player_list" value="option8" <?php if ( !$options->player_list
                  ) { echo 'checked'; } ?>>
                  <label for="checkbox-off-player_list">OFF</label>
                </div>
              </div>
            </form>
          </div>
          <div class="modal--options__player_list__body" style="<?php if ( ! $options->player_list ) { echo 'display:none';  } ?>">

            <!-- Joker Info -->
            <div class="modal--options__joker_info mb-5">
              <div class="modal--options__joker_info__header d-flex justify-content-between align-items-center pb-2">
                <h6> 조커 질문 입력 </h6>
                <form role="form" class="mb-0">
                  <div class="d-flex">
                    <div class="radio abc-radio abc-radio-primary">
                      <input type="radio" name="checkbox-joker_info" id="checkbox-on-joker_info" value="option1" <?php if ( $options->joker_info
                      ) { echo 'checked'; } ?>>
                      <label for="checkbox-on-joker_info">ON</label>
                    </div>
                    <div class="radio abc-radio abc-radio-danger">
                      <input type="radio" name="checkbox-joker_info" id="checkbox-off-joker_info" value="option2" <?php if ( !$options->joker_info
                      ) { echo 'checked'; } ?>>
                      <label for="checkbox-off-joker_info">OFF</label>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal--options__joker_info__body pt-3" style="<?php if ( ! $options->joker_info ) { echo 'display:none';  } ?>">
                <div class="modal--options__joker_info__body__questions row">
                  <div class="col-2"></div>
                  <div class="col-10">
                    <form id="form-joker_info_questions" class="row" action="<?php echo $controller_url; ?>" method="POST">
                      <?php for( $i = 0; $i < 6; $i++ ) { ?>
                      <div class="col-12">
                        <div class="input-group modal--options__joker_info__body__questions__question_setting mb-2">
                          <span class="input-group-addon p-0" data-team="1"> <?php echo ($i+1); ?> </span>
                          <input type="text" class="form-control" id="<?php echo 'modal--options__joker_info__body__questions__question_setting__input'.($i+1); ?>"
                            name="joker_info_questions[]" placeholder="<?php if ( isset($joker_info_questions[$i]) ) { echo $joker_info_questions[$i]; } ?>">
                        </div>
                      </div>
                      <!-- <div class="modal--options__joker_info__body__questions__question_setting col-12 mb-2">
                          <div class="media">
                            <label class="d-flex align-self-center mr-3" for="<?php echo 'modal--options__joker_info__body__questions__question_setting__input'.($i+1); ?>"><?php echo ($i+1)."번째 질문 : "; ?></label>
                            <div class="media-body">
                              <input type="text" id="<?php echo 'modal--options__joker_info__body__questions__question_setting__input'.($i+1); ?>" name="joker_info_questions[]" placeholder="<?php if ( isset($joker_info_questions[$i]) ) { echo $joker_info_questions[$i]; } ?>" class="form-control">
                            </div>
                          </div>
                        </div> -->
                      <?php } ?>
                      <div class="col-12 complete-btn-container text-right">
                        <button type="submit" class="btn btn-primary btn-complete"> 확인 </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Test Mode -->
        <div class="modal--options__test_mode__header d-flex justify-content-between align-items-center mb-5 pb-2">
          <h6 class="text-left"> 테스트 모드 </h6>
          <form role="form" class="mb-0">
            <div class="d-flex">
              <div class="radio abc-radio abc-radio-primary">
                <input type="radio" name="checkbox-test_mode" id="checkbox-on-test_mode" value="option5" <?php if ( $options->test_mode
                ) { echo 'checked'; } ?>>
                <label for="checkbox-on-test_mode">ON</label>
              </div>
              <div class="radio abc-radio abc-radio-danger">
                <input type="radio" name="checkbox-test_mode" id="checkbox-off-test_mode" value="option6" <?php if ( !$options->test_mode
                ) { echo 'checked'; } ?>>
                <label for="checkbox-off-test_mode">OFF</label>
              </div>
            </div>
          </form>
        </div>

        <!-- Beacon -->
        <div class="modal--options__beacon">
          <div class="modal--options__beacon__header d-flex justify-content-between align-items-center pb-2">
            <h6 class="text-left"> 비콘 사용 </h6>
            <form role="form" class="mb-0">
              <div class="d-flex">
                <div class="radio abc-radio abc-radio-primary">
                  <input type="radio" name="checkbox-beacon" id="checkbox-on-beacon" value="option1" <?php if ( $options->beacon
                  ) { echo 'checked'; } ?>>
                  <label for="checkbox-on-beacon">ON</label>
                </div>
                <div class="radio abc-radio abc-radio-danger">
                  <input type="radio" name="checkbox-beacon" id="checkbox-off-beacon" value="option2" <?php if ( !$options->beacon
                  ) { echo 'checked'; } ?>>
                  <label for="checkbox-off-beacon">OFF</label>
                </div>
              </div>
            </form>
          </div>
          <!-- Beacon Body -->
          <div class="modal--options__beacon__body">
            <!-- 자꾸 테이블이 아래로 내려가서 이렇게 가둬놓음 -->
            <div>
              <table class="table table-hover modal--options__beacon__body__beacon_list" style="<?php if ( ! $options->beacon ) { echo 'display:none';  } ?>">
                <thead>
                  <tr>
                    <th>POST</th>
                    <th>미션이름</th>
                    <th>비콘 정보 주소</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($beacon_datas as $data) { ?>
                  <tr class="modal--options__beacon__body__beacon_list__row" data-post="<?php echo $data['post']; ?>">
                    <th scope="row" class="modal--options__beacon__body__beacon_list__row__data modal--options__beacon__body__beacon_list__row__data--post">
                      <span> <?php echo $data['post']; ?> </span>
                      <input type="text" name="post" class="form-control" value="<?php echo $data['post']; ?>">
                    </th>
                    <td class="modal--options__beacon__body__beacon_list__row__data modal--options__beacon__body__beacon_list__row__data--item">
                      <span> <?php echo $data['item']; ?> </span>
                      <input type="text" name="item" class="form-control" value="<?php echo $data['item']; ?>">
                    </td>
                    <td class="modal--options__beacon__body__beacon_list__row__data modal--options__beacon__body__beacon_list__row__data--url">
                      <span> <?php echo $data['url']; ?> </span>
                      <input type="text" name="url" class="form-control" value="<?php echo $data['url']; ?>">
                    </td>
                    <td class="d-flex" style="min-width: 120px;">
                      <button type="button" class="btn btn-outline-warning modal--options__beacon__body__beacon_list__row__update btn-sm"> 수정 </button>
                      <button type="button" class="btn btn-outline-danger modal--options__beacon__body__beacon_list__row__remove btn-sm ml-2"> 삭제 </button>
                      <button type="button" class="btn btn-success modal--options__beacon__body__beacon_list__row__complete btn-sm"> 완료 </button>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="d-flex">
              <button class="fg-1 modal--options__beacon__body__beacon_list__add btn btn-secondary" type="button"> 비콘 추가 </button>
            </div>
          </div>
          <!-- Beacon Body __ End -->
        </div>
      </div>
    </div>
  </div>
</div>