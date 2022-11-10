# web-service en WordPress
<strong>hacer consulta al web-service y obtener datos de MySQL , sino hay datos guardados obtenerlo de un API rest
</strong>


Proyecto final

Como proyecto final quiero presentar todo los ejercicios que fuimos desarrollando a lo largo del curso, en el menú PROYECTOS ->STOCK`S es lo último que estaba intentando hacer en el cual me queda algunas cosas que resolver, os comento este último en concreto porque sino la explicación sería extensa.  

la idea es el uso de Custom Post Type < !--Panel de administración para crear tipos de contenido personalizados y taxonomías 
crear en una de ellas un bloque personalizado en mi caso he utilizado Genesis Custom Blocks <!-- hace que sea fácil aprovechar esto y construir bloques personalizados.


Proceso de desarrollo : 
instalamos  los plugin necesarios, en este proyecto “ Custom Post Type” & “Genesis Custom Blocks”

Block Personalizado : 
	en bloques personalizados creamos un nuevo bloque con el nombre stocks,
en la edición del nuevo bloque le creamos un campo de categoría Texto



La idea general del proyecto es que mediante bloques personalizados se pueda hacer consultas a un web-service personalizado en el cual decida de donde obtener los datos si de una API externa o de su misma base de datos.
al estar utilizando wordPress como base de todo el conjunto donde se encuentra la web no he querido utilizar la misma base de datos de wordPress para generar su propia base de datos ya que la información a trabajar podría ser extensa 

el proceso es el siguiente :


Web-service : 

recibe $_GET un parámetro en este caso “symbol” crea las tablas necesarias en otra base de datos externa.
De esta forma intentó agilizar los manejos de información al momento de cargar la vista, lo segundo importante es crear una tabla de respaldo en el caso que la información a consultar esté desactualizada .


Una vez creada las tablas  pregunta de dónde obtener la información, en este caso al ser creada por primera vez hace uso de un API externa obteniendo un JSON y los separa en array para poder insertar su valor  en las diferentes tablas anteriormente creadas.


El primer registro contiene un array con clave => valor  obtener la información de este me resultó más sencilla que el segundo array del JSON.


En el segundo array obtenemos todos los valores por vuelta de cada vueltas.
Los valores necesarios se extraen del foreach a una variable convirtiendo los datos a float Una vez terminado el foreach interno se insertan los datos en la tabla SQL y realiza el nuevo ciclo hasta su fin principal. 


Generar la respuesta del web service
realiza una consulta a la tablas necesarias para la respuesta
creamos una variable $result donde almacenaremos los datos obtenidos en el formato que 
necesitamos 
realizamos una segunda consulta a otra tabla que necesitamos para componer el JSON
y los datos obtenidos y lo concatenamos a la variable $result para conformar un objeto
devolución de la respuesta 
header('Content-Type: application/json');		
echo $result;

para comprobar su funcionamiento del web service https://nascor01.md360.es/web-service/web-service/webService.php?symbol=ocgn 



resumiendo..
Utilizando un themes personalizado en este caso jjnico añado tres carpetas principales
llamadas blocks , blocks-models y blocks-views 
la primera carpeta blocks contiene todos los bloques creados 



en la carpeta blocks
el archivo block-stocks.php

en la carpeta blocks-models
el archivo timeSeriesIntradayModel.php


en la carpeta blocks-views
el archivo  metaDataCardStockView.php 


<h2><strong>Nota:</strong> en el archivo memoria.pdf se encuentra mejor ilustrado </h2>

ver resultado a falta de darle mejor estilos css  y distribución de la información  
https://nascor01.md360.es/wordpress/index.php/stocks/stocks/
