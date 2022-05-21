Vue.use(VueRouter);

/*PÁGINAS*/
const HomePage = httpVueLoader('/public/new/pages/index.vue');
const ComoComprarPage = httpVueLoader('/public/new/pages/help_comprar.vue');
const ComoUsarPage = httpVueLoader('/public/new/pages/help_usar.vue');
const PreguntasFrecuentesPage = httpVueLoader('/public/new/pages/help_question.vue');
const ContactoPage = httpVueLoader('/public/new/pages/help_contacto.vue');

/*COMPONENTES*/
const HeaderComponent = httpVueLoader('/public/new/Components/navbar.vue');
const FooterComponent = httpVueLoader('/public/new/Components/Footer.vue');

const routes = [
    {path: '/', component: HomePage, name: "Inicio"},
    {path: '/como-comprar', component: ComoComprarPage, name: "Comprar"},
    {path: '/como-usar', component: ComoUsarPage, name: "Usar"},
    {path: '/preguntas-frecuentes', component: PreguntasFrecuentesPage, name: "Preguntas"},
    {path: '/contacto', component: ContactoPage, name: "Contacto"},
];

const router = new VueRouter({
    routes
});

const priceByCard = {
    "1000": [
        {
            "destino": "BUENOS AIRES",
            "min_movil": "3 MIN",
            "min_fijo": "80 MIN",
            "icon": "https://www.countryflags.io/ar/flat/64.png"
        },
        {
            "destino": "RESTO DEL PAIS",
            "min_movil": "3 MIN",
            "min_fijo": "49 MIN",
            "icon": "https://www.countryflags.io/ar/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "38 MIN",
            "min_fijo": "95 MIN",
            "icon": "https://www.countryflags.io/br/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "51 MIN",
            "min_fijo": "22 MIN",
            "icon": "https://www.countryflags.io/co/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "49 MIN",
            "min_fijo": "207 MIN",
            "icon": "https://www.countryflags.io/es/flat/64.png"
        },
        {
            "destino": "LIMA",
            "min_movil": "49 MIN",
            "min_fijo": "194 MIN",
            "icon": "https://www.countryflags.io/pe/flat/64.png"
        },
        {
            "destino": "RESTO DEL PAIS",
            "min_movil": "49 MIN",
            "min_fijo": "177 MIN",
            "icon": "https://www.countryflags.io/pe/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "166 MIN",
            "min_fijo": "166 MIN",
            "icon": "https://www.countryflags.io/us/flat/64.png"
        },
        {
            "destino": "VENEZUELA",
            "min_movil": "5 MIN - MOVISTAR",
            "min_fijo": "34 MIN",
            "icon": "https://www.countryflags.io/ve/flat/64.png"
        },
        {
            "destino": "VENEZUELA",
            "min_movil": "10 MIN - MOVILNET",
            "min_fijo": "34 MIN",
            "icon": "https://www.countryflags.io/ve/flat/64.png"
        },
        {
            "destino": "VENEZUELA",
            "min_movil": "5 MIN - DIGITEL",
            "min_fijo": "34 MIN",
            "icon": "https://www.countryflags.io/ve/flat/64.png"
        }

    ],
    "2000": [
        {
            "destino": "BUENOS AIRES",
            "min_movil": "7 MIN",
            "min_fijo": "164 MIN",
            "icon": "https://www.countryflags.io/ar/flat/64.png"
        },
        {
            "destino": "RESTO DEL PAIS",
            "min_movil": "7 MIN",
            "min_fijo": "98 MIN",
            "icon": "https://www.countryflags.io/ar/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "80 MIN",
            "min_fijo": "200 MIN",
            "icon": "https://www.countryflags.io/br/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "113 MIN",
            "min_fijo": "48 MIN",
            "icon": "https://www.countryflags.io/co/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "109 MIN",
            "min_fijo": "456 MIN",
            "icon": "https://www.countryflags.io/es/flat/64.png"
        },
        {
            "destino": "LIMA",
            "min_movil": "108 MIN",
            "min_fijo": "408 MIN",
            "icon": "https://www.countryflags.io/pe/flat/64.png"
        },
        {
            "destino": "RESTO DEL PAIS",
            "min_movil": "108 MIN",
            "min_fijo": "236 MIN",
            "icon": "https://www.countryflags.io/pe/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "312 MIN",
            "min_fijo": "312 MIN",
            "icon": "https://www.countryflags.io/us/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "13 MIN - MOVISTAR",
            "min_fijo": "78 MIN",
            "icon": "https://www.countryflags.io/ve/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "23 MIN - MOVILNET",
            "min_fijo": "78 MIN",
            "icon": "https://www.countryflags.io/ve/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "13 MIN - DIGITEL",
            "min_fijo": "78 MIN",
            "icon": "https://www.countryflags.io/ve/flat/64.png"
        }
    ],
    "5000": [
        {
            "destino": "BUENOS AIRES",
            "min_movil": "22 MIN",
            "min_fijo": "348 MIN",
            "icon": "https://www.countryflags.io/ar/flat/64.png"
        },
        {
            "destino": "RESTO DEL PAIS",
            "min_movil": "22 MIN",
            "min_fijo": "233 MIN",
            "icon": "https://www.countryflags.io/ar/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "200 MIN",
            "min_fijo": "478 MIN",
            "icon": "https://www.countryflags.io/br/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "258 MIN",
            "min_fijo": "113 MIN",
            "icon": "https://www.countryflags.io/co/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "280 MIN",
            "min_fijo": "1164 MIN",
            "icon": "https://www.countryflags.io/es/flat/64.png"
        },
        {
            "destino": "LIMA",
            "min_movil": "288 MIN",
            "min_fijo": "898 MIN",
            "icon": "https://www.countryflags.io/pe/flat/64.png"
        },
        {
            "destino": "RESTO DEL PAIS",
            "min_movil": "288 MIN",
            "min_fijo": "558 MIN",
            "icon": "https://www.countryflags.io/pe/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "798 MIN",
            "min_fijo": "798 MIN",
            "icon": "https://www.countryflags.io/us/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "32 MIN - MOVISTAR",
            "min_fijo": "190 MIN",
            "icon": "https://www.countryflags.io/ve/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "50 MIN - MOVILNET",
            "min_fijo": "190 MIN",
            "icon": "https://www.countryflags.io/ve/flat/64.png"
        },
        {
            "destino": "",
            "min_movil": "32 MIN - DIGITEL",
            "min_fijo": "190 MIN",
            "icon": "https://www.countryflags.io/ve/flat/64.png"
        }
    ]
};

const LandingHome = new Vue({
    el: "#LandingApp",
    router: router,
    components: {
        "header-component": HeaderComponent,
        "footer-component": FooterComponent,
    },
    data(){
        return {
          minutes: priceByCard,
        };
    }
});