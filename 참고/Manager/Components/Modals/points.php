<!-- Points Modal -->
<div class="modal fade modal--points" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title d-flex justify-content-between align-items-center w-100 pr-4">
          <span class="d-inline"> 본부 점수 제공 </span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php if ( $total_team_count == 0 ) { ?>
        <div style="text-align: center; line-height: 100px; font-size: 2em; font-weight: 500;">
          전체 팀 수를 먼저 설정해 주세요
        </div>
        <?php } else { ?>
        <form id="form-points" class="row" action="<?php echo $controller_url; ?>" method="POST">
          <?php for ($i=0; $i < $total_team_count; $i++) { $team = $i + 1; ?>
          <div class="col-3 mt-3 points__input_container">
            <div class="input-group w-100">
              <span class="input-group-addon w-20 p-0" data-team="<?php echo $i; ?>"> <?php echo $team; ?> </span>
              <input type="number" class="form-control w-80" name="points[]" data-team="<?php echo $team; ?>" data-point="<?php echo $team_points[$i]['usable']; ?>">
            </div>
          </div>
          <?php } ?>
          <input type="hidden" name="update_points" value="true">
          <input type="hidden" name="total_team_count" value="<?php echo $total_team_count; ?>">
        </form>
        <?php } ?>

      </div>
      <div class="modal-footer text-right">
        <button type="button" class="btn btn-success">점수제공</button>
      </div>
    </div>
  </div>
</div>