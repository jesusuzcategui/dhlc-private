jQuery(document).ready(($)=>{
    FillSelect('usuarios/ajax/rolls','roll-select',"seleccione rol");
    $("#usuarios-table").DataTable({
        ajax: {
            url: 'usuarios/ajax/getUsu'
        },
        responsive: true,
        paging: true,
        pageLength: 5,
        lengthMenu: [ [5, 10, 20, 50, 100, 200, 300, 500, -1], [5, 10, 20, 50, 100, 200, 300, 500, "All"] ],
        columns: [
           {
				data: 'id',
				width: '20%'
			},
			{
				data: 'cedula',
				width: '20%'
			},{
				data: 'email',
				width: '20%'
            },
            {
				data: 'telefono',
				width: '20%'
			},
            {
				data: 'rol',
				width: '20%'
			},
            {
				data: 'accion',
				width: '10%'
			}
        ],
        language: {
            lengthMenu: 'Mostrar _MENU_ registros',
            infoFiltered:   '(Encontrados de _MAX_ registros en total)',
            loadingRecords: '<span class="fa fa-spinner spinner-icon-lg spinner-animation"></span> <span class="spinner-text">Cargando registros</span>',
            info:           "Mostrando de _START_ a _END_ de un total _TOTAL_ registros",
            paginate: {
                first: 'Primera',
                previous: 'Anterior',
                last: 'Última',
                next: 'Siguiente'
            },
            search: 'Buscar'
        }
    });
    
    //validaciones de usuario
    $("#telefono").gyvalidator({require: true, type:'number'});
    $("#email").gyvalidator({require: true, type:'email'})
    $("#roll").gyvalidator({require:true, type:'selectlist'});
    
    
    //VALIDACION DE RUT
    
    $("#cedula").on("blur", function(event){
        let rutIngresado = $(this).val();
        let rutValido    = formateaRut(rutIngresado);
        
        //
        $(this).val(rutValido);
    });
 
});
function ExportarPDF(){
    window.open("https://digitalmark.cl/reportes/locutorios/usuarios");
 }

function modalDelete(id){
    UIkit.modal.confirm('¿Desea eliminar este registro de este usuario?').then( ()=>{
        if( id != null ){
          
            proccessAjax({
           url: 'usuarios/ajax/deleteusua',
           headers: {"Permiso": localStorage.getItem('codigo')},
           method: 'post',
           dataType: 'json',
           data: {
             id: id
           },
           beforeSend: function(respose){
             toastr.info('Eliminando...', {"timeOut": "0"});
           }
            }, function(resp){
                toastr.clear();
                if(resp.data == 1){
                  jQuery('#usuarios-table').DataTable().ajax.reload();
                  toastr.success('Usuario eliminado...');
                }
     
                if(resp.data == 2){
                 toastr.error('Usuario no eliminada...');
                 }
                 if(resp.data==3){
                 toastr.error('No tienes permiso para realizar esta accion...');
                 }
                 if(resp.data==4){
                    toastr.error('No tienes permiso para realizar esta accion...');
                }
            });
        }
    
      }, ()=>{
        return;
      } );
}


let modaladdOpen = function(){
    //Se cambia el titulo de la modal.
  
    jQuery("#addusu-modal").find(".uk-modal-title").html("Registrar Usuario");
	//Se establece la function a ejecutar cuando se envíe el formulario.
    jQuery("#save").attr("onclick", "javascript:guardarusu(event)");
	jQuery("#usu-form").find("#cedula").val("");
    jQuery("#usu-form").find("#email").val("");
	jQuery("#usu-form").find("#telefono").val("");
    jQuery("#usu-form").find("#roll").val("");
    jQuery("#usu-form").find("#contrasena").val("");
    jQuery("#usu-form").find("#recontrasena").val("");
    jQuery("#usu-form").find("#pass").show();
    jQuery("#usu-form").find("#repass").show();
	UIkit.modal("#addusu-modal").show();
};

