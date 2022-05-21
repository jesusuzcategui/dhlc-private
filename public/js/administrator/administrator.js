/**
 * Home.js
 * @version 1.0
 * @package Sarec
 * @subpackage Home - Controller.
 */

jQuery(document).ready(($)=>{
    $("#pagesave").attr("disabled",true);  
    FillSelect('home/ajax/precio','precio-select','seleccione precio');
    $("#telefono").gyvalidator({require: true, type:'phone'});
});


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