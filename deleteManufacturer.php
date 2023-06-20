<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$manufacturer_id = $_POST['delete_manufacturer_id'];

$success = $handle->deleteManufacturer($manufacturer_id);

if ($success) {
    echo "Händler (ID $manufacturer_id) wurde erfolgreich gelöscht!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="manufacturer.php">Zurück zum Hersteller-Menü</a>
