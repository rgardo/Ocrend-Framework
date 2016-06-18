<?php

defined('INDEX_DIR') OR exit('Ocrend software says .i.');

abstract class Controllers {

  protected $template;
  protected $isset_id;
  protected $mode;

  /**
    * Constructor, inicializa los alcances de todos los Controladores
    *
    * @param bool $LOGED: Si el controlador en cuestión será solamente para usuarios logeados, se pasa TRUE
    * @param bool $CACHE: Si la VISTA para el controlador en cuestión se quiere compilar una única sin detectar futuros cambios vez se pasa TRUE
    *
    * @return void
  */
  protected function __construct(bool $LOGED = false, bool $CACHE = false) {

    if(DEBUG) {
      $_SESSION['___QUERY_DEBUG___'] = array();
    }

    if($LOGED and !isset($_SESSION[SESS_APP_ID])) {
      Func::redir();
      exit;
    }

    #Definición de templates
    $this->template = new Twig_Environment(new Twig_Loader_Filesystem('templates'), array(
      'cache' => 'templates/.compiler',
      'auto_reload' => !$CACHE
    ));
    $this->template->addGlobal('session', $_SESSION);
    $this->template->addGlobal('get', $_GET);
    $this->template->addGlobal('post', $_POST);

    /*
      #AGREGAR FUNCIÓN A TWIG
      $function = new Twig_SimpleFunction('MiFuncionDesdeTwig',function($parametros) {
        return MiFuncion($parametros);
      });
      $this->template->addFunction($function);
    */

    $this->mode = $_GET['mode'] ?? null;
    $this->isset_id = isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] >= 1;
  }

}

?>
