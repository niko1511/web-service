<?php

/*incluimos la url del modelo solo una vez para genenerar una nueva instancia por cada vez que se llame al bloque*/
include_once get_template_directory() . '/blocks-models/timeSeriesIntradayModel.php';
/*creamos una nueva instancia y le pasamos un parametro que retornara un valor que será almacenado en la variable rows*/
$intraday = new Intraday();
/*llamo a la funcion que se encuentra dentro de la clase generada por la instancia  y le paso un string recibido */
$rows = $intraday->timeSeriesIntraday(block_field('stock',false));
/*convierto el string a objecto que es obtenido de la cosulta al web-service para poder trabajarlo mejor*/
 $object = json_decode($rows);

/*genero las variables del primero array que se encuentra dentro del objecto para un mejor manejo de la informacion y programación */
$information = $object->meta_data->information;
$symbol = $object->meta_data->symbol;
$last_refreshed = $object->meta_data->last_refreshed;
$out_size = $object->meta_data->out_size;
$time_zone = $object->meta_data->time_zone;

/*creo un foreach del arreglo que se encuentra dentro del segundo array del objeto principal*/
/*obtengo un array del segundo array del objeto principal*/
foreach($object->time_series_daily  as $clave =>$array){
	/*obtengo el arreglo y por cada interación le asigno el valor de cada key a su variable correspondiente */
	foreach($array as $key => $valor){
		$daily[]= $clave; // obtengo la clave  por cada vez que se ejecuta el primer foreach por vuelta
		$key_id[] = $array->id;
		$open[] = $array->open;
		$high[] = $array->high;
		$low[] = $array->low;
		$close[] = $array->close;
		$volume[] = $array->volume;
		
		
	}
}	

/*llamamos a la vista correspondiente para mostrar los valores */
include get_template_directory() . '/blocks-views/metaDataCardStockView.php';

?>

