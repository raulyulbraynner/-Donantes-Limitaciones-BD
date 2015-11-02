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
		$telefono = $misParamentros->{'telefono'};
		$correo = $misParamentros->{'correo'};
		$direccion = $misParamentros->{'direccion'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO usuarios (usuario, contrasena, nombres, apellidos, telefono, correo, direccion, tipos_usuario_id, documento)
		VALUES ('$usuario', '$password', '$nombres', '$apellidos', '$telefono', '$correo', '$direccion', 3, '$documento')";

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
		$direccion = $misParamentros->{'direccion'};
		$tipoDiscapacidad = $misParamentros->{'tipo_discapacidad'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO usuarios (usuario, contrasena, nombres, apellidos, telefono, correo, direccion, tipos_usuario_id, documento, implemento, tipo_discapacidad)
		VALUES ('$documento', '$documento', '$nombres', '$apellidos', '$telefono', '$correo', '$direccion', 2, '$documento', '$implemento', '$tipoDiscapacidad')";

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
	if($consulta == 'agregarDonacionFundacion'){

		$implemento = $_POST['implemento'];
		$estado = $_POST['estado'];
		$idDonante = $_POST['idDonante'];
		$tipoDiscapacidad = $_POST['tipo_discapacidad'];
		$pathImg = 'imgDonaciones/d_f'.date('y_d_m_G_i_s').".jpg";

		move_uploaded_file($_FILES["file"]["tmp_name"], "../".$pathImg);

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO donaciones (implemento, estados_donaciones_id, usuarios_id_donante, usuarios_id_beneficiario, estado_implemento,tipo_discapacidad,url_foto)
		VALUES ('$implemento',1,'$idDonante',1,'$estado','$tipoDiscapacidad','$pathImg')";

		$resultset = mysql_query($sql,$connection) or die(mysql_error());
		if ($resultset) {
			$obj['resultado'] = '1';
			echo $callback.'(' . json_encode($obj) . ')';
		}
		else{
			$obj['resultado'] = '0';
			echo $callback.'(' . json_encode($obj) . ')';
		}
/*
		$misParamentros = json_decode($_GET['data']);

		$implemento = $misParamentros->{'implemento'};
		$estado = $misParamentros->{'estado'};
		$idDonante = $misParamentros->{'idDonante'};
		$tipoDiscapacidad = $misParamentros->{'tipo_discapacidad'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO donaciones (implemento, estados_donaciones_id, usuarios_id_donante, usuarios_id_beneficiario, estado_implemento,tipo_discapacidad)
		VALUES ('$implemento',1,'$idDonante',1,'$estado','$tipoDiscapacidad')";

		$resultset = mysql_query($sql,$connection) or die(mysql_error());
		if ($resultset) {
			$obj['resultado'] = '1';
			echo $callback.'(' . json_encode($obj) . ')';
		}
		else{
			$obj['resultado'] = '0';
			echo $callback.'(' . json_encode($obj) . ')';
		}*/
	}

	if($consulta == 'agregarDonacionUsuario'){

		$idBeneficiario = $_POST['idBeneficiario'];
		$implemento =$_POST['implemento'];
		$estado = $_POST['estado'];
		$tipoDiscapacidad = $_POST['tipo_discapacidad'];
		$idDonante = $_POST['idDonante'];
		$pathImg = 'imgDonaciones/d_u'.date('y_d_m_G_i_s').".jpg";

		move_uploaded_file($_FILES["file"]["tmp_name"], "../".$pathImg);

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO donaciones (implemento, estados_donaciones_id, usuarios_id_donante, usuarios_id_beneficiario, estado_implemento,tipo_discapacidad, url_foto)
		VALUES ((SELECT implemento FROM usuarios WHERE id = '$idBeneficiario'),1,'$idDonante','$idBeneficiario','$estado', '$tipoDiscapacidad', '$pathImg')";

		$resultset = mysql_query($sql,$connection) or die(mysql_error());
		if ($resultset) {
			$obj['resultado'] = '1';
			echo $callback.'(' . json_encode($obj) . ')';
		}
		else{
			$obj['resultado'] = '0';
			echo $callback.'(' . json_encode($obj) . ')';
		}
/* Modo anterior. (Previo al cambio de la foto)
		$misParamentros = json_decode($_GET['data']);

		$idBeneficiario = $misParamentros->{'idBeneficiario'};
		$implemento = $misParamentros->{'implemento'};
		$estado = $misParamentros->{'estado'};
		$tipoDiscapacidad = $misParamentros->{'tipo_discapacidad'};
		$idDonante = $misParamentros->{'idDonante'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO donaciones (implemento, estados_donaciones_id, usuarios_id_donante, usuarios_id_beneficiario, estado_implemento,tipo_discapacidad)
		VALUES ((SELECT implemento FROM usuarios WHERE id = '$idBeneficiario'),1,'$idDonante','$idBeneficiario','$estado', '$tipoDiscapacidad')";

		$resultset = mysql_query($sql,$connection) or die(mysql_error());
		if ($resultset) {
			$obj['resultado'] = '1';
			echo $callback.'(' . json_encode($obj) . ')';
		}
		else{
			$obj['resultado'] = '0';
			echo $callback.'(' . json_encode($obj) . ')';
		}
		*/
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
		$sql = "SELECT d.id, u.nombres, u.apellidos, u.direccion,d.implemento,d.url_foto FROM donaciones.donaciones d JOIN usuarios u ON d.usuarios_id_donante = u.id WHERE d.estados_donaciones_id = 1";

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
		$sql = "SELECT id, CONCAT(nombres, ' ', apellidos) as nombre, implemento, direccion, telefono FROM usuarios WHERE tipos_usuario_id = 2";

		$resultset = mysql_query($sql,$connection);
		$records = array();

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

	if($consulta == 'usuariosBeneficiariosDiscapacidad'){
		$misParamentros = json_decode($_GET['data']);
		$tipoDiscapacidad = $misParamentros->{'tipo_discapacidad'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "SELECT id, CONCAT(nombres, ' ', apellidos) as nombre, implemento, direccion, telefono FROM usuarios WHERE tipos_usuario_id = 2 AND tipo_discapacidad = '$tipoDiscapacidad' AND id NOT IN (SELECT usuarios_id_beneficiario FROM donaciones)";

		$resultset = mysql_query($sql,$connection);
		$records = array();

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

	if($consulta == 'verDonacionesRechazadas'){

		mysql_query('SET CHARACTER SET utf8');
		$sql = "SELECT id, nombre_donante, implemento, observaciones FROM donaciones_rechazadas";

		$resultset = mysql_query($sql,$connection);
		$records = array();

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

	if ($consulta == 'donacionesRealizadasUsuario' && isset($_GET['data'])) {
		$misParamentros = json_decode($_GET['data']);
		$idUsuario = $misParamentros->{'idUsuario'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "SELECT d.id, d.implemento, d.estado_implemento, d.tipo_discapacidad, CONCAT(ud.nombres, ' ' , ud.apellidos) as donante, d.url_foto FROM donaciones d JOIN usuarios u ON d.usuarios_id_beneficiario = u.id JOIN usuarios ud ON d.usuarios_id_donante = ud.id WHERE usuarios_id_beneficiario = '$idUsuario';";

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
		$sql = "SELECT d.id, u.nombres, u.apellidos, d.implemento, d.url_foto FROM donaciones d JOIN usuarios u ON d.usuarios_id_donante = u.id WHERE d.estados_donaciones_id = 2 AND d.usuarios_id_beneficiario = 1;";

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

	if($consulta == 'verDonacionesSeguimiento'){

		mysql_query('SET CHARACTER SET utf8');
		$sql = "SELECT
		d.id, CONCAT(u.nombres, ' ', u.apellidos) as donante, CONCAT(u.nombres, ' ', u.apellidos) as beneficiario, d.implemento, d.url_foto
		FROM
		donaciones d
		JOIN
		usuarios u ON d.usuarios_id_donante = u.id
		JOIN
		usuarios b ON d.usuarios_id_beneficiario = b.id
		WHERE
		d.estados_donaciones_id = 2;";

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

	if($consulta == 'verSeguimientos'){

		$misParamentros = json_decode($_GET['data']);
		$idDonacion = $misParamentros->{'idDonacion'};
		mysql_query('SET CHARACTER SET utf8');
		$sql = "SELECT descripcion,created FROM seguimientos WHERE donaciones_id = $idDonacion";

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

	// Guardar seguimiento
	if($consulta == 'guardarSeguimiento' && isset($_GET['data'])){

		$misParamentros = json_decode($_GET['data']);
		$idDonacion = $misParamentros->{'idDonacion'};
		$descripcion = $misParamentros->{'descripcion'};

		mysql_query('SET CHARACTER SET utf8');
		$sql = "INSERT INTO seguimientos (descripcion, donaciones_id) VALUES ('$descripcion', $idDonacion)";

		$resultset = mysql_query($sql,$connection);
		if($resultset){
			$obj['resultado'] = '1';
			echo $callback.'(' . json_encode($obj) . ')';
		}else{
			$obj['resultado'] = '0';
			echo $callback.'(' . json_encode($obj) . ')';
		}
	}

	if($consulta == 'rechazarDonacion' && isset($_GET['data'])){

		$misParamentros = json_decode($_GET['data']);
		$id = $misParamentros->{'id'};
		$motivo = $misParamentros->{'motivo'};

		mysql_query("INSERT INTO donaciones_rechazadas (nombre_donante, implemento, observaciones) SELECT CONCAT(nombres, ' ', apellidos), d.implemento, '$motivo' FROM donaciones d JOIN usuarios u ON d.usuarios_id_donante = u.id WHERE d.id = '$id'");

		mysql_query('SET CHARACTER SET utf8');
		$sql = "DELETE FROM donaciones WHERE id = '$id'";

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