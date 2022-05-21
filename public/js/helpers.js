let valemail=false;
let valcadula=false;

let SITE_URL;

if(isLocal()){
    SITE_URL = getUrlDomain('testlocu/');
} else {
    SITE_URL = getUrlDomain('');
}

function getUrlDomain(path=null){

    var dominio = window.location.hostname;
    var protocol = window.location.protocol;
    var url;
    if(path != null){

      url = protocol+"//"+dominio+"/"+path;

    } else {

      url = protocol+"//"+dominio+"/";

    }

    return url;
  }

  function isLocal(){

    const DOMAIN_LOCALS = ["localhost", "127.0.0.1"];

    const resp = DOMAIN_LOCALS.includes(location.hostname);

    return resp;

  }

// ------preload del sistema ----------

var cargarImg = $("img");
var cargarscript=$("script");
var cargarCSS=$("link");
var cargarAudios=$("audio");
var cargarvideos=$("video");
var cargarvista=[];
var numItem=0;
var valorPorcentaje=0;
var incremento=0;
var numCarga=0;

cargarvista.push(cargarImg,cargarscript,cargarCSS,cargarAudios,cargarvideos);

cargarvista.forEach(recorrevista);

function recorrevista(item,index){
	for(var i=0; i<item.length; i++){
	  numItem ++;
	  valorPorcentaje=100/numItem;
	  //console.log('valorporcentaje',valorPorcentaje);
	}

	for (var i=0; i<item.length; i++){
	   preload(i,item);
    }
}

function preload(i,item) {

		setTimeout(function() {

			$(item[i]).ready(function () {
				numCarga ++
				incremento=Math.floor(numCarga*valorPorcentaje);//pocentaje redondeado
				$("#porcentajecarga").html(incremento+'%');
				$("#rellenocarga").css({"width":incremento+"%"});

				if(incremento>=100){
				$("#preload").delay(350).fadeOut("slow");
				}

				//console.log('incremento',incremento);
				});

		},i*200);
}
//-----fin del preload--------

$(document).ready(function ($) {

	$('[data-toggle="datepicker"]').datepicker({
		format: 'yyyy-mm-dd'
	});

	let token = localStorage.getItem('token');

	if( token != null ){
		let decode = jwt_decode(token);
		console.log(decode);
	}

  });

  let cerrarseccion=function(){
     jQuery.ajax({
       url: 'home/ajax/logout',
       method: 'get',
       dataType: 'json',
       data: {},
     }).then(function(done){

		if(done.data == true){
			localStorage.clear();
			window.location.href = SITE_URL + "administrator";
		} else {
			toastr.error(
				'Error al cerrar la session'
			);
		}

		

	 },function(error){
		 console.error(error);
	 });

  }

	let ajax=(uri=null,method="get",data={},direccion=null)=>{
		jQuery.ajax({
			url:uri,
			method:method,
			dataType:'json',
			data:data,

		}).then(function(response){
			datodevuelto(response,direccion);
		});
	}


	let proccessAjax = (params = {url:null, method:'post', dataType: 'json', data: {}}, callbackDone=null, callbackFail=null) => {
  		jQuery.ajax(params).then(callbackDone, callbackFail);
	};

let serialize = function (form) {

	// Setup our serialized data
	var serialized = [];

	// Loop through each field in the form
	for (var i = 0; i < form.elements.length; i++) {

		var field = form.elements[i];

		// Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
		if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue;

		// If a multi-select, get all selections
		if (field.type === 'select-multiple') {
			for (var n = 0; n < field.options.length; n++) {
				if (!field.options[n].selected) continue;
				serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[n].value));
			}
		}

		// Convert field data to a query string
		else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
			serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value));
		}
	}

	return serialized.join('&');

};

let FillSelect = (uri=null, id=null,seleccione="-- Seleccione --",data={},method='get',value) => {

	var select = jQuery("#"+id);

	var optionEpmty = document.createElement("option");
			  optionEpmty.value = "";
		 	  optionEpmty.text = seleccione;
			  select.append(optionEpmty);
	select.addClass("helpers-select");
	jQuery.ajax({
		url: uri,
		dataType: 'json',
		method:method,
		data: data
	}).then((respose)=>{
		//console.log(respose);
		jQuery.each(respose, (a,b) => {
			var option = document.createElement("option");
				option.value = b.id;
				option.text = b.descripcion;
				select.append(option);
		});
		if(value){
		 jQuery('#'+id).val(value);
		 console.log(value);
	    }
	});

};

