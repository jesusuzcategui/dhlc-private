<template>
    <div>
        <div>
            <mainsection-component />
        </div>
        <div>
            <products />
        </div>
    </div>
</template>
<script>
    const MainsectionComponent = httpVueLoader('/public/new/Components/Mainsection.vue');
    const ProductsComponent    = httpVueLoader('/public/new/Components/Products.vue');

    module.exports = {
        components: {
            "mainsection-component": MainsectionComponent,
            "products": ProductsComponent,
        },
        data(){
            return {};
        },
        mounted(){

        }
    };
</script>