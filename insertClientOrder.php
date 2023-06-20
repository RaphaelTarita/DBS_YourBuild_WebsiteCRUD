<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$status = $_POST['new_status'];
$target_address = $_POST['new_target_address'];
$price = $_POST['new_price'];
$admission_date = $_POST['new_admission_date'];
$ordered_by_id = $_POST['new_ordered_by_id'];

$id = $handle->insertClientOrder($status, $target_address, $price, $admission_date, $ordered_by_id);

echo "Bestellung (Tracking-Nummer $id) wurde erfolgreich angelegt!";

?>
<br>
<a href="clientOrder.php">Zurück zum Bestellungen-Menü</a>
