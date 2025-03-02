let idexcusa = document.querySelector("#idexcusa");
let idAprendiz = document.querySelector("#idAprendiz");
let idInasistencia = document.querySelector("#idInasistencia");

const btnCerrar = document.getElementById("btnCerrar");
const btnEquis = document.getElementById("btnEquis");

const tablaInasistencias = document.getElementById("tablaInasistencias");
const tablaExcusas = document.getElementById("tablaExcusas");
/* 
const verMotivo = document.getElementById("verMotivo"); */

/* fetch(base_url + "/excusas/getUsuarioByID")
  .then((res) => res.json)
  .then((res) => {
    if (res.status) {
      usuario = res.data;
      if (usuario.rol === "INSTRUCTOR") {
      } else if (usuario.rol === "APRENDIZ") {
      }
    }
  }); */

////////////////////////////////////////////////
// -------------- LISTAR EXCUSAS ---------------
////////////////////////////////////////////////

function listExcusas() {
  tablaExcusas.innerHTML = "";
  let idInstructor = 1;
  /* fetch(base_url + `/excusas/getExcusasPorInstructor/${idusuario}`, {
    method: "GET",
  }) */
  fetch(base_url + `/excusas/getExcusasPorInstructor/${idInstructor}`, {
    method: "GET",
  })
    .then((res) => res.json())
    .then((res) => {
      let excusas = res.data;

      if (res.status === true) {
        excusas.forEach((excusa) => {
          let opciones = { year: "numeric", month: "long", day: "numeric" };
          let fecha_inasistencia = new Date(excusa.fecha_inasistencia).toLocaleDateString(
            "es",
            opciones
          );
          let fecha_excusa = new Date(excusa.fecha_excusa).toLocaleDateString("es", opciones);
          tablaExcusas.innerHTML += `
                  <td>${fecha_inasistencia}</td>
                  <td>${excusa.nombre_aprendiz}</td>
                  <td>${excusa.nombre_curso}</td>
                  <td>${excusa.numero_ficha}</td>
                  <td>${fecha_excusa}</td>
                  <td>${excusa.excusa}</td>
                  <td>${excusa.options}</td>`;
        });
      } else {
        tablaExcusas.innerHTML = `
                  <td colspan="7" align="center">${excusas.msg}</td>`;
      }
    });
}

/////////////////////////////////////////////////////////////////
// ------------- DESCARGAR/APROBAR/RECHAZAR EXCUSA --------------
/////////////////////////////////////////////////////////////////

document.addEventListener("click", (e) => {
  try {
    let selected = e.target.closest("button").getAttribute("data-action-type");
    let idexcusa = e.target.closest("button").getAttribute("rel");
    /* console.log(idexcusa); */

    if (selected == "descargar") {
      /* console.log(idexcusa); */
      fetch(base_url + `/excusas/descargarExcusa?idexcusa=${idexcusa}`, {
        method: "GET",
      })
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
              listExcusas();
            });
        }
      });
    }

    if (selected == "rechazar") {
      let idexcusa = e.target.closest("button").getAttribute("rel");

      document.getElementById("RechazarModalLabel").textContent = "Rechazar Excusa";
      document.getElementById("btnRechazar").style.display = "inline";

      let txtMotivo = document.querySelector("#motivo_rechazo");
      txtMotivo.readOnly = false;
      txtMotivo.value = "";

      $("#rechazarExcusaModal").modal("show");
      document.querySelector("#idexcusa").value = idexcusa;
      console.log("Rechazar");
      console.log("ID excusa: " + idexcusa);

      /* idexcusa.value = e.target.closest("button").getAttribute("rel"); */

      /* Swal.fire({
        title: "Rechazar excusa",
        text: "¿Desea rechazar esta excusa?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Sí",
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
          let formData = new FormData();
          formData.append("idexcusa", idexcusa);
          console.log(formData);
          fetch(base_url + "/excusas/rechazarExcusa", {
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
              listExcusas();
            });
        }
      }); */
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
      let contadorInas = data.length + 1;
      data.forEach((inasistencia) => {
        idexcusa.value = inasistencia.idexcusa;
        idAprendiz.value = inasistencia.aprendices_idusuario;
        idInasistencia.value = inasistencia.idregistro;
        let opciones = { year: "numeric", month: "long", day: "numeric" };
        let fecha = new Date(inasistencia.fecha_inasistencia).toLocaleDateString("es", opciones);

        contadorInas = contadorInas - 1;

        /* if (verMotivo) {
          console.log("yasta");
          verMotivo.addEventListener("click", (e) => {
            $("#rechazarExcusaModal").modal("show");
            let txtMotivo = document.querySelector("#motivo_rechazo");
            txtMotivo.readOnly = true;
            txtMotivo.text = inasistencia.motivo_rechazo;
          });
        } */

        tablaInasistencias.innerHTML += `
                <td>${contadorInas}</td>
                <td>${fecha}</td>
                <td>${inasistencia.nombre_usuario}</td>
                <td>${inasistencia.estado_excusa}</td>
                <td>${inasistencia.options}</td>`;
      });
    });
}

