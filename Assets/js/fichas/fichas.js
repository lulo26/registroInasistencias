

document.addEventListener("DOMContentLoaded", (e)=>{
    listFichas()
})


function listFichas(){
    document.getElementById("tablaFichas").innerHTML = "";
      fetch(base_url + "/fichas/getFichas")
      .then((data) => data.json())
      .then((data) => {  
          data.forEach((ficha) =>{
              document.getElementById("tablaFichas").innerHTML += `<tr>
              <td>${ficha.idficha}</td>
              <td>${ficha.numero_ficha}</td>
              <td>${ficha.cursos_idcurso}</td>
              <td>${ficha.fecha_inicio}</td>
              <td>${ficha.fecha_fin}</td>
              <td>${ficha.modalidad}</td>`
          })
      })
  } 

const btnFicha = document.querySelector("#btnFicha")
frmFichas = document.querySelector("#frmFichas")

btnFicha.addEventListener('click', ()=>{
  document.getElementById("FichaModalLabel").innerHTML =
        "Agregar Ficha";
    $('#crearFichaModal').modal('show')
})