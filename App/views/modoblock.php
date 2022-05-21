<?php require_once "modules/headerfront.php"; ?>
<?php
USE Core\Config,
    App\helpers\Functions;
?>

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

    <div class="uk-placeholder uk-width-1-2@m">

      <div class="uk-tile uk-muted">
          <p class="uk-h4 uk-text-center">¡Atención!</p>
      </div>
        
      <p class="uk-h4 uk-text-center">En estos momentos estamos actualizando nuestro stock de pines para llamadas. Volveremos en unos instantes.</p>
        
    </div>
</div>

<?php include 'modules/modales.php'; ?>

<?php include 'modules/footer-main.php'; ?>
