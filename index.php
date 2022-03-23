<?php
// Obtener la lista de usuarios desde la base de datos
include 'funciones.php';

$error = false;
$config = include 'config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    if(isset($_POST['apellido'])) {
        $consultaSQL = "SELECT * FROM usuarios WHERE apellido LIKE '%" . $_POST['apellido'] . "%'";
    } else {
        $consultaSQL = "SELECT * FROM usuarios";
    }

    // Codigo que obtendra la lista de alumnos
    //$consultaSQL = "SELECT * FROM usuarios";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
    // Almacenar resultado en variable $usuarios
    $usuarios = $sentencia->fetchAll();

} catch (PDOException $error) {
    $error = $error->getMessage();
}

$titulo = isset($_POST['apellido']) ? 'Lista de contactos ' . $_POST['apellido'] . '' : 'Contactos';
?>


<?php include "templates/header.php"; ?>

<?php
if($error) {
    ?>
<div class="container mt-2">
    <div class="row">
        <div class="col-md-2">
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        </div>
    </div>
</div>
<?php
}
?>

<!-- Codigo de la aplicacion -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="crear.php" class="btn btn-primary">Agendar Contacto</a>
            <hr>
            <form method="post" class="form-inline">
                <div class="form-group mr-3">
                    <input type="text" id="apellido" name="apellido" placeholder="Buscar por apellido" class="form-control">
                </div>
                <br>
                <button type="submit" name="submit" class="btn btn-primary">Ver Resultados</button>
            </form>
        </div>
    </div>
</div>



<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3"><?= $titulo ?></h2>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Edad</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($usuarios && $sentencia->rowCount() > 0) {
                    foreach ($usuarios as $fila) {
                        ?>
                        <tr>
                            <td><?php echo escapar($fila["id"]); ?></td>
                            <td><?php echo escapar($fila["nombre"]); ?></td>
                            <td><?php echo escapar($fila["apellido"]); ?></td>
                            <td><?php echo escapar($fila["email"]); ?></td>
                            <td><?php echo escapar($fila["edad"]); ?></td>
                            <td>
                                <a href="<?= 'borrar.php?id=' . escapar($fila["id"]) ?>">🗑️Borrar</a>
                                <a href="<?= 'editar.php?id=' . escapar($fila["id"]) ?>" . >✏️Editar</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tbody>
            </table>
        </div>
    </div>
</div>




<?php include "templates/footer.php"; ?>
