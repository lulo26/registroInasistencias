const btnCurso = document.querySelector("#btnCurso")
frmCursos = document.querySelector("#frmCursos")

btnCurso.addEventListener('click', ()=>{
    $('#crearCursoModal').modal('show')
})

function listCursos(){
    fetch(base_url + "/cursos/getCursos")
    .then((data) => data.json())
    .then((data) => {  
        data.forEach((curso) =>{
            document.getElementById("tablaCursos").innerHTML += `<tr>
            <td>${curso.idcurso}</td>
            <td>${curso.nombre_curso}</td>
            <td>${curso.tipo_curso}</td>
            <td>${curso.descripcion_curso}</td>
            <td>${curso.options}</td>`
        })
    })
} 

window.addEventListener("DOMContentLoaded", e =>{
   listCursos();
})

frmCursos.addEventListener("submit", (e) => {
    e.preventDefault();
    frmData = new FormData(frmCursos);
    console.log(frmData);
    fetch(base_url + "/cursos/setCursos", {
      method: "POST",
      body: frmData,
    })
      .then((res) => res.json())
      .then((data) => {
        Swal.fire({
          title: data.status ? "Correcto" : "Error",
          text: data.msg,
          icon: data.status ? "success" : "error",
        });
        if (data.status) {
            frmCursos.reset();
          $("#crearCursoModal").modal("hide");
          tablaMascotas.api().ajax.reload(function () {});
        }
      });
  });