let modaleditOpen = function(data){
    console.log(data);
	//Se cambia el titulo de la modal.
	jQuery("#addusu-modal").find(".uk-modal-title").html("Editar Usuario");
    //Se establece la function a ejecutar cuando se envíe el formulario.
    proccessAjax({
        url: 'usuarios/ajax/usuid',
        method: 'post',
        dataType: 'json',
        data:{id:data},
    }, function(resp){
        console.log(resp);
        jQuery("#save").attr("onclick", "javascript:actualizarusu(event)");
        jQuery("#usu-form").find("#cedula").val(resp[0].cedula);
        jQuery("#usu-form").find("#email").val(resp[0].email);
        jQuery("#usu-form").find("#telefono").val(resp[0].telefono);
        jQuery("#roll-select").val(resp[0].croll);
        jQuery("#val_id").val(data);
        jQuery("#usu-form").find("#pass").hide();
        jQuery("#usu-form").find("#repass").hide();
        UIkit.modal("#addusu-modal").show();
    }, function(error){
        console.error(error);
    }); 
};

let guardarusu = function(event){
    event.preventDefault();
    var cedula=jQuery("#usu-form").find("#cedula").val();
    var email= jQuery("#usu-form").find("#email").val();
    var telefono=jQuery("#usu-form").find("#telefono").val();
    var roll=jQuery("#usu-form").find("#roll-select").val();
    var contrasena=jQuery("#usu-form").find("#contrasena").val();
    var recontrasena=jQuery("#usu-form").find("#recontrasena").val();

    var send={
        cedula:cedula,
        email:email,
        telefono:telefono,
        rol:roll,
        contrasena:contrasena
    }
    if(contrasena!==recontrasena){
        toastr.error('la contrasenas deben ser iguales');
    }

    

    if(email!='' && telefono!=''&& roll!=''&&contrasena===recontrasena){
        proccessAjax({
            url: 'usuarios/ajax/saveusu',
            method: 'post',
            dataType: 'json',
            headers: {"Permiso": localStorage.getItem('codigo')},
            data:send,
            beforeSend: function(respose){
				jQuery(".submit-button").html('<i class="fas fa-spinner spinner-animation"></i>');
			}
        }, function(resp){
             console.log(resp);
             toastr.clear();
                if(resp.data == 1){
                    UIkit.modal("#addusu-modal").hide();
                    jQuery(".submit-button").html('Guardar');
                    jQuery('#usuarios-table').DataTable().ajax.reload();

                    toastr.success('Usuarios registrado...');
                }
                if(resp.data == 2){
                    toastr.error('Usuario no registrado...');
                }
                if(resp.data==3){
                   toastr.error('No tienes permiso para realizar esta accion...');
                }
                if(resp.data==4){
                    toastr.error('No tienes permiso para realizar esta accion...');
                 }
                
        }, function(error){
            console.error(error);
        });  
    }else{
        toastr.error('Algunos campos estan vacios');  
    }


}

let testToken = function(){
    jQuery.ajax({
        url: 'usuarios/ajax/testToken',
        dataType: 'json',
        data: {},
        method: 'post',
        headers: {"Permiso": 'hola mundo'},
    }).then(function(resp){
        console.log(resp);
    });
}

let actualizarusu = function(event){
    event.preventDefault();
    var cedula=jQuery("#usu-form").find("#cedula").val();
    var email= jQuery("#usu-form").find("#email").val();
    var telefono=jQuery("#usu-form").find("#telefono").val();
    var roll=jQuery("#usu-form").find("#roll-select").val();
    
    var id=jQuery("#val_id").val();
  
            var send={
                cedula:cedula,
                email:email,
                telefono:telefono,
                rol:roll,     
                id:id
            }

    if(email!='' && telefono!=''&& roll!=''){
        proccessAjax({
            url: 'usuarios/ajax/actualizarusu',
            method: 'post',
            dataType: 'json',
            headers: {"Permiso": localStorage.getItem('codigo')},
            data:send,
            beforeSend: function(respose){
				jQuery(".submit-button").html('<i class="fas fa-spinner spinner-animation"></i>');
			}
        }, function(resp){
             console.log(resp);
             toastr.clear();
                if(resp.data == 1){
                    UIkit.modal("#addusu-modal").hide();
                    jQuery('#usuarios-table').DataTable().ajax.reload();
                    jQuery(".submit-button").html('Guardar');
                    toastr.success('Usuarios Actualizado...');
                }

                if(resp.data == 2){
                    toastr.error('Usuario no Actualizado...');
                }
                if(resp.data==3){
                   toastr.error('No tienes permiso para realizar esta accion...');
                }
                if(resp.data==4){
                    toastr.error('No tienes permiso para realizar esta accion...');
                 }

        });
    }  else{ toastr.error('Algunos campos estan vacios');  }
}
