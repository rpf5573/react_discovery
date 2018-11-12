<?php
$dirs = [
  'whole'       =>  '../User/Whole_Map/',
  'posts'       =>  '../User/Posts/',
  'assistant'   =>  'Assistant/Map/',
  'company'     =>  '../User/Company/'
];
$counts = [
  'whole'       =>  iterator_count( new FilesystemIterator($dirs['whole'], FilesystemIterator::SKIP_DOTS) ),
  'posts'       =>  iterator_count( new FilesystemIterator($dirs['posts'], FilesystemIterator::SKIP_DOTS) ),
  'assistant'   =>  iterator_count( new FilesystemIterator($dirs['assistant'], FilesystemIterator::SKIP_DOTS) ),
  'company'     =>  iterator_count( new FilesystemIterator($dirs['company'], FilesystemIterator::SKIP_DOTS) )
];
?>

<!-- Maps Modal -->
<div class="modal fade modal--maps" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> 지도 업로드 </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal--maps__upload_box_container">
          <!-- jQuery File Upload - Whole Map -->
          <div class="modal--maps__upload_box_container__whole_map pb-4">
            <h6> 전체지도 업로드 </h6>
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
              <div class="col-12">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn <?php if ($counts['whole'] > 0) { echo 'btn-info'; } else { echo 'btn-success'; } ?> fileinput-button">
                  <i class="glyphicon glyphicon-plus"></i>
                  <span class="file_select"><?php if ($counts['whole'] > 0) { echo '재업로드'; } else { echo '파일선택'; } ?></span>
                  <input id="fileupload--whole_map" type="file" name="files[]">
                </span>
              </div>
              <!-- The global progress state -->
              <div class="progress_container col-12 mt-2 d-none">
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          <!-- jQuery File Upload - Assistant Map -->
          <div class="modal--maps__upload_box_container__assistant_map pb-4">
            <h6> 보조 관리자 전체지도 업로드 </h6>
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
              <div class="col-12">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn <?php if ($counts['assistant'] > 0) { echo 'btn-info'; } else { echo 'btn-success'; } ?> fileinput-button">
                  <i class="glyphicon glyphicon-plus"></i>
                  <span class="file_select"><?php if ($counts['assistant'] > 0) { echo '재업로드'; } else { echo '파일선택'; } ?></span>
                  <input id="fileupload--assistant_map" type="file" name="files[]">
                </span>
                <span class="fileupload-process"></span>
              </div>
              <!-- The global progress state -->
              <div class="progress_container col-12 mt-2 d-none">
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          <!-- jQuery File Upload - Post Maps -->
          <div class="modal--maps__upload_box_container__post_maps pb-4">
            <h6> 포스트 지도 업로드 ( 1.jpg, 2.jpg, 3.jpg .... ) </h6>
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
              <div class="col-12">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn <?php if ($counts['posts'] > 0) { echo 'btn-info'; } else { echo 'btn-success'; } ?> fileinput-button">
                  <i class="glyphicon glyphicon-plus"></i>
                  <span class="file_select"><?php if ($counts['posts'] > 0) { echo '재업로드'; } else { echo '파일선택'; } ?></span>
                  <input id="fileupload--post_maps" type="file" name="files[]" multiple>
                </span>
                <span class="fileupload-process"></span>
              </div>
              <!-- The global progress state -->
              <div class="progress_container col-12 mt-2 d-none">
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          <!-- jQuery File Upload - Company Logo -->
          <div class="modal--maps__upload_box_container__company pb-4" style="display: none;">
            <h6> 회사 이미지 업로드 </h6>
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
              <div class="col-12">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn <?php if ($counts['company'] > 0) { echo 'btn-info'; } else { echo 'btn-success'; } ?> fileinput-button">
                  <i class="glyphicon glyphicon-plus"></i>
                  <span class="file_select"><?php if ($counts['company'] > 0) { echo '재업로드'; } else { echo '파일선택'; } ?></span>
                  <input id="fileupload--company" type="file" name="files[]">
                </span>
              </div>
              <!-- The global progress state -->
              <div class="progress_container col-12 mt-2 d-none">
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>