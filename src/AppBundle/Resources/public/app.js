/* globals $ */

$(function () {
  var totalClick = 0; // Refresh

  $('nav li a.add').click(function (e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $('.form-send').toggle();
  });

  $('.form-send form').submit(function (e) {

    var text_ = $.trim($('textarea[name="insulte"]').val()),
      check_ = $('input[name="bonneInsulte"]').is(':checked') ? 1 : 0,
      url_ = $(this).attr('action'),
      ok = false;
    $.ajax({
      url: 'verif',
      type: 'POST',
      data: {insulte: text_, check: check_},
      dataType: 'json',
      async: false,
      success: function (data) {
        if (data.response != 1) {
          alert(data.response)
        }
        else {
          ok = true;
        }
      }
    });
    return ok;
  });

  $('.menu a:first').click(function (e) {
    if (totalClick < 10) {
      e.preventDefault();
      $.get('insulte-aleatoire', function (data) {
        $('.insulte').text('');
        $('.insulte').html(data);
      });
      totalClick++;
    } else {
      location.reload();
    }
  });

  $(this).keydown(function (e) {
    if ($('.form-send').is(':hidden')) {
      var k = parseInt(e.which, 10);
      if (k == 32 || k == 73) {
        $('.menu a:first').click();
        e.preventDefault();
      }
    }
  });
});