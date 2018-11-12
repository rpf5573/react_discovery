jQuery(document).ready(function ($) {
  /*----------  jQuery Form - Total Team Count  ----------*/
  (function () {
    // 전체 팀 수만큼, <인원설정>,<비밀번호설정>,<타이머>,<점수제공>의 team별 input or button을 갈아 엎습니다.
    function reset_boxes(total_team_count, target_class, $container) {
      //제거
      $.each($container.children(target_class), function (index, val) {
        //console.dir( $(val) );
        $(val).remove();
      });
      //붙이기
      for (var i = 1; i <= total_team_count; i++) {
        //clone( true ) -> 이벤트하고 Data를 갖고온다
        $new_box = $('.prototype' + target_class).clone(true);
        $new_box.removeClass('prototype');
        //console.dir( $new_box.find('.input-group-addon').data('team', i) );
        $new_box.find('.input-group-addon').data('team', i).html(i);
        $container.append($new_box);
      }
    }
  })();

  /*----------  Form - Team Settings  ----------*/
  (function () {
    var option = {
      beforeSubmit: function (data, form, option) {
        var empty_count = 0;
        $united_total_team_count_input = form.find("input[name='united_team_player_count']");
        $password_inputs = form.find("input[name='team_passwords[]']");

        console.log( "before submit" );

        // 빈박스 검사
        console.dir($united_total_team_count_input[0].value);
        if (isNaN(parseInt($united_total_team_count_input[0].value))) {
          empty_count++;
        }
        $.each($password_inputs, function (index, val) {
          // 슬쩍 여기 껴서 리셋시켜야징 ㅇㅋ
          val.style.backgroundColor = 'white';
          if (isNaN(parseInt(val.value))) {
            empty_count++;
          }
        });
        if (empty_count == 21) {
          alert("성공");
          return false;
        }

        // Password 중복 검사
        var response_code = 201;
        $.each($password_inputs, function (index, val) {
          var here = parseInt(val.value);
          if (isNaN(here)) {
            if (!isNaN(parseInt(val.placeholder))) {
              here = parseInt(val.placeholder);
            } else {
              here = 0;
            }
          }
          if (here > 0) {
            for (var i = index + 1; i < 20; i++) {
              var next = parseInt($password_inputs[i].value);
              if (isNaN(next)) {
                if (!isNaN(parseInt($password_inputs[i].placeholder))) {
                  next = parseInt($password_inputs[i].placeholder);
                } else {
                  next = 0;
                }
              }
              if (here == next) {
                val.style.backgroundColor = 'yellow';
                $password_inputs[i].style.backgroundColor = 'yellow';
                response_code = 401; // 중복값
              }
            }
          }
        });

        if (response_code != 201) {
          return false;
        }
      },
      success: function (data) {
        console.log( data );
        var message = JSON.parse(data);
        if (message.response_code == 201) {
          alert("성공");
          window.location.reload(true);
        }
      },
      error: function () {
        alert("Error가 발생하였습니다.");
      }
    }
    forms.team_settings.ajaxForm(option);
  }());

  /*----------  Timer Controls  ----------*/
  (function () {
    function changeGameState(state, callback) {
      console.log(state);
      $.post(
        CONTROLLER_URL, {
          update_game_state: true,
          game_state: state,
        },
        function (data, textStatus, xhr) {
          console.log('changeGameState --> ');
          console.log(data);
          var message = JSON.parse(data);
          if (message.response_code == 201) {
            callback();
          }
        }
      );
    }

    $("input#checkbox-on-game_state").click(function (event) {
      changeGameState(true, function () {
        alert("ON");
      })
    });
    $("input#checkbox-off-game_state").click(function (event) {
      changeGameState(false, function () {
        alert("OFF");
        window.location.reload(true);
      })
    });

    //Deadline Setting
    var modal_timer = $('.modal--timer');
    var form_timer_deadline = $('#form-timer_deadline');
    var inputs = form_timer_deadline.find('.form-control');
    var options = {
      beforeSubmit: function (data, form, option) {
        var minute = parseInt(data[0].value);
        var second = parseInt(data[1].value);
        var time_as_seconds = minute * 60 + second;
        if (isNaN(time_as_seconds)) {
          alert("시간을 입력해 주세요");
          return false;
        }
        inputs[0].placeholder = minute;
        inputs[1].placeholder = second;
        inputs[0].value = '';
        inputs[1].value = '';
        //하나 없애고
        data.pop();
        //0번째 data만 이용하자
        data[0].name = 'timer_deadline';
        data[0].value = time_as_seconds;
      },
      success: function (data) {
        var message = JSON.parse(data);
        if (message.response_code == 201) {
          alert("완료");
        }
      },
      error: function () {
        alert("Error가 발생하였습니다.");
      }
    }
    form_timer_deadline.ajaxForm(options);
    //All Start
    var all_start_btn = $('.modal--timer .btn-all-start');
    all_start_btn.click(function (event) {
      if ($('.modal--timer__each_team_control__control.btn-danger').length == 0) {
        $message_modal = $('.modal--check');
        $message_modal.modal('show');
        $('.modal--check__message').html(' 전체 타이머를 작동 시키시겠습니까? ');
        $('.modal--check .btn-yes').off('click');
        $('.modal--check .btn-yes').click(function (event) {
          $message_modal.modal('hide');
          $.post(
            CONTROLLER_URL, {
              timer_all_start: true,
              total_team_count: total_team_count
            },
            function (data, textStatus, xhr) {
              console.dir(data);
              var message = JSON.parse(data);
              if (message.response_code == 201) {
                alert('전체 팀의 타이머를 작동시켰습니다');
                $('.modal--timer__each_team_control__clock').css('display', 'block');
                $('.modal--timer__each_team_control__control').removeClass('btn-secondary').addClass('btn-danger').html('End');
              } else {
                alert(message.error_message);
              }
            }
          );
          return false;
        });
      } else {
        alert("아직 끄지않은 타이머가 있습니다!");
      }
    });
    //All End
    var all_end_btn = $('.modal--timer .btn-all-end');
    all_end_btn.click(function (event) {
      $message_modal = $('.modal--check');
      $message_modal.modal('show');
      $('.modal--check__message').html(' 전체 타이머를 중지 시키시겠습니까? ');
      $('.modal--check .btn-yes').off('click');
      $('.modal--check .btn-yes').click(function (event) {
        $message_modal.modal('hide');
        $.post(
          CONTROLLER_URL, {
            timer_all_end: true,
            total_team_count: total_team_count
          },
          function (data, textStatus, xhr) {
            var message = JSON.parse(data);
            if (message.response_code == 201) {
              alert('전체 팀의 타이머를 중지시켰습니다');
              $('.modal--timer__each_team_control__clock').css('display', 'none');
              $('.modal--timer__each_team_control__control').removeClass('btn-danger').addClass('btn-secondary').html('Ready');
            } else {
              alert(message.error_message);
            }
          }
        );
        return false;
      });
    });
    //Each End
    $('.modal--timer__each_team_control__control').click(function (event) {
      var $this = $(this);
      var team = $this.siblings('.input-group-addon').data('team');
      //END! 
      if ($this.hasClass('btn-danger')) {
        $.post(
          CONTROLLER_URL, {
            timer_end: true,
            team: team
          },
          function (data, textStatus, xhr) {
            var message = JSON.parse(data);
            if (message.response_code == 201) {
              $this.siblings('.modal--timer__each_team_control__clock').css('display', 'none');
              $this.removeClass('btn-danger').addClass('btn-secondary').html('Ready');
              alert(team + "팀의 타이머 종료");
            } else {
              alert(message.error_message);
            }
          }
        );
      }
    });


    // timer modal이 등장할때, timer states를 가져와서 update
    modal_timer.on('show.bs.modal', function () {
      var controls = $('.modal--timer__controls .modal--timer__each_team_control');
      if (controls.length > 0) {
        $.post(
          CONTROLLER_URL, {
            'get_timer_states': true,
            'total_team_count': total_team_count
          },
          function (data, textStatus, jqXHR) {
            var message = JSON.parse(data);
            if (message.response_code == 201) {
              $.each(message.value, function (index, element) {
                var control = $(controls[index]).find('.modal--timer__each_team_control__control');
                var clock = $(controls[index]).find('.modal--timer__each_team_control__clock');

                if ( element.state ) {
                  console.dir("state == true");
                  control.removeClass('btn-secondary').addClass('btn-info');
                  control.html('가동중');
                  clock.css('display', 'block');
                } else {
                  control.removeClass('btn-info').addClass('btn-secondary');
                  control.html('준비중');
                  clock.css('display', 'none');
                }
              });
            }
          }
        );
      }
    });
  })();
  /*----------  Modal -- Options  ----------*/
  (function () {
    /*----------  Switches  ----------*/
    var switches = {
      beacon: {
        on: $('input#checkbox-on-beacon'),
        off: $('input#checkbox-off-beacon')
      },
      test_mode: {
        on: $('input#checkbox-on-test_mode'),
        off: $('input#checkbox-off-test_mode')
      },
      player_list: {
        on: $('input#checkbox-on-player_list'),
        off: $('input#checkbox-off-player_list')
      },
      joker_info: {
        on: $('input#checkbox-on-joker_info'),
        off: $('input#checkbox-off-joker_info')
      }
    };

    function changeStateOf(target, state, callback) {
      var parms = {};
      parms['option_update'] = true;
      parms[target + '_state'] = state;
      $.post(
        CONTROLLER_URL, parms,
        function (data, textStatus, xhr) {
          console.log(data);
          var message = JSON.parse(data);
          callback(message);
        }
      );
    }

    /*----------  Beacon  ----------*/
    switches.beacon.on.click(function (event) {
      changeStateOf('beacon', true, function (message) {
        if (message.response_code == 201) {
          $('.modal--options__beacon__body__beacon_list').slideDown('slow');
        } else {
          alert(message.error_message);
        }
      });
    });
    switches.beacon.off.click(function (event) {
      changeStateOf('beacon', false, function (message) {
        if (message.response_code == 201) {
          $('.modal--options__beacon__body__beacon_list').slideUp('slow');
        } else {
          alert(message.error_message);
        }
      });
    });

    var updateClickEventListener = function (event) {
      var $this = $(this);
      var row = $this.parent().parent();
      row.addClass('update');
    };
    var removeClickEventListener = function (event) {
      var $this = $(this);
      var row = $this.parent().parent();
      var post = row.data('post');
      $.post(
        CONTROLLER_URL, {
          //정말 신기하다! beacon_data는 javascript object인데 , 서버쪽에서 그냥 받아서 쓸수 있는 형태로 바뀌네!! 신기!!!
          remove_beacon_data: true,
          post: post
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
      var span_post = row.find('.modal--options__beacon__body__beacon_list__row__data--post > span');
      var input_post = row.find('.modal--options__beacon__body__beacon_list__row__data--post > input');
      var span_item = row.find('.modal--options__beacon__body__beacon_list__row__data--item > span');
      var input_item = row.find('.modal--options__beacon__body__beacon_list__row__data--item > input');
      var span_url = row.find('.modal--options__beacon__body__beacon_list__row__data--url > span');
      var input_url = row.find('.modal--options__beacon__body__beacon_list__row__data--url > input');
      var beacon_data = {
        post: input_post.val(),
        item: input_item.val(),
        url: input_url.val()
      }
      $.post(
        CONTROLLER_URL, {
          //정말 신기하다! beacon_data는 javascript object인데 , 서버쪽에서 그냥 받아서 쓸수 있는 형태로 바뀌네!! 신기!!!
          beacon_data: beacon_data
        },
        function (data, textStatus, xhr) {
          console.log(data);
          var message = JSON.parse(data);
          if (message.response_code == 201) {
            alert("성공");
            row.data('post', beacon_data.post);
            span_post.html(beacon_data.post);
            span_item.html(beacon_data.item);
            span_url.html(beacon_data.url);
            row.removeClass('new');
            row.removeClass('update');
          } else {
            alert("ERROR!");
          }
        }
      );
    };

    $('.modal--options__beacon__body__beacon_list__row__update').click(updateClickEventListener);
    $('.modal--options__beacon__body__beacon_list__row__remove').click(removeClickEventListener);
    $('.modal--options__beacon__body__beacon_list__row__complete').click(completeClickEventListener);
    $('.modal--options__beacon__body__beacon_list__add').click(function (event) {
      var table_body = $('.modal--options__beacon__body__beacon_list tbody');
      // <tr class="modal--options__beacon__body__beacon_list__row modal--options__beacon__body__beacon_list__row--new prototype">
      //   <th scope="row" class="modal--options__beacon__body__beacon_list__row__data modal--options__beacon__body__beacon_list__row__data--post">
      //     <span></span>
      //     <input name="post" class="form-control " value="" type="text">
      //   </th>
      //   <td class="modal--options__beacon__body__beacon_list__row__data modal--options__beacon__body__beacon_list__row__data--item">
      //     <span></span>
      //     <input name="item" class="form-control " value="" type="text">
      //   </td>
      //   <td class="modal--options__beacon__body__beacon_list__row__data modal--options__beacon__body__beacon_list__row__data--url">
      //     <span></span>
      //     <input name="url" class="form-control" value="" type="text">
      //   </td>
      //   <td class="d-flex" style="min-width: 120px;">
      //     <button type="button" class="btn btn-outline-warning modal--options__beacon__body__beacon_list__row__update btn-sm"> 수정 </button>
      //     <button type="button" class="btn btn-outline-danger modal--options__beacon__body__beacon_list__row__remove btn-sm ml-2" data-post="1"> 삭제 </button>
      //     <button type="button" class="btn btn-success modal--options__beacon__body__beacon_list__row__complete btn-sm" data-post="1"> 완료 </button>
      //   </td>
      // </tr>
      var rowHtmlString = '<tr class="modal--options__beacon__body__beacon_list__row new"><th scope="row" class="modal--options__beacon__body__beacon_list__row__data modal--options__beacon__body__beacon_list__row__data--post"><span></span><input name="post" class="form-control " value="" type="text"></th><td class="modal--options__beacon__body__beacon_list__row__data modal--options__beacon__body__beacon_list__row__data--item"><span></span><input name="item" class="form-control " value="" type="text"></td><td class="modal--options__beacon__body__beacon_list__row__data modal--options__beacon__body__beacon_list__row__data--url"><span></span><input name="url" class="form-control" value="" type="text"></td><td class="d-flex" style="min-width: 120px;"><button type="button" class="btn btn-outline-warning modal--options__beacon__body__beacon_list__row__update btn-sm"> 수정 </button><button type="button" class="btn btn-outline-danger modal--options__beacon__body__beacon_list__row__remove btn-sm ml-2"> 삭제 </button><button type="button" class="btn btn-success modal--options__beacon__body__beacon_list__row__complete btn-sm"> 완료 </button></td></tr>';
      var new_beacon_data_row = $($.parseHTML(rowHtmlString));
      new_beacon_data_row.find('.modal--options__beacon__body__beacon_list__row__update').click(updateClickEventListener);
      new_beacon_data_row.find('.modal--options__beacon__body__beacon_list__row__remove').click(removeClickEventListener);
      new_beacon_data_row.find('.modal--options__beacon__body__beacon_list__row__complete').click(completeClickEventListener);
      table_body.append(new_beacon_data_row);
      // $new_beacon_data_row = $('.modal--options__beacon__body__beacon_list__row.prototype').clone(true);
      // $new_beacon_data_row.removeClass('prototype');
      // console.dir($new_beacon_data_row.html());
    });

    /*----------  Test Mode  ----------*/
    switches.test_mode.on.click(function (event) {
      changeStateOf('test_mode', true, function (message) {
        if (message.response_code == 201) {
          alert("명단 자동입력 + 업로드 / 포스트 선택시간 5초로 설정되었습니다");
        } else {
          alert(message.error_message);
          switches.test_mode.off.trigger('click');
        }
      });
    });
    switches.test_mode.off.click(function (event) {
      changeStateOf('test_mode', false, function (message) {
        if (message.response_code == 201) {
          alert("명단 수동입력 + 업로드 / 포스트 선택시간 180초로 원상복귀 되었습니다");
        } else {
          alert(message.error_message);
        }
      });
    });

    /*----------  Player List  ----------*/
    switches.player_list.on.click(function (event) {
      changeStateOf('player_list', true, function (message) {
        if (message.response_code == 201) {
          $('.modal--options__player_list__body').slideDown('fast', function () {});
        } else {
          alert(message.error_message);
        }
      });
    });
    switches.player_list.off.click(function (event) {
      changeStateOf('player_list', false, function (message) {
        if (message.response_code == 201) {
          $('.modal--options__player_list__body').slideUp('fast', function () {
            if (switches.joker_info.on.prop("checked")) {
              console.log('on이 체크되어있는 상태입니다');
              switches.joker_info.off.trigger('click');
            } else {
              console.log('on이 체크되어있는 상태가 아닙니다');
            }
          });
        } else {
          alert(message.error_message);
        }
      });
    });

    /*----------  Joker Info  ----------*/
    switches.joker_info.on.click(function (event) {
      changeStateOf('joker_info', true, function (message) {
        if (message.response_code == 201) {
          $('.modal--options__joker_info__body').slideDown('slow', function () {});
        } else {
          alert(message.error_message);
        }
      });
    });
    switches.joker_info.off.click(function (event) {
      changeStateOf('joker_info', false, function (message) {
        if (message.response_code == 201) {
          $('.modal--options__joker_info__body').slideUp('slow', function () {});
        } else {
          alert(message.error_message);
        }
      });
    });

    /*----------  Joker Info Questions를 다입력하고 서버로 보내자!  ----------*/
    forms.joker_info_questions.ajaxForm({
      filtering: function (el, index) {
        console.dir(el);
        console.log(index);
        if (el.nodeName != 'BUTTON') {
          if (el.value.length > 1) {
            return el;
          } else if (el.placeholder.length > 1) {
            el.value = el.placeholder;
            return el;
          }
        }
      },
      beforeSubmit: function (data, form, option) {
        console.log("beforeSubmit called");
        console.dir(data);
        if (data.length == 0) {
          alert("성공"); // 이건 에러지만 성공을 누른다!
          return false;
        }
      },
      success: function (data) {
        console.log(data);
        var message = JSON.parse(data);
        if (message.response_code == 201) {
          $.each($(".modal--options__joker_info__body__questions__question_setting input[name='joker_info_questions[]']"), function (index, val) {
            if (val.value.length > 1) {
              val.placeholder = val.value;
              val.value = '';
            }
          });
          alert("성공!");
        } else {
          alert("실패");
        }
      },
      error: function () {
        alert("Error가 발생하였습니다.");
      }
    });
  })();

  /*----------  Modal -- Mpas  ----------*/
  (function () {

    var upload_input_ids = {
      whole_map: 'whole_map',
      assistant_map: 'assistant_map',
      post_maps: 'post_maps',
      company : 'company'
    }
    $.each(upload_input_ids, function (index, id) {
      ready_file_upload(id);
      //load_existing_files( id );
    });

    function ready_file_upload(upload_input_id) {
      var sendQueue = new Array();
      var queueSize = 0;
      var theUrl = '../Resources/Libraries/jQuery_File_Upload/Server/php/index.php?the_dir=' + upload_input_id;
      var _acceptFileTypes = /(\.|\/)(jpg|jpe?g|png)$/i;
      if (upload_input_id == 'post_maps') {
        _acceptFileTypes = /(\.|\/)(jpg)$/i;
      }
      $('#fileupload--' + upload_input_id).fileupload({
        url: theUrl,
        acceptFileTypes: _acceptFileTypes,
        autoUpload: false,
        change: function (e, data) {
          console.log('change called');
          queueSize = data.files.length;
          console.log(queueSize);
          $('.modal--maps__upload_box_container__' + upload_input_id).find('.progress_container').removeClass('d-none');
        },
        add: function (e, data) {
          console.log('add called');
          sendQueue.push(data);
          if (sendQueue.length == queueSize) {
            $.post(theUrl, {
              reset: 'true'
            }, function (data, textStatus, xhr) {
              var message = JSON.parse(data);
              if (message.response_code == 201) {
                $.each(sendQueue, function (index, val) {
                  val.submit();
                });
              }
            });
          }
        },
        done: function (e, data) {
          console.log('done --> start');
          console.dir(data);
          console.log('done --> end');
        },
        progressall: function (e, data) {
          var progress = parseInt(data.loaded / data.total * 100, 10);
          $('.modal--maps__upload_box_container__' + upload_input_id).find('.progress-bar').css('width', progress + "%");
        },
        fail: function (e, data) {
          console.log("fail --> start");
          console.dir(e);
          console.log("fail --> end");
        }
      }).bind('fileuploadstop', function (event) {
        console.log('fileuploadstop --> start ');
        console.dir(event);
        console.log('fileuploadstop --> end ');
        alert("업로드 완료");
        $('.modal--maps__upload_box_container__' + upload_input_id).find('.file_select').text('재업로드');
        $('.modal--maps__upload_box_container__' + upload_input_id).find('.fileinput-button').removeClass('btn-success').addClass('btn-info');
        $('.modal--maps__upload_box_container__' + upload_input_id).find('.progress_container').addClass('d-none').find('.progress-bar').css('width', 0);
        if (queueSize > 0 && upload_input_id == 'post_maps') {
          update_posts_count(queueSize);
        }
        // 초기화!
        sendQueue = new Array();
        queueSize = 0;
      });
    }


    function load_existing_files(upload_input_id) {
      $('#fileupload--' + upload_input_id).addClass('fileupload-processing');
      $.ajax({
        url: $('#fileupload--' + upload_input_id).fileupload('option', 'url'),
        dataType: 'json',
        context: $('#fileupload--' + upload_input_id)[0]
      }).always(function () {
        $(this).removeClass('fileupload-processing');
      }).done(function (result) {
        $(this).fileupload('option', 'done').call(this, $.Event('done'), {
          result: result
        });
      });
    }

    function update_posts_count(count) {
      $.post(
        CONTROLLER_URL, {
          update_posts_count: true,
          count: count
        },
        function (data, textStatus, xhr) {
          console.dir(data);
          var message = JSON.parse(data);
          if (message.response_code == 201) {
            setTimeout(function () {
              alert('포스트의 개수를 업데이트 했습니다');
            }, 300);
          } else {
            alert(message.error_message);
          }
        }
      );
    }
  })();

  /*----------  Modal -- Points  ----------*/
  (function () {
    var inputs = $(".modal--points input[name='points[]']");
    $('.modal--points .btn-success').click(function (event) {
      var options = {
        beforeSubmit: function (data, form, option) {},
        success: function (data) {
          var message = JSON.parse(data);
          if (message.response_code == 201) {
            $.each(inputs, function (index, input) {
              var $input = $(input);
              var point = $input.val();
            });
          }
          alert("성공");
          forms.points.clearForm();
          $('.modal--points').modal('hide');
        },
        error: function () {
          alert("Error가 발생하였습니다.");
        }
      };
      forms.points.ajaxSubmit(options);
    });
  })();

  /*----------  Modal -- Result Page  ----------*/
  (function () {
    $('.modal--result_page').on('shown.bs.modal', function () {
      $(this).find('iframe').attr('src', BASE_URL + '/Manager/result.php');
    });
  })();

  /*----------  Modal -- Mapping Points  ----------*/
  (function () {
    $('.modal--mapping_points__point_box__modification-btn').click(function (event) {
      var $this = $(this);
      var container = $this.closest('.modal--mapping_points__point_box');
      var point_span = $this.siblings('span');
      var point_info = point_span.data('point_info');

      var prototype = $('.prototype.modal--mapping_points__point-editmode').clone();
      prototype.removeClass('prototype');
      var point_input_box = prototype.children('.modal--mapping_points__point-editmode__input-box');
      var cancle_btn = prototype.children('.modal--mapping_points__point-editmode__cancle-btn');
      var complete_btn = prototype.children('.modal--mapping_points__point-editmode__complete-btn');
      point_input_box.attr('placeholder', point_info.point);
      container.append(prototype);
      point_span.css('display', 'none');
      $this.css('display', 'none');
      prototype.css('display', 'inline-block');

      cDir('point_info', point_info);

      cancle_btn.click(function (event) {
        prototype.remove();
        point_span.css('display', 'inline-block');
        $this.css('display', 'inline-block');
      });
      complete_btn.click(function (event) {
        point_info.point = point_input_box.val();
        $.post(
          CONTROLLER_URL,
          point_info,
          function (data) {
            var message = JSON.parse(data);
            if (message.response_code == 201) {
              //비우고
              if (point_info.mapping_target == 'time_minus') {
                point_span.text("(-)" + point_info.point);
              } else {
                point_span.text(point_info.point);
              }
              prototype.remove();
              point_span.css('display', 'inline-block');
              $this.css('display', 'inline-block');
            }
          });
      });
    });
  })();

  /*----------  Modal -- Manager + Assistant Passwords  ----------*/
  (function () {
    var inputs = {
      manager: forms.manager_password.find('input[name=password]'),
      assistant: forms.assistant_password.find('input[name=password]')
    }
    var options = {
      manager: {
        beforeSubmit: function (data, form, e) {},
        success: function (data) {
          var message = JSON.parse(data);
          if (message.response_code == 201) {
            inputs.manager.attr('placeholder', ('현재: ' + inputs.manager.val())).val('');
            alert('성공!');
          }
        },
        error: function (e) {
          alert(e);
        }
      },
      assistant: {
        beforeSubmit: function (data, form, e) {

        },
        success: function (data) {
          console.log(data);
          var message = JSON.parse(data);
          if (message.response_code == 201) {
            inputs.assistant.attr('placeholder', ('현재: ' + inputs.assistant.val())).val('');
            alert('성공!');
          }
        },
        error: function (e) {
          alert(e);
        }
      }
    }
    forms.manager_password.ajaxForm(options.manager);
    forms.assistant_password.ajaxForm(options.assistant);
  })();
  /*----------  Reset  ----------*/
  (function () {
    $('.menu__item--reset > button').click(function (event) {
      $message_modal = $('.modal--check');
      $message_modal.modal('show');

      $('.modal--check__message').html(' 모든 세팅을 리셋하시겠습니까? <br> (단, 관리자 비밀번호, 점수배분표, 비콘 등등..은 기본값을 유지합니다. ) ');
      $('.modal--check .btn-yes').off('click');
      $('.modal--check .btn-yes').click(function (event) {
        $.post(
          CONTROLLER_URL, {
            reset: true
          },
          function (data, textStatus, xhr) {
            cDir('reset data', data);
            if (parseInt(data) == 201) {
              alert('리셋 완료!');
              window.location.reload(true);
            } else {
              alert('에러 발생');
            }
          }
        );
      });
    });
  })();

  /*----------  Modal -- Edit Team Info  ----------*/
  (function () {
    $modal = $('.modal--edit_team_info');
    $modal.find('.modal--edit_team_info__trigger').click(function (event) {
      var $this = $(this);
      $.post(
        CONTROLLER_URL, {
          update_team_info: true,
          team: $this.data('team')
        },
        function (data, textStatus, xhr) {
          console.log(data);
          var message = JSON.parse(data);
          if (message.response_code == 201) {
            alert("성공");
          } else {
            alert("에러발생");
          }
        }
      );
    });
  })();

  /*----------  Reset  ----------*/
  (function () {
    $('.menu__item--reset > button').click(function (event) {
      $message_modal = $('.modal--check');
      $message_modal.modal('show');

      $('.modal--check__message').html(' 모든 세팅을 리셋하시겠습니까? <br> (단, 관리자 비밀번호, 점수배분표, 비콘 등등..은 기본값을 유지합니다. ) ');
      $('.modal--check .btn-yes').off('click');
      $('.modal--check .btn-yes').click(function (event) {
        $.post(
          CONTROLLER_URL, {
            reset: true
          },
          function (data, textStatus, xhr) {
            cDir('reset data', data);
            if (parseInt(data) == 201) {
              alert('리셋 완료!');
              window.location.reload(true);
            } else {
              alert('에러 발생');
            }
          }
        );
      });
    });
  })();

  /*----------  Open Warehouse Button  ----------*/
  (function () {
    var btn = $('.float_btn--open_warehouse');
    btn.click(function (event) {
      var self = $(this);
      self.animateCss('bounceIn');
      setTimeout(function () {
        var url = BASE_URL + "/Manager/warehouse.php";
        window.open(url, '_blank');
      }, 500);
    });
  })();

  /*----------  Load More Button  ----------*/
  (function () {
    function shuffleArray(d) {
      for (var c = d.length - 1; c > 0; c--) {
        var b = Math.floor(Math.random() * (c + 1));
        var a = d[c];
        d[c] = d[b];
        d[b] = a;
      }
      return d;
    };

    function getFileExtension(filename) {
      var ext = /^.+\.([^.]+)$/.exec(filename);
      if (ext == null) {
        return false;
      } else if (ext[1].length > 7) {
        return false;
      } else {
        return ext[1];
      }
    }

    function classificationExtension(filename) {
      var ext = getFileExtension(filename).toLowerCase();
      switch (ext) {
        case 'jpg':
          return 'img';
          break;
        case 'jpeg':
          return 'img';
          break;
        case 'png':
          return 'img';
          break;
        case 'mp4':
          return 'video';
          break;
        case 'mov':
          return 'video';
          break;
        case '3gp':
          return 'video';
          break;
        default:
          return 'fail';
          break;
      }
    }

    function handleEvaluateUploadedFile(team, file_name, $container, type) {
      cDir('handleEvaluateUploadedFile - type', type);
      var evaluate_uploaded_file_box = $(('.evaluate_uploaded_file--' + type + '.prototype')).clone();
      cDir('evaluate_uploaded_file_box', evaluate_uploaded_file_box);
      evaluate_uploaded_file_box.find(type).attr('src', ('../User/Uploads/' + team + '/' + file_name));
      evaluate_uploaded_file_box.removeClass('prototype');
      evaluate_uploaded_file_box.find('.team').text(team);
      evaluate_uploaded_file_box.find('[name=team]').val(team);
      evaluate_uploaded_file_box.find('[name=file_name]').val(file_name);
      evaluate_uploaded_file_box.find('form').ajaxForm({
        beforeSubmit: function (data, form, e) {
          cDir("evaluate_uploaded_file_box data beforeSubmit", data);
          form.find('.btn-primary').attr("disabled", "disabled");
        },
        success: function (data) {
          cDir("evaluate_uploaded_file_box data Success", data);
          var message = JSON.parse(data);
          if (message.response_code == 201) {
            //cDir( 'evaluate_uploaded_file_box.find([name=point])', evaluate_uploaded_file_box.find('[name=point]') );
            var point = evaluate_uploaded_file_box.find('[name=point]').val();
            alert(team + "팀에게" + point + "점을 제공하였습니다");
            evaluate_uploaded_file_box.remove();
          }
        },
        error: function (e) {
          alert(e);
        }
      });
      $container.append(evaluate_uploaded_file_box);
    }

    function can_load_more() {
      if ($('.evaluate_uploaded_file:not(.prototype)').length > 0) {
        alert("아직 점수를 주지 않은 팀이 있습니다");
        return false;
      }
      return true;
    }
    var btn = $('.float_btn--load_more');
    btn.click(function (event) {
      if (can_load_more()) {
        var self = $(this);
        self.animateCss('bounceIn');
        $.post(
          CONTROLLER_URL, {
            get_uploaded_files_name: true,
            total_team_count: total_team_count
          },
          function (data, textStatus, xhr) {
            var message = JSON.parse(data);
            if (message.response_code == 201) {
              var container = $('.evaluate_uploaded_files_container');
              var uploaded_files_name = shuffleArray(message.value);
              for (var i = 0; i < uploaded_files_name.length; i++) {
                if (uploaded_files_name[i].files.length > 0) {
                  var team = parseInt((uploaded_files_name[i].files[0]).split('_')[0]);
                  for (var z = 0; z < uploaded_files_name[i].files.length; z++) {
                    var file_name = uploaded_files_name[i].files[z];
                    var file_exts = classificationExtension(file_name);
                    handleEvaluateUploadedFile(team, file_name, container, file_exts);
                  }
                }
              }
            } else {
              alert(message.error_message);
            }
          });
      }
    });
  })();
});