<?php
class agencia{
	private $id;
	private $descripcion;
	private $direccion;
	private $telefono;
	private $horainicio;
	private $horafin;
	private $foto;
	private $con;
	
	function __construct($cn){
		$this->con = $cn;
	}
		
		
//*********************** 3.1 METODO update_vehiculo() **************************************************	
	
	public function update_agencia(){
		
			
			$id = $_POST['id'];
		
				
		// ATRIBUTOS DE LA CLASE VEHICULO   
				//$this->id = $id;
                $this->descripcion = $_POST['descripcion'];
                $this->direccion = $_POST['direccion'];
                $this->telefono = $_POST['telefono'];
                $this->horainicio = $_POST['horainicio'];
        		$this->horafin = $_POST['horafin'];
       
			$sql = "UPDATE agencia SET  descripcion='$this->descripcion', direccion='$this->direccion', telefono = '$this->telefono', horainicio = '$this->horainicio', horafin = '$this->horafin' WHERE id=$id;";
		
		
		if($this->con->query($sql)){
			echo $this->_message_ok("actualizo");
		}else{
			echo $this->_message_error("actualizar<br>");
		}							
										
	}
	

//*********************** 3.2 METODO save_vehiculo() **************************************************	

	public function save_agencia(){
		
		 $this->descripcion = $_POST['descripcion'];
                $this->direccion = $_POST['direccion'];
                $this->telefono = $_POST['telefono'];
                $this->horainicio = $_POST['horainicio'];
                $this->horafin = $_POST['horafin'];
                
                
                //$this->foto = $_POST['foto'];
                

        /* echo "<br> FILES <br>";
         echo "<pre>";
              print_r($_FILES);
         echo "<pre>";*/

         $this->foto=$this->_get_name_file($_FILES['foto']['name'],12);
         $path = "images/" . $this->foto;

         if(!move_uploaded_file($_FILES['foto']['tmp_name'], $path)){
         	$mensaje="Cargar la imagen";
         	echo $this->_message_error($mensaje);
         }
				
				
		$sql = "INSERT INTO agencia VALUES (NULL, '$this->descripcion',
									'$this->direccion',
									'$this->telefono', 
									'$this->horainicio',
									'$this->horafin',
									'$this->foto'
									);";
		echo $sql;
		
		if($this->con->query($sql)){
			echo $this->_message_ok("guardo");
		}else{
			echo $this->_message_error("guardar<br>");
		}						
										
	}



	

