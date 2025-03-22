fetch(base_url + "/excepciones/getUsuarioByID")
  .then((res) => res.json())
  .then((res) => {
    if (res.status) {
      usuario = res.data[0];
      console.log(usuario);
      if (usuario.rol_usuario === "INSTRUCTOR") {
        let idInstructor = usuario.idusuario;
        console.log(idInstructor);
        /* listExcepciones(idInstructor); */

        /* CARGAR SELECT DE FICHAS */
      }
    } else {
      console.log("Status: " + res.status + ". " + res.msg);
    }
  });

fetch(base_url + "/excepciones/getFichasByUserID")
  .then((res) => res.json())
  .then((res) => {
    if (res.status) {
      usuario = res.data[0];
      console.log(usuario);
      if (usuario.rol_usuario === "INSTRUCTOR") {
        let idInstructor = usuario.idusuario;
        console.log(idInstructor);
        /* listExcepciones(idInstructor); */

        /* CARGAR SELECT DE FICHAS */
      }
    } else {
      console.log("Status: " + res.status + ". " + res.msg);
    }
  });

fetch(base_url + "/excepciones/getFichasByDate")
  .then((res) => res.json())
  .then((res) => {
    if (res.status) {
      usuario = res.data[0];
      console.log(usuario);
      if (usuario.rol_usuario === "INSTRUCTOR") {
        let idInstructor = usuario.idusuario;
        console.log(idInstructor);
        /* listExcepciones(idInstructor); */

        /* CARGAR SELECT DE FICHAS */
      }
    } else {
      console.log("Status: " + res.status + ". " + res.msg);
    }
  });

////////////////////////////////////////////////
// ------------ LISTAR EXCEPCIONES -------------
////////////////////////////////////////////////

function listExcepciones(idInstructor) {
  tablaExcepciones.innerHTML = "";
  fetch(base_url + `/excepciones/getExcepPorInstructor/${idInstructor}`, {
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
                  <td>${fecha}</td>
                  <td>${excepcion.motivo_excepcion}</td>
                  <td>${excepcion.nombre_curso}</td>
                  <td>${excepcion.bloque}</td>`;
        });
      } else {
        tablaExcepciones.innerHTML = `
                  <td colspan="4" align="center">${excepciones.msg}</td>`;
      }
    });
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
