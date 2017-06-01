function backendReady () {
  /*  ACCORDION  */
  var acc = document.getElementsByClassName('accordion')
  var i

  for (i = 0; i < acc.length; i++) {
    // Abrirlos al encenderlo
    acc[i].nextElementSibling.style.display = 'block'
    $(acc[i].lastChild).toggleClass('fa-caret-down')
    $(acc[i].lastChild).toggleClass('fa-caret-up')

    acc[i].onclick = function () {
      let icon = $(this.lastChild)

      icon.toggleClass('fa-caret-down')
      icon.toggleClass('fa-caret-up')

      var panel = this.nextElementSibling
      if (panel.style.display === 'block') {
        panel.style.display = 'none'
      } else {
        panel.style.display = 'block'
      }
    }
  }
}

// function accordionPlanets () {
//   /*  ACCORDION  */
//   var acc = document.getElementsByClassName('accordionPlanet')

//   for (i = 0; i < acc.length; i++) {
//     acc[i].onclick = function () {
//       $('.contentPlanets .panel').removeClass('active')
//       $('.contentPlanets .fa-caret-up').addClass('fa-caret-down')
//       $('.contentPlanets .fa-caret-up').removeClass('fa-caret-up')

//       let icon = $(this).children('i:nth-child(2)')
//       icon.toggleClass('fa-caret-down')
//       icon.toggleClass('fa-caret-up')

//       var panel = this.nextElementSibling
//       $(panel).addClass('active')
//     }
//   }
// }
