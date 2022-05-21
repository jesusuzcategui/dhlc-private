<?php include 'modules/navbar-top.php'; ?>


<div class="uk-container uk-flex uk-flex-middle uk-flex-center" style="">
    <div class="uk-width-1-1 uk-margin-large-top uk-margin-large-bottom">
        <div class="uk-card uk-card-default uk-padding-large">
            <div class="uk-grid uk-margin-bottom">
                <div class="uk-width-3-5 uk-text-left">
                    <h2 class=" uk-h2">Importar archivo de Excel</h2>
                </div>
                <div class="uk-width-2-5 uk-text-right">
                    <a class="uk-button uk-button-primary" href="tarjetas">Volver</a>
                </div>
            </div>
            <form enctype="multipart/form-data" name="login-form" method="post"  onsubmit="javascript:importingCards(event, this);">
                <div class="uk-margin">
                    <label class="uk-form-label">Archivo excel</label>
                    <div class="uk-form-controls">
                        <div class="uk-placeholder uk-text-center">
                            <input type="file" name="excel" id="excel" class="uk-input">
                        </div>
                        
                    </div>
                </div>
                <div class="uk-margin">
                    <div class="uk-form-controls uk-flex uk-flex-center">
                        <button class="uk-button uk-button-primary" type="submit">
                            Importar tarjetas
                        </button>
                    </div>

                       <div class="loadtarg uk-margin uk-form-controls uk-flex uk-flex-center">
                       <span uk-spinner="ratio: 3" >Cargando...</span>
                       </div>
                       <div class="resulttar uk-margin uk-form-controls uk-flex uk-flex-center">
                        <h3>Resultado de Carga</h3>
                        
                        <table>
                         <tr>
                         <td> <b>REGISTRADAS</b></td>
                         <td id="insertada"></td>
                         </tr>
                         <tr>
                         <td> <b>ERRORES</b> </td>
                         <td id="errores"></td>
                         </tr>
                         <tr>
                         <td> <b>OMITADAS</b> </td>
                         <td id="omitidas"></td>
                         </tr>
                         <tr>
                         <td> <b>SIN MONTO</b> </td>
                         <td id="nomonto"></td>
                         </tr>
                        
                        </table>
                       </div>   
                </div>
            </form>
        </div>
    </div>
</div>


<?php include 'modules/footer-main.php'; ?>