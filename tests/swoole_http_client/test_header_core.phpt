--TEST--
swoole_http_client: test header coredump
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php
require __DIR__ . '/../include/bootstrap.php';
require __DIR__ . '/../include/api/swoole_http_client/simple_http_client.php';
$simple_http_server = __DIR__ . "/../include/api/swoole_http_server/simple_http_server.php";
$closeServer = start_server($simple_http_server, HTTP_SERVER_HOST, $port = get_one_free_port());

set_error_handler(function ($errno) {
    if (!assert($errno === E_DEPRECATED)) {
        echo "ERROR";
    }
});

testHeaderCore(HTTP_SERVER_HOST, $port, function() use($closeServer) {
    echo "SUCCESS";
    $closeServer();
});

suicide(1000, SIGTERM, $closeServer);
?>
--EXPECT--
SUCCESS
