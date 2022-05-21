<?php
USE Core\Config,
    App\helpers\Functions;
?>

<footer class="uk-dark uk-padding uk-panel">

    <div class="uk-grid">
      <div class="uk-width-2-5@m uk-flex uk-flex-left@m uk-flex-center@s uk-margin">
        <a class="uk-logo" href="<?php echo Functions::permalink(); ?>">
            <img style="width: 150px;" src="<?php echo Functions::permalink(); ?>/images/logoweb.png"  class="logo_img d-inline-block align-middle" alt="">
        </a>
      </div>
      <div class="uk-width-3-5@m uk-flex uk-flex-right@m uk-flex-center@s uk-margin">
        <img style="width: 250px" src="<?php echo Functions::permalink(); ?>images/metodopagoa1.png">
      </div>
    </div>

    <div class="uk-text-center uk-margin">
      Tarjetas Locutorios - Un servicio de <a target="_blank" href="https://locutorios.cl/">Locutorios.cl</a>
    </div>

</footer>
