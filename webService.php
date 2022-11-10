<?php
//echo '<pre>';
//print_r($_SERVER);
// Conectamos a BBDD
$mysqli = new mysqli('localhost', 'root', 'root', 'nascor01_DB');
if ($mysqli->connect_errno) {
    echo "Lo sentimos, este sitio web está experimentando problemas.";
    echo "Error: Fallo al conectarse a MySQL debido a: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    exit;
}
$mysqli->set_charset("utf8");
//Cosultar las tablas


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        // Realizar una consulta SQL
        $sql = "SELECT * FROM `symbol` WHERE `id_symbol` = " . $_GET['id'];

        if (!$resultado = $mysqli->query($sql)) {
            // ¡Oh, no! La consulta falló. 
            echo "Lo sentimos, este sitio web está experimentando problemas.";
            echo "Error: La ejecución de la consulta falló debido a: \n";
            echo "Query: " . $sql . "\n";
            echo "Errno: " . $mysqli->errno . "\n";
            echo "Error: " . $mysqli->error . "\n";
            exit;
        }
    } 
	
	 if (isset($_GET['symbol'])) {
		$symbol = $_GET['symbol'];
		 
		 				// sql to create table
	$sql = "CREATE TABLE `nascor01_DB`.`symbol` ( 
	`id_symbol` INT NOT NULL AUTO_INCREMENT ,
	`symbol` VARCHAR(10) NOT NULL , 
	PRIMARY KEY (`id_symbol`)) ENGINE = InnoDB;";
		 
		 $sql = "CREATE TABLE `nascor01_DB`.`meta_data` (
		 `id` INT NOT NULL AUTO_INCREMENT ,
		 `information` VARCHAR(100) NOT NULL ,
		 `symbol` VARCHAR(20) NOT NULL , 
		 `last_refreshed` DATE NOT NULL , 
		 `out_size` VARCHAR(20) NOT NULL , 
		 `id_symbol` int(11) NOT NULL,
		  `time_zone` VARCHAR(50) NOT NULL , 
		 PRIMARY KEY (`id`)) ENGINE = InnoDB;";
		 
		 $sql ="CREATE TABLE 
		 `nascor01_DB`.`time_series_daily` 
		 ( `id` INT NOT NULL AUTO_INCREMENT , 
		 `daily` DATE NOT NULL , 
		 `open` FLOAT NOT NULL , 
		 `high` FLOAT NOT NULL , 
		 `low` FLOAT NOT NULL , 
		 `close` FLOAT NOT NULL ,
		 `volume` FLOAT NOT NULL ,
		 `id_symbol` INT NOT NULL ,
		 PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        
		if ($mysqli->query($sql) === TRUE) {
			//Table symbol created successfully";
			} else {
			//consultamos que los datos existen 
			$sql = "SELECT * FROM `symbol` WHERE `symbol` = '$symbol'";
			
			if($mysqli->query($sql)->num_rows > 0 ){// comprueba que existen datos 
				//echo 'si hay datos mostrar todos()';
		$sql = "SELECT * FROM `symbol` WHERE `symbol` = '$symbol'";
				
				 //obtenemos el id_symbol de la consulta
				$registro = $mysqli->query($sql);
				while ($fila = $registro->fetch_assoc()) {
				 $id_symbol = $fila['id_symbol'];
				 $symbol = $fila['symbol'];
					
				}
				// recuperamos datos de la tabla meta_data
				$sql = "SELECT * FROM `meta_data` WHERE `id_symbol` = '$id_symbol'";
				
				 //obtenemos el id_symbol de la consulta
				$registro = $mysqli->query($sql);
				$result = '{"meta_data":{';
				while ($fila = $registro->fetch_assoc()) {
				
		$result .='"information":"'.$fila['information'].'","symbol":"'.$fila['symbol'].'","last_refreshed":"'.$fila['last_refreshed'].'","out_size":"'.$fila['out_size'].'","time_zone":"'.$fila['time_zone'].'"},';
				}
							 
    // Realizar una consulta SQL
        $sql = "SELECT * FROM `time_series_daily` WHERE `id_symbol` = '$id_symbol'";
        if (!$resultado = $mysqli->query($sql)) {
            // ¡Oh, no! La consulta falló. 
            echo "Lo sentimos, este sitio web está experimentando problemas.";
            echo "Error: La ejecución de la consulta falló debido a: \n";
            echo "Query: " . $sql . "\n";
            echo "Errno: " . $mysqli->errno . "\n";
            echo "Error: " . $mysqli->error . "\n";
            exit;
        }
     $registro_json = []; //creamos un array para mostrar en pantalla
    
				$i=0;
   $result .= '"time_series_daily":{';
				$registro = $mysqli->query($sql);
				while ($fila = $registro->fetch_assoc()) {
				//'$fila['id'];
				if($i>0){
					$result .= ',';
				}	
					$i++;
								
				$result .= '"'. $fila['daily'].'":{"id":"'.$fila['id'].'","open":"'.$fila['open'].'","high":"'.$fila['high'].'","low":"'.$fila['low'].'","close":"'.$fila['close'].'","volume":"'.$fila['volume'].'","id_symbol":"'.$fila['id_symbol'].'"}';
					
				}
				$result .= '}}';
				
				header('Content-Type: application/json');
				echo $result;
			}
			else{
				//echo 'de lo contrario guardar';
				$sql = "INSERT INTO `symbol` (id_symbol, symbol) VALUES (NULL, '$symbol')";
  				$registro = $mysqli->query($sql);
				//obtengo el ultimo id ingresado 
				$last_id=  $mysqli -> insert_id;
				$data = json_decode(file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=$symbol&outputsize=full&apikey=S1EDEWMYFQAFWTS4"), true);
				/*ya no funcionan por ser demo*/
				 // primera key API 0XQB6K7M2RYU0QE6  
				// segunda key API 'S1EDEWMYFQAFWTS4'
				
				$information=$data['Meta Data']['1. Information'];
				$symbol=$data['Meta Data']['2. Symbol'];
				$last_refreshed=$data['Meta Data']['3. Last Refreshed'];
				$out_size=$data['Meta Data']['4. Output Size'];
				$time_zone=$data['Meta Data']['5. Time Zone'];
				
				// insertamos el meta data con el ultimo id_symbol
				$sql="INSERT INTO `meta_data` 
				(`id`, `information`, `symbol`, `last_refreshed`, `out_size`, `id_symbol`,`time_zone`) 
				VALUES (NULL, '$information', '$symbol', '$last_refreshed', '$out_size', '$last_id','$time_zone')";
				$mysqli->query($sql);
			 
				
    $registro_json = []; //creamos un array
	foreach ($data['Time Series (Daily)'] as $clave => $array){
		$registro_json = []; //creamos un array
		foreach ($array as $key => $value){
			$registro_json[] = $value;
		}
		
		 $open= json_encode(floatval($registro_json[0]));
		 $high= json_encode(floatval($registro_json[1]));
		 $low= json_encode(floatval($registro_json[2]));
		 $close= json_encode(floatval($registro_json[3]));
		 $volume= json_encode(floatval($registro_json[4]));

 
			
		$sql="INSERT INTO `time_series_daily` 
		(`id`, `daily`, `open`, `high`, `low`, `close`, `volume`, `id_symbol`) 
		VALUES (NULL, '$clave', '$open', '$high', '$low', '$close', '$volume', '$last_id');";
		$mysqli->query($sql);
			
	}
			
			}
			//$mysqli->close();
			
		}
	 }

    // El script automáticamente cerrará la conexión
   
    exit();
}
