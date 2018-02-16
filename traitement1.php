<?php
    header("Content-type: application/json; charset=utf-8");

    $newObject = $_POST['newObject'];

    $encoded = json_encode($newObject);
    file_put_contents('todo.json', $encoded);

?>