let secondSelect=(uri=null,ida=null,idb=null,seleccione="select",value)=>{

	//console.log(value);
	 //Se llena el select

	 var select = jQuery("#"+idb);
	   //    if(value="true"){
    //       var optionEpmty = document.createElement("option");
			 //  optionEpmty.value = "";
		 	//  optionEpmty.text = seleccione;
			 // select.append(optionEpmty);
	   //  }
	  console.log(jQuery("#"+ida).val());


	 select.addClass("helpers-select");
	 jQuery.ajax({
		 url:uri,
		 dataType: 'json',
		 method:'post',
		 data: {
			 id: $("#"+ida).val()
		 }
	 }).then((respose)=>{
		 //console.log(respose);
		 jQuery.each(respose, (a,b) => {
			 var option = document.createElement("option");
				 option.value = b.id;
				 option.text = b.descripcion;
				 select.append(option);
		 });

         if(value){
         	 //$("#"+idb).val(value);
         	 $('#'+idb).find("option[value='"+value+"']").attr("selected", true);
         }else{
            if(respose.length <= 1){
			 select.attr("disabled", true);
			 select.val(respose[0].id);
		  } else {
			 select.attr("disabled", false);
		  }
         }

	 });
}

let selectmultiple=(url=null,method='GET',input)=>{
		 $('#'+input).multipleSelect({
		    maxHeight: 400,
		    buttonWidth: '100%',
		    includeSelectAllOption: true,
		    enableFiltering: true
		});

		$.ajax({
		  method:method,
		  url:url,
		  dataType: 'json',
		  success: function(data) {
		     console.log(data);
		     $.each(data, function (i, item) {
		         $('#'+input).append('<option value="' + item.id+ '">' + item.descripcion + '</option>');
		    });
		    $('#'+input).multipleSelect('refresh');
		  },
		  error: function() {
		        alert('error loading items');
		  }
		 });

		$('#'+input).trigger( 'change' );
}

let compararArrays=(url=null,method='GET',idguia,input,arrcomp,vista)=>{
    $("#"+idguia).find("#"+input).html('');
     jQuery.ajax({
        url:url,
        method:method,
        dataType:'json',
        data:{}
      }).done(function(e){
        var result=[];
        for(var i=0; i<e.length;i++){
             //console.log(e[i].descripcion);
            for(var j=0; j<arrcomp.length;j++){
               if (arrcomp[j]==e[i].id){
                //console.log(e[i].descripcion);
                if(vista=="sarecLogin"){

                	console.log(e[i].id);
                $("#"+idguia).find("#"+input).append("<button onclick='javascript:iniciodeseccion("+e[i].id+");' class='uk-button uk-button-primary'>"+e[i].descripcion+"</button> &nbsp");
                }else{
                 result.push(e[i].descripcion)
                }

              }
            }
         }
         if(vista=="verpersona"){
         jQuery("#"+idguia).find("."+input).html(result.toString());
         }


      });
}

let datatable=(id="",url="",columnas=[])=>{

		$("#"+id).DataTable({
       	ajax: {
            url: url
        },
        responsive: true,
        pageLength: 3,
        lengthMenu: [ [3, 10, 20, 50, 100, 200, 300, 500, -1], [3, 10, 20, 50, 100, 200, 300, 500, "All"] ],
        columns: columnas,
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

}

function formateaRut(rut) {

    var actual = rut.replace(/^0+/, "");
    if (actual != '' && actual.length > 1) {
        var sinPuntos = actual.replace(/\./g, "");
        var actualLimpio = sinPuntos.replace(/-/g, "");
        var inicio = actualLimpio.substring(0, actualLimpio.length - 1);
        var rutPuntos = "";
        var i = 0;
        var j = 1;
        for (i = inicio.length - 1; i >= 0; i--) {
            var letra = inicio.charAt(i);
            rutPuntos = letra + rutPuntos;
            if (j % 3 == 0 && j <= inicio.length - 1) {
                rutPuntos = "." + rutPuntos;
            }
            j++;
        }
        var dv = actualLimpio.substring(actualLimpio.length - 1);
        rutPuntos = rutPuntos + "-" + dv;
    }
    return rutPuntos;
}
