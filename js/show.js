const container = document.querySelector(".container"),
  pwShowHide = document.querySelectorAll(".showHipePw"),
  pwFields = document.querySelectorAll(".password"),
  signUp = document.querySelector(".signup-link"),
  login = document.querySelector(".login-link");


pwShowHide.forEach(eyeIcon =>{
    eyeIcon.addEventListener("click", ()=>{
        pwFields.forEach(pwFields =>{
            if(pwFields.type ==="password"){
                pwFields.type = "text";

                pwShowHide.forEach(icon =>{
                    icon.classList.replace("bx-hide","bx-show");
                })
            }else{
                pwFields.type = "password";

                pwShowHide.forEach(icon =>{
                    icon.classList.replace("bx-show", "bx-hide");
                })
            }
        })
    })
})