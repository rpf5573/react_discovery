<?php 
  require_once '../Common/db_connection.php';
  require_once '../Common/classes.php'; 
?>

<?php
  /*----------  Run Timer  ----------*/
  if ( isset( $_POST['run_timer'] ) ) {
    $total_team_count = $_POST['total_team_count'];
    $message = TB_Timer::run( $total_team_count );

    echo $message->get_json();
  }
?>