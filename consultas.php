<?php
header("Content-Type: text/javascript");
include 'conexion.php';

$obj = array();
if(isset($_GET['callback']) && isset($_GET['consulta']))
{
	$callback = $_GET['callback'];
	$consulta = $_GET['consulta'];

	// Inserción de usuarios.
	if($consulta == 'agregarDonante' && isset($_GET['data'])){

		$misParamentros = json_decode($_GET['data']);
		$usuario = $misParamentros->{'usuario'};
		$password = $misParamentros->{'password'};
		$nombres = $misParamentros->{'nombres'};
		$apellidos = $misParamentros->{'apellidos'};
		$documento = $misParamentros->{'documento'};
		$implemento = $misParamentros->{'implemento'};
		$telefono = $misParamentros->{'telefono'};
		$correo = $misParamentros->{'correo'};
		$fecha_nacimiento = $misParamentros->{'fecha_nacimiento'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO usuarios (usuario, contrasena, nombres, apellidos, telefono, correo, direccion, tipos_usuario_id, documento, fecha_nacimiento) 
		VALUES ('$usuario', '$password', '$nombres', '$apellidos', '$telefono', '$correo', '', 3, '$documento', '$fecha_nacimiento')";

		$resultset = mysql_query($sql,$connection);
		if ($resultset) {
			$obj['resultado'] = '1';
			echo $callback.'(' . json_encode($obj) . ')';
		}
		else{
			$obj['resultado'] = '0';
			echo $callback.'(' . json_encode($obj) . ')';
		}
	}

	if($consulta == 'agregarBeneficiario' && isset($_GET['data'])){

		$misParamentros = json_decode($_GET['data']);

		$nombres = $misParamentros->{'nombres'};
		$apellidos = $misParamentros->{'apellidos'};
		$documento = $misParamentros->{'documento'};
		$implemento = $misParamentros->{'implemento'};
		$telefono = $misParamentros->{'telefono'};
		$correo = $misParamentros->{'correo'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO usuarios (usuario, contrasena, nombres, apellidos, telefono, correo, direccion, tipos_usuario_id, documento, fecha_nacimiento, implemento) 
		VALUES ('$documento', '$documento', '$nombres', '$apellidos', '$telefono', '$correo', '', 2, '$documento', null, '$implemento')";

		$resultset = mysql_query($sql,$connection);
		if ($resultset) {
			$obj['resultado'] = '1';
			echo $callback.'(' . json_encode($obj) . ')';
		}
		else{
			$obj['resultado'] = '0';
			echo $callback.'(' . json_encode($obj) . ')';
		}
	}

	// Agregar donaciones
	if($consulta == 'agregarDonacionFundacion' && isset($_GET['data'])){

		$misParamentros = json_decode($_GET['data']);

		$implemento = $misParamentros->{'implemento'};
		$estado = $misParamentros->{'estado'};
		$cantidad = $misParamentros->{'cantidad'};
		$idDonante = $misParamentros->{'idDonante'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO donaciones (implemento, cantidad, estados_donaciones_id, usuarios_id_donante, usuarios_id_beneficiario, estado_implemento)
		VALUES ('$implemento','$cantidad',1,'$idDonante',1,'$estado')";

		$resultset = mysql_query($sql,$connection) or die(mysql_error());
		if ($resultset) {
			$obj['resultado'] = '1';
			echo $callback.'(' . json_encode($obj) . ')';
		}
		else{
			$obj['resultado'] = '0';
			echo $callback.'(' . json_encode($obj) . ')';
		}
	}

	if($consulta == 'agregarDonacionUsuario' && isset($_GET['data'])){

		$misParamentros = json_decode($_GET['data']);

		$idBeneficiario = $misParamentros->{'idBeneficiario'};
		$implemento = $misParamentros->{'implemento'};
		$estado = $misParamentros->{'estado'};
		$cantidad = $misParamentros->{'cantidad'};
		$idDonante = $misParamentros->{'idDonante'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO donaciones (implemento, cantidad, estados_donaciones_id, usuarios_id_donante, usuarios_id_beneficiario, estado_implemento)
		VALUES ('$implemento','$cantidad',1,'$idDonante','$idBeneficiario','$estado')";

		$resultset = mysql_query($sql,$connection) or die(mysql_error());
		if ($resultset) {
			$obj['resultado'] = '1';
			echo $callback.'(' . json_encode($obj) . ')';
		}
		else{
			$obj['resultado'] = '0';
			echo $callback.'(' . json_encode($obj) . ')';
		}
	}

	// Inicio de sesión
	if($consulta == 'iniciarSesion' && isset($_GET['data'])){

		$misParamentros = json_decode($_GET['data']);
		$usuario = $misParamentros->{'usuario'};
		$password = $misParamentros->{'password'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "SELECT id, usuario, tipos_usuario_id FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$password' LIMIT 1";

		$resultset = mysql_query($sql,$connection);
		$records = array();
			//Loop through all our records and add them to our array
		while($r = mysql_fetch_assoc($resultset))
		{
			$records[] = $r;
		}

		if(count($records) > 0){
			$obj['resultado'] = '1';
			$obj['query'] = $records;
			echo $callback.'(' . json_encode($obj) . ')';
		}else{
			$obj['resultado'] = '0';
			$obj['query'] = $records;
			echo $callback.'(' . json_encode($obj) . ')';
		}
	}

	// Realizar donación a la fundación
	if($consulta == 'donacionesPendientes'){

		mysql_query('SET CHARACTER SET utf8');
		$sql = "SELECT d.id, u.nombres, u.apellidos, d.implemento, d.cantidad FROM donaciones.donaciones d JOIN usuarios u ON d.usuarios_id_donante = u.id WHERE d.estados_donaciones_id = 1";

		$resultset = mysql_query($sql,$connection);
		$records = array();
			//Loop through all our records and add them to our array
		while($r = mysql_fetch_assoc($resultset))
		{
			$records[] = $r;
		}

		if(count($records) > 0){
			$obj['resultado'] = '1';
			$obj['query'] = $records;
			echo $callback.'(' . json_encode($obj) . ')';
		}else{
			$obj['resultado'] = '0';
			$obj['query'] = $records;
			echo $callback.'(' . json_encode($obj) . ')';
		}
	}

	if($consulta == 'usuariosBeneficiarios'){

		mysql_query('SET CHARACTER SET utf8');
		$sql = "SELECT id, CONCAT(nombres, ' ', apellidos) as nombre, implemento FROM donaciones.usuarios WHERE tipos_usuario_id = 2";

		$resultset = mysql_query($sql,$connection);
		$records = array();
			//Loop through all our records and add them to our array
		while($r = mysql_fetch_assoc($resultset))
		{
			$records[] = $r;
		}

		if(count($records) > 0){
			$obj['resultado'] = '1';
			$obj['query'] = $records;
			echo $callback.'(' . json_encode($obj) . ')';
		}else{
			$obj['resultado'] = '0';
			$obj['query'] = $records;
			echo $callback.'(' . json_encode($obj) . ')';
		}
	}

	if($consulta == 'verDonacionesFundacion'){

		mysql_query('SET CHARACTER SET utf8');
		$sql = "SELECT d.id, u.nombres, u.apellidos, d.implemento, d.cantidad FROM donaciones.donaciones d JOIN usuarios u ON d.usuarios_id_donante = u.id WHERE d.estados_donaciones_id = 2 AND d.usuarios_id_beneficiario = 1;";

		$resultset = mysql_query($sql,$connection);
		$records = array();
			//Loop through all our records and add them to our array
		while($r = mysql_fetch_assoc($resultset))
		{
			$records[] = $r;
		}

		if(count($records) > 0){
			$obj['resultado'] = '1';
			$obj['query'] = $records;
			echo $callback.'(' . json_encode($obj) . ')';
		}else{
			$obj['resultado'] = '0';
			$obj['query'] = $records;
			echo $callback.'(' . json_encode($obj) . ')';
		}
	}

	// Aceptar donación
	if($consulta == 'aceptarDonacion' && isset($_GET['data'])){

		$misParamentros = json_decode($_GET['data']);
		$id = $misParamentros->{'id'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "UPDATE donaciones SET estados_donaciones_id = 2 WHERE id = '$id'";

		$resultset = mysql_query($sql,$connection);
		if($resultset){
			$obj['resultado'] = '1';
			echo $callback.'(' . json_encode($obj) . ')';
		}else{
			$obj['resultado'] = '0';
			echo $callback.'(' . json_encode($obj) . ')';
		}
	}
}
?>