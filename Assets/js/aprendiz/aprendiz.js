const frmAprendiz = document.querySelector("#frmAprendiz");
const aprendicesUrl = "http://localhost/registroInasistencias/aprendiz/";
let idAprendiz = document.querySelector("#idAprendiz");
let btnCrearAprendiz = document.querySelector("#btnCrearAprendiz");
let nombreAprendiz = document.querySelector("#nombreAprendiz");
let apellidoAprendiz = document.querySelector("#apellidoAprendiz");
let generoAprendiz = document.querySelector("#generoAprendiz");
let numeroDocumentoAprendiz = document.querySelector(
  "#numeroDocumentoAprendiz"
);
let accion = "";

btnCrearAprendiz.addEventListener("click", () => {
  $("#crearAprendizModal").modal("show");
});

console.log("hello word");

function listAprendices() {
  let nada = "rtr";
  fetch(aprendicesUrl + "/getAprendices")
    .then((data) => data.json())
    .then((data) => {
      console.log(data);
      data.forEach((aprendiz) => {
        document.getElementById("tablaAprendiz").innerHTML += `
            <tr>
            <td>${aprendiz.idaprendiz}</td>
            <td>${aprendiz.numdoc}</td>
            <td>${aprendiz.nombre_aprendiz}</td>
            <td>${aprendiz.apellido_aprendiz}</td>
            <td>${aprendiz.generos_idgenero}</td>
            <td>${aprendiz.actions}</td>
            <tr/>`;
      });
    });
}

//Insertar

frmAprendiz.addEventListener("submit", (e) => {
  e.preventDefault();
  frmData = new FormData(frmAprendiz);
  console.log(frmData);
  fetch(aprendicesUrl + "/setAprendices", {
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
        frmAprendiz.reset();
        $("#crearAprendizModal").modal("hide");
        listAprendices();
      }
    });
});

/* frmAprendiz.addEventListener("submit", (e) => {
  e.preventDefault();
  frmData = new FormData(frmAprendiz);
  console.log(frmData);
  fetch(aprendicesUrl + "/setAprendices", {
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
        frmAprendiz.reset();
        $("#crearAprendizModal").modal("hide");
        listAprendices();
      }
    });
}); */

window.addEventListener("DOMContentLoaded", (e) => {
  listAprendices();
});

document.addEventListener("click", (e) => {
  try {
    let selected = e.target.closest("button").getAttribute("data-action-type");
    let idAprendiz = e.target.closest("button").getAttribute("rel");

    if (selected == "delete") {
      Swal.fire({
        title: "Eliminar aprendiz",
        text: "¿Está seguro de eliminar el aprendiz?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Sí",
        denyButtonText: `Cancelar`,
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
              });
            });
        }
      });
    }

    if (selected == "update") {
      accion = "update";
      $("#crearAprendizModal").modal("show");
      document.getElementById("crearAprendizModalLabel").innerHTML =
        "Actualizar Aprendiz";

      fetch(aprendicesUrl + `getAprendizByID/` + idAprendiz, {
        method: "GET",
      })
        .then((res) => res.json())
        .then((res) => {
          aprendiz = res.data[0];
          console.log(aprendiz);

          document.querySelector("#numeroDocumentoAprendiz").value =
            aprendiz.numdoc;
          document.querySelector("#nombreAprendiz").value =
            aprendiz.nombre_aprendiz;
          document.querySelector("#apellidoAprendiz").value =
            aprendiz.apellido_aprendiz;
          document.querySelector("#generoAprendiz").value =
            aprendiz.generos_idgenero;

          /*  document.querySelector(
            "#generoAprendiz"
          ).innerHTML = `<option selected hidden value="${aprendiz.generos_idgenero}">${aprendiz.generos_idgenero}</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
          <option value="Otros">Otros..</option>`; */
        });
    }
  } catch { }
});

//Actualizar

if (accion == "update") {
  frmAprendiz.addEventListener("submit", (e) => {
    e.preventDefault();
    frmData = new FormData(frmAprendiz);
    console.log(frmData);
    fetch(aprendicesUrl + "/updateAprendices", {
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
          frmAprendiz.reset();
          $("#crearAprendizModal").modal("hide");
          listAprendices();
        }
      });
  });
}
