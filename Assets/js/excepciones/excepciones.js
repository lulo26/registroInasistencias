const input_fecha = document.getElementById("fecha_excep");
const select_fichas = document.getElementById("fichas_idficha");
const select_bloques = document.getElementById("bloques_idbloque");

let arrayUsuario = "";
let idUsuario;
let rolUsuario;

const btnCerrar = document.getElementById("btnCerrar");
const btnEquis = document.getElementById("btnEquis");

/////////////////////////////////////////////////////////
// ---------- LIMPIAR FORMULARIO AL CERRAR --------------
/////////////////////////////////////////////////////////

function limpiarFormulario() {
  frmExcepciones.reset();
  div_otro_motivo.hidden = true;
  div_hora_entrada.hidden = true;
  div_hora_salida.hidden = true;
}

btnCerrar.addEventListener("click", limpiarFormulario);
btnEquis.addEventListener("click", limpiarFormulario);

////////////////////////////////////////////////
// ----------------- EVENTOS -------------------
////////////////////////////////////////////////

document.addEventListener("DOMContentLoaded", () => {
  div_otro_motivo.hidden = true;
  div_hora_entrada.hidden = true;
  div_hora_salida.hidden = true;

  obtenerUsuario();
  /* if (rolUsuario === "INSTRUCTOR") {
  } else  */
  listarFichas();
});

input_fecha.addEventListener("change", () => {
  console.log("tastt"); /* 
  select_fichas.innerHTML = "<option selected disabled>Seleccione una ficha</option>"; */
  let fechaValidar = input_fecha.value;
  listarFichasPorFecha(fechaValidar);
});

function obtenerUsuario() {
  fetch(base_url + "/excepciones/getUsuarioByID")
    .then((res) => res.json())
    .then((res) => {
      if (res.status) {
        arrayUsuario = res.data[0];
        idUsuario = arrayUsuario.idusuario;
        rolUsuario = arrayUsuario.rol_usuario;
        /* if (arrayUsuario.rol_usuario === "INSTRUCTOR") {
        console.log(rolUsuario);
        listExcepciones(idUsuario);
      } else if (arrayUsuario.rol_usuario === "COORDINADOR") {
        console.log(rolUsuario);
      } */
        select_fichas.innerHTML = "<option selected disabled>Seleccione una ficha</option>";
        if (rolUsuario === "COORDINADOR") {
          select_fichas.innerHTML += "<option value=''>Excepcion general</option>";
        }
        listExcepciones(idUsuario);
      } else {
        console.log("Status: " + res.status + ". " + res.msg);
      }
    });
}

/////////////////////////////////////////////////
// ---------- CARGAR SELECT DE FICHAS -----------
/////////////////////////////////////////////////

function listarFichas() {
  fetch(base_url + "/excepciones/getFichasByUserID")
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      let arrayFichas = data.data;
      /* Colocar la linea de abajo en el evento que desencadene esta funcion */
      /* select_fichas.innerHTML = ""; */

      if (arrayFichas) {
        arrayFichas.forEach((ficha) => {
          select_fichas.innerHTML += `<option value="${ficha.idficha}">${ficha.numero_ficha} - ${ficha.nombre_curso}</option>`;
        });
      }
    });
}

/* REVISAR ESTA FUNCION, (CONSULTA EN EL MODEL) PARA TRAER LAS FICHAS POR LA FECHA SELECIONADA */
function listarFichasPorFecha(fechaValidar) {
  let formData = new FormData();
  formData.append("fecha", fechaValidar);
  fetch(base_url + "/excepciones/getFichasByDate", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      select_fichas.innerHTML = "<option selected disabled>Seleccione una ficha</option>";
      if (!data.status) {
        if (rolUsuario === "COORDINADOR") {
          select_fichas.innerHTML += "<option value='0'>Excepcion general</option>";
        } else if (rolUsuario === "INSTRUCTOR") {
          select_fichas.innerHTML += `<option disabled>Sin fichas en fecha seleccionada</option>`;
        }
      } else {
        let arrayFichas = data.data;

        arrayFichas.forEach((ficha) => {
          select_fichas.innerHTML += `<option value="${ficha.idficha}">${ficha.numero_ficha} - ${ficha.nombre_curso}</option>`;
        });
      }
    });
}

////////////////////////////////////////////////
// ------------ LISTAR EXCEPCIONES -------------
////////////////////////////////////////////////

