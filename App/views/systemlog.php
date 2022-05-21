<?php include 'modules/navbar-top.php'; ?>

<div class="uk-container">
    <h3 class="uk-text-center uk-margin-remove-top">Log de webpay.</h3>
    <p class="uk-text-center">Aquí podrá observar un LOG o seguimiento de las compras para tener mejor soporte en hora de reclamos a Webpay</p>
    <div class="uk-grid uk-margin">
        <div class="uk-width-4-5@m uk-margin-auto">
            <div class="uk-card uk-card-body uk-card-default uk-padding-small">
                <textarea class="uk-width-1-1" style="min-height: 500px; max-height: 500px" readonly>
                  <?php echo $contenido; ?>
                </textarea>
            </div>
        </div>
    </div>
</div>

<?php //include 'modules/footer-main.php'; ?>
