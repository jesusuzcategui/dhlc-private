<?php include 'modules/navbar-top.php'; ?>

<div id="cupones">
    <div class="uk-container">
        <h1>Cupones</h1>
        <ul id="switcher-nav" class="uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
            <li><a href="#" @click.prevent="changeTab('list')">Lista</a></li>
            <li><a href="#" @click="changeTab('registro')">Registro</a></li>
            <li><a href="#" @click="changeTab('exp')">Exportar</a></li>
            <li><a v-bind:class="{'uk-disabled': isEdit == false}" href="#">Edicion</a></li>
        </ul>

        <ul class="uk-switcher uk-margin">
            <li>
                <table id="partnerTable" class="uk-table">
                    <thead>
                        <th>Cupon</th>
                        <th>Porcentaje</th>
                        <th>Comentario</th>
                        <th>Creaction</th>
                        <th>Actualizacion</th>
                        <th>Borrar</th>
                        <th>Editar</th>
                    </thead>
                    <tbody v-if="list.length > 0">
                        <tr v-for="(item, i) of list" :key="i">
                            <td>{{ item.cupon }}</td>
                            <td>{{ item.porcentaje }}</td>
                            <td>{{ item.comment }}</td>
                            <td>{{ item.creacion }}</td>
                            <td>{{ item.actualizacion }}</td>
                            <td>
                                <button type="button" class="uk-button uk-button-danger" uk-icon="icon: trash" @click="deletePartner(item.id)"></button>
                            </td>
                            <td>
                                <button type="button" class="uk-button uk-button-secondary" uk-icon="icon: pencil" @click="editPartner(item.id)"></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </li>
            <li>
                <form @submit.prevent="registerSubmit">
                    <fieldset class="uk-fieldset">

                        <legend class="uk-legend">Registro</legend>

                        <div class="uk-margin">
                            <label for="" class="uk-form-label">
                                Cupon
                            </label>
                            <input 
                                class="uk-input" 
                                type="text" 
                                v-model="reg.cupon" 
                                maxlength="15"
                                @input="reg.cupon = $event.target.value.toUpperCase()"
                                require>
                        </div>
                        
                        <div class="uk-margin">
                            <label for="" class="uk-form-label">
                                Porcentaje
                            </label>
                            <input class="uk-input" type="number" v-model="reg.porcentage" step="1" min="1" max="100" require>
                        </div>

                        <div class="uk-margin">
                            <label for="" class="uk-form-label">
                                Comentario
                            </label>
                            <textarea class="uk-textarea" rows="5"  v-model="reg.comentario" require></textarea>
                        </div>

                        <div class="uk-margin">
                            <button type="submit" class="uk-button uk-button-primary">Guardar</button>
                        </div>

                    </fieldset>
                </form>
            </li>
            <li></li>
            <li>
                <form v-if="isEdit" @submit.prevent="updateSubmit">
                    <fieldset class="uk-fieldset">

                        <legend class="uk-legend">Edicion</legend>

                        <div class="uk-margin">
                            <label for="" class="uk-form-label">
                                Cupon
                            </label>
                            <input 
                                class="uk-input" 
                                type="text" 
                                v-model="edit.cupon" 
                                maxlength="15"
                                @input="edit.cupon = $event.target.value.toUpperCase()"
                                require>
                        </div>

                        <div class="uk-margin">
                            <label for="" class="uk-form-label">
                                Porcentaje
                            </label>
                            <input class="uk-input" type="number" v-model="edit.porcentage" step="1" min="1" max="100" require>
                        </div>

                        <div class="uk-margin">
                            <label for="" class="uk-form-label">
                                Comentario
                            </label>
                            <textarea class="uk-textarea" rows="5"  v-model="edit.comentario" require></textarea>
                        </div>
                        
                        <div class="uk-margin">
                            <label for="" class="uk-form-label">
                                Estatus
                            </label>
                            <select class="uk-select" v-model="edit.status">
                                <option value="0">Inactivo</option>
                                <option value="1">Activo</option>
                            </select>
                        </div>

                        <div class="uk-margin">
                            <button type="submit" class="uk-button uk-button-primary">Actualizar</button>
                        </div>

                    </fieldset>
                </form>
            </li>
        </ul>
    </div>
</div>