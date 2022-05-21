<?php require_once "modules/headerfront.php"; ?>
<?php
USE Core\Config,
    App\helpers\Functions;
?>
<div class="uk-container">

<div class="uk-child-width-expand@s uk-text-center pt-4" uk-grid>
  <div class="uk-margin uk-margin-auto uk-margin-auto@m uk-width-1-2@l uk-card  uk-card-body uk-text-center" style="background:rgb(243, 237, 220);">

    <?php if($view == 0): ?>
      <div class="uk-padding">

        <h3 class="uk-text-center uk-text-info uk-margin-remove-bottom">COMPRA EXITOSA</h3>
        <h5 class="uk-text-center uk-margin-remove-top">Gracias por comprar tu tarjeta o pin locutorios, a continuación se mostrará los datos de la compra y de igual forma se te enviará un correo a <?php echo strtoupper($email); ?> con los detalles.</h5>
        <p class="uk-text-center">Si no sabes cómo usar tu tarjeta o pin, por favor da clic <a class="uk-button uk-button-primary" href="#modal-example" uk-toggle>aquí</a></p>
        <p class="uk-text-center">Para cualquier información puede contactarnos a través de Whatsapp al siguiente número.</p>
        <div class="uk-alert-primary" uk-alert>
          <h4>¡Importante!</h4>
          <p>Pin al portador, no reembolsable, expira 30 días luego de su primer uso, Locutorios SPA no se hace responsable por tarjetas pines mal usados, perdidos o robados.</p>
        </div>
        <a class="uk-text-center uk-button uk-button-primary" target="_blank" href="https://api.whatsapp.com/send?phone=56232108264"> <span uk-icon="whatsapp"></span> +56232108264</a>

        <table class="uk-table uk-table-striped">
           <thead>
             <tr>
               <th colspan="2"><h3 class="uk-text-center">DETALLE DE COMPRA</h3></th>
             </tr>
           </thead>
           <tbody>
               <tr>
                   <td><b>N° de compra</b></td>
                   <td><?php echo $compra; ?></td>
               </tr>
               <tr>
                   <td><b>Código de tarjeta o pin</b></td>
                   <td><?php echo $pin; ?></td>
               </tr>
               <tr>
                   <td><b>Monto</b></td>
                   <td><?php echo $monto; ?></td>
               </tr>

           </tbody>
        </table>

        <div class="uk-button-group">
          <a class="uk-text-center uk-button uk-button-primary" href="<?php echo Functions::permalink(); ?>">Volver al inicio.</a>
          <a class="uk-text-center uk-button uk-button-secondary" href="<?php echo Config::AppUrl['sitio']; ?>">Visitar nuestro sitio web.</a>
        </div>

      </div>
      
      <!-- Event snippet for Compra pin conversion page -->
        <script>
          gtag('event', 'conversion', {
              'send_to': 'AW-691360173/399PCJKs3d0BEK2j1ckC',
              'value': 1000.0,
              'currency': 'CLP',
              'transaction_id': ''
          });
        </script>
      
    <?php endif; ?>

    <?php if($view == 1): ?>
      <div class="uk-padding">
        <h3 class="uk-text-center uk-text-info uk-margin-remove-bottom">COMPRA RECHAZADA</h3>
        <h4 class="uk-text-center uk-text-info uk-margin-remove-top ">N° <?php echo $compra; ?></h4>
        <h5 class="uk-text-center">Si llegase a tener algún cobro en su tarjeta de débito o crédito, por favor no dude en contactarse al siguiente número.</h5>
        <a class="uk-text-center uk-button uk-button-primary" target="_blank" href="https://api.whatsapp.com/send?phone=56232108264"> <span uk-icon="whatsapp"></span> +56232108264</a>
        <p class="uk-text-center">Algunas de las razones por las cuales sucede esto son:.</p>
        <ul>
          <li class="uk-text-left">Error en el ingreso de los datos de su tarjeta de Crédito o Débito (fecha y/o código de seguridad)</li>
          <li class="uk-text-left">Su tarjeta de Crédito o Débito no cuenta con saldo suficiente.</li>
          <li class="uk-text-left">Tarjeta aún no habilitada en el sistema financiero.</li>
          <li class="uk-text-left">Compra cancelada / rechazada por usted</li>
        </ul>
        <h4>Regresa para ejecutar la compra nuevamente.</h4>
        <div class="uk-button-group">
          <a class="uk-text-center uk-button uk-button-primary" href="<?php echo Functions::permalink(); ?>">Volver al inicio.</a>
          <a class="uk-text-center uk-button uk-button-secondary" href="<?php echo Config::AppUrl['sitio']; ?>">Visitar nuestro sitio web.</a>
        </div>
      </div>
    <?php endif; ?>

    <?php if($view == 2): ?>
      <div class="uk-padding">
        <h3 class="uk-text-center uk-text-info">ERROR DE CONEXIÓN CON WEBPAY O ANULACIÓN DE LA COMPRA</h3>
        <h5 class="uk-text-center">Si llegase a tener algún cobro en su tarjeta de débito o crédito, por favor no dude en contactarse al siguiente número.</h5>
        <a class="uk-text-center uk-button uk-button-primary" target="_blank" href="https://api.whatsapp.com/send?phone=56232108264"> <span uk-icon="whatsapp"></span> +56232108264</a>

        <p class="uk-text-center">Algunas de las razones por las cuales sucede esto son:.</p>
        <ul>
          <li class="uk-text-left">Error en el ingreso de los datos de su tarjeta de Crédito o Débito (fecha y/o código de seguridad)</li>
          <li class="uk-text-left">Su tarjeta de Crédito o Débito no cuenta con saldo suficiente.</li>
          <li class="uk-text-left">Tarjeta aún no habilitada en el sistema financiero.</li>
          <li class="uk-text-left">Compra cancelada / rechazada por usted</li>
        </ul>

        <div class="uk-button-group">
          <a class="uk-text-center uk-button uk-button-primary" href="<?php echo Functions::permalink(); ?>">Volver al inicio.</a>
          <a class="uk-text-center uk-button uk-button-secondary" href="<?php echo Config::AppUrl['sitio']; ?>">Visitar nuestro sitio web.</a>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>


<?php include 'modules/footer-main.php'; ?>

<?php include 'modules/modales.php'; ?>

<!-- Global site tag (gtag) - Google Ads: 691360173 -->
<amp-analytics type="gtag" data-credentials="include">
			<script type="application/json">
				{
					"vars": {
						"gtag_id": "AW-691360173",
						"config": {
							"AW-691360173": {
								"groups": "default"
								}
							}
						},
					"triggers": {
						"C_fk0tSC5RW2Y": {
							"on": "visible",
							"vars": {
								"event_name": "conversion",
								"transaction_id": "<?php echo $compra; ?>",
								"send_to": ["AW-691360173/yI3_CNPE_LUBEK2j1ckC"]
							}
						}
					}
				}
			</script>
		</amp-analytics>
