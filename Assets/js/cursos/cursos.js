console.log("hello world");

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

const btnCurso = document.querySelector("#btnCurso")

btnCurso.addEventListener('click', ()=>{
    $('#crearCursoModal').modal('show')
})



