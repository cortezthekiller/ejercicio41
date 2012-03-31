<?
include("/var/seguridad/mysql.inc.php");

$table    = "tabla1";
$datafile = "datos41.txt";

/* Conectamos con el servidor y comprobamos la conexión */
$link = mysql_connect($mysql_host, $mysql_user, $mysql_passwd)
        or die("Error en la conexión: ".mysql_error());

mysql_select_db ($mysql_db, $link); 

/* Vamos a leer los datos de un archivo de texto */
$fd = fopen($datafile, "r") or die("Error abriendo archivo: ".mysql_error());

while(!feof($fd)) {
   /* Recoger en un array cada palabra de una línea */
   $arr = explode(",", fgets($fd));

   /* En este caso es útil la opción IGNORE si queremos añadir */
   /* nuevos datos al archivo de texto, para que ignore los    */
   /* registros que ya existen en la tabla.                    */
   $query  = "INSERT IGNORE INTO $table (";
   $query .= "dni, nombre, apellido1, apellido2, fecha_nac, repetidor) ";
   $query .= "VALUES ('$arr[0]', '$arr[1]', '$arr[2]', ";
   $query .= "'$arr[3]', '$arr[4]', '$arr[5]')";

   /* No se por qué, la última iteración (EOF) recoge */
   /* valores vacíos en vez de salir del bucle while. */
   /* Con este condicional evitamos el problema       */
   if($arr[0]) {
      echo $query."</br>";
      mysql_query($query, $link) 
      or die("Error query INSERT: ".mysql_error($link));
   }
}

fclose($fd);
mysql_close($link);
?>
