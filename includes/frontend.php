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
        $nombres = sanitize_text_field($_POST['nombres']);
        $apellido_paterno = sanitize_text_field($_POST['apellido_paterno']);
        $apellido_materno = sanitize_text_field($_POST['apellido_materno']);
        $rut = sanitize_text_field($_POST['rut']);
        $email = sanitize_text_field($_POST['email']);
        $perm_admin = sanitize_text_field($_POST['perm_admin']);
        $fdo_legal = sanitize_text_field($_POST['fdo_legal']);
        $perm_parent = sanitize_text_field($_POST['perm_parent']);
        $dias = sanitize_text_field($_POST['dias']);
        $desde = sanitize_text_field($_POST['desde']);
        $hasta = sanitize_text_field($_POST['hasta ']);
        $nombre_pdf = sanitize_text_field($_POST['nombre_pdf']);
        $dir_archivo_externo = sanitize_text_field($_POST['dir_archivo_externo']);
        $user_id = sanitize_text_field($_POST['user_id']);
        $status_id = sanitize_text_field($_POST['status_id']);
        $key_id = sanitize_text_field($_POST['key_id']);
        // $file = sanitize_text_field($_POST['file']);

        /*para subir archivos*/
        $filename = sanitize_text_field($_FILES["image"]["name"]);
        $deprecated = null;
        $bits = file_get_contents($_FILES["image"]["tmp_name"]);
        $time = current_time('mysql');
        $file = wp_upload_bits($filename, $deprecated, $bits, $time);
        /*Para subir archivos*/
        


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
                'status_id'             => $status_id,
                'key_id'                => $key_id,
                'file'                  => $file,

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
<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="nombres"><?php _e('Nombres :', 'wpbc')?></label>
            <br>
            <input id="nombres" name="nombres" type="text" required>
        </p>

        <p>
            <label for="apellido_paterno"><?php _e('Apellido Paterno :', 'wpbc')?></label>
            <br>
            <input id="apellido_paterno" name="apellido_paterno" type="text" required>
        </p>

        <p>
            <label for="apellido_materno"><?php _e('Apellido Materno :', 'wpbc')?></label>
            <br>
            <input id="apellido_materno" name="apellido_materno" type="text" required>
        </p>        

        </div>
<!-- --------------------------------------------------------------------------------------------------------------- -->    
<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="rut"><?php _e('Rut :', 'wpbc')?></label>
            <br>
            <input id="rut" name="rut" type="text" required>
        </p>

        <p>
            <label for="email"><?php _e('email :', 'wpbc')?></label>
            <br>
            <input id="email" name="email" type="text" required>
        </p>
             
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="perm_admin"><?php _e('Permiso Administrativo :', 'wpbc')?></label>
            <br>
            <input id="perm_admin" name="rut" type="perm_admin" required>
        </p>
             
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="fdo_legal"><?php _e('Feriado Legal :', 'wpbc')?></label>
            <br>
            <input id="fdo_legal" name="fdo_legal" type="fdo_legal" required>
        </p>
             
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="perm_parent"><?php _e('Permiso parental :', 'wpbc')?></label>
            <br>
            <input id="perm_parent" name="perm_parent" type="perm_parent" required>
        </p>
             
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 


<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="dias"><?php _e('Dias :', 'wpbc')?></label>
            <br>
            <input id="dias" name="dias" type="dias" required>
        </p>

        <p>
            <label for="desde"><?php _e('Desde :', 'wpbc')?></label>
            <br>
            <input id="desde" name="desde" type="desde" required>
        </p>

        <p>
            <label for="hasta"><?php _e('Hasta :', 'wpbc')?></label>
            <br>
            <input id="hasta" name="hasta" type="hasta" required>
        </p>

        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="nombre_pdf"><?php _e('Nombre PDF :', 'wpbc')?></label>
            <br>
            <input id="nombre_pdf" name="nombre_pdf" type="nombre_pdf" required>
        </p>




        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="dir_archivo_externo"><?php _e('Direccion archivo :', 'wpbc')?></label>
            <br>
            <input id="dir_archivo_externo" name="dir_archivo_externo" type="dir_archivo_externo" required>
        </p>
        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 


<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="file"><?php _e('archivo :', 'wpbc')?></label>
            <br>
            <input id="file" name="file" type="file" required>
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