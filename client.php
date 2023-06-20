<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$client_id = isset($_GET['search_client_id']) ? $_GET['search_client_id'] : null;
$full_name = isset($_GET['search_full_name']) ? $_GET['search_full_name'] : null;
$display_name = isset($_GET['search_display_name']) ? $_GET['search_display_name'] : null;
$vouchers_min = isset($_GET['search_vouchers_min']) ? $_GET['search_vouchers_min'] : null;
$vouchers_max = isset($_GET['search_vouchers_max']) ? $_GET['search_vouchers_max'] : null;
$invited_by_id = isset($_GET['search_invited_by_id']) ? $_GET['search_invited_by_id'] : null;

$result_array = $handle->selectClient(
    $client_id,
    $full_name,
    $display_name,
    $vouchers_min,
    $vouchers_max,
    $invited_by_id
);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>YourBuild - Klienten</title>
</head>
<body>
<h1><a href="index.php">&lt;</a> Klienten-Menü</h1>
<table class="table mt-3">
    <tr>
        <td>
            <h3>Suche</h3>
            <form method="get">
                <div>
                    <label for="search_client_id">Klient-ID:</label>
                    <input id="search_client_id"
                           name="search_client_id"
                           class="form-control"
                           type="number"
                           min="0"
                           value='<?php echo isset($client_id) ? $client_id : ''; ?>'>
                </div>
                <div>
                    <label for="search_full_name">Voller Name:</label>
                    <input id="search_full_name"
                           name="search_full_name"
                           class="form-control"
                           type="text"
                           maxlength="100"
                           value='<?php echo isset($full_name) ? $full_name : ''; ?>'>
                </div>
                <div>
                    <label for="search_display_name">Anzeigename:</label>
                    <input id="search_display_name"
                           name="search_display_name"
                           class="form-control"
                           type="text"
                           maxlength="20"
                           value='<?php echo isset($display_name) ? $display_name : ''; ?>'>
                </div>
                <div>
                    <label for="search_vouchers_min">Rabatt-Zähler (min):</label>
                    <input id="search_vouchers_min"
                           name="search_vouchers_min"
                           class="form-control"
                           type="number"
                           min="0"
                           value='<?php echo isset($vouchers_min) ? $vouchers_min : ''; ?>'>
                </div>
                <div>
                    <label for="search_vouchers_max">Rabatt-Zähler (max):</label>
                    <input id="search_vouchers_max"
                           name="search_vouchers_max"
                           class="form-control"
                           type="number"
                           min="0"
                           value='<?php echo isset($vouchers_max) ? $vouchers_max : ''; ?>'>
                </div>
                <div>
                    <label for="search_invited_by_id">Eingeladen von (Klient-ID):</label>
                    <input id="search_invited_by_id"
                           name="search_invited_by_id"
                           class="form-control"
                           type="number"
                           min="0"
                           value='<?php echo isset($invited_by_id) ? $invited_by_id : ''; ?>'>
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Klient suchen</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Anlegen</h3>
            <form method="post" action="insertClient.php">
                <div>
                    <label for="new_full_name">Voller Name:</label>
                    <input id="new_full_name"
                           name="new_full_name"
                           class="form-control"
                           type="text"
                           maxlength="100">
                </div>
                <div>
                    <label for="new_display_name">Anzeigename:</label>
                    <input id="new_display_name"
                           name="new_display_name"
                           class="form-control"
                           type="text"
                           maxlength="20">
                </div>
                <div>
                    <label for="new_vouchers">Rabatt-Zähler:</label>
                    <input id="new_vouchers"
                           name="new_vouchers"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <label for="new_invited_by_id">Eingeladen von (Klient-ID):</label>
                    <input id="new_invited_by_id"
                           name="new_invited_by_id"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Klient hinzufügen</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Bearbeiten</h3>
            <form method="post" action="updateClient.php">
                <div>
                    <label for="change_client_id">Klient-ID:</label>
                    <input id="change_client_id"
                           name="change_client_id"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <label for="change_full_name">Voller Name:</label>
                    <input id="change_full_name"
                           name="change_full_name"
                           class="form-control"
                           type="text"
                           maxlength="100">
                </div>
                <div>
                    <label for="change_display_name">Anzeigename:</label>
                    <input id="change_display_name"
                           name="change_display_name"
                           class="form-control"
                           type="text"
                           maxlength="20">
                </div>
                <div>
                    <label for="change_vouchers">Rabatt-Zähler:</label>
                    <input id="change_vouchers"
                           name="change_vouchers"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <label for="change_invited_by_id">Eingeladen von (Klient-ID):</label>
                    <input id="change_invited_by_id"
                           name="change_invited_by_id"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Klient bearbeiten</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Löschen</h3>
            <form method="post" action="deleteClient.php">
                <div>
                    <label for="delete_client_id">Klient-ID:</label>
                    <input id="delete_client_id"
                           name="delete_client_id"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Klient löschen</button>
                </div>
            </form>
        </td>
    </tr>
</table>
<h2><?php echo count($result_array) ?> Ergebnis<?php echo count($result_array) != 1 ? 'se' : '' ?> gefunden:</h2>
<table class="table mt-3">
    <thead>
    <th class="table-column-25">
        <div class="header" data-column-index="0">
            <span class="pull-left">Klient-ID</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="1">
            <span class="pull-left">Voller Name</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="2">
            <span class="pull-left">Anzeigename</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="3">
            <span class="pull-left">Rabatt-Zähler</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="4">
            <span class="pull-left">Eingeladen von (Klient-ID)</span>
        </div>
    </th>
    </thead>
    <tbody>
    <?php foreach ($result_array as $row) : ?>
        <tr>
            <td><?php echo $row['CLIENT_ID'] ?></td>
            <td><?php echo $row['FULL_NAME'] ?></td>
            <td><?php echo $row['DISPLAY_NAME'] ?></td>
            <td><?php echo $row['VOUCHERS'] ?></td>
            <td><?php echo $row['INVITED_BY'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
