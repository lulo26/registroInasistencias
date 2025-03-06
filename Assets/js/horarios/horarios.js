console.log("hello world");


const btnHorario = document.querySelector("#btnHorario")

btnHorario.addEventListener('click', ()=>{
    document.getElementById("horarioModalLabel").innerHTML =
          "Agregar horario";
      $('#horarioModal').modal('show')
  })