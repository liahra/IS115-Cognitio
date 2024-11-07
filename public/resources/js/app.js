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
          console.log(`Klargjør for sletting av gjøremål med id: ${id}`);
          confirmDialog.showModal();

          confirmDialog.addEventListener("close", () => {
              if (confirmDialog.returnValue === 'confirm') {
                  console.log(`Bekreftet sletting av gjøremål med id: ${id}`);
                  // TODO
              } else {
                  console.log(`Avbrutt sletting av gjøremål med id: ${id}`);
              }
          });
      });
  }
}

// Initialiser funksjoner når DOM er lastet inn
document.addEventListener("DOMContentLoaded", () => {
  const toggleButton = document.getElementById('toggle-btn');
  const sidebar = document.getElementById('sidebar');
  const add_todo = document.getElementById('add_todo');
  const add_todo_window = document.getElementById('add_todo_window');
  const cancel_add_todo = document.getElementById('cancel_add_todo');
  const delete_buttons = document.querySelectorAll('[id^=todo_]');
  const delete_todo_window = document.getElementById('delete_todo_window');

  // Sett opp sidebar-toggle
  toggleButton.addEventListener("click", () => {
      sidebar.classList.toggle('close');
      toggleButton.classList.toggle('rotate');
  });

  // Sett opp modalhåndtering for å legge til gjøremål
  setupModalHandlers(add_todo, cancel_add_todo, add_todo_window);

  // Sett opp slettingshåndtering for gjøremål
  setupDeleteHandlers(delete_buttons, delete_todo_window);
});