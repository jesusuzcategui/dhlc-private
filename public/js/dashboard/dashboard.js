jQuery(document).ready(function($){

    /*CONTADOR TOTAL DE PESOS CHILENOS*/

    /*GRÁFICA PARA ESTATUS DE TÁJETAS*/
    $.ajax({
        url: 'auditoria/ajax/tarjetas',
        method: 'post',
        dataType: 'json',
        data: {},
        beforeSend: function(before){
            toastr.info('Analíticas de ventas', 'Cargando...', {
                progressBar: true
            });
        }
    }).then(function(done){

        if(typeof(done) == 'object'){
            if(done.length > 0){
                let labels = [];
                let data   = [];
                let graficaElement = $("#graficaTarjetas");
                done.forEach(function(a,b){
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
                            'rgba(255, 206, 86, 0.2)','rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)','rgba(255, 159, 64, 0.2)'],
                        borderColor: ['rgba(255, 99, 132, 1)','rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)','rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)','rgba(255, 159, 64, 1)'],
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

    },function(error){
        console.error(error);
    });


});

function crearGrafica(id=null, data=null, type=null){
    if(id!=null && data != null && type != null){
        let data = [];
        switch(type){
            case 'tarjetas':

                if(Object.is(data)){
                    data.forEach(function(a,b){
                        console.log(a);
                    });
                }

                break;
        }
    }
}

function grafica(type="",x=[],y=[],fondoColor=[],bordColor=[]){
    label=[];
    arr=[];
    label=x;
    arr=y;
    return config={
        type: type,
        data: {
            labels:label,
            datasets: [{
                label:label,
                data:arr,
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)',
                         'rgba(255, 206, 86, 0.2)','rgba(75, 192, 192, 0.2)',
                         'rgba(153, 102, 255, 0.2)','rgba(255, 159, 64, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)','rgba(54, 162, 235, 1)',
                         'rgba(255, 206, 86, 1)','rgba(75, 192, 192, 1)',
                         'rgba(153, 102, 255, 1)','rgba(255, 159, 64, 1)'],
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