<?php
    /*setcookie("$list", time()+365*24*3600);*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To Do list</title>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    
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
        
        li {
            list-style: none;
            display: flex;
        }
        a {margin: 0 10px 0 0; padding: 0;}
        
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
                
                if (myObj['tache'] === undefined) {
                     myObj['tache'] = [];
                }

		        for (var i=0; i < myObj['tache'].length; i++) {

                    $("#sortable").append("<li><label for='task"+i+"'><i class='fas fa-pencil-alt'></i><input type='checkbox' name='tache' value='false' id='task"+i+"' /><span>"+myObj['tache'][i]+"</span></label></li>");
		        }

		        for (var j=0; j < myObj['done'].length; j++) {
		        	$("#done ul").append("<li><a class='up'><i class='fas fa-arrow-up'></i></a><a class='del'><i class='far fa-trash-alt'></i></a>"+myObj['done'][j]+"</li>");
		        }

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

                            myObj['done'].push(selected);
                            var d = myObj['tache'].indexOf(selected);
                            myObj['tache'].splice(d, 1);
                            
                                var test = myObj;
                                console.log(test);

                        
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
                
                $(".up").click(function() {
                   var t = $(this).parent().text();
                    console.log(t);
                    
                     myObj['tache'].push(t);
                     var up = myObj['done'].indexOf(t);
                     myObj['done'].splice(up, 1);
                    console.log(myObj);
                    
                     var test = myObj;
                     console.log(test);

                        
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
                });
                
                $(".del").click(function() {
                   var t = $(this).parent().text();
                    console.log(t);
                    
                     var del = myObj['done'].indexOf(t);
                     myObj['done'].splice(del, 1);
                    console.log(myObj);
                    
                     var test = myObj;
                     console.log(test);

                        
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
                });
		        
		    }
            
		};
		
		xmlhttp.send();
        
        
	</script>

</body>
</html>
