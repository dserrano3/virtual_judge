<?php
include "config.php";

$mensaje = 'sin cambiar';
function comparar_resultados($array1, $array2){
	global $mensaje;
	$array_bueno1 = array();
	$array_bueno2 = array();
	//EL 2 es el del usuario y el 1 es el que esta bien.
	for($i = 0; $i < count($array1); $i ++)
	{
		if(!empty($array1[$i])){
			array_push($array_bueno1, $array1[$i]);
		}
	}
	for($i = 0; $i < count($array2); $i ++)
	{
		if(!empty($array2[$i])){
			array_push($array_bueno2, $array2[$i]);
		}
	}
	//Si son diferentes se puede devolver false, no se hace para saber
	//donde esta la diferencia y poder mostrarla.
	if(count($array_bueno1) == 0){
		$mensaje = '<br> <table bgcolor="#FF0000"><tr><td> Hay un problema con este problema, contacte al administrador </td></tr></table><br>';
		return false;
	}
	if(count($array_bueno2) == 0){
		$mensaje = '<br> <table bgcolor="#FF0000"><tr><td>Tu codigo no imprime nada, verificalo </td></tr></table><br>';
		return false;
	}

	
	if(count($array_bueno2) != count($array_bueno1)) {
		$mensaje = '<br> <table bgcolor="#FF0000"><tr><td> La respuesta tiene más o menos lineas de lo que debería</td></tr></table> <br>';
		return false;
	}
	for($i = 0; $i < count($array_bueno1); $i ++)
	{
		if($array_bueno1[$i] != $array_bueno2[$i] ){
			$mensaje = '<br> <table bgcolor="#FF0000"><tr><td> En alguna linea se está imprimiendo ';
			$mensaje .= $array_bueno2[$i] . " ";
			$mensaje .= "y deberia ser ";
			$mensaje .= $array_bueno1[$i] . " </td> </tr></table> <br>";
			return false;
		}
	}
	$mensaje = '<br> <br> <table bgcolor="#00FF00" ><tr><td>Muy bien =), la solución del problema es correcta </td></tr></table> <br>';
	return true;
}




//COnectamos a base de datos.
$con = connection_query();


$usuario = $_POST["usuario"];
$pass = sha1($_POST["pass"]);

$result = mysqli_query($con, "SELECT usuario, password FROM Usuario WHERE usuario = '$usuario' AND password = '$pass'");
$entro = false;

while($row = mysqli_fetch_array($result)) {
  $entro = true;
}

if(!$entro){
//	die('El usuario o la contraseña son incorrectos ');
}



$target_path = "uploads/";

//Saber cual es el problema
$problema = $_POST["problema"];


$result = mysqli_query($con, "SELECT id, nombre, lenguaje FROM problema WHERE id = $problema");

$problema_nombre = 'Sin_nombre';
$lenguaje = "ninguno";
while($row = mysqli_fetch_array($result)) {
  $problema_nombre = $row['nombre'];
  $lenguaje = $row['lenguaje'];
}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<title>Juez Virtual Discant</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/../css/style.css" type="text/css" media="screen, projection, tv" />
<link rel="stylesheet" href="/../css/style-print.css" type="text/css" media="print" />
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
        <li><a href="/juez/upload_form.php" class="active">Enviar problema</a></li>
        <li><a href="/juez/insertar_usuario.html" >Crear usuario</a></li>
        <li><a href="/juez/puntajes.php">Tabla de posiciones</a></li>
        <li><a href="/juez/insert_problem.html">Agregar problema</a></li>
        <li class="last"><a href="/juez/mis_envios.html">Mis envios</a></li>
      </ul>
    </div>
    <div id="skip-menu"></div>
    <div class="column-right">
      <div class="box">
        <div class="box-top"></div>
        <div class="box-in">
          <h2>Resultados</h2>
          <p>
					<?php
					if(!$entro){
						die('El usuario o la contraseña son incorrectos ');
					}
					echo "<br>Está intentando resolver el problema: " . $problema_nombre . '<br><br>';

					//Subir el archivo al servidor, todos con el mismo nombre, para que no se llene.

					//$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
					$target_path = $target_path . 'code.dis'; 

					if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
						echo "El archivo ".  basename( $_FILES['uploadedfile']['name']). 
						" ha sido subido al servidor con éxito<br><br>";
					} else{
						die ('Hubo un problema subiendo el archivo al servidor, por favor intenta de nuevo.');
					}

					/*Converts to unix format*/
					$file = file_get_contents("uploads/code.dis");
					$file = str_replace("\r", "", $file);
					file_put_contents("uploads/code.dis", $file);




					//Ejecutar los dos programas a ver como queda.

					$codigo_bueno = "problemas/" .$problema_nombre . '.dis';
					$entrada = "problemas/" . $problema_nombre . '.in';


					$respuestaUsuario = "before";
					$respuestaCorrecta = "before";
					if($lenguaje == "dis"){
						exec('java -jar Discant_linux.jar "uploads/code.dis" <' . '"' . $entrada . '" & sleep 4 ; kill $!', $respuestaUsuario);
						exec('java -jar Discant_linux.jar "' . $codigo_bueno . '" <' . '"' . $entrada . '"', $respuestaCorrecta);
					}else if($lenguaje == "py"){
						exec('python "uploads/code.dis" <' . '"' . $entrada . '" & sleep 4 ; kill $!', $respuestaUsuario);
						exec('python "' . $codigo_bueno . '" <' . '"' . $entrada . '"', $respuestaCorrecta);
					}
					
					
					echo "<br><br>";
					//print_r($respuestaCorrecta); 

					$resultado = comparar_resultados($respuestaCorrecta, $respuestaUsuario);

					echo $mensaje;


					if($resultado ) {
						$result = mysqli_query($con, "SELECT usuario, problema FROM usuario_problema WHERE usuario = '$usuario' AND problema = '$problema'");
						$entro = false;

						while($row = mysqli_fetch_array($result)) {
						  $entro = true;
						}
						mysqli_close($con);
						if($entro){
							echo "<br>Ud ya habia completado este problema, no hay puntos<br>";
						}else{
							 //Lo actualiza en la base de datos.
							$con = connection_update();
							 
							 
							 $fecha = date('Y-m-d');
							 $sql = "INSERT INTO usuario_problema (usuario, problema, fecha)
							 VALUES ('$usuario', '$problema', now())";

							$retval = mysql_query( $sql );
							if(! $retval )
							{
							  die('Could not enter data: ' . mysql_error());
							}
							//$ar = addslashes (file_get_contents($_FILES['uploadedfile']['tmp_name']));
							$ar = file_get_contents("uploads/code.dis");
							$sql = "INSERT INTO archivo_solucion(archivo, usuario) VALUES('$ar', '$usuario')";
							$retval = mysql_query( $sql );
							if(! $retval )
							{
							  die('Could not enter data of file: ' . mysql_error());
							}else{
								echo 'Lo he insertado';
							}
							
							echo "<br>Felicitaciones has hecho un problema más, has ganado puntos.<br>";

						}

					}

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



















