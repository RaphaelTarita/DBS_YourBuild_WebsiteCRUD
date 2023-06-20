<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$client_id = $_POST['delete_client_id'];

$success = $handle->deleteClient($client_id);

if ($success) {
    echo "Klient (ID $client_id) wurde erfolgreich gelöscht!";
} else {
    echo 'Ein unerwarteter Fehler ist aufgetreten';
}

?>
<br>
<a href="client.php">Zurück zum Klienten-Menü</a>
