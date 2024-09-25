<?php
$hostname = 'smtp.gmail.com';
$port = 587;
$timeout = 10; // Таймаут в секундах

echo "Testing connection to $hostname on port $port...<br>";

$connection = @fsockopen($hostname, $port, $errno, $errstr, $timeout);

if (is_resource($connection)) {
    echo "Connection successful!";
    fclose($connection);
} else {
    echo "Connection failed. Error: $errno - $errstr";
}
?>
