const ifExist = document.querySelector("#bannermanager");

if(ifExist){
    const banner_manager = new Vue({
        "el": "#bannermanager",
        data: function(){
            return {
                banner: null,
                loading: false,
                image: null,
                imageMovil: null,
                idNow: null,
                loadingList: false,
                list: [],
                form_update: {
                    position: '',
                    url: ''
                },
                currentEdit: null
            };
        },
        mounted(){
            this.listBanners();
        },
        methods: {
            onChangeFileMovil(evt, id){
                console.log(evt);
                this.imageMovil = evt.target.files[0];
                this.idNow = id;
            },
            onChangeFile(){
                this.banner = this.$refs.banner.files[0];
                console.log(this.banner);
            },
            async openEdit(id){
                let modal = document.querySelector("#banner_edit");
                const { data, status } = await axios.get('/dashboard/getBanner?id='+id);
                if( status == 200 ){
                    if( Array.isArray(data) && data.length > 0 ){
                        this.currentEdit = data[0];
                    }
                }
                UIkit.modal(modal).show();
            },
            async updateEdit(){
                let id = this.currentEdit.id;
                let url = this.currentEdit.link_related;
                let position = Number.parseInt(this.currentEdit.position);

                const form = new FormData();
                form.append("id", Number.parseInt(id));
                form.append("url", url);
                form.append("position", Number.isNaN(position) ? null : position);

                const header = {'Content-Type': 'multipart/form-data'};
                const {data, status} = await axios.post('/dashboard/updateSettingsBanner', form, { header });
                
                if(status == 200){
                    window.location.reload();
                } else {
                    alert('Ha ocurrido un error.');
                }
            },
            async submitBannerMovil(){
                if(!this.imageMovil){
                    UIkit.modal.alert('Por favor selecciona un archivo antes').then(function(){});
                    return false;
                }
    
                this.loading = true;
                const IdForm = this.idNow;
                const form = new FormData();
                form.append('banner', this.imageMovil);
                form.append('id', IdForm);
                const header = {'Content-Type': 'multipart/form-data'};
                const {data, status} = await axios.post('/dashboard/uploadBannerMovil', form, { header });
                console.log(data);
                if(status === 200){
                    window.location.reload();
                } else {
                    alert('Ha ocurrido un error.');
                }
            },
            async submitBanner(){
                if(!this.banner){
                    UIkit.modal.alert('Por favor selecciona un archivo antes').then(function(){});
                    return false;
                }
    
                this.loading = true;
                const form = new FormData();
                form.append('banner', this.banner);
                const header = {'Content-Type': 'multipart/form-data'};
                const {data, status} = await axios.post('/dashboard/uploadBanner', form, { header });
                if(status === 200){
                    window.location.reload();
                } else {
                    alert('Ha ocurrido un error.');
                }
            },
            async listBanners(){
                this.loadingList = true;
                const { data, status } = await axios.get('/dashboard/listBanner');
                if(status == 200){
                    this.loadingList = false;
                    this.list = data;
                }
            },
            async updateBanner(id, estado){
                const form = new FormData();
                form.append("estado", estado);
                form.append("id", id);
                const {data, status} = await axios.post('/dashboard/updateState', form);
                if(status == 200){
                    UIkit.modal.alert('Banner actualizado').then(function(){});
                    this.listBanners();
                }
            },
            async deleteBanner(id){
                const {data, status} = await axios.delete('/dashboard/deleteBanner?id='+id);
                console.log(data);
                if(status == 200){
                    UIkit.modal.alert('Banner eliminado').then(function(){});
                    this.listBanners();
                }
            }
        }
    });
}