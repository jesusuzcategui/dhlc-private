<template>
    <div>
        <div class="uk-container">
            <div class="android-card-container mdl-grid">
                <div class="mdl-cell mdl-card mdl-shadow--4dp">
                    <div class="mdl-card__media tarjeta_con_border">
                        <img src="/public/images/tarjetas/Tarjeta_1000.png">
                    </div>
                    <div class="mdl-card__title">
                        <h4 class="mdl-card__title-text">Tarjeta de 1000 CLP</h4>
                    </div>
                    <div class="mdl-card__actions">
                        <a @click="selectInformation(1000)" class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase" href="javascript:void(0)">
                            Más información
                            <i class="material-icons">chevron_right</i>
                        </a>
                        <button @click="openPayment(1)" class="mdl-typography--text-uppercase mdl-button mdl-js-button mdl-button--raised">
                            Comprar
                        </button>
                    </div>
                </div>
                <div class="mdl-cell mdl-card mdl-shadow--4dp">
                    <div class="mdl-card__media tarjeta_con_border">
                        <img src="/public/images/tarjetas/Tarjeta_2000.png">
                    </div>
                    <div class="mdl-card__title">
                        <h4 class="mdl-card__title-text">Tarjeta de 2000 CLP</h4>
                    </div>
                    <div class="mdl-card__actions">
                        <a  @click="selectInformation(2000)" class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase"  href="javascript:void(0)">
                            Más información
                            <i class="material-icons">chevron_right</i>
                        </a>
                        <button @click="openPayment(2)"  class="mdl-typography--text-uppercase mdl-button mdl-js-button mdl-button--raised">
                            Comprar
                        </button>
                    </div>
                </div>
                <div class="mdl-cell mdl-card mdl-shadow--4dp">
                    <div class="mdl-card__media tarjeta_con_border">
                        <img src="/public/images/tarjetas/Tarjeta_5000.png">
                    </div>
                    <div class="mdl-card__title">
                        <h4 class="mdl-card__title-text">Tarjeta de 5000 CLP</h4>
                    </div>
                    <div class="mdl-card__actions">
                        <a  @click="selectInformation(5000)" class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase"  href="javascript:void(0)">
                            Más información
                            <i class="material-icons">chevron_right</i>
                        </a>
                        <button @click="openPayment(3)" class="mdl-typography--text-uppercase mdl-button mdl-js-button mdl-button--raised">
                            Comprar
                        </button>
                    </div>
                </div>
                <div class="mdl-cell mdl-card mdl-shadow--4dp">
                    <div class="mdl-card__media">
                        <img src="/public/images/tarjetas/tarjeta_de_10_lucas.jpeg">
                    </div>
                    <div class="mdl-card__title">
                        <h4 class="mdl-card__title-text">Tarjeta de 10000 CLP</h4>
                    </div>
                    <div class="mdl-card__actions producto_action">
                        <a  @click="selectInformation(10000)" class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase"  href="javascript:void(0)">
                            Más información
                            <i class="material-icons">chevron_right</i>
                        </a>
                        <button @click="openPayment(6)" class="mdl-typography--text-uppercase mdl-button mdl-js-button mdl-button--raised">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="placement_response_form"></div>
        <div id="modal_purchase" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Necesitamos tus datos, por favor</h2>
                </div>
                <div class="uk-modal-body">
                    
                    <form>
                        <div class="uk-margin">
                            <input type="text" class="uk-input" v-model="payment.email" placeholder="Ingresa tu email" />
                        </div>
                        <div class="uk-margin">
                            <input type="text" class="uk-input" v-model="payment.phone" placeholder="Ingresa tu numero de teléfono" />
                        </div>
                    </form>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                    <button class="uk-button uk-button-primary" type="button" @click="proccessPayment()">Comprar</button>
                </div>
            </div>
        </div>

        <div id="modal_information" class="uk-padding-small" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title uk-margin-remove-bottom">Información</h2>
                    <h4 class="uk-margin-remove-top">Minutos {{ammount}} CLP</h4>
                </div>
                <div class="uk-modal-body">
                    <div class="">
                        <div v-if="ammount === 1000">
                            <img src="/public/images/tarifas/1000.jpg" alt="Tarifa 1000" />
                        </div>
                        <div v-if="ammount === 2000">
                            <img src="/public/images/tarifas/2000.jpg" alt="Tarifa 1000" />
                        </div>
                        <div v-if="ammount === 5000">
                            <img src="/public/images/tarifas/5000.jpg" alt="Tarifa 1000" />
                        </div>
                        <div v-if="ammount === 10000">
                            <img src="/public/images/tarifas/10000.jpg" alt="Tarifa 1000" />
                        </div>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .tarjeta_con_border {
        border-radius: 15px !important;
    }
