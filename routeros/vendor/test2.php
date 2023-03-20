<?php
use PEAR2\Net\RouterOS;

require_once 'Autoload.php';
$ip = "10.168.226.160";
exec("ping $ip", $output, $result);
print_r($output);
try {
    $client = new RouterOS\Client('10.168.0.3', 'script', 'M00n123!P@55w0rd1!');
} catch (Exception $e) {
    die('Unable to connect to the router.');
    //Inspect $e if you want to know details about the failure.
}

$responses = $client->sendSync(new RouterOS\Request('/ip/hotspot/user/print'));

foreach ($responses as $response) {
    if ($response->getType() === RouterOS\Response::TYPE_DATA) {
        echo 'USER: ', $response->getProperty('name'),
        ' Password: ', $response->getProperty('password'),
        "\n";
    }
}
//Example output:
/*
IP: 192.168.88.100 MAC: 00:00:00:00:00:01
IP: 192.168.88.101 MAC: 00:00:00:00:00:02
 */