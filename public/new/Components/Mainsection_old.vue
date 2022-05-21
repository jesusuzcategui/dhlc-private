<template>
    <div>
        <div class="main-section-hero-slick">
            <div v-for="(img, i) in images" :key="i">
                <img style="maz-height: 280px; object-fit: cover; width: 100%" :src="img" />
            </div>
        </div>
    </div>
</template>
<script>
    module.exports = {
        components: {
        },
        data(){
            return {
                images: [
                    "/public/images/banners/BANNER-TJ-NOVIEMBRE.jpg",
                    //"/public/images/banners/banner-promo-otc-3.jpg",
                    "/public/images/banners/banner-oct2021.jpg"
                ]
            };
        },
        mounted(){
            $('.main-section-hero-slick').slick({
                autoplay: true,
                fade: true,
            });
        }
    };
</script>