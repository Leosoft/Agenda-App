<?php
include "funciones.php";

$config = include 'config.php';

$resultado = [
        'error' => false,
        'mensaje' => ''
];

if(!isset($_GET['id'])) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'El contacto no existe';
}

if (isset($_POST['submit'])) {
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);


        $usuario = [
                "id" => $_GET['id'],
            "nombre" => $_POST['nombre'],
            "apellido" => $_POST['apellido'],
            "email" => $_POST['email'],
            "edad" => $_POST['edad'],
            "telefono" => $_POST['telefono'],
            "discord" => $_POST['discord']
        ];

        $consultaSQL = "UPDATE usuarios SET
        nombre= :nombre,
        apellido= :apellido,
        email= :email,
        edad= :edad,
        telefono= :telefono,
        discord= :discord,
        updated_at = NOW()
        WHERE id = :id";

        $consulta = $conexion->prepare($consultaSQL);
        $consulta->execute($usuario);
    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}


try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);





    $id = $_GET['id'];
    $consultaSQL = "SELECT * FROM usuarios WHERE id=" . $id;

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

   $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);


    if(!$usuario) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado el alumno';
    }
} catch (PDOException $error){
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
}

?>



<?php include "templates/header.php";?>

<!-- codigo de la pagina -->

<?php
if ($resultado['error']) {

?>
<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="aler alert-danger" role="alert">
                <?= $resultado['mensaje'] ?>
            </div>
        </div>
    </div>
</div>
<?php
}
?>

<!-- mensaje de confirmacion -->
<?php
if (isset($_POST['submit']) && !$resultado['error']) {
    ?>
<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                El contacto ha sido actualizado correctamente
            </div>
        </div>
    </div>
</div>
<?php
}
?>



<?php
if (isset($usuario) && $usuario) {
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Editando Contacto <?= escapar($usuario['nombre']) . ' ' . escapar($usuario['apellido'])?></h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?= escapar($usuario['nombre'])?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="<?= escapar($usuario['apellido'])?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= escapar($usuario['email'])?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Edad</label>
                    <input type="text" name="edad" id="edad" value="<?= escapar($usuario['edad'])?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="tel" name="telefono" id="telefono" value="<?= escapar($usuario['telefono'])?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="discord">Discord</label>
                    <input type="text" name="discord" id="discord" value="<?= escapar($usuario['discord'])?>" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
                    <a class=" btn btn-primary" href="index.php">Regresar al inicio</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
}
?>

<?php include "templates/footer.php";?>
