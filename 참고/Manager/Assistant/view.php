<?php
require_once ('../../Common/db_connection.php');
require_once ('../../Common/classes.php');
require_once ('../../Common/tools.php');

$teamCount = TB_Meta::get_total_team_count()->value;
$points = TB_Points::get_all( $teamCount )->value;
$allTeamPlayers = TB_Players::get_all( $teamCount )->value;
$files = scandir('Map/', 1); // 파일 이름이 긴것순으로~
$assistantMap = null;
if ( count($files) > 2 ) {
  $assistantMap = $files[0];
}
?>

<!DOCTYPE html>
<html class="H100">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/48487ab84a.js"></script>
  <script src="../../Resources/Libraries/jquery.form.min.js"></script>

  <title></title>
  <style type="text/css">
    * {
      box-sizing: border-box;
    } 
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0; }
    input[type=number] {
      -moz-appearance: textfield; }

    .container-fluid {
      padding-right: 15px;
      padding-left: 15px;
      margin-right: auto;
      margin-left: auto;
    }
    .clearfix::before, 
    .clearfix::after {
      content:"";
      display:table;
    }
    .clearfix::after {
      clear:both;
    }
    .row {
      margin-right: -15px;
      margin-left: -15px;
    }

    .col-xs-50 {
      position: relative;
      min-height: 1px;
      padding-right: 15px;
      padding-left: 20px;
      width: 50%;
      /* display: inline-block; */
      padding-top: 10px;
      padding-bottom: 10px;
      margin: 0px;
      border: 0px;
      float: left;


      width: 50%;
      padding-left: 10%;
    }

    .form-control {
      display: block;
      width: 100%;
      height: 36px;
      padding: 6px 12px;
      font-size: 16px;
      text-align: center;
      line-height: 1.42857143;
      color: #555;
      background-color: #fff;
      background-image: none;
      border: 1px solid #ccc;
      border-radius: 4px;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
      -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
      transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }

    .btn {
      display: inline-block;
      padding: 6px 12px;
      margin-bottom: 0;
      font-size: 14px;
      font-weight: 400;
      line-height: 1.42857143;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
      -ms-touch-action: manipulation;
      touch-action: manipulation;
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background-image: none;
      border: 1px solid transparent;
      border-radius: 4px;
    }

    .btn-primary {
      color: #fff;
      background-color: #337ab7;
      border-color: #2e6da4;
    }

    .btn-danger {
      color: #fff;
      background-color: #d9534f;
      border-color: #d43f3a;
    }

    .H100 {
      height: 100%;
    }

    .dropdown {
      position: absolute;
      left: 0;
      top: 18px;
    }
    .dropdown-toggle {
      padding: 0;
      margin: 0;
    }
    .dropdown-menu > li > a.outed_player {
      color: red;
    }

    body.no-list .col-xs-50 .dropdown {
      display: none;
    }
    body.no-list .col-xs-50 .dropdown-toggle {
      display: none;
    }
    body.no-list .col-xs-50 {
      padding-left: 15px;
    }
    .dropdown .caret {
      border-top-width: 7px;
      border-right-width: 7px;
      border-left-width: 7px;
      border-top-color: red;
      border-width: 0px;
    }
  </style>
</head>

<script type="text/javascript"></script>

<body class="H100 <?php if ( !$allTeamPlayers ) { echo "no-list"; } ?>">
  <div class="container-fluid H100">
    <div class="H100">
      <form id="form-points" action="<?php echo BASE_URL.'/Manager/controller.php'; ?>" class="clearfix H100" method="POST" style="width:100%; position: relative;">
        <?php
        for($i = 0; $i < $teamCount; $i++){
          $team = $i+1;
          $point = $points[$i]['usable'];
          $players = $allTeamPlayers[$i];
          ?>
          <div class="col-xs-50">
            <input class="form-control w-80" placeholder="<?php echo $team.'조'; ?>" name="points[]" data-team="1" type="number" style="width:96%;">
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle dropdown-toggle--outed_players" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-team="<?php echo $team; ?>">
                활동제한
              </button>
              <ul class="dropdown-menu dropdown-menu--outed_players" aria-labelledby="dropdownMenu1">
                <?php 
                if ( $players ) {
                  $has_out_player = false;
                  //var_dump($allTeamPlayers);
                  foreach ($players as $player) {
                    if ( $player->is_outed ) { $has_out_player = true; ?>
                    <li><a href="" class="outed_player"><?php echo $player->name; ?></a></li>
                    <?php }
                  }
                  if ( !$has_out_player ) {
                    echo "활동제한 당한 팀원이 없습니다";
                  }
                } else {
                  echo "명단이 없습니다";
                }
                ?>
              </ul>
            </div>
          </div>
          <?php
        }
        ?>
        <div style="width: 100%;padding: 10px;position: absolute; bottom: 0px;">
          <div style="width: 50%; float: left; padding: 20px;margin: 0px;border: 0px;">
            <div class="dropup">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid black; padding: 6px 12px;">
                메뉴
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <li><a href="<?php echo BASE_URL.'/Manager/Assistant/result.php'; ?>">결과표</a></li>
                <?php 
                if ( $assistantMap ) { ?>
                  <li><a target="_blank" href="<?php echo 'Map/' . $assistantMap; ?>">전체지도</a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <div style="width: 50%; float: left; padding: 20px;margin: 0px;border: 0px;">
            <button type="submit" class="btn btn-success" style="width: 100%;">
              확인
            </button>
          </div>
        </div>
        <input name="update_points" value="true" type="hidden">
        <input name="total_team_count" value="<?php echo $teamCount; ?>" type="hidden">
      </form>
    </div>
  </div>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      /*----------  Modal -- Points  ----------*/
      var point_form = $("#form-points");
      var inputs = $("input[name='points[]']");
      var options = {
        beforeSubmit: function(data,form,option) {},
        success: function(data) {
          var message = JSON.parse(data);
          if ( message.response_code == 201 ) {
            $.each( inputs, function(index, input) {
              var $input = $(input);
              var point = $input.val();
            });
          }
          alert( "성공" );
          point_form.clearForm();
        },
        error: function() {
          alert("Error가 발생하였습니다.");
        }
      };
      point_form.ajaxForm( options );
      
      jQuery('.dropdown-toggle--outed_players').click(function() {
        var self = $(this);
        var team = self.data('team');
        $.post(
          'controller.php', {
            //정말 신기하다! beacon_data는 javascript object인데 , 서버쪽에서 그냥 받아서 쓸수 있는 형태로 바뀌네!! 신기!!!
            get_outed_players: true,
            team: team
          },
          function (data, textStatus, xhr) {
            console.dir(data);
            var outed_player_list = self.siblings('.dropdown-menu--outed_players');
            outed_player_list.empty();
            var message = JSON.parse(data);
            if ( message.response_code == 201 ) {
              for ( var i = 0; i < message.value.length; i++ ) {
                var name = message.value[i];
                var node = '<li><a href="" class="outed_player">'+name+'</a></li>';
                outed_player_list.append( $(node) );
              }
              jQuery.each(jQuery('.dropdown-menu--outed_players a'), function (index, val) {
                var name = message.value[index];
                '<li><a href="" class="outed_player">'+name+'</a></li>'
                val.innerHtml = name;
              });
            } 
            else {
              outed_player_list.html( message.error_message );
            }
          }
        );
      })
    });
  </script>
</body>
</html>