<?php include 'modules/navbar-top.php'; ?>

<div class="container-fluid uk-padding-small">
  <div class="uk-grid uk-margin-remove px-3 uk-padding-remove">
    <div class="uk-width-1-1 theme-blue mt-2">
      <div class="uk-grid uk-padding-small">
        <div class="uk-width-3-5@m  uk-flex uk-flex-left@m uk-flex-center@s uk-margin-auto-@s">
          <h2 class="text-black uk-text-left ">EMAILS PARA REMARKETING</h2>
        </div>
        </div>
      </div>
    </div>
    <div class="uk-overflow-auto@s">
        <table id="ventas-table" class="uk-table uk-table-small  text-center" style="width: 100%;">
          <thead>
            <tr>
              <th>EMAIL</th>
			  <th>TELÉFONO</th>
              <th>CANT. COMPRAS</th>
              <th>ÚLTIMA COMPRA</th>
            </tr>
          </thead>
		  <tbody>
			<?php foreach($emails AS $email): ?>
			<tr>
				<td><?php echo $email['email']; ?></td>
				<td><?php echo $email['telefono']; ?></td>
				<td><?php echo $email['cantidad']; ?></td>
				<td><?php echo $email['ultima_fecha']; ?></td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
        </table>
      </div>

</div>

<script>
  
  jQuery(document).ready( function(){
    $("#ventas-table").DataTable({
      lengthMenu: [ [50, 100, 200, 300, 500, -1], [50, 100, 200, 300, 500, "All"] ],
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'csv',
          text: 'CSV',
          className: 'uk-button',
          
        },
        {
          extend: 'excel',
          text: 'Excel',
          className: 'uk-button',
        },
        {
          extend: 'pdf',
          text: 'PDF',
          className: 'uk-button',
        }
      ]
    });
  } );


</script>



<?php //include 'modules/footer-main.php'; ?>
