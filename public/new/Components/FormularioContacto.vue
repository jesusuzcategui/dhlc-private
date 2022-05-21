<template>
    <div>
        <form @submit.prevent="sendMessage()">
            <div class="uk-margin">
                <input placeholder="Escriba su nombre" type="text" name="message_name" v-model="message.name" class="uk-input" />
            </div>
            <div class="uk-margin">
                <input placeholder="Escriba su email" type="email" name="message_email" v-model="message.email" class="uk-input" />
            </div>
            <div class="uk-margin">
                <input placeholder="Escriba su numero de Whatsapp" type="text" name="message_whatsapp" v-model="message.whatsapp" class="uk-input" />
            </div>
            <div class="uk-margin">
                <textarea class="uk-textarea" placeholder="Escriba en que podemos ayudarle" name="message_msg" v-model="message.message"></textarea>
            </div>
            <div class="uk-margin">
                <button type="submit" class="uk-button uk-button-primary uk-width-1-1">ENVIAR MENSAJE</button>
            </div>
        </form>
    </div>
</template>
<script>
    module.exports = {
        data(){
            return {
                message: {
                    name: '',
                    email: '',
                    whatsapp: '',
                    message: '',
                }
            };
        },
        methods: {
            sendMessage(){
                const msg = this.message;
                if( msg.name.trim() == '' || msg.email.trim() == '' || msg.whatsapp.trim() == '' || msg.message.trim() == '' ){
                    swal({
                        title: 'Información',
                        text: 'Por favor complete todos los campos.',
                        icon: 'info',
                        buttons: false,
                    });

                    return false;
                }

                const form = new FormData();
                form.append('name', msg.name);
                form.append('email', msg.email);
                form.append('whatsapp', msg.whatsapp);
                form.append('mensaje', msg.message);

                return axios.post('/home/sendmsgcontact', form).then((response)=>{
                    swal({
                        title: 'OK',
                        text: 'Pronto nos pondremos en contacto contigo',
                        icon: 'success',
                        buttons: false,
                    });

                    this.message = {
                        name: '',
                        email: '',
                        whatsapp: '',
                        message: '',
                    };

                    console.log(response)
                }).catch((error)=>{
                    console.error(error);
                });
            }
        }
    };
</script>