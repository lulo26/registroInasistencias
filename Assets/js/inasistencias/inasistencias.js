const frmInasistencia = document.querySelector("#frmInasistencia");
const inasistenciaUrl = "http://localhost/registroInasistencias/inasistencias/";
let codigoInasistencia = document.querySelector("#codigoInasistencia");
let numeroFichaInput = document.querySelector("#numeroFicha");
let idUsuario = document.querySelector("#idUsuario");
let card = document.getElementById("card");
let numeroFicha = 0;
let container2 = document.querySelector("#container2");
let container1 = document.querySelector("#container1");
/*function listAprendices() {

    fetch(aprendicesUrl + "/getInasistencias")
        .then((data) => data.json())
        .then((data) => {
            console.log(data);
            data.forEach((inasistencias) => {
                document.getElementById("tablaAprendiz").innerHTML += `
              <tr>
              <td>${inasistencias.idregistro}</td>
              <td>${inasistencias.aprendices_idusuario}</td>
              <td>${inasistencias.fecha_inasistencia}</td>
              <td>${inasistencias.registro_idusuario}</td>
              <td>${inasistencias.estado_inasistencia}</td>
              <td>${inasistencias.hora_inasistencia}</td>
              <td>${inasistencias.retardos_inasistencia}</td>
              <tr/>`;
            });
        });
}
*/

//Para que quede por dewfecto en focus ahi
window.onload = () => {
  codigoInasistencia.focus();
};

//Insertar
//Con la funsion input se ejecuta cada que se escriba algo

codigoInasistencia.addEventListener("input", () => {
  let codigoValor = codigoInasistencia.value.trim();

  // Evita envíos si el input está vacío
  if (codigoValor === "") return;

  let frmData = new FormData(frmInasistencia);

  fetch(inasistenciaUrl + "/setInasistencias", {
    method: "POST",
    body: frmData,
  })
    .then((res) => res.json())
    .then((data) => {
      console.log("Respuesta del servidor:", data); // Para depuración

      alerta.style.display = "block";
      alerta.style.backgroundColor = data.status ? "green" : "red";
      alerta.style.color = "white";
      alerta.innerHTML = data.msg;

      setTimeout(() => {
        alerta.style.display = "none"; // Oculta la alerta después de 3 segundos
      }, 3000);

      if (data.status) {
        frmInasistencia.reset();
        codigoInasistencia.focus();
      }
    })
    .catch((error) => console.error("Error en la petición:", error));
});

//Apartado de muestra de fichas

function listFichas() {
  fetch(inasistenciaUrl + "/getFichas")
    .then((data) => data.json())
    .then((data) => {
      console.log(data);
      data.forEach((fichas) => {
        card.innerHTML += `
            <div class="col-4">
          <div class="card" name="ficha${fichas.numero_ficha}" id="ficha${fichas.numero_ficha}" style="width: 18rem;">
            <img src="Assets/img/sena.png" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">${fichas.numero_ficha}</p>
            </div>
          </div>
        </div>`;
      });
    });
}

//Asigna valor de numero de ficha

fetch(inasistenciaUrl + "/getFichas")
  .then((data) => data.json())
  .then((data) => {
    data.forEach((fichas) => {
      $(document).on("click", `#ficha${fichas.numero_ficha}`, function () {
        console.log(`El numero de ficha es ${fichas.numero_ficha}`);
        numeroFicha = fichas.numero_ficha;
        console.log(numeroFicha);
        container2.style.display = "none";
        container1.style.display = "block";
        numeroFichaInput.value = numeroFicha;
        codigoInasistencia.focus();
      });
    });
  });

listFichas();
