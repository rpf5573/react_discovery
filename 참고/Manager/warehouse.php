<?php
require_once '../Common/db_connection.php';
require_once '../Common/classes.php';
require_once '../Common/tools.php';

$controller_url             =   BASE_URL . '/Manager/controller.php';
$beacon_datas               =   TB_WareHouse::get_all()->value;
?>

  <!-- PHP variables map Javascript -->
  <script type="text/javascript">
    var BASE_URL = "<?php echo BASE_URL; ?>";
    var CONTROLLER_URL = (BASE_URL + '/Manager/controller.php');
  </script>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- jQuery - UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="warehouse.css">
    <script src="warehouse.js?ver=<?php echo rand(10,10000); ?>" charset="utf-8"></script>

  </head>

  <body class="warehouse">

    <div class="container-fluid" style="max-width: 1000px;">
      <!-- 자꾸 테이블이 아래로 내려가서 이렇게 가둬놓음 -->
      <div class="mt-5">
        <div class="title text-center mb-4"> 비콘 정보 창고 </div>
        <table class="table table-hover beacon_list">
          <thead>
            <tr>
              <th>미션이름</th>
              <th>비콘 정보 주소</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 0; foreach ($beacon_datas as $data) { $i++; ?>
            <tr class="beacon_list__row" data-id="<?php echo $data['id']; ?>">
              <td class="beacon_list__row__data beacon_list__row__data--item">
                <span> <?php echo $data['item']; ?> </span>
                <input type="text" name="item" class="form-control" value="<?php echo $data['item']; ?>">
              </td>
              <td class="beacon_list__row__data beacon_list__row__data--url">
                <span> <?php echo $data['url']; ?> </span>
                <input type="text" name="url" class="form-control" value="<?php echo $data['url']; ?>">
              </td>
              <td class="d-flex" style="min-width: 120px;">
                <button type="button" class="btn btn-outline-warning beacon_list__row__update btn-sm"> 수정 </button>
                <button type="button" class="btn btn-outline-danger beacon_list__row__remove btn-sm ml-2" data-id="<?php echo $data['id']; ?>"> 삭제 </button>
                <button type="button" class="btn btn-success beacon_list__row__complete btn-sm" data-id="<?php echo $data['id']; ?>"> 완료 </button>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="d-flex">
        <button class="fg-1 beacon_list__add btn btn-secondary" type="button"> 비콘 추가 </button>
      </div>
    </div>
    <!-- Beacon Body __ End -->

  </body>

  </html>