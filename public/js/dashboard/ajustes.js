const ajustesApp = document.querySelector("#settingsapp");

if( ajustesApp ){
    const applicationAjustes = new Vue({
        el: ajustesApp,
        data(){
            return {
                ajustes: []
            }
        },
        methods: {

        },
        async mounted(){

        }
    });
}