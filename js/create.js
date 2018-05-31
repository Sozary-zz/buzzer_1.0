var time
var dTime = {
  m: 0,
  s: 0,
  h: 0
}
var table = document.querySelector('#studResult')
$('#time').keypress(function(e) {
  if (e.keyCode == 13)
    $('#startbtn').click();
});
$.ajax({
  url: "?action=teacherReleased&name=" + getCookie('name'),
  success: function(result) {
    if (result == "0x0") {
      $('#same').hide()
      $('#empty').hide()
      $('#nope').hide()
      $('#results').hide()
      $('#endResults').hide()
      $('.result-field').hide()
    } else {
      $('#same').hide()
      $('#empty').hide()
      $('#nope').hide()
      $('#asktime').hide()
      $('#startbtn').hide()
      $('.result-field').hide()
      $('#endResults').hide()
    }
  }
})

let endResults = () => {
  $.ajax({
    url: "?action=resetSession&name=" + getCookie('name'),
    success: function(result) {
      if (result == "0x1") {
        $('.result-field').fadeOut()
        $('#results').fadeOut()
        $('#endResults').fadeOut()
        $('#asktime').fadeIn()
        $('#startbtn').fadeIn()
      }
    }
  })
}
let updateResults = () => {

  dTime.s--;
  if (dTime.s < 0) {
    dTime.s = 59
    dTime.m--;
    if (dTime.m < 0) {
      if (dTime.h == 0) {
        dTime.m = 0
        dTime.h = 0
        dTime.s = 0
        clearInterval(time);
        $('#endResults').fadeIn()
      } else {
        dTime.m = 59
        dTime.h--;
      }

    }
  }
  document.querySelector('.time-left').innerText = 'Temps restant: ' + dTime.h + ' heures ' + dTime.m + ' minutes et ' + dTime.s + ' secondes'
  updateTable()
}
let updateTable = (callback) => {
  $.ajax({
    url: "?action=gatherData&name=" + getCookie('name'),
    success: function(result) {
      if (result != "0x0") {
        let data = JSON.parse(result)

        for (let i = table.children.length; i < data.length; i++) {
          let d = data[i].split(',')
          console.log(d);
          let tr = document.createElement("tr")
          let th = document.createElement("th")
          let td = document.createElement("td")
          if (i == 0)
            tr.classList.add('table-success')
          else if (i == 1)
            tr.classList.add('table-danger')
          else if (i == 2)
            tr.classList.add('table-warning')
          else if (i % 2 == 0)
            tr.classList.add('table-active')
          th.setAttribute('scope', 'row')
          th.appendChild(document.createTextNode(d[0]))
          td.appendChild(document.createTextNode(i + 1))
          tr.appendChild(th)
          tr.appendChild(td)
          table.appendChild(tr)
        }
      }
      callback()
    }
  })
}
let showResults = () => {
  let elem = document.querySelector('.time-left')
  $("#results").prop('disabled', true);
  $.ajax({
    url: "?action=timeLeft&name=" + getCookie('name'),
    success: function(result) {
      $('.result-field').fadeIn()
      let t = parseInt(result)
      if (t < 0) {
        elem.innerText = "Temps écoulé."
        updateTable(() => {
          $('#endResults').fadeIn()

        })


      } else {
        dTime.m = parseInt(t / 60)
        dTime.s = t % 60
        dTime.h = parseInt(t / 3600)
        time = setInterval(updateResults, 1000);
      }

    }
  })

}

$('li[name=create]').addClass('active')

let checkFields = () => {
  if ($('#name').val() == "" || $('#pass').val() == "") {
    $('#empty').show()
    return
  }
}
let create = () => {
  checkFields()
  req("create", (result) => {
    if (result == "0x1") {
      $('#same').show();
    } else {
      setCookie("name", $('#name').val(), 30)
      setCookie("pass", $('#pass').val(), 30)

      location.reload();
    }
  })

}
let req = (type, callback) => {
  let u
  if (type == "create")
    u = "?action=createProfile&name=" + $('#name').val() + "&pass=" + $('#pass').val()
  else
    u = "?action=connecProfile&name=" + $('#name').val() + "&pass=" + $('#pass').val()

  $.ajax({
    url: u,
    success: function(result) {
      callback(result)
    }
  })
}
let connec = () => {
  checkFields()
  req("connec", (result) => {
    if (result == "0x1") {
      setCookie("name", $('#name').val(), 30)
      setCookie("pass", $('#pass').val(), 30)
      location.reload();
    } else {
      $('#nope').show();
    }
  })
}

let start = () => {
  if ($('#time').val() == "" || $('#time').val() < 0) {
    $('#empty').show()
    return
  }
  while (table.firstChild)
    table.removeChild(table.firstChild);

  $('#asktime').fadeOut()
  $('#startbtn').fadeOut();
  setTimeout(() => {
    $('#results').fadeIn()
    $("#results").prop('disabled', false);
  }, 400);


  $.ajax({
    url: "?action=releaseAccess&name=" + getCookie('name') + "&time=" + $('#time').val(),
    success: function(result) {
      //  console.log(result);
    }
  })
}