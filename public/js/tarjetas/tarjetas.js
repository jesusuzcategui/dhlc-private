jQuery(document).ready(($) => {
    const valueStateModal = 0;
    FillSelect('tarjetas/ajax/estados', 'estado-select', "seleccione estado");

    FillSelect('tarjetas/ajax/precio', 'precio-select', "seleccione precio");
    jQuery(".loadtarg").hide();
    jQuery(".resulttar").hide();

    let dataTable_cards = $("#tarjetas-table").DataTable({
        processing: true,
        serverSide: true,
        serverMethod: 'post',
        ajax: {
            url: 'tarjetas/ajax/getDataTable',
            data: function(data) {
                data.filterPrice = $('#filterByPrice').find('option:selected').val(),
                    data.filterState = $('#filterByStatus').find('option:selected').val()
            }
        },
        responsive: false,
        paging: true,
        pageLength: 50,
        lengthMenu: [
            [10, 20, 50, 100, 200, 300, 500, -1],
            [10, 20, 50, 100, 200, 300, 500, "All"]
        ],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'csv',
                text: 'CSV',
                className: 'uk-button',

            },
            {
                extend: 'excel',
                text: 'Excel',
                className: 'uk-button',
            },
            {
                extend: 'pdf',
                text: 'PDF',
                className: 'uk-button',
            }
        ],

        columns: [{
                data: 'pin',
                width: '15%'
            },
            {
                data: 'codigo',
                width: '15%'
            },
            {
                data: 'precio',
                width: '20%'
            },
            {
                data: 'estado',
                width: '10%'
            },
            {
                data: 'creacion',
                width: '20%'
            },
            {
                data: 'accion',
                width: '10%'
            },
            {
                data: 'check',
                width: '10%'
            }
        ],
        columnDefs: [{
            targets: [6, 5],
            orderable: false,
        }],
        language: {
            lengthMenu: 'Mostrar _MENU_ registros',
            infoFiltered: '(Encontrados de _MAX_ registros en total)',
            loadingRecords: '<span class="fa fa-spinner spinner-icon-lg spinner-animation"></span> <span class="spinner-text">Cargando registros</span>',
            info: "Mostrando de _START_ a _END_ de un total _TOTAL_ registros",
            paginate: {
                first: 'Primera',
                previous: 'Anterior',
                last: 'Última',
                next: 'Siguiente'
            },
            search: 'Buscar'
        }
    });

    //Eventos para filtros.
    //filtro para precio........................................................

    $('#filterByPrice').on('change', function() {
        dataTable_cards.draw();
    });

    //filtro para estatus........................................................

    $('#filterByStatus').on('change', function() {
        dataTable_cards.draw();
    });

    //validaciones de usuario
    //$("#codigo").gyvalidator({require: true, type:'phone'});

    $("#precio-select").gyvalidator({
        require: true,
        type: 'selectlist'
    });
    $("#estado-select").gyvalidator({
        require: true,
        type: 'selectlist'
    });

    //CHECK ALL
    $("#checkAll").click(function() {
        if ($(this).is(':checked')) {
            $('.delete_check').prop('checked', true);
        } else {
            $('.delete_check').prop('checked', false);
        }
    });


    //GRAFICA DE JS


    /*GRÁFICA PARA ESTATUS DE TÁJETAS*/
    $.ajax({
        url: 'auditoria/ajax/tarjetas',
        method: 'post',
        dataType: 'json',
        data: {},
        beforeSend: function(before) {
            toastr.info('Analíticas de ventas', 'Cargando...', {
                progressBar: true
            });
        }
    }).then(function(done) {

        if (typeof(done) == 'object') {
            if (done.length > 0) {
                let labels = [];
                let data = [];
                let graficaElement = $("#graficaTarjetas");
                done.forEach(function(a, b) {
                    labels.push(a.labels.toUpperCase());
                    data.push(parseInt(a.cantidad));
                });

                let Char = new Chart(graficaElement, {
                    type: 'doughnut',
                    aspectRatio: 1,
                    responsive: false,
                    data: {
                        datasets: [{
                            data: data,
                            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }],

                        // These labels appear in the legend and in the tooltips when hovering different arcs
                        labels: labels
                    }
                });
            } else {
                toastr.error('No hay datos disponibles', 'Error', {
                    progressBar: true
                });
            }
        } else {
            toastr.error('Ocurrió un error en el servidor', 'Error', {
                progressBar: true
            });
        }

    }, function(error) {
        console.error(error);
    });

});

