
const btnFicha = document.querySelector("#btnFicha");
const numero = document.querySelector("#numero_ficha");
const tablaFichas = document.getElementById("tablaFichas");
const selectCursos = document.getElementById("cursos_idcurso");
const btnCerrar = document.getElementById("btnCerrar");
const btnCerrar2 = document.getElementById("btnCerrar2");
/////////////////////////////////////////////////////LISTA FICHAS/////////////////////////////////////////////////////
function listFichas() {
    tablaFichas.innerHTML = "";
  fetch(base_url + "/fichas/getFichas")
    .then((data) => data.json())
    .then((data) => {
      console.log(data);
      data.forEach((ficha) => {
        console.log(ficha.numero_ficha);
        tablaFichas.innerHTML += `
                <td>${ficha.idficha }</td>
                <td>${ficha.numero_ficha}</td>
                <td>${ficha.id_curso }</td>
                <td>${ficha.fecha_inicio}</td>
                <td>${ficha.fecha_fin}</td>
                <td>${ficha.modalidad}</td>`;
      });
    });
}
/////////////////////////////////////////////////////LISTAR CURSOS/////////////////////////////////////////////////////
function listarCursos() {
  fetch(base_url + "/fichas/getCursos")
    .then((data) => data.json())
    .then((data) => {
      console.log(data);
      data.forEach((curso) => {
        selectCursos.innerHTML += `<option value="${curso.idcurso}">${curso.id_curso}</option>`;
      });
    });
}
/////////////////////////////////////////////////////LIMPIAR FORMULARIO////////////////////////////////////////////////
function limpiarFormulario() {
  frmFichas.reset();
}
btnCerrar.addEventListener("click", limpiarFormulario);
btnCerrar2.addEventListener("click", limpiarFormulario);
/////////////////////////////////////////////////////CARGAR FICHAS/////////////////////////////////////////////////////
window.addEventListener("DOMContentLoaded", (e) => {
    listFichas();
});
/////////////////// PRUEBAS/////////////////////////////////////////
frmFichas.addEventListener("submit", (e)=>{
  e.preventDefault();
  frmData = new FormData(frmFichas);
  console.log(frmData);
  fetch(base_url + "/fichas/setFichas",{
    method: "POST",
    body: frmData,
  })
    .then((res) => res.json())
    .then((data)=>{
      Swal.fire({
        title: data.status ? "corrrecto" : "Error",
        text: data.msg,
        icon: data.status ? "success" : "error",
      });
      if (data.status){
        frmFichas.reset();
        $("#crearFichaModal").modal("hide");
        listFichas();
      }
    });
});
/////////////////////////////////////////////////////ABRIR MODAL/////////////////////////////////////////////////////
btnFicha.addEventListener("click", () => {
  numero.readOnly = false;
/*   selectCursos.innerHTML = "<option selected disabled>Seleccione el Curso...</option>";
  listarCursos(); */
  document.getElementById("FichaModalLabel").innerHTML = "Agregar Ficha";
  $("#crearFichaModal").modal("show");
});
/////////////////////////////////////////////////////VALIDAR LONGITUD CODIGO/////////////////////////////////////////////
numero.addEventListener("input", function () {
  if (this.value.length > 10) {
    this.value = this.value.slice(0, 10);
  }
});
/////////////////////////////////////////////////////ENVIO DE DATOS/////////////////////////////////////////////////////
frmFichas.addEventListener("submit", (e) => {
  e.preventDefault();
  if (selectCursos.value === "Seleccione el curso...") {
    Swal.fire({
      title: "¡Error!",
      text: "Seleccione un curso!.",
      icon: "error",
    });
  } else {
    frmData = new FormData(frmFichas);
    console.log(frmData);
    fetch(base_url + "/fichas/setFichas", {
      method: "POST",
      body: frmData,
    })
      .then((res) => res.json())
      .then((data) => {
        console.log(data);
        Swal.fire({
          title: data.status ? "¡Correcto!" : "¡Error!",
          text: data.msg,
          icon: data.status ? "success" : "error",
        });
        if (data.status) {
          frmFichas.reset();
          $("#crearFichaModal").modal("hide");
          listFichas();
        }
      });
  }
});
/////////////////////////////////////////////////////EDITAR /////// ELIMINAR/////////////////////////////////////////////////////
document.addEventListener("click", (e) => {
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
          console.log(formData);
          fetch(base_url + "/fichas/eliminarFicha", {
            method: "POST",
            body: formData,
          })
            .then((res) => res.json())
            .then((data) => {
              Swal.fire({
                title: data.status ? "¡Correcto!" : "¡Error!",
                text: data.msg,
                icon: data.status ? "success" : "error",
              });
              listFichas();
            });
        }
      });
    }
    if (selected == "update") {
      numero.readOnly = true;
      let idficha = e.target.closest("button").getAttribute("rel");
      $("#crearFichaModal").modal("show");
      document.getElementById("FichaModalLabel").innerHTML = "Actualizar Ficha";
      fetch(base_url + `/fichas/getFichaByID/${idficha}`, {
        method: "GET",
      })
        .then((res) => res.json())
        .then((res) => {
          let ficha = res.data[0];
          console.log(ficha);
          document.querySelector("#idficha").value = ficha.idficha;
          document.querySelector("#numero_ficha").value = ficha.numero_ficha;
          document.querySelector("#cursos_idcurso").value = ficha.cursos_idcurso;
          document.querySelector("#fecha_inicio").value = ficha.fecha_inicio;
          document.querySelector("#fecha_fin").value = ficha.fecha_fin;
          document.querySelector("#modalidad").value = ficha.modalidad;

          selectCursos.innerHTML = "";

          cursos.forEach((curso) => {
            let selected = ficha.cursos_idcurso == curso ? "selected" : "";
            selectCursos.innerHTML += `<option ${selected} value="${curso}">${mayusInicial(
              curso
            )}</option>`;
          });
        }); 
    }
  } catch (e) {}
});