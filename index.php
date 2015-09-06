<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>Almacén</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>



<h1>Añadir al almacén</h1>


<form method="POST" action="index.php"> 
	<input type="hidden" name="accion" value="anadir" />
    Añadir a la lista: <input type="text" value="" name="producto"/>
    Cantidad: <input type="text" value="" name="cantidad_producto"/>
    Fecha de caducidad: <input type="text" value="" name="fecha_producto"/>
	<input type="submit" value="Añadir" name="anadir"/>
</form>

<form method="POST" action="index.php"> 
    <select name="orden">
        <option value="fecha_caducidad">Fecha</option>
        <option value="nombre">Nombre</option>
    </select>
	<input type="hidden" name="accion" value="listar" />
    <input type="submit" value="Ordenar lista" name="ordenar_lista"/>
</form>
<h1>Almacén</h1>
<?php 

$servername = "localhost";
$username = "root";
$password = "";
$database = "local";

$mysqli = new mysqli($servername, $username, $password, $database);

/* comprueba la conexión */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());  
    exit();  
}


if($_POST) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    if(isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        
        if (strcmp($accion, 'anadir') == 0) {
         // anadimos  
             $producto =  $_POST["producto"];
             $cantidad =  $_POST["cantidad_producto"];
             $fecha =  $_POST["fecha_producto"];

             $consulta = "INSERT INTO productos (nombre, fecha_caducidad, cantidad) VALUES ('". $producto . "', '" . $fecha . "', " . $cantidad . ")";

             if (!$resultado = $mysqli->query($consulta)) {
                 echo $mysqli->error;
             }
             if ($resultado = $mysqli->query("SELECT * from productos")) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo $fila['cantidad'] . ' - ' . $fila['nombre'] . ' - ' . $fila['fecha_caducidad'] . '<br>';    

                }
                $resultado->free();
                $mysqli->close();
            }
        } else {
         // listar
            $orden = 'fecha_caducidad';
            if(isset($_POST['orden'])) {
                $orden = $_POST['orden'];
            }
            if (strcmp($orden, 'fecha_caducidad') == 0){
                                $consulta = "SELECT * FROM productos ORDER BY " . $orden . " DESC";
    
                if (!$resultado = $mysqli->query($consulta)) {
                    echo $mysqli->error;
                }
            
            while ($fila = $resultado->fetch_assoc()) {
                    echo $fila['nombre'] . ' [ ' . $fila['cantidad'] . ' ] - ' . $fila['fecha_caducidad'] . '<br>';    

                }                
            }
            else if (strcmp($orden, 'nombre') == 0){
                            
                $consulta = "SELECT * FROM productos ORDER BY " . $orden . " ASC";
    
                if (!$resultado = $mysqli->query($consulta)) {
                    echo $mysqli->error;
                }
            
                // NUEVO
                ?>
                <form action="checkbox-form.php" method="post">
    
                <?php
                $mostrar = $fila['nombre'] . ' [ ' . $fila['cantidad'] . ' ] - ' . $fila['fecha_caducidad'] . '<br>';
                    
                while ($fila = $resultado->fetch_assoc()) {
                
                    ?>
                <input type="checkbox" name="valores[]" value="A" /> <?php echo $mostrar ?><br />
<?php
                }
                ?>
                </form>
    
                <?php
                
                // FIN NUEVO
                
                    //echo $fila['nombre'] . ' [ ' . $fila['cantidad'] . ' ] - ' . $fila['fecha_caducidad'] . '<br>';    

                
            }
            
            $resultado->free();
            $mysqli->close();
        }
    }
    
}


?>


</body>
</html>


