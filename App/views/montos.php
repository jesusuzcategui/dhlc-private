<?php include 'modules/navbar-top.php'; ?>

<div class="uk-margin uk-container uk-container-expand" id="montos">
    <div v-if="loading == false" class="uk-card uk-card-body uk-card-default">
        <div class="uk-grid uk-grid-match">
            <div class="uk-width-1-4@m uk-width-1-1@s uk-grid-item-match uk-margin-bottom" v-for="(item, i) of montos" :key="i">
                <div class="uk-card uk-card-secondary uk-card-body uk-width-1-1">
                    <div class="uk-card-badge uk-label">
                        {{ item.id }}
                    </div>
                    <h3 class="uk-card-title">
                        {{ item.monto }}
                    </h3>
                    <div class="uk-alert-success" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p style="color: #000 !important" class="uk-text-emphasis">
                            {{ item.estatus_id != "1" ? 'Monto inactivo' : 'Monto activo' }}
                        </p>
                    </div>
                    <div>
                        <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                            <li><a href="#">Imagen 1</a></li>
                            <li><a href="#">Imagen 2</a></li>
                        </ul>

                        <ul class="uk-switcher uk-margin">
                            <li>
                                
                                <img class="uk-margin preview_image" v-if="item.imagen1" :src="'/'+item.imagen1" />
                                <form @submit.prevent="uploadImage($event, item.id, 'imagen1')">
                                    <div class="uk-margin" uk-margin>
                                        <div uk-form-custom="target: true">
                                            <input @change="changeImage($event, item.id)" ref="banner1" type="file">
                                            <input  class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                                        </div>
                                        <button class="uk-button uk-button-default">Submit</button>
                                    </div>
                                </form>
                            </li>
                            <li>
                            <img class="uk-margin preview_image" v-if="item.imagen2" :src="'/'+item.imagen2" />
                                <form @submit.prevent="uploadImage($event, item.id, 'imagen2')">
                                    <div class="uk-margin" uk-margin>
                                        <div uk-form-custom="target: true">
                                            <input @change="changeImage($event, item.id)" ref="banner2" type="file">
                                            <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                                        </div>
                                        <button class="uk-button uk-button-default">Submit</button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .preview_image {
        width: 400px;
        height: 200px;
        object-fit: cover;
    }
</style>