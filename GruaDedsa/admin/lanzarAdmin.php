<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../logo.png" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../butterup/butterup.min.css" />
    <link rel="stylesheet" href="../css/styleservicio.css">
    <title>DEDSA - ARRASTRE</title>
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DATATABLES -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../butterup/butterup.min.js"></script>
    <script src="https://kit.fontawesome.com/d15e5b966b.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="../js/jspdf.min.js"></script>

    <?php include "../conexion.php"; ?>
    <?php
    session_start();

    if (isset($_SESSION["usuario"]) && $_SESSION["usuario"]) {
        $usuario = $_SESSION["usuario"];
        $permisos = $_SESSION["permisos"];
    } else {
        header("location: ../login");
        exit();
    }
    include("sliderbarAdmin.php");
    ?>

    <?php function realizarRegistroServicio($conexion)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $lugarExpedicion = strtoupper($_POST["lugarExpedicion"]);
            $fechaExpedicion = strtoupper($_POST["fechaExpedicion"]);
            $solicitante = strtoupper($_POST["solicitante"]);
            $tipoVehiculoArrastrado = strtoupper($_POST["tipoVehiculoArrastrado"]);
            $marca = strtoupper($_POST["marca"]);
            $placas = strtoupper($_POST["placas"]);
            $color = strtoupper($_POST["color"]);
            $anioModelo = strtoupper($_POST["anioModelo"]);
            $serie = strtoupper($_POST["serie"]);
            $motivoServicio = strtoupper($_POST["motivoServicio"]);
            $lugarHoraEnganche = strtoupper($_POST["lugarHoraEnganche"]);
            $destino = strtoupper($_POST["destino"]);
            $fechaHoraEnganche = strtoupper($_POST["fechaHoraEnganche"]);
            $horaDesenganche = strtoupper($_POST["horaDesenganche"]);
            $tipoGrua = strtoupper($_POST["tipoGrua"]);
            $numEconomicoGrua = strtoupper($_POST["numEconomicoGrua"]);
            $numVehiculosArrastrados = strtoupper($_POST["numVehiculosArrastrados"]);
            $maniobrasEspeciales = strtoupper($_POST["maniobrasEspeciales"]);
            $observaciones = strtoupper($_POST["observaciones"]);
            $nombrePersonaRecibe = strtoupper($_POST["nombrePersonaRecibe"]);
            $nombrePersonaEntrega = strtoupper($_POST["nombrePersonaEntrega"]);
            $nombreOperador = strtoupper($_POST["nombreOperador"]);
            $informacionDeContacto = strtoupper($_POST["informacionDeContacto"]);

            $personaEntrega = $_POST["personaEntregaCanva"];
            $personaEntrega = str_replace(
                "data:image/png;base64,",
                "",
                $personaEntrega
            );
            $fileDataEntrega = base64_decode($personaEntrega);
            $fileNameEntrega = "Sin Firma";
            if (!canvasIsBlank($fileDataEntrega)) {
                $fileNameEntrega = "Entrega" . uniqid() . ".png";
                file_put_contents(
                    "../firmas/" . $fileNameEntrega,
                    $fileDataEntrega
                );
            }

            $personaRecibe = $_POST["personaRecibeCanva"];
            $personaRecibe = str_replace(
                "data:image/png;base64,",
                "",
                $personaRecibe
            );
            $fileDataRecibe = base64_decode($personaRecibe);
            $fileNameRecibe = "Sin Firma";
            if (!canvasIsBlank($fileDataRecibe)) {
                $fileNameRecibe = "Recibe" . uniqid() . ".png";
                file_put_contents("../firmas/" . $fileNameRecibe, $fileDataRecibe);
            }

            $firmaOperador = $_POST["firmaOperadorCanva"];
            $firmaOperador = str_replace(
                "data:image/png;base64,",
                "",
                $firmaOperador
            );
            $fileDataOperador = base64_decode($firmaOperador);
            $fileNameOperador = "Sin Firma";
            if (!canvasIsBlank($fileDataOperador)) {
                $fileNameOperador = "Operador" . uniqid() . ".png";
                file_put_contents(
                    "../firmas/" . $fileNameOperador,
                    $fileDataOperador
                );
            }

            $sql = "INSERT INTO viajes_lanzados (lugarExpedicion, fechaExpedicion, solicitante, tipoVehiculoArrastrado, marca, placas, color, anioModelo, serie, motivoServicio, lugarHoraEnganche, destino, fechaHoraEnganche, horaDesenganche, tipoGrua, numEconomicoGrua, numVehiculosArrastrados, nombrePersonaEntrega, personaEntrega, nombrePersonaRecibe, personaRecibe, maniobrasEspeciales, observaciones, nombreOperador, firmaOperador, informacionDeContacto) VALUES ('$lugarExpedicion', '$fechaExpedicion', '$solicitante', '$tipoVehiculoArrastrado', '$marca', '$placas', '$color', '$anioModelo', '$serie', '$motivoServicio', '$lugarHoraEnganche', '$destino', '$fechaHoraEnganche', '$horaDesenganche', '$tipoGrua', '$numEconomicoGrua', '$numVehiculosArrastrados', '$nombrePersonaEntrega' ,'$fileNameEntrega', '$nombrePersonaRecibe' ,'$fileNameRecibe', '$maniobrasEspeciales', '$observaciones', '$nombreOperador', '$fileNameOperador', '$informacionDeContacto')";

            $result = mysqli_query($conexion, $sql);

            if ($result) {
                ?>
                <script>
                    butterup.toast({
                        title: "ARRASTRES",
                        message: "ARRASTRE GUARDADO CORRECTAMENTE",
                        type: "success",
                        icon: true,
                    })
                </script>
                <?php
            }
        }
    }
    ?>

    <?php
    function realizarEdicionServicio($conexion)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $folioEditar = $_POST["folioEditar"];
            $lugarExpedicionEditar = strtoupper($_POST["lugarExpedicionEditar"]);
            $fechaExpedicionEditar = strtoupper($_POST["fechaExpedicionEditar"]);
            $solicitanteEditar = strtoupper($_POST["solicitanteEditar"]);
            $tipoVehiculoArrastradoEditar = strtoupper($_POST["tipoVehiculoArrastradoEditar"]);
            $marcaEditar = strtoupper($_POST["marcaEditar"]);
            $placasEditar = strtoupper($_POST["placasEditar"]);
            $colorEditar = strtoupper($_POST["colorEditar"]);
            $anioModeloEditar = strtoupper($_POST["anioModeloEditar"]);
            $serieEditar = strtoupper($_POST["serieEditar"]);
            $motivoServicioEditar = strtoupper($_POST["motivoServicioEditar"]);
            $lugarHoraEngancheEditar = strtoupper($_POST["lugarHoraEngancheEditar"]);
            $destinoEditar = strtoupper($_POST["destinoEditar"]);
            $fechaHoraEngancheEditar = strtoupper($_POST["fechaHoraEngancheEditar"]);
            $horaDesengancheEditar = strtoupper($_POST["horaDesengancheEditar"]);
            $tipoGruaEditar = strtoupper($_POST["tipoGruaEditar"]);
            $numEconomicoGruaEditar = strtoupper($_POST["numEconomicoGruaEditar"]);
            $numVehiculosArrastradosEditar = strtoupper($_POST["numVehiculosArrastradosEditar"]);
            $maniobrasEspecialesEditar = strtoupper($_POST["maniobrasEspecialesEditar"]);
            $observacionesEditar = strtoupper($_POST["observacionesEditar"]);
            $liberado = strtoupper($_POST["liberadoEditar"]);
            $nombreOperadorEditar = strtoupper($_POST["nombreOperadorEditar"]);
            $nombrePersonaEntregaEditar = strtoupper($_POST["nombrePersonaEntregaEditar"]);
            $nombrePersonaRecibeEditar = strtoupper($_POST["nombrePersonaRecibeEditar"]);
            $informacionDeContactoEditar = strtoupper($_POST["informacionDeContactoEditar"]);


            $firmaEntregaActual = $_POST["firmaEntregaActual"];
            $firmaRecibeActual = $_POST["firmaRecibeActual"];
            $firmaOperadorActual = $_POST["firmaOperadorActual"];

            if (file_exists("../firmas/" . $firmaEntregaActual)) {
                if (unlink("../firmas/" . $firmaEntregaActual)) {
                    // echo "El archivo $firmaEntregaActual fue eliminado correctamente.";
                }
            }

            if (file_exists("../firmas/" . $firmaRecibeActual)) {
                if (unlink("../firmas/" . $firmaRecibeActual)) {
                    // echo "El archivo $firmaEntregaActual fue eliminado correctamente.";
                }
            }

            if (file_exists("../firmas/" . $firmaOperadorActual)) {
                if (unlink("../firmas/" . $firmaOperadorActual)) {
                    // echo "El archivo $firmaEntregaActual fue eliminado correctamente.";
                }
            }


            $personaEntregaEditar = $_POST["personaEntregaCanvaEditar"];
            $personaEntregaEditar = str_replace(
                "data:image/png;base64,",
                "",
                $personaEntregaEditar
            );
            $fileDataEntregaEditar = base64_decode($personaEntregaEditar);
            $fileNameEntregaEditar = "Sin Firma";
            if (!canvasIsBlank($fileDataEntregaEditar)) {
                $fileNameEntregaEditar = "Entrega" . uniqid() . ".png";
                file_put_contents(
                    "../firmas/" . $fileNameEntregaEditar,
                    $fileDataEntregaEditar
                );
            }

            $personaRecibeEditar = $_POST["personaRecibeCanvaEditar"];
            $personaRecibeEditar = str_replace(
                "data:image/png;base64,",
                "",
                $personaRecibeEditar
            );
            $fileDataRecibeEditar = base64_decode($personaRecibeEditar);
            $fileNameRecibeEditar = "Sin Firma";
            if (!canvasIsBlank($fileDataRecibeEditar)) {
                $fileNameRecibeEditar = "Recibe" . uniqid() . ".png";
                file_put_contents("../firmas/" . $fileNameRecibeEditar, $fileDataRecibeEditar);
            }

            $firmaOperadorEditar = $_POST["firmaOperadorCanvaEditar"];
            $firmaOperadorEditar = str_replace(
                "data:image/png;base64,",
                "",
                $firmaOperadorEditar
            );
            $fileDataOperadorEditar = base64_decode($firmaOperadorEditar);
            $fileNameOperadorEditar = "Sin Firma";
            if (!canvasIsBlank($fileDataOperadorEditar)) {
                $fileNameOperadorEditar = "Operador" . uniqid() . ".png";
                file_put_contents(
                    "../firmas/" . $fileNameOperadorEditar,
                    $fileDataOperadorEditar
                );
            }

            if ($informacionDeContactoEditar == "") {
                $informacionDeContactoEditar = "SIN INFORMACION";
            }

            $sql = "UPDATE viajes_lanzados SET lugarExpedicion = '$lugarExpedicionEditar', fechaExpedicion = '$fechaExpedicionEditar', solicitante = '$solicitanteEditar', tipoVehiculoArrastrado = '$tipoVehiculoArrastradoEditar', marca = '$marcaEditar', placas = '$placasEditar', color = '$colorEditar', anioModelo = '$anioModeloEditar', serie = '$serieEditar', motivoServicio = '$motivoServicioEditar', lugarHoraEnganche = '$lugarHoraEngancheEditar', destino = '$destinoEditar', fechaHoraEnganche = '$fechaHoraEngancheEditar', horaDesenganche = '$horaDesengancheEditar', tipoGrua = '$tipoGruaEditar', numEconomicoGrua = '$numEconomicoGruaEditar', numVehiculosArrastrados = '$numVehiculosArrastradosEditar', personaEntrega = '$fileNameEntregaEditar' , personaRecibe = '$fileNameRecibeEditar' , maniobrasEspeciales = '$maniobrasEspecialesEditar', observaciones = '$observacionesEditar', firmaOperador = '$fileNameOperadorEditar', liberado = '$liberado', nombreOperador = '$nombreOperadorEditar', nombrePersonaEntrega = '$nombrePersonaEntregaEditar', nombrePersonaRecibe = '$nombrePersonaRecibeEditar', informacionDeContacto = '$informacionDeContactoEditar' WHERE folio = '$folioEditar'";

            $result = mysqli_query($conexion, $sql);

            if ($result) {
                ?>
                <script>
                    butterup.toast({
                        title: "ARRASTRES",
                        message: <?php echo json_encode("FOLIO N." . strtoupper($folioEditar) . " ACTUALIZADO CORRECTAMENTE."); ?>,
                        type: "success",
                        icon: true,
                    })
                </script>
                <?php
            } else {
                ?>
                <script>
                    butterup.toast({
                        title: "ARRASTRES",
                        message: <?php echo json_encode("FOLIO N." . strtoupper($folioEditar) . " NO SE HA ACTUALIZADO."); ?>,
                        type: "error",
                        icon: true,
                    })
                </script>
                <?php
            }
        }
    }
    ?>

    <?php
    if (!empty($_GET["folio"])) {
        $folio = $_GET["folio"];
        $correoEnviar = $_GET["correoEnviar"];
        $sql = "SELECT * FROM viajes_lanzados WHERE folio = '$folio'";
        $result = mysqli_query($conexion, $sql);
        $mostrar = mysqli_fetch_array($result);
        $folioA = $mostrar["folio"];
        $lugarExpedicion = $mostrar["lugarExpedicion"];
        $fechaExpedicion = $mostrar["fechaExpedicion"];
        $solicitante = $mostrar["solicitante"];
        $tipoVehiculoArrastrado = $mostrar["tipoVehiculoArrastrado"];
        $marca = $mostrar["marca"];
        $placas = $mostrar["placas"];
        $color = $mostrar["color"];
        $anioModelo = $mostrar["anioModelo"];
        $serie = $mostrar["serie"];
        $motivoServicio = $mostrar["motivoServicio"];
        $lugarHoraEnganche = $mostrar["lugarHoraEnganche"];
        $destino = $mostrar["destino"];
        $fechaHoraEnganche = $mostrar["fechaHoraEnganche"];
        $horaDesenganche = $mostrar["horaDesenganche"];
        $tipogrua = $mostrar["tipogrua"];
        $numEconomicoGrua = $mostrar["numEconomicoGrua"];
        $numVehiculosArrastrados = $mostrar["numVehiculosArrastrados"];
        $personaEntrega = $mostrar["personaEntrega"];
        $personaRecibe = $mostrar["personaRecibe"];
        $maniobrasEspeciales = $mostrar["maniobrasEspeciales"];
        $observaciones = $mostrar["observaciones"];
        $firmaOperador = $mostrar["firmaOperador"];
        $nombreOperador = $mostrar["nombreOperador"];
        $nombrePersonaEntrega = $mostrar["nombrePersonaEntrega"];
        $nombrePersonaRecibe = $mostrar["nombrePersonaRecibe"];
        $informacionDeContacto = $mostrar["informacionDeContacto"];
        ?>

        <script>
            function loadImage(url) {
                return new Promise(resolve => {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', url, true);
                    xhr.responseType = "blob";
                    xhr.onload = function (e) {
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            const res = event.target.result;
                            resolve(res);
                        }
                        const file = this.response;
                        reader.readAsDataURL(file);
                    }
                    xhr.send();
                });
            }

            var folioA = "<?php echo $folioA; ?>";
            var correoEnviar = "<?php echo $correoEnviar; ?>";
            var lugarExpedicion = "<?php echo $lugarExpedicion; ?>";
            var fechaExpedicion = "<?php echo $fechaExpedicion; ?>";
            var solicitante = "<?php echo $solicitante; ?>";
            var tipoVehiculoArrastrado = "<?php echo $tipoVehiculoArrastrado; ?>";
            var marca = "<?php echo $marca; ?>";
            var placas = "<?php echo $placas; ?>";
            var color = "<?php echo $color; ?>";
            var anioModelo = "<?php echo $anioModelo; ?>";
            var serie = "<?php echo $serie; ?>";
            var motivoServicio = "<?php echo $motivoServicio; ?>";
            var lugarHoraEnganche = "<?php echo $lugarHoraEnganche; ?>";
            var destino = "<?php echo $destino; ?>";
            var fechaHoraEnganche = "<?php echo $fechaHoraEnganche; ?>";
            var horaDesenganche = "<?php echo $horaDesenganche; ?>";
            var tipogrua = "<?php echo $tipogrua; ?>";
            var numEconomicoGrua = "<?php echo $numEconomicoGrua; ?>";
            var numVehiculosArrastrados = "<?php echo $numVehiculosArrastrados; ?>";
            var personaEntrega = "<?php echo $personaEntrega; ?>";
            var personaRecibe = "<?php echo $personaRecibe; ?>";
            var maniobrasEspeciales = "<?php echo $maniobrasEspeciales; ?>";
            var observaciones = "<?php echo $observaciones; ?>";
            var firmaOperador = "<?php echo $firmaOperador; ?>";
            var nombreOperador = "<?php echo $nombreOperador; ?>";
            var nombrePersonaEntrega = "<?php echo $nombrePersonaEntrega; ?>";
            var nombrePersonaRecibe = "<?php echo $nombrePersonaRecibe; ?>";
            var informacionDeContacto = "<?php echo $informacionDeContacto; ?>";
            generatePDF(folioA, lugarExpedicion, fechaExpedicion, solicitante, tipoVehiculoArrastrado, marca, placas, color, anioModelo, serie, motivoServicio, lugarHoraEnganche, destino, fechaHoraEnganche, horaDesenganche, tipogrua, numEconomicoGrua, numVehiculosArrastrados, personaEntrega, personaRecibe, maniobrasEspeciales, observaciones, firmaOperador, nombreOperador, nombrePersonaEntrega, nombrePersonaRecibe, informacionDeContacto, correoEnviar);


            async function generatePDF(folioA, lugarExpedicion, fechaExpedicion, solicitante, tipoVehiculoArrastrado, marca, placas, color, anioModelo, serie, motivoServicio, lugarHoraEnganche, destino, fechaHoraEnganche, horaDesenganche, tipogrua, numEconomicoGrua, numVehiculosArrastrados, personaEntrega, personaRecibe, maniobrasEspeciales, observaciones, firmaOperador, nombreOperador, nombrePersonaEntrega, nombrePersonaRecibe, informacionDeContacto, correoEnviar) {
                const image = await loadImage("../formatoArrastre.png");
                const pdf = new jsPDF('p', 'pt', 'letter');
                pdf.addImage(image, 'PNG', 0, 0, 615, 800);

                //FOLIO
                pdf.setFontSize(14);
                pdf.setFontStyle("bold");
                pdf.setTextColor(255, 0, 0);
                pdf.text("N." + folioA, 541, 65);

                //LUGAR
                pdf.setFontSize(10);
                pdf.setTextColor(0, 0, 0);
                pdf.text(lugarExpedicion, 237, 69);

                //FechaExpedicion
                pdf.setFontSize(12);
                pdf.text(fechaExpedicion.substring(0, 4), 463, 69);
                pdf.text(fechaExpedicion.substring(5, 7), 407, 69);
                pdf.text(fechaExpedicion.substring(8, 10), 363, 69);

                //SOLICITANTE
                pdf.text(solicitante, 218, 118);

                //TIPOVEHICULOARRASTRADO
                pdf.text(tipoVehiculoArrastrado, 254, 162);

                //MARCA
                if (marca.length > 16) {
                    pdf.text(marca.substring(0, 16) + "\n" + marca.substring(17), 14, 218);
                } else {
                    pdf.text(marca, 14, 220);
                }

                //PLACAS
                pdf.text(placas, 135, 220);

                //COLOR
                pdf.text(color, 240, 220);

                //anioModelo
                pdf.text(anioModelo, 350, 220);

                //SERIE
                pdf.text(serie, 438, 220);

                //MotivoDelServicio
                if (motivoServicio.length > 46 && motivoServicio.length < 92) {
                    pdf.text(motivoServicio.substring(0, 49) + "\n" + motivoServicio.substring(49), 21, 273);
                } else if (motivoServicio.length > 92 && motivoServicio.length < 138) {
                    pdf.text(motivoServicio.substring(0, 49) + "\n" + motivoServicio.substring(49, 94) + "\n" + motivoServicio.substring(94), 21, 273);
                } else if (motivoServicio.length > 138) {
                    pdf.text(motivoServicio.substring(0, 49) + "\n" + motivoServicio.substring(49, 95) + "\n" + motivoServicio.substring(95, 141) + "\n" + motivoServicio.substring(141), 21, 273);
                } else {
                    pdf.text(motivoServicio, 21, 273);
                }

                //LugarDeEnganche
                if (lugarHoraEnganche.length > 44 && lugarHoraEnganche.length < 90) {
                    pdf.text(lugarHoraEnganche.substring(0, 44) + "\n" + lugarHoraEnganche.substring(44), 326, 271);
                } else if (lugarHoraEnganche.length > 90 && lugarHoraEnganche.length < 136) {
                    pdf.text(lugarHoraEnganche.substring(0, 44) + "\n" + lugarHoraEnganche.substring(44, 89) + "\n" + lugarHoraEnganche.substring(89), 326, 271);
                } else if (lugarHoraEnganche.length > 136) {
                    pdf.text(lugarHoraEnganche.substring(0, 44) + "\n" + lugarHoraEnganche.substring(44, 89) + "\n" + lugarHoraEnganche.substring(89, 136) + "\n" + lugarHoraEnganche.substring(138), 326, 271);
                } else {
                    pdf.text(lugarHoraEnganche, 326, 271);
                }
                //HoraDeEnganche
                pdf.text(fechaHoraEnganche.substring(10, 16), 534, 315);

                //DESTINO
                pdf.text(destino, 21, 364);

                //HoraDeEnganche
                pdf.text(horaDesenganche.substring(10, 16), 495, 384);

                //TipoGrua
                if (tipogrua === 'CAJA CERRADA') {
                    pdf.text(tipogrua, 70, 469);
                } else if (tipogrua === 'PLATAFORMA') {
                    pdf.text(tipogrua, 76, 469);
                } else {
                    pdf.text(tipogrua, 110, 469);
                }

                //NumeroEconomico
                pdf.text(numEconomicoGrua, 296, 467);

                //NumeroVehiculoArrastrado
                pdf.text(numVehiculosArrastrados, 487, 466);

                //NombrePersonaEntrega
                pdf.text(nombrePersonaEntrega, 46, 514);

                //PersonaEntrega
                if (personaEntrega != "Sin Firma") {
                    const firmaEntregaImage = await loadImage("../firmas/" + personaEntrega);
                    pdf.addImage(firmaEntregaImage, 'PNG', 46, 514, 247, 51);
                }

                //NombrePersonaRecibe
                pdf.text(nombrePersonaRecibe, 339, 514);

                //PersonaRecibe
                if (personaRecibe != "Sin Firma") {
                    const firmaRecibeImage = await loadImage("../firmas/" + personaRecibe);
                    pdf.addImage(firmaRecibeImage, 'PNG', 339, 514, 247, 51);
                }

                //ManiobrasEspeciales
                if (maniobrasEspeciales.length > 58) {
                    pdf.text(maniobrasEspeciales.substring(0, 58), 227, 609);
                    pdf.text(maniobrasEspeciales.substring(58, 147), 16, 630);
                    pdf.text(maniobrasEspeciales.substring(147), 16, 650);
                } else {
                    pdf.text(maniobrasEspeciales, 227, 609);
                }

                //Observaciones
                if (maniobrasEspeciales.length > 58) {
                    pdf.text(observaciones.substring(0, 58), 227, 672);
                    pdf.text(observaciones.substring(58, 147), 16, 694);
                    pdf.text(observaciones.substring(147), 16, 714);
                } else {
                    pdf.text(observaciones, 227, 672);
                }

                //NombreOperador
                pdf.setFontSize(9);
                pdf.text(nombreOperador, 485, 768);

                //FirmaOperador
                if (firmaOperador != "Sin Firma") {
                    const firmaOperadorImage = await loadImage("../firmas/" + firmaOperador);
                    pdf.addImage(firmaOperadorImage, 'PNG', 320, 723, 235, 65);
                }

                if (correoEnviar == "true" && informacionDeContacto.includes("@")) {
                    const pdfContentBase64 = pdf.output('dataurlstring');
                    const contacto = informacionDeContacto;
                    const folioMandar = folioA;
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'lanzarAdmin.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // console.log(xhr.responseText);
                        }
                    };
                    const data = 'pdfContent=' + encodeURIComponent(pdfContentBase64) + '&contacto=' + encodeURIComponent(contacto) + '&folioMandar=' + encodeURIComponent(folioMandar);
                    xhr.send(data);

                    butterup.toast({
                        title: "ARRASTRES",
                        message: "FOLIO N." + folioA + " ENVIADO A " + informacionDeContacto + ".",
                        type: "success",
                        icon: true,
                    })
                } else if (correoEnviar == "true" && !informacionDeContacto.includes("@")) {
                    butterup.toast({
                        title: "ARRASTRES",
                        message: "FOLIO N." + folioA + " SIN INFORMACION DE CONTACTO VALIDA.",
                        type: "error",
                        icon: true,
                    })
                }

                if (correoEnviar == "false") {
                    butterup.toast({
                        title: "ARRASTRES",
                        message: "DESCARGANDO FOLIO N." + folioA + ".",
                        type: "success",
                        icon: true,
                    })

                    pdf.save("ARRASTRE_FOLIO_N." + folioA + ".pdf");
                }
            }
        </script>
        <?php
    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/Exception.php';
    require '../PHPMailer/PHPMailer.php';
    require '../PHPMailer/SMTP.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pdfContent'])) {
        $pdfContentBase64 = $_POST['pdfContent'];
        $contactoCorreo = $_POST['contacto'];
        $folioFormato = $_POST['folioMandar'];

        // Decodificar la cadena base64 del PDF
        $pdfContent = base64_decode(str_replace('data:application/pdf;base64,', '', $pdfContentBase64));


        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            // $mail->Host       = 'smtp.example.com';                  //Set the SMTP server to send through
            $mail->Host = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'brayanaviles2017@gmail.com';                     //SMTP username
            $mail->Password = 'kpka vmmy sywp oflu';                             //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
            //Recipients
            $mail->setFrom('brayanaviles2017@gmail.com', 'DEDSA ARRASTRES');
            $mail->addAddress($contactoCorreo);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
    
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            $mail->addStringAttachment($pdfContent, "ARRASTRE_FOLIO_N." . $folioFormato . ".pdf", 'base64', 'application/pdf');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "ARRASTRE_FOLIO_N." . $folioFormato;
            $mail->Body = "ARRASTRE_FOLIO_N." . $folioFormato;
            $mail->AltBody = "ARRASTRE_FOLIO_N." . $folioFormato;

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
    ?>

    <?php
    function canvasIsBlank($fileData)
    {
        $img = imagecreatefromstring($fileData);
        $width = imagesx($img);
        $height = imagesy($img);

        // Iterar a través de los píxeles y verificar si todos son transparentes
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgba = imagecolorat($img, $x, $y);
                $alpha = ($rgba >> 24) & 0xff;

                if ($alpha !== 127 && $alpha !== 0) {
                    // Si encuentra un píxel no transparente, el lienzo no está en blanco
                    return false;
                }
            }
        }

        // Si todos los píxeles son transparentes, el lienzo está en blanco
        return true;
    }
    ?>

    <?php
    if (isset($_POST["registrar"])) {
        realizarRegistroServicio($conexion);
    }

    if (isset($_POST["registrarFormulario"])) {
        realizarEdicionServicio($conexion);
    }

    if (!empty($_GET["folioEliminar"])) {
        $folio = $_GET["folioEliminar"];
        $firmaEntregaActualBorrar = $_GET["firmaEntregaActualBorrar"];
        $firmaRecibeActualBorrar = $_GET["firmaRecibeActualBorrar"];
        $firmaOperadorActualBorrar = $_GET["firmaOperadorActualBorrar"];

        $sql = $conexion->prepare(
            "DELETE FROM viajes_lanzados WHERE folio = ?"
        );
        $sql->bind_param("s", $folio);

        if (file_exists("../firmas/" . $firmaEntregaActualBorrar)) {
            if (unlink("../firmas/" . $firmaEntregaActualBorrar)) {
                // echo "El archivo $firmaEntregaActual fue eliminado correctamente.";
            }
        }

        if (file_exists("../firmas/" . $firmaRecibeActualBorrar)) {
            if (unlink("../firmas/" . $firmaRecibeActualBorrar)) {
                // echo "El archivo $firmaEntregaActual fue eliminado correctamente.";
            }
        }

        if (file_exists("../firmas/" . $firmaOperadorActualBorrar)) {
            if (unlink("../firmas/" . $firmaOperadorActualBorrar)) {
                // echo "El archivo $firmaEntregaActual fue eliminado correctamente.";
            }
        }

        if ($sql->execute()) {
            ?>
            <script>
                butterup.toast({
                    title: "ARRASTRES",
                    message: <?php echo json_encode("EL FOLIO N." . strtoupper($folio) . " SE HA ELIMINADO CORRECTAMENTE."); ?>,
                    type: "success",
                    icon: true,
                })
            </script>
            <?php
        } else {
            ?>
            <script>
                butterup.toast({
                    title: "ARRASTRES",
                    message: <?php echo json_encode("EL FOLIO N." . strtoupper($folio) . " NO SE HA ELIMINADO."); ?>,
                    type: "error",
                    icon: true,
                })
            </script>
            <?php
        }
    }
    ?>

    <script>
        history.replaceState(null, null, location.pathname)
    </script>

    <?php
    $sqlGruas = "SELECT tipo FROM gruas GROUP BY tipo";
    $tiposG = $conexion->query($sqlGruas);

    $sqlEconomico = "SELECT economico FROM gruas GROUP BY economico";
    $nEconomico = $conexion->query($sqlEconomico);

    $sqlOperadores = "SELECT nombre FROM operadores";
    $nOperadores = $conexion->query($sqlOperadores);
    ?>

    <!-- INSERTAR -->
    <div class="modal fade" tabindex="-1" id="formularioArrastres" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">REGISTRAR ARRASTRE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="borrarFirmas()"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" action="lanzarAdmin" method="POST"
                        onsubmit="return validarFormularioArrastres()">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="lugarExpedicion">LUGAR DE EXPEDICIÓN:</label>
                                <input type="text" id="lugarExpedicion" name="lugarExpedicion" required
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="fechaExpedicion">FECHA DE EXPEDICIÓN:</label>
                                <input type="datetime-local" id="fechaExpedicion" name="fechaExpedicion"
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="solicitante">SOLICITANTE DEL SERVICIO:</label>
                                <input type="text" id="solicitante" name="solicitante" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="tipoVehiculoArrastrado">TIPO DE VEHICULO ARRASTRADO:</label>
                                <input type="text" id="tipoVehiculoArrastrado" name="tipoVehiculoArrastrado" required
                                    class="form-control">
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-2">
                                <label for="marca">MARCA:</label>
                                <input type="text" id="marca" name="marca" class="form-control" required>
                            </div>

                            <div class="col-md-2">
                                <label for="placas">PLACAS:</label>
                                <input type="text" id="placas" name="placas" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label for="color">COLOR:</label>
                                <input type="text" id="color" name="color" required class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label for="anioModelo">AÑO/MODELO:</label>
                                <input type="text" id="anioModelo" name="anioModelo" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label for="serie">SERIE:</label>
                                <input type="text" id="serie" name="serie" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="motivoServicio">MOTIVO DE SERVICIO:</label>
                                <input type="text" id="motivoServicio" name="motivoServicio" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-3">
                                <label for="lugarHoraEnganche">LUGAR DE ENGANCHE:</label>
                                <input type="text" id="lugarHoraEnganche" name="lugarHoraEnganche" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="fechaHoraEnganche">HORA DE ENGANCHE:</label>
                                <input type="datetime-local" id="fechaHoraEnganche" name="fechaHoraEnganche"
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="destino">DESTINO:</label>
                                <input type="text" id="destino" name="destino" class="form-control" required>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="horaDesenganche">HORA DEL DESENGANCHE:</label>
                                <input type="datetime-local" id="horaDesenganche" name="horaDesenganche"
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="tipoGrua">TIPO DE GRUA:</label>
                                <select id="tipoGrua" name="tipoGrua" class="form-control" required>
                                    <option selected disabled value="">TIPO DE GRUA</option>
                                    <?php
                                    while ($row_gruas = $tiposG->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row_gruas["tipo"]; ?>">
                                            <?php echo $row_gruas["tipo"]; ?>
                                        </option>
                                    <?php }
                                    ?>

                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="numEconomicoGrua">N. ECONOMICO DE GRUA:</label>
                                <select id="numEconomicoGrua" name="numEconomicoGrua" class="form-control" required>
                                    <option selected disabled value="">N. ECONOMICO</option>
                                    <?php
                                    while ($row_economico = $nEconomico->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row_economico["economico"]; ?>">
                                            <?php echo $row_economico["economico"]; ?>
                                        </option>
                                    <?php }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="numVehiculosArrastrados">N. DE VEHÍCULOS ARRASTRADOS:</label>
                                <input type="number" id="numVehiculosArrastrados" name="numVehiculosArrastrados"
                                    required class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="nombrePersonaEntrega">NOMBRE DE PERSONA QUE ENTREGA:</label>
                                <input type="text" id="nombrePersonaEntrega" name="nombrePersonaEntrega"
                                    class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="nombrePersonaRecibe">NOMBRE DE PERSONA QUE RECIBE:</label>
                                <input type="text" id="nombrePersonaRecibe" name="nombrePersonaRecibe"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="personaEntrega">PERSONA QUE ENTREGA EL VEHÍCULO:</label>
                                <input type="hidden" name="personaEntregaCanva" value="" id="personaEntregaCanva">
                                <canvas id="personaEntrega" class="signature-canvas"
                                    style="border: 1px solid #000;"></canvas>
                                <button type="button" class="btn btn-secondary" onclick="limpiarFirmaEntrega()">BORRAR
                                    FIRMA</button>
                            </div>
                            <div class="col-md-6">
                                <label for="personaRecibe">PERSONA QUE RECIBE EL VEHÍCULO:</label>
                                <input type="hidden" name="personaRecibeCanva" value="" id="personaRecibeCanva">
                                <canvas id="personaRecibe" class="signature-canvas"
                                    style="border: 1px solid #000;"></canvas>
                                <button type="button" class="btn btn-secondary" onclick="limpiarFirmaRecibe()">BORRAR
                                    FIRMA</button>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="maniobrasEspeciales">MANIOBRAS ESPECIALES:</label>
                                <textarea type="text" id="maniobrasEspeciales" name="maniobrasEspeciales" rows="4"
                                    cols="50" class="form-control"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="observaciones">OBSERVACIONES:</label>
                                <textarea type="text" id="observaciones" name="observaciones" rows="4" cols="50"
                                    class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="nombreOperador">NOMBRE Y FIRMA DEL OPERADOR:</label>
                                <select id="nombreOperador" name="nombreOperador" class="form-control" required
                                    style="margin-bottom: 20px;">
                                    <option selected disabled value="">NOMBRE DEL OPERADOR</option>
                                    <?php
                                    while ($row_operadores = $nOperadores->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row_operadores["nombre"]; ?>">
                                            <?php echo $row_operadores["nombre"]; ?>
                                        </option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="hidden" name="firmaOperadorCanva" value="" id="firmaOperadorCanva">
                                <canvas id="firmaOperador" width="725" height="200"
                                    style="border: 1px solid #000;"></canvas>
                                <button type="button" class="btn btn-secondary" onclick="limpiarFirmaOperador()">BORRAR
                                    FIRMA</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="informacionDeContacto">INFORMACION DE CONTACTO:</label>
                                <input type="text" id="informacionDeContacto" name="informacionDeContacto"
                                    class="form-control">
                            </div>
                        </div>

                        <script>
                            var firmaOperador = new SignaturePad(document.getElementById('firmaOperador'));
                            firmaOperador.onEnd = function () {
                                document.getElementById('firmaOperador').value = firmaOperador.toDataURL();
                            };

                            var personaEntrega = new SignaturePad(document.getElementById('personaEntrega'));
                            personaEntrega.onEnd = function () {
                                document.getElementById('personaEntrega').value = personaEntrega.toDataURL();
                            };

                            var personaRecibe = new SignaturePad(document.getElementById('personaRecibe'));
                            personaRecibe.onEnd = function () {
                                document.getElementById('personaRecibe').value = personaRecibe.toDataURL();
                            };

                            function limpiarFirmaOperador() {
                                firmaOperador.clear();

                            }

                            var firmaEntregaCanvas = document.getElementById("personaEntrega");
                            var firmaRecibeCanvas = document.getElementById("personaRecibe");

                            var ctxEntrega = firmaEntregaCanvas.getContext("2d");
                            var ctxRecibe = firmaRecibeCanvas.getContext("2d");

                            function ajustarTamanoCanvas() {
                                var anchoVentana = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

                                // Define el nuevo ancho del canvas en función del ancho de la ventana
                                var nuevoAnchoCanvas = anchoVentana < 768 ? anchoVentana * 0.9 : 725;

                                // Guarda el contenido actual del canvas
                                var firmaEntregaData = ctxEntrega.getImageData(0, 0, firmaEntregaCanvas.width, firmaEntregaCanvas.height);
                                var firmaRecibeData = ctxRecibe.getImageData(0, 0, firmaRecibeCanvas.width, firmaRecibeCanvas.height);

                                // Aplica el nuevo ancho al canvas
                                firmaEntregaCanvas.width = nuevoAnchoCanvas;
                                firmaRecibeCanvas.width = nuevoAnchoCanvas;

                                // Restaura el contenido al canvas con el nuevo ancho
                                ctxEntrega.putImageData(firmaEntregaData, 0, 0);
                                ctxRecibe.putImageData(firmaRecibeData, 0, 0);
                            }

                            window.addEventListener("resize", ajustarTamanoCanvas);

                            ajustarTamanoCanvas();

                            function limpiarFirmaEntrega() {
                                ctxEntrega.clearRect(0, 0, firmaEntregaCanvas.width, firmaEntregaCanvas.height);
                            }

                            function limpiarFirmaRecibe() {
                                ctxRecibe.clearRect(0, 0, firmaRecibeCanvas.width, firmaRecibeCanvas.height);
                            }

                            function agregarFirmaAlFormulario() {
                                var operadorFirma = document.getElementById('firmaOperador');
                                var firmaOperadorData = operadorFirma.toDataURL();
                                document.getElementById('firmaOperadorCanva').value = firmaOperadorData;

                                var entregaFirma = document.getElementById('personaEntrega');
                                var firmaEntregaData = entregaFirma.toDataURL();
                                document.getElementById('personaEntregaCanva').value = firmaEntregaData;

                                var recibeFirma = document.getElementById('personaRecibe');
                                var firmaRecibeData = recibeFirma.toDataURL();
                                document.getElementById('personaRecibeCanva').value = firmaRecibeData;

                            }

                            document.querySelector('form').addEventListener('submit', agregarFirmaAlFormulario);
                        </script>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button class="btn btn-primary" type="submit" name="registrar" id="registrarBtn">
                                REGISTRAR
                            </button>

                            <button class="btn btn-primary d-none" type="button" disabled id="loadingBtn">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                CARGANDO...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <?php
    $tiposG->data_seek(0);
    $nEconomico->data_seek(0);
    $nOperadores->data_seek(0);

    ?>

    <!-- ACTUALIZAR -->
    <div class="modal fade" tabindex="-1" id="formularioArrastresEditar"
        aria-labelledby="formularioArrastresEditarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ACTUALIZAR ARRASTRE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="borrarFirmas()"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditar" class="row g-3 needs-validation" action="lanzarAdmin" method="POST"
                        onsubmit="return validarFormularioArrastresEditar()">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <input type="hidden" name="firmaEntregaActual" value="" id="firmaEntregaActual">
                                <input type="hidden" name="firmaRecibeActual" value="" id="firmaRecibeActual">
                                <input type="hidden" name="firmaOperadorActual" value="" id="firmaOperadorActual">

                                <input type="hidden" name="folioEditar" value="" id="folioEditar">
                                <label for="lugarExpedicionEditar">LUGAR DE EXPEDICIÓN:</label>
                                <input type="text" id="lugarExpedicionEditar" name="lugarExpedicionEditar" required
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="fechaExpedicionEditar">FECHA DE EXPEDICIÓN:</label>
                                <input type="datetime-local" id="fechaExpedicionEditar" name="fechaExpedicionEditar"
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="solicitanteEditar">SOLICITANTE DEL SERVICIO:</label>
                                <input type="text" id="solicitanteEditar" name="solicitanteEditar" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="tipoVehiculoArrastradoEditar">TIPO DE VEHICULO ARRASTRADO:</label>
                                <input type="text" id="tipoVehiculoArrastradoEditar" name="tipoVehiculoArrastradoEditar"
                                    required class="form-control">
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-2">
                                <label for="marcaEditar">MARCA:</label>
                                <input type="text" id="marcaEditar" name="marcaEditar" class="form-control" required>
                            </div>

                            <div class="col-md-2">
                                <label for="placasEditar">PLACAS:</label>
                                <input type="text" id="placasEditar" name="placasEditar" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label for="colorEditar">COLOR:</label>
                                <input type="text" id="colorEditar" name="colorEditar" required class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label for="anioModeloEditar">AÑO/MODELO:</label>
                                <input type="text" id="anioModeloEditar" name="anioModeloEditar" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label for="serieEditar">SERIE:</label>
                                <input type="text" id="serieEditar" name="serieEditar" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="motivoServicioEditar">MOTIVO DE SERVICIO:</label>
                                <input type="text" id="motivoServicioEditar" name="motivoServicioEditar"
                                    class="form-control" required>
                            </div>

                            <div class="col-md-3">
                                <label for="lugarHoraEngancheEditar">LUGAR DE ENGANCHE:</label>
                                <input type="text" id="lugarHoraEngancheEditar" name="lugarHoraEngancheEditar"
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="fechaHoraEngancheEditar">HORA DE ENGANCHE:</label>
                                <input type="datetime-local" id="fechaHoraEngancheEditar" name="fechaHoraEngancheEditar"
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="destinoEditar">DESTINO:</label>
                                <input type="text" id="destinoEditar" name="destinoEditar" class="form-control"
                                    required>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="horaDesengancheEditar">HORA DEL DESENGANCHE:</label>
                                <input type="datetime-local" id="horaDesengancheEditar" name="horaDesengancheEditar"
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="tipoGruaEditar">TIPO DE GRUA:</label>
                                <select id="tipoGruaEditar" name="tipoGruaEditar" class="form-control" required>
                                    <option selected disabled value="">TIPO DE GRUA</option>
                                    <?php
                                    while ($row_gruas = $tiposG->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row_gruas["tipo"]; ?>">
                                            <?php echo $row_gruas["tipo"]; ?>
                                        </option>
                                    <?php }
                                    ?>

                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="numEconomicoGruaEditar">N. ECONOMICO DE GRUA:</label>
                                <select id="numEconomicoGruaEditar" name="numEconomicoGruaEditar" class="form-control"
                                    required>
                                    <option selected disabled value="">N. ECONOMICO DE GRUA</option>
                                    <?php
                                    while ($row_economico = $nEconomico->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row_economico["economico"]; ?>">
                                            <?php echo $row_economico["economico"]; ?>
                                        </option>
                                    <?php }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="numVehiculosArrastradosEditar">N. DE VEHÍCULOS ARRASTRADOS:</label>
                                <input type="number" id="numVehiculosArrastradosEditar"
                                    name="numVehiculosArrastradosEditar" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="nombrePersonaEntregaEditar">NOMBRE DE PERSONA QUE ENTREGA</label>
                                <input type="text" id="nombrePersonaEntregaEditar" name="nombrePersonaEntregaEditar"
                                    class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="nombrePersonaRecibeEditar">NOMBRE DE PERSONA QUE RECIBE:</label>
                                <input type="text" id="nombrePersonaRecibeEditar" name="nombrePersonaRecibeEditar"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="personaEntregaEditar">PERSONA QUE ENTREGA EL VEHÍCULO:</label>
                                <input type="hidden" name="personaEntregaCanvaEditar" value=""
                                    id="personaEntregaCanvaEditar">
                                <canvas id="personaEntregaEditar" class="signature-canvas"
                                    style="border: 1px solid #000;"></canvas>
                                <button type="button" class="btn btn-secondary"
                                    onclick="limpiarFirmaEntregaEditar()">BORRAR FIRMA</button>
                            </div>
                            <div class="col-md-6">
                                <label for="personaRecibeRecibe">PERSONA QUE RECIBE EL VEHÍCULO:</label>
                                <input type="hidden" name="personaRecibeCanvaEditar" value=""
                                    id="personaRecibeCanvaEditar">
                                <canvas id="personaRecibeEditar" class="signature-canvas"
                                    style="border: 1px solid #000;"></canvas>
                                <button type="button" class="btn btn-secondary"
                                    onclick="limpiarFirmaRecibeEditar()">BORRAR FIRMA</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="maniobrasEspecialesEditar">MANIOBRAS ESPECIALES:</label>
                                <textarea type="text" id="maniobrasEspecialesEditar" name="maniobrasEspecialesEditar"
                                    rows="4" cols="50" class="form-control"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="observacionesEditar">OBSERVACIONES:</label>
                                <textarea type="text" id="observacionesEditar" name="observacionesEditar" rows="4"
                                    cols="50" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="nombreOperadorEditar">NOMBRE Y FIRMA DEL OPERADOR</label>
                                <select id="nombreOperadorEditar" name="nombreOperadorEditar" class="form-control"
                                    required style="margin-bottom: 20px;">
                                    <option selected disabled value="">NOMBRE DEL OPERADOR</option>
                                    <?php
                                    while ($row_operadores = $nOperadores->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row_operadores["nombre"]; ?>">
                                            <?php echo $row_operadores["nombre"]; ?>
                                        </option>
                                    <?php }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="observacionesEditar">LIBERADO:</label>
                                <select id="liberadoEditar" name="liberadoEditar" class="form-control">
                                    <option selected disabled value="">SELECCIONE</option>
                                    <option value="LIBERADO">LIBERADO</option>
                                    <option value="NO LIBERADO">NO LIBERADO</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="hidden" name="firmaOperadorCanvaEditar" value=""
                                    id="firmaOperadorCanvaEditar">
                                <canvas id="firmaOperadorEditar" width="725" height="200"
                                    style="border: 1px solid #000;"></canvas>
                                <button type="button" class="btn btn-secondary"
                                    onclick="limpiarFirmaOperadorEditar()">BORRAR FIRMA</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="informacionDeContactoEditar">INFORMACION DE CONTACTO:</label>
                                <input type="text" id="informacionDeContactoEditar" name="informacionDeContactoEditar"
                                    class="form-control">
                            </div>
                        </div>

                        <script>
                            var firmaOperadorEditar = new SignaturePad(document.getElementById('firmaOperadorEditar'));
                            firmaOperadorEditar.onEnd = function () {
                                document.getElementById('firmaOperadorEditar').value = firmaOperadorEditar.toDataURL();
                            };

                            var personaEntregaEditar = new SignaturePad(document.getElementById('personaEntregaEditar'));
                            personaEntregaEditar.onEnd = function () {
                                document.getElementById('personaEntregaEditar').value = personaEntregaEditar.toDataURL();
                            };

                            var personaRecibeEditar = new SignaturePad(document.getElementById('personaRecibeEditar'));
                            personaRecibeEditar.onEnd = function () {
                                document.getElementById('personaRecibeEditar').value = personaRecibe.toDataURL();
                            };

                            function limpiarFirmaOperadorEditar() {
                                firmaOperadorEditar.clear();
                            }

                            var firmaEntregaCanvasEditar = document.getElementById("personaEntregaEditar");
                            var firmaRecibeCanvasEditar = document.getElementById("personaRecibeEditar");

                            var ctxEntregaEditar = firmaEntregaCanvasEditar.getContext("2d");
                            var ctxRecibeEditar = firmaRecibeCanvasEditar.getContext("2d");

                            function ajustarTamanoCanvasEditar() {
                                var anchoVentana = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

                                // Define el nuevo ancho del canvas en función del ancho de la ventana
                                var nuevoAnchoCanvas = anchoVentana < 768 ? anchoVentana * 0.9 : 725;

                                // Guarda el contenido actual del canvas
                                var firmaEntregaDataEditar = ctxEntregaEditar.getImageData(0, 0, firmaEntregaCanvasEditar.width, firmaEntregaCanvasEditar.height);
                                var firmaRecibeDataEditar = ctxRecibeEditar.getImageData(0, 0, firmaRecibeCanvasEditar.width, firmaRecibeCanvasEditar.height);

                                // Aplica el nuevo ancho al canvas
                                firmaEntregaCanvasEditar.width = nuevoAnchoCanvas;
                                firmaRecibeCanvasEditar.width = nuevoAnchoCanvas;

                                // Restaura el contenido al canvas con el nuevo ancho
                                ctxEntregaEditar.putImageData(firmaEntregaDataEditar, 0, 0);
                                ctxRecibeEditar.putImageData(firmaRecibeDataEditar, 0, 0);
                            }

                            window.addEventListener("resize", ajustarTamanoCanvasEditar);

                            ajustarTamanoCanvasEditar();

                            function limpiarFirmaEntregaEditar() {
                                ctxEntregaEditar.clearRect(0, 0, firmaEntregaCanvasEditar.width, firmaEntregaCanvasEditar.height);
                            }

                            function limpiarFirmaRecibeEditar() {
                                ctxRecibeEditar.clearRect(0, 0, firmaRecibeCanvasEditar.width, firmaRecibeCanvasEditar.height);
                            }

                            function borrarFirmas() {
                                limpiarFirmaEntregaEditar();
                                limpiarFirmaRecibeEditar();
                                limpiarFirmaOperadorEditar();
                            }

                            function agregarFirmaAlFormularioEditar() {
                                var operadorFirmaEditar = document.getElementById('firmaOperadorEditar');
                                var firmaOperadorDataEditar = operadorFirmaEditar.toDataURL();
                                document.getElementById('firmaOperadorCanvaEditar').value = firmaOperadorDataEditar;

                                var entregaFirmaEditar = document.getElementById('personaEntregaEditar');
                                var firmaEntregaDataEditar = entregaFirmaEditar.toDataURL();
                                document.getElementById('personaEntregaCanvaEditar').value = firmaEntregaDataEditar;

                                var recibeFirmaEditar = document.getElementById('personaRecibeEditar');
                                var firmaRecibeData = recibeFirmaEditar.toDataURL();
                                document.getElementById('personaRecibeCanvaEditar').value = firmaRecibeData;
                            }

                            document.getElementById('formEditar').addEventListener('submit', agregarFirmaAlFormularioEditar);
                        </script>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                onclick="borrarFirmas()">Cerrar</button>
                            <button class="btn btn-primary" type="submit" name="registrarFormulario" id="registrarBtn">
                                ACTUALIZAR ARRASTRE
                            </button>

                            <button class="btn btn-primary d-none" type="button" disabled id="loadingBtn">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                CARGANDO...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>
        <button class="buttonNew" name="nuevo" type="button" value="nuevo" data-bs-toggle="modal"
            data-bs-target="#formularioArrastres"> <i class="fa-solid fa-circle-plus"></i> NUEVO</button>

        <table id="tablax" class="table table-striped table-bordered" style="width: 100%">

            <thead>
                <th class="centered">FOLIO</th>
                <th class="centered">LUGAR Y FECHA DE EXPEDICION</th>
                <th class="centered">MARCA</th>
                <th class="centered">PLACA</th>
                <th class="centered">COLOR</th>
                <th class="centered">TIPO DE GRUA</th>
                <th class="centered">ECONOMICO</th>
                <th class="centered">LIBERADO</th>
                <th class="centered">ACCION</th>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT folio, lugarExpedicion, fechaExpedicion, marca, placas, color, tipogrua, numEconomicoGrua, personaEntrega, personaRecibe, firmaOperador, liberado FROM viajes_lanzados";
                $result = mysqli_query($conexion, $sql);

                while ($mostrar = mysqli_fetch_array($result)) {
                    $modalId = "confirmarEliminacion_" . $mostrar["folio"];
                    ?>
                    <tr>
                        <td>
                            <?php echo $mostrar["folio"]; ?>
                        </td>
                        <td>
                            <?php echo $mostrar["lugarExpedicion"] .
                                " - FECHA: " .
                                $mostrar["fechaExpedicion"]; ?>
                        </td>
                        <td>
                            <?php echo $mostrar["marca"]; ?>
                        </td>
                        <td>
                            <?php echo $mostrar["placas"]; ?>
                        </td>
                        <td>
                            <?php echo $mostrar["color"]; ?>
                        </td>
                        <td>
                            <?php echo $mostrar["tipogrua"]; ?>
                        </td>
                        <td>
                            <?php echo $mostrar["numEconomicoGrua"]; ?>
                        </td>
                        <td>
                            <?php
                            if ($mostrar["liberado"] == "NO LIBERADO") {
                                ?>
                                <i class="fa-solid fa-circle" style="color: rgb(255,0,0);"></i>
                                <?php
                            } elseif ($mostrar["liberado"] == "LIBERADO") {
                                ?>
                                <i class="fa-solid fa-circle" style="color: rgb(0,255,0);"></i>
                                <?php
                            }
                            ?>
                        </td>
                        <td>

                            <!-- <a type="button" id="borrarBtn" name="borrarBtn" class="btn btn-danger" data-bs-toggle="modal"
                                href="#<?php echo $modalId; ?>">
                                <i class="fa-solid fa-trash" style="color: #fff;"></i>
                            </a>

                            <a type="button" id="editarBtn" name="editarBtn" class="btn btn-success editbtnArrastre"
                                data-bs-toggle="modal" data-bs-target="#formularioArrastresEditar"
                                data-bs-folio="<?= $mostrar["folio"] ?>"><i class="fa-solid fa-pen-to-square"
                                    style="color: #fff"></i></a>


                            <a type="button" id="descargarBtn" name="descargarBtn"
                                href="lanzarAdmin?folio=<?= $mostrar["folio"] ?>" class="btn btn-success"><i
                                    class="fa-solid fa-download" style="color: #fff"></i></a>

                            <a type="button" id="qrBtn" name="qrBtn" href="#" class="btn btn-warning"><i
                                    class="fa-solid fa-qrcode"></i></a> -->

                            <div class="btn-group">
                                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-gear" style="color: #fff"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" id="descargarBtn" name="descargarBtn"
                                        href="lanzarAdmin?folio=<?= $mostrar["folio"] ?>&correoEnviar=false"><i
                                            class="fa-solid fa-download"></i> DESCARGAR</a>

                                    <a class="dropdown-item" id="editarBtn" name="editarBtn" data-bs-toggle="modal"
                                        data-bs-target="#formularioArrastresEditar"
                                        data-bs-folio="<?= $mostrar["folio"] ?>"><i class="fa-solid fa-pen-to-square"></i>
                                        EDITAR</a>

                                    <a class="dropdown-item" id="qrBtn" name="qrBtn" href="#"><i
                                            class="fa-solid fa-qrcode"></i> GENERAR QR</a>

                                    <a class="dropdown-item" id="enviarBtn" name="enviarBtn"
                                        href="lanzarAdmin?folio=<?= $mostrar["folio"] ?>&correoEnviar=true"><i
                                            class="fa-solid fa-envelope"></i> ENVIAR POR CORREO</a>

                                    <a class="dropdown-item" id="borrarBtn" name="borrarBtn" data-bs-toggle="modal"
                                        href="#<?php echo $modalId; ?>"><i class="fa-solid fa-trash"></i> BORRAR</a>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ELIMINAR ARRASTRE</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Seguro que quieres eliminar el viaje
                                        <?= $mostrar["folio"] ?>?
                                    </p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <a type="button" id="btnConfirmacion"
                                        href="lanzarAdmin?folioEliminar=<?= $mostrar["folio"] ?>&firmaEntregaActualBorrar=<?= $mostrar["personaEntrega"] ?>&firmaRecibeActualBorrar=<?= $mostrar["personaRecibe"] ?>&firmaOperadorActualBorrar=<?= $mostrar["firmaOperador"] ?>"
                                        class="btn btn-danger"
                                        onclick="btnConfirmacion('<?php echo $modalId; ?>')">Eliminar</a>

                                    <button id="btnLoadingEliminacion" class="btn btn-danger d-none" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        CARGANDO...
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </tbody>
        </table>
    </section>

    <!-- ENVIAR PDF POR CORREO -->


    <script>
        $(document).ready(function () {
            $('#tablax').DataTable({
                scrollX: "100%",
                columnDefs: [{
                    className: "centered",
                    width: "1%",
                    targets: [0]
                },
                {
                    className: "centered",
                    width: "15%",
                    //"searchable": false,
                    targets: [1]
                },
                {
                    className: "centered",
                    width: "10%",
                    //"searchable": false,
                    targets: [2]
                },
                {
                    className: "centered",
                    width: "5%",
                    //"searchable": false,
                    targets: [3]
                },
                {
                    className: "centered",
                    width: "10%",
                    //"searchable": false,
                    targets: [4]
                },
                {
                    className: "centered",
                    width: "7%",
                    //"searchable": false,
                    targets: [5]
                },
                {
                    className: "centered",
                    width: "7%",
                    //"searchable": false,
                    targets: [6]
                },
                {
                    className: "centered",
                    width: "1%",
                    //"searchable": false,
                    targets: [7]
                },
                {
                    className: "centered",
                    width: "1%",
                    //"searchable": false,
                    targets: [8]
                }
                ],
                destroy: true,
                language: {
                    processing: "TRATAMIENTO EN CURSO...",
                    search: "BUSCAR:",
                    lengthMenu: "AGRUPAR DE _MENU_ ITEMS",
                    info: "MOSTRANDO DEL ITEM _START_ AL _END_ DE UN TOTAL DE _TOTAL_ ITEMS",
                    infoEmpty: "NO EXISTEN DATOS.",
                    infoFiltered: "(filtrado de _MAX_ elementos en total)",
                    infoPostFix: "",
                    loadingRecords: "CARGANDO...",
                    zeroRecords: "NO SE ENCONTRARON DATOS EN TU BUSQUEDA",
                    emptyTable: "NO HAY DATOS DISPONIBLES EN LA TABLA.",
                    paginate: {
                        first: "PRIMERO",
                        previous: "ANTERIOR",
                        next: "SIGUIENTE",
                        last: "ULTIMO"
                    },
                    aria: {
                        sortAscending: ": active para ordenar la columna en orden ascendente",
                        sortDescending: ": active para ordenar la columna en orden descendente"
                    }
                },
                lengthMenu: [
                    [5, 10, 25, -1],
                    [5, 10, 25, "All"]
                ],
            });
        });
    </script>

    <script>
        let editaModal = document.getElementById('formularioArrastresEditar');

        editaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let folio = button.getAttribute('data-bs-folio')

            let inputFolio = editaModal.querySelector('.modal-body #folioEditar')
            let lugarExpedicionEditar = editaModal.querySelector('.modal-body #lugarExpedicionEditar')
            let fechaExpedicionEditar = editaModal.querySelector('.modal-body #fechaExpedicionEditar')
            let solicitanteEditar = editaModal.querySelector('.modal-body #solicitanteEditar')
            let tipoVehiculoArrastradoEditar = editaModal.querySelector('.modal-body #tipoVehiculoArrastradoEditar')
            let marcaEditar = editaModal.querySelector('.modal-body #marcaEditar')
            let placasEditar = editaModal.querySelector('.modal-body #placasEditar')
            let colorEditar = editaModal.querySelector('.modal-body #colorEditar')
            let anioModeloEditar = editaModal.querySelector('.modal-body #anioModeloEditar')
            let serieEditar = editaModal.querySelector('.modal-body #serieEditar')
            let motivoServicioEditar = editaModal.querySelector('.modal-body #motivoServicioEditar')
            let lugarHoraEngancheEditar = editaModal.querySelector('.modal-body #lugarHoraEngancheEditar')
            let destinoEditar = editaModal.querySelector('.modal-body #destinoEditar')
            let fechaHoraEngancheEditar = editaModal.querySelector('.modal-body #fechaHoraEngancheEditar')
            let horaDesengancheEditar = editaModal.querySelector('.modal-body #horaDesengancheEditar')
            let numVehiculosArrastradosEditar = editaModal.querySelector('.modal-body #numVehiculosArrastradosEditar')
            let maniobrasEspecialesEditar = editaModal.querySelector('.modal-body #maniobrasEspecialesEditar')
            let observacionesEditar = editaModal.querySelector('.modal-body #observacionesEditar')
            let liberado = editaModal.querySelector('.modal-body #liberadoEditar')
            let informacionDeContactoEditar = editaModal.querySelector('.modal-body #informacionDeContactoEditar')


            let tipoGruaEditar = editaModal.querySelector('.modal-body #tipoGruaEditar')
            let numEconomicoGruaEditar = editaModal.querySelector('.modal-body #numEconomicoGruaEditar')

            let firmaEntregaActual = editaModal.querySelector('.modal-body #firmaEntregaActual')
            let firmaRecibeActual = editaModal.querySelector('.modal-body #firmaRecibeActual')
            let firmaOperadorActual = editaModal.querySelector('.modal-body #firmaOperadorActual')

            let nombreOperadorEditar = editaModal.querySelector('.modal-body #nombreOperadorEditar')
            let nombrePersonaEntregaEditar = editaModal.querySelector('.modal-body #nombrePersonaEntregaEditar')
            let nombrePersonaRecibeEditar = editaModal.querySelector('.modal-body #nombrePersonaRecibeEditar')


            let personaEntregaEditar = editaModal.querySelector('.modal-body #personaEntregaEditar')
            var ctxEntrega = personaEntregaEditar.getContext("2d");
            let personaRecibeEditar = editaModal.querySelector('.modal-body #personaRecibeEditar')
            var ctxRecibe = personaRecibeEditar.getContext("2d");
            let firmaOperadorEditar = editaModal.querySelector('.modal-body #firmaOperadorEditar')
            var ctxOperador = firmaOperadorEditar.getContext("2d");




            let url = "../getArrastreDatos.php"
            let formData = new FormData();
            formData.append('folio', folio)

            fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
                .then(data => {
                    inputFolio.value = data.folio
                    lugarExpedicionEditar.value = data.lugarExpedicion
                    fechaExpedicionEditar.value = data.fechaExpedicion
                    solicitanteEditar.value = data.solicitante
                    tipoVehiculoArrastradoEditar.value = data.tipoVehiculoArrastrado
                    marcaEditar.value = data.marca
                    placasEditar.value = data.placas
                    colorEditar.value = data.color
                    anioModeloEditar.value = data.anioModelo
                    serieEditar.value = data.serie
                    motivoServicioEditar.value = data.motivoServicio
                    lugarHoraEngancheEditar.value = data.lugarHoraEnganche
                    destinoEditar.value = data.destino
                    fechaHoraEngancheEditar.value = data.fechaHoraEnganche
                    horaDesengancheEditar.value = data.horaDesenganche
                    numVehiculosArrastradosEditar.value = data.numVehiculosArrastrados
                    maniobrasEspecialesEditar.value = data.maniobrasEspeciales
                    observacionesEditar.value = data.observaciones
                    numEconomicoGruaEditar.value = data.numEconomicoGrua
                    tipoGruaEditar.value = data.tipogrua

                    firmaEntregaActual.value = data.personaEntrega
                    firmaRecibeActual.value = data.personaRecibe
                    firmaOperadorActual.value = data.firmaOperador

                    nombreOperadorEditar.value = data.nombreOperador
                    nombrePersonaEntregaEditar.value = data.nombrePersonaEntrega
                    nombrePersonaRecibeEditar.value = data.nombrePersonaRecibe


                    personaEntregaCanvaEditar.value = data.personaEntrega
                    personaRecibeCanvaEditar.value = data.personaRecibe
                    firmaOperadorEditar = data.firmaOperador
                    liberado.value = data.liberado
                    informacionDeContactoEditar.value = data.informacionDeContacto

                    var firmaPersonaEntrega = new Image();
                    var firmaPersonaRecibe = new Image();
                    var firmaOperador = new Image();

                    if (data.personaEntrega != 'Sin Firma') {
                        firmaPersonaEntrega.src = "../firmas/" + data.personaEntrega;
                        firmaPersonaEntrega.onload = function () {
                            ctxEntrega.drawImage(firmaPersonaEntrega, 0, 0);
                        }
                    }

                    if (data.personaRecibe != 'Sin Firma') {
                        firmaPersonaRecibe.src = "../firmas/" + data.personaRecibe;
                        firmaPersonaRecibe.onload = function () {
                            ctxRecibe.drawImage(firmaPersonaRecibe, 0, 0);
                        }
                    }

                    if (data.firmaOperador != 'Sin Firma') {
                        firmaOperador.src = "../firmas/" + data.firmaOperador;
                        firmaOperador.onload = function () {
                            ctxOperador.drawImage(firmaOperador, 0, 0);
                        }
                    }

                }).catch(err => console.log(err))
        })
    </script>
</body>
<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement;
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });
</script>

</html>