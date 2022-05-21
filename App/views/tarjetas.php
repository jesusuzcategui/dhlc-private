<?php include 'modules/navbar-top.php'; ?>

<div class="container-fluid">
  <div class="uk-grid uk-margin-remove px-3">
    <div class="uk-width-1-1 theme-blue mt-2">
      <div class="uk-grid uk-padding-small">
        <div class="uk-width-3-5@m uk-flex uk-flex-left@m uk-flex-center@s uk-margin-auto-@s">
          <h2 class="text-black uk-text-left ">Gestion de Tarjetas</h2>
        </div>
        <div class="uk-width-2-5@m uk-flex uk-flex-right@m uk-flex-center@s uk-margin-auto-@s">
         <div class="uk-button-group">
            <button class="uk-button uk-button-primary"  id="regidoc" title="Agregar tarjeta" onclick="javascript:modaladdOpen();"><span uk-icon="plus"></span></button>
            <button class="uk-button uk-button-secondary"  id="regidoc" title="Importar archivo excel" onclick="javascript:window.location.href='tarjetas/importar'"><span uk-icon="upload"></span></button>
         </div>
        </div>
      </div>
    </div>

    <div class="uk-width-1-1 uk-padding" >
      <div class="uk-overflow-auto">
        <table style="width: 100%;" id="tarjetas-table" class="uk-table uk-table-striped uk-table-small  text-center">
          <thead>
            <!--toolbar view desktop-->
            <tr class="rowTheme">
              <th class="uk-width-1-4@m" colspan="7">
                <div class="uk-grid">
                  <div class="uk-width-1-4@m"> Filtrar por</div>
                  <div class="uk-width-1-4@m">
                    Precio:
                    <select class="uk-select" name="filterByPrice" id="filterByPrice">
                      <option value="">SELECCIONE PRECIO</option>
                      <option value="1">CLP 1.000</option>
                      <option value="2">CLP 2.000</option>
                      <option value="3">CLP 5.000</option>
                      <option value="6">CLP 10.000</option>
                      <option value="7">REGALO</option>
                    </select>
                  </div>
                  <div class="uk-width-1-4@m">
                    Estatus:
                    <select class="uk-select" name="filterByStatus" id="filterByStatus">
                      <option value="">SELECCIONE ESTATUS</option>
                      <option value="1">DISPONIBLES</option>
                      <option value="2">PROCESO</option>
                      <option value="3">PAGADAS</option>
                      <option value="4">BLOQUEDAS</option>
                      <option value="5">ELIMINADAS</option>
                    </select>
                  </div>
                  <div class="uk-width-1-4@m">
                    <button onclick="javascript:deleteMasive();" class="uk-button uk-button-danger" type="button">ELIMINAR</button>
                    <button onclick="javascript:setStateMasive();" class="uk-button uk-button-secondary" type="button">CAMBIAR ESTADO</button>
                  </div>
                </div>
              </th>
            </tr>
            <!--end toolbar-->
            <tr>
              <th>PIN</th>
              <th>CODIGO</th>
              <th>PRECIO</th>
              <th>ESTADO</th>
              <th>CREACION</th>
              <th>Accion</th>
              <th><input class="uk-checkbox" type="checkbox" id="checkAll" name="checkAll"></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

  </div>
</div>

<h3 class="uk-card-title uk-text-center uk-text-primary">Analíticas para tarjetas</h3>
<div id="grappie" class="chart-pie" style="position: relative; width: 350px; margin: auto;">
	<canvas id="graficaTarjetas" style=""></canvas>
</div>


<div id="addtar-modal" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">Agregar Tarjeta</h2>
        <form id="tar-form" class="uk-grid-small" uk-grid >

            <div class="uk-width-1-1@m uk-width-1-1@s">
              <label class="uk-form-label">Codigo</label>
              <div class="uk-form-controls">
                <input class="uk-input" type="text" id="codigo">
              </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-1@s">
              <label class="uk-form-label">Pin</label>
              <div class="uk-form-controls">
                <input class="uk-input" type="text" id="ping">
              </div>
            </div>

            <div class="uk-width-1-1@m uk-width-1-1@s">
                <label class="uk-form-label">Precio</label>
                <div class="uk-form-controls">
                <select id="precio-select" class="uk-select" type="text"></select>
                </div>
            </div>

            <div class="uk-width-1-1@m uk-width-1-1@s">
                <label class="uk-form-label">Estado</label>
                <div class="uk-form-controls">
                <select id="estado-select" class="uk-select" type="text"></select>
                </div>
            </div>
            <span id="val_id"></span>

            <div class="uk-width-1-1">
                <div class="uk-width-1-1 uk-flex uk-flex-right">
                  <button id='save' class="uk-button uk-button-primary submit-button" id="guard"  type="submit" onclick="javascript:guardartar(event)">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php //include 'modules/footer-main.php'; ?>