function deleteMasive() {
    var deleteids_arr = [];
    // Read all checked checkboxes
    jQuery(`input.delete_check[type="checkbox"]:checked`).each(function() {
        deleteids_arr.push($(this).val());
    });
    // Check checkbox checked or not
    if (deleteids_arr.length > 0) {
        UIkit.modal.confirm(`Desea eliminar ` + deleteids_arr.length + ` tarjetas? esta acción es irreversible.`).then(function() {

            jQuery.ajax({
                url: 'tarjetas/ajax/deletetar',
                method: 'post',
                dataType: 'json',
                data: {
                    ids: deleteids_arr
                },
                headers: {
                    "Permiso": localStorage.getItem('codigo')
                },
                beforeSend: function() {
                    toastr.info(`Están siendo eliminadas ` + deleteids_arr.length + ` tarjetas`);
                }
            }).then(function(done) {
                if (done.data.resp == 1) {
                    if ($("#checkAll").is(':checked')) {
                        $("#checkAll").prop('checked', false);
                    }
                    toastr.success(`Se han eliminado ` + done.data.cant + ` tarjetas`);
                    jQuery('#tarjetas-table').DataTable().ajax.reload();
                } else {
                    toastr.error(`Ha ocurrido un error`);
                }
            }, function(fail) {
                console.log(fail);
            });

        }, function() {

        });
    }
}

function createSelecteStates(){
    const select = document.createElement('select');
    select.classList.add('uk-select');
    const options = [
        {id: 0, label: 'SELECCIONE'},
        {id: 1, label: 'DISPONIBLES'},
        {id: 2, label: 'PROCESO'},
        {id: 3, label: 'PAGADAS'},
        {id: 4, label: 'BLOQUEADAS'},
        {id: 5, label: 'ELIMINADAS'},
    ];

    options.map((item) => {
        let htmlOp = document.createElement('option');
        htmlOp.value = item.id;
        htmlOp.text = item.label;
        select.appendChild(htmlOp);
    });

    select.onchange = (e) => {
        valueStateModal = parseInt(e.target.value);
    };

    return select;
}

function setStateMasive(){
    var deleteids_arr = [];
    // Read all checked checkboxes
    jQuery(`input.delete_check[type="checkbox"]:checked`).each(function() {
        deleteids_arr.push($(this).val());
    });
    // Check checkbox checked or not
    if (deleteids_arr.length === 0) {
        toastr.warning('Por favor seleccione alguna tarjeta');
        return false;
    }

    swal({
        title: 'Selecciona un estado',
        text: 'para actualizar las tarjetas seleccionadas.',
        icon: 'info',
        buttons: {
            confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "",
                closeModal: false
            }
        },
        content: {
            element: createSelecteStates()
        }
    }).then((e) => {
        if(valueStateModal === 0){
            toastr.error('Por favor seleccione una opcion de estado');
            return false;
        }

        jQuery.ajax({
            url: 'tarjetas/ajax/updateStateTarjetaMasive',
            method: 'post',
            dataType: 'json',
            data: {
                ids: deleteids_arr,
                state: valueStateModal
            },
            headers: {
                "Permiso": localStorage.getItem('codigo')
            },
            beforeSend: function() {
                toastr.info(`Están siendo actualizadas ` + deleteids_arr.length + ` tarjetas`);
            }
        }).then(function(done) {
            if (done.data.resp == 1) {
                if ($("#checkAll").is(':checked')) {
                    $("#checkAll").prop('checked', false);
                }
                toastr.success(`Se han actualizado ` + done.data.cant + ` tarjetas`);
                jQuery('#tarjetas-table').DataTable().ajax.reload();
                swal.close();
            } else {
                toastr.error(`Ha ocurrido un error`);
            }
        }, function(fail) {
            console.log(fail);
        });

    });
}

