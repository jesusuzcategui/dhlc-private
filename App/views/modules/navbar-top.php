<div id="preload">
    <div id="porcentajecarga">0%</div>
    <div id="lineacarga">
       <div id="rellenocarga"></div>
    </div>
    <div id="estadocarga"></div>
</div>
<nav class="uk-navbar-container" uk-navbar="mode: click">

    <div id="menulateral"  class="uk-navbar-left">

        <ul class="uk-navbar-nav">
        <li class="">
        <?php if(isset($_SESSION['rol'])):?>
           <a  href="#offcanvas-usage" uk-toggle style="color: white !important;"><i class="uk-margin-small-right " uk-icon="menu"></i> Menú</a>
            <?php else: ?>
              <a style="color: white !important;">
                ¡Bienvenido!
              </a>
              <?php endif; ?>
         </li>
        </ul>

    </div>


    <div class="uk-navbar-center">


        <!--<a href="./home"><img src="./images/logoweb.svg"  class="logo_img d-inline-block align-top" alt=""></a>-->
        <a class="uk-navbar-item uk-logo" href="./administrator">
			<img src="./images/logoweb.png"  class="logo_img d-inline-block align-top" alt=""> 
			<span class="uk-h2 uk-margin-left uk-light uk-margin-auto-vertical uk-visible@s">Panel de administración</span>
		</a>

    </div>

</nav>


<div id="offcanvas-usage" uk-offcanvas="mode:push">
    <div class="uk-offcanvas-bar uk-flex uk-flex-column uk-open">

        <div class="sidebar-help">

            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <div>


                <div class="uk-navbar-item uk-logo ">
                    <img src="./images/logoweb.png"  class="logo_img d-inline-block align-top align-left" alt="">
                </div>
                <hr class="uk-divider-icon">
                <?php if(isset($_SESSION['permisos'])&&is_array($_SESSION['permisos'])){ ?>
                <h1 class="uk-text-lead uk-text-uppercase uk-text-small uk-margin-remove-bottom uk-margin-remove-top"><?php echo $_SESSION['email']?></h1>
                <h3 class="uk-text-lead uk-text-small uk-margin-remove-top"> <?php  echo $_SESSION['rol']?></h3>
                <div class="uk-flex uk-flex-center uk-margin">
                    <a class="uk-button uk-button-default" href="#restorepass-modal" uk-toggle>Cambiar contraseña</a>
                </div>
                <div class="uk-flex uk-flex-center uk-margin">
                    <a class="uk-button uk-button-default" href="javascript:cerrarseccion();" class="tree">Salir</a>
                </div>

                <?php } ?>

            </div>
            <div class="" >

                 <?php foreach($_SESSION['permisos'] as $key =>$valor) { ?>

                        <ul id="menuside" class="uk-nav nav-side uk-nav-parent-icon" uk-nav="multiple: true">

                            <?php if( $valor['permiso']=='listvent'){ ?>
                            <li class="nav-side-item ">

                                    <?php if($_SESSION['rol']=="Administrador"){
                                        echo "<a href='./ventas'>Ventas</a>";
                                    }else{
                                        echo "<a href='./ventas/add'>Ventas</a>";
                                    } ?>
                                <!--<ul class="uk-nav-sub">
                                    <li id="modperfiles" class="nav-side-item">
                                        <a href="./perfil">Listar</a>
                                    </li>
                                </ul>-->
                            </li>

                            <?php } ?>

                            <?php if($valor['permiso']=='listtar'){ ?>
                            <li  class=" nav-side-item">
                                <a href="./dashboard/systemlog">Log de operaciones</a>
                                <!--<ul class="uk-nav-sub">
                                    <li id="modperfiles" class="nav-side-item">
                                        <a href="./perfil">Listar</a>
                                    </li>
                                </ul>-->
                            </li>
							<li  class=" nav-side-item">
                                <a href="./dashboard/remarketing">Lista de Emails</a>
                            </li>
                            <li  class=" nav-side-item">
                                <a href="./dashboard/banners">Administrar banners</a>
                            </li>
                            <li  class=" nav-side-item">
                                <a href="./partner">Asociados</a>
                            </li>
                            <li  class=" nav-side-item">
                                <a href="./cupones">Cupones</a>
                            </li>
                            <li  class=" nav-side-item">
                                <a href="./dashboard/clientsnosales">Consultar no comprantes</a>
                            </li>
                            <li  class=" nav-side-item">
                                <a href="./tarjetas">Tarjetas</a>
                                <!--<ul class="uk-nav-sub">
                                    <li id="modperfiles" class="nav-side-item">
                                        <a href="./perfil">Listar</a>
                                    </li>
                                </ul>-->
                            </li>
                            <?php } ?>
                            <?php if($valor['permiso']=='listusu'){ ?>
                            <li  class="nav-side-item">
                                <a href="./dashboard">Inicio</a>
                                <a href="./usuarios">Usuarios</a>
                                <!--<ul class="uk-nav-sub">
                                    <li id="modperfiles" class="nav-side-item">
                                        <a href="./usuarios">Listar</a>
                                    </li>
                                </ul>-->
                            </li>
                            <?php } ?>
                            <?php if($valor['permiso']=='listconf'){ ?>
                            <li  class="uk-parent nav-side-item">
                                <a href="./perfil">Configuración</a>
                                <!--<ul class="uk-nav-sub">
                                    <li id="modperfiles" class="nav-side-item">
                                        <a href="./perfil">General</a>
                                    </li>-->
                                </ul>
                            </li>
                            <?php }?>
                        </ul>
                 <?php } ?>
            </div>
        </div>


    </div>
