const btnUsuario = document.querySelector("#btnUsuario");
frmUsuarios = document.querySelector("#frmUsuarios");

/* document.addEventListener('load', (e) => {

}) */

btnUsuario.addEventListener("click", () => {
   document.getElementById("UsuarioModalLabel").innerHTML = "Agregar Usuario";
   $("#crearUsuarioModal").modal("show");
});

function listUsuarios() {
   document.getElementById("tablaUsuarios").innerHTML = "";
   fetch(base_url + "/usuarios/getUsuarios")
      .then((data) => data.json())
      .then((data) => {
         console.log(data);
         data.forEach((usuario) => {
            console.log(usuario.nombre_usuario);
            document.getElementById("tablaUsuarios").innerHTML += `<tr>
                <td>${usuario.idusuario}</td>
                <td>${usuario.numdoc_usuario}</td>
                <td>${usuario.nombre_usuario}</td>
                <td>${usuario.correo_usuario}</td>
                <td>${usuario.telefono_usuario}</td>
                <td>${usuario.nombre_rol}</td>
                <td>${usuario.codigo_usuario}</td>
                <td>${usuario.options}</td>
            </tr>`;
         });
      });
}

function listRoles() {
   fetch(base_url + "/usuarios/getRoles")
      .then((data) => data.json())
      .then((data) => {
         console.log(data);
         data.forEach((rol) => {
            console.log(rol.nombre_rol);
            document.getElementById("roles_idrol").innerHTML += `<option value='${rol.idrol}'>${rol.nombre_rol}</option>`;
         });
      });
}

window.addEventListener("DOMContentLoaded", (e) => {
   listUsuarios();
   listRoles();
});

frmUsuarios.addEventListener("submit", (e) => {
   e.preventDefault();
   console.log(frmUsuarios)
   /* let numdoc = document.getElementById("numdoc_usuario");
   let nombre = document.getElementById("nombre_usuario");
   let password = document.getElementById("password_usuario");
   let correo = document.getElementById("correo_usuario");
   let telefono = document.getElementById("telefono_usuario");
   let idrol = document.getElementById("roles_idrol");
   let codigo = document.getElementById("codigo_usuario");
   let idusuario = document.getElementById("idusuario"); */
   frmData = new FormData(frmUsuarios);
   /* frmData.append('numdoc_usuario', numdoc.value);
   frmData.append('nombre_usuario', nombre.value);
   frmData.append('password_usuario', password.value);
   frmData.append('correo_usuario', correo.value);
   frmData.append('telefono_usuario', telefono.value);
   frmData.append('roles_idrol', idrol.value);
   frmData.append('codigo_usuario', codigo.value);
   frmData.append('idusuario', idusuario.value);
   console.log("Nombre: " + numdoc.value);
   console.log(nombre.value);
   console.log(password.value);
   console.log(correo.value);
   console.log(telefono.value);
   console.log(idrol.value);
   console.log(codigo.value);
   console.log(idusuario.value) */

   console.log(frmData);

   fetch(base_url + "/usuarios/setUsuarios", {
      method: "POST",
      body: frmData,
   })
      .then((data) => data.json())
      .then((data) => {
         Swal.fire({
            title: data.status ? "Correcto" : "Error",
            text: data.msg,
            icon: data.status ? "success" : "error",
         });
         if (data.status) {
            frmUsuarios.reset();
            $("#crearUsuarioModal").modal("hide");
            listUsuarios();
         }
      });
});

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
               console.log(formData)
               fetch(base_url + "/usuarios/eliminarUsuario", {
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
                     listUsuarios();
                  });
            }
         });
      }

      if (selected == "update") {
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

               document.querySelector("#numdoc_usuario").value = usuario.numdoc_usuario;
               document.querySelector("#nombre_usuario").value = usuario.nombre_usuario;
               document.querySelector("#password_usuario").value = usuario.password_usuario;
               document.querySelector("#correo_usuario").value = usuario.correo_usuario;
               document.querySelector("#telefono_usuario").value = usuario.telefono_usuario;
               fetch(base_url + `/usuario/getRolByID/${idusuario}`, {
                  method: "GET",
               })
                  .then((res) => res.json())
                  .then((res) => {

                     document.querySelector(
                        "#roles_idrol"
                     ).innerHTML = `<option selected hidden value="${usuario.roles_idrol}">${curso.tipo_curso}</option>
                          <option value="${usuario.roles_idrol}">${usuario.rol_nombre}</option>
                          <option value="tecnologo">tecnologo</option>`;

                  })
               document.querySelector("#codigo_usuario").value = usuario.codigo_usuario;
               document.querySelector("#idusuario").value = usuario.idusuario;
            });
         listCursos();
      }
   } catch { }
});
