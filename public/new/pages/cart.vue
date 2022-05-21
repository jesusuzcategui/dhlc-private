<template>
    <div>
        <div class="uk-padding-large uk-grid-small uk-grid-divider" uk-grid>
            <div class="uk-width-4-5@l">
                <h3>Resumen de compra</h3>
                <div class="uk-child-width-1-2" uk-grid>
                    <div>
                        <img v-if="payment.ammount == '1'" src="/public/images/tarjetas/Tarjeta_1000.png" alt="Tarjeta de 1000" />
                        <img v-if="payment.ammount == '2'" src="/public/images/tarjetas/Tarjeta_2000.png" alt="Tarjeta de 2000" />
                        <img v-if="payment.ammount == '3'" src="/public/images/tarjetas/Tarjeta_5000.png" alt="Tarjeta de 5000" />
                        <img v-if="payment.ammount == '6'" src="/public/images/tarjetas/tarjeta_de_10_lucas.jpeg" alt="Tarjeta de 10000" />
                    </div>
                    <div>
                        <h3>Necesitamos sus datos, por favor.</h3>
                        <div role="form">
                            <div class="mdl-textfield mdl-js-textfield">
                                <input class="mdl-textfield__input"  v-model="payment.email" type="text" id="fname">
                                <label class="mdl-textfield__label" for="fname">Correo electrónico</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield">
                                <input class="mdl-textfield__input" v-model="payment.phone" type="text" id="fname">
                                <label class="mdl-textfield__label" for="fname">Numero de teléfono</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-5@l">
                <button type="button" @click="proccessPayment" class="uk-width-1-1 mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Proceder a pagar</button>
            </div>
        </div>
        <div id="placement_response_form"></div>
    </div>
</template>
<style>
    .mdl-textfield {
        max-width: 100%;
        width: 100%;
    }
</style>
<script>
    module.exports = {
        components: {
        },
        data(){
            return {
                payment: {
                    ammount: 0,
                    email: '',
                    phone: ''
                }
            };
        },
        methods: {
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
            }
        },
        mounted(){
            this.payment.ammount = sessionStorage.getItem('ammount');
        }
    };
</script>