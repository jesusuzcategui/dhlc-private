const ifExistC = document.querySelector("#clientnorsales");

if(ifExistC){
    const banner_manager = new Vue({
        "el": "#clientnorsales",
        data: function(){
            return {
                init: null,
                ended: null,
                list: [],
                lista_correos: [],
                mostrar: false
            };
        },
        mounted(){
        },
        methods: {
            async searchData(){
                if( this.init == null || this.ended == null || this.init == "" || this.ended == "" ){
                    alert('Por favor seleccione unas fechas.');
                    return false;
                }
                
                const uri = "/dashboard/getClientsNoSales?init=" + this.init + "&ended=" + this.ended;
                
                const {status, data} = await axios.get(uri);
                
                if(status == 200){
                    this.list = data;
                    this.lista_correos = data;
                    if(data.length > 0){
                        this.mostrar = true;
                    }
                }
            },
            exportExcelCL(){
                if( this.init == null || this.ended == null || this.init == "" || this.ended == "" ){
                    alert('Por favor seleccione unas fechas.');
                    return false;
                }
                
                const uri = SITE_URL + "/dashboard/exportClientsNotSales?init=" + this.init + "&ended=" + this.ended;
                
                window.open(uri, '_blank');
            }
        }
    });
}