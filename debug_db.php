<?php
require "db/connection.php";

echo "<h2>Countries Table</h2><pre>";
$r = Database::search("SELECT * FROM `country`");
if ($r && $r->num_rows > 0) {
    while ($row = $r->fetch_assoc()) print_r($row);
} else {
    echo "No rows found or table does not exist.";
}
echo "</pre>";

echo "<h2>Cities Table</h2><pre>";
$r2 = Database::search("SELECT * FROM `city`");
if ($r2 && $r2->num_rows > 0) {
    while ($row = $r2->fetch_assoc()) print_r($row);
} else {
    echo "No rows found or table does not exist.";
}
echo "</pre>";

echo "<h2>City Table - DESCRIBE</h2><pre>";
$r3 = Database::search("DESCRIBE `city`");
if ($r3 && $r3->num_rows > 0) {
    while ($row = $r3->fetch_assoc()) print_r($row);
} else {
    echo "Table does not exist.";
}
echo "</pre>";

echo "<h2>getCities.php test (country_id=1)</h2><pre>";
$r4 = Database::search(
    "SELECT `id`,`name` FROM `city` WHERE `country_id`=? ORDER BY `name`",
    "i",
    [1]
);
if ($r4 && $r4->num_rows > 0) {
    while ($row = $r4->fetch_assoc()) print_r($row);
} else {
    echo "No cities found for country_id=1.";
}
echo "</pre>";
?>
