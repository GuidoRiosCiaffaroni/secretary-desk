<?php

/*Inicio crear shortcode en la pagina de inicio */
add_shortcode('kfp_ShotCondeBuscar_form', 'Kfp_Buscar_form');
/*Fin crear shortcode enla pagina de inicio*/ 

/*Inicio funcion para crear shortcode en la pagina de inicio */

function Kfp_Buscar_form() 
{
  global $wpdb;
  $registros = $wpdb->get_results( "SELECT * FROM wp_secretarydesk" );



        // nombre de los campos de la tabla
        foreach ($registros as $registros) {
            $result .= 
            '
            <tr>
                <td>'.$registros->id.'</td>
                <td>'.$registros->nint.'</td>
            </tr>
            ';
        }



        $template = '<table class="table-data">
                      <tr>
                        <th>ID</th>
                        <th>nint</th>
                      </tr>
                      {data}
                    </table>';

        return $content.str_replace('{data}', $result, $template);


  }
// Ejecutamos nuestro funcion en WordPress
//add_action('wp', 'leer_wpdb');

?>