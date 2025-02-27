<<<<<<< HEAD
=======
<<<<<<< HEAD
let cursosUrl = "http://localhost/registroInasistencias/cursos";
console.log("hello world");

function listCursos() {
  fetch(cursosUrl + "/getCursos")
    .then((data) => data.json())
    .then((data) => {
      console.log(data);
      data.forEach((curso) => {
        console.log(curso.nombre_curso);
        document.getElementById("tablaCursos").innerHTML += `<tr>
            <td>${curso.idcurso}</td>
            <td>${curso.nombre_curso}</td>
            <td>${curso.tipo_curso}</td>
            <td>${curso.descripcion_curso}</td>`;
      });
    });
}

window.addEventListener("DOMContentLoaded", (e) => {
  listCursos();
});
=======
let cursosUrl = "http://localhost/registroInasistencias/cursos"
>>>>>>> f2d444bcd356937dfd1851f7695d33b4240b71e9
console.log("hello world");


const btnCurso = document.querySelector("#btnCurso")
frmCursos = document.querySelector("#frmCursos")

btnCurso.addEventListener('click', ()=>{
  document.getElementById("CursoModalLabel").innerHTML =
        "Agregar Curso";
    $('#crearCursoModal').modal('show')
})

function listCursos(){
  document.getElementById("tablaCursos").innerHTML = "";
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
<<<<<<< HEAD

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
          listCursos();
        }
      });
  });

  document.addEventListener('click', (e)=>{
    console.log("click");
    
    try {
      let selected = e.target.closest("button").getAttribute("data-action-type");
      let idcurso = e.target.closest("button").getAttribute("rel");
  
      if (selected == "delete") {
        Swal.fire({
          title: "Eliminar curso",
          text: "¿Está seguro de eliminar el curso?",
          icon: "warning",
          showDenyButton: true,
          confirmButtonText: "Sí",
          denyButtonText: `Cancelar`,
        }).then((result) => {
          if (result.isConfirmed) {
            let formData = new FormData();
            formData.append("idcurso", idcurso);
            fetch(base_url + "/cursos/eliminarCurso", {
              method: "POST",
              body: formData,
            })
              .then((res) => res.json())
              .then((data) => {
                Swal.fire({
                  title: data.status ? "Correcto" : "Error",
                  text: data.msg,
                  icon: data.status ? "success" : "error",
                });
                listCursos();
              });
          }
        });
      }
  
      if (selected == "update") {
        $("#crearCursoModal").modal("show");
        document.getElementById("CursoModalLabel").innerHTML =
          "Actualizar Curso";
        fetch(base_url + `/cursos/getCursoByID/${idcurso}`, {
          method: "GET",
        })
          .then((res) => res.json())
          .then((res) => {
            curso = res.data[0];
            console.log(curso);
            
            document.querySelector("#nombreCurso").value = curso.nombre_curso;
            document.querySelector("#tipoCurso").innerHTML = `<option selected hidden value="${curso.tipo_curso}">${curso.tipo_curso}</option>
            <option value="tecnico">tecnico</option>
                    <option value="tecnologo">tecnologo</option>
                    <option value="complementario">complementario</option>`;
            document.querySelector("#descripcionCurso").value = curso.descripcion_curso;
            document.querySelector("#idcurso").value = curso.idcurso;
              });
              listCursos();
      }
    } catch {}
  })
=======
>>>>>>> 670947a49ff133b601f3e0132ad63ddec737f499
>>>>>>> f2d444bcd356937dfd1851f7695d33b4240b71e9
