function objetoAjax () {
  var xmlhttp = false
  try {
    xmlhttp = new ActiveXObject('Msxml2.XMLHTTP')
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject('Microsoft.XMLHTTP')
    } catch (E) {
      xmlhttp = false
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest !== 'undefined') {
    xmlhttp = new XMLHttpRequest()
  }
  return xmlhttp
}

function refreshdiv () {
  var url = 'cont.php'
  $.ajax({
    type: 'POST',
    url: url,
    data: $('#formularioRE').serialize(),
    success: function (data) {
      $('#cont-conversation').html(data)
    }
  })
}

function scrollBtm () {
  let d = $('.cont-conversation')
  d.scrollTop(d.prop("scrollHeight"))
}
function enviarDatosMensaje () {
  // donde se mostrará lo resultados
  let btnMensaje = document.getElementById('mensaje')
  // valores de los inputs

  let he = document.frmMsg.he.value
  let you = document.frmMsg.you.value
  let mensaje = document.frmMsg.mensaje.value

  btnMensaje.value = ''
  // instanciamos el objetoAjax
  let ajax = objetoAjax()
  // usando del medoto POST
  // archivo que realizará la operacion
  // actualizacion.php
  ajax.open('POST', 'actualizacion.php', true)
  // muy importante este encabezado ya que hacemos uso de un formulario
  ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  // enviando los valores
  ajax.send('he=' + he + '&you=' + you + '&mensaje=' + mensaje)
}

function pedirDatos (idempleado) {
  // donde se mostrará el formulario con los datos
  let divFormulario = document.getElementById('formulario')
  // instanciamos el objetoAjax
  let ajax = objetoAjax()
  // uso del medotod GET
  ajax.open('GET', 'consulta_por_id.php?idemp=' + idempleado)
  ajax.onreadystatechange = function () {
    if (ajax.readyState === 4) {
      // mostrar resultados en esta capa
      divFormulario.innerHTML = ajax.responseText
      // mostrar el formulario
      divFormulario.style.display = 'block'
    }
  }
  // como hacemos uso del metodo GET
  // colocamos null
  ajax.send(null)
}
