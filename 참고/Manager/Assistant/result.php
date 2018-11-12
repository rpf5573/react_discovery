<?php 
require_once '../../Common/db_connection.php';
require_once '../../Common/classes.php';
require_once '../../Common/tools.php';

// 0보다 클것입니다
$total_team_count = TB_Meta::get_total_team_count()->value;
$all_team_points = TB_Points::get_all( $total_team_count )->value;
$all_team_players = TB_Players::get_all( $total_team_count )->value;
$team_player_counts = TB_Meta::get_team_player_counts()->value;
$mapping_points = TB_Meta::get_mapping_points()->value;
$options = TB_Meta::get_options()->value;
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" crossorigin="anonymous">
  <!-- Bootstrap Table -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.js"></script>
  
  <link rel="stylesheet" href="../Resources/Libraries/balloon.min.css">

  <style type="text/css">
    #page table {
      width: 100%;
    }
    #page th,
    #page tr {
      text-align: center;
      vertical-align: middle;
    }
    #page thead tr:nth-of-type(2) .th-inner {
      line-height: 3rem;
    }
    #page tbody tr {
      line-height: 3rem;
    }
    #page .table>tbody>tr:nth-of-type(odd),
    #page .table>thead>tr:nth-of-type(odd) {
      background-color: #f9f9f9;
    }
  </style>
</head>
<body>
<?php if ( $total_team_count == 0 || ! $team_player_counts ) { ?>
<div style="text-align: center; line-height: 100px; font-size: 2em; font-weight: 500;">
  전체 팀수가 아직 설정되지 않았습니다
</div>
<?php return; }
// <사용자가 아직 입력은 안한 경우> & <명단 입력 모드가 아닌 경우> & <사용자가 다 입력을 한 경우> 모두 고려했습니다
$rows = [];
for ( $i = 0; $i < $total_team_count; $i++ ) {
  $team                   =  ($i+1);
  $points                 =  $all_team_points[$i];
  $jokers                 =  ( $all_team_players[$i] ? get_jokers_from( $all_team_players[$i] ) : false );
  $outed_joker_count      =  ( $jokers ? count( get_outed_players_from( $jokers ) ) : 0 );
  $alive_joker_count      =  ( $jokers ? count( $jokers ) - $outed_joker_count : 0 );
  $members                =  ( $all_team_players[$i] ? get_members_from( $all_team_players[$i] ) : false );
  $outed_member_count     =  ( $members ? count( get_outed_players_from( $members ) ) : 0 );
  $alive_member_count     =  ( $members ? count( $members ) - $outed_member_count : 0 );
  $rank_point             =  ( $points['usable'] + $points['timer_plus'] - $points['timer_minus'] ); // default on no player list mode
  
  if ( $options->player_list ) {
    $rank_point             +=  ( (int)$points['member_out'] + (int)$points['joker_out'] + ($alive_member_count * $mapping_points->member_ransom) + ($alive_joker_count * $mapping_points->joker_ransom) - $points['usable'] );
  }
  $rank                   =  1;

  $rows[] = [
    'team'                  =>  $team,
    'points'                =>  $all_team_points[$i],
    'jokers'                =>  $jokers,
    'outed_joker_count'     =>  $outed_joker_count,
    'alive_joker_count'     =>  $alive_joker_count,
    'members'               =>  $members,
    'outed_member_count'    =>  $outed_member_count,
    'alive_member_count'    =>  $alive_member_count,
    'rank_point'            =>  $rank_point,
    'rank'                  =>  $rank
  ];
}

// Rank구하기
for ( $i = 0; $i < $total_team_count; $i++ ) {
  for ( $z = 0; $z < $total_team_count; $z++ ) {
    if ( $i != $z ) {
      if ( $rows[$i]['rank_point'] < $rows[$z]['rank_point'] ) {
        // 비교해서 작을때 마다 1씩 증가!
        $rows[$i]['rank'] = ($rows[$i]['rank']+1);
      }
    }
  }
} 
?>

<div id="page" class="container" style="padding-bottom: 20px;">
  <h2 style="padding-top: 20px; padding-bottom: 20px;">결과표</h2>
  <table data-toggle="table" class="table-bordered table-striped">
    <thead>
      <tr>
        <th rowspan="2">팀</th>
        <th colspan="2">최종결과</th>
      </tr>
      <tr>
        <th><span style="color:blue;">순위점수</span></th>
        <th><span style="color:red;">순위</span></th>
      </tr>
    </thead>
    <tbody>
    <?php  for( $i = 0; $i < $total_team_count; $i++ ) { ?>
      <tr>
        <td><?php echo $rows[$i]['team']; ?></td>
        <td> <?php echo $rows[$i]['rank_point']; ?> </td>
        <td><?php echo $rows[$i]['rank']; ?></td>
      </tr> <?php  } // End For  ?>
    </tbody>
  </table>
</div>

</body>
</html>