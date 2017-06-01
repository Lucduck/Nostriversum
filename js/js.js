var msg = `%c
                                                                   
 :::        :::    ::: :::::::::  :::    :::  ::::::::  :::    ::: 
 :+:        :+:    :+: :+:    :+: :+:    :+: :+:    :+: :+:   :+:  
 +:+        +:+    +:+ +:+    +:+ +:+    +:+ +:+        +:+  +:+   
 +#+        +#+    +:+ +#+    +:+ +#+    +:+ +#+        +#++:++    
 +#+        +#+    +#+ +#+    +#+ +#+    +#+ +#+        +#+  +#+   
 #+#        #+#    #+# #+#    #+# #+#    #+# #+#    #+# #+#   #+#  
 ##########  ########  #########   ########   ########  ###    ### 
                                                                   %c
   =============================================================   %c
     ¡Bienvenid@ a la consola! Parece que sabes lo que haces.      
             ¡Y si no lo sabes mejor no toques mucho!              %c
      =======================================================      
                                                                   `
console.log(msg, 'background: #333; color: #ddd', 'background: #333; color: #FFE4A0', 'background: #333; color: #FFD56E', 'background: #333; color: #FFE4A0')

jQuery(document).ready(function () {
  $('.burger-bubble > p').css('display', 'none')
  $('.burger-bubble > h2').css('display', 'none')

  $('.click').click(function (event) { menu() })
  $('.click-ubication').click(function (event) { map() })

  $('.burger-bubble > h2').click(function (event) {
    let element = $(this).attr('menu')
    $('html, body').stop().animate({
      scrollTop: jQuery(element).offset().top
    }, 1000)
    menu()
  })
})

function menu () {
  if ($('.ubication-bubble').attr('class') === 'ubication-bubble active') {
    $('.ubication-bubble').toggleClass('active')
  }
  $('.click').parent().toggleClass('active')
  $('.burger-bubble').toggleClass('active')
  if ($('.burger-bubble > p').attr('class') === 'active') {
    $('.burger-bubble > p').toggleClass('active')
    $('.burger-bubble > h2').toggleClass('active')
    setTimeout(function () {
      $('.burger-bubble > p').css('display', 'none')
      $('.burger-bubble > h2').css('display', 'none')
    }, 200)
  } else {
    $('.burger-bubble > p').css('display', 'block')
    $('.burger-bubble > h2').css('display', 'block')
    $('.burger-bubble > p').toggleClass('active')
    let repetitions = $('.burger-bubble > h2').length
    for (let i = 1; i <= repetitions; i++) {
      let element = '.burger-bubble > h2:nth-child(' + i + ')'
      let time = 200 * i
      setTimeout(function () {
        $(element).toggleClass('active')
      }, time)
    }
  }
}
