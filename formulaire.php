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
        <form>
            <?php
                foreach ($content_json_Decoded['tache'] as $item) {
                    echo "<label for='tache'><input type='checkbox' name='tache[]' value='".$item."' /><span>".$item."</span></label><br/>";
                }
            
                if (isset($_POST['tache'])){
                    $archive = $_POST['tache'];

                    // on ajoute la tache dans le tableau data
                    foreach ($archive['tache'] as $item) {
                        echo "<p>".$item."</p>";
                        $content_json_Decoded["archive"][] = $item;
                    };


                    // Encode the array back into a JSON string
                    $content_json_Encoded = json_encode($content_json_Decoded);
                    // Save the file
                    file_put_contents('todo.json', $content_json_Encoded);

                }
            ?>
            <br/>
            <!--<input type="submit" name="submit" value="Enregister">-->
        </form>
    </div>
    
    <div id="done">
        <p class="h3">DONE</p>
        <form>

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
    
    
<!--<script src="jquery-3.2.1.min.js"></script>-->

<!--  <script>
        $(document).ready(function() {
            $("input[type=checkbox]").change(function() {
                var checked = $(this).val();
                
                    $.ajax({
                        method: "GET",
                        url: "todo.json",
                        beforeSend: function(xhr){
                            if (xhr.overrideMimeType)
                            {
                              xhr.overrideMimeType("application/json");
                            }
                        },
                        dataType: "json",
                        mimeType: "textPlain",
                        sync: true,
                        contentType: "application/json; charset=utf-8",
                        success: function (data) {
                            var json = data;
                            
                            var taches = json["tache"];
                            var archives = json["archive"];
                            for (var i=0; i<taches.length; i++) {
                                    if (checked == taches[i]) {
                                        var removeItem = taches[i];
                                        
                                        archives.push(taches[i]);
                                        taches.splice($.inArray(removeItem, taches), 1);
                                        json = {'tache':taches, 'archive':archives};
                                    }
                             }
                            console.log(json);
                        },
                        error: function(xhr, status, error) {
                            alert(xhr.responseText + '|\n' + status + '|\n' +error);
                        }
                    }); 
            });
        });
    </script> -->
<!--  <script>
        $(document).ready(function() {
            $("input[type=checkbox]").change(function() {
                var checked = $(this).val();
                
                $.getJSON('todo.json', {}, function (data) {
                    var json = data;
                            
                            var taches = json["tache"];
                            var archives = json["archive"];
                            for (var i=0; i<taches.length; i++) {
                                    if (checked == taches[i]) {
                                        var removeItem = taches[i];
                                        
                                        archives.push(taches[i]);
                                        taches.splice($.inArray(removeItem, taches), 1);
                                        json = {'tache':taches, 'archive':archives};
                                    }
                             }
                     console.log(json);
                });
            });
        });
    </script> -->


</body>
</html>
