<?php
    /*setcookie("$list", time()+365*24*3600);*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To Do list</title>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
    
    <style>
        #container {
            width: 250px;
            height: auto;
            border: 1px solid black;
            border-radius: 20px;
            padding: 10px 5px;
            margin: 0 auto;
            background-color: #ccc;
  
        }
        * {font-family: 'Indie Flower', cursive;}
        
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
            background-color: #fff;
        }
        #ajouter {
            margin-top: 10px;
        }
        
        li {
            list-style: none;
            display: flex;
        }
        a {margin: 0 10px 0 0; padding: 0;}
        
        
        input[type="text"] {
            padding: 2px !important;
            height: 20px;
        }
        
        .cache {
            display: none;
        }
        
        #sortable {
            position: relative;
        }
        #sortable label span {margin-left: 10px;}
        #sortable label:before {
            border: 2px solid #000;
              border-top: none;
              border-right: none;
              content: "";
              height: 6px;
              transform: rotate(-45deg);
              width: 12px;
            position: absolute;
            margin-top: 4px;
        }

        
        #sortable input[type="checkbox"] {
          visibility: hidden;
        }
        
        #sortable input[type="checkbox"]:checked + label {
          background-color: transparent;
          border-color: #ccc;
        }
        
        input[type="submit"] {
            background-color: transparent;
            border: 1px solid #000;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            padding-top: 5px;
        }
        
        #todo {
            border-top: 0px;
            border-right: 0px;
            border-left: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        #todo::placeholder {padding-left: 5px;}
        
        
        input.cache {
            border-top: 0px;
            border-right: 0px;
            border-left: 0px;
            border-bottom: 1px solid #000;
        }
    </style>
</head>
<body>
<div id="container">
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
        <p class="h2">ADD A TASK</p>
           <form action="contenu.php" method="POST">
                <input type="text" name="tache" placeholder="Task to do" id="todo">
                <input type="submit" name="submit" value="Add" id="add">
           </form>
    </div>

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
                if (myObj['done'] === undefined) {
                     myObj['done'] = [];
                }

		        for (var i=0; i < myObj['tache'].length; i++) {

                    $("#sortable").append("<li><a class='edit'><i class='fas fa-pencil-alt'></i></a><label for='task"+i+"'><input type='checkbox' name='tache' value='false' id='task"+i+"' /><span>"+myObj['tache'][i]+"</span></label><input type='text' size='10' maxlength='60' placeholder='"+myObj['tache'][i]+"' class='cache' /><a class='cache' id='exit'><i class='fas fa-times-circle'></i></a></li>");
		        }

		        for (var j=0; j < myObj['done'].length; j++) {
		        	$("#done ul").append("<li><a class='up'><i class='fas fa-arrow-up'></i></a><a class='del'><i class='far fa-trash-alt'></i></a><span>"+myObj['done'][j]+"</span></li>");
		        }

                $("#sortable").sortable({
                    update: function() {
                        var newList = $("#sortable li label span");
                        var doneActuel = $("#done ul li span");

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
                
                $(".edit").click(function() {
                    var clicked = $(this).parent().find("span");
                    console.log(clicked);
                    clicked.css('display','none');
                    $(this).parent().find(".cache").css('display','block');
                    
                    $(".cache").keypress(function( event ) {
                      if ( event.which == 13 ) {
                         console.log("le enter was pressed");
                         var newToDo = $(this).parent().find(".cache").val();
                            console.log(newToDo);
                          clicked.text(newToDo);
                          clicked.css('display','inline');
                          $(this).parent().find(".cache").css('display','none');
                      }
  
                        var edited = $("#sortable li label span");
                        var done = $("#done ul li span");

                        var newTaches = [];
                        var newDone = [];

                        for (k=0; k < edited.length; k++) {
                            newTaches.push(edited[k].innerHTML);
                        }
                        for (f=0; f < done.length; f++) {
                            newDone.push(done[f].innerHTML);
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
                    });
                });
		        
                $("a#exit").click(function() {
                    $(this).parent().find("input.cache").css('display','none');
                    $(this).css('display','none');
                    $(this).parent().find("span").css('display','inline');
                    
                });
		    }
            
		};
		
		xmlhttp.send();
        
        
	</script>

</body>
</html>
