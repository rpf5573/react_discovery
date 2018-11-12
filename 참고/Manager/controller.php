<?php
  require_once '../Common/db_connection.php';
  require_once '../Common/classes.php';
  require_once '../Common/tools.php';

  /*----------  Update Game State  ----------*/
  if ( isset( $_POST['update_game_state'] ) && isset( $_POST['game_state'] ) ) {
    $state = ($_POST['game_state'] === 'true') ? 1 : 0;
    if ( !$state ) { // 딥마인드 종료시에
      $total_team_count = TB_Meta::get_total_team_count()->value;
      // 타이머시간을 점수에 반영 해보자!
      $mapping_points = TB_Meta::get_mapping_points()->value;
      for ( $team = 1; $team <= $total_team_count; $team++) {
        $time = (int) TB_Timer::get( $team )->value['time'];
        $timer_state = (int) TB_Timer::get( $team )->value['state'];
        // 타이머가 On인 팀만
        if ( $timer_state ) {
          if ( $time > 0 ) {
            $point = ( (int)($time/30) * (int)$mapping_points->time_plus );
            TB_Points::update( $team, 'timer_plus', abs($point) );
          } else {
            $point = ( (int)($time/30) * (int)$mapping_points->time_minus );
            TB_Points::update( $team, 'timer_minus', abs($point) );
          }
        }
      }

      TB_Timer::reset(); // 마지막으로 타이머 리셋!
    }
    $message = TB_Meta::update_game_state( $state );
    echo $message->get_json();
  }

  /*----------  Update Total Team Count  ----------*/
  if ( isset( $_POST['update_total_team_count'] ) ) {
    $total_team_count = $_POST['total_team_count'];
    $message = [
      'response_code'         =>  201,
      'description'           =>  '전체 팀 수를 업데이트',
      'value'                 =>  null,
      'error_message'         =>  null,
      'success_message'       =>  null
    ];
    //Reset
    if ( $_POST['total_team_count'] > 0 ) {
      TB_Meta::update_team_player_counts( 0 );
      TB_Meta::update_team_passwords( 0 );
      TB_Timer::update_state_all( $total_team_count, 0 );
    }
    $message = TB_Meta::update_total_team_count( $_POST['total_team_count'] );
    echo $message->get_json();
  }

  /*----------  Update Team Passwords  ----------*/
  if ( isset( $_POST['team_passwords'] ) || isset( $_POST['united_team_player_count'] ) ) {
    $team_passwords = TB_Meta::get_team_passwords()->value;
    $total_team_count = 0;
    for ( $i = 0; $i < 20; $i++ ) {
      $password = intval( ($_POST['team_passwords'][$i]) );
      if ( $password > 0 ) {
        $team_passwords[$i] = $password;
      }
      if ( $team_passwords[$i] > 0 ) {
        $total_team_count++;
      }
    }
    TB_Meta::update_total_team_count( $total_team_count );
    $message = TB_Meta::update_team_passwords( $team_passwords );
    // message검사 안했습니다.. 왠만하면 잘 되었겠지요~, 딱히 논리적인 오류가 없는이상은 그냥 갑시다!

    /*----------  Update Team Player Counts  ----------*/
    $united_team_player_count = (int)$_POST['united_team_player_count'];
    if ( ! $united_team_player_count ) {
      $team_player_counts = TB_Meta::get_team_player_counts()->value;
      $united_team_player_count = ($team_player_counts == 0 ? 0 : $team_player_counts[0]);
    }
    if ( $united_team_player_count > 2 ) {
      $team_player_coutns = array();
      for ( $i = 0; $i < $total_team_count; $i++ ) {
        $team_player_counts[$i] = $united_team_player_count;
      }
      $message = TB_Meta::update_team_player_counts( $team_player_counts );
    }
    echo $message->get_json();
  }

  /*----------  Update Timer Deadline  ----------*/
  if ( isset( $_POST['timer_deadline'] ) ) {
    $message = TB_Meta::update_timer_deadline( (int)$_POST['timer_deadline'] );
    echo $message->get_json();
  }

  /*----------  Timer All Start  ----------*/
  if ( isset( $_POST['timer_all_start'] ) ) {
    $total_team_count = (int)$_POST['total_team_count'];
    $message = TB_Timer::update_state_all( $total_team_count, 1 );
    echo $message->get_json();
  }

  /*----------  Timer All End  ----------*/
  if ( isset( $_POST['timer_all_end'] ) ) {
    $total_team_count = (int)$_POST['total_team_count'];
    $message = TB_Timer::update_state_all( $total_team_count, [] );
    echo $message->get_json();
  }

  /*----------  Timer End  ----------*/
  if ( isset( $_POST['timer_end'] ) ) {
    $team = $_POST['team'];
    $message = TB_Timer::update_state( (int)$team, 0 );
    echo $message->get_json();
  }

  /*----------  Insert\Update Beacon Data  ----------*/
  if ( isset( $_POST['beacon_data'] ) ) {
    $message = TB_Beacon::update( $_POST['beacon_data'] );
    echo $message->get_json();
  }

  /*----------  Remove Beacon Data  ----------*/
  if ( isset( $_POST['remove_beacon_data'] ) && isset( $_POST['post'] ) ) {
    $message = TB_Beacon::remove( (int)$_POST['post'] );
    echo $message->get_json();
  }

  /*----------  Insert\Update Beacon Data On Warehouse  ----------*/
  if ( isset( $_POST['beacon_data_on_warehouse'] ) ) {
    $message = TB_WareHouse::update( $_POST['beacon_data_on_warehouse'] );
    echo $message->get_json();
  }

  /*----------  Remove Beacon Data On Wareouse  ----------*/
  if ( isset( $_POST['remove_beacon_data_on_warehouse'] ) && isset( $_POST['id_on_warehouse'] ) ) {
    $message = TB_WareHouse::remove( (int)$_POST['id_on_warehouse'] );
    echo $message->get_json();
  }

  /*----------  Update Options  ----------*/
  if ( isset( $_POST['option_update'] ) ) {
    $key = null;
    $state = null;
    if ( isset( $_POST['beacon_state'] ) ) {
      $key = 'beacon';
      $state = ($_POST['beacon_state'] === 'true') ? true : false;
    } else if ( isset( $_POST['test_mode_state'] ) ) {
      $key = 'test_mode';
      $state = ($_POST['test_mode_state'] === 'true') ? true : false;
      // 테스트모드에서는 미리 입력되도록 하자!!
      if ($state) {
        $team_player_counts = TB_Meta::get_team_player_counts()->value;
        if ( count($team_player_counts) > 1 ) {
          $names = ["정윤석","박사랑","김향기","박준목","정다빈","김유정","조수민","정채은","심혜원","은원재","고주연","주민수","이현우","정민아","한예린","남지현","박지빈","백승도","박보영"];
          $answers = [
            [
                "비 내리면산 부풀고산 부풀면개울물 넘친다.",
                "귀뚜라미 귀뜨르르 가느단 소리",
                "7년 후에 지구를 한바퀴 돌 수 있다. ",
                "신은 용기있는자를 결코 버리지 않는다",
                "피할수 없으면 즐겨라",
                "더많이 실험할수록 더나아진다"
            ],
            [
                "푹푹 찌는 여름.",
                "아이스크림보다 생각나는 것이 있나.",
                "한 송이의 국화꽃",
                "너를 예로 들어",
                "문득 아름다운 것과 마주쳤을 때 지금 곁에 있으면 얼마나 좋을까 하고",
                "늦게 도착한 바람이 때를 놓치고, 책은 덮인다"
            ]
          ];
          for( $i = 0; $i < 20; $i++ ) {
            $team = $i+1;
            $count = $team_player_counts[$i];
            $players = [];
            for ( $z = 0; $z < $count-2; $z++ ) {
              $player = new mPlayer( $names[$z], false, 0, false, null );
              $players[] = $player;
            }
            $jokerInfo1 = new mJokerInfo( [], $answers[0] );
            $jokerInfo2 = new mJokerInfo( [], $answers[1] );
            $players[] = new mPlayer( "김조커", false, 0, true, $jokerInfo1 );
            $players[] = new mPlayer( "박조커", false, 0, true, $jokerInfo2 );

            shuffle( $players );

            TB_Players::update( $team, $players );
          }
        } else {
          $message = [
            'response_code'       =>  402,
            'description'         =>  "테스트모드에서 팀 플레이어 미리 입력 에러",
            'value'               =>  null,
            'error_message'       =>  "팀 인원수를 먼저 설정해 주세요",
            'success_message'     =>  null
          ];
          $message = new Message( $message );
          echo $message->get_json();
          return;
        }
      }
    } else if ( isset( $_POST['player_list_state'] ) ) {
      $key = 'player_list';
      $state = ($_POST['player_list_state'] === 'true') ? true : false;
    } else if ( isset( $_POST['joker_info_state'] ) ) {
      $key = 'joker_info';
      $state = ($_POST['joker_info_state'] === 'true') ? true : false;
    }
    $message = TB_Meta::update_options( $key, $state );
    echo $message->get_json();
  }
  
  /*----------  Update Joker Info Questions  ----------*/
  if ( isset( $_POST['joker_info_questions'] ) ) {
    $message = TB_Meta::update_joker_info_questions( $_POST['joker_info_questions'] );
    echo $message->get_json();
  }

  if ( isset( $_POST['reset_joker_info_questions'] ) ) {
    $message = TB_Meta::update_joker_info_questions( 0 );
    echo $message->get_json();
  }

  if ( isset( $_POST['update_points'] ) ) {
    // 이 둘은 항상 같이 오르기는 하지만, 작게 조각낸 코드를 합치고 싶지 않아, 그정도 빠른 성능이 필요하지도 않고.
    TB_Points::update_all( intval( $_POST['total_team_count'] ), 'usable', $_POST['points'] );
    $message = TB_Points::update_all( intval( $_POST['total_team_count'] ), 'stack', $_POST['points'] );
    echo $message->get_json();
  }

  /*----------  Update Mapping Points  ----------*/
  if ( isset( $_POST['update_mapping_points'] ) ) {
    $message = TB_Meta::update_mapping_points( $_POST['mapping_key'], (int)$_POST['point'] );
    echo $message->get_json();
  }

  /*----------  Update Manager Password  ----------*/
  if ( isset( $_POST['update_manager_password'] ) ) {
    $message = TB_Meta::update_manager_password( $_POST['password'] );
    echo $message->get_json();
  }

  /*----------  Update Assistant Password  ----------*/
  if ( isset( $_POST['update_assistant_password'] ) ) {
    $message = TB_Meta::update_assistant_password( $_POST['password'] );
    echo $message->get_json();
  }

  /*----------  Update Posts Count  ----------*/
  if ( isset( $_POST['update_posts_count'] ) && isset( $_POST['count'] ) ) {
    $message = TB_Meta::update_posts_count( (int)$_POST['count'] );
    echo $message->get_json();
  }

  /*----------  Update Team Info  ----------*/
  if ( isset( $_POST['update_team_info'] ) && isset( $_POST['team'] ) ) {
    $message = TB_Players::update( (int)$_POST['team'], 0 );
    echo $message->get_json();
  }

  if ( isset( $_POST['get_timer_states'] ) && isset( $_POST['total_team_count'] ) ) {
    $message = TB_Timer::get_timer_infos( (int)$_POST['total_team_count'] );
    echo $message->get_json();
  }

  /*----------  Reset  ----------*/
  if ( isset( $_POST['reset'] ) ) {

    /*----------  Meta  ----------*/
    TB_Meta::reset_game_state();
    TB_Meta::reset_mapping_points();
    TB_Meta::reset_options();
    TB_Meta::reset_passwords();
    TB_Meta::reset_team_player_counts();
    TB_Meta::reset_timer_deadline();
    TB_Meta::reset_total_team_count();
    TB_Meta::reset_joker_info_questions();
    TB_Meta::reset_posts_count();

    // points
    TB_Points::reset();
    TB_Timer::reset();

    // players
    TB_Players::reset();

    // posts
    TB_Posts::reset();

    // uploads
    TB_Uploads::reset();

    // beacon
    TB_Beacon::reset();
    
    
    /*====================================
    =            Delete Files            =
    ====================================*/
    $dirs = [ '../User/Posts/', '../User/Whole_Map/', '../User/Company/', 'Assistant/Map/', '../User/Uploads/' ];
    for ($i=0; $i < count($dirs); $i++) { 
      $di = new RecursiveDirectoryIterator($dirs[$i], FilesystemIterator::SKIP_DOTS);
      $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
      foreach ( $ri as $file ) {
        $file->isDir() ?  rmdir($file) : unlink($file);
      }
    }

    echo 201;
  }
  /*----------  Get Uploaded File Names  ----------*/
  if ( isset( $_POST['get_uploaded_files_name'] ) && isset( $_POST['total_team_count'] ) ) {
    $message = TB_Uploads::get_all_files( (int)$_POST['total_team_count'] );
    echo $message->get_json();
  }
  /*----------  Give Evaluation Of Uploaded File Point  ----------*/
  if ( isset( $_POST['evaluate_uploaded_file'] ) && isset( $_POST['point'] ) && isset( $_POST['team'] ) && isset( $_POST['file_name'] ) ) {
    $team = (int)$_POST['team'];
    $point = (int)$_POST['point'];
    TB_Points::update( $team, 'usable', $point );
    TB_Points::update( $team, 'stack', $point );
    $message = TB_Uploads::remove( $team, $_POST['file_name'] );
    $message->description = "업로드 자료를 평가하고 점수를 부여했습니다";

    echo $message->get_json();
  }

?>