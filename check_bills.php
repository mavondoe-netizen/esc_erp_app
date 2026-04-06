<?php
$db = new mysqli('localhost', 'root', '', 'eras_app');
$res = $db->query("DESCRIBE bills");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
$db->close();
