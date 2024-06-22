<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../butterup/butterup.min.css" />
    <link rel="stylesheet" href="../css/styleservicio.css">
    <title>DEDSA - GRUAS</title>
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
    function realizarRegistroGrua($conexion)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $economico = $_POST["economico"];
            $razon = strtoupper($_POST["razon"]);
            $placa = strtoupper($_POST["placa"]);
            $modelo = $_POST["modelo"];
            $tipo = $_POST["tipo"];
            try {
                $sql = "INSERT INTO gruas (razon, economico, placa, modelo, tipo) VALUES ('$razon', '$economico', '$placa', '$modelo', '$tipo')";
                $result = mysqli_query($conexion, $sql);

                if ($result) {
                    ?>
                    <script>
                        butterup.toast({
                            title: "GRUAS",
                            message: "Grua " + "<?php echo $economico; ?>" + " agregada correctamente.",
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
                        title: "GRUAS",
                        message: <?php echo json_encode("La placa " . strtoupper($placa) . " ya se encuentra registrada."); ?>,
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
    function realizarEdicionGrua($conexion)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $placaAct = $_POST["placaAct"];
            $economico = $_POST["economicoEditar"];
            $razon = strtoupper($_POST["razonEditar"]);
            $placa = strtoupper($_POST["placaEditar"]);
            $modelo = $_POST["modeloEditar"];
            $tipo = $_POST["tipoEditar"];
            try {
                $sql = "UPDATE gruas SET economico = '$economico', razon = '$razon', placa = '$placa', modelo = '$modelo', tipo = '$tipo' WHERE placa = '$placaAct'";
                $result = mysqli_query($conexion, $sql);

                if ($result) {
                    ?>
                    <script>
                        butterup.toast({
                            title: "GRUAS",
                            message: "Grua " + "<?php echo $economico; ?>" + " actualizada correctamente.",
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
                        title: "GRUAS",
                        message: <?php echo json_encode("La placa " . strtoupper($placa) . " ya se encuentra registrada."); ?>,
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
    if (isset($_POST['registrarGrua'])) {
        realizarRegistroGrua($conexion);
    }

    if (isset($_POST['editarGrua'])) {
        realizarEdicionGrua($conexion);
    }

    if (!empty($_GET["placa"])) {
        $placa = $_GET["placa"];
    
        $sql = $conexion->prepare("DELETE FROM gruas WHERE placa = ?");
        $sql->bind_param("s", $placa);
    
        if ($sql->execute()) {
            ?>
            <script>
                butterup.toast({
                    title: "GRUAS",
                    message: "Grua con placa " + "<?php echo $placa; ?>" + " se ha eliminado correctamente.",
                    type: "success",
                    icon: true,
                })  
            </script>
            <?php
        } else {
            ?>
            <script>
                butterup.toast({
                    title: "GRUAS",
                    message: <?php echo json_encode("Grua con placa" + "<?php echo $placa; ?>" + " no se ha eliminado."); ?>,
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
    <div class="modal fade" tabindex="-1" id="formularioGruas" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">REGISTRAR GRUAS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" action="gruasAdmin.php" method="POST"
                        onsubmit="return validarFormularioGruas()">
                        <div class="col-md-4 position-relative">
                            <label for="economico" class="form-label">N. ECONOMICO</label>
                            <input type="text" class="form-control" id="economico" name="economico"
                                placeholder="N. ECONOMICO" required>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="placa" class="form-label">PLACAS</label>
                            <input type="text" class="form-control" id="placa" name="placa" placeholder="PLACAS"
                                required>
                        </div>

                        <div class="col-md-4 position-relative">
                            <label for="razon" class="form-label">RAZON SOCIAL</label>
                            <input type="text" class="form-control" id="razon" name="razon" placeholder="RAZON SOCIAL"
                                required>
                        </div>

                        <div class="col-md-5 position-relative">
                            <label for="modelo" class="form-label">MODELO</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" placeholder="MODELO"
                                required>
                        </div>

                        <div class="col-md-4 position-relative">
                            <label for="tipo" class="form-label">TIPO DE GRUA</label>
                            <select name="tipo" class="form-select" id="tipo" required>
                                <option selected disabled value="">TIPO DE GRUA</option>
                                <option value="PLATAFORMA">PLATAFORMA</option>
                                <option value="CAJA CERRADA">CAJA CERRADA</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>

                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button class="btn btn-primary" type="submit" name="registrarGrua" id="registrarBtn">
                                REGISTRAR GRUA
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
    <div class="modal fade" tabindex="-1" id="formularioGruasEditar" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ACTUALIZAR GRUAS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" action="gruasAdmin.php" method="POST"
                        onsubmit="return validarFormularioGruasEditar()">
                        <div class="col-md-4 position-relative">
                            <input type="hidden" name="placaAct" value="" id="placaAct">
                            <label for="economicoEditar" class="form-label">N. ECONOMICO</label>
                            <input type="text" class="form-control" id="economicoEditar" name="economicoEditar"
                                placeholder="N. ECONOMICO" required>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="placaEditar" class="form-label">PLACAS</label>
                            <input type="text" class="form-control" id="placaEditar" name="placaEditar"
                                placeholder="PLACAS" required>
                        </div>

                        <div class="col-md-4 position-relative">
                            <label for="razonEditar" class="form-label">RAZON SOCIAL</label>
                            <input type="text" class="form-control" id="razonEditar" name="razonEditar"
                                placeholder="RAZON SOCIAL" required>
                        </div>

                        <div class="col-md-5 position-relative">
                            <label for="modeloEditar" class="form-label">MODELO</label>
                            <input type="text" class="form-control" id="modeloEditar" name="modeloEditar"
                                placeholder="MODELO" required>
                        </div>

                        <div class="col-md-4 position-relative">
                            <label for="tipoEditar" class="form-label">TIPO DE GRUA</label>
                            <select name="tipoEditar" class="form-select" id="tipoEditar" required>
                                <option selected disabled value="">TIPO DE GRUA</option>
                                <option value="PLATAFORMA">PLATAFORMA</option>
                                <option value="CAJA CERRADA">CAJA CERRADA</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>

                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button class="btn btn-primary" type="submit" name="editarGrua" id="editarGruasBtn">
                                ACTUALIZAR GRUA
                            </button>

                            <button class="btn btn-primary d-none" type="button" disabled id="loadingEditarGruasBtn">
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
            data-bs-target="#formularioGruas"> <i class="fa-solid fa-truck"></i> NUEVO</button>

        <table id="tablax" class="table table-striped table-bordered" style="width: 100%">

            <thead>
                <th class = "centered">N. ECONOMICO</th>
                <th class = "centered">RAZON SOCIAL</th>
                <th class = "centered">PLACAS</th>
                <th class = "centered">MODELO</th>
                <th class = "centered">TIPO</th>
                <th class = "centered">ACCION</th>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT razon, economico, placa, modelo, tipo FROM gruas";
                $result = mysqli_query($conexion, $sql);

                while ($mostrar = mysqli_fetch_array($result)) {
                    $modalId = "confirmarEliminacion_" . $mostrar['placa'];
                    ?>
                    <tr>
                        <td>
                            <?php echo $mostrar['economico'] ?>
                        </td>
                        <td>
                            <?php echo $mostrar['razon'] ?>
                        </td>
                        <td>
                            <?php echo $mostrar['placa'] ?>
                        </td>
                        <td>
                            <?php echo $mostrar['modelo'] ?>
                        </td>
                        <td>
                            <?php echo $mostrar['tipo'] ?>
                        </td>
                        <td>
                            <a type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="<?php echo "#" . $modalId; ?>">
                                <i class="fa-solid fa-trash" style="color: #fff;"></i>
                            </a>
                            <a type="button" class="btn btn-success editbtnGruas" data-bs-toggle="modal"
                                data-bs-target="#formularioGruasEditar"><i class="fa-solid fa-pen-to-square"
                                    style="color: #fff"></i></a>
                        </td>
                    </tr>

                    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ELIMINAR GRUA/VEHICULO</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>SEGURO QUE QUIERES ELIIMINAR LA GRUA 
                                        <?= $mostrar['economico'] ?> CON PLACA
                                        <?= $mostrar['placa'] ?>?
                                    </p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                                    <a type="button" id="btnConfirmacion" href="gruasAdmin?placa=<?= $mostrar['placa'] ?>"
                                        class="btn btn-danger"
                                        onclick="btnConfirmacion('<?php echo $modalId; ?>')">ELIMINAR</a>

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
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DATATABLES -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
    </script>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
    </script>
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
                    targets: [1]
                },
                {
                    className: "centered",
                    width: "10%",
                    targets: [2]
                },
                {
                    className: "centered",
                    width: "5%",
                    targets: [3]
                },
                {
                    className: "centered",
                    width: "10%",
                    targets: [4]
                },
                {
                    className: "centered",
                    width: "7%",
                    targets: [5]
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
        $(".editbtnGruas").on("click", function () {
            $tr = $(this).closest("tr");
            var datos = $tr.children("td").map(function () {
                return $(this).text();
            });
            $("#placaAct").val(datos[2].trim());
            $("#economicoEditar").val(datos[0].trim());
            $("#razonEditar").val(datos[1].trim());
            $("#placaEditar").val(datos[2].trim());
            $("#modeloEditar").val(datos[3].trim());
            $("#tipoEditar").val(datos[4].trim());
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