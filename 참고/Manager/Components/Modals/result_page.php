<!-- Result Page Modal -->
<div class="modal fade modal--result_page" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">최종결과</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <?php if ( $total_team_count > 0 ) { ?>
        <iframe src="result.php" style="min-height: 560px;" width="99%" height="99%" frameborder="0" allowtransparency="true"></iframe>
      <?php } else { ?>
        <h5 style="text-align: center; line-height: 100px; font-size: 2em; font-weight: 500;"> 전체 팀수를 먼저 설정해 주세요 </h5>
      <?php } ?>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
