<?php

/*Inicio crear shortcode en la pagina de inicio */
add_shortcode('kfp_ShotCondeBuscar_form', 'Kfp_Buscar_form');
/*Fin crear shortcode enla pagina de inicio*/ 

/*Inicio funcion para crear shortcode en la pagina de inicio */

function Kfp_Buscar_form() 
{
  global $wpdb;
  $registros = $wpdb->get_results( "SELECT nombre, email FROM wp_secretarydesk" );
  echo "id: " . $registros[0]->id . ", nint: " . $registros[0]->nint . "<br/>";
  }
// Ejecutamos nuestro funcion en WordPress
add_action('wp', 'leer_wpdb');

?>