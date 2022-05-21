/**
 * Home.js
 * @version 1.0
 * @package Sarec
 * @subpackage Home - Controller.
 */

jQuery(document).ready(($)=>{
    $("#pagesave").attr("disabled",true);
    FillSelect('home/ajax/precio','precio-select','Seleccione precio');
    //$("#telefono").gyvalidator({require: true, type:'phone'});
    //$("#correo").gyvalidator({require: true, type:'email'});

    validateRecarga();

    particlesJS.load('particle-teater', 'js/particle.json', function() {
      console.log('callback - particles.js config loaded');
    });
});


function validateRecarga(){
  jQuery("#recargaform").validate({
    debug: false,
    rules: {
      correo: {
        required: true,
        email: true
      },
      telefono: {
        required: true,
        number: true,
        minlength: 9,
        maxlength: 12
      },
      precioselect: {
        required: true
      }
    },
    messages: {
      correo: 'Por favor ingrese un email válido',
      telefono: {
        required: 'Por favor ingrese un numero de telefono valido',
        minlength: 'Un teléfono comunmente tiene minimo 9 caracteres.',
        maxlength: 'Un teléfono comunmente tiene máximo 12 caratecres.'
      },
      precioselect: {
        required: 'Por favor elija un precio'
      }
    },
    invalidHandler: function(event, validator) {
      var errors = validator.numberOfInvalids();
      console.log(errors);
      if (errors) {
        $("#datasave").attr("disabled",true);
      } else {
        $("#datasave").attr("disabled",false);
      }
    },
    highlight: function( element, errorClass, validClass ) {
      $("#datasave").attr("disabled",true);
    },
    unhighlight: function( element, errorClass, validClass ) {
      $("#datasave").attr("disabled",false);
    },
    errorPlacement: function(error, elemento){
    },
    errorElement: 'p',
    errorLabelContainer: '.form.uk-alert-danger',
    error: function(element){
      console.log('error');
    },
    success: function(element){
      console.log('Hola');
      $("#datasave").attr("disabled",false);
    },
    submitHandler: function(form){
      form.submit();
    }
  });
}


function recargas(event){
    event.preventDefault();
    validateRecarga();
    let correo= jQuery("#recargaform").find("#correo").val();
    let telefono = jQuery("#recargaform").find("#telefono").val();
    let precio= jQuery("#recargaform").find("#precio-select").val();
    var send={
        telefono:telefono,
        precio:precio,
        correo:correo
    }
     if(telefono!='' && precio!='' && correo!=''){
       proccessAjax({
           url: 'home/ajax/savere',
           method: 'post',
           dataType: 'json',
           headers: {"Permiso": localStorage.getItem('codigo')},
           data:send,
           beforeSend: function(){
             toastr.info(`Solicitando conexión segura con Webpay`, {"timeOut": "0",});
           }
       }, function(resp){
            console.log(resp);
            toastr.clear();
               if(resp.data.data == 1){
                   console.log(resp.data.cod);
                  $("#recargaform").attr("action",resp.data.cod.action);
                  $("#token_ws").val(resp.data.cod.token_ws);
                  toastr.success('Verificado, ahora de click en pagar');
                  $("#pagesave").attr("disabled", false);
                  $("#datasave").attr("disabled",true);
               }
               if(resp.data.data== 2){
                   toastr.warning('Error, vuelve a intentarlo');
               }
               if(resp.data.data==3){
                 toastr.error('recarga no pudo ser gestionada...');
               }
               if(resp.data.data==4){
                   $("#datasave").attr("disabled",false);
                   toastr.warning('Monto no disponible');

               }

               if(resp.data.data==5){
                   $("#datasave").attr("disabled",false);
                   toastr.error('Error al conectar con webpay');
               }

       }, function(error){
           toastr.error('Error interno del servicio...');
           console.log(error);
       });
     } else {
       toastr.warning('Debe completar el formulario');
       $("#datasave").attr("disabled",false);
     }
}

let finalizar = function(event){
    event.preventDefault();
    window.location.href="./";
    }

 function login(event, form){
    event.preventDefault();
    let txtEmail = jQuery(form).find("#email").val();
    let txtPass = jQuery(form).find("#contra").val();
    if( txtEmail == "" || txtEmail == null || txtEmail == undefined || txtPass == "" || txtPass == null || txtPass == undefined ){
        toastr.error('DEBE COMPLETAR TODOS LOS CAMPOS');
    } else {
        proccessAjax({
            url: 'home/ajax/login',
            method: 'post',
            dataType: 'json',
            data: jQuery(form).serializeArray()
        }, function(resp){
            if( resp.data.response == 1 ){
                toastr.info('EL EMAIL INGRESADO NO PERTENECE A NINGÚN USUARIO REGISTRADO, POR FAVOR VERIFIQUE E INTENTELO UNA VEZ MÁS.');
            } else if( resp.data.response == 2 ){
                toastr.info('EL CORREO O LA CONTRASEÑA NO COINCIDEN, POR FAVOR INTENTA OTRA VEZ.');
            } else if( resp.data.response ==3){
                 localStorage.setItem('codigo',resp.data.token);
                toastr.success(resp.data.message);
                window.location.href = './dashboard';

            }
        }, function(error){
            console.error(error);
            toastr.error("Credenciales incorrectas");
        });
    }

}
