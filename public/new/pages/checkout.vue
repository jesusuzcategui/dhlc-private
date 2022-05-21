<template>
    <div>
        <div v-if="showing == true">
            <h3>¡Ha ocurrido un error al obtener la información de tu compra</h3>
            <h4>Te pedimos disculpas</h4>
            <p>Por favor, comunicaté con nosotros vía <a href="wa.me/56232108264">Whatsapp</a> para ayudarte a solucionar el problema.</p>
        </div>
        <div v-if="showing == false">
            <div class="check-container">
                <img style="width: 100px" src="/images/checked.svg" alt="checkicon" />
                <div class="check-title">
                    <h3>Compra N° {{ order.id_operacion }}</h3>
                    <p>Ha sido realizada con éxito</p>
                    <span>{{ order.fin }}</span>
                </div>

                <div class="check-detail">
                    <h3>Tu tarjeta</h3>
                    <p>{{order.pin}}</p>
                    <span>Hemos enviado a tu mail detalle de compra e instrucciones de uso de Tarjeta de llamadas Locutorios.</span>
                </div>

                <div class="check-icons">
                    <ul>
                        <li><a target="_BLANK" href="https://instagram.com/locutorios.cl"><ion-icon name="logo-instagram" size="large"></ion-icon></a></li>
                        <li><a target="_BLANK" href="https://m.me/locutorios.cl"><ion-icon name="logo-facebook" size="large"></ion-icon></a></li>
                        <li><a target="_BLANK" href="https://wa.me/56232108264"><ion-icon name="logo-whatsapp" size="large"></ion-icon></a></li>
                    </ul>
                    <a  href="/#/" class="mdl-typography--text-uppercase mdl-button mdl-js-button mdl-button--raised">
                        Ir a inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .check-icons {
        width: 100%;
    }
    .mdl-button {
        width: 100%;
    }
    .check-container {
        width: 100%;
        max-width: 500px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-color: #fff;
        margin: 30px auto;
        padding: 50px;
        box-shadow: 0 0 5px rgb(0 0 0 / 20%);
    }

    .check-title {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .check-title h3 {
        color: #2d2d2d;
        font-size: 2rem;
        text-align: center;

    }

    .check-title p {
        color: #4ad167;
        font-size: 1.5rem;
        text-align: center;
    }

    .check-title span {
        color: #acacac;
        font-size: 1.25rem;
        text-align: center;
    }

    .check-detail {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .check-detail h3 {
        color: #2d2d2d;
        font-size: 1.5rem;
        text-align: center;

    }

    .check-detail p {
        color: #4ad167;
        font-size: 4rem;
        text-align: center;
        font-weight: 900 !important;
    }

    .check-detail span {
        color: #acacac;
        font-size: .8rem;
        text-align: center;
        display: block;
        margin-top: 2rem;
    }

    .check-icons ul {
        display: flex;
        list-style: none;
        justify-content: space-between;
        padding: 0;
        margin: 15px 0;
    }

    .check-icons ul li {
        max-width: 40px;
        flex: 0 0 40px;
    }

    .check-icons ul li ion-icon{
        font-size: 80px !important;
        color: #176eae;
    }

</style>
<script>

module.exports = {
    data(){
        return {
            token: '',
            order: {},
            showing: false,
            svgcheck: null,
        }
    },
    mounted() {
        this.token = this.$route.params.token;
        this.getInformation();
    },
    methods: {
        async getInformation(){
            const { data, status } = await axios.get('/flow/status?order=' + this.token);
            if(status!=200)
                this.showing = true;
            
            this.order = data;
        }
    }
};

</script>
