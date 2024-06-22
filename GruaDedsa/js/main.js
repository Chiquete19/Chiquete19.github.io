function validarFormularioGruas() {
  // Obtener los valores de los campos
  var economico = document.getElementById("economico").value;
  var placa = document.getElementById("placa").value;
  var razonSocial = document.getElementById("razon").value;
  var modelo = document.getElementById("modelo").value;
  var tipoGrua = document.getElementById("tipo").value;

  // Verificar si los campos están vacíos
  if (
    economico.trim() === "" ||
    placa.trim() === "" ||
    razonSocial.trim() === "" ||
    modelo.trim() === "" ||
    tipoGrua === ""
  ) {
    return false; // Evita que el formulario se envíe
  }

  // Mostrar el spinner y deshabilitar el botón de registrar
  document.getElementById("loadingBtn").classList.remove("d-none");
  document.getElementById("registrarBtn").classList.add("d-none");

  setTimeout(function () {
    // Ocultar el spinner y habilitar el botón de registrar después de un tiempo
    document.getElementById("loadingBtn").classList.add("d-none");
    document.getElementById("registrarBtn").classList.remove("d-none");
  }, 2000); // Cambia 2000 por la duración real de tu operación asíncrona
  return true; // Permite que el formulario se envíe
}

function validarFormularioGruasEditar() {
  // Obtener los valores de los campos
  var economico = document.getElementById("economicoEditar").value;
  var placa = document.getElementById("placaEditar").value;
  var razonSocial = document.getElementById("razonEditar").value;
  var modelo = document.getElementById("modeloEditar").value;
  var tipoGrua = document.getElementById("tipoEditar").value;

  // Verificar si los campos están vacíos
  if (
    economico.trim() === "" ||
    placa.trim() === "" ||
    razonSocial.trim() === "" ||
    modelo.trim() === "" ||
    tipoGrua === ""
  ) {
    return false; // Evita que el formulario se envíe
  }

  // Mostrar el spinner y deshabilitar el botón de registrar
  document.getElementById("loadingEditarGruasBtn").classList.remove("d-none");
  document.getElementById("editarGruasBtn").classList.add("d-none");

  setTimeout(function () {
    // Ocultar el spinner y habilitar el botón de registrar después de un tiempo
    document.getElementById("loadingEditarGruasBtn").classList.add("d-none");
    document.getElementById("editarGruasBtn").classList.remove("d-none");
  }, 2000); // Cambia 2000 por la duración real de tu operación asíncrona
  return true; // Permite que el formulario se envíe
}

function validarFormularioOperadores() {
  var nombre = document.getElementById("nombreLicencia").value;
  var licencia = document.getElementById("Nlicencia").value;
  var tipoLicencia = document.getElementById("tipoLicencia").value;

  // Verificar si los campos están vacíos
  if (nombre.trim() === "" || licencia.trim() === "" || tipoLicencia === "") {
    // Campos vacíos, no realizar la operación y salir
    return;
  }

  // Mostrar el spinner y deshabilitar el botón de registrar
  document.getElementById("loadingBtn").classList.remove("d-none");
  document.getElementById("registrarBtn").classList.add("d-none");

  setTimeout(function () {
    // Ocultar el spinner y habilitar el botón de registrar después de un tiempo
    document.getElementById("loadingBtn").classList.add("d-none");
    document.getElementById("registrarBtn").classList.remove("d-none");
  }, 2000); // Cambia 2000 por la duración real de tu operación asíncrona
}

function validarFormularioOperadoresEditar() {
  var nombreLicenciaEditar = document.getElementById(
    "nombreLicenciaEditar"
  ).value;
  var NlicenciaEditar = document.getElementById("NlicenciaEditar").value;
  var tipoLicenciaEditar = document.getElementById("tipoLicenciaEditar").value;

  // Verificar si los campos están vacíos
  if (
    nombreLicenciaEditar.trim() === "" ||
    NlicenciaEditar.trim() === "" ||
    tipoLicenciaEditar === ""
  ) {
    // Campos vacíos, no realizar la operación y salir
    return;
  }

  // Mostrar el spinner y deshabilitar el botón de registrar
  document.getElementById("loadingEditarBtn").classList.remove("d-none");
  document.getElementById("editarBtn").classList.add("d-none");

  setTimeout(function () {
    // Ocultar el spinner y habilitar el botón de registrar después de un tiempo
    document.getElementById("loadingEditarBtn").classList.add("d-none");
    document.getElementById("editarBtn").classList.remove("d-none");
  }, 2000); // Cambia 2000 por la duración real de tu operación asíncrona
}

