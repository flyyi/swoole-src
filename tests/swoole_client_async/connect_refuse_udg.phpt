--TEST--
swoole_client_async: connect refuse with unix dgram

--SKIPIF--
<?php require  __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php
require __DIR__ . '/../include/bootstrap.php';
$cli = new swoole_client(SWOOLE_SOCK_UNIX_DGRAM, SWOOLE_SOCK_ASYNC);
$cli->on("connect", function(swoole_client $cli) {
    assert(false);
});
$cli->on("receive", function(swoole_client $cli, $data) {
    assert(false);
});
$cli->on("error", function(swoole_client $cli) { echo "error\n"; });
$cli->on("close", function(swoole_client $cli) { echo "close\n"; });

@$cli->connect("/test.sock", 0, 0.5, 1);

swoole_event_wait();
?>
--EXPECT--
error