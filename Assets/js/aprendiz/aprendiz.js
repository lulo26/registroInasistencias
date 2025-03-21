const frmAprendiz = document.querySelector("#frmAprendiz");
const aprendicesUrl = "http://localhost/registroInasistencias/aprendiz/";
let btnCrearAprendiz = document.querySelector("#btnCrearAprendiz");
let btnCerrarModal = document.querySelector(".close");
let btnCancelarModal = document.querySelector("[data-dismiss='modal']");

let accion = "";


btnCrearAprendiz.addEventListener("click", () => {
  accion = "create";
  frmAprendiz.reset(); // Limpiar el formulario
  document.getElementById("crearAprendizModalLabel").innerHTML = "Crear Usuario";
  $("#crearAprendizModal").modal("show");
});


[btnCerrarModal, btnCancelarModal].forEach((btn) => {
  btn.addEventListener("click", () => {
    $("#crearAprendizModal").modal("hide");
  });
});


// Listar aprendices
function listAprendices() {
  fetch(aprendicesUrl + "/getAprendices")
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
              <button class="btn btn-warning btn-sm" data-action-type="update" rel="${aprendiz.idaprendiz}">Editar</button>
              <button class="btn btn-danger btn-sm" data-action-type="delete" rel="${aprendiz.idaprendiz}">Eliminar</button>
            </td>
          </tr>`;
      });
    });
}

frmAprendiz.addEventListener("submit", (e) => {
  e.preventDefault();
  let frmData = new FormData(frmAprendiz);
  let url = accion === "update" ? aprendicesUrl + "/updateAprendices" : aprendicesUrl + "/setAprendices";

  fetch(url, { method: "POST", body: frmData })
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


document.addEventListener("click", (e) => {
  let btn = e.target.closest("button");
  if (!btn) return;

  let selected = btn.getAttribute("data-action-type");
  let idAprendiz = btn.getAttribute("rel");

  if (selected === "delete") {
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

        fetch(aprendicesUrl + "eliminarAprendiz/", {
          method: "POST",
          body: formData,
        })
          .then((res) => res.json())
          .then((data) => {
            Swal.fire({
              title: data.status ? "Correcto" : "Error",
              text: data.msg,
              icon: data.status ? "success" : "error",
            }).then(() => {
              if (data.status) {
                listAprendices(); // Recargar 
              }
            });
          });
      }
    });
  }

  if (selected === "update") {
    accion = "update";
    document.getElementById("crearAprendizModalLabel").innerHTML = "Actualizar Aprendiz";
    $("#crearAprendizModal").modal("show");

    fetch(aprendicesUrl + `getAprendizByID/${idAprendiz}`, { method: "GET" })
      .then((res) => res.json())
      .then((res) => {
        let aprendiz = res.data[0];

        document.querySelector("#idAprendiz").value = aprendiz.idaprendiz;
        document.querySelector("#numeroDocumentoAprendiz").value = aprendiz.numdoc;
        document.querySelector("#nombreAprendiz").value = aprendiz.nombre_aprendiz;
        document.querySelector("#apellidoAprendiz").value = aprendiz.apellido_aprendiz;
        document.querySelector("#generoAprendiz").value = aprendiz.generos_idgenero;
        document.querySelector("#codigoAprendiz").value = aprendiz.codigo_aprendiz;
      });
  }
});


window.addEventListener("DOMContentLoaded", listAprendices);
