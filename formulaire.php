<?php
    /*setcookie("$list", time()+365*24*3600);*/
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
        
        #list, #ajouter {
            width: 200px;
            height: auto;
            padding: 20px;
            margin: 0 auto;
            border: 1px dotted black;
            border-radius: 20px;
        }
        #ajouter {
            margin-top: 10px;
        }
        
    </style>
</head>
<body>

<div id="list">
      <div id="a-faire">
        <p class="h3">TO DO</p>
        <ul id="sortable">

        </ul>
    </div>
    
    <div id="done">
        <p class="h3">DONE</p>
        <ul>
            
        </ul>
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
	<script src="jquery-ui.min.js"></script>

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
                    $("#sortable").append("<li><label for='task"+i+"'><input type='checkbox' name='tache' value='false' id='task"+i+"' /><span>"+myObj['tache'][i]+"</span></label></li>");
		        }

		        for (var j=0; j < myObj['done'].length; j++) {
		        	$("#done ul").append("<li>"+myObj['done'][j]+"</li>");
		        }
                
                /*$("#sortable").sortable();
                var newList = $("#sortable li label span");
                var doneActuel = $("#done ul li");
                
                var newTaches = [];
                var newDone = [];
                
                for (k=0; k < newList.length; k++) {
                    newTaches.push(newList[k].innerHTML);
                }
                for (f=0; f < doneActuel.length; f++) {
                    newDone.push(doneActuel[f].innerHTML);
                }
                var newObject = {"tache":newTaches,"done":newDone};
                console.log(JSON.stringify(newObject));*/
                $("#sortable").sortable({
                    update: function() {
                        var newList = $("#sortable li label span");
                        var doneActuel = $("#done ul li");

                        var newTaches = [];
                        var newDone = [];

                        for (k=0; k < newList.length; k++) {
                            newTaches.push(newList[k].innerHTML);
                        }
                        for (f=0; f < doneActuel.length; f++) {
                            newDone.push(doneActuel[f].innerHTML);
                        }
                        var newObject = {"tache":newTaches,"done":newDone};
                        console.log(newObject);
                        
                        $.ajax ({
                            type: "POST",
                            url: "traitement1.php",
                            beforeSend: function(xhr){
                                    if (xhr.overrideMimeType)
                                    {
                                      xhr.overrideMimeType("application/json");
                                    }
                                },
                            data: {newObject},
                            dataType: "json",
                            success: function() {
                                    console.log("ok");
                            }
                        });
                    }
                });
                
                

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
                                complete: function() {
                                    location.reload();
                                },
                                success: function() {
                                    console.log("ok");
                                }
                                
                            });
                        /*location.reload();*/
                            
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
