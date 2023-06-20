<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$manufacturer_id = $_POST['change_manufacturer_id'];
$name = $_POST['change_name'];
$homepage = $_POST['change_homepage'];

$success = $handle->updateManufacturer($manufacturer_id, $name, $homepage);

if ($success) {
    echo "Hersteller (ID $manufacturer_id) wurde erfolgreich bearbeitet!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="manufacturer.php">Zurück zum Hersteller-Menü</a>
