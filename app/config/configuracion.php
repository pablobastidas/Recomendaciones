<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', DS . "MVC-Basico" . DS); 

/**
 * Parámetros de configuración de la app
 * @author Jazna
 * @copyright (c) 2016
 */
class Config{
    /**
    * Conjunto de datos que corresponden a la configuración
    * @var array
    * @access private
    */  
    static private $configuracion = array(
		"autor"    =>"Jazna Meza Hidalgo",
		"path"      => "/MVC-Basico/",
		"path_css" =>  "/MVC-Basico/assets/css/bootstrap.min.css",
		"path_js" => "/MVC-Basico/assets/js/bootstrap.min.js",		
		"msg_agregar" => "Registro agregado con éxito",
		"msg_modificar" => "Registro modificado con éxito",
		"msg_accesofracaso" => "Imposible actualizar tabla",
		"msg_exito" => "Registro encontrado",
		"msg_fracaso" => "Registro NO existe",
		"msg_filtroexitoso" => "Registros encontrados",
		"msg_filtrofracaso" => "Búsqueda por filtro no contiene resultados"
	);
        
        /**
         * Retorna un parámetro especifico de la app	
         * @param string $name, nombre del parámetro
         * @return string
         */
	static function get($name){
            return self::$configuracion[$name];
	}
}
?>