</div>



<!--modal cambiar clave -->

<!-- This is the modal -->
<div id="restorepass-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Configurar contraseña nueva.</h2>
        <form onsubmit="javascript:changepass(event, this)">
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <div class="uk-form-label">
                        <label for="">Ingresar clave nueva</label>
                    </div>
                    <div class="uk-form-controls">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                        <input class="uk-input" type="password" id="pass1" name="pass1">
                    </div>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <div class="uk-form-label">
                        <label for="">Repetir la clave</label>
                    </div>
                    <div class="uk-form-controls">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                        <input class="uk-input" type="password" id="pass2" name="pass2">
                    </div>
                </div>
            </div>
            <input type="hidden" name="emailrec" id="emailrec" value="<?php echo $_SESSION['email']; ?>">
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                <button class="uk-button uk-button-primary" type="submit">Cambiar contraseña</button>
            </p>
        </form>
    </div>
</div>


<script>

function changepass(event, form){
    event.preventDefault();
    let passw = {
        uno: jQuery("#pass1").val(),
        dos: jQuery("#pass2").val()
    }
    if( (passw.uno != "") || (passw.dos != "") ){

        if(passw.uno != passw.dos){
            toastr.info(`La contraseña y su confirmación no coinciden.`);
        } else {
            jQuery.ajax({
                url: 'restablecer/ajax/changepass',
                method: 'post',
                dataType: 'json',
                data: {
                    contra: passw.uno,
                    email:  jQuery("#emailrec").val()
                },
                beforeSend: function(){
                    toastr.info(`Cambiando la contraseña`);
                }
            }).then(function(done){
                if( done.data == true ){

                    toastr.success(`Haz cambiado tu contraseña. La próxima vez que inicies sesión, debes usar la que colocaste ahora.`);

                    UIkit.modal(jQuery("#restorepass-modal")).hide();

                    jQuery("#pass1").val('');
                    jQuery("#pass2").val('');

                } else {
                    toastr.success(`Ha ocurrido un error, por favor intentar de nuevo.`);
                }
            },function(error){
                console.error(error);
            });
        }

    } else {
        toastr.info(`Debe completar los campos.`);
    }
}


</script>
