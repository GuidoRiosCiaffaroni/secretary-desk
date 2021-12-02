<?php

/*Inicio crear shortcode en la pagina de inicio */
add_shortcode('kfp_ShotCondeIngreso_form', 'Kfp_Ingreso_form');
/*Fin crear shortcode enla pagina de inicio*/ 

/*Inicio funcion para crear shortcode en la pagina de inicio */


function Kfp_Ingreso_form() 
{

global $wpdb; // Este objeto global permite acceder a la base de datos de WP
    // Si viene del formulario  graba en la base de datos




        global $user_id;
        global $key_id;
        global $status_id;
        global $nint;
        global $date;



        /*
        global $depto_unid;
        global $nombres;
        global $apellido_paterno;
        global $apellido_materno;
        global $rut;
        global $email;
        global $perm_admin;
        global $fdo_legal;
        global $perm_parent;
        global $dias;
        global $desde;
        global $hasta;
        global $nombre_pdf;
        global $dir_archivo_externo;
        global $user_id;
        global $status_id;
        global $key_id;
        */

        
        if (get_current_user_id() != NULL) 
        {
        	//echo 'Usuario validado ';
        	$tabla_aspirantes = $wpdb->prefix . 'secretarydesk';
        	echo "<p class='exito'><b>Usuario validado</b>. Puede ingresar los datos.<p>"; 
    	}

        $tabla_aspirantes = $wpdb->prefix . 'secretarydesk'; 

        $user_id                = sanitize_text_field($_POST['user_id']);
        $key_id                 = sanitize_text_field($_POST['key_id']);
        $status_id              = sanitize_text_field($_POST['status_id']);
        $nint                   = sanitize_text_field($_POST['nint']);
        $date                   = sanitize_text_field($_POST['date']);

        /*
        $depto_unid             = sanitize_text_field($_POST['depto_unid']);
        $nombres                = sanitize_text_field($_POST['nombres']);
        $apellido_paterno       = sanitize_text_field($_POST['apellido_paterno']);
        $apellido_materno       = sanitize_text_field($_POST['apellido_materno']);
        $rut                    = sanitize_text_field($_POST['rut']);
        $email                  = sanitize_text_field($_POST['email']);
        $perm_admin             = sanitize_text_field($_POST['perm_admin']);
        $fdo_legal              = sanitize_text_field($_POST['fdo_legal']);
        $perm_parent            = sanitize_text_field($_POST['perm_parent']);
        $dias                   = sanitize_text_field($_POST['dias']);
        $desde                  = sanitize_text_field($_POST['desde']);
        $hasta                  = sanitize_text_field($_POST['hasta ']);
        $nombre_pdf             = sanitize_text_field($_POST['nombre_pdf']);
        $dir_archivo_externo    = sanitize_text_field($_POST['dir_archivo_externo']);
        $user_id                = sanitize_text_field($_POST['user_id']);
        $status_id              = sanitize_text_field($_POST['status_id']);
        $key_id                 = sanitize_text_field($_POST['key_id']);
        */
        
        //https://stackoverflow.com/questions/33748430/wordpress-user-image-upload
        //$upload = wp_upload_bits($_FILES['wp_custom_attachment']['name'], null, @file_get_contents($_FILES['wp_custom_attachment']['tmp_name']));


        //https://developer.wordpress.org/reference/functions/wp_upload_dir/
        /*
        $current_user = wp_get_current_user();
        $upload_dir   = wp_upload_dir();
 
        if ( isset( $current_user->user_login ) && ! empty( $upload_dir['basedir'] ) ) {
            $user_dirname = $upload_dir['basedir'].'/'.$current_user->user_login;
            if ( ! file_exists( $user_dirname ) ) {
                wp_mkdir_p( $user_dirname );
            }
        }
        */


        /* Inicio subir archivo */
        $upload = wp_upload_bits(
            $_FILES['wp_custom_attachment']['name'], 
            null, 
            @file_get_contents($_FILES['wp_custom_attachment']['tmp_name'])
        );

        $current_user = wp_get_current_user();
        $upload_dir   = wp_upload_dir();
 
        if ( isset( $current_user->user_login ) && ! empty( $upload_dir['basedir'] ) ) {
            $user_dirname = $upload_dir['basedir'].'/'.date('Y').'/'.date('m').'/'.date('d').'/';
            if ( ! file_exists( $user_dirname ) ) {
                wp_mkdir_p( $user_dirname );
            }
        }


        // verifica la existencia de la variable antes de renonbrar el archivo 
        if ( isset($upload) != TRUE   ) 
        {
            rename($upload['file'] , $user_dirname.time().'_'.$_FILES['wp_custom_attachment']['name']);  
            $file = date('Y').'/'.date('m').'/'.date('d').'/'.time().'_'.$_FILES['wp_custom_attachment']['name']; 
        }
   

    


        /* Fin subir archivo */     

        /*
        $thefile = $upload['file'];
        $upload_dir = wp_upload_dir();
        $newfolder = $user_dirname;
        move_uploaded_file($thefile, $newfolder);
        */


/*
       $wpdb->insert(
            $tabla_aspirantes,
            array(
                'user_id'               => $user_id,
                'key_id'                => $key_id,
                'status_id'             => $status_id,
                'nint'                  => $nint,
                'date'                  => $date,
                'depto_unid'            => $depto_unid,
                'nombres'               => $nombres,
                'apellido_paterno'      => $apellido_paterno,
                'apellido_materno'      => $apellido_materno,
                'rut'                   => $rut,
                'email'                 => $email,
                'perm_admin'            => $perm_admin,
                'fdo_legal'             => $fdo_legal,
                'perm_parent'           => $perm_parent,
                'dias'                  => $dias,
                'desde'                 => $desde,
                'hasta'                 => $hasta,
                'nombre_pdf'            => $nombre_pdf,
                'dir_archivo_externo'   => $dir_archivo_externo,
                'user_id'               => $user_id,
                'status_id'             => $status_id,
                'key_id'                => $key_id,
                'file'                  => $file,

            )
        );
*/



        
         //$nint = 1;
       

      $wpdb->insert(
            $tabla_aspirantes,
            array(
                'user_id'               => $user_id,
                'key_id'                => $key_id,
                'status_id'             => $status_id,
                'nint'                  => $nint,
                'date'                  => $date,
            )
        );



















    


    // Esta función de PHP activa el almacenamiento en búfer de salida (output buffer)
    // Cuando termine el formulario lo imprime con la función ob_get_clean
    ob_start();
    ?>


    <?php
    echo ' get_current_user_id() - > ' .get_current_user_id() .  '</br></br>';
    if ( (get_current_user_id() != NULL) OR (get_current_user_id() != 0) ) 
    {
        echo "Usuario activo </br>";
        echo "archivo : " . $upload_dir . "</br>";
        echo "archivo : " . get_current_user_id()  . "</br>";

        wpbc_ingreso_form();



    }
    else
    {
        echo "Usuario inactivo ";
    }



    ?>



    


    <?php
     
    // Devuelve el contenido del buffer de salida
    return ob_get_clean();
}
/*Fin funcion para crear shotcode en la pagina de inicio */



?>