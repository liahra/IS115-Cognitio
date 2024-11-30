<?php

echo
"<li class='todo_item' >
<input type=\"checkbox\" class=\"todo_complete\" id=todo_check_$todo_id>
<span class='value' id=desc_todo_$todo_id>$value</span> 
<a href='../src/process_delete_todo.php?todo=$todo_id' class='icon' id=todo_$todo_id onclick=\"return confirm('Er du sikker på at du vil slette denne oppgaven?')\"><i class=\"fas fa-trash\"></i></a>
</li>";
