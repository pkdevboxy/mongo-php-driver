--TEST--
BSON\toPHP(): BSON decoding exceptions
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

/* We can't really test for bson_iter_init() failure, since bson_reader_read()
 * already checks that the buffer is at least 5 bytes.
 */
$invalidBson = array(
    '',
    str_repeat(fromJSON('{"x": "y"}'), 2),
);

foreach ($invalidBson as $bson) {
    try {
        var_dump(toPHP($bson));
    } catch (MongoDB\Driver\Exception\UnexpectedValueException $e) {
        echo $e->getMessage(), "\n";
    }
}

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
Could not read document from BSON reader
Reading document did not exhaust input buffer
===DONE===
