<?php include 'modules/navbar-top.php'; ?>

<form action="" onsubmit="javascript:testingEncryp(event, this)">

    <input type="text" id="nombre" name="nombre">
    <button type="submit">Probar</button>

</form>

<script>

function testingEncryp(event, form){
    event.preventDefault();
}

</script>


<?php include 'modules/footer-main.php'; ?>