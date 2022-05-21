<?php

USE Core\Config;

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

<div class="uk-container uk-flex uk-flex-center">
    <div class="uk-width-1-2@m uk-card uk-card-body">
        <h2 class="uk-card-title uk-text-center">RECUPERAR CLAVE</h2>
        <form  id="formper" class="formses" name="formper" method="POST" >
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <div class="uk-form-label">
                        <label for="">Ingresar correo electrónico</label>
                    </div>
                    <div class="uk-form-controls">
                        <input type="email" class="uk-input" id="email" name="email"  autocomplete="off" placeholder="Ingrese Correo Electronico" required="required"> 
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <p class="uk-text-center">¿RECUPERASTE TU CLAVE?, INGRESA <a href="./administrator">AQUÍ</a></p>
            </div>
            
            <div class="uk-margin uk-flex uk-flex-center">
                <button class="uk-button uk-button-primary " id="guard" onclick="javascript:recupera(event);">Recuperar contraseña</button>
            </div>
        </form>
    </div>
</div>

<?php include 'modules/modales.php'; ?>

<?php include 'modules/footer-main.php'; ?>