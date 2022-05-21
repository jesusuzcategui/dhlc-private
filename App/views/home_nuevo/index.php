<?php

use Core\Config;
use App\helpers\Functions;

?>

<style>
    .mdl-layout__header {
        background: #073c4d !important;
    }
</style>

<div id="LandingApp">
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <div><header-component></header-component></div>
        <div><router-view></router-view></div>
        <div><footer-component></footer-component></div>
    </div>
</div>