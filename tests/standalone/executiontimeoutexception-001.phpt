--TEST--
ExecutionTimeoutException: exceeding $maxTimeMS (queries)
--SKIPIF--
<?php require "tests/utils/basic-skipif.inc" ?>
--FILE--
<?php
require_once "tests/utils/basic.inc";

$manager = new MongoDB\Driver\Manager(MONGODB_URI);

$query = new MongoDB\Driver\Query(array("company" => "Smith, Carter and Buckridge"), array(
    'projection' => array('_id' => 0, 'username' => 1),
    'sort' => array('phoneNumber' => 1),
    'modifiers' => array(
        '$maxTimeMS' => 1,
    ),
));

failMaxTimeMS($manager);
throws(function() use ($manager, $query) {
    $result = $manager->executeQuery(NS, $query);
}, "MongoDB\Driver\ExecutionTimeoutException");

?>
===DONE===
<?php exit(0); ?>
--EXPECT--
OK: Got MongoDB\Driver\ExecutionTimeoutException
===DONE===