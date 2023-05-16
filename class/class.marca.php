<?php
class marca{
	private $id;
	private $descripcion;
	private $pais;
	private $direccion;
	private $foto;
	function __construct($cn){
		$this->con = $cn;
	}
		
		
//*********************** 3.1 METODO update_vehiculo() **************************************************	
	
	public function update_marca(){
		$this->id = $_POST['id'];
		$this->descripcion = $_POST['descripcion'];
		$this->pais = $_POST['pais'];
		$this->direccion = $_POST['direccion'];
		
		$sql = "UPDATE marca SET descripcion ='$this->descripcion', pais = '$this->pais', direccion = '$this->direccion' WHERE id=$id;";
		
		//exit;
		if($this->con->query($sql)){
			echo $this->_message_ok("modificó");
		}else{
			echo $this->_message_error("al modificar");
		}								
										
	}
	

//*********************** 3.2 METODO save_vehiculo() **************************************************	

	public function save_marca(){
		$this->id = $_POST['id'];
		$this->descripcion = $_POST['descripcion'];
		$this->pais = $_POST['pais'];
		
		$sql = "INSERT INTO marca VALUES(NULL,
											'$this->descripcion',
											'$this->pais');";
		echo $sql;
		//exit;
		if($this->con->query($sql)){
			echo $this->_message_ok("guardó");
		}else{
			echo $this->_message_error("guardar");
		}								
										
	}



