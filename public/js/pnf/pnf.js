jQuery(document).ready( function($){


    selectmultiple("sedes/async?action=getsede", "POST", "sedes");

    FillSelect('sedes/async?action=getestatus', "estatus","seleccione estatus");

    datatable()


} );

var modalPnfOpen = function(){
    jQuery("#pnf-modal").find(".modal-title").text('Agregar PNF');
    jQuery("#pnf-modal").find("#pnf-form").attr("onsubmit", "javascript:savepnf(event)");
    jQuery("#pnf-modal").find("#pnf-form").find("button[type='submit']").text("Agregar");
    jQuery("#desc").val("");
    jQuery("#sedes").val("");
    jQuery("#estatus").val("");
    jQuery("#pnf-modal").modal('show');
};



var savepnf = function(event){
    event.preventDefault();
    var request = {
        sede: jQuery("#sedes").val(),
        desc: jQuery("#desc").val(),
        estatus: jQuery("#estatus").find('option:selected').val()
    };

    if( request.desc == "" || request.estatus == "" || request.sede == "" || request.sede == null ){
        toastr.info("Debe llenar todos los campos");
    } else {
        proccessAjax({
            url:'pnf/async?action=add',
            method:'post',
            dataType: 'json',
            data: request
        }, function(data){
            if( data.data === false ){
                toastr.warning('Se ha producido un error, intete más tarde.');
            } else {
                jQuery("#desc").val("");
                jQuery("#sedes").val("");
                jQuery("#estatus").val("");
                toastr.success('Se ha guardado el pnf correctamente.');
                jQuery("#pnf-modal").modal('hide');
            }
        }, function(err){
            toastr.error('Error al procesar petición al servidor');
        });
    }


};
