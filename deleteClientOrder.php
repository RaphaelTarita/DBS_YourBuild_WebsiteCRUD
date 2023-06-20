<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$tracking_number = $_POST['delete_tracking_number'];

$success = $handle->deleteClientOrder($tracking_number);

if ($success) {
    echo "Bestellung (Tracking-Nummer $tracking_number) wurde erfolgreich gelöscht!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="clientOrder.php">Zurück zum Bestellungen-Menü</a>