//*************************************** PARTE I ************************************************************
	

	
	
	
//************************************* PARTE II ****************************************************	

	public function get_form($id=NULL){
		
		if(($id == NULL) || ($id == 0) ) {
			$this->descripcion = NULL;
			$this->pais = NULL;
			$this->direccion = NULL;
			$this->foto = NULL;
			$flag = NULL;
			$op = "new";
			$bandera = 1;
		}else{

			$sql = "SELECT * FROM marca WHERE id=$id;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
            $num = $res->num_rows;
            $bandera = ($num==0) ? 0 : 1;
            
            if(!($bandera)){
                $mensaje = "tratar de actualizar el vehiculo con id= ".$id . "<br>";
                echo $this->_message_error($mensaje);
				
            }else{    
			
			 $this->descripcion = $row['descripcion'];
                $this->pais = $row['pais'];
                $this->direccion = $row['direccion'];
                $this->foto = $row['foto'];
                //$this->avaluo = $row['avaluo'];
				
                //$flag = "disabled";
				$flag = "enabled";
                $op = "act"; 

		}
	}
		if($bandera){
		
		$html = '
		<div class="container">
		<body  class="bg-secondary text-white">
		<br>
		
  		<div class="row">
		<div class="col-md-12">
		<form name="marca" method="POST" action="marca.php" enctype="multipart/form-data">
		<input type="hidden" name="id" value="' . $id  . '">
		<input type="hidden" name="op" value="' . $op  . '">
			<table border="0" align="center">
				<tr>
					<th colspan="2" class="text-center">DATOS MARCA</th>
				</tr>
				<tr>
					<td class="text-center">Marca:</td>
					<td><input type="text" size="6" name="descripcion" value="' . $this->descripcion . '" required></td>
				</tr>
				<tr>
					<td class="text-center">Pais:</td>
					<td><input type="text" size="6" name="pais" value="' . $this->pais . '" required></td>
				</tr>
				<tr>
					<td class="text-center">Direccion:</td>
					<td><input type="text" size="15" name="direccion" value="' . $this->direccion . '"></td>
				</tr>
				<tr>
					<td class="text-center">Foto:</td>
					<td><input type="file" name="foto" ' . $flag . '></td>
				</tr>
                <tr>
					<th class="text-center" colspan="2"><input type="submit" name="Guardar_Marca" value="GUARDAR" class="btn btn-primary"></th>
					<th class="text-center" colspan="2"><button type="button" class="btn btn-primary"><a class="link-light" href="marca.php">REGRESAR</a></button></th>
				</tr>									
			</table></div></div></body></div>';
		return $html;
	}
}
	
	

	public function get_list_marca(){
		$d_new = "new_marca/0";
		$d_new_final = base64_encode($d_new);
		$html = '
		<table border="1" align="center" class="table table-striped table-dark">
			<tr>
				<th colspan="8" class="text-center">Lista de Marcas</th>
			</tr>
			<tr>
				<th colspan="8" class="text-center"><button type="button" class="btn btn-primary"><a class="link-light" href="marca.php?d=' . $d_new_final . '">Nueva</a></button></th>
			</tr>
			<tr class="text-center">
				<th>Marca</th>
				<th>Pais</th>
				<th colspan="3">Acciones</th>
			</tr>';
		$sql = "SELECT * FROM marca";	
		$res = $this->con->query($sql);
		// Sin codificar <td><a href="index.php?op=del&id=' . $row['id'] . '">Borrar</a></td>
		while($row = $res->fetch_assoc()){
			$d_del = "delmarca/" . $row['id'];
			$d_del_final = base64_encode($d_del);
			$d_act = "actmarca/" . $row['id'];
			$d_act_final = base64_encode($d_act);
			$d_det = "detmarca/" . $row['id'];
			$d_det_final = base64_encode($d_det);					
			$html .= '
				<tr class="text-center">
					<td>' . $row['descripcion'] . '</td>
					<td>' . $row['pais'] . '</td>
					<td><button type="button" class="btn btn-primary"><a class="link-light" href="marca.php?d=' . $d_del_final . '">Borrar</a></button></td>
					<td><button type="button" class="btn btn-primary"><a class="link-light" href="marca.php?d=' . $d_act_final . '">Actualizar</a></button></td>
					<td><button type="button" class="btn btn-primary"><a class="link-light" href="marca.php?d=' . $d_det_final . '">Detalle</a></button></td>
				</tr>';
		}
		$html .= '
		</table>
		<center>
		<button type="button" class="btn btn-primary"><a class="link-light" href="index.html">REGRESAR</a></button></center>';
		
		return $html;
		
	}
	
	
	public function get_detail_marca($id){
		$sql = "SELECT id, descripcion, pais, direccion, foto
				FROM marca
				WHERE id=$id;";
		
		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();
		
		// VERIFICA SI EXISTE id
		$num = $res->num_rows;
        
	if($num == 0){
        $mensaje = "desplegar el detalle del vehiculo con id= ".$id . "<br>";
        echo $this->_message_error($mensaje);
				
    }else{ 
				$html = '
				<div class="container">
  				<div class="row">
				<div class="col-md-12">
				<div class="table-responsive">
				<table border="1" class="table table-striped table-gray">
					<tr>
						<th colspan="2" class="text-center">DATOS DE LA MARCA</th>
					</tr>
					<tr>
						<td class="text-center">Marca: </td>
						<td>'. $row['descripcion'] .'</td>
					</tr>
					<tr>
						<td class="text-center" >Pais: </td>
						<td>'. $row['pais'] .'</td>
					</tr>
					<tr>
						<td class="text-center">Direccion: </td>
						<td>'. $row['direccion'] .'</td>
					</tr>
					<tr>
						<td class="text-center">Foto: </td>
						<td colspan="2"><img src="images/' . $row['foto'] . '" width="300px"/></td>
					</tr>
					<tr class="text-center">
						<th colspan="2"><button type="button" class="btn btn-primary"><a class="link-light" href="marca.php">Regresar</a></button></th>
					</tr>																						
				</table>';
				
				return $html;
		}
	}
	
	
	public function delete_marca($id){
		$sql = "DELETE FROM marca WHERE id='$id';";
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
				<th><a href="marca.php">Regresar</a></th>
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
				<th><a href="marca.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
//****************************************************************************	
	
} // FIN SCRPIT
?>

