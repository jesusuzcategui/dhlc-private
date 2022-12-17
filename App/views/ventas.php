<?php include 'modules/navbar-top.php'; ?>

<div class="container-fluid uk-padding-small">
  <div class="uk-grid uk-margin-remove px-3 uk-padding-remove">
    <div class="uk-width-1-1 theme-blue mt-2">
      <div class="uk-grid uk-padding-small">
        <div class="uk-width-3-5@m  uk-flex uk-flex-left@m uk-flex-center@s uk-margin-auto-@s">
          <h2 class="text-black uk-text-left ">Gestion de Ventas</h2>
          
        </div>
        <div class="uk-width-2-5@m  uk-flex uk-flex-left@m uk-flex-center@s uk-margin-auto-@s">
        	<a href="./ventas/manual" target="_blank" class="uk-button uk-button-primary uk-button-large">AGREGAR VENTA MANUAL</a>
        </div>
        </div>
      </div>
    </div>

    <div class="uk-card uk-card-secondary rowTheme uk-card-body uk-light uk-card-small uk-margin">
      <div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-5@s uk-text-left" uk-grid>
        <div>
          <label class="uk-form-label">Estado</label>
          <div class="uk-form-controls">
            <select name="filterByEstado" id="filterByEstado" class="uk-select">
              <option value="">SELECCIONE ESTATUS</option>
              <option value="1">DISPONIBLES</option>
              <option value="2">PROCESO</option>
              <option value="3">PAGADAS</option>
              <option value="4">BLOQUEDAS</option>
              <option value="5">ELIMINADAS</option>
            </select>
          </div>
        </div>
        <div>
          <label class="uk-form-label">Precio</label>
          <div class="uk-form-controls">
            <select name="filterByPrecio" id="filterByPrecio" class="uk-select">
              <option value="">SELECCIONE PRECIO</option>
              <option value="1">CLP 1.000</option>
              <option value="2">CLP 2.000</option>
              <option value="3">CLP 5.000</option>
              <option value="6">CLP 10.000</option>
              <option value="7">GRATIS</option>
            </select>
          </div>
        </div>
        <div>
          <label class="uk-form-label">Fecha inicial</label>
          <div class="uk-form-controls">
            <input type="datetime" name="filterByIni" id="filterByIni" class="uk-input" data-toggle="datepicker">
          </div>
        </div>
        <div>
          <label class="uk-form-label">Fecha final</label>
          <div class="uk-form-controls">
            <input type="datetime" name="filterByIni" id="filterByFin" class="uk-input" data-toggle="datepicker">
          </div>
        </div>
        <div class="uk-flex uk-flex-column uk-flex-bottom">
          <label class="uk-form-label">EXPORTAR EXCEL</label>
          <button type="button" id="exportBTN" class="uk-button uk-button-primary uk-width-1-1">
            EXPORTAR
          </button>
        </div>
    </div>
  </div>

  <div class="uk-overflow-auto@s">
    <table id="ventas-table" class="uk-table uk-table-small  text-center" style="width: 100%;">
      <thead>
        <tr>
          <th>ID</th>
          <th>CLIENTE</th>
          <th>TELF</th>
          <th>PIN</th>
          <th>PRECIO</th>
          <th>№ ORDEN</th>
          <th>ESTADO</th>
          <th>INICIO</th>
          <th>FIN</th>
          <th>CUPON</th>
          <th>PRECIO VENTA</th>
          <th>% CUPON</th>
          <th>ASOCIADO</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
    </table>
  </div>

</div>

<!--TOTALS-->
<div id="cantidadesVentas" class="uk-container">
	<div class="uk-align-center uk-h1 uk-text-center">TOTAL</div>
	<div class="uk-align-center uk-h5 uk-text-center">AUN ESTÁ EN DESARROLLO. SÓLO TENGO LA DIAGRAMACIÓN ARMADA.</div>
	<div class="" uk-grid>
		<div class="uk-width-2-5@l">
			<div class="uk-card uk-card-body uk-card-default">
				<h3 class="uk-card-title">TOTAL VENTAS</h3>
				<h1 class="venta_cants cant_ventas">1500</h1>
			</div>
		</div>
		<div class="uk-width-3-5@l">
			<div class="uk-card uk-card-body uk-card-primary">
				<h3 class="uk-card-title">TOTAL PESOS CHILENOS</h3>
				<h1 class="venta_cants cant_dinero">500.000</h1>
			</div>
		</div>
	</div>
	<div class="" uk-grid>
		<div class="uk-width-1-4@l">
			<div class="uk-card uk-card-body uk-card-default">
				<h3 class="uk-card-title">PINES DE 1000 CPL</h3>
				<h1 class="venta_cants cant_1000">400</h1>
			</div>
		</div>
		<div class="uk-width-1-4@l">
			<div class="uk-card uk-card-body uk-card-default">
				<h3 class="uk-card-title">PINES DE 2000 CPL</h3>
				<h1 class="venta_cants cant_2000">200</h1>
			</div>
		</div>
		<div class="uk-width-1-4@l">
			<div class="uk-card uk-card-body uk-card-default">
				<h3 class="uk-card-title">PINES DE 5000 CPL</h3>
				<h1 class="venta_cants cant_5000">100</h1>
			</div>
		</div>
		<div class="uk-width-1-4@l">
			<div class="uk-card uk-card-body uk-card-default">
				<h3 class="uk-card-title">PINES DE 10000 CPL</h3>
				<h1 class="venta_cants cant_10000">100</h1>
			</div>
		</div>
	</div>
