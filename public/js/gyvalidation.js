(function( $ ){
	'use strict';
	$.fn.gyvalidator = function(config){
	    var gy = this;
	    var config = $.extend({}, $.fn.gyvalidator.defaultOptions, config);
	    var elementMsg = document.createElement('span');
	    elementMsg.classList.add("gyvalidator-msg", "uk-width-1-1");
		$(".gyvalidator-msg").hide();
		
	    function validForm(flag=false){
	    	var buttonSubmit = $(".submit-button");
	    	if(flag === false){
				buttonSubmit.attr("disabled", true);
	    	} else {
	    		buttonSubmit.attr("disabled", false);
	    	}
	    }
	    $(gy).each((i, e)=>{
	    	if(config.require != false){
	    		$(e).blur(function(event) {
					if($(this).val() === "" || $(this).val() === null){
						elementMsg.innerHTML = "<div  class='uk-alert-danger' uk-alert>Este campo es requerido</div>";
						$(this).parent().parent().append(elementMsg);
						validForm(false);
					} else {
						$(this).parent().parent().find('.gyvalidator-msg').remove();
						//validForm(true);
					}
				});
	    	}
	    	if(config.size != null){
	    		$(e).attr("maxlength", config.size);
	    	}
	    	switch(config.type){
	    	    case 'all':
					
				break;
	    		case 'lettersAndSpace':
					var regx = new RegExp(/[A-ZÁÉÍÓÚa-záéíóú\s]+/g);
					$(e).blur(function(event) {
						if( regx.test($(this).val()) == false ){
							elementMsg.innerHTML = "<div class='uk-alert-danger' uk-alert>El formato no es correcto. (Solo letras y espacios)</div>";
							$(this).parent().parent().append(elementMsg);
							validForm(false);
						} else {
							$(this).parent().parent().find('.gyvalidator-msg').remove();
							validForm(true);
						}
					});
				break;
				case 'password':
					var regx = new RegExp(/[A-Za-z0-9._%+-]{8,}/);
					$(e).blur(function(event) {
						if( regx.test($(this).val()) == false ){
							elementMsg.innerHTML = "<div class='uk-alert-danger' uk-alert>Una contraseña segura es mayor o igual a 8 carácteres, ejm.: C0n7r4-35a</div>";
							$(this).parent().parent().append(elementMsg);
							validForm(false);
						} else {
							$(this).parent().parent().find('.gyvalidator-msg').remove();
							validForm(true);
						}
					});
				break;
				case 'repassword':
				 $(e).blur(function(event) {
				   if($('#repassword').val()!= $('#password').val()){
					elementMsg.innerHTML = "<div class='uk-alert-danger' uk-alert>debe ser igual a la contrasena</div>";
					$(this).parent().parent().append(elementMsg);
					validForm(false); 
				   }else{
					$(this).parent().parent().find('.gyvalidator-msg').remove();
					validForm(true);  
				   }
				});
				case 'number':
				    
				    var regx = new RegExp(/[0-9]+/g);
				    
				    $(e).blur(function(event){
				        if( regx.test($(this).val()) == false ){
							elementMsg.innerHTML = "<div class='uk-alert-danger' uk-alert>Solo se admiten numeros</div>";
							$(this).parent().parent().append(elementMsg);
							validForm(false);
						} else {
							$(this).parent().parent().find('.gyvalidator-msg').remove();
							validForm(true);
						}
				    });
				    
				break;

				break;
				case 'email':
					var regx = new RegExp(/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/);
					$(e).blur(function(event) {
						if( regx.test($(this).val()) == false ){
							elementMsg.innerHTML = "<div class='uk-alert-danger' uk-alert>No es un correo electrónico</div>";
							$(this).parent().parent().append(elementMsg);
							validForm(false);
						} else {
							$(this).parent().parent().find('.gyvalidator-msg').remove();
							validForm(true);
						}
					});
	    		break;
				case 'selectlist':
					$(e).change(function(event){
						var fieldVal = $(this).find('option:selected').val();
						if(fieldVal == "" || fieldVal == null){
							elementMsg.innerHTML = "<div class='uk-alert-danger' uk-alert>Debe seleccionar una opción</div>";
							$(this).parent().parent().append(elementMsg);
							validForm(false);
						} else {
							$(this).parent().find('.gyvalidator-msg').remove();
							validForm(true);
						}
					});
				break;

				case 'phone':
					var regx = new RegExp(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
					$(e).blur(function(event) {
						if( regx.test($(this).val()) == false ){
							elementMsg.innerHTML = "<div class='uk-alert-danger' uk-alert>formato de solo numeros</div>";
							$(this).parent().parent().append(elementMsg);
							validForm(false);
						} else {
							$(this).parent().parent().find('.gyvalidator-msg').remove();
							validForm(true);
						}
					});
				break;
	    	}
	    });
	    

	    return this;
  	}

  	$.fn.gyvalidator.defaultOptions = {
  		type: 'lettersAndSpace',
	  	require: false,
	  	size: null
	}

})( jQuery );