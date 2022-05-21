<?php include 'modules/navbar-top.php'; ?>

<div class="container-fluid">
  <div class="uk-grid uk-margin-remove px-3">
    <div class="uk-width-1-1 theme-blue mt-2">
      <div class="uk-grid uk-padding-small">
        <div class="uk-width-3-5@m  uk-flex uk-flex-left@m uk-flex-center@s uk-margin-auto-@s">
          <h2 class="text-black uk-text-left ">Gestión de Usuarios</h2>
        </div>
        <div class="uk-width-2-5@m  uk-flex uk-flex-right@m uk-flex-center@s uk-margin-auto-@s">
         <div class="uk-button-group">
            <button class="uk-button uk-button-primary"  id="regidoc" title="Registrar Usuario" onclick="javascript:modaladdOpen();"><span uk-icon="plus"></span></button>
            <a target="_blank" href="reportes/locutorios/usuarios" class="uk-button uk-button-danger"  id="regidoc" title="GENERAR PDF"><span uk-icon="file-pdf"></span></a>
         </div>
        </div>
      </div>
    </div>
  

    <div class="uk-width-1-1 uk-padding" >
      <table id="usuarios-table" class="uk-table uk-table-striped uk-table-small  text-center" style="width: 100%;">
        <thead>
          <tr>
            <th>ID</th>
            <th>RUT</th>
            <th>EMAIL</th>
            <th>TELÉFONO</th>
            <th>ROL</th>
            <th>ACCIÓN</th>
          </tr>
        </thead>
      </table>
    </div>

  </div>
</div>

<div id="addusu-modal" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">Agregar usuario</h2>
        <form id="usu-form" class="uk-grid-small" uk-grid >
            <div class="uk-width-1-2@m uk-width-1-1@s">
              <label class="uk-form-label">RUT</label>
              <div class="uk-form-controls">
                <input class="uk-input" type="text" id="cedula" pattern="[kK0-9.-]*">
              </div>
            </div>
            <div class="uk-width-1-2@m uk-width-1-1@s">
                <label class="uk-form-label">Email</label>
                <div class="uk-form-controls">
                 
                  <input class="uk-input" type="text" id="email">
                </div>
            </div>
            <div class="uk-width-1-2@m uk-width-1-1@s">
                <label class="uk-form-label">telefono</label>
                <div class="uk-form-controls">
                <input class="uk-input" type="phone" id="telefono">
                </div>
            </div>

            <div id="pass" class="uk-width-1-2@m uk-width-1-1@s">
              <label class="uk-form-label">Contrasena</label>
              <div class="uk-form-controls">
                <input class="uk-input" type="password" id="contrasena">
              </div>
            </div>
            <div id="repass" class="uk-width-1-2@m uk-width-1-1@s">
              <label class="uk-form-label">Repetir contrasena</label>
              <div class="uk-form-controls">
                <input class="uk-input" type="password" id="recontrasena">
              </div>
            </div>

            <div class="uk-width-1-2@m uk-width-1-1@s">
                <label class="uk-form-label">roll</label>
                <div class="uk-form-controls">
                <select id="roll-select" class="uk-select" type="text"></select>
                </div>
            </div>

            <span id="val_id"></span>

            <div class="uk-width-1-1">
                <div class="uk-width-1-1 uk-flex uk-flex-right">
                  <button id='save' class="uk-button uk-button-primary submit-button" id="guard"  type="submit" onclick="javascript:guardarusu(event)">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php //include 'modules/footer-main.php'; ?>