function validate(){
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    let emptyFields = [];
    if (!email) emptyFields.push("Correo Electrónico");
    if (!password) emptyFields.push("Contraseña");

    if (email && !validateEmail(email)) {
        emptyFields.push("Formato de Correo Electrónico inválido");
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