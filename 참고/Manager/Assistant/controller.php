<?php
require_once ('../../Common/db_connection.php');
require_once ('../../Common/classes.php');
require_once ('../../Common/tools.php');

if ( isset( $_POST['get_outed_players'] ) && isset( $_POST['team'] ) ) {
  $team = $_POST['team'];
  $message = [
    'response_code'       =>  201,
    'description'         =>  $team.'팀의 Players를 가져오기',
    'value'               =>  null,
    'error_message'       =>  null,
    'success_message'     =>  "성공적으로 가져왔습니다"
  ]; 
  $teamPlayers = TB_Players::get( $team )->value;
  if ( $teamPlayers ) {
    $outed_players = [];
    $has_outed_player = false;
    for( $i = 0; $i < count($teamPlayers); $i++ ) {
      if ( $teamPlayers[$i]->is_outed ) {
        $outed_players[] = $teamPlayers[$i]->name;
        $has_outed_player = true;
      }
    }
    if ( $has_outed_player ) {
      $message['value'] = $outed_players;
    } else {
      $message['response_code'] = 402;
      $message['error_message'] = "활동제한 당한 팀원이 없습니다";
    }
  } else {
    $message['response_code'] = 401;
    $message['error_message'] = "명단이 없습니다";
  }

  $message = new Message( $message );
  echo $message->get_json();
}

?>