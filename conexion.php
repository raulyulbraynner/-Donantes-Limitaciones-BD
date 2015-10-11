<?php
 // Connects to Our Database
 $connection = mysql_connect("localhost", "<usuario>", "<password>") or die(mysql_error());
 mysql_select_db("donaciones") or die(mysql_error());
?>