 const toggleOldPassword = document.querySelector("#toggleOldPassword");
const oldPassword = document.querySelector("#oldPassword");
toggleOldPassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = oldPassword.getAttribute("type") === "password" ? "text" : "password";
            oldPassword.setAttribute("type", type);

            // toggle the icon
            this.classList.toggle("bi-eye");
        });

const toggleOldRePassword = document.querySelector("#toggleOldRePassword");
const oldRePassword = document.querySelector("#oldRePassword");
 toggleOldRePassword.addEventListener("click", function () {
  // toggle the type attribute
 const type = oldRePassword.getAttribute("type") === "password" ? "text" : "password";
 oldRePassword.setAttribute("type", type);// toggle the icon
 this.classList.toggle("bi-eye");
  });
const toggleNewRePassword = document.querySelector("#toggleNewRePassword");
const newRePassword = document.querySelector("#newRePassword");
toggleNewRePassword.addEventListener("click", function () {
  // toggle the type attribute
 const type = newRePassword.getAttribute("type") === "password" ? "text" : "password";
newRePassword.setAttribute("type", type);
// toggle the icon
this.classList.toggle("bi-eye");
 });
 
 