function listExcepciones(idUsuario) {
  tablaExcepciones.innerHTML = "";
  if (rolUsuario === "INSTRUCTOR") {
    fetch(base_url + `/excepciones/getExcepByInstructor/${idUsuario}`, {
      method: "GET",
    })
      .then((res) => res.json())
      .then((res) => {
        let excepciones = res.data;

        if (res.status === true) {
          excepciones.forEach((excepcion) => {
            let opciones = { year: "numeric", month: "long", day: "numeric" };
            let fecha = new Date(excepcion.fecha).toLocaleDateString("es", opciones);
            tablaExcepciones.innerHTML += `
                    <td>${excepcion.idexcepcion}</td>
                    <td>${fecha}</td>
                    <td>${excepcion.motivo_excepcion}</td>
                    <td>${excepcion.nombre_usuario}</td>
                    <td>${mayusInicial(excepcion.rol_usuario)}</td>
                    <td>${excepcion.bloques_idbloque}</td>
                    <td>${excepcion.hora_bloque}</td>
                    <td>${excepcion.ficha}</td>
                    <td>${excepcion.options}</td>`;
          });
        } else {
          tablaExcepciones.innerHTML = `
                    <td colspan="8" align="center">${excepciones.msg}</td>`;
        }
      });
  } else if (rolUsuario === "COORDINADOR") {
    fetch(base_url + `/excepciones/getExcepciones`, {
      method: "GET",
    })
      .then((res) => res.json())
      .then((res) => {
        let excepciones = res.data;

        if (res.status === true) {
          excepciones.forEach((excepcion) => {
            let opciones = { year: "numeric", month: "long", day: "numeric" };
            let fecha = new Date(excepcion.fecha).toLocaleDateString("es", opciones);
            tablaExcepciones.innerHTML += `
                    <td>${excepcion.idexcepcion}</td>
                    <td>${fecha}</td>
                    <td>${excepcion.motivo_excepcion}</td>
                    <td>${excepcion.nombre_usuario}</td>
                    <td>${mayusInicial(excepcion.rol_usuario)}</td>
                    <td>${excepcion.bloques_idbloque}</td>
                    <td>${excepcion.hora_bloque}</td>
                    <td>${excepcion.ficha}</td>
                    <td>${excepcion.options}</td>`;
          });
        } else {
          tablaExcepciones.innerHTML = `
                    <td colspan="8" align="center">${excepciones.msg}</td>`;
        }
      });
  }
}

////////////////////////////////////////////////
// --------------- ABRIR MODAL -----------------
////////////////////////////////////////////////

btnExcepcion.addEventListener("click", () => {
  /* 
    document.getElementById("UsuarioModalLabel").innerHTML = "Agregar Usuario"; */
  $("#crearExcepModal").modal("show");
});

///////////////////////////////////////////////
// ------------- ENVIO DE DATOS ---------------
///////////////////////////////////////////////

frmExcepciones.addEventListener("submit", (e) => {
  e.preventDefault();

  if (select_fichas.value === "Seleccione una ficha") {
    Swal.fire({
      title: "¡Atencion!",
      text: "Por favor, seleccione una ficha.",
      icon: "warning",
    });
  } else if (select_motivo.value === "Seleccione un motivo") {
    Swal.fire({
      title: "¡Atencion!",
      text: "Por favor, seleccione un motivo.",
      icon: "warning",
    });
  } else if (select_motivo.value === "Otro" && otro_motivo.value === "") {
    Swal.fire({
      title: "¡Atencion!",
      text: "Por favor, indique el motivo de la excepción.",
      icon: "warning",
    });
  } else if (select_motivo.value === "Entrada tarde" && hora_entrada.value === "") {
    Swal.fire({
      title: "¡Atencion!",
      text: "Por favor, seleccione una hora.",
      icon: "warning",
    });
  } else if (select_motivo.value === "Salida temprano" && hora_salida.value === "") {
    Swal.fire({
      title: "¡Atencion!",
      text: "Por favor, seleccione una hora.",
      icon: "warning",
    });
  } else if (select_bloques.value === "Seleccione un bloque") {
    Swal.fire({
      title: "¡Atencion!",
      text: "Por favor, seleccione una bloque.",
      icon: "warning",
    });
  } else {
    frmData = new FormData(frmExcepciones);
    frmData.append("usuarios_idusuario", idUsuario);
    console.log("ID Excepción: " + frmData.get("idexcepcion"));
    console.log("Fecha: " + frmData.get("fecha_excep"));

    /* console.log(frmData.get("motivo_excep")); */

    console.log("ID del Usuario: " + frmData.get("usuarios_idusuario"));
    console.log("ID Bloque: " + frmData.get("bloques_idbloque"));
    console.log("ID Ficha: " + frmData.get("fichas_idficha"));

    console.log("Motivo seleccionado: " + frmData.get("select_motivo"));
    console.log("Otro motivo: " + frmData.get("otro_motivo"));
    console.log("Hora entrada: " + frmData.get("hora_entrada"));
    console.log("Hora salida: " + frmData.get("hora_salida"));

    fetch(base_url + "/excepciones/setExcepciones", {
      method: "POST",
      body: frmData,
    })
      .then((res) => res.json())
      .then((data) => {
        /* console.log(data); */
        Swal.fire({
          title: data.status ? "¡Correcto!" : "¡Error!",
          text: data.msg,
          icon: data.status ? "success" : "error",
        });
        if (data.status) {
          /* frmExcepciones.reset(); */
          $("#crearExcepModal").modal("hide");
          limpiarFormulario();
          listExcepciones();
        }
      });
  }
});

