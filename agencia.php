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
	    include_once("constantes.php");
		require_once("class/class.agencia.php");
		
		$cn = conectar();
		$v = new agencia($cn);
		//vehiculo::MetodoEstatico();
		
		
//2.1 URL para la petición GET
//$URL = "http://localhost:8088/Vehiculo_CRUD/Vehiculo_PARTE_II/index.php?d=act/0";	
//$URL = "http://localhost:8088/Vehiculo_CRUD/Vehiculo_PARTE_II/index.php?d=act/5";	

//$URL = "http://localhost:8088/Vehiculo_CRUD/Vehiculo_PARTE_II/index.php?d=det/0";	
//$URL = "http://localhost:8088/Vehiculo_CRUD/Vehiculo_PARTE_II/index.php?d=det/5";		
		
    // Codigo necesario para realizar pruebas.
		if(isset($_GET['d'])){
		  
		/*	echo "<br>PETICION GET <br>";
			echo "<pre>";
				print_r($_GET);
			echo "</pre>";
		*/
		  
			// 2.1 PETICION GET
			// $dato = $_GET['d'];
			
			// 2.2 DETALLE id
			$dato = base64_decode($_GET['d']);
			$tmp = explode("/", $dato);
			
			
			/*echo "<br>VARIABLE TEMP <br>";
			echo "<pre>";
				print_r($tmp);
			echo "</pre>";
					*/
			
			$op = $tmp[0];
			$id = $tmp[1];
			
			if($op == "det"){
				echo $v->get_detail_agencia($id);
			}elseif($op == "act"){
				echo $v->get_form($id);
			}elseif($op == "new"){
				echo $v->get_form($id);
			}elseif($op == "del"){
				echo $v->delete_agencia($id); 
			}
		
	
		//NUEVO CODIGO - PARTE III
		
		}else{
			   
				/*echo "<br>PETICION POST <br>";
				echo "<pre>";
					print_r($_POST);
				echo "</pre>";*/
		      
			if(isset($_POST['Guardar']) && $_POST['op']=="new"){
				$v->save_agencia();
			}elseif(isset($_POST['Guardar']) && $_POST['op']=="act"){
				$v->update_agencia();
			}else{
				echo $v->get_list_agencia();
			}	
		}
				

		
//*******************************************************
		function conectar(){
			//echo "<br> CONEXION A LA BASE DE DATOS<br>";
			$c = new mysqli(SERVER,USER,PASS,BD);
			
			if($c->connect_errno) {
				die("Error de conexión: " . $c->mysqli_connect_errno() . ", " . $c->connect_error());
			}
		/*	else{
				echo "La conexión tuvo éxito .......<br><br>";
			}  */
			
			$c->set_charset("utf8");
			return $c;
		}
//**********************************************************
		
		
	?>	
</body>
</html>
