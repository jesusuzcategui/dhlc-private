<?php include 'modules/navbar-top.php'; ?>

<div id="partner">
    <div class="uk-container">
        <h1>Asociados</h1>
        <ul id="switcher-nav" class="uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
            <li><a href="#" @click.prevent="changeTab('list')">Lista</a></li>
            <li><a href="#" @click="changeTab('registro')">Registro</a></li>
            <li><a href="#" @click="changeTab('exp')">Exportar</a></li>
            <li><a v-bind:class="{'uk-disabled': isEdit == false}" href="#">Edicion</a></li>
            <li><a v-bind:class="{'uk-disabled': isSales == false}" href="#">Ventas</a></li>
        </ul>

        <ul class="uk-switcher uk-margin">
            <li>
                <table id="partnerTable" class="uk-table">
                    <thead>
                        <th>Nombre</th>
                        <th>Serial</th>
                        <th>Comentario</th>
                        <th>Link</th>
                        <th>Bit.ly</th>
                        <th>Creaction</th>
                        <th>Actualizacion</th>
                        <th>Borrar</th>
                        <th>Editar</th>
                        <th>Ventas</th>
                    </thead>
                    <tbody v-if="list.length > 0">
                        <tr v-for="(item, i) of list" :key="i">
                            <td>{{ item.nombre }}</td>
                            <td>{{ item.serial }}</td>
                            <td>{{ item.comentario }}</td>
                            <td>{{ 'https://tarjetalocutorios.com?partner=' + item.serial }}</td>
                            <td>{{ (item.bitly != 'null' || item.bitly != null) ? item.bitly : 'N/A' }}</td>
                            <td>{{ item.creacion }}</td>
                            <td>{{ item.actualizacion }}</td>
                            <td>
                                <button type="button" class="uk-button uk-button-danger" @click="deletePartner(item.id)">
                                    ELIMINAR
                                </button>
                            </td>
                            <td>
                                <button type="button" class="uk-button uk-button-secondary" @click="editPartner(item.id)">
                                    EDITAR
                                </button>
                            </td>
                            <td>
                                <button type="button" class="uk-button uk-button-primary" @click="openSales(item.id)">
                                    VER
                                </button>
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
                                Nombre
                            </label>
                            <input class="uk-input" type="text" v-model="reg.nombre" require>
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
                                Nombre
                            </label>
                            <input class="uk-input" type="text" v-model="edit.nombre" require>
                        </div>
                        
                        <div class="uk-margin">
                            <label for="" class="uk-form-label">
                                Bitly
                            </label>
                            <input class="uk-input" type="text" v-model="edit.bitly" disabled>
                            <button v-if="edit.bitly == null" type="button" class="uk-button uk-button-secondary" @click="generateBitly()">Generar</button>
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
            <li>
                <table class="uk-table uk-table-small">
                    <thead>
                        <tr>
                            <th>CLIENTE</th>
                            <th>FECHA</th>
                            <th>PRECIO</th>
                            <th>PRECIO VENTA</th>
                            <th>CUPON</th>
                            <th>CUPON %</th>
                        </tr>
                    </thead>
                    <tbody v-if="sales.length > 0">
                        <tr v-for="(item, i) of sales" :key="i">
                            <td>{{ item.correo }}</th>
                            <td>{{ item.inicio }}</th>
                            <td>{{ item.precio }}</th>
                            <td>{{ item.monto_venta }}</th>
                            <td>{{ item.cupon }}</th>
                            <td>{{ item.cupon_porcentaje }}</th>
                        </tr>
                    </tbody>
                    <tbody v-if="sales.length == 0">
                        <tr>
                            <td colspan="6">
                                No hay ventas
                            </td>
                        </tr>
                    </tbody>
                </table>
            </li>
        </ul>
    </div>
</div>