<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$manufacturer_id = $_POST['new_manufacturer_id'];
$name = $_POST['new_name'];
$homepage = $_POST['new_homepage'];

$success = $handle->insertManufacturer($manufacturer_id, $name, $homepage);

if ($success) {
    echo "Hersteller (ID $manufacturer_id) wurde erfolgreich angelegt!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="manufacturer.php">Zurück zum Hersteller-Menü</a>
