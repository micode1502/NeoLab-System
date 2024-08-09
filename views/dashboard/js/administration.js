/*============== DARK THEME AND RESPONSIVE MENU ============== */

const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");

// ======= Menu desplegable =======
menuBtn.addEventListener("click", () => {
  sideMenu.style.display = "block";
});

closeBtn.addEventListener("click", () => {
  sideMenu.style.display = "none";
});

// ======= change theme =======
/* const themeToggler = document.querySelector(".theme-toggler"); */
function changeDarkMode(){
  if(localStorage.getItem("dark-theme") == "true"){
      document.getElementById("a-dark").checked = true;
      changeTheme();
  }
}

function changeTheme() {
  // Get the checkbox
  var checkBox = document.getElementById("a-dark");
  var modals = document.querySelectorAll(".modal");
  // If the checkbox is checked, display the output text
  if (checkBox.checked == true) {
    modals.forEach((modal) => {
      modal.setAttribute("data-bs-theme", "dark");
    });
    document.body.classList.toggle("dark-theme-variables");
    localStorage.setItem('dark-theme', "true");
  } else {
    modals.forEach((modal) => {
      modal.setAttribute("data-bs-theme", "light");
    });
    document.body.classList.toggle("dark-theme-variables");
    localStorage.setItem('dark-theme', "false");
  }
}
