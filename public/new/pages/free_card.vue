<template>
    <div>
        <div class="container-dividivo uk-child-width-1-2" uk-height-match uk-grid>
            <div class="uk-margin-auto">
                <h2>Locutorios te regala Tarjeta de Llamadas</h2>
                
                <div v-if="verificado===0">
                    <h4>Completa tus datos y recibe en tu mail tarjeta e instrucciones de uso para que hables hasta 10 minutos, totalmente gratis!</h4>
                    <form class="flex-colunm" v-on:submit.prevent="validateForm">
                        <div class="mdl-textfield mdl-js-textfield">
                            <input class="mdl-textfield__input"  v-model="email" type="text" id="fname">
                            <label class="mdl-textfield__label" for="fname">Correo electrónico</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield">
                            <input class="mdl-textfield__input" v-model="phone" type="text" id="fname">
                            <label class="mdl-textfield__label" for="fname">Numero de whatsapp</label>
                        </div>
                        <div>
                            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Adquirir tarjeta</button>
                        </div>
                    </form>
                </div>
                <div v-if="verificado===1">
                    <h4>VERIFICA TUS DATOS</h4>
                    <div class="flex-colunm">
                        <div class="">
                            <h5 class="" for="fname">Correo electrónico: {{email}}</h5>
                        </div>
                        <div class="">
                            <h5 class="" for="fname">Numero de whatsapp: {{phone}}</h5>
                        </div>
                        <div>
                            <button v-on:click="verificado=0" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Volver</button>
                            <button v-on:click="getGif" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Adquirir tarjeta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .container-dividivo {
        width: 100%;
        height: 89vh;
    }
    
    .container-dividivo img {
        height: 89vh;
        width: 100%;
        object-fit: cover;
        object-position: top;
    }
    
    .uk-background-secondary.uk-padding.uk-margin-large-top {
        margin-top: 0 !important;
    }

    .flex-colunm {
        display: flex;
        flex-direction: column;
    }

    .flex-colunm .mdl-textfield {
        width: 100%;
    }
</style>
<script>

module.exports = {
    data(){
        return {
            verificado: 0,
            email: '',
            phone: ''
        }
    },
    methods: {
        validateForm(){
            if( this.email.trim() == "" || this.phone.trim() == ""){
                toastr.info('Por favor complete todos los campos.', 'Información');
                return false;
            }

            this.verificado = 1;
        },
        getGif(){
            let form = new FormData();
            form.append('correo', this.email);
            form.append('telefono', this.phone);
            axios
            .post('/flow/createSolicitud', form)
            .then( (response) => {
                console.log(response);
                swal({
                    title: "Felicidades",
                    text: "Hemos enviado tu pin a tu correo. Gracias por probar nuestro servicio, esperamos que lo disfrutes.",
                    icon: "success",
                    buttons: false
                });
                this.verificado = 0;
                this.email = "";
                this.phone = "";
            } ).catch( (error) => {
                if(error && error.response){
                    console.log("er", error.response);
                    if(error.response.status == 400){
                        swal({
                            title: "Info",
                            text: "Ya te hemos enviado una tarjeta a ese correo.",
                            icon: "warning",
                            buttons: false
                        });
                    } else {
                        swal({
                            title: "Error",
                            text: "Servidor",
                            icon: "error",
                            buttons: false
                        });
                    }
                }
            } );
        }
    },
    mounted() {
    }
};

</script>
