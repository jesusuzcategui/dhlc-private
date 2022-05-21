<?php include 'modules/navbar-top.php'; ?>
<div id="clientnorsales">
    <div class="uk-container">
        <h1>Buscar clientes no compradores</h1>
        <form @submit.prevent="searchData" class="uk-form">
            <div class="uk-child-width-1-2" uk-grid>
                <div>
                    <label>Desde</label>
                    <input type="date" v-model="init" />
                </div>
                <div>
                    <label>Hasta</label>
                    <input type="date" v-model="ended" />
                </div>
            </div>
            <div class="uk-margin">
                <button type="submit" class="uk-width-1-1 uk-button uk-button-primary">
                    Buscar
                </button>
            </div>
        </form>
        
        <hr>
        
        <div v-if="mostrar === true" class="uk-card uk-card-body uk-card-default">
            <button @click="exportExcelCL" class="uk-buton uk-button-danger">EXPORTAR EXCEL</button>
            <table class="uk-table uk-table-divider">
                <thead>
                    <tr>
                        <th>Correo electrónico</th>
                        <th>Telefono</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) of list" :key="i">
                        <td>{{item.correo}}</td>
                        <td>{{item.telefono}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div  v-if="mostrar === false" class="uk-card uk-card-body uk-card-default" v-if="!mostrar">
            <h3>No hay nada que mostrar</h3>
        </div>
    </div>
</div>