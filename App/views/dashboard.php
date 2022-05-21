<?php include 'modules/navbar-top.php'; ?>

<div class="uk-container">
    <h2 class="uk-heading-line uk-text-center uk-margin-top uk-margin-remove-bottom"><span>Locutorios</span></h2>
    <h3 class="uk-text-center uk-margin-remove-top">PANEL ADMINISTRATIVO</h3>

    <div class="uk-child-width-1-3@l uk-margin" uk-grid>
        <div>
            <div class="uk-card uk-card-body uk-card-default uk-padding-small uk-text-center">
                <h3 class="uk-card-title uk-text-center">USUARIOS</h3>
				<a href="./usuarios" class="uk-button uk-button-primary">ACCEDER</a>
            </div>
        </div>
		
		<div>
            <div class="uk-card uk-card-body uk-card-default uk-padding-small uk-text-center">
                <h3 class="uk-card-title uk-text-center">PINES</h3>
				<a href="./tarjetas" class="uk-button uk-button-primary">ACCEDER</a>
            </div>
        </div>
		
		<div>
            <div class="uk-card uk-card-body uk-card-default uk-padding-small uk-text-center">
                <h3 class="uk-card-title uk-text-center">VENTAS</h3>
				<a href="./ventas" class="uk-button uk-button-primary">ACCEDER</a>
            </div>
        </div>
        
    </div>
	
	<div class="uk-child-width-1-3@l uk-margin" uk-grid>
        <div>
            <div class="uk-card uk-card-body uk-card-default uk-padding-small uk-text-center">
                <h3 class="uk-card-title uk-text-center"></h3>
				<a href="./dashboard/remarketing" class="uk-button uk-button-primary">MARKETING</a>
            </div>
        </div>
		
		<div>
            <div class="uk-card uk-card-body uk-card-default uk-padding-small uk-text-center">
                <h3 class="uk-card-title uk-text-center">ARCHIVO DE LOG</h3>
				<a href="./dashboard/systemlog" class="uk-button uk-button-primary">ACCEDER</a>
            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">
    
    jQuery(document).ready(function($){

        $.ajax({
            url: 'ventas/ajax/totalventas',
            method: 'post',
            dataType: 'json',
            beforeSend: function(){

            }
        }).then(function(r){
            console.log(r);
        }, function(e){
            console.error(e);
        });
    });
</script>

<?php //include 'modules/footer-main.php'; ?>