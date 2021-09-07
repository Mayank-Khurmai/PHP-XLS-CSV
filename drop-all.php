<?php

$mysqli = new mysqli('localhost','root','','icloudems');
$mysqli->query('SET foreign_key_checks = 0');
if ($result = $mysqli->query("SHOW TABLES"))
{
    while($row = $result->fetch_array(MYSQLI_NUM))
    {
        $mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
        echo "<br>";
        echo $row[0].",\n";
    }
}

$mysqli->query('SET foreign_key_checks = 1');
$mysqli->close();
?>