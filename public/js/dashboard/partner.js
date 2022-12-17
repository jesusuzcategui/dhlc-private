if( document.querySelector('#partner') ) {
    new Vue({
        el: "#partner",
        data: function(){
            return {
                tab: 'lista',
                isEdit: false,
                isSales: false,
                sales: [],
                reg: {
                    nombre: '',
                    comment: ''
                },
                edit: {
                    nombre: null,
                    comentario: null,
                    status: null,
                    id: null,
                    bitly: null,
                    serial: null
                },
                list: []
            }
        },
        methods: {
            generateBitly: async function(){
                const header = {
                    'Content-Type': 'application/json', 
                    'Authorization': 'Bearer e5e14cb2d95f858c4a45dc9f991533abbdb42f18'
                };

                const { status, data } = await axios.post('https://api-ssl.bitly.com/v4/bitlinks', {
                    long_url: 'https://tarjetalocutorios.com?partner=' + this.edit.serial,
                    domain: 'bit.ly'
                }, {
                    headers: header
                });

                if(200 != status){
                    alert('Bitly a retornado un error.');
                    return false;
                }

                this.edit.bitly = data.link;

                window.toastr.success('Bitly creado, ahora actualizar');
            },
            editPartner: async function(id){
                this.isEdit = true;
                this.edit.id = id;
                const { status, data } = await axios.get('/partner/getPartners?id=' + this.edit.id);
                if( status == 200 ){
                    if( !Array.isArray(data) && data.length > 0 ){
                        alert('error al editar');
                        return false;
                    }

                    const { estatus, nombre, comentario, bitly, serial } = data[0];

                    this.edit.nombre = nombre;
                    this.edit.comentario = comentario;
                    this.edit.status = estatus;
                    this.edit.bitly = bitly;
                    this.edit.serial = serial;
                } else {
                    throw Error(JSON.stringify(data));
                }
                setTimeout(() => UIkit.switcher("#switcher-nav").show(3), 500);
            },
            openSales: async function(id){
                this.isSales = true;
                const { status, data } = await axios.get('/partner/getSales?id=' + id);
                if( status == 200 ){
                    if( !Array.isArray(data) && data.length > 0 ){
                        alert('error al editar');
                        return false;
                    }

                    this.sales = data;
                } else {
                    throw Error(JSON.stringify(data));
                }
                setTimeout(() => UIkit.switcher("#switcher-nav").show(4), 500);
            },
            deletePartner: async function(id){
                const confirma = confirm("Desea eliminar?");
                if(confirma){
                    const form = new FormData();
                    const header = {'Content-Type': 'multipart/form-data'};
                    const { status } = await axios.post('/partner/delete?id=' + id, form, { header });
                    if( status == 200 ){
                        window.location.reload();
                    } else {
                        alert('Ha ocurrido un error');
                    }
                }
            },
            getPartners: async function(){
                const { status, data } = await axios.get('/partner/getPartners');
                if( status == 200 ){
                    this.list = data;
                } else {
                    throw Error(JSON.stringify(data));
                }
            },
            registerSubmit: async function(){
                const form = new FormData();
                form.append("nombre", this.reg.nombre);
                form.append("comentario", this.reg.comentario);
                const header = {'Content-Type': 'multipart/form-data'};
                const { status } = await axios.post('/partner/store', form, { header });
                if( status == 200 ){
                    window.location.href = "/partner?tab=list";
                } else {
                    alert('Ha ocurrido un error');
                }
            },
            updateSubmit: async function(){
                const form = new FormData();
                form.append("nombre", this.edit.nombre);
                form.append("comentario", this.edit.comentario);
                form.append("estatus", this.edit.status);
                form.append("bitly", this.edit.bitly);
                const header = {'Content-Type': 'multipart/form-data'};
                const { status } = await axios.post('/partner/update?id=' + this.edit.id, form, { header });
                if( status == 200 ){
                    window.location.reload();
                } else {
                    alert('Ha ocurrido un error');
                }
            },
            changeTab: function(v){
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                urlParams.set('tab', v);
                if( window.history.replaceState ){
                    const uri = window.location.protocol + "//" + window.location.host + window.location.pathname + "?" + urlParams.toString();
                    window.history.replaceState({
                        path: uri
                    }, "", uri);
                    this.tab = v;

                    this.isEdit = false;
                    this.isSales = false;
                    this.sales = [];
                    this.edit = {
                        nombre: null,
                        comentario: null,
                        status: null,
                        id: null
                    };
                }
            }
        },
        mounted: function(){
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            this.tab = urlParams.get("tab") ? urlParams.get("tab") : 'lista';
            let index = 0;
            if( this.tab == 'registro' ){
                index = 1;
            } else if (this.tab == 'exp') {
                index = 2;
            } else if (this.tab == 'edit') {
                index = 3;
            }

            UIkit.switcher("#switcher-nav").show(index);

            this.getPartners();

            const partnerTable = document.querySelector("#partnerTable");
            setTimeout(() => {
                jQuery(partnerTable).DataTable();
            }, 500);
        }
    });
}