<?php
include "config.php";

$con = connection_query();

$array_usuarios = array();
$array_puntos = array();
$array_nombre = array();
$array_colegio = array();

$result = mysqli_query($con, "SELECT nombre, usuario, colegio FROM Usuario");


while($row = mysqli_fetch_array($result)) {
  array_push($array_usuarios, $row['usuario']);
  $array_puntos[$row['usuario']] = 0;
  $array_nombre[$row['usuario']] = $row['nombre'];
  $array_colegio[$row['usuario']] = $row['colegio'];

}

$result = mysqli_query($con, "SELECT usuario, problema, fecha_maxima, id, fecha FROM usuario_problema, problema WHERE problema = id");
$puntos = 0;
while($row = mysqli_fetch_array($result)) {
  $fecha_envio = strtotime( $row['fecha'] );
  $fecha_maxi = strtotime( $row['fecha_maxima'] );
  if($fecha_maxi - $fecha_envio >= 0){
	$puntos = 10;
  }else{
	$puntos = 5;
  }
  $array_puntos[$row['usuario']] = $array_puntos[$row['usuario']] + $puntos;
}

for($i = 0; $i < count($array_usuarios); $i++){
	for($j = 0 ; $j < count($array_usuarios) - 1; $j++){
		if($array_puntos[$array_usuarios[$j]] < $array_puntos[$array_usuarios[$j+1]] ){
			$auxil = $array_usuarios[$j];
			 $array_usuarios[$j] =  $array_usuarios[$j+1];
			 $array_usuarios[$j+1] = $auxil;

		}
	}



}



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
        <li><a href="/index.html" >Inicio</a></li>
        <li><a href="/judge/upload_form.php">Enviar problema</a></li>
        <li><a href="/judge/insertar_usuario.html" >Crear usuario</a></li>
        <li><a href="/judge/puntajes.php" class="active">Tabla de posiciones</a></li>
        <li><a href="/judge/insert_problem.html">Agregar problema</a></li>
        <li class="last"><a href="/judge/mis_envios.html">Mis envios</a></li>
      </ul>
    </div>
    <div id="skip-menu"></div>
    <div class="column-right">
      <div class="box">
        <div class="box-top"></div>
        <div class="box-in">
          <h2>Tabla Posiciones</h2>
          <p>
				<?php
				echo 'Por cada problema enviado a tiempo, se otorgan 10 puntos, por cada problema completado fuera de la fecha límite, se otorgan 5 puntos.<br><br>';

				echo '<table border = "2"><tr><td> Usuario </td> <td> Nombre </td>  <td> Colegio </td> <td> Puntos </td></tr>'   ;
				for($i = 0; $i < count($array_usuarios);$i++)
				{
					echo '<tr><td>' . '<a href="envios_usuario.php?usuario=' . $array_usuarios[$i] . '">' . $array_usuarios[$i] . '</a>' . '</td>' . '<td>' . $array_nombre[$array_usuarios[$i]] . '</td> <td>' . $array_colegio[$array_usuarios[$i]] . '</td><td>' . $array_puntos[$array_usuarios[$i]] . '</td></tr>';
				}

				echo '</table>';


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