function importingCards(event, form) {
    event.preventDefault();
    var archivo = jQuery('#excel').prop('files')[0];
    var FormD = new FormData();
    FormD.append('excel', archivo);
    proccessAjax({
        url: 'tarjetas/ajax/import',
        method: 'post',
        dataType: 'json',
        headers: {
            "Permiso": localStorage.getItem('codigo')
        },
        data: FormD,
        processData: false,
        contentType: false,
        cache: false,
        enctype: 'multipart/form-data',
        beforeSend: function(respose) {
            jQuery("button[type='submit']").html('<i class="fas fa-spinner spinner-animation"></i>');
            jQuery(".loadtarg").show();
        }
    }, function(resp) {

        if (Array.isArray(resp)) {
            jQuery(".loadtarg").hide();
            jQuery(".resulttar").show();
            jQuery("#insertada").html(resp[0]);
            jQuery("#errores").html(resp[2]);

            jQuery("#omitidas").html(resp[1]);
            jQuery("#nomonto").html(resp[3]);
            jQuery("button[type='submit']").html('Importar tarjetas');
            console.log(resp);
        }

    }, function(error) {
        console.error(error);
    });
}

function ExportarPDF() {
    window.open("https://digitalmark.cl/reportes/locutorios/tarjetas");
}

let modaladdOpen = function() {
    //Se cambia el titulo de la modal.

    jQuery("#addusu-modal").find(".uk-modal-title").html("Registrar Tarjeta");
    //Se establece la function a ejecutar cuando se envíe el formulario.
    jQuery("#save").attr("onclick", "javascript:guardartar(event)");
    jQuery("#tar-form").find("#codigo").val("");
    jQuery("#tar-form").find("#ping").val("");
    jQuery("#tar-form").find("#precio-select").val("");
    jQuery("#tar-form").find("#estado-select").val("");
    UIkit.modal("#addtar-modal").show();
};

let modaleditOpen = function(data) {
    console.log(data);
    //Se cambia el titulo de la modal.
    jQuery("#addusu-modal").find(".uk-modal-title").html("Registrar Tarjeta");
    //Se establece la function a ejecutar cuando se envíe el formulario.
    proccessAjax({
        url: 'tarjetas/ajax/taredit',
        method: 'post',
        dataType: 'json',
        data: {
            id: data
        },
    }, function(resp) {
        console.log(resp);
        //Se establece la function a ejecutar cuando se envíe el formulario.
        jQuery("#save").attr("onclick", "javascript:actualizartar(event)");
        jQuery("#tar-form").find("#codigo").val(resp[0].cod_targ);
        jQuery("#tar-form").find("#ping").val(resp[0].pin);
        jQuery("#tar-form").find("#precio-select").val(resp[0].precio);
        jQuery("#tar-form").find("#estado-select").val(resp[0].estado);
        jQuery("#val_id").val(data);
        UIkit.modal("#addtar-modal").show();
    }, function(error) {
        console.error(error);
    });
};

let guardartar = function(event) {
    event.preventDefault();
    var codigo = jQuery("#tar-form").find("#codigo").val();
    var pin = jQuery("#tar-form").find("#ping").val();
    var precio = jQuery("#tar-form").find("#precio-select").val();
    var estado = jQuery("#tar-form").find("#estado-select").val();

    var send = {
        pin: pin,
        codigo: codigo,
        precio: precio,
        estado: estado
    }


    if (codigo != '' && precio != '' && estado != '' && pin != '') {
        proccessAjax({
            url: 'tarjetas/ajax/savetar',
            method: 'post',
            dataType: 'json',
            headers: {
                "Permiso": localStorage.getItem('codigo')
            },
            data: send,
            beforeSend: function(respose) {
                jQuery(".submit-button").html('<i class="fas fa-spinner spinner-animation"></i>');
            }
        }, function(resp) {
            console.log(resp);
            toastr.clear();
            if (resp.data == 1) {

                UIkit.modal("#addtar-modal").hide();
                jQuery(".submit-button").html('Guardar');
                jQuery('#tarjetas-table').DataTable().ajax.reload();

                toastr.success('Tarjeta registrado...');
            }
            if (resp.data == 2) {
                toastr.error('Tarjeta no registrado...');
            }
            if (resp.data == 3) {
                toastr.error('No tienes permiso para realizar esta accion...');
            }

            if (resp.data == 4) {
                toastr.error('No tienes permiso para realizar esta accion...');
            }

        }, function(error) {
            console.error(error);
        });
    } else {
        toastr.error('Algunos campos estan vacios');
    }


}

