

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
              <td>${ficha.nombre_curso}</td>
              <td>${ficha.fecha_inicio}</td>
              <td>${ficha.fecha_fin}</td>
              <td>${ficha.modalidad}</td>
              <td>${ficha.options}</td>`
          })
      })
  } 

  function cleanModal(){
    document.querySelector("#numFicha").value = "";
    document.querySelector("#fechaIni").value = "";
    document.querySelector("#fechaFin").value = "";
    document.querySelector("#modalidad").innerHTML = `<option selected>Seleccione la modalidad</option>
                    <option value="presencial">Presencial</option>
                    <option value="virtual">Virtual</option>`
    document.querySelector("#curso").innerHTML = `<option selected hidden>Seleccione el curso</option>`;
    curosSelect()
  }

  function curosSelect(){
      fetch(base_url + "/cursos/getCursos")
      .then((data) => data.json())
      .then((data) => {  
          data.forEach((curso) =>{
            document.querySelector("#curso").innerHTML += `<option value="${curso.idcurso}">${curso.nombre_curso}</option>`
          })
        })
  }

const btnFicha = document.querySelector("#btnFicha")
frmFichas = document.querySelector("#frmFichas")

btnFicha.addEventListener('click', ()=>{
  cleanModal()
  document.getElementById("FichaModalLabel").innerHTML =
        "Agregar Ficha";
    $('#crearFichaModal').modal('show')
})

frmFichas.addEventListener("submit", (e) => {
    e.preventDefault();
    frmData = new FormData(frmFichas);
    console.log(frmData);
    fetch(base_url + "/fichas/setFichas", {
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
            frmFichas.reset();
          $("#crearFichaModal").modal("hide");
          listFichas();
        }
      });
  });

  document.addEventListener('click', (e)=>{
    console.log("click");
    
    try {
      let selected = e.target.closest("button").getAttribute("data-action-type");
      let idficha = e.target.closest("button").getAttribute("rel");
  
      if (selected == "delete") {
        Swal.fire({
          title: "Eliminar ficha",
          text: "¿Está seguro de eliminar la ficha?",
          icon: "warning",
          showDenyButton: true,
          confirmButtonText: "Sí",
          denyButtonText: `Cancelar`,
        }).then((result) => {
          if (result.isConfirmed) {
            let formData = new FormData();
            formData.append("idficha", idficha);
            fetch(base_url + "/fichas/eliminarFicha", {
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
                listFichas();
              });
          }
        });
      }

      if (selected == "update") {
        $("#crearFichaModal").modal("show");
        document.getElementById("FichaModalLabel").innerHTML =
          "Actualizar Ficha";
        fetch(base_url + `/fichas/getFichaByID/${idficha}`, {
          method: "GET",
        })
          .then((res) => res.json())
          .then((res) => {
            ficha = res.data[0];
            console.log(ficha);
            
            document.querySelector("#numFicha").value = ficha.numero_ficha;
            document.querySelector("#curso").innerHTML = `<option selected hidden value="${ficha.cursos_idcurso}">${ficha.nombre_curso}</option>`;
            curosSelect();
            document.querySelector("#fechaIni").value = ficha.fecha_inicio;
            document.querySelector("#fechaFin").value = ficha.fecha_fin;
            document.querySelector("#modalidad").innerHTML = `<option selected hidden value="${ficha.modalidad}">${ficha.modalidad}</option>
                    <option value="presencial">Presencial</option>
                    <option value="virtual">Virtual</option>`
            document.querySelector("#idficha").value = ficha.idficha;
              });
              listFichas();
      }
    } catch {}
  })