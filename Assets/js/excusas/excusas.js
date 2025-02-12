/* const btnUsuario = document.querySelector("#btnUsuario");
let frmUsuarios = document.querySelector("#frmUsuarios"); */

const numdoc = document.querySelector("#numdoc_usuario");
const select_roles = document.getElementById("roles_idrol");

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
      console.log(data);
      data.forEach((excusa) => {
        console.log(excusa.nombre_aprendiz);
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

////////////////////////////////////////////////
// -------------- MOSTRAR EXCUSA ---------------
////////////////////////////////////////////////
document.addEventListener("click", (e) => {
  try {
    let selected = e.target.closest("button").getAttribute("data-action-type");
    let idexcusa = e.target.closest("button").getAttribute("rel");

    if (selected == "excusa") {
      console.log(idexcusa);
      fetch(base_url + `/excusas/mostrarExcusaDescargaDirecta?idexcusa=${idexcusa}`, {
        method: "GET",
      }); /* 
        .then((data) => data.json())
        .then((data) => {
          console.log(data);
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
      console.log(data);
      data.forEach((inasistencia) => {
        console.log(inasistencia.fecha_inasistencia);
        /* let estadoExcusa = "";
        if (inasistencia.estado_inasistencia === "Sin excusa") {
          estadoExcusa = `<span class="badge rounded-pill text-bg-secondary">${inasistencia.estado_inasistencia}</span>`;
        } else if (
          inasistencia.estado_inasistencia === "Enviada" ||
          inasistencia.estado_inasistencia === "Por revisar"
        ) {
          estadoExcusa = `
            <span class="badge rounded-pill text-bg-info">${inasistencia.estado_inasistencia}</span>
          `;
        } else if (inasistencia.estado_inasistencia === "Aprobada") {
          estadoExcusa = `<span class="badge rounded-pill text-bg-success">
              ${inasistencia.estado_inasistencia}
            </span>`;
        } else if (inasistencia.estado_inasistencia === "Rechazada") {
          estadoExcusa = `<span class="badge rounded-pill text-bg-danger">
              ${inasistencia.estado_inasistencia}
            </span>`;
        } */
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

////////////////////////////////////////////////
// --------------- ABRIR MODAL -----------------
////////////////////////////////////////////////

/* btnUsuario.addEventListener("click", () => {
  numdoc.readOnly = false;
  select_roles.innerHTML = "<option selected disabled>Seleccione el rol</option>";
  listarRoles();
  document.getElementById("UsuarioModalLabel").innerHTML = "Agregar Usuario";
  $("#crearUsuarioModal").modal("show");
}); */

///////////////////////////////////////////////
// ------------- ENVIO DE DATOS ---------------
///////////////////////////////////////////////

frmExcusas.addEventListener("submit", (e) => {
  e.preventDefault();
  frmData = new FormData(frmExcusas);
  console.log(frmData);
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

///////////////////////////////////////////////
// ---------- EDITAR Y ELIMINAR --------------
///////////////////////////////////////////////

document.addEventListener("click", (e) => {
  try {
    let selected = e.target.closest("button").getAttribute("data-action-type"); /* 
    let idusuario = e.target.closest("button").getAttribute("rel"); */

    if (selected == "adjuntar") {
      /* 
      document.getElementById("ExcusaModalLabel").innerHTML = "Agregar Usuario"; */
      $("#subirExcusaModal").modal("show");
    }
  } catch (e) {}
});

//////////////////////////////////////////////////
// -------------- APROBAR EXCUSAS ----------------
//////////////////////////////////////////////////

frmExcusas.addEventListener("submit", (e) => {
  e.preventDefault();
  let frmData = new FormData();
  frmData.append("estado_excusa", "aprobada");
  console.log(frmData);
  fetch(base_url + "/excusas/aprobarExcusa", {
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

//////////////////////////////////////////////////
// -------------- RECHAZAR EXCUSAS ---------------
//////////////////////////////////////////////////

frmExcusas.addEventListener("submit", (e) => {
  e.preventDefault();
  let frmData = new FormData();
  frmData.append("estado_excusa", "rechazada");
  console.log(frmData);
  fetch(base_url + "/excusas/rechazarExcusa", {
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
