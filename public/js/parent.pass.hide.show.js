
const parentOldPassword = document.querySelector("#parentOldPassword");
const parentOldPasswordBtn = document.querySelector("#parentOldPasswordBtn");
parentOldPassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = parentOldPasswordBtn.getAttribute("type") === "password" ? "text" : "password";
            parentOldPasswordBtn.setAttribute("type", type);

            // toggle the icon
            this.classList.toggle("bi-eye");
        });

const reParentOldPassword = document.querySelector("#reParentOldPassword");
const reparentOldPasswordBtn = document.querySelector("#reparentOldPasswordBtn");
 reParentOldPassword.addEventListener("click", function () {
  // toggle the type attribute
 const type = reparentOldPasswordBtn.getAttribute("type") === "password" ? "text" : "password";
 reparentOldPasswordBtn.setAttribute("type", type);// toggle the icon
 this.classList.toggle("bi-eye");
  });
