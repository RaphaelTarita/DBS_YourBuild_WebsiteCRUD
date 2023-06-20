<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$tracking_number = isset($_GET['search_tracking_number']) ? $_GET['search_tracking_number'] : null;
$build_id = isset($_GET['search_build_id']) ? $_GET['search_build_id'] : null;
$price_min = isset($_GET['search_price_min']) ? $_GET['search_price_min'] : null;
$price_max = isset($_GET['search_price_max']) ? $_GET['search_price_max'] : null;
$performance_rating = isset($_GET['search_performance_rating']) ? $_GET['search_performance_rating'] : null;

$result_array = $handle->selectBuild(
    $tracking_number,
    $build_id,
    $price_min,
    $price_max,
    $performance_rating
);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>YourBuild - Builds</title>
</head>
<body>
<h1><a href="index.php">&lt;</a> Builds-Menü</h1>
<table class="table mt-3">
    <tr>
        <td>
            <h3>Suche</h3>
            <form method="get">
                <div>
                    <label for="search_tracking_number">Tracking-Nummer (Bestellung):</label>
                    <input id="search_tracking_number"
                           name="search_tracking_number"
                           class="form-control"
                           type="number"
                           min="0"
                           value='<?php echo isset($tracking_number) ? $tracking_number : ''; ?>'>
                </div>
                <div>
                    <label for="search_build_id">Build-ID:</label>
                    <input id="search_build_id"
                           name="search_build_id"
                           class="form-control"
                           type="text"
                           maxlength="10"
                           value='<?php echo isset($build_id) ? $build_id : ''; ?>'>
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
                    <label for="search_performance_rating">Performance-Rating:</label>
                    <input id="search_performance_rating"
                           name="search_performance_rating"
                           class="form-control"
                           type="number"
                           min="0"
                           value='<?php echo isset($performance_rating) ? $performance_rating : ''; ?>'>
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Build suchen</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Anlegen</h3>
            <form method="post" action="insertBuild.php">
                <div>
                    <label for="new_tracking_number">Tracking-Nummer (Bestellung):</label>
                    <input id="new_tracking_number"
                           name="new_tracking_number"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <label for="new_build_id">Build-ID:</label>
                    <input id="new_build_id"
                           name="new_build_id"
                           class="form-control"
                           type="text"
                           maxlength="10">
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
                    <label for="new_performance_rating">Performance-Rating:</label>
                    <input id="new_performance_rating"
                           name="new_performance_rating"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Build hinzufügen</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Bearbeiten</h3>
            <form method="post" action="updateBuild.php">
                <div>
                    <label for="change_tracking_number">Tracking-Nummer (Bestellung):</label>
                    <input id="change_tracking_number"
                           name="change_tracking_number"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <label for="change_build_id">Build-ID:</label>
                    <input id="change_build_id"
                           name="change_build_id"
                           class="form-control"
                           type="text"
                           maxlength="10">
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
                    <label for="change_performance_rating">Performance-Rating:</label>
                    <input id="change_performance_rating"
                           name="change_performance_rating"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Build bearbeiten</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Löschen</h3>
            <form method="post" action="deleteBuild.php">
                <div>
                    <label for="delete_tracking_number">Tracking-Nummer (Bestellung):</label>
                    <input id="delete_tracking_number"
                           name="delete_tracking_number"
                           class="form-control"
                           type="number"
                           min="0">
                </div>
                <div>
                    <label for="delete_build_id">Build-ID:</label>
                    <input id="delete_build_id"
                           name="delete_build_id"
                           class="form-control"
                           type="text"
                           maxlength="10">
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
            <span class="pull-left">Build-ID</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="2">
            <span class="pull-left">Preis</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="3">
            <span class="pull-left">Performance-Rating</span>
        </div>
    </th>
    </thead>
    <tbody>
    <?php foreach ($result_array as $row) : ?>
        <tr>
            <td><?php echo $row['TRACKING_NUMBER'] ?></td>
            <td><?php echo $row['BUILD_ID'] ?></td>
            <td><?php echo (floatval($row['PRICE']) / 100) . ' €' ?></td>
            <td><?php echo $row['PERFORMANCE_RATING'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
