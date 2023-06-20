<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$full_name = $_POST['new_full_name'];
$display_name = $_POST['new_display_name'];
$vouchers = $_POST['new_vouchers'];
$invited_by_id = $_POST['new_invited_by_id'];

$id = $handle->insertClient($full_name, $display_name, $vouchers, $invited_by_id);

echo "Klient '$full_name' (ID $id) wurde erfolgreich angelegt!";

?>
<br>
<a href="client.php">Zurück zum Klienten-Menü</a>
