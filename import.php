<?php
$host = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$user = 'ZxsGDx7pr8JMMQ4.root';
$pass = '32jRZmHrIDyXRDuA';
$db = 'sys';
$port = 4000;

$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, false);

if (defined('MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT')) {
    $flags = MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT | MYSQLI_CLIENT_SSL;
} else {
    $flags = MYSQLI_CLIENT_SSL;
}

$mysqli->ssl_set(NULL, NULL, NULL, NULL, NULL);
$mysqli->real_connect($host, $user, $pass, $db, $port, null, $flags);

if ($mysqli->connect_errno) {
    die("Connect failed: " . $mysqli->connect_error);
}

$sql = file_get_contents('d:/ppdbv1/db/ppdbonline.sql');
// Execute multi query
if ($mysqli->multi_query($sql)) {
    do {
        if ($res = $mysqli->store_result()) {
            $res->free();
        }
    } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
    echo "Import successful.\n";
} else {
    echo "Error: " . $mysqli->error . "\n";
}
$mysqli->close();
