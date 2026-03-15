<?php
echo "MYSQLHOST: " . (getenv('MYSQLHOST') ?: 'not set') . "\n";
echo "MYSQLPORT: " . (getenv('MYSQLPORT') ?: 'not set') . "\n";
echo "MYSQLUSER: " . (getenv('MYSQLUSER') ?: 'not set') . "\n";
echo "MYSQLDATABASE: " . (getenv('MYSQLDATABASE') ?: 'not set') . "\n";
?>
