<?php
    // Load the file
    $content_todo_json = file_get_contents('todo.json');
    // Decode the JSON data into a PHP array.
    $content_json_Decoded = json_decode($content_todo_json, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To Do list</title>
    
    
    <style>
        :checked + span {
            text-decoration: line-through;
        }
    </style>
</head>
<body>
 
  <div id="list">
      <div id="a-faire">
        <p class="h3">A FAIRE</p>
        <form action="contenu.php" method="POST">
            <?php
                foreach ($content_json_Decoded['tache'] as $item) {
                    echo "<label for='tache'><input type='checkbox' name='tache' value='".$item."' /><span>".$item."</span></label><br/>";
                }
            ?>
            <br/>
            <!--<input type="submit" name="submit" value="Enregister">-->
        </form>
    </div>
    
    <div id="archive">
        <p class="h3">ARCHIVE</p>
        <form action="formulaire.php" method="POST">

        </form>
    </div>
  </div>

    <div id="ajouter">
        <p class="h2">AJOUTER UNE TACHE</p>
           <form action="contenu.php" method="POST">
                <input type="text" name="tache" placeholder="La tâche à effectuer">
                <input type="submit" name="submit" value="Ajouter" id="add">
           </form>
    </div>
    
    <script src="jquery-3.2.1.min.js"></script>
    <script>
        
    </script>
</body>
</html>