///////////////////////////////////////////////
// ---------- EDITAR Y ELIMINAR --------------
///////////////////////////////////////////////

document.addEventListener("click", (e) => {
  try {
    let selected = e.target.closest("button").getAttribute("data-action-type");
    let idusuario = e.target.closest("button").getAttribute("rel");

    if (selected == "delete") {
      Swal.fire({
        title: "Eliminar usuario",
        text: "¿Está seguro de eliminar el usuario?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Sí",
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
          let formData = new FormData();
          formData.append("idusuario", idusuario);
          console.log(formData);
          fetch(base_url + "/usuarios/eliminarUsuario", {
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

    if (selected == "update") {
      numdoc.readOnly = true;
      /* const codigo = document.querySelector("#codigo_usuario");
      codigo.setAttribute("disabled", "true"); */

      let idusuario = e.target.closest("button").getAttribute("rel");
      $("#crearUsuarioModal").modal("show");
      document.getElementById("UsuarioModalLabel").innerHTML = "Actualizar Usuario";
      fetch(base_url + `/usuarios/getUsuarioByID/${idusuario}`, {
        method: "GET",
      })
        .then((res) => res.json())
        .then((res) => {
          let usuario = res.data[0];
          console.log(usuario);

          document.querySelector("#idusuario").value = usuario.idusuario;
          document.querySelector("#nombre_usuario").value = usuario.nombre_usuario;
          document.querySelector("#numdoc_usuario").value = usuario.numdoc_usuario;
          document.querySelector("#correo_usuario").value = usuario.correo_usuario;
          document.querySelector("#telefono_usuario").value = usuario.telefono_usuario;
          document.querySelector("#codigo_usuario").value = usuario.codigo_usuario;
          document.querySelector("#password_usuario").value = usuario.password_usuario;

          const roles = ["INSTRUCTOR", "COORDINADOR"];
          select_rol.innerHTML = "";

          roles.forEach((rol) => {
            let selected = usuario.rol_usuario == rol ? "selected" : "";
            select_rol.innerHTML += `<option ${selected} value="${rol}">${mayusInicial(
              rol
            )}</option>`;
          });

          /* fetch(base_url + `/usuarios/getRoles`, {
            method: "GET",
          })
            .then((res) => res.json())
            .then((data) => {
              select_roles.innerHTML = "";

              data.forEach((roles) => {
                let selected = usuario.roles_idrol == roles.idrol ? "selected" : "";
                select_roles.innerHTML += `<option ${selected} value="${roles.idrol}">${roles.nombre_rol}</option>`;
              });
            }); */
        });
    }
  } catch (e) {}
});

function mayusInicial(word) {
  return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
}

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////

const select_motivo = document.getElementById("select_motivo");
const otro_motivo = document.getElementById("otro_motivo");
const div_otro_motivo = document.getElementById("div_otro_motivo");

const hora_entrada = document.getElementById("hora_entrada");
const div_hora_entrada = document.getElementById("div_hora_entrada");

const hora_salida = document.getElementById("hora_salida");
const div_hora_salida = document.getElementById("div_hora_salida");

select_motivo.addEventListener("change", () => {
  if (select_motivo.value === "Otro") {
    console.log("Otro");
    div_otro_motivo.hidden = false;
    div_hora_entrada.hidden = true;
    div_hora_salida.hidden = true;
  } else if (select_motivo.value === "Entrada tarde") {
    console.log("Entrada tarde");
    div_hora_entrada.hidden = false;
    div_otro_motivo.hidden = true;
    div_hora_salida.hidden = true;
  } else if (select_motivo.value === "Salida temprano") {
    console.log("Salida temprano");
    div_hora_salida.hidden = false;
    div_otro_motivo.hidden = true;
    div_hora_entrada.hidden = true;
  }
});

/* if (select_motivo.value === "Otro") {
  if (otro_motivo.value === "") {
    Swal.fire({
      title: "¡Atencion!",
      text: "Por favor, indique el motivo de la excepción.",
      icon: "warning",
    });
  } else {
  }
} else if (select_motivo.value === "Entrada tarde") {
  if (hora_entrada.value === "") {
    Swal.fire({
      title: "¡Atencion!",
      text: "Por favor, seleccione una hora.",
      icon: "warning",
    });
  } else {
  }
} else if (select_motivo.value === "Salida temprano") {
  if (hora_salida.value === "") {
    Swal.fire({
      title: "¡Atencion!",
      text: "Por favor, seleccione una hora.",
      icon: "warning",
    });
  } else {
  }
} */