///////////////////////////////////////////////////////////
// ------------ ADJUNTAR/EDITAR/ELIMINAR EXCUSA------------
///////////////////////////////////////////////////////////

document.addEventListener("click", (e) => {
  try {
    // Busca el elemento más cercano que sea un <button> o un <a>
    let selectedButton = e.target.closest("button");
    let selectedLink = e.target.closest("a");

    // Si el elemento más cercano es un botón, obtenemos el data-action-type
    if (selectedButton) {
      let action = selectedButton.getAttribute("data-action-type");
      console.log(action);
      if (action == "adjuntar") {
        console.log("click");
        /* 
        document.getElementById("ExcusaModalLabel").innerHTML = "Agregar Usuario"; */
        $("#subirExcusaModal").modal("show");
      }

      if (action == "update") {
        /* 
        console.log(idAprendiz.value); */
        let idexcusa = e.target.closest("button").getAttribute("rel");
        console.log(idexcusa);
        $("#subirExcusaModal").modal("show");
        document.getElementById("ExcusaModalLabel").innerHTML = "Actualizar Excusa";

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
            document.querySelector("#idAprendiz").value = excusa.aprendices_idusuario;
            document.querySelector("#idInasistencia").value =
              excusa.registro_inasistencias_idregistro;
          });
      }

      if (action == "delete") {
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
    }
    // Si el elemento más cercano es un enlace, también obtenemos el data-action-type
    else if (selectedLink) {
      let action = selectedLink.getAttribute("data-action-type");
      console.log(action);

      if (action == "verMotivo") {
        let idexcusa = selectedLink.getAttribute("data-idexcusa");
        if (idexcusa > 0) {
          fetch(base_url + `/excusas/getMotivoRechazo/${idexcusa}`, {
            method: "GET",
          })
            .then((res) => res.json())
            .then((res) => {
              let excusa = res.data[0];

              if (res.status === true) {
                console.log(excusa);

                document.getElementById("RechazarModalLabel").textContent = "Excusada Rechazada";
                document.getElementById("btnRechazar").style.display = "none";

                $("#rechazarExcusaModal").modal("show");
                let txtMotivo = document.querySelector("#motivo_rechazo");
                txtMotivo.readOnly = true;
                txtMotivo.value = excusa.motivo_rechazo;
              } else {
                console.log("Error al traer el motivo de rechazo de la excusa");
              }
            });
        }
      }
    }

    /* let verMotivo = document.getElementById("verMotivo"); */

    /* verMotivo.addEventListener("click", (e) => { */
    /* let idexcusa = verMotivo.getAttribute("data-idexcusa"); */

    /* if (idexcusa > 0) {
      fetch(base_url + `/excusas/getMotivoRechazo/${idexcusa}`, {
        method: "GET",
      })
        .then((res) => res.json())
        .then((res) => {
          let excusa = res.data[0];

          if (res.status === true) {
            console.log(excusa);

            document.getElementById("RechazarModalLabel").textContent = "Excusada Rechazada";
            document.getElementById("btnRechazar").style.display = "none";

            $("#rechazarExcusaModal").modal("show");
            let txtMotivo = document.querySelector("#motivo_rechazo");
            txtMotivo.readOnly = true;
            txtMotivo.value = excusa.motivo_rechazo;
          } else {
            console.log("Error al traer el motivo de rechazo de la excusa");
          }
        });
    } */

    /* }); */
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
  frmData = new FormData(frmExcusas); /* 
  console.log(frmExcusas.idexcusa.value);
  console.log(frmExcusas.idAprendiz);
  console.log(frmExcusas.idInasistencia);
  console.log(frmExcusas.excusa); */

  fetch(base_url + "/excusas/setExcusas", {
    method: "POST",
    body: frmData,
  })
    .then((res) => res.json())
    .then((data) => {
      /* 
      console.log(data); */
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

frmMotivoRechazo.addEventListener("submit", (e) => {
  e.preventDefault();
  console.log(idexcusa.value);
  const motivo_rechazo = document.querySelector("#motivo_rechazo");
  if (motivo_rechazo.value.trim() == "") {
    Swal.fire({
      title: "¡Error!",
      text: "Llene el motivo del rechazo de la excusa.",
      icon: "error",
    });
  } else {
    let idexcusa = document.querySelector("#idexcusa").value;
    let motivo_rechazo = document.querySelector("#motivo_rechazo").value;
    console.log(idexcusa, motivo_rechazo);
    frmData = new FormData();
    frmData.append("idexcusa", idexcusa);
    frmData.append("motivo_rechazo", motivo_rechazo);
    fetch(base_url + "/excusas/rechazarExcusa", {
      method: "POST",
      body: frmData,
    })
      .then((res) => res.json())
      .then((data) => {
        /* 
        console.log(data); */
        Swal.fire({
          title: data.status ? "¡Correcto!" : "¡Error!",
          text: data.msg,
          icon: data.status ? "success" : "error",
        });
        if (data.status) {
          frmMotivoRechazo.reset();
          $("#rechazarExcusaModal").modal("hide");
          listExcusas();
        }
      });
  }
});
