<?php

USE Core\Config;

global $vali;

?>
<nav class="uk-navbar-container" uk-navbar="mode: click">


<div class="uk-navbar-left">
    
</div>

<div class="uk-navbar-center">
    
    <a class="uk-navbar-item uk-logo" href="./">
        <img src="<?php echo Config::AppUrl['web']; ?>images/logoweb.svg"  class="logo_img d-inline-block align-top" alt="">
    </a>
    
</div>

<div class="uk-navbar-right">
  <div class="uk-visible@m">
    <ul class="uk-navbar-nav">
        <li><a href="#modal-tarifas" uk-toggle>Conoce las tarifas Aquí</a></li>
        <li><a href="#modal-example" uk-toggle>¿Cómo usar mi pin?</a></li>
        <li><a href="https://locutorios.cl" class="tree">Locutorios.cl</a></li>
    </ul>
  </div>
  <div class="uk-hidden@m">
    <ul class="uk-navbar-nav">
        <li>
            <a href="#"><span uk-icon="menu"></span> MENÚ</a>
            <div class="uk-navbar-dropdown">
                <ul class="uk-nav uk-navbar-dropdown-nav">
                    <li><a href="#modal-tarifas" uk-toggle>Conoce las tarifas Aquí</a></li>
                    <li><a href="#modal-example" uk-toggle>¿Cómo usar mi pin?</a></li>
                    <li><a href="https://locutorios.cl" class="tree">Locutorios.cl</a></li>
                </ul>
            </div>
        </li>
    </ul>
  </div>
</div>

</nav>


<div class="uk-container">

<div class="uk-child-width-expand@s uk-text-center pt-4" uk-grid>
    
    <div class="uk-margin uk-margin-auto uk-margin-auto@m uk-width-1-2@s uk-card  uk-card-body uk-text-center" style="background:rgb(243, 237, 220);">
     <h3><b>Resultado de compra</b></h3>  
    <?php if($isValid=="completado"){ ?>
   <table class="uk-table uk-table-striped">
        <tbody>
            <tr>
                <td><b>N° de compra</b></td>
                <td><?php echo $compra; ?></td>
            </tr>
            <tr>
                <td><b>N Tarjeta</b></td>
                <td><?php echo $tarjeta; ?></td>
            </tr>
            <tr>
                <td><b>Tipo de venta</b></td>
                <td><?php echo $tipo; ?></td>
            </tr>
            <tr>
                <td><b>Monto</b></td>
                <td><?php echo $monto; ?></td>
            </tr>
           
        </tbody>
   </table>
    <?php
     }
     
     if($isValid=="incompleto"){ 
         echo"<script>console.log($valid);</script>";
        echo "<h1>Compra rechazada:</h1> ";
        echo "<p>La ".$tipo." de La compra N° ".$compra."con el tipo de venta de:".$result.", los posibles motivos de este rechazo pueden ser: </p>";
        echo "<ul>";
        echo "<li>Error en el ingreso de los datos de su tarjeta de Crédito o Débito (fecha y/o código de seguridad)</li>";
        echo "<li>Su tarjeta de Crédito o Débito no cuenta con saldo suficiente.</li>";
        echo "<li>Tarjeta aún no habilitada en el sistema financiero.</li>";
        echo "<li>Compra cancelada / rechazada por usted</li>";
        echo "</ul>";
        echo "<h4>regresa para executar compra nuevamente</h4>";
        echo "<br>";
     }

     if($isValid=="Error service"){
        echo "<h1>Compra rechazada:</h1> "; 
        echo "<p>La ".$tipo." de La compra N° ".$compra.",no pudo ser procesada por favor enviar correo  a: ".Config::EmailSender["cuenta"]." con los datos dados</p>";
     }
    ?>
    
     <button  class="uk-button uk-button-primary submit-button"  onclick="javascript:finalizar(event)">Aceptar</button>
    </div>
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