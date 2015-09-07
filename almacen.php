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
                while ($fila = $resultado->fetch_assoc()) {
                    $mostrar = $fila['nombre'] . ' [ ' . $fila['cantidad'] . ' ] - ' . $fila['fecha_caducidad'] . '<br>';
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
