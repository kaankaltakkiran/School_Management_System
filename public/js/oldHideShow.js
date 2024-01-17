const oldtogglePassword = document.querySelector("#oldtogglePassword");
        const oldpassword = document.querySelector("#oldpassword");

        oldtogglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = oldpassword.getAttribute("type") === "password" ? "text" : "password";
            oldpassword.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });