
//inicializan las variables
var cedula,N,nombres,apellidos,genero,parroquia, apellidos,
nacimiento, direccion,estado, movil,casa ,origen,periodo,
comentario,correo,contrasena, recontrasena,rol;

var isValid; 




function readURL(input){
    if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }  
     
       reader.readAsDataURL(input.files[0]);
      
    }
 }


jQuery(document).ready(($)=>{
  
   //selects multiples
   selectmultiple( 'personas/async?action=getroll','GET','rols');
	
	//LLenamos el data table
	
	$("#personas").DataTable({
        ajax: {
            url: 'personas/async?action=getPers'
        },
        responsive: true,
        pageLength: 5,
        lengthMenu: [ [5, 10, 20, 50, 100, 200, 300, 500, -1], [5, 10, 20, 50, 100, 200, 300, 500, "All"] ],
        columns: [
            {
				data: 'cedula',
				width: '20%'
			},
            {
				data: 'nombre',
				width: '20%'
			},
            {
				data: 'apellido',
				width: '20%'
			},
      {
        data: 'correo',
        width: '10%'
      },
      {
        data: 'roles',
        width: '10%'
      },
			{
				data: 'fecha_nacimiento',
				width: '10%'
      },

      {
				data: 'creado',
				width: '10%'
			},
			{
				data: 'estatus',
				width: '10%'
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

    //Llenamos dinamicamenete los selects.
	  FillSelect('personas/async?action=getgenero', "genero","seleccione Genero");
    FillSelect('personas/async?action=getcivil', "civil","seleccione Estado civil");
    FillSelect('personas/async?action=getetnia', "etnia","seleccione Etnia");
    FillSelect('personas/async?action=getnacionalidad', "nacionalidad","seleccione nacionalidad");
    FillSelect('personas/async?action=getestatus', "estatus","seleccione estatus");
    FillSelect('personas/async?action=getpaises', "paises","seleccione pais donde recide");
    FillSelect('personas/async?action=getpaises1', "paises1","seleccione pais de origen");
   // multipleSelect('personas/async?action=getroll', "rols");
    
   
    $('#paises').on('change',function(event){
        jQuery("#estado").find("option").remove();
        jQuery("#municipio").find("option").remove();
        jQuery("#parroquia").find("option").remove();
        secondSelect('personas/async?action=getestado','paises','estado',"seleccione estado donde recide");
    });

    $('#estado').on('change',function(event){
        jQuery("#municipio").find("option").remove();
        jQuery("#parroquia").find("option").remove();
        secondSelect('personas/async?action=getmunicipio','estado','municipio',"seleccione municipio donde recide");
    });

    $('#municipio').on('change',function(event){
        jQuery("#parroquia").find("option").remove();
        secondSelect('personas/async?action=getparroquia','municipio','parroquia',"seleccione parroquia donde recide");
    });

    $('#paises1').on('change',function(event){
        jQuery("#estado1").find("option").remove();
        jQuery("#municipio1").find("option").remove();
        jQuery("#origen1").find("option").remove();
        secondSelect('personas/async?action=getestado1','paises1','estado1',"seleccione estado de origen");
    });

    $('#estado1').on('change',function(event){
        jQuery("#municipio1").find("option").remove();
        jQuery("#parroquia1").find("option").remove();
        secondSelect('personas/async?action=getmunicipio1','estado1','municipio1',"seleccione municipio de origen");
    });

    $('#municipio1').on('change',function(event){
        jQuery("#origen").find("option").remove();
        secondSelect('personas/async?action=getorigen','municipio1','origen',"seleccione parroquia origen");

    });

    //Validar campos...
    $("#cedula").gyvalidator({require: true, type:'phone'});
    $("#nombres").gyvalidator({require: true, type:'lettersAndSpace'});
    $("#apellidos").gyvalidator({require: true, type:'lettersAndSpace'});
    $("#nacimiento").gyvalidator({require: true,type:''});
    $("#genero").gyvalidator({ type: 'selectlist'});
    $("#paises").gyvalidator({type: 'selectlist'});
    $("#paises1").gyvalidator({ type: 'selectlist'});
    $("#correo").gyvalidator({require: true, type:'email'});
    $("#nacionalida").gyvalidator({type: 'selectlist'});
    $("#periodo").gyvalidator({require: false,type:''});
    $("#direccion").gyvalidator({require: false ,type:''});
    $("#movil").gyvalidator({ type:'phone'});
    $("#casa").gyvalidator({ type:'phone'});
    $("#rols").gyvalidator({require:true, type:'selectlist'});

});



let editOpen = (id) => {

           jQuery.ajax({
           url: 'personas/async?action=getEdit',
           method: 'post',
           dataType: 'json',
           headers: {"Permiso": localStorage.getItem('token')},
           data: {
           id: id
          },

          beforeSend: function(respose){
            toastr.info('Cargando data...', {"timeOut": "0"});
          }
        }).then(function(response){
          //console.log(response);
          if(response.length > 0){
                var fecha=response[0].fecha_creacion;
                if(response[0].avatar!=null){
                  jQuery("#formpersona").find('#blah').attr('src',response[0].avatar);
                }else{
                  jQuery("#formpersona").find('#blah').attr('src','./images/profil.png');
                }

                var cedula=response[0].cedula;
                var es= cedula.split("-");
                 jQuery("#formpersona").find('#N').removeAttr("onfocus");
                jQuery("#formpersona").find('#cedula').removeAttr("onfocus");
                jQuery("#formpersona").find('#correo').removeAttr("onfocus");
               var roll=response[0].rolls_id;
               var rolls=roll.split(",");
               console.log(rolls);
                //(response[0].rolls_id);
                for(var i in rolls){
                  jQuery("#rols").find("option[value='"+rolls[i]+"']").attr("selected", true);
                }
                jQuery("#rols").multipleSelect();
           
          // jQuery("#formpersona").find('#formper').attr('onsubmit','javascript:editpersona(event);');
            jQuery("#formpersona").find('#per').val(response[0].id);
            jQuery("#formpersona").find('#usu').val(response[0].us_id);
            jQuery("#formpersona").find('#editar').val("editar");    
            jQuery("#formpersona").find('#N').val(es[0]);
            jQuery("#formpersona").find('#cedula').val(es[1]);
            jQuery("#formpersona").find('#nombres').val(response[0].nombre);
            jQuery("#formpersona").find('#apellidos').val(response[0].apellido);
            jQuery("#formpersona").find('#nacimiento').val(response[0].fecha_nacimiento);
            jQuery("#formpersona").find('#genero').val(response[0].genero);
            jQuery("#formpersona").find('#estatus').val(response[0].estatus);
            jQuery("#formpersona").find('#correo').val(response[0].correo);
            jQuery("#formpersona").find('#nacionalidad').val(response[0].nacionalidad);

          
            $("#formpersona").modal('show');
          } else {
            if(response.message){
              toastr.error(response.message);
            }else{
              toastr.error('Ocurrió un error...'); 
            }
           
          }  
         }); 
};



let openmodalreg =() => {

  jQuery.ajax({
    url: 'personas/async?action=verfi',
    method: 'get',
    dataType: 'json',
    data: {},
    headers: {"Permiso": localStorage.getItem('token')}
     }).then(function(response){
     console.log(response);
      if(response.data===true){
    $("#formpersona").modal('show');
    jQuery("#formpersona").find('#editar').val("guardar"); 
    jQuery("#N").val("");
    jQuery("#cedula").val("");
    jQuery("#nombres").val("");
    jQuery("#apellidos").val("");
    jQuery("#nacimiento").val("");
    jQuery("#genero").val(""); //Se obtiene el valor selecionado del select
    jQuery("#nacionalidad").val("");
    jQuery("#estatus").val("");
    jQuery("#correo").val("");
    jQuery("#rols").val("");
    jQuery('#blah').attr('src','./images/profil.png');
    jQuery(".submit-button").html('Guardar');
    jQuery("#rols").multipleSelect('refresh');
      }else{
       toastr.error(response.message);
      }

  });
};

let modalDelete=(id)=>{
 UIkit.modal.confirm('Seguro de deseas eliminar esta persona').then(function() {
   
   jQuery.ajax({
    url: 'personas/async?action=deleper',
    method: 'post',
    dataType: 'json',
    headers: {"Permiso": localStorage.getItem('token')},
    data: {
      id: id
    },
  }).then(function(response){
    console.log(response);
     if(response==1){
      toastr.success("Eliminado con exito");
      $('#personas').DataTable().ajax.reload();
     }else{
      toastr.error(response.message);
     }
     
  });

}, function () {
    console.log('Rejected.');
});

}


let viewpersona = (id) => {
 jQuery.ajax({
    url: 'personas/async?action=getPer',
    method: 'post',
    dataType: 'json',
    headers: {"Permiso": localStorage.getItem('token')},
    data: {
      id: id
    },
    beforeSend: function(respose){
      toastr.info('Cargando data...', {"timeOut": "0"});
    }
  }).then(function(response){
    console.log(response);
    if(response.length > 0){

          var fecha=response[0].fecha_creacion;
          if(response[0].avatar!=null){
            jQuery("#viewpersona").find('#imagen').attr('src',response[0].avatar);
          }else{
            jQuery("#viewpersona").find('#imagen').attr('src','./images/profil.png');
          }

      var roll=response[0].rolls_id;
      var rols=roll.split(',');

      compararArrays('personas/async?action=getroll',method='GET',"viewpersona",'per-rolls',rols,'verpersona');

      //jQuery("#viewpersona").find('.per-rolls').html(response[0].cedula);
      jQuery("#viewpersona").find('.per-cedula').html(response[0].cedula);
      jQuery("#viewpersona").find('.per-nombres').html(response[0].nombre);
      jQuery("#viewpersona").find('.per-apellidos').html(response[0].apellido);
      jQuery("#viewpersona").find('.per-fecha').html(response[0].fecha_nacimiento);
      jQuery("#viewpersona").find('.per-genero').html(response[0].genero);
      jQuery("#viewpersona").find('.per-direccion').html(response[0].direccion);
      jQuery("#viewpersona").find('.per-parriquia').html(response[0].parroquia);
      jQuery("#viewpersona").find('.per-direccion').html(response[0].direccion);
      jQuery("#viewpersona").find('.per-civil').html(response[0].civil);
      jQuery("#viewpersona").find('.per-etnia').html(response[0].etnia);
      jQuery("#viewpersona").find('.per-movil').html(response[0].tel_cel);
      jQuery("#viewpersona").find('.per-casa').html(response[0].tel_casa);
      jQuery("#viewpersona").find('.per-origen').html(response[0].origen);
      jQuery("#viewpersona").find('.per-periodo').html(response[0].periodo_ingreso);
      jQuery("#viewpersona").find('.per-comentario').html(response[0].comentario);
      jQuery("#viewpersona").find('.per-creado').html(fecha.split(".",1));
      jQuery("#viewpersona").find('.per-estatus').html(response[0].estatus);
      jQuery("#viewpersona").find('.per-correo').html(response[0].correo);
      $("#viewpersona").modal('show');
    } else {
      if(response.message){
        toastr.error(response.message);
      }else{
        toastr.error('Ocurrió un error...'); 
      }
    }  
  }); 
};


let savepersona = function(event){
  event.preventDefault();
    var imagen_subida = jQuery('#imagen').prop('files')[0];
    var cedula= jQuery("#N").val()+'-'+jQuery("#cedula").val();
    var nombres= jQuery("#nombres").val();
    var apellidos= jQuery("#apellidos").val();
    var nacimiento=jQuery("#nacimiento").val();
    var genero= jQuery("#genero").find("option:selected").val(); //Se obtiene el valor selecionado del select
    var parroquia=jQuery("#parroquia").find("option:selected").val();
    var civil=jQuery("#civil").find("option:selected").val();
    var direccion=jQuery("#direccion").val();
    var origen=jQuery("#origen").find("option:selected").val();
    var etnia=jQuery("#etnia").find("option:selected").val(); //Se obtiene el valor selecionado del select
    var movil=jQuery("#movil").val();
    var casa=jQuery("#casa").val();
    var nacionalidad=jQuery("#nacionalidad").find("option:selected").val();
    var periodo=jQuery("#periodo").val();
    var comentario=jQuery("#comentario").val();
    var estatus=jQuery("#estatus").find("option:selected").val();
    var correo=jQuery("#correo").val();
    var rols=$('#rols').val();
    var editar=$('#editar').val();
    var per=$('#per').val();
    var usu=$('#usu').val();

  var data = new FormData();


  data.append("editar",editar);
  data.append("per",per);
  data.append("usu",usu);
  data.append("imagen", imagen_subida);
  data.append("cedula", cedula);
  data.append("nombres", nombres);
  data.append("apellidos", apellidos);
  data.append("nacimiento", nacimiento);
  data.append("genero", genero);
  data.append("nacionalidad",nacionalidad);
  data.append("estatus", estatus);
  data.append("correo",correo);
  data.append("rols",rols);
  //data.append("editar",editar);
  
  if(data.nombres != "" && data.cedula != "" && data.apellidos != "" && data.correo != "" && data.estatus != ""){
	        
                jQuery.ajax({
        			url: 'personas/async?action=savepersona',
        			method: 'post',
        			dataType: 'json',
              headers: {"Permiso": localStorage.getItem('token')},
        			data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    enctype: 'multipart/form-data',
        			beforeSend: function(respose){
        				jQuery(".submit-button").html('<i class="fas fa-spinner spinner-animation"></i>');
                toastr.info('Cargando data...', {"timeOut": "0"});
        			}
        		}).then(function(response){
                    console.log(response); 
                    console.log(response.data);
        			if(response.data === true){
                      toastr.info(response.message, {"timeOut": "7000"});
        	             jQuery("#N").val("");
                       jQuery("#cedula").val("");
                       jQuery("#nombres").val("");
                       jQuery("#apellidos").val("");
                       jQuery("#nacimiento").val("");
                       jQuery("#genero").val(""); //Se obtiene el valor selecionado del select
                       jQuery("#nacionalidad").val("");
                       jQuery("#estatus").val("");
                       jQuery("#correo").val("");
                       jQuery("#rols").val("");
                       jQuery('#blah').attr('src','./images/profil.png');
                       jQuery(".submit-button").html('Guardar');
                       jQuery("#rols").multipleSelect('refresh');
        				       toastr.success('Usuario guardado...', '¡Éxito!');
                        $("#formpersona").modal('hide');
        				$('#personas').DataTable().ajax.reload();
        			} else{
        				jQuery(".submit-button").html('Guardar');
        				toastr.error(response.message, '¡Error!');
        			}
        		});
	    
    }else {
		toastr.warning('Complete todos los campos...', '¡Precaución!');
	}
};

function Cedula(){
    Exist('personas/async?action=persona_cedula', "post",{'cedula':jQuery("#N").val()+'-'+jQuery("#cedula").val()},'cedula');
}

function Correo(){
    Exist('personas/async?action=correo', "post",{'correo':jQuery("#correo").val()},'correo');
}

function ExportarPDF(){
   window.open("//localhost/sarec/reportes/auditoria/personas");
}



  
 