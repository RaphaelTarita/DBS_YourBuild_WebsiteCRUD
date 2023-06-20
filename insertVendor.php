<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$vendor_id = $_POST['new_vendor_id'];
$name = $_POST['new_name'];
$homepage = $_POST['new_homepage'];

$success = $handle->insertVendor($vendor_id, $name, $homepage);

if ($success) {
    echo "Händler (ID $vendor_id) wurde erfolgreich angelegt!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="vendor.php">Zurück zum Händler-Menü</a>
