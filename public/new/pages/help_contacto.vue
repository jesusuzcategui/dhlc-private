<template>
    <div>
        <div class="uk-container">
            <h3 class="uk-text-center uk-heading-primary uk-margin-bottom-large">Contacto</h3>

            <div>
                <div class="uk-card uk-card-body uk-card-default">
                    <formulario-contacto />
                </div>
            </div>

            <div class="uk-margin-top uk-text-center">
                <a href="/#/" class="mdl-typography--text-uppercase mdl-button mdl-js-button mdl-button--raised uk-width-1-1">VAMOS A COMPRAR</a>
            </div>
        </div>
    </div>
</template>
<script>
    const formulario = httpVueLoader('/public/new/Components/FormularioContacto.vue');

    module.exports = {
        components: {
            "formulario-contacto" : formulario,
        },
        data(){
            return {};
        },
        methods: {

        }
    };
</script>