let tablaCursos = "";
let cursosUrl = "http://localhost/registroInasistencias/cursos"
console.log("hello world");

function listCursos(){
    fetch(cursosUrl + "/getCursos")
    .then((data) => data.json())
    .then((data) => { console.log(data);    
        data.curso.forEach((curso) =>{
            let fila = `<tr>
            <td>${curso.idcurso}</td>
            <td>${curso.nombre_curso}</td>
            <td>${curso.tipo_curso}</td>
            <td>${curso.descripcion_curso}</td>`
            contenido.innerHTML += fila;
        })
    })
}

window.addEventListener("DOMContentLoaded", e =>{
    listCursos();
})