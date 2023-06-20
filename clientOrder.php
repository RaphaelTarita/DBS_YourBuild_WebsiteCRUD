<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$tracking_number = isset($_GET['search_tracking_number']) ? $_GET['search_tracking_number'] : null;
$status = isset($_GET['search_status']) ? $_GET['search_status'] : null;
$target_address = isset($_GET['search_target_address']) ? $_GET['search_target_address'] : null;
$price_min = isset($_GET['search_price_min']) ? $_GET['search_price_min'] : null;
$price_max = isset($_GET['search_price_max']) ? $_GET['search_price_max'] : null;
$ordered_by_id = isset($_GET['search_ordered_by_id']) ? $_GET['search_ordered_by_id'] : null;

$result_array = $handle->selectClientOrder(
    $tracking_number,
    $status,
    $target_address,
    $price_min,
    $price_max,
    $ordered_by_id
);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>YourBuild - Bestellungen</title>
</head>
<body>
<h1><a href="index.php">&lt;</a> Bestellungen-Menü</h1>
<table class="table mt-3">
    <tr>
        <td>
            <h3>Suche</h3>
            <form method="get">

                <div>
                    <label for="search_tracking_number">Tracking-Nummer:</label>
                    <input id="search_tracking_number"
                           name="search_tracking_number"
                           class="form-control"
                           type="number"
                           min="0"
                           value='<?php echo isset($tracking_number) ? $tracking_number : ''; ?>'>
                </div>
                <div>
                    <label for="search_status">Status:</label>
                    <input id="search_status"
                           name="search_status"
                           class="form-control"
                           type="text"
                           value='<?php echo isset($status) ? $status : ''; ?>'>
                </div>
                <div>
                    <label for="search_target_address">Zieladresse:</label>
                    <input id="search_target_address"
                           name="search_target_address"
                           class="form-control"
                           type="text"
                           maxlength="100"
                           value='<?php echo isset($target_address) ? $target_address : ''; ?>'>
                </div>
                <div>
                    <label for="search_price_min">Preis (min):</label>
                    <input id="search_price_min"
                           name="search_price_min"
                           class="form-control"
                           type="number"
                           min="0"
                           value='<?php echo isset($price_min) ? $price_min : ''; ?>'>
                </div>
                <div>
                    <label for="search_price_max">Preis (max):</label>
                    <input id="search_price_max"
                           name="search_price_max"
                           class="form-control"
                           type="number"
                           min="0"
                           value='<?php echo isset($price_max) ? $price_max : ''; ?>'>
                </div>
                <div>
                    <label for="search_ordered_by_id">Bestellt von (Klient-ID):</label>
                    <input id="search_ordered_by_id"
                           name="search_ordered_by_id"
                           class="form-control"
                           type="number"
                           min="0"
                           value='<?php echo isset($ordered_by_id) ? $ordered_by_id : ''; ?>'>
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Bestellung suchen</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Anlegen</h3>
            <form method="post" action="insertClientOrder.php">
                <div>
                    <label for="new_status">Status:</label>
                    <input id="new_status"
                           name="new_status"
                           class="form-control"
                           type="text">
                </div>
                <div>
                    <label for="new_target_address">Zieladresse:</label>
                    <input id="new_target_address"
                           name="new_target_address"
                           class="form-control"
                           type="text"
                           maxlength="100">
                </div>
                <div>
                    <label for="new_price">Preis:</label>
                    <input id="new_price"
                           name="new_price"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <label for="new_admission_date">Aufnahmedatum (dd.mm.yyyy):</label>
                    <input id="new_admission_date"
                           name="new_admission_date"
                           class="form-control"
                           type="text">
                </div>
                <div>
                    <label for="new_ordered_by_id">Bestellt von (Klient-ID):</label>
                    <input id="new_ordered_by_id"
                           name="new_ordered_by_id"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Bestellung hinzufügen</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Bearbeiten</h3>
            <form method="post" action="updateClientOrder.php">
                <div>
                    <label for="change_tracking_number">Tracking-Nummer:</label>
                    <input id="change_tracking_number"
                           name="change_tracking_number"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <label for="change_status">Status:</label>
                    <input id="change_status"
                           name="change_status"
                           class="form-control"
                           type="text">
                </div>
                <div>
                    <label for="change_target_address">Zieladresse:</label>
                    <input id="change_target_address"
                           name="change_target_address"
                           class="form-control"
                           type="text"
                           maxlength="100">
                </div>
                <div>
                    <label for="change_price">Preis:</label>
                    <input id="change_price"
                           name="change_price"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <label for="change_ordered_by_id">Bestellt von (Klient-ID):</label>
                    <input id="change_ordered_by_id"
                           name="change_ordered_by_id"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Bestellung bearbeiten</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Löschen</h3>
            <form method="post" action="deleteClientOrder.php">
                <div>
                    <label for="delete_tracking_number">Tracking-Nummer:</label>
                    <input id="delete_tracking_number"
                           name="delete_tracking_number"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Bestellung löschen</button>
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
            <span class="pull-left">Tracking-Nummer</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="1">
            <span class="pull-left">Status</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="2">
            <span class="pull-left">Zieladresse</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="3">
            <span class="pull-left">Preis</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="4">
            <span class="pull-left">Aufnahmedatum</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="5">
            <span class="pull-left">Bestellt von (Klient-ID)</span>
        </div>
    </th>
    </thead>
    <tbody>
    <?php foreach ($result_array as $row) : ?>
        <tr>
            <td><?php echo $row['TRACKING_NUMBER'] ?></td>
            <td><?php echo DatabaseHandle::orderStatusIntToString($row['STATUS']) ?></td>
            <td><?php echo $row['TARGET_ADDRESS'] ?></td>
            <td><?php echo (floatval($row['PRICE']) / 100) . ' €' ?></td>
            <td><?php echo $row['ADMISSION_DATE'] ?></td>
            <td><?php echo $row['ORDERED_BY'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
