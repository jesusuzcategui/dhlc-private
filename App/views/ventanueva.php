<?php require_once "modules/headerfront.php"; ?>
<?php
USE Core\Config,
    App\helpers\Functions;
?>

<div class="home uk-padding uk-grid uk-flex-center" style="">


    <div class="uk-width-1-2@m">
        <div class="lModule module-recarga">
            <h3 class="uk-flex uk-flex-center">COMPRA DE PINES</h3>

            <div class="tarjetaImg">
                <img src="<?php echo Functions::permalink(); ?>/images/cardprepaidall.jpg" style="width:100%; object-fit: contain;">
            </div>

            <form  id="recargaform">
                <div class="uk-margin">
                  <div style="display:none;" class="form uk-alert-danger" uk-alert>
                      <a class="uk-alert-close" uk-close></a>

                  </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label">CORREO ELECTRÓNICO *</label>
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: user"></span>
                        <input value="" class="uk-input" type="email" name="correo" id="correo" placeholder="CORREO ELECTRÓNICO">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label">N° DE TELÉFONO *</label>
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: receiver"></span>
                        <input value="" class="uk-input" type="text" name="telefono" id="telefono" placeholder="N° DE TELÉFONO">
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
                        <button  id="datasave" class="uk-button uk-button-primary submit-button" onclick="javascript:recargas(event)">VERIFICAR</button>
                        &nbsp;
                        <button id="pagesave" type="submit" class="uk-button uk-button-primary" >PAGAR</button>
                    </div>
                </div>

            </form>


        </div>
    </div>

    <!--<div class="uk-width-1-2@m uk-margin-large-top" >
        <div class="lModule module-login">

            <h3 class="uk-flex uk-flex-center">INICIAR SESIÓN</h3>
            <form method="post" name="loginform" id="loginform" onsubmit="javascript:login(event, this)">

                <div class="uk-margin">
                <label class="uk-form-label">CORREO ELECTRÓNICO</label>
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: user"></span>
                        <input class="uk-input" type="email" id="email" name="email" placeholder="CORREO ELECTRÓNICO">
                    </div>
                </div>

                <div class="uk-margin">
                   <label class="uk-form-label">CONTRASEÑA</label>
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: lock"></span>
                        <input class="uk-input" type="password" id="contra" name="contra" placeholder="CONTRASEÑA">
                    </div>
                </div>

                <div class="uk-margin uk-flex uk-flex-center">
                    <button type="submit" class="uk-button uk-button-primary">INGRESAR</button>
                </div>

            </form>

        </div>
    </div>-->

</div>

<?php include 'modules/modales.php'; ?>

<footer class="uk-padding-large">

    <div class="uk-text-center">Tarjetas Locutorios - Un servicio de <a target="_blank" href="https://locutorios.cl/">Locutorios SPA</a></div>

</footer>