function modalDelete(id) {
    UIkit.modal.confirm('¿Desea eliminar este registro de esta tarjeta?').then(() => {
        if (id != null) {
            proccessAjax({
                url: 'tarjetas/ajax/deletetar',
                headers: {
                    "Permiso": localStorage.getItem('codigo')
                },
                method: 'post',
                dataType: 'json',

                data: {
                    id: id
                },
                beforeSend: function(respose) {
                    toastr.info('Eliminando...', {
                        "timeOut": "0"
                    });
                }
            }, function(resp) {
                toastr.clear();
                if (resp.data == 1) {
                    toastr.success('Tarjeta eliminado...');
                    jQuery('#tarjetas-table').DataTable().ajax.reload();

                }

                if (resp.data == 2) {
                    toastr.error('Tarjeta no eliminada...');
                }
                if (resp.data == 3) {
                    toastr.error('No tienes permiso para realizar esta accion...');
                }
                if (resp.data == 4) {
                    toastr.error('No tienes permiso para realizar esta accion...');
                }

            });
        }

    }, () => {
        return;
    });
}


let actualizartar = function(event) {
    event.preventDefault();
    var codigo = jQuery("#tar-form").find("#codigo").val();
    var pin = jQuery("#tar-form").find("#ping").val();
    var precio = jQuery("#tar-form").find("#precio-select").val();
    var estado = jQuery("#tar-form").find("#estado-select").val();
    var id = jQuery("#val_id").val();


    var send = {
        codigo: codigo,
        pin: pin,
        precio: precio,
        estado: estado,
        id: id
    }

    if (codigo != '' && precio != '' && estado != '' && pin != '') {
        proccessAjax({
            url: 'tarjetas/ajax/actualizartar',
            method: 'post',
            dataType: 'json',
            headers: {
                "Permiso": localStorage.getItem('codigo')
            },
            data: send,
            beforeSend: function(respose) {
                jQuery(".submit-button").html('<i class="fas fa-spinner spinner-animation"></i>');
            }
        }, function(resp) {
            console.log(resp);
            toastr.clear();
            if (resp.data == 1) {
                UIkit.modal("#addtar-modal").hide();
                jQuery('#tarjetas-table').DataTable().ajax.reload();
                jQuery(".submit-button").html('Guardar');
                toastr.success('Tarjeta Actualizado...');
            }

            if (resp.data == 2) {
                toastr.error('Tarjeta no Actualizado...');
            }
            if (resp.data == 3) {
                toastr.error('No tienes permiso para realizar esta accion...');
            }
            if (resp.data == 4) {
                toastr.error('No tienes permiso para realizar esta accion...');
            }


        });
    } else {
        toastr.error('Algunos campos estan vacios');
    }
}

function crearGrafica(id = null, data = null, type = null) {
    if (id != null && data != null && type != null) {
        let data = [];
        switch (type) {
            case 'tarjetas':

                if (Object.is(data)) {
                    data.forEach(function(a, b) {
                        console.log(a);
                    });
                }

                break;
        }
    }
}

function grafica(type = "", x = [], y = [], fondoColor = [], bordColor = []) {
    label = [];
    arr = [];
    label = x;
    arr = y;
    return config = {
        type: type,
        data: {
            labels: label,
            datasets: [{
                label: label,
                data: arr,
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    };

}