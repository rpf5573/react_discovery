<?php
require_once '../Common/db_connection.php';
require_once '../Common/classes.php';
require_once '../Common/tools.php';

$controller_url             =   BASE_URL . '/Manager/controller.php';
$game_state                 =   TB_Meta::get_game_state()->value;
$total_team_count           =   TB_Meta::get_total_team_count()->value;
$team_player_counts         =   TB_Meta::get_team_player_counts()->value;
$united_team_player_count   =   ( empty($team_player_counts) ? 0 : $team_player_counts[0] );
$team_passwords             =   TB_Meta::get_team_passwords()->value;
$options                    =   TB_Meta::get_options()->value;
$joker_info_questions       =   TB_Meta::get_joker_info_questions()->value;
$mapping_points             =   TB_Meta::get_mapping_points()->value;
$passwords                  =   TB_Meta::get_passwords()->value;
$timer_infos                =   TB_Timer::get_timer_infos( $total_team_count )->value;
$beacon_datas               =   TB_Beacon::get_all()->value;
$team_points                =   TB_Points::get_all( $total_team_count )->value;

?>

<!-- PHP variables map Javascript -->
<script type="text/javascript">
  var BASE_URL = "<?php echo BASE_URL; ?>";
  var CONTROLLER_URL = (BASE_URL + '/Manager/controller.php');
  var TIMER_CONTROLLER_URL = (BASE_URL + '/Manager/effective_timer.php');
  var is_it_ok = false;
  var total_team_count = "<?php echo $total_team_count; ?>";
</script>

<!DOCTYPE html>
<html>
<head>
  <title>DeepMind</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!--===============================
  =            Libraries            =
  ================================-->
  
  <!-- Font Awesome -->
  <script src="https://use.fontawesome.com/840d82fdb4.js"></script>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- jQuery - UI -->
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

  <!-- Bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" crossorigin="anonymous">

  <!-- jQuery.Form -->
  <script src="../Resources/Libraries/jquery.form.min.js"></script>

  <!-- Timer Indicator -->
  <link rel="stylesheet" type="text/css" href="../Resources/CSS/load-indicator-clock.css">
  
  <!-- Awesome Bootstrap Radio -->
  <link rel="stylesheet" type="text/css" href="../Resources/Libraries/awesome-bootstrap-radio.css">

  <!-- jQuery.File.Upload -->
  <link rel="stylesheet" type="text/css" href="../Resources/Libraries/jQuery_File_Upload/CSS/jquery.fileupload.css">
  <link rel="stylesheet" type="text/css" href="../Resources/Libraries/jQuery_File_Upload/CSS/jquery.fileupload-ui.css">

  <!-- should keep this order of importing scripts -->
  <script src="../Resources/Libraries/jQuery_File_Upload/JS/jquery.iframe-transport.js"></script>
  <script src="../Resources/Libraries/jQuery_File_Upload/JS/jquery.fileupload.js"></script>
  <script src="../Resources/Libraries/jQuery_File_Upload/JS/jquery.fileupload-ui.js"></script>

  <!-- Animate.css -->
  <link rel="stylesheet" type="text/css" href="../Resources/Libraries/animate.min.css">

  <!--====  End of Libraries  ====-->
  <link rel="stylesheet" type="text/css" href="manager.css?ver=0.01">
  <script src="manager.js?ver=<?php echo rand(10,10000); ?>" charset="utf-8"></script>
  
</head>
<body>
  <div id="page">
    <div class="sidebar">
      <?php include 'Components/menu.php'; ?>
    </div>
    <div class="main">
      <div class="container">
        <div class="row evaluate_uploaded_files_container justify-content-around no-gutters">
          
        </div>
      </div>

      <!-- Float Button -->
      <div class="float_btn float_btn--open_warehouse">
        <div class="inner">
        </div>
      </div>
      <div class="float_btn float_btn--load_more">
        <div class="inner">
        </div>
      </div>
    </div>
    <?php include 'Components/modals.php'; ?>
  </div>

  <!-- 자잘한 Javascipt Code들 -->
  <script type="text/javascript">
    function cDir( tag, content ) {
      console.log( tag + '-->' );
      console.dir( content );
    }
    //폼을 모아놨다
    var forms = {
      team_settings           :  jQuery('#form-team_settings'),
      team_player_counts      :  jQuery('#form-team_player_counts'),
      team_passwords          :  jQuery('#form-team_passwords'),
      joker_info_questions    :  jQuery('#form-joker_info_questions'),
      points                  :  jQuery('#form-points'),
      manager_password        :  jQuery('#form-manager_password'),
      assistant_password      :  jQuery('#form-assistant_password')
    };
    //Tab설정
    $('.modal--team_settings #tabs').tabs();
    /*----------  Ripple Effect  ----------*/
    (function(){
      'use strict';
      var $ripple = $('.js-ripple');
      $ripple.on('click.ui.ripple', function(e) {
        var $this = $(this);
        var $offset = $this.parent().offset();
        var $circle = $this.find('.c-ripple__circle');
        var x = e.pageX - $offset.left;
        var y = e.pageY - $offset.top;
        $circle.css({
          top: y + 'px',
          left: x + 'px'
        });
        $this.addClass('is-ripple');
      });
      $ripple.on('animationend webkitAnimationEnd oanimationend MSAnimationEnd', function(e) {
        $(this).removeClass('is-ripple');
      });
    })();
    /*---------- Add/Remove Menu Item Effect  ----------*/
    (function(){
      //메뉴 아이템 누르면, active붙인다
      $('.menu__item .c-button').click(function(event) {
        var $this = $(this);
        $this.addClass('is-active');
      });
      //Modal 사라질때, active때버려
      var $modals = $('.modal');
      $modals.on('hide.bs.modal', function (event) {
        $('.menu__item .c-button.is-active').removeClass('is-active');
      });
    })();
    /*----------  Infinite Run Timer  ----------*/
    (function(){
      function run_timer() {
        console.log( 'run_timer...' );
        $.post(
          TIMER_CONTROLLER_URL,
          {
            run_timer : true,
            total_team_count : total_team_count
          },
          function(data, textStatus, xhr) {}
          );
        setTimeout(function(){
          run_timer();
        }, 4950);
      }
      run_timer();
    })();
    function getExtensionOfFilename( filename ) { 
      var fileLen = filename.length;
      var lastDot = filename.lastIndexOf( '.' );
      var fileExt = filename.substring( lastDot, fileLen ).toLowerCase(); 
      return fileExt;
    }
    function getOnlyFileName( filename ) {
      var fileLen = filename.length;
      var lastDot = filename.lastIndexOf( '.' );
      var only_file_name = filename.substring( 0, lastDot ).toLowerCase(); 
      return only_file_name;
    }
    $.fn.extend({
      animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $(this).addClass('animated ' + animationName).one(animationEnd, function() {
          $(this).removeClass('animated ' + animationName);
        });
      }
    });
  </script>

</body>
</html>