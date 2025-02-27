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
console.log("hello world");

function listCursos(){
    fetch(cursosUrl + "/getCursos")
    .then((data) => data.json())
    .then((data) => { console.log(data);    
        data.forEach((curso) =>{
            console.log(curso.nombre_curso)
            document.getElementById("tablaCursos").innerHTML += `<tr>
            <td>${curso.idcurso}</td>
            <td>${curso.nombre_curso}</td>
            <td>${curso.tipo_curso}</td>
            <td>${curso.descripcion_curso}</td>`
        })
    })
} 



window.addEventListener("DOMContentLoaded", e =>{
   listCursos();
})
>>>>>>> 670947a49ff133b601f3e0132ad63ddec737f499
