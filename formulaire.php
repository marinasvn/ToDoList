
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
        <p class="h3">TO DO</p>
        <form method="post">

        </form>
    </div>
    
    <div id="done">
        <p class="h3">DONE</p>

    </div>
  </div>

	<div id="ajouter">
        <p class="h2">AJOUTER UNE TACHE</p>
           <form action="contenu.php" method="POST">
                <input type="text" name="tache" placeholder="La tâche à effectuer">
                <input type="submit" name="submit" value="Ajouter" id="add">
           </form>
    </div>


	<script src="jquery-3.3.1.min.js"></script>

	<script>
		var xmlhttp = new XMLHttpRequest();
        xmlhttp.overrideMimeType("application/json");
		xmlhttp.open("POST", "todo.json", true);
		xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
		
		xmlhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		        var myObj = JSON.parse(this.responseText);

		        for (var i=0; i < myObj['tache'].length; i++) {
		        	/*$("#a-faire").append("<li>"+myObj['tache'][i]+"</li>");*/
                    $("#a-faire").append("<label for='task"+i+"'><input type='checkbox' name='tache' value='false' id='task"+i+"' /><span>"+myObj['tache'][i]+"</span></label><br/>");
		        }

		        for (var j=0; j < myObj['done'].length; j++) {
		        	$("#done").append("<p>"+myObj['done'][j]+"</p><br/>");
		        }

		        $("input[type=checkbox]").change(function() {
                    if ($(this).is(':checked')) {
                            $(this).attr('value', 'true');
                            var selected = $("label[for='" +this.id +"']").text();
                            console.log(selected);
                        
                            myObj['done'].push(selected);

                            myObj['tache'].splice($.inArray(selected, myObj['tache']), 1);
                            console.log(myObj);
                        
                            var test = myObj;
                        
                            $.ajax ({
                                type: "POST",
                                url: "traitement.php",
                                beforeSend: function(xhr){
                                    if (xhr.overrideMimeType)
                                    {
                                      xhr.overrideMimeType("application/json");
                                    }
                                },
                                data: {test},
                                dataType: "json",
                                success: function() {
                                    console.log("ok");
                                }
                                
                            });
                        location.reload();
                            
                    } else {
                        $(this).attr('value','false');
                    }
                    
		        });
		        	
		    }
		};
		
		xmlhttp.send();
        
        
	</script>

</body>
</html>
