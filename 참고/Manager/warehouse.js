jQuery(document).ready(function () {
  var updateClickEventListener = function (event) {
    var $this = $(this);
    var row = $this.parent().parent();
    row.addClass('s-update');
  };
  var removeClickEventListener = function (event) {
    var $this = $(this);
    var id = $this.parent().parent().data('id');
    console.log( id );
    $.post(
      CONTROLLER_URL, {
        //정말 신기하다! beacon_data는 javascript object인데 , 서버쪽에서 그냥 받아서 쓸수 있는 형태로 바뀌네!! 신기!!!
        remove_beacon_data_on_warehouse: true,
        id_on_warehouse: id
      },
      function (data, textStatus, xhr) {
        console.dir(data);
        var message = JSON.parse(data);
        if (message.response_code == 201) {
          alert("성공");
          $this.parent().parent().remove();
        } else {
          alert("ERROR!");
        }
      }
    );
  };
  var completeClickEventListener = function (event) {
    var $this = $(this);
    var row = $this.parent().parent();
    var span_item = row.find('.beacon_list__row__data--item > span');
    var input_item = row.find('.beacon_list__row__data--item > input');
    var span_url = row.find('.beacon_list__row__data--url > span');
    var input_url = row.find('.beacon_list__row__data--url > input');
    var beacon_data = {
      id: row.data('id'),
      item: input_item.val(),
      url: input_url.val()
    }

    console.dir(beacon_data);

    $.post(
      CONTROLLER_URL, {
        //정말 신기하다! beacon_data는 javascript object인데 , 서버쪽에서 그냥 받아서 쓸수 있는 형태로 바뀌네!! 신기!!!
        beacon_data_on_warehouse: beacon_data
      },
      function (data, textStatus, xhr) {
        console.log(data);
        var message = JSON.parse(data);
        if (message.response_code == 201) {
          // DB와 현재 Row의 ID값이 일치하지 않기 때문에, 처음 추가 하는거면, 새로고침한다.
          if ( jQuery('.beacon_list__row').length == 1 ) {
            window.location.reload(true);
          } else {
            alert("성공");
            span_item.html(beacon_data.item);
            span_url.html(beacon_data.url);
            row.removeClass('s-new');
            row.removeClass('s-update');
          }
        } else {
          alert("ERROR!");
        }
      }
    );
  };

  $('.beacon_list__row__update').click(updateClickEventListener);
  $('.beacon_list__row__remove').click(removeClickEventListener);
  $('.beacon_list__row__complete').click(completeClickEventListener);
  $('.beacon_list__add').click(function (event) {
    var table_body = $('.beacon_list tbody');
    // <tr class="beacon_list__row beacon_list__row--new prototype">
    //   <th scope="row" class="beacon_list__row__data beacon_list__row__data--post">
    //     <span></span>
    //     <input name="post" class="form-control " value="" type="text">
    //   </th>
    //   <td class="beacon_list__row__data beacon_list__row__data--item">
    //     <span></span>
    //     <input name="item" class="form-control " value="" type="text">
    //   </td>
    //   <td class="beacon_list__row__data beacon_list__row__data--url">
    //     <span></span>
    //     <input name="url" class="form-control" value="" type="text">
    //   </td>
    //   <td class="d-flex" style="min-width: 120px;">
    //     <button type="button" class="btn btn-outline-warning beacon_list__row__update btn-sm"> 수정 </button>
    //     <button type="button" class="btn btn-outline-danger beacon_list__row__remove btn-sm ml-2" data-post="1"> 삭제 </button>
    //     <button type="button" class="btn btn-success beacon_list__row__complete btn-sm" data-post="1"> 완료 </button>
    //   </td>
    // </tr>
    var last_row = $('.beacon_list__row:last');
    console.dir( last_row );
    var id = parseInt(last_row.data('id')) + 1;
    if ( isNaN(id) ) {
      id = 1;
    }
    var rowHtmlString = '<tr class="beacon_list__row s-new" data-id=' + id + '><td class="beacon_list__row__data beacon_list__row__data--item"><span></span><input name="item" class="form-control " value="" type="text"></td><td class="beacon_list__row__data beacon_list__row__data--url"><span></span><input name="url" class="form-control" value="" type="text"></td><td class="d-flex" style="min-width: 120px;"><button type="button" class="btn btn-outline-warning beacon_list__row__update btn-sm"> 수정 </button><button type="button" class="btn btn-outline-danger beacon_list__row__remove btn-sm ml-2" data-post=' + id + '> 삭제 </button><button type="button" class="btn btn-success beacon_list__row__complete btn-sm" data-id=' + id + '> 완료 </button></td></tr>';
    var new_beacon_data_row = $($.parseHTML(rowHtmlString));
    new_beacon_data_row.find('.beacon_list__row__update').click(updateClickEventListener);
    new_beacon_data_row.find('.beacon_list__row__remove').click(removeClickEventListener);
    new_beacon_data_row.find('.beacon_list__row__complete').click(completeClickEventListener);
    table_body.append(new_beacon_data_row);
    // $new_beacon_data_row = $('.beacon_list__row.prototype').clone(true);
    // $new_beacon_data_row.removeClass('prototype');
    // console.dir($new_beacon_data_row.html());
  });
});