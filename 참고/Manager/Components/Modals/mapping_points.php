<!-- 점수 배정표 체크 모달 입니다 -->
<div class="modal fade modal--mapping_points" tabindex="-1" role="dialog">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">점수 배정표</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped sortable">
          <thead>
            <tr> 
              <th colspan="3" data-mainsort="1" data-firstsort="desc" class="nosort" data-sortcolumn="1" data-sortkey="1-1">항목</th>
              <th colspan="1" data-mainsort="1" data-firstsort="desc" class="nosort" data-sortcolumn="1" data-sortkey="1-1">점수</th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td colspan="3"><h6><span> 시간점수 +30초 </span></h6></td>
              <td colspan="1" class="modal--mapping_points__point_box"> <span data-point_info='{"update_mapping_points": "true", "mapping_key": "time_plus", "point":"<?php echo $mapping_points->time_plus; ?>"}'> <?php echo $mapping_points->time_plus; ?> </span> <button class="btn btn-success btn-sm ml-5 modal--mapping_points__point_box__modification-btn">수정</button> </td>
            </tr>

            <tr>
              <td colspan="3"><h6><span> 시간점수 -30초 </span></h6></td>
              <td colspan="1" class="modal--mapping_points__point_box"> <span data-point_info='{"update_mapping_points": "true", "mapping_key": "time_minus", "point":"<?php echo $mapping_points->time_minus; ?>"}'> <?php echo "(-)".$mapping_points->time_minus; ?> </span> <button class="btn btn-success btn-sm ml-5 modal--mapping_points__point_box__modification-btn">수정</button> </td>
            </tr>

            <tr>
              <td colspan="3"><h6><span> 업로드 </span></h6></td>
              <td colspan="1" class="modal--mapping_points__point_box"> <span data-point_info='{"update_mapping_points": "true", "mapping_key": "upload", "point":"<?php echo $mapping_points->upload; ?>"}'> <?php echo $mapping_points->upload; ?> </span> <button class="btn btn-success btn-sm ml-5 modal--mapping_points__point_box__modification-btn">수정</button> </td>
            </tr>

            <tr>
              <td colspan="3"><h6><span> 조커정보구매 점수 </span></h6></td>
              <td colspan="1" class="modal--mapping_points__point_box"> <span data-point_info='{"update_mapping_points": "true", "mapping_key": "joker_info", "point":"<?php echo $mapping_points->joker_info; ?>"}'> <?php echo $mapping_points->joker_info; ?> </span> <button class="btn btn-success btn-sm ml-5 modal--mapping_points__point_box__modification-btn">수정</button> </td>
            </tr>

            <tr>
              <td colspan="3"><h6><span> 활동제한사용점수 </span></h6></td>
              <td colspan="1" class="modal--mapping_points__point_box"> <span data-point_info='{"update_mapping_points": "true", "mapping_key": "out_cost", "point":"<?php echo $mapping_points->out_cost; ?>"}'> <?php echo $mapping_points->out_cost; ?> </span> <button class="btn btn-success btn-sm ml-5 modal--mapping_points__point_box__modification-btn">수정</button> </td>
            </tr>

            <tr>
              <td colspan="3"><h6><span> 일반팀원제한 획득점수 </span></h6></td>
              <td colspan="1" class="modal--mapping_points__point_box"> <span data-point_info='{"update_mapping_points": "true", "mapping_key": "member_out", "point":"<?php echo $mapping_points->member_out; ?>"}'> <?php echo $mapping_points->member_out; ?> </span> <button class="btn btn-success btn-sm ml-5 modal--mapping_points__point_box__modification-btn">수정</button> </td>
            </tr>

            <tr>
              <td colspan="3"><h6><span> 조커제한 획득점수 </span></h6></td>
              <td colspan="1" class="modal--mapping_points__point_box"> <span data-point_info='{"update_mapping_points": "true", "mapping_key": "joker_out", "point":"<?php echo $mapping_points->joker_out; ?>"}'> <?php echo $mapping_points->joker_out; ?> </span> <button class="btn btn-success btn-sm ml-5 modal--mapping_points__point_box__modification-btn">수정</button> </td>
            </tr>

            <tr>
              <td colspan="3"><h6><span> 일반 팀원의 점수 </span></h6></td>
              <td colspan="1" class="modal--mapping_points__point_box"> <span data-point_info='{"update_mapping_points": "true", "mapping_key": "member_ransom", "point":"<?php echo $mapping_points->member_ransom; ?>"}'> <?php echo $mapping_points->member_ransom; ?> </span> <button class="btn btn-success btn-sm ml-5 modal--mapping_points__point_box__modification-btn">수정</button> </td>
            </tr>

            <tr>
              <td colspan="3"><h6><span> 조커의 점수 </span></h6></td>
              <td colspan="1" class="modal--mapping_points__point_box"> <span data-point_info='{"update_mapping_points": "true", "mapping_key": "joker_ransom", "point":"<?php echo $mapping_points->joker_ransom; ?>"}'> <?php echo $mapping_points->joker_ransom; ?> </span> <button class="btn btn-success btn-sm ml-5 modal--mapping_points__point_box__modification-btn">수정</button> </td>
            </tr>

          </tbody>
        </table>

      </div>
    </div>
  </div>

</div>