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

function optionsUser () {
  let options = $('.menu-top .options')
  let icon = $('.menu-top .user .down-options i')

  icon.toggleClass('fa-caret-down')
  icon.toggleClass('fa-caret-up')

  if (options.css('display') === 'none') {
    options.css('display', 'block')
    options.css('display', 'block')
  } else {
    options.css('display', 'none')
    options.css('display', 'none')
  }
}

function insertContent (file) {
  let route = 'content/' + file
  $('.cont').load(route)
}
