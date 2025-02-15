/* const btnUsuario = document.querySelector("#btnUsuario");
let frmUsuarios = document.querySelector("#frmUsuarios"); */

let idexcusa = document.querySelector("#idexcusa");
let idAprendiz = document.querySelector("#idAprendiz");
let idInasistencia = document.querySelector("#idInasistencia");

const btnCerrar = document.getElementById("btnCerrar");
const btnEquis = document.getElementById("btnEquis");
const tablaInasistencias = document.getElementById("tablaInasistencias");

const tablaExcusas = document.getElementById("tablaExcusas");

////////////////////////////////////////////////
// -------------- LISTAR EXCUSAS ---------------
////////////////////////////////////////////////

function listExcusas() {
  tablaExcusas.innerHTML = "";
  let idInstructor = 4;
  /* fetch(base_url + `/excusas/getExcusasPorInstructor/${idusuario}`, {
    method: "GET",
  }) */
  fetch(base_url + `/excusas/getExcusasPorInstructor/${idInstructor}`, {
    method: "GET",
  })
    .then((data) => data.json())
    .then((data) => {
      /* 
      console.log(data); */
      data.forEach((excusa) => {
        tablaExcusas.innerHTML += `
                <td>${excusa.fecha_excusa}</td>
                <td>${excusa.nombre_aprendiz}</td>
                <td>${excusa.nombre_curso}</td>
                <td>${excusa.numero_ficha}</td>
                <td>${excusa.fecha_inasistencia}</td>
                <td>${excusa.estado_excusa}</td>
                <td>${excusa.excusa}</td>
                <td>${excusa.options}</td>`;
      });
    });
}

/////////////////////////////////////////////////////////////////
// -------------- MOSTRAR/APROBAR/RECHAZAR EXCUSA ---------------
/////////////////////////////////////////////////////////////////
document.addEventListener("click", (e) => {
  try {
    let selected = e.target.closest("button").getAttribute("data-action-type");
    let idexcusa = e.target.closest("button").getAttribute("rel");
    console.log(idexcusa);

    if (selected == "descargar") {
      /* console.log(idexcusa); */
      fetch(
        base_url + `/excusas/mostrarExcusaDescargaDirecta?idexcusa=${idexcusa}`,
        {
          method: "GET",
        }
      )
        .then((data) => data.blob())
        .then((excusa) => {
          const link = document.createElement("a"); // Crea un enlace de descarga
          fileURL = URL.createObjectURL(excusa); // Crea una URL temporal para el archivo
          window.open(fileURL, "_blank");
          /* link.download = "archivo.pdf"; */ // Asigna un nombre al archivo descargado
          link.click(); // Simula el clic para que el archivo se descargue
        });
    }

    if (selected == "aprobar") {
      Swal.fire({
        title: "Aprobar excusa",
        text: "¿Desea aprobar esta excusa?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Sí",
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
          let formData = new FormData();
          formData.append("idexcusa", idexcusa);
          /* console.log(formData); */
          fetch(base_url + "/excusas/aprobarExcusa", {
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
              listUsuarios();
            });
        }
      });
    }
  } catch (e) {}
});

//////////////////////////////////////////////////
// ------------ LISTAR INASISTENCIAS -------------
//////////////////////////////////////////////////

function listInasistencias() {
  tablaInasistencias.innerHTML = "";

  fetch(base_url + "/excusas/getInasistencias")
    .then((data) => data.json())
    .then((data) => {
      /* 
      console.log(data); */
      data.forEach((inasistencia) => {
        /* idexcusa.value = inasistencia.idexcusa;
        idAprendiz.value = inasistencia.aprendices_idusuario;
        idInasistencia.value = inasistencia.registro_idusuario; */

        tablaInasistencias.innerHTML += `
                <td>${inasistencia.idregistro}</td>
                <td>${inasistencia.nombre_aprendiz}</td>
                <td>${inasistencia.fecha_inasistencia}</td>
                <td>${inasistencia.nombre_usuario}</td>
                <td>${inasistencia.estado_excusa}</td>
                <td>${inasistencia.options}</td>`;
      });
    });
}

///////////////////////////////////////////////////////////
// ---------- ADJUNTAR/EDITAR/ELIMINAR EXCUSA--------------
///////////////////////////////////////////////////////////

document.addEventListener("click", (e) => {
  try {
    let selected = e.target
      .closest("button")
      .getAttribute("data-action-type"); /* 
    let idusuario = e.target.closest("button").getAttribute("rel"); */

    if (selected == "adjuntar") {
      /* 
      document.getElementById("ExcusaModalLabel").innerHTML = "Agregar Usuario"; */
      $("#subirExcusaModal").modal("show");
    }

    if (selected == "update") {
      /* 
      console.log(idAprendiz.value); */
      let idexcusa = e.target.closest("button").getAttribute("rel");
      console.log(idexcusa);
      $("#subirExcusaModal").modal("show");
      document.getElementById("ExcusaModalLabel").innerHTML =
        "Actualizar Excusa";

      fetch(base_url + `/excusas/getExcusaByID/${idexcusa}`, {
        method: "GET",
      })
        .then((res) => res.json())
        .then((res) => {
          let excusa = res.data[0];
          console.log(excusa.idexcusa);
          console.log(excusa.aprendices_idusuario);
          console.log(excusa.registro_inasistencias_idregistro);

          document.querySelector("#idexcusa").value = excusa.idexcusa;
          document.querySelector("#idAprendiz").value =
            excusa.aprendices_idusuario;
          document.querySelector("#idInasistencia").value =
            excusa.registro_inasistencias_idregistro;
        });
    }

    if (selected == "delete") {
      Swal.fire({
        title: "Eliminar excusa",
        text: "¿Desea eliminar esta excusa?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Sí",
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
          let formData = new FormData();
          formData.append("idExcusa", idExcusa);
          console.log(formData);
          fetch(base_url + "/excusas/deleteExcusa", {
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
              listUsuarios();
            });
        }
      });
    }
  } catch (e) {}
});

/////////////////////////////////////////////////////////
// ---------- LIMPIAR FORMULARIO AL CERRAR --------------
/////////////////////////////////////////////////////////

function limpiarFormulario() {
  frmExcusas.reset();
}

btnCerrar.addEventListener("click", limpiarFormulario);
btnEquis.addEventListener("click", limpiarFormulario);

///////////////////////////////////////////////
// -------------- CARGAR DATOS ----------------
///////////////////////////////////////////////

window.addEventListener("DOMContentLoaded", (e) => {
  listInasistencias();
  listExcusas();
});

///////////////////////////////////////////////
// ------------- ENVIO DE DATOS ---------------
///////////////////////////////////////////////

frmExcusas.addEventListener("submit", (e) => {
  e.preventDefault();
  frmData = new FormData(frmExcusas);
  console.log(frmExcusas.idexcusa.value);
  console.log(frmExcusas.idAprendiz);
  console.log(frmExcusas.idInasistencia);
  console.log(frmExcusas.excusa);

  fetch(base_url + "/excusas/setExcusas", {
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
        frmExcusas.reset();
        $("#subirExcusaModal").modal("hide");
        listInasistencias();
      }
    });
});
