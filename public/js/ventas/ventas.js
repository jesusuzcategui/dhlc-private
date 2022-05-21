jQuery(document).ready(($)=>{
    /* proccessAjax({
         url: 'ventas/ajax/pagos',
         method: 'post',
         dataType: 'json',
         data:{},
     }, function(resp){
         console.log(resp);
     }, function(error){
         console.log(error);
     }); */
 
     FillSelect('tarjetas/ajax/precio','precio-select',"seleccione precio");
     FillSelect('ventas/ajax/estados','estado-select',"seleccione estado");
	 
	 var f_a = new Date().toLocaleString("es-CL", {timeZone: "America/Santiago"});
	 console.log(f_a);
	 //var f_a_h = f_a.getYear() + '-' + f_a.getMonth() + '-' f_a.getDay();
	 //console.log( f_a.getFullYear() + '-' + f_a.getMonth() + '-' + f_a.getDate() );
	 
	 
 
     let dataTable_sales = $("#ventas-table").DataTable({
         processing: true,
         serverSide: true,
         serverMethod: 'post',
         ajax: {
             url: 'ventas/ajax/getDataTable',
             data: function(data){
                 data.filterPrice = $('#filterByPrecio').find('option:selected').val(),
                 data.filterState = $('#filterByEstado').find('option:selected').val(),
                 data.filterIni   = $("#filterByIni").val(),
                 data.filterFin   = $("#filterByFin").val()
             }
         },
         responsive: true,
         paging: true,
         pageLength: 50,
         lengthMenu: [ [5, 10, 20, 50, 100, 200, 300, 500, -1], [5, 10, 20, 50, 100, 200, 300, 500, "All"] ],
 
         createdRow: function(row, data, dataIndex) {
           switch (data.estado) {
             case "Pagada":
               $(row).addClass('uk-alert-success uk-dark');
               break;
             case "Eliminado":
               $(row).addClass('uk-alert-danger uk-dark');
               break;
             case "Bloqueada":
               $(row).addClass('uk-alert-warning uk-dark');
               break;
             case "Proceso":
               $(row).addClass('uk-alert-primary uk-dark');
               break;
           }
         },

         order: [
           [0, 'DESC']
         ],
 
         columnDefs: [
           { responsivePriority: 1, targets: 5 },
           { responsivePriority: 3, targets: 9 }
         ],
 
         columns: [
           {
             data: 'id',
             width: '5%'
           } , {
             data: 'cliente',
             width: '5%'
           } , {
             data: 'telefono',
             width: '5%'
           } , {
             data: 'pin',
             width: '10%'
           } , {
             data: 'precio',
             width: '10%'
           } , {
             data: 'operacion',
             width: '10%'
           } , {
             data: 'estado',
             width: '10%'
           } , {
             data: 'fecha',
             width: '10%'
           }  , {
             data: 'final',
             width: '10%'
           } , {
             data: 'accion',
             width: '25%'
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
 
     //Filter datatable
     $('#filterByPrecio, #filterByEstado').on('change', function(event){
       dataTable_sales.draw();
     });
 
     $('#filterByIni').on('change', function(event){
       if($(this).val() != ""){
         toastr.info("Por favor, elija una fecha final en el siguiente campo");
         $('#filterByFin').focus();
       } else {
         toastr.info("Por favor, elija una fecha inicial.");
       }
     });
 
     $('#filterByFin').on('change', function(event){
       if($(this).val() != ""){
 
         dataTable_sales.draw();
		 getTotals($("#filterByIni").val(), $("#filterByFin").val());
 
       } else {
         toastr.info("Por favor, elija una fecha final.");
       }
     });
 
     //validaciones de usuario
     //$("#codigo").gyvalidator({require: true, type:'phone'});
     //$("#precio").gyvalidator({require: true, type:'phone'});
     $("#precio-select").gyvalidator({require:true, type:'selectlist'});
     $("#estado-select").gyvalidator({require:true, type:'selectlist'});
 
     //Habilitar datepicker
     $.datetimepicker.setLocale('es');
     $("#fecha_final").datetimepicker({
       formatDate: 'Y-m-d',
       formatTime: 'H:i:s',
	   startDate: new Date()
     });
	 
	 
	 
	 getTotals($("#filterByIni").val(), $("#filterByFin").val());
 
     $("#exportBTN").on('click', function(event){
 
       let precio = $("#filterByPrecio").find("option:selected").val();
       let estado = $("#filterByEstado").find("option:selected").val();
       let ini    = $("#filterByIni").val();
       let fin    = $("#filterByFin").val();
 
       console.log("Precio: " + precio);
       console.log("Estado: " + estado);
       console.log("Ini:    " + ini);
       console.log("Fin:    " + fin);
 
       exportarResultadoComoPdf(precio, estado, ini, fin);
     });
	 
	 
	 //VENTA MANUAL
 
	 /*TYPEHEAD*/
	 
	 /*var pinesData = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  prefetch: 'tarjetas/ajax/querypin',
	  remote: {
		url: 'tarjetas/ajax/querypin',
		pin: '%QUERY'
	  }
	});

	$('#pinquery').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
}, {
	  source: function (query, processSync, processAsync) {
		return $.ajax({
		  url: "tarjetas/ajax/querypin", 
		  type: 'GET',
		  data: {query: query},
		  dataType: 'json',
		  success: function (json) {
			var matches = [];
            $.each(json, function(i, str) {
                matches.push(str.pin);
            });
            return processAsync(matches);
		  }
		});
	  }
	});


	console.log(pinesData);*/
 
 });
 
 
 let modaladdOpen = function(){
     //Se cambia el titulo de la modal.
 
     //Se establece la function a ejecutar cuando se envíe el formulario.
     jQuery("#ven-form").find("#email").val("");
     jQuery("#ven-form").find("#telefono").val("");
     jQuery("#ven-form").find("#precio-select").val("");
     location.href="./ventas/add";
 };
 
 let modaleditOpen = function(id, estado, fin=null){
   if( id != "" || id != null){
     if(fin!=null || fin != "" || fin != undefined){
       $("#fecha_final").datetimepicker({
         formatDate: 'Y-m-d',
         formatTime: 'H:i:s'
       });
       $("#fecha_final").val(fin);
     }
     let forma = jQuery("#venta-form");
     let modal = jQuery("#venta-modal");
     //Buscamos el input oculto para asignar el valor del id.
     forma.find('#itemId').val(id);
     forma.find("#estado-select").find(`option[value="`+estado+`"]`).attr("selected", true);
 
     UIkit.modal(modal).show();
   }
 };
 
 let guardarven = function(event){
     event.preventDefault();
     $("#save").attr("disabled",true);
     var email=jQuery("#ven-form").find("#email").val();
     var precio= jQuery("#ven-form").find("#precio-select").val();
     var telefono=jQuery("#ven-form").find("#telefono").val();
     var send={
         telefono:telefono,
         precio:precio,
         email:email
     }
     if(telefono!='' && precio!='' && email!=''){
         proccessAjax({
             url: 'ventas/ajax/saveven',
             method: 'post',
             dataType: 'json',
             headers: {"Permiso": localStorage.getItem('codigo')},
             data:send
         }, function(resp){
              console.log(resp);
              toastr.clear();
                 if(resp.data == 1){
                    console.log(resp.cod);
                    $("#save").attr("disabled",true);
                    $("#ven-form").attr("Action",resp.cod.formAction);
                    $("#token_ws").val(resp.cod.tokenWs);
                    toastr.success('Verificado de click en pagar');
                 }
                 if(resp.data == 2){
                     toastr.error('Tarjeta no registrado...');
                 }
                 if(resp.data==3){
                    toastr.error('No tienes permiso para realizar esta accion...');
                 }
                 if(resp.data==4){
                     toastr.error('No tienes permiso para realizar esta accion...');
                  }
                 if(resp.data==6){
                     $("#save").attr("disabled",false);
                     toastr.info('monto no disponible','seleccione monto diferente');
                  }
 
         }, function(error){
             console.error(error);
         });
     }else{
         toastr.error('Algunos campos estan vacios');
     }
 }
 
 function modalDelete(id){
     UIkit.modal.confirm('¿Desea eliminar este registro de esta tarjeta?').then( ()=>{
         if( id != null ){
             proccessAjax({
                 url: 'tarjetas/ajax/deletetar',
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
                     toastr.success('Tarjeta eliminado...');
                     jQuery('#tarjetas-table').DataTable().ajax.reload();
 
                 }
 
                 if(resp.data == 2){
                     toastr.error('Tarjeta no eliminada...');
                     }
                     if(resp.data==3){
                     toastr.error('No tienes permiso para realizar esta accion...');
                     }
 
             });
         }
 
       }, ()=>{
         return;
       } );
 }
 
 
 let actualizarventa = function(event){
   event.preventDefault();
   let forma = jQuery("#venta-form");
   let modal = jQuery("#venta-modal");
 
   let fecha = forma.find("#fecha_final").val();
   let data  = {
     itemId: forma.find('#itemId').val(),
     estado: forma.find("#estado-select").find(`option:selected`).val(),
     fecha:  fecha
   }
 
   if(data.itemId != "" && data.itemId != null && data.estado != "" && data.estado != null){
     jQuery.ajax({
       url: 'ventas/ajax/updateState',
       dataType: 'json',
       data: data,
       method: 'post',
       beforeSend: function(){
         toastr.info("Se está actualizando la venta.");
       }
     }).then(function(done){
       if(done.data == 1){
         $("#ventas-table").DataTable().ajax.reload();
         toastr.success('Se ha actualizado la venta y la tarjeta.');
         UIkit.modal(modal).hide();
       } else {
         toastr.error('Ocurrió un error y no se logro actualizar la venta o la tarjeta.');
       }
     },function(error){
       console.error(error);
       toastr.info("Error interno del servidor");
     });
   } else {
     toastr.warning("No se puede editar");
   }
 };
 
 
 let actualizartar = function(event){
     event.preventDefault();
     var codigo= jQuery("#tar-form").find("#codigo").val();
     var precio=jQuery("#tar-form").find("#precio-select").val();
     var estado=jQuery("#tar-form").find("#estado-select").val();
     var id= jQuery("#val_id").val();
 
 
     var send={
         codigo:codigo,
         precio:precio,
         estado:estado,
         id:id
     }
 
     if(codigo!='' && precio!='' && estado!=''){
         proccessAjax({
             url: 'tarjetas/ajax/actualizartar',
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
                     UIkit.modal("#addtar-modal").hide();
                     jQuery('#tarjetas-table').DataTable().ajax.reload();
                     jQuery(".submit-button").html('Guardar');
                     toastr.success('Tarjeta Actualizado...');
                 }
 
                 if(resp.data == 2){
                     toastr.error('Tarjeta no Actualizado...');
                 }
                 if(resp.data==3){
                    toastr.error('No tienes permiso para realizar esta accion...');
                 }
 
         });
     }  else{ toastr.error('Algunos campos estan vacios');  }
 }
 
 let finalizar = function(event){
 event.preventDefault();
 window.location.href="./ventas/add";
 }
 
 function sendmanual(event, form){
	 
	 event.preventDefault();
	 
	 var f = jQuery(form);
	 var email = f.find('.email');
	 var phone = f.find('.telefono');
	 var precio = f.find('.precio');
	 var orden  = f.find('.orden');
	 
	 if(orden.val().trim() == ""){
		toastr.warning('Debe ingresar un numero de orden');
		return;
	 }
	 
	 if(precio.val().trim() == ""){
		toastr.warning('Debe seleccionar un precio');
		return;
	 }
	 
	 if(email.val().trim() == ""){
		toastr.warning('Debe ingresar un email de cliente');
		return;
	 }
	 
	 
	 
	 jQuery.ajax({
		 url: 'ventas/ajax/registermanual',
		 method: 'post',
		 dataType: 'json',
		 data: jQuery(form).serializeArray(),
		 beforeSend: function(){
			 jQuery("#submitventa").text('PROCESANDO');
		 }
	 }).then(function(r){
		 if(r.error == null){
			 toastr.success('VENTA AGREGADA CON EXITO');
			 jQuery(form).trigger("reset");
			 jQuery("#submitventa").text('AGREGAR VENTA');
		 } if(r.error == 1){
			  toastr.info('No hay pines disponibles de este monto');
		}else {
			 toastr.error('OCURRIÓ UN ERROR');
		 }
	 }, function(e){
		 toastr.error('OCURRIÓ UN ERROR');
	 });
 }
 
 
 //Modal de detalles
 
 function modalviewOpen(id=null){
   if(id != null && id != ""){
     jQuery.ajax({
       url: 'ventas/ajax/detailSale',
       dataType: 'json',
       data: {
         itemId: id,
       },
       method: 'post',
       beforeSend: function(){
         toastr.info('Cargando data de la venta');
       }
     }).then(function(done){
       if(done.data == 1){
         toastr.success('Consulta éxitosa');
         let modal    = jQuery("#modal-sales-details");
         let modalBox = modal.find('.uk-modal-dialog');
             modalBox.find('.sale_estado').html(done.venta.estado);
             modalBox.find('.sale_precio').html('CLP '+done.venta.precio+'$');
             modalBox.find('.sale_order').html(done.venta.id_operacion);
             modalBox.find('.sale_date').html(done.venta.fecha);
             modalBox.find('.sale_datelast').html(done.venta.fin);
             modalBox.find('.sale_email').html(done.venta.correo_cliente);
             modalBox.find('.sale_telf').html(done.venta.telefono);
             modalBox.find('.sale_pin').html(done.venta.pin);
             modalBox.find('.sale_pinid').html(done.venta.cod_targ);
             modalBox.find('.sale_type').html(done.venta.tipo_venta);
             modalBox.find('.sale_wmsg').html(done.venta.mensaje_webpay);
 
             UIkit.modal(modal).show();
       } else if( done.data == 2){
         toastr.error('No se ha enviado ningun dato al servidor.');
       } else if(done.data == 3){
         toastr.error('No se ha encontrado información');
       }
     }, function(error){
       console.error(error);
       toastr.error('Error en el servidor');
     });
   } else {
     toastr.warning('No se ha cargado ningun dato');
   }
 }

 function getTotals(ini="", hasta=""){
	 
	var contenedor = jQuery("#cantidadesVentas");
	var mainClass  = contenedor.find('.venta_cants');
	 
	jQuery.ajax({
		url: `ventas/ajax/totalventas?from=${ini}&to=${hasta}`,
		dataType: 'json',
		method: 'GET',
		beforeSend: function(){
			if(mainClass){
				mainClass.each(function(a, b){
					jQuery(b).html(`<div uk-spinner></div>`);
				});
			}
		}
	}).then(function(done){
		if(done[0]){
			var totalVentas = contenedor.find('.cant_ventas');
			totalVentas.html(done[0].ventas_aprovadas);
			var totalDinero = contenedor.find('.cant_dinero');
			totalDinero.html(new Intl.NumberFormat("es-CL", {style: "currency", currency: "CLP"}).format(done[0].ventas_total_dinero));
			var total1000   = contenedor.find('.cant_1000');
			var total2000   = contenedor.find('.cant_2000');
			var total5000   = contenedor.find('.cant_5000');
			var total10000   = contenedor.find('.cant_10000');
			total1000.html( `<strong class="uk-text-small">Vendidos: ${done[0].cant_tar_mil} | ${new Intl.NumberFormat("es-CL", {style: "currency", currency: "CLP"}).format(done[0].ventas_total_mil)}` );
			total2000.html( `<strong class="uk-text-small">Vendidos: ${done[0].cant_tar_dosmil} | ${new Intl.NumberFormat("es-CL", {style: "currency", currency: "CLP"}).format(done[0].ventas_total_dosmil)}` );
			total5000.html( `<strong class="uk-text-small">Vendidos: ${done[0].cant_tar_cincomil} | ${new Intl.NumberFormat("es-CL", {style: "currency", currency: "CLP"}).format(done[0].ventas_total_cincomil)}` );
			total10000.html( `<strong class="uk-text-small">Vendidos: ${done[0].cant_tar_diezmil} | ${new Intl.NumberFormat("es-CL", {style: "currency", currency: "CLP"}).format(done[0].ventas_total_diezmil)}` );
		}
	}, function(e){
		console.error(e);
	});
  
 }
 
 
 //Filtro de pdf.
 
 function exportarResultadoComoPdf(precio="", estado="", ini="", hasta=""){
     let Uri = SITE_URL;
     Uri = Uri + "ventas/export?byPrecio="+precio+"&byState="+estado+"&byIni="+ini+"&byFin="+hasta;
     window.open(Uri , '_blank');
     /*if(precio!=null && precio!="" && precio.trim() != "" && precio != undefined){
       Uri = Uri + "?byPrecio="+precio;
     }*/
 } 

 function changeToLower(event){
   let input = event.target;
   let tolower = input.value.toLowerCase();
   input.value = tolower;
 }