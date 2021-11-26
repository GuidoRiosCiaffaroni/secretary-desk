<?php

/*Inicio crear shortcode en la pagina de inicio */
add_shortcode('kfp_aspirante_form', 'Kfp_Aspirante_form');
/*Fin crear shortcode enla pagina de inicio*/ 

/*Inicio funcion para crear shortcode en la pagina de inicio */
function Kfp_Aspirante_form() 
{

global $wpdb; // Este objeto global permite acceder a la base de datos de WP
    // Si viene del formulario  graba en la base de datos
    // Cuidado con el último igual de la condición del if que es doble

        
        if (get_current_user_id() != NULL) 
        {
        	//echo 'Usuario validado ';
        	$tabla_aspirantes = $wpdb->prefix . 'secretarydesk';
        	echo "<p class='exito'><b>Usuario validado</b>. Puede ingresar los datos.<p>"; 
    	}

        
        $tabla_aspirantes = $wpdb->prefix . 'secretarydesk'; 

        $user_id = sanitize_text_field($_POST['user_id']);
        $key_id = sanitize_text_field($_POST['key_id']);
        $status_id = sanitize_text_field($_POST['status_id']);
        $nint = sanitize_text_field($_POST['nint']);
        $date = sanitize_text_field($_POST['date']);
        $depto_unid = sanitize_text_field($_POST['depto_unid']);
        $nombres = sanitize_text_field($_POST['depto_unid']);
        $apellido_paterno = sanitize_text_field($_POST['depto_unid']);
        $apellido_materno = sanitize_text_field($_POST['depto_unid']);
        $rut = sanitize_text_field($_POST['depto_unid']);
        $email = sanitize_text_field($_POST['depto_unid']);
        $perm_admin = sanitize_text_field($_POST['depto_unid']);
        $fdo_legal = sanitize_text_field($_POST['depto_unid']);
        $perm_parent = sanitize_text_field($_POST['depto_unid']);
        $dias = sanitize_text_field($_POST['depto_unid']);
        $desde = sanitize_text_field($_POST['depto_unid']);
        $hasta = sanitize_text_field($_POST['depto_unid']);
        $nombre_pdf = sanitize_text_field($_POST['depto_unid']);
        $dir_archivo_externo = sanitize_text_field($_POST['depto_unid']);
        $user_id = sanitize_text_field($_POST['depto_unid']);
        $user_name = sanitize_text_field($_POST['depto_unid']);
        $status_id = sanitize_text_field($_POST['depto_unid']);
        $key_id = sanitize_text_field($_POST['depto_unid']);


       $wpdb->insert(
            $tabla_aspirantes,
            array(
                'user_id' => $user_id,
                'key_id' => $key_id,
                'status_id' => $status_id,
                'nint' => $nint,
                'date' => $date,
                'depto_unid' => $depto_unid,
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
                'user_name'             => $user_name,
                'status_id'             => $status_id,
                'key_id'                => $key_id,

            )
        );

    


    // Esta función de PHP activa el almacenamiento en búfer de salida (output buffer)
    // Cuando termine el formulario lo imprime con la función ob_get_clean
    ob_start();
    ?>

    <form action="<?php get_the_permalink(); ?>" method="post" id="form_aspirante" class="cuestionario">
        <?php wp_nonce_field('graba_aspirante', 'aspirante_nonce'); ?>
<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p> 

            <input id="user_id" name="user_id" type="hidden" value="<?php echo get_current_user_id(); ?>">
            <input id="user_name" name="user_name" type="hidden" value="<?php echo get_current_user(); ?>">
            <input id="key_id" name="key_id" type="hidden" value="<?php echo time().'_'.wp_generate_password( 3, false ); ?>">
            <input id="status_id" name="status_id" type="hidden" value="1">
            
        </p>
        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">

        <p>         
            <label for="nint"><?php _e('N° INT:', 'wpbc')?></label>
            <br>    
            <input id="nint" name="nint" type="text" required>
        </p>

        <p>

            <label for="date"><?php _e('Fecha:', 'wpbc')?></label>
            <br>
            <input id="date" name="date" type="text" required>
            <br>
        </p>
        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- -->    

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="depto_unid"><?php _e('Departamento / Unidad :', 'wpbc')?></label>
            <br>
            <input id="depto_unid" name="depto_unid" type="text" required>
        </p>
        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- -->    


        <div class="form-input">
            <input type="submit" value="Enviar">
        </div>
    </form>

    <?php
     
    // Devuelve el contenido del buffer de salida
    return ob_get_clean();
}
/*Fin funcion para crear shotcode en la pagina de inicio */



?>