<?php

$config = include 'config.php';

try{
    //DSN
    $conexion = new PDO('mysql:host=' . $config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    $sql = file_get_contents("data/migracion.sql");


    $conexion->exec($sql);
    echo "La base de datos y la tabla usuarios se ha creado con exito";
} catch (PDOException $error){
    echo $error->getMessage();
}

