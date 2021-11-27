<?php

/*Inicio crear shortcode en la pagina de inicio */
add_shortcode('kfp_aspirante_form', 'Kfp_Aspirante_form');
/*Fin crear shortcode enla pagina de inicio*/ 

/*Inicio funcion para crear shortcode en la pagina de inicio */


function Kfp_Aspirante_form() 
{

global $wpdb; // Este objeto global permite acceder a la base de datos de WP
    // Si viene del formulario  graba en la base de datos

        
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

        rename($upload['file'] , $user_dirname.time().'_'.$_FILES['wp_custom_attachment']['name']);  

        $file = date('Y').'/'.date('m').'/'.date('d').'/'.time().'_'.$_FILES['wp_custom_attachment']['name']; 

        /* Fin subir archivo */     

        /*
        $thefile = $upload['file'];
        $upload_dir = wp_upload_dir();
        $newfolder = $user_dirname;
        move_uploaded_file($thefile, $newfolder);
        */

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

    


    // Esta función de PHP activa el almacenamiento en búfer de salida (output buffer)
    // Cuando termine el formulario lo imprime con la función ob_get_clean
    ob_start();
    ?>

    <form action="<?php get_the_permalink(); ?>" method="post" id="form_aspirante" class="cuestionario" enctype="multipart/form-data">
        <?php wp_nonce_field('graba_aspirante', 'aspirante_nonce'); ?>
<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
            <label ><?php echo '$_FILES : '. $_FILES['wp_custom_attachment']['name'] ?></label></br>
            <label ><?php echo '$_FILES : '. $_FILES['wp_custom_attachment']['tmp_name'] ?></label></br>
            <label ><?php echo date('l jS \of F Y h:i:s A'); ?></label></br>
            <label ><?php echo date('Y_m_d'); ?></label></br>
            <label ><?php echo $doc_dir; ?></label></br>
            
            <?php 
                
                $ruta = $upload_dir['basedir'];
                $ruta = $ruta . '/proyecto';

                echo 'ruta ->' . $ruta . '<br />';
                echo 'path ->' . $upload_dir['path'] . '/'.date('d').'<br />';
                echo 'url ->' . $upload_dir['url'] . '<br />';
                echo 'subdir ->' . $upload_dir['subdir'] . '<br />';
                echo 'basedir ->' . $upload_dir['basedir'] . '<br />';
                echo 'baseurl ->' . $upload_dir['baseurl'] . '<br />';
                echo 'upload ->' . $upload_dir['upload'] . '<br />';
                echo 'upload2 ->' . $upload . '<br />';
                echo 'upload3 ->' . $upload['wp_custom_attachment']['name']. '<br />';
                echo 'upload4 ->' . $upload['file']. '<br />';
                echo 'upload5 ->' . date('Y').'/'.date('m').'/'.date('d').'/'.time().'_'.$_FILES['wp_custom_attachment']['name']. '<br />';

            ?> 
            <br> 
        <p> 

            <input id="user_id" name="user_id" type="hidden" value="<?php echo get_current_user_id(); ?>">
            <input id="user_name" name="user_name" type="hidden" value="<?php echo get_current_user(); ?>">
            <input id="key_id" name="key_id" type="hidden" value="<?php echo time().'_'.wp_generate_password( 3, false ); ?>">
            <input id="status_id" name="status_id" type="hidden" value="1">
            
        </p>
        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>

        <p>         
            <label for="nint"><?php _e('N° INT:', 'wpbc')?></label>
            <br>    
            <input id="nint" name="nint" type="text">
        </p>

        <p>

            <label for="date"><?php _e('Fecha:', 'wpbc')?></label>
            <br>
            <input id="date" name="date" type="text">
            <br>
        </p>
        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- -->    

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
        <p>
            <label for="depto_unid"><?php _e('Departamento / Unidad :', 'wpbc')?></label>
            <br>
            <input id="depto_unid" name="depto_unid" type="text">
        </p>
        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- -->    
<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
        <p>
            <label for="nombres"><?php _e('Nombres :', 'wpbc')?></label>
            <br>
            <input id="nombres" name="nombres" type="text" >
        </p>

        <p>
            <label for="apellido_paterno"><?php _e('Apellido Paterno :', 'wpbc')?></label>
            <br>
            <input id="apellido_paterno" name="apellido_paterno" type="text" >
        </p>

        <p>
            <label for="apellido_materno"><?php _e('Apellido Materno :', 'wpbc')?></label>
            <br>
            <input id="apellido_materno" name="apellido_materno" type="text" >
        </p>        

        </div>
<!-- --------------------------------------------------------------------------------------------------------------- -->    
<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
        <p>
            <label for="rut"><?php _e('Rut :', 'wpbc')?></label>
            <br>
            <input id="rut" name="rut" type="text" >
        </p>

        <p>
            <label for="email"><?php _e('email :', 'wpbc')?></label>
            <br>
            <input id="email" name="email" type="text" >
        </p>
             
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
        <p>
            <label for="perm_admin"><?php _e('Permiso Administrativo :', 'wpbc')?></label>
            <br>
            <input id="perm_admin" name="perm_admin" type="perm_admin">
        </p>
             
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
        <p>
            <label for="fdo_legal"><?php _e('Feriado Legal :', 'wpbc')?></label>
            <br>
            <input id="fdo_legal" name="fdo_legal" type="fdo_legal">
        </p>
             
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
        <p>
            <label for="perm_parent"><?php _e('Permiso parental :', 'wpbc')?></label>
            <br>
            <input id="perm_parent" name="perm_parent" type="perm_parent">
        </p>
             
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 


<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
        <p>
            <label for="dias"><?php _e('Dias :', 'wpbc')?></label>
            <br>
            <input id="dias" name="dias" type="dias">
        </p>

        <p>
            <label for="desde"><?php _e('Desde :', 'wpbc')?></label>
            <br>
            <input id="desde" name="desde" type="desde">
        </p>

        <p>
            <label for="hasta"><?php _e('Hasta :', 'wpbc')?></label>
            <br>
            <input id="hasta" name="hasta" type="hasta">
        </p>

        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
        <p>
            <label for="nombre_pdf"><?php _e('Nombre PDF :', 'wpbc')?></label>
            <br>
            <input id="nombre_pdf" name="nombre_pdf" type="nombre_pdf">
        </p>




        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
        <p>
            <label for="dir_archivo_externo"><?php _e('Direccion archivo :', 'wpbc')?></label>
            <br>
            <input id="dir_archivo_externo" name="dir_archivo_externo" type="dir_archivo_externo">
        </p>
        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 


<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p>
            <label for="file"><?php _e('archivo :', 'wpbc')?></label>
            <br>
            
            <input type="file" name="wp_custom_attachment"id="wp_custom_attachment" size="50" />
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