function validarFormularioArrastres() {
  var lugarExpedicion = document.getElementById("lugarExpedicion").value;
  var fechaExpedicion = document.getElementById("fechaExpedicion").value;
  var solicitante = document.getElementById("solicitante").value;
  var tipoVehiculoArrastrado = document.getElementById(
    "tipoVehiculoArrastrado"
  ).value;
  var marca = document.getElementById("marca").value;
  var placas = document.getElementById("placas").value;
  var color = document.getElementById("color").value;
  var anioModelo = document.getElementById("anioModelo").value;
  var serie = document.getElementById("serie").value;
  var motivoServicio = document.getElementById("motivoServicio").value;
  var lugarHoraEnganche = document.getElementById("lugarHoraEnganche").value;
  var fechaHoraEnganche = document.getElementById("fechaHoraEnganche").value;
  var destino = document.getElementById("destino").value;
  var horaDesenganche = document.getElementById("horaDesenganche").value;
  var tipoGrua = document.getElementById("tipoGrua").value;
  var numEconomicoGrua = document.getElementById("numEconomicoGrua").value;
  var numVehiculosArrastrados = document.getElementById(
    "numVehiculosArrastrados"
  ).value;

  // Verificar si los campos obligatorios están vacíos
  if (
    lugarExpedicion.trim() === "" ||
    fechaExpedicion.trim() === "" ||
    solicitante.trim() === "" ||
    tipoVehiculoArrastrado.trim() === "" ||
    marca.trim() === "" ||
    placas.trim() === "" ||
    color.trim() === "" ||
    anioModelo.trim() === "" ||
    serie.trim() === "" ||
    motivoServicio.trim() === "" ||
    lugarHoraEnganche.trim() === "" ||
    fechaHoraEnganche.trim() === "" ||
    destino.trim() === "" ||
    horaDesenganche.trim() === "" ||
    tipoGrua.trim() === "" ||
    numEconomicoGrua.trim() === "" ||
    numVehiculosArrastrados.trim() === ""
  ) {
    return;
  }

  // Mostrar el spinner y deshabilitar el botón de registrar
  document.getElementById("loadingBtn").classList.remove("d-none");
  document.getElementById("registrarBtn").classList.add("d-none");

  setTimeout(function () {
    // Ocultar el spinner y habilitar el botón de registrar después de un tiempo
    document.getElementById("loadingBtn").classList.add("d-none");
    document.getElementById("registrarBtn").classList.remove("d-none");
  }, 2000); // Cambia 2000 por la duración real de tu operación asíncrona
}

function validarFormularioArrastresEditar() {
  var lugarExpedicion = document.getElementById("lugarExpedicionEditar").value;
  var fechaExpedicion = document.getElementById("fechaExpedicionEditar").value;
  var solicitante = document.getElementById("solicitanteEditar").value;
  var tipoVehiculoArrastrado = document.getElementById(
    "tipoVehiculoArrastradoEditar"
  ).value;
  var marca = document.getElementById("marcaEditar").value;
  var placas = document.getElementById("placasEditar").value;
  var color = document.getElementById("colorEditar").value;
  var anioModelo = document.getElementById("anioModeloEditar").value;
  var serie = document.getElementById("serieEditar").value;
  var motivoServicio = document.getElementById("motivoServicioEditar").value;
  var lugarHoraEnganche = document.getElementById(
    "lugarHoraEngancheEditar"
  ).value;
  var fechaHoraEnganche = document.getElementById(
    "fechaHoraEngancheEditar"
  ).value;
  var destino = document.getElementById("destinoEditar").value;
  var horaDesenganche = document.getElementById("horaDesengancheEditar").value;
  var tipoGrua = document.getElementById("tipoGruaEditar").value;
  var numEconomicoGrua = document.getElementById(
    "numEconomicoGruaEditar"
  ).value;
  var numVehiculosArrastrados = document.getElementById(
    "numVehiculosArrastradosEditar"
  ).value;

  // Verificar si los campos obligatorios están vacíos
  if (
    lugarExpedicion.trim() === "" ||
    fechaExpedicion.trim() === "" ||
    solicitante.trim() === "" ||
    tipoVehiculoArrastrado.trim() === "" ||
    marca.trim() === "" ||
    placas.trim() === "" ||
    color.trim() === "" ||
    anioModelo.trim() === "" ||
    serie.trim() === "" ||
    motivoServicio.trim() === "" ||
    lugarHoraEnganche.trim() === "" ||
    fechaHoraEnganche.trim() === "" ||
    destino.trim() === "" ||
    horaDesenganche.trim() === "" ||
    tipoGrua.trim() === "" ||
    numEconomicoGrua.trim() === "" ||
    numVehiculosArrastrados.trim() === ""
  ) {
    return;
  }

  // Mostrar el spinner y deshabilitar el botón de registrar
  document.getElementById("loadingBtn").classList.remove("d-none");
  document.getElementById("registrarBtn").classList.add("d-none");

  setTimeout(function () {
    // Ocultar el spinner y habilitar el botón de registrar después de un tiempo
    document.getElementById("loadingBtn").classList.add("d-none");
    document.getElementById("registrarBtn").classList.remove("d-none");
  }, 2000); // Cambia 2000 por la duración real de tu operación asíncrona
}

function btnConfirmacion(modalId) {
  // Mostrar el botón de carga y ocultar el enlace de eliminación
  $("#" + modalId + " #btnLoadingEliminacion").removeClass("d-none");
  $("#" + modalId + " #btnConfirmacion").hide();

  // Aquí puedes agregar la lógica de confirmación o realizar la acción de eliminación
  // Por ejemplo, podrías hacer una solicitud AJAX para eliminar el elemento.

  // Simulación de una acción de eliminación con un retardo de 2 segundos (puedes ajustar según tus necesidades)
  setTimeout(function () {
    // Ocultar el botón de carga y mostrar el enlace de eliminación nuevamente
    $("#" + modalId + " #btnLoadingEliminacion").addClass("d-none");
    $("#" + modalId + " #btnConfirmacion").show();
  }, 2000); // 2000 milisegundos (2 segundos)
}

