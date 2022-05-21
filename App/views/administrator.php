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

<div class="home uk-padding uk-grid uk-flex-center">

    <div class="uk-width-1-2@m uk-margin-large-top" >
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

                <div class="uk-margin">
                   <p class="uk-text-center">¿OLVIDASTE TU CONTRASEÑA? RECUPERALA  <a href="./restablecer">AQUÍ</a></p>
                </div>

                <div class="uk-margin uk-flex uk-flex-center">
                    <button type="submit" class="uk-button uk-button-primary">INGRESAR</button>
                </div>

            </form>
            
        </div>
    </div>

</div>

<?php include 'modules/modales.php'; ?>

<footer class="uk-padding-large">
    
    <div class="uk-text-center">Tarjetas Locutorios - Un servicio se <a target="_blank" href="https://locutorios.cl/">Locutorios SPA</a></div>
    
</footer>

