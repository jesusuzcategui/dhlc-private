<?php include 'modules/navbar-top.php'; ?>
<div id="bannermanager">
    <div class="uk-container">
        <h1>Administrar banners</h1>
        <div class="uk-card uk-card-default uk-padding-large">
            <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                <li><a href="#">Listar</a></li>
                <li><a href="#">Cargar</a></li>
            </ul>
            <ul class="uk-switcher uk-margin">
                <li>
                    <div>
                        <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                            <div v-for="(item, i) of list" :key="i">
                                <div class="uk-card uk-card-default uk-margin">
                                    <div class="uk-card-media-top uk-cover-container">
                                        <img :src="item.image_url" alt="" uk-cover>
                                        <canvas width="600" height="200"></canvas>
                                    </div>
                                    <div>
                                        <div class="uk-card-body">
                                            <div class="uk-card-badge uk-label">
                                                <span v-if="!item.position">Posición no asignada</span>
                                                <span v-else>{{ item.position }}</span>
                                            </div>
                                            <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                                                <li><a href="#">Opciones</a></li>
                                                <li><a href="#">Movil</a></li>
                                            </ul>
                                            <ul class="uk-switcher uk-margin">
                                                <li>
                                                    <div class="uk-placeholder">
                                                        <button type="button" @click="openEdit(item.id)" class="uk-width-1-1 uk-button uk-button-primary">EDITAR PROPIEDADES</button>
                                                    </div>

                                                    <div class="uk-button-group uk-width-1-1">
                                                        <button @click="deleteBanner(item.id)" class="uk-width-1-1 uk-button uk-button-secondary">Eliminar</button>
                                                        <button @click="updateBanner(item.id, item.state)" class="uk-width-1-1 uk-button uk-button-danger">
                                                            {{(item.state == "1") ? 'Desactivar' : 'Activar'}}
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div v-if="!item.image_movil">
                                                        <div class="uk-alert-warning" uk-alert>
                                                            <p>No haz cargado la imagen para movil de este banner</p>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <img :src="item.image_movil" style="width: 100%; height: 100px; object-fit: cover;">
                                                    </div>
                                                    <div class="uk-margin">
                                                        <div uk-form-custom="target: true">
                                                            <input :data-id="item.id" ref="bannerMovil" @change="onChangeFileMovil($event, item.id)" type="file" />
                                                            <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled />
                                                        </div>
                                                        <button @click="submitBannerMovil" class="uk-button uk-button-default">Cargar</button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="uk-margin">
                        <div uk-form-custom="target: true">
                            <input ref="banner" @change="onChangeFile" type="file" />
                            <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled />
                        </div>
                        <button @click="submitBanner" class="uk-button uk-button-default">Cargar</button>
                    </div>
                    <div v-if="loading" class="uk-margin">
                        Cargando
                        <div uk-spinner></div>
                    </div>
                    <div v-if="!loading && image != null" class="uk-margin">
                        <img class="uk-width-1-1" :src="image" alt="Imagen subida" />
                    </div>
                </li>
            </ul>
        </div>
    </div>
    
    <div id="banner_edit" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

            <button class="uk-modal-close-default" type="button" uk-close></button>

            <h4 class="uk-text-center">Por favor cambia las propiedades del banner que consideres.</h4>

            <form @submit.prevent="updateEdit" v-if="currentEdit" class="uk-form">
                <div class="uk-margin">
                    <label class="uk-form-label" for="banner_link_edit">Url relacionada</label>
                    <div class="uk-form-controls">
                        <input v-model="currentEdit.link_related" class="uk-input" id="banner_link_edit" type="text" placeholder="" />
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="banner_position_edit">Posición</label>
                    <div class="uk-form-controls">
                        <input v-model="currentEdit.position" class="uk-input" id="banner_position_edit" type="number" placeholder="" />
                    </div>
                </div>

                <div class="uk-margin">
                    <button type="submit" class="uk-width-1-1 uk-button uk-button-secondary">GUARDAR</button>
                </div>
            </form>

        </div>
    </div>
</div>

