<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$tracking_number = $_POST['new_tracking_number'];
$build_id = $_POST['new_build_id'];
$price = $_POST['new_price'];
$performance_rating = $_POST['new_performance_rating'];

$success = $handle->insertBuild($tracking_number, $build_id, $price, $performance_rating);

if ($success) {
    echo "Build (Tracking-Nummer $tracking_number, Build-ID $build_id) wurde erfolgreich angelegt!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="build.php">Zurück zum Builds-Menü</a>
