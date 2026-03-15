<?php
header('Content-Type: text/plain');
echo "Railway Environment Diagnostic\n";
echo "=============================\n\n";

$vars_to_check = ['MYSQLHOST', 'MYSQLPORT', 'MYSQLUSER', 'MYSQLDATABASE', 'MYSQLPASSWORD', 'MYSQL_URL'];

foreach ($vars_to_check as $var) {
    $val_getenv = getenv($var);
    $val_env = isset($_ENV[$var]) ? 'SET' : 'NOT SET';
    $val_server = isset($_SERVER[$var]) ? 'SET' : 'NOT SET';
    
    echo "$var:\n";
    echo "  getenv(): " . ($val_getenv !== false ? "SET (Length: " . strlen($val_getenv) . ")" : "NOT SET") . "\n";
    echo "  \$_ENV:    $val_env\n";
    echo "  \$_SERVER: $val_server\n";
    if ($var !== 'MYSQLPASSWORD' && $var !== 'MYSQL_URL' && $val_getenv !== false) {
        echo "  Value:    $val_getenv\n";
    }
    echo "\n";
}

echo "PDO MySQL Extension: " . (extension_loaded('pdo_mysql') ? "LOADED" : "NOT LOADED") . "\n";
?>
