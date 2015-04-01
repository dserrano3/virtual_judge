<?php
	include "config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<title>Juez Virtual Discant</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/css/style.css" type="text/css" media="screen, projection, tv" />
<link rel="stylesheet" href="/css/style-print.css" type="text/css" media="print" />
</head>
<body>
<div id="wrapper">
  <div class="title">
    <div class="title-top">
      <div class="title-left">
        <div class="title-right">
          <div class="title-bottom">
            <div class="title-top-left">
              <div class="title-bottom-left">
                <div class="title-top-right">
                  <div class="title-bottom-right">
                    <h1><a href="/">Juez Virtual Discant</a></h1>
                    <p>Juez para el curso de colegios, Capítulo Javeriano ACM</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr class="noscreen" />
  <div class="content">
    <div class="column-left">
      <h3>MENU</h3>
      <a href="#skip-menu" class="hidden">Skip menu</a>
      <ul class="menu">
        <li><a href="/index.html">Inicio</a></li>
        <li><a href="/judge/upload_form.php">Enviar problema</a></li>
        <li><a href="/judge/insertar_usuario.html" >Crear usuario</a></li>
        <li><a href="/judge/puntajes.php">Tabla de posiciones</a></li>
        <li><a href="/judge/insert_problem.html"  class="active">Agregar problema</a></li>
        <li class="last"><a href="/judge/mis_envios.html">Mis envios</a></li>
      </ul>
    </div>
    <div id="skip-menu"></div>
    <div class="column-right">
      <div class="box">
        <div class="box-top"></div>
        <div class="box-in">
          <h2>Agregar Problema</h2>
          <p>


					<?php


					$con = connection_query();



					$usuario = $_POST["usuario"];
					$pass = sha1($_POST["pass"]);

					$result = mysqli_query($con, "SELECT usuario, password FROM admon WHERE usuario = '$usuario' AND password = '$pass'");
					$entro = false;

					while($row = mysqli_fetch_array($result)) {
					  $entro = true;
					}

					if(!$entro){
						die('El usuario o la contraseña son incorrectos ');
					}


					mysqli_close($con);

					$con = connection_update();



					$nombre = $_POST["nombre"];
					$desc = $_POST["descripcion"];
					$fecha = $_POST["fecha"];
					$lenguaje = $_POST["lenguaje"];
					$archivo = $nombre . ".dis";
					$in = $nombre . ".in";

					  $sql = "INSERT INTO problema (nombre, descripcion, codigo, fecha_maxima, lenguaje)
					  VALUES ('$nombre', '$desc','$archivo', '$fecha', '$lenguaje')";

					$retval = mysql_query( $sql );
					if(! $retval )
					{
					  die('Could not enter data: ' . mysql_error());
					}





					//Subir el codigo del problema
					$target_path = "problemas/";

					//$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
					$target_path = $target_path . $archivo;

					if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
						echo "The file ".  basename( $_FILES['uploadedfile']['name']).
						" has been uploaded";
					} else{
						echo "There was an error uploading the file, please try again!";
					}

					/*Converts to unix format*/
					$file = file_get_contents("problemas/code.dis");
					$file = str_replace("\r", "", $file);
					file_put_contents("problemas/code.dis", $file);


					//UPLOAD THE IN FILE

					$target_path = "problemas/";

					//$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
					$target_path = $target_path . $in;

					if(move_uploaded_file($_FILES['filein']['tmp_name'], $target_path)) {
						echo "The file ".  basename( $_FILES['filein']['name']).
						" has been uploaded";
					} else{
						echo "There was an error uploading the file, please try again!";
					}

					/*Converts to unix format*/
					$file = file_get_contents("problemas/code.dis");
					$file = str_replace("\r", "", $file);
					file_put_contents("problemas/code.dis", $file);



					echo "Problema insertado con exito" ;
					// some code

					mysql_close($con);


					?>
          </p>


        </div>
      </div>
    </div>
    <div class="cleaner">&nbsp;</div>
  </div>
</div>
<div align=center>Juez creado por: Daniel Serrano, Lenguaje creado por Alfredo Santamaria y Daniel Serrano</div></body>
</html>

