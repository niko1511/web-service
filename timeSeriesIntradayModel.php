<?php


class Intraday{
    private $db;
    public $rows;

   // esta funcion se encarga de llamar al web service pasandole un parametro y esta devolvera un array
    public function timeSeriesIntraday($symbol){
			
	$url ="https://nascor01.md360.es/web-service/web-service/webService.php?symbol=$symbol";
	
	return  file_get_contents($url);
		
		   
  /*      return $data = json_decode(file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=$symbol&outputsize=full&apikey=0XQB6K7M2RYU0QE6"), true);*/
    }

}
	
