<?php 
include 'conexion.php';

//para leer los datos json
$data = file_get_contents('C:\xampp\htdocs\suplosBackEnd-master\data-1.json');
$datos = json_decode($data, true);

//variables que sirven para quitar datos duplicados en los select del filtro

$ciudad = [];
$tipo = [];
$i = 0;

foreach ($datos as $value) {
 
 $ciudad[$i] = $value['Ciudad'];
 $tipo[$i] = $value['Tipo'];
 $i++;
}

//arrys con datos no suplivados 
$resultadot = array_unique($tipo);
$resultadoc = array_unique($ciudad);


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/customColors.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/index.css" media="screen,projection" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulario</title>
</head>

<body>
    <video src="img/video.mp4" id="vidFondo"></video>

    <div class="contenedor">
        <div class="card rowTitulo">
            <h1>Bienes Intelcost</h1>
        </div>
        <div class="colFiltros">
            <form action="#" method="post" id="formulario">
                <div class="filtrosContenido">
                    <div class="tituloFiltros">
                        <h5>Filtros</h5>
                    </div>
                    <div class="filtroCiudad input-field">
                        <p><label for="selectCiudad">Ciudad:</label><br></p>
                        <select name="ciudad" id="selectCiudad">
                           <option value="" selected>Elige una ciudad</option>
                           <?php foreach($resultadoc as $filac):?>
                            <option value="<?php echo $filac; ?>"><?php echo $filac; ?></option>
                           <?php endforeach ?>
                        </select>
                    </div>
                    <div class="filtroTipo input-field">
                        <p><label for="selecTipo">Tipo:</label></p>
                        <br>
                        <select name="tipo" id="selectTipo">
                            <option value="">Elige un tipo</option>
                            <?php foreach($resultadot as $filat):?>
                            <option value="<?php echo $filat; ?>"><?php echo $filat; ?></option>
                            <?php endforeach ?> 
                        </select>
                    </div>
                    <div class="filtroPrecio">
                        <label for="rangoPrecio">Precio:</label>
                        <input type="text" id="rangoPrecio" name="precio" value="" />
                    </div>
                    <div class="botonField">
                        <input type="submit" class="btn white" value="Buscar" id="submitButton" name="Buscar"> 
                    </div>
                </div>
            </form>
        </div>

        <?php

        //captura de datos de los filtros 
        if (isset($_POST["Buscar"])) {
            
             $ciudad1 = $_POST["ciudad"];
             $tipo1 = $_POST["tipo"];

        }

        //if y ciclo foreach para mostrar los resultados de los filtros en pantalla

        ?>
        <div id="tabs" style="width: 75%;">
            <ul>
                <li><a href="#tabs-1">Bienes disponibles</a></li>
                <li><a href="#tabs-2">Mis bienes</a></li>
            </ul>
            <div id="tabs-1">
                <div class="colContenido" id="divResultadosBusqueda">
                    <div class="tituloContenido" >
                        <h5>Resultados de la búsqueda: </h5>
                        <?php
                            if (empty($ciudad1) && empty($tipo1)) {
                                echo "no tiene  guardados";
                            }else{
                        ?>
                        <?php foreach($datos as $dato):?>
                        <?php 
                            if ($dato['Ciudad'] === $ciudad1 && $dato['Tipo'] === $tipo1 ) {
                        ?>
                        <div class="row" >
                          <div class="col s6">
                           <img src="img/home.jpg" alt="" width="150" height="150"> 
                          </div>
                          <div class="col s6">
                          
                           <label for="">Direccion:</label><?php echo $dato['Direccion'];?><br>
                           <label for="">Ciudad:</label><?php echo $dato['Ciudad'];?><br>
                           <label for="">Telefono:</label><?php echo $dato['Telefono'];?><br>
                           <label for="">Codigo_Postal:</label><?php echo $dato['Codigo_Postal'];?><br>
                           <label for="">Tipo:</label><?php echo $dato['Tipo'];?><br>
                           <label for="">Precio:</label><?php echo $dato['Precio'];?>

                           <form action="registrar.php" method="post" id="formulario1">
                                <input type="hidden" name="Direccion" value="<?php echo $dato['Direccion'];?>">
                                <input type="hidden" name="Ciudad" value="<?php echo $dato['Ciudad'];?>">
                                <input type="hidden" name="Telefono" value="<?php echo $dato['Telefono'];?>">
                                <input type="hidden" name="Codigo_Postal" value="<?php echo $dato['Codigo_Postal'];?>">
                                <input type="hidden" name="Tipo" value="<?php echo $dato['Tipo'];?>">
                                <input type="hidden" name="Precio" value="<?php echo $dato['Precio'];?>">
                                <input type="submit" class="btn green" value="guardar" id="submitButton1" name="guardar"> 
                           </form>
                                
                          </div>  
                        </div>
                        <?php 
                        }
                       
                        ?>
                        <?php endforeach; 
                        }
                        ?> 
                    </div>
                </div>
    
            </div>
            
            <?php
            
            // variables para capturar datos de la base de datos de vienes 

                $sentencia_select=$con->prepare('SELECT *FROM bienes');
                $sentencia_select->execute();
                $resul=$sentencia_select->fetchAll();

                //print_r($resul);

            ?>             


            <div id="tabs-2">
                <div class="colContenido" id="divResultadosBusqueda">
                    <div class="tituloContenido card" style="justify-content: center;">
                        <h5>Bienes guardados:</h5>
                        <?php
                            if (empty($resul)) {
                                echo "no tiene bienes guardados";
                            }
                        ?>
                        <?php   foreach($resul as $resu): ?>
                            <div class="row" >
                                <div class="col s6">
                                <img src="img/home.jpg" alt="" width="150" height="150"> 
                                </div>
                                <div class="col s6">
                                
                                <label for="">Direccion:</label><?php echo $resu['Direccion'];?><br>
                                <label for="">Ciudad:</label><?php echo $resu['Ciudad'];?><br>
                                <label for="">Telefono:</label><?php echo $resu['Telefono'];?><br>
                                <label for="">Codigo_Postal:</label><?php echo $resu['Codigo_Postal'];?><br>
                                <label for="">Tipo:</label><?php echo $resu['Tipo'];?><br>
                                <label for="">Precio:</label><?php echo $resu['Precio'];?>
                                <form action="#" method="post" id="formulario3">
                                  <input type="hidden" name="id" value="<?php echo $resu['id'];?>">  
                                  <input type="submit" class="btn green" value="eliminar" id="submitButton1" name="eliminar"> 
                                </form>
                                       
                                </div>  
                            </div>     

                        <?php  endforeach?> 
                    </div>
                </div>
            </div>
            <?php

            //para eliminar los bienes de la base de datos 
            if (isset($_POST["eliminar"])) {
                
                $id = $_POST['id'];
                echo $id;
                $eliminar = "DELETE FROM `bienes` WHERE `bienes`.`id` = $id";
                $eli =  mysqli_query($conexion, $eliminar);
                echo '<script>
                alert("eliminado exitosamente ");
                window.history.go(-1);
              </script>';
        exit;

            }
            ?>

        </div>

    
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

        <script type="text/javascript" src="js/ion.rangeSlider.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/index.js"></script>
        <script type="text/javascript" src="js/buscador.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#tabs").tabs();
            });
        </script>
</body>

</html>