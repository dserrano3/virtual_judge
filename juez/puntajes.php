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
<link href='http://fonts.googleapis.com/css?family=Fira+Sans:400,500italic,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen, projection, tv" />
<link rel="stylesheet" href="../css/style-print.css" type="text/css" media="print" />
</head>
<body>
  <header class="lp-header" id="header">
    <div class="judge-header">
        <h1>Juez Virtual <span>Discant</span></h1>
        <p>Juez para el curso de colegios, Capítulo Javeriano ACM</p>
    </div>

  <main class="container">
    <div class="row">
      <br />
      <div class="col-xs-12 col-sm-3">
        <a href="#skip-menu" class="hidden">Skip menu</a>
        <ul class="nav nav-pills nav-stacked">
          <li>
            <a href="/index.html">
              <span class="glyphicon glyphicon-home"></span>
                  Inicio
            </a>
          </li>
          <li>
            <a href="/judge/upload_form.php">
              <span class="glyphicon glyphicon-send"></span>
              Enviar problema
            </a>
          </li>
          <li>
            <a href="/judge/insertar_usuario.html" >
              <span class="glyphicon glyphicon-user"></span>
              Crear usuario
            </a>
          </li>
          <li class="active">
            <a href="/judge/puntajes.php">
              <span class="glyphicon glyphicon-stats"></span>
              Tabla de posiciones
            </a>
          </li>
          <li>
            <a href="/judge/insert_problem.html">
              <span class="glyphicon glyphicon-plus-sign"></span>
              Agregar problema
            </a>
          </li>
          <li class="last">
            <a href="/judge/mis_envios.html">
              <span class="glyphicon glyphicon-transfer"></span>
              Mis envios
            </a>
          </li>
        </ul>
      </div>
      <div id="skip-menu"></div>


      <div class="col-xs-12 col-sm-8 col-md-8">
        Por cada problema enviado a tiempo, se otorgan 10 puntos,
        por cada problema completado fuera de la fecha límite,
        se otorgan 5 puntos.
        <br><br>

        <div class="progress progress-striped">

          <div class="progress-bar  progress-bar-custom" style="width: 40%">
            Colgio 1
          </div>
        </div>
        <div class="progress progress-striped">
          <div class="progress-bar progress-bar-custom" style="width: 20%">
            Colgio 2
          </div>
        </div>
        <div class="progress progress-striped">
          <div class="progress-bar progress-bar-custom" style="width: 60%">
            Colgio n
          </div>
        </div>

        <div class="panel panel-custom filterable">
          <div class="panel-heading">
              <h3 class="panel-title">Tabla de posiciones Usuarios</h3>
          </div>

          <table class="table table-hover" id="dev-table">
            <tr>
              <th><font color="#DB8321"> # </font></th>
              <th><font color="#DB8321"> Usuario </font></th>
              <th><font color="#DB8321"> Nombre </font></th>
              <th><font color="#DB8321"> Colegio </font></th>
              <th><font color="#DB8321"> Puntos </font></th>
            </tr>
            <p>
      				<?php

      				for($i = 0; $i < count($array_usuarios);$i++)
      				{
      					echo '<tr>' .
                          '<td>' . ($i + 1)  . '</td>' .
                          '<td>' .
                            '<a href="envios_usuario.php?usuario=' . $array_usuarios[$i] . '">' .
                            $array_usuarios[$i] . '</a>' .
                          '</td>' .
                          '<td>' . $array_nombre[$array_usuarios[$i]]  . '</td>' .
                          '<td>' . $array_colegio[$array_usuarios[$i]] . '</td>' .
                          '<td>' . $array_puntos[$array_usuarios[$i]]  . '</td>' .
                      '</tr>';
      				}


      				?>

            </p>
					</table>
        </div>
      </div>
  </main>
</header>

<div align=center>Juez creado por: Daniel Serrano, Lenguaje creado por Alfredo Santamaria y Daniel Serrano</div></body>
</html>
