<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$client_id = $_POST['change_client_id'];
$full_name = $_POST['change_full_name'];
$display_name = $_POST['change_display_name'];
$vouchers = $_POST['change_vouchers'];
$invited_by_id = $_POST['change_invited_by_id'];

$success = $handle->updateClient($client_id, $full_name, $display_name, $vouchers, $invited_by_id);

if ($success) {
    echo "Klient (ID $client_id) wurde erfolgreich bearbeitet!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="client.php">Zurück zum Klienten-Menü</a>
