<?php
$ports = [25, 80, 443, 587, 465]; // Додайте порти, які хочете перевірити
$hosts = ['smtp.gmail.com', 'google.com']; // Додайте хости, які хочете перевірити

foreach ($hosts as $host) {
    echo "Checking ports for host: $host<br>";
    foreach ($ports as $port) {
        $connection = @fsockopen($host, $port, $errno, $errstr, 10);
        if (is_resource($connection)) {
            echo "Port $port on $host is open.<br>";
            fclose($connection);
        } else {
            echo "Port $port on $host is closed or blocked. Error: $errno - $errstr<br>";
        }
    }
    echo "<br>";
}
?>
