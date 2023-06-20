<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$vendor_id = $_POST['change_vendor_id'];
$name = $_POST['change_name'];
$homepage = $_POST['change_homepage'];

$success = $handle->updateVendor($vendor_id, $name, $homepage);

if ($success) {
    echo "Händler (ID $vendor_id) wurde erfolgreich bearbeitet!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="vendor.php">Zurück zum Händler-Menü</a>
