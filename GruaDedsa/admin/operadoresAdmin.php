<!DOCTYPE html>
<html lang="es">

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
    <title>DEDSA - OPERADORES</title>
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DATATABLES -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
    </script>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
    </script>
    <script src="../js/main.js"></script>
    <script src="../butterup/butterup.min.js"></script>
    <script src="https://kit.fontawesome.com/d15e5b966b.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <?php include "../conexion.php"; ?>

    <?php
    session_start();

    if (isset($_SESSION["usuario"])) {
        $usuario = $_SESSION["usuario"];
        $permisos = $_SESSION["permisos"];

    } else {
        header("location: ../login");
        exit();
    }
    include("sliderbarAdmin.php");
    ?>

    <?php
    function realizarRegistroOperador($conexion)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = strtoupper($_POST["nombreLicencia"]);
            $nLicencias = strtoupper($_POST["Nlicencia"]);
            $tipo = $_POST["tipoLicencia"];
            try {
                $sql = "INSERT INTO operadores (nombre, licencia, tipo) VALUES ('$nombre', '$nLicencias', '$tipo')";
                $result = mysqli_query($conexion, $sql);

                if ($result) {
                    ?>
                    <script>
                        butterup.toast({
                            title: "OPERADORES",
                            message: "Operador " + "<?php echo $nombre; ?>" + " agregado correctamente.",
                            type: "success",
                            icon: true,
                        })
                    </script>
                    <?php
                }
            } catch (Exception $e) {
                ?>
                <script>
                    butterup.toast({
                        title: "OPERADORES",
                        message: <?php echo json_encode("El numero de licencia " . strtoupper($nLicencias) . " ya se encuentra registrado."); ?>,
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
    function realizarEdicionOperador($conexion)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $licenciaAct = $_POST["licenciaAct"];
            $nombre = strtoupper($_POST["nombreLicenciaEditar"]);
            $nLicencias = strtoupper($_POST["NlicenciaEditar"]);
            $tipo = $_POST["tipoLicenciaEditar"];
            try {
                $sql = "UPDATE operadores SET nombre = '$nombre', licencia = '$nLicencias', tipo = '$tipo' WHERE licencia = '$licenciaAct'";
                $result = mysqli_query($conexion, $sql);

                if ($result) {
                    ?>
                    <script>
                        butterup.toast({
                            title: "OPERADORES",
                            message: "Operador " + "<?php echo $nombre; ?>" + " actualizado correctamente.",
                            type: "success",
                            icon: true,
                        })
                    </script>
                    <?php
                }
            } catch (Exception $e) {
                ?>
                <script>
                    butterup.toast({
                        title: "OPERADORES",
                        message: <?php echo json_encode("El numero de licencia " . strtoupper($nLicencias) . " ya se encuentra registrado."); ?>,
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
    if (isset($_POST['registrarOperador'])) {
        realizarRegistroOperador($conexion);
    }

    if (isset($_POST['editarOperador'])) {
        realizarEdicionOperador($conexion);
    }

    if (!empty($_GET["licencia"])) {
        $licencia = $_GET["licencia"];
    
        $sql = $conexion->prepare("DELETE FROM operadores WHERE licencia = ?");
        $sql->bind_param("s", $licencia);
    
        if ($sql->execute()) {
            ?>
            <script>
                butterup.toast({
                    title: "OPERADORES",
                    message: <?php echo json_encode("Licencia " . strtoupper($licencia) . " se ha eliminado correctamente."); ?>,
                    type: "success",
                    icon: true,
                })
            </script>
            <?php
        }else {
            ?>
            <script>
                butterup.toast({
                    title: "OPERADORES",
                    message: <?php echo json_encode("Licencia " . strtoupper($licencia) . "no se ha eliminado."); ?>,
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

    <!-- INSERTAR -->
    <div class="modal fade" tabindex="-1" id="formularioOperadores" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">REGISTRAR OPERADORES</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" action="operadoresAdmin" method="POST"
                        onsubmit="return validarFormularioOperadores()">
                        <div class="col-md-4 position-relative">
                            <label for="nombreLicencia" class="form-label">NOMBRE</label>
                            <input type="text" class="form-control" id="nombreLicencia" name="nombreLicencia"
                                placeholder="NOMBRE" required>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="Nlicencia" class="form-label">N. LICENCIA</label>
                            <input type="text" class="form-control" id="Nlicencia" name="Nlicencia"
                                placeholder="N. LICENCIA" required>
                        </div>

                        <div class="col-md-4 position-relative">
                            <label for="tipoLicencia" class="form-label">TIPO DE LICENCIA</label>
                            <select name="tipoLicencia" class="form-select" id="tipoLicencia" required>
                                <option selected disabled value="">TIPO DE LICENCIA</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button class="btn btn-primary" type="submit" name="registrarOperador" id="registrarBtn">
                                REGISTRAR OPERADOR
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

    <!-- ACTUALIZAR -->
    <div class="modal fade" tabindex="-1" id="formularioOperadoresEditar" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ACTUALIZAR OPERADORES</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" action="operadoresAdmin" method="POST"
                        onsubmit="return validarFormularioOperadoresEditar()">
                        <div class="col-md-4 position-relative">
                            <input type="hidden" name="licenciaAct" value="" id="licenciaAct">
                            <label for="nombreLicenciaEditar" class="form-label">NOMBRE</label>
                            <input type="text" class="form-control" id="nombreLicenciaEditar"
                                name="nombreLicenciaEditar" placeholder="NOMBRE" required>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="NlicenciaEditar" class="form-label">N. LICENCIA</label>
                            <input type="text" class="form-control" id="NlicenciaEditar" name="NlicenciaEditar"
                                placeholder="N. LICENCIA" required>
                        </div>

                        <div class="col-md-4 position-relative">
                            <label for="tipoLicenciaEditar" class="form-label">TIPO DE LICENCIA</label>
                            <select name="tipoLicenciaEditar" class="form-select" id="tipoLicenciaEditar" required>
                                <option selected disabled value="">TIPO DE LICENCIA</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button class="btn btn-primary" type="submit" name="editarOperador" id="editarBtn">
                                ACTUALIZAR OPERADOR
                            </button>

                            <button class="btn btn-primary d-none" type="button" disabled id="loadingEditarBtn">
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
            data-bs-target="#formularioOperadores"> <i class="fa-solid fa-user"></i> NUEVO</button>

        <table id="tablax" class="table table-striped table-bordered" style="width: 100%">
            <thead>
                <th class = "centered">NOMBRE</th>
                <th class = "centered">N. LICENCIA</th>
                <th class = "centered">TIPO</th>
                <th class = "centered">ACCION</th>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT nombre, licencia, tipo FROM operadores";
                $result = mysqli_query($conexion, $sql);

                while ($mostrar = mysqli_fetch_array($result)) {
                    $modalId = "confirmarEliminacion_" . $mostrar['licencia'];
                    ?>
                    <tr>
                        <td>
                            <?php echo $mostrar['nombre'] ?>
                        </td>
                        <td>
                            <?php echo $mostrar['licencia'] ?>
                        </td>
                        <td>
                            <?php echo $mostrar['tipo'] ?>
                        </td>
                        <td>

                            <a type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="<?php echo "#" . $modalId; ?>">
                                <i class="fa-solid fa-trash" style="color: #fff;"></i>
                            </a>

                            <a type="button" class="btn btn-success editbtnOperadores" data-bs-toggle="modal"
                                data-bs-target="#formularioOperadoresEditar"><i class="fa-solid fa-pen-to-square"
                                    style="color: #fff"></i></a>
                        </td>
                    </tr>

                    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ELIMIAR OPERADOR</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>SEGURO QUE QUIERES ELIMINAR A
                                        <?= $mostrar['nombre'] ?>?
                                    </p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                                    <a type="button" href="operadoresAdmin?licencia=<?= $mostrar['licencia'] ?>"
                                        class="btn btn-danger" id="btnConfirmacion"
                                        onclick="btnConfirmacion('<?php echo $modalId; ?>')">ELIMINAR</a>

                                    <button id="btnLoadingEliminacion" class="btn btn-danger d-none" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Cargando...
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
    <script>
        $(document).ready(function () {
            $('#tablax').DataTable({
                scrollX: "100%",
                columnDefs: [{
                    className: "centered",
                    width: "30%",
                    targets: [0]
                },
                {
                    className: "centered",
                    width: "20%",
                    targets: [1]
                },
                {
                    className: "centered",
                    width: "1%",
                    targets: [2]
                },
                {
                    className: "centered",
                    width: "10%",
                    targets: [3]
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
        $(".editbtnOperadores").on("click", function () {
            $tr = $(this).closest("tr");
            var datos = $tr.children("td").map(function () {
                return $(this).text();
            });
            $("#licenciaAct").val(datos[1].trim());
            $("#nombreLicenciaEditar").val(datos[0].trim());
            $("#NlicenciaEditar").val(datos[1].trim());
            $("#tipoLicenciaEditar").val(datos[2].trim());
        });
    </script>
</body>
<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
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