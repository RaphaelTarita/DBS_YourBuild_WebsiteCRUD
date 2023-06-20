<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$tracking_number = $_POST['change_tracking_number'];
$build_id = $_POST['change_build_id'];
$price = $_POST['change_price'];
$performance_rating = $_POST['change_performance_rating'];

$success = $handle->updateBuild($tracking_number, $build_id, $price, $performance_rating);

if ($success) {
    echo "Build (Tracking-Nummer $tracking_number, Build-ID $build_id) wurde erfolgreich bearbeitet!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="build.php">Zurück zum Builds-Menü</a>
