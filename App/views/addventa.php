<?php include 'modules/navbar-top.php'; ?>
<div class="container-fluid col-7 mt-4 pt-4"> 
   
   
     <div class="uk-width-5-6 uk-width-1-1 mt-4"> 
          <h2 class="text-black uk-text-left ">Agregar venta</h2>
     </div> 
     <form id="ven-form" class="uk-grid-small uk-grid" uk-grid="">
      <div class="uk-width-1-1@m uk-width-1-1@s uk-first-column">
       <label class="uk-form-label">Email</label> 
       <div class="uk-form-controls">
        <input class="uk-input" type="text" id="email">
         </div>
          </div>
           <div class="uk-width-1-1@m uk-width-1-1@s">
            <label class="uk-form-label">telefono</label> 
            <div class="uk-form-controls">
             <input class="uk-input" type="number" id="telefono">
              </div>
               </div>
                <div class="uk-width-1-1@m uk-width-1-1@s uk-grid-margin uk-first-column"> 
                <label class="uk-form-label">Precio</label> <div class="uk-form-controls">
                 <select id="precio-select" class="uk-select helpers-select" type="text"></select> 
                 </div> 
                 </div> 
                 <div class="uk-width-1-1 uk-grid uk-grid-margin uk-first-column pb-4" style="justify-content: center !important;"> 
                 <div class="uk-width-1-2@m uk-flex uk-flex-right">
                  <button id="save" class="uk-button uk-button-primary submit-button" onclick="javascript:guardarven(event)">Agregar</button>
                   </div>
                    <div class="uk-width-1-2@m uk-flex uk-flex-left">
                     <button type="submit" class="uk-button uk-button-primary submit-button" id="guard">Pagar</button> 
                     </div>
                      </div> 
                      <input type="hidden" name="token_ws" id="token_ws">
                       </form>
         </div>

<?php include 'modules/footer-main.php'; ?>
