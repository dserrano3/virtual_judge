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
        <li><a href="/judge/upload_form.php"  class="active">Enviar problema</a></li>
        <li><a href="/judge/insertar_usuario.html" >Crear usuario</a></li>
        <li><a href="/judge/puntajes.php">Tabla de posiciones</a></li>
        <li><a href="/judge/insert_problem.html">Agregar problema</a></li>
        <li class="last"><a href="/judge/mis_envios.html">Mis envios</a></li>
      </ul>
    </div>
    <div id="skip-menu"></div>
    <div class="column-right">
      <div class="box">
        <div class="box-top"></div>
        <div class="box-in">
          <h2>Envía un problema</h2>
          <p>
				<form action="upload.php" method="post"
					enctype="multipart/form-data">
					<table>
					<tr>
					<td>Usuario:</td><td> <input type="text" name="usuario"></td>
					</tr><tr>
					<td>Contraseña:</td> <td><input type="password" name="pass"></td>
					</tr><tr>
					<td><label for="file">Archivo:</label></td>
					<td><input type="file" name="uploadedfile" id="uploadedfile"></td>
					</tr><tr>
					<td>Seleccione el problema a enviar</td>
					<td><select name="problema">
					<?php
					$con = connection_query();

					$result = mysqli_query($con, "SELECT id, nombre FROM problema");


					while($row = mysqli_fetch_array($result)) {
					  echo '<option value ="' . $row['id'] . '">' .  $row['nombre']  . '</option>'   ;
					}
					?>
					</select>
					</td></tr>
					</table>
					<br><br>

					<center><input type="submit" name="submit" value="Enviar"></center>
					</form>


          </p>

          <p>


					<br><br>Problemas:<br><br>

					<table border = "2">
					<tr><td><b>Nombre Problema</b></td><td><b>Descripción</b></td><td><b>Fecha máxima</b></td></tr>
					<?php
					$result = mysqli_query($con, "SELECT descripcion, nombre, fecha_maxima, lenguaje FROM problema");
					while($row = mysqli_fetch_array($result)) {
					  echo '<tr><td>' . $row['nombre'] . '</td>' . '<td>' . $row['descripcion'] . '</td><td>' . $row['fecha_maxima']  . '</td><td>' . $row['lenguaje']  . '</td></tr>'  ;
					}


					?>


					</table>




          </p>


        </div>
      </div>
    </div>
    <div class="cleaner">&nbsp;</div>
  </div>
</div>
<div align=center>Juez creado por: Daniel Serrano, Lenguaje creado por Alfredo Santamaria y Daniel Serrano</div></body>
</html>