//************************************* PARTE II ****************************************************	

	public function get_form($id=NULL){
		
		if(($id == NULL) || ($id == 0) ) {
			$this->descripcion = NULL;
			$this->direccion = NULL;
			$this->telefono = NULL;
			$this->horainicio = NULL;
			$this->horafin = NULL;
			//$this->anio = NULL;
			//$this->color = NULL;
			$this->foto = NULL;
			//$this->avaluo =NULL;
			
			$flag = NULL;
			$op = "new";
			$bandera = 1;
	}else{
			$sql = "SELECT * FROM agencia WHERE id=$id;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
            $num = $res->num_rows;
            $bandera = ($num==0) ? 0 : 1;
            
            if(!($bandera)){
                $mensaje = "tratar de actualizar la agencia con id= ".$id . "<br>";
                echo $this->_message_error($mensaje);
				
            }else{                
                
				
			
		
             // ATRIBUTOS DE LA CLASE VEHICULO   
                $this->descripcion = $row['descripcion'];
                $this->direccion = $row['direccion'];
                $this->telefono = $row['telefono'];
                $this->horainicio = $row['horainicio'];
                $this->horafin = $row['horafin'];
                //$this->anio = $row['anio'];
                //$this->color = $row['color'];
                $this->foto = $row['foto'];
                //$this->avaluo = $row['avaluo'];
				
                //$flag = "disabled";
				$flag = "enabled";
                $op = "act"; 
            }
	}
        
	if($bandera){
    
		$telefono = ["6054874",
						 "6048754",
						 "3091589",
						"3097686",
						"2658749"
						 ];
		
		$html = '
		<body  class="bg-secondary text-white">
		<br>
		<div class="container">
  		<div class="row">
		<div class="col-md-12">
		<form name="Form_agencia" method="POST" action="agencia.php" enctype="multipart/form-data">
		<input type="hidden" name="id" value="' . $id  . '">
		<input type="hidden" name="op" value="' . $op  . '">
			<table border="0" align="center">
				<tr>
					<th colspan="2">DATOS AGENCIA</th>
				</tr>
				<tr>
					<td class="text-center">descripcion:</td>
					<td><input type="text" size="15" name="descripcion" value="' . $this->descripcion . '"></td>
				</tr>
				<tr>
					<td class="text-center">direccion:</td>
					<td><input type="text" size="15" name="direccion" value="' . $this->direccion . '"></td>
				</tr>
				
				<tr>
					<td class="text-center">telefono:</td>
					<td>' . $this->_get_radio($telefono, "telefono",$this->telefono) . '</td>
				</tr>
				<tr>
					<td class="text-center">horainicio:</td>
					<td><input type="time" name="horainicio" value="' . $this->horainicio . '"></td>
				</tr>
				<tr>
					<td class="text-center">horafin:</td>
					<td><input type="time" name="horafin" value="' . $this->horafin . '"></td>
				</tr>
				<tr>
					<td class="text-center">Foto:</td>
					<td><input type="file" name="foto" ' . $flag . '></td>
				</tr>
				
				<tr>
					<th class="text-center" colspan="2"><input type="submit" name="Guardar_Marca" value="GUARDAR" class="btn btn-primary"></th>
					<th class="text-center" colspan="2"><button type="button" class="btn btn-primary"><a class="link-light" href="marca.php">REGRESAR</a></button></th>
				</tr>												
			</table></div></div></div>';
		return $html;
	}
}
	
	

	public function get_list_agencia(){
		$d_new = "new/0";                           //Línea agregada
        $d_new_final = base64_encode($d_new);       //Línea agregada
        $d_ind = "ind/0";
        $d_new_index = base64_encode($d_ind);
				
		$html = '
		<table border="1" align="center" class="table table-striped table-dark" >
			<tr>
				<th colspan="8" class="text-center">Lista de Agencias</th>
			</tr>
			<tr>
				<th colspan="8" class="text-center"><button type="button" class="btn btn-primary"><a class="link-light" href="agencia.php?d=' . $d_new_final . '">Nuevo</a></button></th>
			</tr>
			<tr class="text-center">
				<th>descripcion</th>
				<th>direccion</th>
				<th>telefono</th>
				<th>horainicio</th>
				<th>horafin</th>
				<th colspan="3">Acciones</th>
			</tr>';
		$sql = "SELECT a.id, a.descripcion, a.direccion, a.telefono, a.horainicio, a.horafin
				FROM agencia a;";
		$res = $this->con->query($sql);
		
		
		
		// VERIFICA si existe TUPLAS EN EJECUCION DEL Query
		$num = $res->num_rows;
        if($num != 0){
		
		    while($row = $res->fetch_assoc()){
			/*
				echo "<br>VARIALE ROW ...... <br>";
				echo "<pre>";
						print_r($row);
				echo "</pre>";
			*/
		    		
				// URL PARA BORRAR
				$d_del = "del/" . $row['id'];
				$d_del_final = base64_encode($d_del);
				
				// URL PARA ACTUALIZAR
				$d_act = "act/" . $row['id'];
				$d_act_final = base64_encode($d_act);
				
				// URL PARA EL DETALLE
				$d_det = "det/" . $row['id'];
				$d_det_final = base64_encode($d_det);						
			$html .= '
				<tr class="text-center">
					<td>' . $row['descripcion'] . '</td>
						<td>' . $row['direccion'] . '</td>
						<td>' . $row['telefono'] . '</td>
						<td>' . $row['horainicio'] . '</td>
						<td>' . $row['horafin'] . '</td>
					<td><button type="button" class="btn btn-primary"><a class="link-light" href="agencia.php?d=' . $d_del_final . '">Borrar</a></button></td>
					<td><button type="button" class="btn btn-primary"><a class="link-light" href="agencia.php?d=' . $d_act_final . '">Actualizar</a></button></td>
					<td><button type="button" class="btn btn-primary"><a class="link-light" href="agencia.php?d=' . $d_det_final . '">Detalle</a></button></td>
				</tr>';
		}
		$html .= '  
		</table>
		<center>
		<button type="button" class="btn btn-primary"><a class="link-light" href="index.html">REGRESAR</a></button></center>';
		
		return $html;
		
	}
}
	
	
	public function get_detail_agencia($id){
		$sql = "SELECT a.id, a.descripcion, a.direccion, a.telefono, a.horainicio, a.horafin, a.foto
				FROM agencia a
				WHERE a.id=$id;";
		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();
		
		// VERIFICA SI EXISTE id
		$num = $res->num_rows;
        
	if($num == 0){
        $mensaje = "desplegar el detalle de la agencia con id= ".$id . "<br>";
        echo $this->_message_error($mensaje);
				
    }else{ 

		echo "</pre>";
				$html = '
				<div class="container">
  				<div class="row">
				<div class="col-md-12">
				<div class="table-responsive">
				<table border="1"  class="table table-striped table-gray">
					<tr>
						<th colspan="2" class="text-center">DATOS DE LA AGENCIA</th>
					</tr>
					<tr>
						<td class="text-center">Agencia: </td>
						<td>'. $row['descripcion'] .'</td>
					</tr>
					<tr>
						<td class="text-center">Direccion: </td>
						<td>'. $row['direccion'] .'</td>
					</tr>
					<tr>
						<td class="text-center">Telefono: </td>
						<td>'. $row['telefono'] .'</td>
					</tr>
					<tr>
						<td class="text-center">Hora Inicio: </td>
						<td>'. $row['horainicio'] .'</td>
					</tr>
					<tr>
						<td class="text-center">Hora Fin: </td>
						<td>'. $row['horafin'] .'</td>
					</tr>
					<tr>
						<td class="text-center">Foto: </td>
						<td class="text-center" colspan="2"><img src="images/' . $row['foto'] . '" width="400px"/></td>
					</tr>
					<tr>
						<th class="text-center" colspan="2"><button type="button" class="btn btn-primary"><a class="link-light" href="agencia.php">Regresar</a></button></th>
					</tr>																						
				</table></div></div></div></div>';
				
				return $html;
		}
	}
	
	
	public function delete_agencia($id){
		$sql = "DELETE FROM agencia WHERE id=$id;";
		if($this->con->query($sql)){
			echo $this->_message_ok("elimino");
		}else{
			echo $this->_message_error("eliminar");
		}	
	}
	
//*************************************************************************	
	
	private function _message_error($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a href="agencia.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
	
	private function _message_ok($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th><a href="agencia.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	

	private function _get_name_file($nombre_original, $tamanio){
			$tmp = explode(".",$nombre_original);
			$numElm = count($tmp);
			$ext = $tmp[$numElm-1];
			$cadena = "";
					for($i=1;$i<=$tamanio;$i++){
						$c = rand(65, 122);
						if(($c >= 91) && ($c <=96)){
							$c = NULL;
								$i--;
						}else{
							$cadena .= chr($c);
						}
					}
	return $cadena . "." . $ext;
}
private function _get_radio($arreglo,$nombre,$defecto=NULL){
		$html = '
		<div class="container">
  		<div class="row">
		<div class="col-md-12">
		<div class="table-responsive">
		<table border="0"  class="table table-striped table-gray">';
		foreach($arreglo as $etiqueta){
			$html .= '
			<tr>
				<td>' . $etiqueta . '</td>
				<td>';
				$html .= ($defecto == $etiqueta)? '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>':'<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '"/></td>';
			
			$html .= '</tr>';
		}
		$html .= '</table>';
		return $html;
	}



//****************************************************************************	
	
} // FIN SCRPIT
?>

