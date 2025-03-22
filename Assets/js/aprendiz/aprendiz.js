const frmAprendiz = document.querySelector("#frmAprendiz");
const frmActualizarAprendiz = document.querySelector("#frmActualizarAprendiz");
const aprendicesUrl = "http://localhost/registroInasistencias/aprendiz/";
let btnCrearAprendiz = document.querySelector("#btnCrearAprendiz");

let idAprendizSeleccionado = null;

// Abrir modal de creación
btnCrearAprendiz.addEventListener("click", () => {
  frmAprendiz.reset();
  $("#crearAprendizModal").modal("show");
});

// Cargar la lista de aprendices
function listAprendices() {
  fetch(aprendicesUrl + "getAprendices")
    .then((data) => data.json())
    .then((data) => {
      let tabla = document.querySelector("#tablaAprendiz tbody");
      tabla.innerHTML = "";

      data.forEach((aprendiz) => {
        tabla.innerHTML += `
          <tr>
            <td>${aprendiz.idaprendiz}</td>
            <td>${aprendiz.numdoc}</td>
            <td>${aprendiz.nombre_aprendiz}</td>
            <td>${aprendiz.apellido_aprendiz}</td>
            <td>${aprendiz.generos_idgenero}</td>
            <td>
              <button class="btn btn-warning btn-sm btn-editar" data-id="${aprendiz.idaprendiz}">Editar</button>
              <button class="btn btn-danger btn-sm btn-eliminar" data-id="${aprendiz.idaprendiz}">Eliminar</button>
            </td>
          </tr>`;
      });

      // Agregar eventos 
      document.querySelectorAll(".btn-editar").forEach((btn) => {
        btn.addEventListener("click", (e) => editarAprendiz(e.target.dataset.id));
      });

      document.querySelectorAll(".btn-eliminar").forEach((btn) => {
        btn.addEventListener("click", (e) => eliminarAprendiz(e.target.dataset.id));
      });
    });
}


function editarAprendiz(idAprendiz) {
  idAprendizSeleccionado = idAprendiz;
  $("#actualizarAprendizModal").modal("show");

  fetch(aprendicesUrl + `getAprendizByID/${idAprendiz}`)
    .then((res) => res.json())
    .then((res) => {
      let aprendiz = res.data[0];

      document.querySelector("#idAprendiz1").value = aprendiz.idaprendiz;
      document.querySelector("#numeroDocumentoAprendiz1").value = aprendiz.numdoc;
      document.querySelector("#nombreAprendiz1").value = aprendiz.nombre_aprendiz;
      document.querySelector("#apellidoAprendiz1").value = aprendiz.apellido_aprendiz;
      document.querySelector("#generoAprendiz1").value = aprendiz.generos_idgenero;
      document.querySelector("#codigoAprendiz1").value = aprendiz.codigo_aprendiz;
    });
}

// Función para eliminar aprendiz
function eliminarAprendiz(idAprendiz) {
  Swal.fire({
    title: "Eliminar aprendiz",
    text: "¿Está seguro de eliminar el aprendiz?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      let formData = new FormData();
      formData.append("idAprendiz", idAprendiz);

      fetch(aprendicesUrl + "eliminarAprendiz/", { method: "POST", body: formData })
        .then((res) => res.json())
        .then((data) => {
          Swal.fire({
            title: data.status ? "Correcto" : "Error",
            text: data.msg,
            icon: data.status ? "success" : "error",
          }).then(() => {
            if (data.status) listAprendices();
          });
        });
    }
  });
}


frmAprendiz.addEventListener("submit", (e) => {
  e.preventDefault();

  let frmData = new FormData(frmAprendiz);

  fetch(aprendicesUrl + "setAprendices", { method: "POST", body: frmData })
    .then((res) => res.json())
    .then((data) => {
      Swal.fire({
        title: data.status ? "Correcto" : "Error",
        text: data.msg,
        icon: data.status ? "success" : "error",
      }).then(() => {
        if (data.status) {
          frmAprendiz.reset();
          $("#crearAprendizModal").modal("hide");
          listAprendices();
        }
      });
    });
});

frmActualizarAprendiz.addEventListener("submit", (e) => {
  e.preventDefault();

  let frmData = new FormData(frmActualizarAprendiz);
  frmData.append("idAprendiz1", idAprendizSeleccionado);

  // Verificar los datos antes de enviarlos
  console.log("Datos enviados:");
  frmData.forEach((value, key) => {
    console.log(`${key}: ${value}`);
  });

  fetch(aprendicesUrl + "updateAprendices", { method: "POST", body: frmData })
    .then((res) => res.json())
    .then((data) => {
      console.log("Respuesta del servidor:", data);
      Swal.fire({
        title: data.status ? "Correcto" : "Error",
        text: data.msg,
        icon: data.status ? "success" : "error",
      }).then(() => {
        if (data.status) {
          frmActualizarAprendiz.reset();
          $("#actualizarAprendizModal").modal("hide");
          listAprendices();
        }
      });
    });
});



window.addEventListener("DOMContentLoaded", listAprendices);
