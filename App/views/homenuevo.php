<?php require_once "modules/headerfront.php"; ?>
<?php
USE Core\Config,
    App\helpers\Functions;
?>


<!--<div class="uk-background-cover uk-background-secondary uk-light uk-overflow-hidden uk-flex uk-flex-center uk-flex-middle" uk-height-viewport="">
  <div>
    <h1 class="uk-h3 uk-text-center">ESTAMOS ACTUALIZANDO</h1>
    <p class="uk-text-center">Para ofrecerte un mejor servicio, pero podemos atenderte vía WhatsApp, solo da clic <a href="https://wa.me/56232108264">AQUÍ</a></p>
    
  </div>
</div>-->

<div id="particle-teater" class="uk-background-cover uk-overflow-hidden uk-light uk-flex uk-flex-middle" uk-height-viewport="expand: true">
  <div class="content-heading uk-width-1-1">
    <div class="uk-grid">
      <div class="uk-width-2-5@m">
        <div class="tarjetaImg uk-padding-small uk-margin-auto">
          <img src="<?php echo Functions::permalink(); ?>/images/cardprepaidall.jpg" style="width:100%; object-fit: contain;">
        </div>
      </div>
      <div class="uk-width-3-5@m uk-margin-auto-vertical">
        <h1 class="uk-heading-medium uk-text-center">Compra de tarjeta o pin</h1>
        <h2 class="uk-heading-small uk-margin-remove-top  uk-text-center">Locutorios | Acortando distancias</h2>
        <div class="uk-flex uk-flex-center">
          <a href="#compra-ahora" class="uk-button uk-button-default uk-button-large">COMPRAR AHORA <span uk-icon="icon: chevron-down"></span></a>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="compra-ahora" class="home uk-padding-small uk-grid uk-flex-middle uk-flex-center" uk-scrollspy="cls: uk-animation-slide-left; repeat: false">

    <div class="uk-width-1-2@m">

      <div class="uk-tile uk-muted">
          <p class="uk-h4 uk-text-center">COMPRA DE TARJETA O PIN</p>
      </div>


      <form  id="recargaform" class=" uk-card uk-card-body uk-card-default uk-padding-small">
          <div class="uk-margin">
            <div style="display:none;" class="form uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>

            </div>
          </div>
          <div class="uk-margin">
              <label class="uk-form-label">CORREO ELECTRÓNICO *</label>
              <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: user"></span>
                  <input class="uk-input" type="email" name="correo" id="correo" placeholder="CORREO ELECTRÓNICO">
              </div>
          </div>

          <div class="uk-margin">
              <label class="uk-form-label">N° DE TELÉFONO *</label>
              <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: receiver"></span>
                  <input class="uk-input" type="text" name="telefono" id="telefono" placeholder="N° DE TELÉFONO">
              </div>
          </div>

          <div class="uk-margin">
             <label class="uk-form-label">MONTO DE PIN *</label>
              <div class="uk-inline uk-width-1-1">
                  <select id="precio-select" class="uk-select helpers-select" name="precioselect"></select>
              </div>
          </div>

          <input type="hidden" name="token_ws" value="" id="token_ws">

          <div class="uk-margin" style="justify-content: center !important;">
              <div class="uk-flex uk-flex-center">
                  <div class="uk-button-group">
                    <button  id="datasave" class="uk-button uk-button-primary submit-button" onclick="javascript:recargas(event)">VERIFICAR</button>
                    &nbsp;
                    <button id="pagesave" type="submit" class="uk-button uk-button-primary">PAGAR</button>
                  </div>
              </div>
          </div>

      </form>
    </div>
</div>

<?php include 'modules/modales.php'; ?>

<?php include 'modules/footer-main.php'; ?>
