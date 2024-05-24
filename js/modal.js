const openModalBtn = document.getElementById("open-modal-btn");
const closeModalBtn = document.getElementById("close-modal-btn");
const modal = document.getElementById("modal");

openModalBtn.addEventListener("click", () => {    
    modal.style.display = "block";
});

closeModalBtn.addEventListener("click", () => {    
    modal.style.display = "none";
});
