
  const retoggleOldPassword = document.querySelector("#retoggleOldPassword");
 const reoldPassword = document.querySelector("#reoldPassword");
 retoggleOldPassword.addEventListener("click", function () {
             // toggle the type attribute
             const type = reoldPassword.getAttribute("type") === "password" ? "text" : "password";
             reoldPassword.setAttribute("type", type);

             // toggle the icon
             this.classList.toggle("bi-eye");
         });

 const retoggleOldRePassword = document.querySelector("#retoggleOldRePassword");
 const reoldRePassword = document.querySelector("#reoldRePassword");
  retoggleOldRePassword.addEventListener("click", function () {
   // toggle the type attribute
  const type = reoldRePassword.getAttribute("type") === "password" ? "text" : "password";
  reoldRePassword.setAttribute("type", type);// toggle the icon
  this.classList.toggle("bi-eye");
   });
 const retoggleNewRePassword = document.querySelector("#retoggleNewRePassword");
 const renewRePassword = document.querySelector("#renewRePassword");
 retoggleNewRePassword.addEventListener("click", function () {
   // toggle the type attribute
  const type = renewRePassword.getAttribute("type") === "password" ? "text" : "password";
 renewRePassword.setAttribute("type", type);
 // toggle the icon
 this.classList.toggle("bi-eye");
  });
