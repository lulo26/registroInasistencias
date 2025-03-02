/* const btnUsuario = document.querySelector("#btnUsuario");
let frmUsuarios = document.querySelector("#frmUsuarios"); */

const numdoc = document.querySelector("#numdoc_usuario"); /* 
const select_roles = document.getElementById("roles_idrol"); */
const select_rol = document.querySelector("#rol_usuario");

const btnCerrar = document.getElementById("btnCerrar");
const btnEquis = document.getElementById("btnEquis");
const tablaUsuarios = document.getElementById("tablaUsuarios");

///////////////////////////////////////////////
// ------------ LISTAR USUARIOS --------------
///////////////////////////////////////////////

function listUsuarios() {
  tablaUsuarios.innerHTML = "";

  fetch(base_url + "/usuarios/getUsuarios")
    .then((data) => data.json())
    .then((data) => {
      data.forEach((usuario) => {
        tablaUsuarios.innerHTML += `
                <td>${usuario.idusuario}</td>
                <td>${usuario.numdoc_usuario}</td>
                <td>${usuario.nombre_usuario}</td>
                <td>${usuario.correo_usuario}</td>
                <td>${usuario.telefono_usuario}</td>
                <td>${usuario.codigo_usuario}</td>
                <td>${mayusInicial(usuario.rol_usuario)}</td>
                <td>${usuario.options}</td>`;
      });
    });
}

///////////////////////////////////////////////
// ---------- LISTAR ROLES --------------
///////////////////////////////////////////////

/* function listarRoles() {
  fetch(base_url + "/usuarios/getRoles")
    .then((data) => data.json())
    .then((data) => {
      console.log(data);
      data.forEach((rol) => {
        select_roles.innerHTML += `<option value="${rol.idrol}">${rol.nombre_rol}</option>`;
      });
    });
} */

/////////////////////////////////////////////////////////
// ---------- LIMPIAR FORMULARIO AL CERRAR --------------
/////////////////////////////////////////////////////////

function limpiarFormulario() {
  frmUsuarios.reset();
}

btnCerrar.addEventListener("click", limpiarFormulario);
btnEquis.addEventListener("click", limpiarFormulario);

///////////////////////////////////////////////
// ------------ CARGAR USUARIOS --------------
///////////////////////////////////////////////

window.addEventListener("DOMContentLoaded", (e) => {
  listUsuarios();
});

////////////////////////////////////////////////
// --------------- ABRIR MODAL -----------------
////////////////////////////////////////////////

btnUsuario.addEventListener("click", () => {
  numdoc.readOnly = false;
  /* select_roles.innerHTML = "<option selected disabled>Seleccione el rol</option>";
  listarRoles(); */
  document.getElementById("UsuarioModalLabel").innerHTML = "Agregar Usuario";
  $("#crearUsuarioModal").modal("show");
});

/////////////////////////////////////////////////////////
// --------- VALIDAR LONGITUD IDENTIFICACION ------------
/////////////////////////////////////////////////////////

numdoc.addEventListener("input", function () {
  if (this.value.length > 10) {
    this.value = this.value.slice(0, 10);
  }
});

///////////////////////////////////////////////
// ------------- ENVIO DE DATOS ---------------
///////////////////////////////////////////////

frmUsuarios.addEventListener("submit", (e) => {
  e.preventDefault();
  if (select_rol.value === "Selecciona un rol") {
    Swal.fire({
      title: "¡Error!",
      text: "Seleccione un rol.",
      icon: "error",
    });
  } else {
    frmData = new FormData(frmUsuarios);
    console.log(frmData);
    fetch(base_url + "/usuarios/setUsuarios", {
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
          frmUsuarios.reset();
          $("#crearUsuarioModal").modal("hide");
          listUsuarios();
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
