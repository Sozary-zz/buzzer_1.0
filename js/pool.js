$('#nope').hide()
$('#empty').hide()
$('.buzz').hide()
$('#pseudo').keypress(function(e) {
  if (e.keyCode == 13)
    $('#sub').click();
});
$('#name').keypress(function(e) {
  if (e.keyCode == 13)
    $('#sub').click();
});
var buzzed = false
var loop

let find = (item) => {
  if ($('#name').val() == "" || $('#pseudo').val() == "") {
    $('#empty').show()
    return
  }
  $.ajax({
    url: "?action=accessBuzz&user=" + $('#name').val(),
    success: function(result) {

      if (result == "0x1") {
        $('#nope').show();
      } else {
        let data = JSON.parse(result)
        document.querySelector('.prof').innerText = data[0]
        $('.join-form').fadeOut()
        setTimeout(() => {
          $('.buzz').fadeIn()
          $('.buzzer').hide();
          $('.buzzed').hide();
          $('.cant-buzz').hide();
          $('.surdelay').hide();

          waitForBuzz()
        }, 400);

      }
    }
  });
}

let waitForBuzz = () => {
  loop = setInterval(() => {
    seekingLoop()
  }, 400);
}

let seekingLoop = () => {
  $.ajax({
    url: "?action=isReleasedAccess&name=" + $('#name').val() + "&player=" + $('#pseudo').val(),
    success: function(result) {
      clearInterval(loop)
      if (result == "0x1") {

        $('.loader').fadeOut()

        setTimeout(() => {
          $('.buzzer').fadeIn()
          document.querySelector('.student').innerText = $('#pseudo').val()
        }, 400)
      } else if (result == "0x2") {
        $('.loader').fadeOut()

        setTimeout(() => {
          $('.cant-buzz').fadeIn()
        }, 400)
      } else if (result == "0x3") {
        $('.loader').fadeOut()
        setTimeout(() => {
          $('.surdelay').fadeIn()
        }, 400)
      }
    }
  })
}

let buzz = () => {
  if (!buzzed) {
    buzzed = true
    $.ajax({
      url: "?action=buzz&player=" + $('#pseudo').val() + '&user=' + $('#name').val(),
      success: function(result) {
        if (result == "0x1") {
          $('.buzzer').fadeOut()
          setTimeout(() => {
            $('.buzzed').fadeIn()
          }, 400)
        }
        buzzed = false
      }
    })
  }

}

$('li[name=joinPool]').addClass('active')