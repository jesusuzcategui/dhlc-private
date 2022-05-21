jQuery(document).ready(($)=>{
    $("#email").gyvalidator({require: true, type:'email'}); 
});

 let recupera=function(event){ 
    event.preventDefault();
    jQuery.ajax({
        url: 'restablecer/ajax/restorepass',
        method: 'post',
        dataType: 'json',
        data: {
            email:$('#email').val()
        },
        beforeSend: function(){
            toastr.info(`ESTAMOS GENERANDO TU NUEVA CLAVE`);
        }
       }).then(function(response){
           if( response.data == 1 ){
               toastr.success(`TÚ NUEVA CLAVE SE HA ENVIADO AL CORREO, POR FAVOR VERIFICALO.`);
               $("#email").val('');
           } else if( response.data == 2){
            toastr.error(`HA OCURRIDO UN ERROR`);
           } else {
            toastr.warning(`EL CORREO INGRESADO NO PERTENECE A NINGUN USUARIO DEL SISTEMA`);
           }
       });
 }