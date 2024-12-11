const btnUsuario = document.querySelector("#btnUsuario");
let frmUsuarios = document.querySelector("#frmUsuarios");

document.addEventListener('load', (e) => {

})

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

window.addEventListener("DOMContentLoaded", (e) => {
   listUsuarios();
});

frmUsuarios.addEventListener("submit", (e) => {
   e.preventDefault();
   frmData = new FormData(frmUsuarios);
   console.log(frmData);
   fetch(base_url + "/usuarios/setUsuario", {
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
               /* document.querySelector("#password_usuario").value = usuario.password_usuario; */
               document.querySelector("#correo").value = usuario.correo_usuario;
               document.querySelector("#telefono_usuario").value = usuario.telefono_usuario;
               /*  document.querySelector(
                   "#roles_idrol"
                ).innerHTML = `<option selected hidden value="${curso.tipo_curso}">${curso.tipo_curso}</option>
                          <option value="${usuario.roles_idrol}">${usuario.rol_nombre}</option>
                          <option value="tecnologo">tecnologo</option>`; */
               /* document.querySelector("#codigo_usuario").value = usuario.codigo_usuario; */
               document.querySelector("#idusuario").value = usuario.idusuario;
            });
         listCursos();
      }
   } catch { }
});
