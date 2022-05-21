<template>
    <div>
        <div class="uk-container">
            <div class="android-card-container grid-productos mdl-grid">
                <div class="mdl-cell mdl-card mdl-shadow--4dp">
                    <div class="mdl-card__media">
                        <img src="/public/images/tarjetas/Tarjeta_1000.png">
                    </div>
                    <div class="mdl-card__title">
                        <h4 class="mdl-card__title-text">Tarjeta de 1000 CLP</h4>
                    </div>
                    <div class="mdl-card__actions producto_action">
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
                    <div class="mdl-card__media">
                        <img src="/public/images/tarjetas/Tarjeta_2000.png">
                    </div>
                    <div class="mdl-card__title">
                        <h4 class="mdl-card__title-text">Tarjeta de 2000 CLP</h4>
                    </div>
                    <div class="mdl-card__actions producto_action">
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
                    <div class="mdl-card__media">
                        <img src="/public/images/tarjetas/Tarjeta_5000.png">
                    </div>
                    <div class="mdl-card__title">
                        <h4 class="mdl-card__title-text">Tarjeta de 5000 CLP</h4>
                    </div>
                    <div class="mdl-card__actions producto_action">
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
                        <a  @click="selectInformation(5000)" class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase"  href="javascript:void(0)">
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

        <dialog class="mdl-dialog" id="modal-example">
            <div class="mdl-dialog__content">
                <h3>Necesitamos tus datos</h3>
                
                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input"  v-model="payment.email" type="text" id="fname">
                    <label class="mdl-textfield__label" for="fname">Correo electrónico</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input" v-model="payment.phone" type="text" id="fname">
                    <label class="mdl-textfield__label" for="fname">Numero de teléfono</label>
                </div>
            </div>
            <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
                <button type="button" class="mdl-button" @click="closeMaterialModal">Cancelar</button>
                <button type="button"  class="mdl-typography--text-uppercase mdl-button mdl-js-button mdl-button--raised" v-if="payment.email != '' || payment.phone != ''" @click="proccessPayment()">Comprar</button>
            </div>
        </dialog>

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
.mdl-dialog {
  border: none;
  box-shadow: 0 9px 46px 8px rgba(0, 0, 0, 0.14), 0 11px 15px -7px rgba(0, 0, 0, 0.12), 0 24px 38px 3px rgba(0, 0, 0, 0.2);
  max-width: 800px;
  width: 100%;
}

.mdl-dialog__title {
    padding: 24px 24px 0;
    margin: 0;
    font-size: 2.5rem; 
}

.mdl-dialog__actions {
    padding: 8px 8px 8px 24px;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-direction: row-reverse;
        -ms-flex-direction: row-reverse;
            flex-direction: row-reverse;
    -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
            flex-wrap: wrap; 
}

.mdl-dialog__actions > * {
    margin-right: 8px;
    height: 36px;
}

.mdl-dialog__actions > *:first-child {
    margin-right: 0;
}

.mdl-dialog__actions--full-width {
    padding: 0 0 8px 0;
}

.mdl-dialog__actions--full-width > * {
    height: 48px;
    -webkit-flex: 0 0 100%;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    padding-right: 16px;
    margin-right: 0;
    text-align: right;
}

.mdl-dialog__content {
    padding: 20px 24px 24px 24px;
    color: rgba(0,0,0, 0.54);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.mdl-textfield {
    max-width: 100%;
    width: 100%;
}

.producto_action {
    display: flex;
}

.producto_action .mdl-button {
    font-size: 11px;
}

@media screen and (min-width: 840px) {
    .grid-productos .mdl-cell {
        width: calc(25% - 16px) !important;
    }
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
                },
                modal: {}
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

                this.dialog.close();
                
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
                        .post('/flow/createPaymentUrl', form)
                        .then( (response) => {
                            console.log(response);
                            window.location.href = response.data.urlpago;
                        } ).catch( (error) => {
                            swal({
                                title: "Error",
                                text: "No hemos podido conectar con el procesador de pagos",
                                icon: "error",
                                buttons: false
                            });
                        } );
                    } else {
                    }
                });
            },
            openPayment(ammount=null){
                this.payment.ammount = ammount;
                this.dialog.showModal();
                //let modalHtml = document.querySelector("#modal_purchase");
                //UIkit.modal(modalHtml).show();
            },
            openMaterialModal(){
                this.dialog.showModal();
            },
            closeMaterialModal(){
                this.dialog.close();
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
            this.dialog = document.querySelector('#modal-example');
            
            if (! this.dialog.showModal) {
                dialogPolyfill.registerDialog(dialog);
            }
            
        }
    };
</script>