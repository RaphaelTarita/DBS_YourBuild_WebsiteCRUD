<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$tracking_number = $_POST['delete_tracking_number'];
$build_id = $_POST['delete_build_id'];

$success = $handle->deleteBuild($tracking_number, $build_id);

if ($success) {
    echo "Build (Tracking-Nummer $tracking_number, ID $build_id) wurde erfolgreich gelöscht!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="build.php">Zurück zum Builds-Menü</a>
