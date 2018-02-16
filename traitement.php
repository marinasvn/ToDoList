<?php
    header("Content-type: application/json; charset=utf-8");

    $test = $_POST['test'];

    $encoded = json_encode($test);
    file_put_contents('todo.json', $encoded);

   /* header ('Location: formulaire.php');*/
?>