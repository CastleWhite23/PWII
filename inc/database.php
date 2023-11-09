<?php
mysqli_report(MYSQLI_REPORT_STRICT);

function open_database()
{
	try {
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$conn->set_charset("utf8");
		return $conn;
	} catch (Exception $e) {
		echo $e->getMessage();
		return null;
	}
}

function close_database($conn)
{
	try {
		mysqli_close($conn);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}
/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 */
function find($table = null, $id = null)
{
	try {
		$database = open_database();
		$found = null;
		if ($id) {
			$sql = "SELECT * FROM " . $table . " WHERE id = " . $id;
			$result = $database->query($sql);

			if ($result->num_rows > 0) {
				$found = $result->fetch_assoc();
			}
		} else {

			$sql = "SELECT * FROM " . $table;
			$result = $database->query($sql);

			if ($result->num_rows > 0) {
				$found = $result->fetch_all(MYSQLI_ASSOC);

				/* Metodo alternativo
					$found = array();
					while ($row = $result->fetch_assoc()) {
					array_push($found, $row);
					} */
			}
		}
	} catch (Exception $e) {
		$_SESSION['message'] = $e->GetMessage();
		$_SESSION['type'] = 'danger';
	}

	close_database($database);
	return $found;
}
function find_all($table)
{
	return find($table);
}

/**
 *  Insere um registro no BD
 */
function save($table = null, $data = null)
{

	$database = open_database();

	$columns = null;
	$values = null;

	//print_r($data);

	foreach ($data as $key => $value) {
		$columns .= trim($key, "'") . ",";
		$values .= "'$value',";
	}

	// remove a ultima virgula
	$columns = rtrim($columns, ',');
	$values = rtrim($values, ',');

	$sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";

	try {
		$database->query($sql);

		$_SESSION['message'] = 'Registro cadastrado com sucesso.';
		$_SESSION['type'] = 'success';
	} catch (Exception $e) {

		$_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
		$_SESSION['type'] = 'danger';
	}

	close_database($database);
}



function update($table = null, $id = 0, $data = null)
{

	$database = open_database();

	$items = null;

	foreach ($data as $key => $value) {
		$items .= trim($key, "'") . "='$value',";
	}

	// remove a ultima virgula
	$items = rtrim($items, ',');

	$sql  = "UPDATE " . $table;
	$sql .= " SET $items";
	$sql .= " WHERE id=" . $id . ";";

	try {
		$database->query($sql);

		$_SESSION['message'] = 'Registro atualizado com sucesso.';
		$_SESSION['type'] = 'success';
	} catch (Exception $e) {

		$_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
		$_SESSION['type'] = 'danger';
	}

	close_database($database);
}

function remove( $table = null, $id = null ) {

	$database = open_database();
	  
	try {
	  if ($id) {
  
		$sql = "DELETE FROM " . $table . " WHERE id = " . $id;
		$result = $database->query($sql);
  
		if ($result = $database->query($sql)) {   	
		  $_SESSION['message'] = "Registro Removido com Sucesso.";
		  $_SESSION['type'] = 'success';
		}
	  }
	} catch (Exception $e) { 
  
	  $_SESSION['message'] = $e->GetMessage();
	  $_SESSION['type'] = 'danger';
	}
  
	close_database($database);
  }





function formatadata($date, $formato)
{
	$dt = new Datetime($date, new DatetimeZone("America/Sao_Paulo"));
	return $dt->format($formato);
}

function formatacep($cep)
{
	$cp = substr($cep, 0, 5) . "-" . substr($cep, 5);
	return $cp;
}


// function formatatel($numero)
// {
// 	if (strlen($numero) == 10) {
// 		$novo = substr_replace($numero, '(', 0, 0);
// 		$novo = substr_replace($novo, '9', 3, 0);
// 		$novo = substr_replace($novo, ')', 3, 0);
// 	} else {
// 		$novo = substr_replace($numero, '(', 0, 0);
// 		$novo = substr_replace($novo, ')', 4, 0);
// 		$novo = substr_replace($novo, '-', 12, 0);
// 	}
// 	return $novo;
// }

function formatarTelefoneCelular($numero) {
    // Remove caracteres não numéricos do número
    $numero = preg_replace('/[^0-9]/', '', $numero);

    // Verifica se o número tem 11 dígitos (formato com DDD)
    if (strlen($numero) == 11) {
        return '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 5) . '-' . substr($numero, 7);
    }
    // Verifica se o número tem 10 dígitos (formato sem DDD)
    elseif (strlen($numero) == 10) {
        return '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 4) . '-' . substr($numero, 6);
    }

    // Se o número não tiver 10 ou 11 dígitos, retorna o número original
    return $numero;
}

function formatarTelefoneFixo($numero) {
    // Remove caracteres não numéricos do número
    $numero = preg_replace('/[^0-9]/', '', $numero);

    // Verifica se o número tem 10 dígitos
    if (strlen($numero) == 10) {
        return '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 4) . '-' . substr($numero, 6);
    }

    // Se o número não tiver 10 dígitos, retorna o número original
    return $numero;
}


