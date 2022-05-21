<?php include 'modules/navbar-top.php'; ?>

<div class="container uk-padding-small">
  
  <form onsubmit="javascript:sendmanual(event, this)" class="uk-margin">
      
      <div class="uk-card uk-card-default">
          <div class="uk-card-body">
			<h3 class="uk-card-title">AGREGAR VENTA MANUAL</h3>
              <div class="uk-child-width-1-2@l" uk-grid>              
                  <div>
                      <div class="">
                          <input onkeyup="changeToLower(event)" type="email" placeholder="CORREO DE CLIENTE" class="email uk-input" name="venta[email]">
                      </div>
                  </div>
                  <div>
                      <div class="">
                          <input type="number" placeholder="NUMERO DE TELEFONO" class="telefono uk-input" name="venta[telefono]">
                      </div>
                  </div>              
              </div>
              <div class="uk-child-width-1-2@l" uk-grid>              
                  <div>
                      <div class="">
                          <input type="text" placeholder="NUMERO DE ORDEN" class="orden uk-input" name="venta[orden]">
                      </div>
                  </div>
                  <div>
                      <div class="">
                          <select class="precio uk-select" name="venta[precio]">
                          	<option value="">SELECIONE PRECIO</option>
                          	<option value="1">1000</option>
                          	<option value="2">2000</option>
                          	<option value="3">5000</option>
                          	<option value="6">10000</option>
                            <option value="7">Gratis</option>
                          </select>
                      </div>
                  </div> 
                  <!--<div>
                      <div class="">
                          <input id="pinquery" type="text" placeholder="PIN" class="uk-input" name="venta[pin]">
                      </div>
                  </div>-->
              </div>
          </div>
          <div class="uk-card-footer">
              <button class="uk-button uk-button-primary" type="submit" id="submitventa">AGREGAR VENTA</button>
          </div>
    </div>
      
  </form>

</div>

<style>

.tt-suggestion {
	background: white;
	width: 100%;
	padding: 10px 5px;
	border-bottom: solid 1px #ccc;
	color:black;
}

</style>


<?php include 'modules/footer-main.php'; ?>
