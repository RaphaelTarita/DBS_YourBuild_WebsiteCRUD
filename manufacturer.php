<?php
require_once('DatabaseHandle.php');
$handle = new DatabaseHandle();

$manufacturer_id = isset($_GET['search_manufacturer_id']) ? $_GET['search_manufacturer_id'] : null;
$name = isset($_GET['search_name']) ? $_GET['search_name'] : null;
$homepage = isset($_GET['search_homepage']) ? $_GET['search_homepage'] : null;

$result_array = $handle->selectManufacturer($manufacturer_id, $name, $homepage);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>YourBuild - Hersteller</title>
</head>
<body>
<h1><a href="index.php">&lt;</a> Hersteller-Menü</h1>
<table class="table mt-3">
    <tr>
        <td>
            <h3>Suche</h3>
            <form method="get">
                <div>
                    <label for="search_manufacturer_id">Hersteller-ID:</label>
                    <input id="search_manufacturer_id"
                           name="search_manufacturer_id"
                           class="form-control"
                           type="text"
                           maxlength="10"
                           value='<?php echo isset($manufacturer_id) ? $manufacturer_id : ''; ?>'>
                </div>
                <div>
                    <label for="search_name">Name:</label>
                    <input id="search_name"
                           name="search_name"
                           class="form-control"
                           type="text"
                           maxlength="50"
                           value='<?php echo isset($name) ? $name : ''; ?>'>
                </div>
                <div>
                    <label for="search_homepage">Homepage:</label>
                    <input id="search_homepage"
                           name="search_homepage"
                           class="form-control"
                           type="text"
                           maxlength="100"
                           value='<?php echo isset($homepage) ? $homepage : ''; ?>'>
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Hersteller suchen</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Anlegen</h3>
            <form method="post" action="insertManufacturer.php">
                <div>
                    <label for="new_manufacturer_id">Hersteller-ID:</label>
                    <input id="new_manufacturer_id"
                           name="new_manufacturer_id"
                           class="form-control"
                           type="text"
                           maxlength="10">
                </div>
                <div>
                    <label for="new_name">Name:</label>
                    <input id="new_name"
                           name="new_name"
                           class="form-control"
                           type="text"
                           maxlength="50">
                </div>
                <div>
                    <label for="new_homepage">Homepage:</label>
                    <input id="new_homepage"
                           name="new_homepage"
                           class="form-control"
                           type="text"
                           maxlength="100">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Hersteller hinzufügen</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Bearbeiten</h3>
            <form method="post" action="updateManufacturer.php">
                <div>
                    <label for="change_manufacturer_id">Hersteller-ID:</label>
                    <input id="change_manufacturer_id"
                           name="change_manufacturer_id"
                           class="form-control"
                           type="text"
                           maxlength="10">
                </div>
                <div>
                    <label for="change_name">Name:</label>
                    <input id="change_name"
                           name="change_name"
                           class="form-control"
                           type="text"
                           maxlength="50">
                </div>
                <div>
                    <label for="change_homepage">Homepage:</label>
                    <input id="change_homepage"
                           name="change_homepage"
                           class="form-control"
                           type="text"
                           maxlength="100">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Hersteller bearbeiten</button>
                </div>
            </form>
        </td>
        <td>
            <h3>Löschen</h3>
            <form method="post" action="deleteManufacturer.php">
                <div>
                    <label for="delete_manufacturer_id">Hersteller-ID:</label>
                    <input id="delete_manufacturer_id"
                           name="delete_manufacturer_id"
                           class="form-control"
                           type="text"
                           maxlength="10">
                </div>
                <div>
                    <button id="submit" type="submit" class="btn btn-primary">Hersteller löschen</button>
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
            <span class="pull-left">Hersteller-ID</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="1">
            <span class="pull-left">Name</span>
        </div>
    </th>
    <th class="table-column-25">
        <div class="header" data-column-index="2">
            <span class="pull-left">Homepage</span>
        </div>
    </th>
    </thead>
    <tbody>
    <?php foreach ($result_array as $row) : ?>
        <tr>
            <td><?php echo $row['MANUFACTURER_ID'] ?></td>
            <td><?php echo $row['NAME'] ?></td>
            <td><?php echo $row['HOMEPAGE'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
