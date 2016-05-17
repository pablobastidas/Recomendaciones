<?php
require_once("../app/core/GenericController.php");
require_once("../app/models/Autor.php");
require_once("../app/views/AutorView.php");
/**
 * Controldor del Autor
 *
 * @author Jazna
 * @copyright 2016 
 */
class AutorController extends GenericController{
	static function handler(){
		$evento = NUEVO_AUTOR;	
		$uri = $_SERVER['REQUEST_URI'];

		# Setea la vista
		AutorView::setView();

		# Lista de peticiones disponibles
		$peticiones = array(AGREGAR_AUTOR, VER_AUTORES, EDICION_AUTOR, EDITAR_AUTOR, EDITA_AUTOR, FILTRAR_AUTOR, FILTRA_AUTOR);

		# Analiza la petición
		foreach ($peticiones as $peticion) {
			$uri_peticion = $peticion . "/";
			if (strpos($uri, $uri_peticion)){
				$evento = $peticion;
			}
		}
		# Obtiene los parámetros que vienen de la URL
		$data = AutorController::helper();
		# Crea el objeto
		$objetoPersistente = AutorController::setearObjeto();
		# Analiza el evento que debe gatillar
		switch ($evento) {	
			case AGREGAR_AUTOR:
				# Setea el objeto con los datos que se han recuperado
				$objetoPersistente->set($data);
 				$data["mensaje"] = $objetoPersistente->mensaje;		 					
				AutorView::retornar_vista(VER_AUTOR, $data);			
				break;		
			case VER_AUTORES:
				$registros = $objetoPersistente->select('au_nombre');
				$data = array('mensaje' => 'Listado de autores', 'tabla'=>''); 
				# Traspasa el control a la vista que corresponde
				AutorView::mostrar_registros(VER_REGISTROS, $data, $registros);		
				break;	
			case EDICION_AUTOR:
				# Obtiene el registro dado el ID
				if ($objetoPersistente->get($data['id'])){
					$data = array(
                        'id' =>$objetoPersistente->au_id,
                        'nombre' =>$objetoPersistente->au_nombre,
                        'nacimiento' => $objetoPersistente->au_nacimiento                     
                    );
                    $data['mensaje'] = Config::get('msg_exito');
                    # Traspasa el control a la vista que corresponde
					AutorView::retornar_vista(MODIFICAR_AUTOR, $data);	 
					break;                   
				}
				else{	
					$data = array(
                        'id' => $data['id'],
                        'nombre' => '-',
                        'nacimiento' => '-'                       
                    );
					$data['mensaje'] = Config::get('msg_fracaso');
					# Traspasa el control a la vista que corresponde
					AutorView::retornar_vista(VER_AUTOR, $data);						
					break;						
				}				

			case EDITA_AUTOR:
				$objetoPersistente->edit($data);
				$registros = $objetoPersistente->select('au_nombre');
				$data['mensaje'] = $objetoPersistente->mensaje;
				AutorView::mostrar_registros(VER_REGISTROS, $data, $registros);			
				break;
			case FILTRA_AUTOR:
				$registros = $objetoPersistente->select('au_nombre', 'au_nacimiento', 
									$data['inicio'], $data['fin']);
				$data['mensaje'] = $objetoPersistente->mensaje;
				AutorView::mostrar_registros(VER_REGISTROS, $data, $registros);			
				break;
			default:
				AutorView::retornar_vista($evento);
				break;				
		}
	}
	
	# Obtiene los parámetros de la URL
	static function helper(){
		$data = array();
		if ($_POST){
			if(array_key_exists('nombre', $_POST)){
				$data['nombre'] = $_POST['nombre'];
			}
			if(array_key_exists('nacimiento', $_POST)){
				$data['nacimiento'] = $_POST['nacimiento'];
			}			
			if(array_key_exists('libro', $_POST)){
				$data['libro'] = $_POST['libro'];
			}		
			if(array_key_exists('id', $_POST)){
				$data['id'] = $_POST['id'];
			}										
		}
		elseif ($_GET){
			if (array_key_exists('id', $_GET)){
				$data['id'] = $_GET['id'];
			}
			if (array_key_exists('inicial', $_GET)){
				$data['inicio'] = $_GET['inicial'];
			}			
			if (array_key_exists('final', $_GET)){
				$data['fin'] = $_GET['final'];
			}						
		}
		return $data;
	}

	# Retorna un objeto del modelo
	static function setearObjeto(){
		$objeto = new Autor();
		return $objeto;
	}	
}
?>