var pass = document.getElementById("password");
var msg = document.getElementById("massage");
var str = document.getElementById("strenght");
var icon = document.getElementById("icon");
var icon2 = document.getElementById("icon2");

function validateFormR() {
    const identificacion = document.getElementById("num").value.trim();
    const tipoIdent = document.getElementById("ident").value;
    const names = document.getElementById("nombre").value.trim();
    const lastname = document.getElementById("apellido").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const tipoUsu = document.getElementById("tipoUsu").value;
  
    let emptyFields = [];
  
    if (!identificacion) emptyFields.push("N° Identificación");
    if (!tipoIdent) emptyFields.push("Tipo de Documento");
    if (!names) emptyFields.push("Nombre");
    if (!lastname) emptyFields.push("Apellidos");
    if (!email) emptyFields.push("Correo Electrónico");
    if (!password) emptyFields.push("Contraseña");
    if (!tipoUsu) emptyFields.push("Tipo de Usuario");
  
    if (email && !validateEmail(email)) {
      emptyFields.push("Formato de Correo Electrónico inválido");
    }
  
    const passwordRequirements = [];
    if (password.length < 8) passwordRequirements.push("Al menos 8 caracteres");
    if (!/\d/.test(password)) passwordRequirements.push("Al menos un número");
    if (!/[a-z]/.test(password)) passwordRequirements.push("Al menos una letra minúscula");
    if (!/[A-Z]/.test(password)) passwordRequirements.push("Al menos una letra mayúscula");
    if (!/[@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) passwordRequirements.push("Al menos un carácter especial");
  
    if (passwordRequirements.length > 0) {
      emptyFields.push("La contraseña debe cumplir con: " + passwordRequirements.join(", "));
    }
  
    if (emptyFields.length > 0) {
      const alertDiv = document.getElementById("alert-div");
      alertDiv.innerHTML = `
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <strong>Por favor, complete los siguientes campos:</strong> ${emptyFields.join(", ")}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
      return false;
    }
  
    return true;
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

window.onload = function () {
    msg.style.display = "none";

    pass.addEventListener("input", () => {
        if (pass.value.length > 0) {
            msg.style.display = "block";
        } else {
            msg.style.display = "none";
        }

        if (pass.value.length < 6) {
            str.innerHTML = "Insegura";
            pass.style.borderBottom = "2px solid #C50A0B";
            msg.style.color = "#C50A0B";
            icon.style.color = "#C50A0B";
            icon2.style.color = "#C50A0B";
        } else if (
            pass.value.length >= 6 &&
            pass.value.length < 12 &&
            /\d/.test(pass.value) &&
            /[A-Z]/.test(pass.value)
        ) {
            str.innerHTML = "Medio Segura";
            pass.style.borderBottom = "2px solid #F76032";
            msg.style.color = "#F76032";
            icon.style.color = "#F76032";
            icon2.style.color = "#F76032";
        } else if (
            pass.value.length >= 12 &&
            /\d/.test(pass.value) &&
            /[A-Z]/.test(pass.value) &&
            /[a-z]/.test(pass.value) &&
            /[@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(pass.value)
        ) {
            str.innerHTML = "Segura";
            pass.style.borderBottom = "2px solid #669801";
            msg.style.color = "#669801";
            icon.style.color = "#669801";
            icon2.style.color = "#669801";
        } else {
            str.innerHTML = "Medio Segura";
            pass.style.borderBottom = "2px solid #F76032";
            msg.style.color = "#F76032";
            icon.style.color = "#F76032";
            icon2.style.color = "#F76032";
        }
    });

   
};
