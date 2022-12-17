if( document.querySelector('#partner') ) {
    new Vue({
        el: "#partner",
        data: function(){
            return {
                tab: 'lista',
                isEdit: false,
                reg: {
                    nombre: '',
                    comment: ''
                },
                edit: {
                    nombre: null,
                    comentario: null,
                    status: null,
                    id: null
                },
                list: []
            }
        },
        methods: {
            editPartner: async function(id){
                this.isEdit = true;
                this.edit.id = id;
                const { status, data } = await axios.get('/partner/getPartners?id=' + this.edit.id);
                if( status == 200 ){
                    if( !Array.isArray(data) && data.length > 0 ){
                        alert('error al editar');
                        return false;
                    }

                    const { estatus, nombre, comentario } = data[0];

                    this.edit.nombre = nombre;
                    this.edit.comentario = comentario;
                    this.edit.status = estatus;
                } else {
                    throw Error(JSON.stringify(data));
                }
                setTimeout(() => UIkit.switcher("#switcher-nav").show(3), 500);
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