</style>
<script>
    module.exports = {
        data(){
            return {
                information: [],
                ammount: 0,
                minutos: {},
                payment: {
                    email: '',
                    phone: '',
                    ammount: '',
                }
            };
        },
        methods: {
            selectInformation(monto){
                this.information = this.minutos[monto];
                this.ammount = monto;
                const modal_information = document.querySelector("#modal_information");
                UIkit.modal(modal_information).show();
            },
            proccessPayment(){
                
                if( this.payment.email.trim() == '' || this.payment.phone.trim() == '' )
                {
                    toastr.info('Por favor complete todos los campos.', 'Información');
                    return false;
                }
                
                swal({
                    title: "Estás seguro de proceder con la compra?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        
                        const form = new FormData();
                        form.append('precio', this.payment.ammount);
                        form.append('correo', this.payment.email);
                        form.append('telefono', this.payment.phone);

                        axios
                            .post('/home/proccesspayment', form)
                            .then( (response) => {
                                const status = response.data.data.data;
                                if(status == 1){
                                    const placement_response_form = document.querySelector("#placement_response_form");
                                    const form_element = document.createElement('form');
                                    const input_element = document.createElement('input');
                                    form_element.action = response.data.data.cod.action;
                                    form_element.method = 'post';
                                    form_element.id = "form_payment_webpay";
                                    input_element.type = 'hidden';
                                    input_element.value = response.data.data.cod.token_ws;
                                    input_element.name = "token_ws";

                                    //formated form
                                    form_element.appendChild(input_element);

                                    placement_response_form.appendChild(form_element);

                                    swal({
                                        title: 'OK',
                                        icon: 'success',
                                        text: 'Vamos a pagar',
                                        buttons: false,
                                    });

                                    setTimeout(() => {
                                        form_element.submit();
                                    }, 2000);


                                }

                                if(status == 4){
                                    swal({
                                        title: 'Info',
                                        icon: 'info',
                                        text: 'Actualmente no existe disponibilidad de pines de este monto',
                                        buttons: false,
                                    });
                                }
                                console.log(response);
                            } )
                            .catch( (error) => {
                                console.error(error);
                            } );
                    } else {
                    }
                });
            },
            openPayment(ammount=null){
                this.payment.ammount = ammount;
                let modalHtml = document.querySelector("#modal_purchase");
                UIkit.modal(modalHtml).show();
            },
            async trackingEvent(){
                const datita = {
                    "data": [
                        {
                            "event_name": "Purchase",
                            "event_time": 1636767390,
                            "action_source": "email",
                            "user_data": {
                                "em": [
                                    "7b17fb0bd173f625b58636fb796407c22b3d16fc78302d79f0fd30c2fc2fc068"
                                    ],
                                "ph": [
                                    null
                                ]
                            },
                            "custom_data": {
                                "currency": "USD",
                                "value": "142.52"
                            }
                        }
                    ]
                }; 
                
                
                const response = await axios.post('https://graph.facebook.com/v12.0/600900951051353/events?access_token=EAAFzVMai9U4BAE1W8eoC2RY681pvlfL5vYZCNsDhLyH7oBVICopCLE45ehA4HwljaqltqxBI1VQFFYCvjaaQxJZBVToU2YsRBeWmUBMBDTZBo5U7Dk9KaEZBZCPVLGS3AibvKTQYQpZCcZBNqFZCn14l4HZC8unozZBLxQOBuiWbosJUHSM4Lmi6tb', datita);
                console.log(response);
            },
            showError(error=null){
                if(!error){
                    return false;
                }

                switch (error) {
                    case 2:
                        swal({
                            title: 'Info',
                            icon: 'warning',
                            text: 'Error al procesar la compra',
                            buttons: false,
                        });
                        break;
                    case 3:
                        swal({
                            title: 'Info',
                            icon: 'warning',
                            text: 'La recarga no pudo ser gestionada',
                            buttons: false,
                        });
                        break;
                    case 4:
                        swal({
                            title: 'Info',
                            icon: 'warning',
                            text: 'No hay tarjetas disponibles para este monto',
                            buttons: false,
                        });
                        break;
                }

                let modalHtml = document.querySelector("#modal_purchase");
                UIkit.modal(modalHtml).hide();

                this.payment = {
                    email: '',
                    phone: '',
                    ammount: '',
                };
            }
        },
        mounted(){
            this.minutos = this.$root.minutes;
            //this.trackingEvent();

        }
    };
</script>