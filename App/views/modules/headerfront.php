<?php
USE Core\Config,
    App\helpers\Functions;
?>

<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #transparent-sticky-navbar">
  <nav class="uk-navbar-container uk-light" uk-navbar="mode: click">


      <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo" href="./">
            <img style="width: 150px;" src="<?php echo Functions::permalink(); ?>/images/logoweb.png"  class="logo_img d-inline-block align-top" alt="">
        </a>
      </div>

      <!--<div class="uk-navbar-center">



      </div>-->

      <div class="uk-navbar-right">
        <div class="uk-visible@m">
          <ul class="uk-navbar-nav">
              <li><a href="#modal-tarifas" uk-toggle>Conoce las tarifas Aquí</a></li>
              <li><a href="#modal-comprar" uk-toggle>¿Cómo comprar?</a></li>
              <li><a href="#modal-example" uk-toggle>¿Cómo usar mi pin?</a></li>
              <li><a href="https://locutorios.cl" class="tree">Locutorios.cl</a></li>
              <li>
                  <a href="#"><span uk-icon="icon:question; ratio: 2"></span></a>
                  <div class="uk-navbar-dropdown">
                      <ul class="uk-nav uk-navbar-dropdown-nav">
                          <li><a href="https://wa.me/56232108264" target="_blank"><span uk-icon="whatsapp"></span> Whatsapp</a></li>
                          <li><a href="https://m.me/locutorios.cl" target="_blank"><span uk-icon="facebook"></span> Messenger</a></a></li>
                      </ul>
                  </div>
              </li>
          </ul>
        </div>
        <div class="uk-hidden@m">
          <ul class="uk-navbar-nav">
              <li>
                  <a href="#sidefrontmenu" uk-toggle><span uk-icon="icon: menu; ratio: 2"></span></a>
                  <!--<div class="uk-navbar-dropdown">
                      <ul class="uk-nav uk-navbar-dropdown-nav">
                          <li><a href="#modal-tarifas" uk-toggle>Conoce las tarifas Aquí</a></li>
                          <li><a href="#modal-comprar" uk-toggle>¿Cómo comprar?</a></li>
                          <li><a href="#modal-example" uk-toggle>¿Cómo usar mi pin?</a></li>
                          <li><a href="https://locutorios.cl" class="tree">Locutorios.cl</a></li>
                      </ul>
                  </div>-->
              </li>
              <li>
                  <a href="#"><span uk-icon="icon:question; ratio: 2"></span></a>
                  <div class="uk-navbar-dropdown">
                      <ul class="uk-nav uk-navbar-dropdown-nav">
                          <li><a href="https://wa.me/56232108264" target="_blank"><span uk-icon="whatsapp"></span> Whatsapp</a></li>
                          <li><a href="https://m.me/locutorios.cl" target="_blank"><span uk-icon="facebook"></span> Messenger</a></a></li>
                      </ul>
                  </div>
              </li>
          </ul>
        </div>
      </div>

  </nav>
</div>





<div id="sidefrontmenu" uk-offcanvas="mode:push; overlay: true">
    <div class="uk-offcanvas-bar uk-flex uk-flex-column uk-open">

        <div class="sidebar-help">

            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <div>
              <div class="uk-navbar-item uk-logo ">
                  <img src="./images/logoweb.png"  class="logo_img d-inline-block align-top align-left" alt="">
              </div>
              <hr class="uk-divider-icon">
            </div>
            <div class="" >

              <ul id="menuside" class="uk-nav nav-side uk-nav-parent-icon" uk-nav="multiple: true">

                  <li  class="nav-side-item"><a href="#modal-tarifas" uk-toggle>Conoce las tarifas Aquí</a></li>
                  <li  class="nav-side-item"><a href="#modal-comprar" uk-toggle>¿Cómo comprar?</a></li>
                  <li  class="nav-side-item"><a href="#modal-example" uk-toggle>¿Cómo usar mi pin?</a></li>
                  <li  class="nav-side-item"><a href="https://locutorios.cl" class="tree">Locutorios.cl</a></li>

              </ul>

            </div>
        </div>


    </div>
</div>