</div>
<!--ENDTOTALS-->

<!-- modals -->

<!--<div id="modal-sales-details" class="uk-flex-top" style="z-index: 1030 !important" uk-modal>
    <div class="uk-modal-dialog uk-width-1-1 uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>

        <table class="uk-table uk-table-small uk-width-1-1">
          <tbody>
            <tr>
              <td colspan="6">
                <div class="uk-alert-primary" uk-alert>
                    <h3>COMPRA <span class="uk-text-uppercase sale_estado"></span></h3>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="1"><strong>N° de compra:</strong></td>
              <td colspan="1"><span class="sale_order"></span></td>
              <td colspan="1"><strong>Fecha:</strong></td>
              <td colspan="1"><span class="sale_date"></span></td>
              <td colspan="1"><strong>F. final:</strong></td>
              <td colspan="1"><span class="sale_datelast"></span></td>
            </tr>
            <tr>
              <td colspan="1"><strong>Cliente:</strong></td>
              <td colspan="2"><span class="sale_email"></span></td>
              <td colspan="1"><strong>Telf.:</strong></td>
              <td colspan="2"><span class="sale_telf"></span></td>
            </tr>
            <tr>
              <td colspan="1"><strong>Pin:</strong></td>
              <td colspan="1"><span class="sale_pin"></span></td>
              <td colspan="1"><strong>Pin ID:</strong></td>
              <td colspan="1"><span class="sale_pinid"></span></td>
              <td colspan="1"><strong>Precio:</strong></td>
              <td colspan="1"><span class="sale_precio"></span></td>
            </tr>
            <tr>
              <td colspan="1"><strong>Tipo de venta:</strong></td>
              <td colspan="2"><span class="sale_type"></span></td>
              <td colspan="1"><strong>Mensaje webpay:</strong></td>
              <td colspan="2"><span class="sale_wmsg"></span></td>
            </tr>
          </tbody>
        </table>

    </div>
</div>-->


<div id="venta-modal" class="uk-modal-full" style="z-index: 1030 !important" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-background-default" uk-height-viewport="offset-top: true">

        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>

        <form class="uk-width-1-2@m uk-margin-auto" id="venta-form" onsubmit="javascript:actualizarventa(event);">
          <h2 class="uk-modal-title">Editar venta.</h2>
          <p class="uk-text-lead uk-text-small">Esta opción del sistema solo es para casos de emergencia en el que el tarjetabiente haga un regalo de cobro y la venta no se haya realizado correctamente.</p>
          <div class="uk-margin">
              <label class="uk-form-label">Estado de la venta.</label>
              <div class="uk-form-controls">
                <select name="estado-select" id="estado-select" class="uk-select"></select>
              </div>
          </div>

          <div class="uk-margin">
              <label class="uk-form-label">Fecha finalización.</label>
              <div class="uk-form-controls">
                <input type="datetime" name="fecha_final" id="fecha_final" class="uk-input">
              </div>
          </div>

          <input type="hidden" name="itemId" id="itemId" value="">

          <div class="uk-margin uk-flex uk-flex-right">
            <button id='save' class="uk-button uk-button-primary submit-button"  type="submit">ACTUALIZAR</button>
          </div>
        </form>

    </div>
</div>

<div id="modal-sales-details" uk-offcanvas="flip: true; overlay: true">
    <div class="uk-offcanvas-bar">

        <button class="uk-offcanvas-close" type="button" uk-close></button>

        <h3>Detalle de compra</h3>

        <table class="uk-table uk-table-small uk-width-1-1">
          <tbody>
            <tr>
              <td colspan="6">
                <div class="uk-alert-primary" uk-alert>
                    <h3>COMPRA <span class="uk-text-uppercase sale_estado"></span></h3>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="1"><strong>N° de compra:</strong></td>
              <td colspan="1"><span class="sale_order"></span></td>
              <td colspan="1"><strong>Fecha:</strong></td>
              <td colspan="1"><span class="sale_date"></span></td>
              <td colspan="1"><strong>F. final:</strong></td>
              <td colspan="1"><span class="sale_datelast"></span></td>
            </tr>
            <tr>
              <td colspan="1"><strong>Cliente:</strong></td>
              <td colspan="2"><span class="sale_email"></span></td>
              <td colspan="1"><strong>Telf.:</strong></td>
              <td colspan="2"><span class="sale_telf"></span></td>
            </tr>
            <tr>
              <td colspan="1"><strong>Pin:</strong></td>
              <td colspan="1"><span class="sale_pin"></span></td>
              <td colspan="1"><strong>Pin ID:</strong></td>
              <td colspan="1"><span class="sale_pinid"></span></td>
              <td colspan="1"><strong>Precio:</strong></td>
              <td colspan="1"><span class="sale_precio"></span></td>
            </tr>
            <tr>
              <td colspan="1"><strong>Tipo de venta:</strong></td>
              <td colspan="2"><span class="sale_type"></span></td>
              <td colspan="1"><strong>Mensaje webpay:</strong></td>
              <td colspan="2"><span class="sale_wmsg"></span></td>
            </tr>
          </tbody>
        </table>
    </div>
</div>

<!--MODAL DE FILTRO-->

<div id="filtro-modal" class="uk-modal-full" style="z-index: 1030 !important" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-background-default" uk-height-viewport="offset-top: true">

        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>

        <div class="inframeContent"></div>


    </div>
</div>



<?php include 'modules/footer-main.php'; ?>
