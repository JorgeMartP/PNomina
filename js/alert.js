
function advertencia(e){
    e.preventDefault();
    var url=e.currentTarget.getAttribute('href');
    Swal.fire({
        title: '¿Esta seguro?',
        text: '¡No podrá recuperar este registro !',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor:'#2CB073',
        cancelButtonColor:'#d33',
        confirmButtonColor: 'Si, Eliminar',
        cancelButtonText: 'No, Salir',
        reverseButtons: true,
        padding: '20px',
        backdrop: true,
        position: 'top',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: false, 
    }).then((result)=>{
        if(result.isConfirmed){
            window.location.href=url;
        }
    })
}




