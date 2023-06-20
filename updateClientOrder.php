<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$tracking_number = $_POST['change_tracking_number'];
$status = $_POST['change_status'];
$target_address = $_POST['change_target_address'];
$price = $_POST['change_price'];
$ordered_by_id = $_POST['change_ordered_by_id'];

$success = $handle->updateClientOrder($tracking_number, $status, $target_address, $price, $ordered_by_id);

if ($success) {
    echo "Bestellung (Tracking-Nummer $tracking_number) wurde erfolgreich bearbeitet!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="clientOrder.php">Zurück zum Bestellungen-Menü</a>
