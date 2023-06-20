<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$vendor_id = $_POST['delete_vendor_id'];

$success = $handle->deleteVendor($vendor_id);

if ($success) {
    echo "Händler (ID $vendor_id) wurde erfolgreich gelöscht!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="vendor.php">Zurück zum Händler-Menü</a>
