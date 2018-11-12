<!-- Team Player Counts - input -->
<div class="col-3 mt-3 team_player_counts__input_container prototype">
  <div class="input-group w-100">
    <span class="input-group-addon w-20 p-0" data-team='0'></span>
    <input type="number" class="form-control w-80" name="team_player_counts[]">
  </div>
</div>

<!-- Team Passwords - input -->
<div class="col-3 mt-3 team_passwords__input_container prototype">
  <div class="input-group w-100">
    <span class="input-group-addon w-20 p-0" data-team='0'></span>
    <input type="number" class="form-control w-80" name="team_passwords[]">
  </div>
</div>

<!-- Timer Modal - Control Input -->
<div class="col-3 mb-3 timer_control__container prototype">
  <div class="btn-group modal--timer__each_team_control mb-3 w-100" role="group" aria-label="Basic example">
    <span class="input-group-addon modal--timer__each_team_control__team w-20 p-0" data-team='0'>0</span>
    <button type="button" class="btn btn-secondary modal--timer__each_team_control__control ready w-62">Ready</button>
    <button type="button" class="btn btn-secondary modal--timer__each_team_control__clock w-18" style="width: 18%;">
      <div class="cssload-clock"></div>
    </button>
  </div>
</div>

<!-- 점수 배정표 에서 수정버튼 누르면 나오는 Input Box -->
<div class="modal--mapping_points__point-editmode prototype">
  <input type="text" placeholder="" class="form-control modal--mapping_points__point-editmode__input-box d-inline-block" style="max-width: 100px;">
  <button class="btn btn-secondary btn-sm modal--mapping_points__point-editmode__cancle-btn">취소</button>
  <button class="btn btn-primary btn-sm modal--mapping_points__point-editmode__complete-btn">완료</button>
</div>

<!-- Uploaded Image File Prototype -->
<div class="evaluate_uploaded_file evaluate_uploaded_file--img col-5 prototype align-self-start">
  <span class="team">
  </span>
  <div class="uploaded_file">
    <img src="">
  </div>
  <div class="point_form">
    <form id="form-evaluate_uploaded_file--img" action="<?php echo $controller_url; ?>" method="POST" class="container">
      <div class="row">
        <div class="col-2"></div>
        <div class="col-5">
          <input type="number" name="point" class="form-control">
          <input type="hidden" name="evaluate_uploaded_file">
          <input type="hidden" name="team">
          <input type="hidden" name="file_name">
        </div>
        <div class="col-3">
          <button type="submit" class="btn btn-primary">점수제공</button>
        </div>
        <div class="col-2"></div>
      </div>
    </form>
  </div>
</div>

<!-- Uploaded Video File Prototype -->
<div class="evaluate_uploaded_file evaluate_uploaded_file--video col-5 prototype align-self-start">
  <span class="team">
  </span>
  <div class="uploaded_file">
    <video controls src="<?php echo BASE_URL.'/Resources/Images/white.png' ?>" preload="metadata" id="piece" type="video/mp4">
  </div>
  <div class="point_form">
    <form id="form-evaluate_uploaded_file--video" action="<?php echo $controller_url; ?>" method="POST" class="container">
      <div class="row">
        <div class="col-2"></div>
        <div class="col-5">
          <input type="number" name="point" class="form-control">
          <input type="hidden" name="evaluate_uploaded_file">
          <input type="hidden" name="team">
          <input type="hidden" name="file_name">
        </div>
        <div class="col-3">
          <button type="submit" class="btn btn-primary">점수제공</button>
        </div>
        <div class="col-2"></div>
      </div>
    </form>
  </div>
</div>

<!-- beacon data table row -->
