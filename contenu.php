<?php
header("Content-type: application/json; charset=utf-8");
// Get the tache to do from formulaire.php
$ajoutTache = $_POST['tache'];
// Load the file
$content = file_get_contents('todo.json');
// Decode the JSON data into a PHP array.
$contentDecoded = json_decode($content, true);
// Modify the counter variable
$contentDecoded['tache'][] = $ajoutTache;
// Encode the array back into a JSON string
$json = json_encode($contentDecoded);

// Save the file
file_put_contents('todo.json', $json);
header ('Location: formulaire.php');
?>