<?php
 // Connects to Our Database
 $connection = mysql_connect("localhost", "root", "") or die(mysql_error());
 mysql_select_db("donaciones") or die(mysql_error());
?>