// Håndter åpning og lukking av modale vinduer for gjøremål
function setupModalHandlers(addButton, cancelButton, modalWindow) {
  addButton.addEventListener("click", () => {
    modalWindow.showModal();
  });

  cancelButton.addEventListener("click", (e) => {
    e.preventDefault();
    modalWindow.close();
  });
}

// Håndter sletting av gjøremål med bekreftelsesdialog
function setupDeleteHandlers(deleteButtons, confirmDialog) {
  for (let deleteBtn of deleteButtons) {
    deleteBtn.addEventListener("click", () => {
      const id = deleteBtn.id.slice(5); // Henter ID fra knappen

      // Sett verdien i det skjulte input-feltet til iden til dette todo-elementet.
      confirmDialog.querySelector("input").setAttribute("value", id);

      confirmDialog.showModal();

      // Hent avbryt-knappen
      const cancelBtn = document.getElementById("cancel_delete_todo");
      // Legg på eventlistener som hindrer at siden lastes på nytt hvis skjemaet ikke skal sendes inn, men bare lukker dialogboksen.
      cancelBtn.addEventListener("click", (e) => {
        e.preventDefault();
        confirmDialog.close();
      });

      // Hva skjer hvis dialogboksen lukkes?
      confirmDialog.addEventListener("close", () => {
        console.log(`Avbrutt sletting av gjøremål med id: ${id}`);
      });
    });
  }
}

// Håndterer fullføring av gjøremål
function setupCompleteHandlers(complete_todos){
  for(let complete of complete_todos){
    complete.addEventListener("input", ()=>{
      let id = complete.id.slice(-1);
      let todo = document.getElementById("desc_todo_" + id);
    
      if(complete.checked){
        console.log(todo.innerHTML);
        todo.innerHTML = "<s>" + todo.innerHTML + "</s>";

      } else {
        console.log(todo.innerHTML);
        todo.innerHTML =  todo.innerText;
  
      }
    })
  }
}

// Håndter oppdatering av gjøremål med dialog
function setupUpdateHandlers(todos, updateWindow) {
  // Legg eventlistener på hvert todo-element
  for (let todo of todos) {
    // Hent id fra todo
    const id = todo.id.slice(10);
    // Hent textinnholdet til dette todo itemet
    const desc = todo.innerText;

    // Legg på eventlistener som åpner dialogboksen for å oppdatere innholdet
    todo.addEventListener("click", () => {
      // Legg textinnholdet i det synlige input feltet.
      document.getElementById("update_todo_content").value = desc;

      // Legg textinnholdet i et usynlig input felt for å sammenligne med en eventuell oppdatering
      updateWindow.querySelector("input[name='original_description']").value = desc;

      // Legg id'en til dette todoelementet i det skjule inputfeltet
      updateWindow.querySelector("input[name='id']").value = id;

      // Vis oppdateringsvinduet
      updateWindow.showModal();

      // Hent avbryt-knappen
      const cancelUpdateTodo = document.getElementById("cancel_update_todo");
      // Legg på eventlistener for å lukke vinduet uten av siden lastes på nytt
      cancelUpdateTodo.addEventListener("click", (e)=>{
        e.preventDefault();
        updateWindow.close();
      });
    });
  }
}

function confirmDeletion() {
  return confirm("Er du sikker på at du vil slette denne oppgaven?");
}

// Initialiser funksjoner når DOM er lastet inn
document.addEventListener("DOMContentLoaded", () => {
  const toggleButton = document.getElementById("toggle-btn");
  const sidebar = document.getElementById("sidebar");
  const add_todo = document.getElementById("add_todo");
  const add_todo_window = document.getElementById("add_todo_window");
  const cancel_add_todo = document.getElementById("cancel_add_todo");
  const delete_buttons = document.querySelectorAll("[id^=todo_]");
  const delete_todo_window = document.getElementById("delete_todo_window");
  const update_todos = document.querySelectorAll("[id^=desc_todo");
  const update_todo_window = document.getElementById("update_todo_window");
  const complete_todos = document.querySelectorAll("[id^=todo_check]");

  // Sett opp sidebar-toggle
  toggleButton.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    toggleButton.classList.toggle("rotate");
  });

  // Sett opp modalhåndtering for å legge til gjøremål
  //setupModalHandlers(add_todo, cancel_add_todo, add_todo_window);

  // Sett opp slettingshåndtering for gjøremål
  //setupDeleteHandlers(delete_buttons, delete_todo_window);

  // Sett opp oppdateringshåndtering for gjøremål
  setupUpdateHandlers(update_todos, update_todo_window);

  setupCompleteHandlers(complete_todos);
});
