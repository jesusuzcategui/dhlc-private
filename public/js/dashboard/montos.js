const montosDiv = document.querySelector("#montos");
const init = {
    el: "#montos",
    data(){
        return {
            loading: true,
            montos: [],
            image: null,
            id: null
        };
    },
    methods: {
        changeImage(event, id){
            this.image = event.target.files[0];
            this.id = id;
        },
        uploadImage(event, id, image_field){
            let form = new FormData();
            form.append('id', id);
            form.append('field', image_field);
            form.append('banner', this.image);

            axios.post('/dashboard/uploadImageMonto', form)
            .then(function(done){
                window.location.reload();
            })
            .catch(function(e){
                if(e){
                    alert('Ha ocurrido un error en el servidor');
                }
            });
        },
        load(){
            let vm = this;
            axios.get('/dashboard/loadingPrice')
            .then(function(done){
                const { data } = done;
                vm.montos = data;
                vm.loading = false;
            })
            .catch(function(e){
                console.log({ e });
            });
        }
    },
    mounted: function(){
        this.load();
    }
};

if( montosDiv )
{
    new Vue(init);
}