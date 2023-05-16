<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Matriculas Vehículos</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
	<?php
		require_once("constantes.php");
		include_once("class/class.matricula.php");
		
		$cn = conectar();
		$mt = new matricula($cn);
		
				if(isset($_GET['d'])){
			$dato = base64_decode($_GET['d']);
			$tmp = explode("/", $dato);
			$op = $tmp[0];
			$id = $tmp[1];
			
			if($op == "matri"){
				echo $mt->get_form($id);
            }
		}else{
		
			if(isset($_POST['Guardar_Matricula']) && $_POST['op']=="matricular"){
				$mt->save_matricula();
			}else{
				echo $mt->get_list_matricula();
				echo $mt->get_list_matriculados();
			}	
		}

	
		
	//*******************************************************
		function conectar(){
			//echo "<br> CONEXION A LA BASE DE DATOS<br>";
			$c = new mysqli(SERVER,USER,PASS,BD);
			
			if($c->connect_errno) {
				die("Error de conexión: " . $c->mysqli_connect_errno() . ", " . $c->connect_error());
			}else{
				//echo "La conexión tuvo éxito .......<br><br>";
			}
			
			$c->set_charset("utf8");
			return $c;
		}
	//**********************************************************	

		
	?>	
</body>
</html>
