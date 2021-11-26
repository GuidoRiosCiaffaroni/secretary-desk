<?php



function wpbc_contacts_page_handler()
{
    global $wpdb;

    $table = new Custom_Table_Example_List_Table();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p> Registro Eliminado</p></div>';
    }

?>

<!-- Inicio Pagina Pricipal -->
<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2>
        <?php _e('Registro', 'wpbc')?> 
        <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=registro_form');?>">
            <?php _e('Nuevo Registro', 'wpbc')?> 
        </a>
    </h2>
    
    <?php echo $message; ?>

    <form id="contacts-table" method="POST">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
        <?php $table->display() ?>
    </form>

</div>


<?php
}


function wpbc_contacts_form_page_handler()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'secretarydesk'; 

    $message = '';
    $notice = '';

    /*Inicio Array Informacion para manejar CRUD */
    $default = array(
        'id'                    => 0,
        'nint'                  => '',
        'date'                  => '',
        'depto_unid'            => '',
        'nombres'               => '',
        'apellido_paterno'      => '',
        'apellido_materno'      => '',
        'rut'                   => '',
        'email'                 => '',
        'perm_admin'            => '',
        'fdo_legal'             => '',
        'perm_parent'           => '',
        'dias'                  => '',
        'desde'                 => '',
        'hasta'                 => '',
        'nombre_pdf'            => '',
        'dir_archivo_externo'   => '',
        'user_id'               => '',
        'user_name'             => '',
        'status_id'             => '',
        'key_id'                => '',


    );
    /*Fin Array Informacion para manejar CRUD */


    if ( isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) 
    {    
        $item = shortcode_atts($default, $_REQUEST);     
        $item_valid = wpbc_validate_contact($item);
        
        if ($item_valid === true) 
        {

            if ($item['id'] == 0) 
            {
                /* Objeto ingreso de informacion en la tabla*/
                $result = $wpdb->insert($table_name, $item);
                $item['id'] = $wpdb->insert_id;
                
                if ($result) 
                {
                    $message = __('Es registro fue ingresado satisfactoriamente', 'wpbc');
                } 
                else 
                {
                    $notice = __('There was an error while saving item', 'wpbc');
                }

            } 

            else 
            {
                /* Objeto actualizacion de informacion en la tabla*/
                
                $result = $wpdb->update($table_name, $item, array('id' => $item['id']));
                if ($result) 
                {
                    $message = __('Item was successfully updated', 'wpbc');
                } 
                else 
                {
                    $notice = __('There was an error while updating item', 'wpbc');
                }
                

                


            }
        } 
        else 
        {
            
            $notice = $item_valid;
        }
    }
    else 
    {
        $item = $default;
        if (isset($_REQUEST['id'])) 
        {
            /* */
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
            if (!$item) 
            {
                $item = $default;
                $notice = __('Item not found', 'wpbc');
            }
        }
    }
    
    add_meta_box(
        'contacts_form_meta_box', 
        __('Registro Data', 'wpbc'), 
        'wpbc_contacts_form_meta_box_handler', 
        'contact', 
        'normal', 
        'default'
    );

    ?>




<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2>
        <?php _e('Registro', 'wpbc')?> 
        <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=registros');?>">
            <?php _e('Regresar a la lista', 'wpbc')?>
            </a>
    </h2>

    <?php 
    if (!empty($notice)): 
    ?>
    
    <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    
    <?php 
    endif;
     
    if (!empty($message)): 
    ?>
    
    <div id="message" class="updated"><p><?php echo $message ?></p></div>
    
    <?php endif;?>

    <form id="form" method="POST">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
        
        <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>

        <div class="metabox-holder" id="poststuff">
            <div id="post-body">
                <div id="post-body-content">
                    
                    <?php do_meta_boxes('contact', 'normal', $item); ?>
                    <input type="submit" value="<?php _e('Ingresar', 'wpbc')?>" id="submit" class="button-primary" name="submit">
                </div>
            </div>
        </div>
    </form>

</div>
<?php
}

function wpbc_contacts_form_meta_box_handler($item)
{

    /* Inicio Generador de Fecha y hora */
    function local_date_i18n($format, $timestamp) {
        $timezone_str = get_option('timezone_string') ?: 'UTC';
        $timezone = new \DateTimeZone($timezone_str);

        // The date in the local timezone.
        $date = new \DateTime(null, $timezone);
        $date->setTimestamp($timestamp);
        $date_str = $date->format('Y-m-d H:i:s');

        // Pretend the local date is UTC to get the timestamp
        // to pass to date_i18n().
        $utc_timezone = new \DateTimeZone('UTC');
        $utc_date = new \DateTime($date_str, $utc_timezone);
        $timestamp = $utc_date->getTimestamp();

        return date_i18n($format, $timestamp, true);
    }
    /* Fin Generador de Fecha y hora */

    /*
    $format = 'F d, Y H:i';
    $timestamp = 1365186960;
    $local = local_date_i18n($format, $timestamp);
    $gmt = date_i18n($format, $timestamp);
    echo "Local: ", $local, " UTC: ", $gmt;
    echo '</br>';
    echo "Local: ", time();
    */



    //echo wp_generate_password();                 // @iU!ZnjUWZsg
    //echo wp_generate_password( 15, false );      // YdD6j750MeiOkPa
    //echo wp_generate_password( 15, true, true ); // .WfvgX6`V^Vg:,_

    ?>



<tbody >
		
	<div class="formdatabc">		
		
    <form >

<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div>
        <p>  
            <!--       
            <label for="user_id"><?php echo get_current_user_id(); ?></label>
            <br>
            <label for="user_name"><?php echo get_current_user(); ?></label>
            <br>
            <label for="key_id"><?php echo time().'_'.wp_generate_password( 3, false ); ?></label>
            <br>
            <label for="status_id"><?php echo '1' ?></label>
            -->

            <br>
            <input id="user_id" name="user_id" type="hidden" value="<?php echo get_current_user_id(); ?>">
            <input id="user_name" name="user_name" type="hidden" value="<?php echo get_current_user(); ?>">
            <input id="key_id" name="key_id" type="hidden" value="<?php echo time().'_'.wp_generate_password( 3, false ); ?>">
            <input id="status_id" name="status_id" type="hidden" value="1">
            
            <!-- <input id="nint" name="nint" type="text" value="<?php echo esc_attr($item['nint'])?>" required> -->
        </p>
        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- --> 


<!-- --------------------------------------------------------------------------------------------------------------- -->		
        <div class="form2bc">
        <p>         
            <label for="nint"><?php _e('N° INT:', 'wpbc')?></label>
            <br>    
            <input id="nint" name="nint" type="text" value="<?php echo esc_attr($item['nint'])?>" required>
        </p>

        <p>


        
            <label for="date"><?php _e('Fecha:', 'wpbc')?></label>
        <br>
            <input id="date" name="date" type="text" value="<?php echo esc_attr($item['date'])?>"
                    required>
        </p>
        
        </div>
<!-- --------------------------------------------------------------------------------------------------------------- -->    

<!-- --------------------------------------------------------------------------------------------------------------- --> 

        <div>   
        <p>
            <label for="depto_unid"><?php _e('Departamento / Unidad :', 'wpbc')?></label>
            <br>	
            <input id="depto_unid" name="depto_unid" type="text" size="106" value="<?php echo esc_attr($item['depto_unid'])?>" required>
		</p>
        
        </div>

<!-- --------------------------------------------------------------------------------------------------------------- --> 
        



<!-- --------------------------------------------------------------------------------------------------------------- --> 

		<div class="form3bc">
		<p>
            <label for="nombres"><?php _e('Nombre:', 'wpbc')?></label> 
		    <br>	
            <input id="nombres" name="nombres" type="text" value="<?php echo esc_attr($item['nombres'])?>" required>
        </p>
        <p>	  
            <label for="apellido_paterno"><?php _e('Apellido Paterno:', 'wpbc')?></label> 
		    <br>
			<input id="apellido_paterno" name="apellido_paterno" type="text" value="<?php echo esc_attr($item['apellido_paterno'])?>">
		</p>

        <p>   
            <label for="apellido_materno"><?php _e('Apellido Materno:', 'wpbc')?></label> 
            <br>
            <input id="apellido_materno" name="apellido_materno" type="text" value="<?php echo esc_attr($item['apellido_materno'])?>">
        </p>

		</div>
        
<!-- --------------------------------------------------------------------------------------------------------------- -->         


<!-- --------------------------------------------------------------------------------------------------------------- --> 

        <div class="form2bc">
        <p>
            <label for="rut"><?php _e('Rut:', 'wpbc')?></label> 
            <br>    
            <input id="rut" name="rut" type="text" value="<?php echo esc_attr($item['rut'])?>" required>
        </p>
        <p>   
            <label for="email"><?php _e('E-mail:', 'wpbc')?></label> 
            <br>
            <input id="email" name="email" type="text" value="<?php echo esc_attr($item['email'])?>">
        </p>

        </div>
        
<!-- --------------------------------------------------------------------------------------------------------------- -->  


<!-- --------------------------------------------------------------------------------------------------------------- --> 

        <div>   
        <p>
            <label for="perm_admin"><?php _e('Permiso administrativo :', 'wpbc')?></label>
            <br>    
            <input id="perm_admin" name="perm_admin" type="text" size="106" value="<?php echo esc_attr($item['perm_admin'])?>" required>
        </p>
        
        </div>

<!-- --------------------------------------------------------------------------------------------------------------- --> 
      

<!-- --------------------------------------------------------------------------------------------------------------- --> 

        <div>   
        <p>
            <label for="fdo_legal"><?php _e('Feriado legal :', 'wpbc')?></label>
            <br>    
            <input id="fdo_legal" name="fdo_legal" type="text" size="106" value="<?php echo esc_attr($item['fdo_legal'])?>" required>
        </p>
        
        </div>

<!-- --------------------------------------------------------------------------------------------------------------- --> 
      

<!-- --------------------------------------------------------------------------------------------------------------- --> 

        <div>   
        <p>
            <label for="perm_parent"><?php _e('Permiso Parental :', 'wpbc')?></label>
            <br>    
            <input id="perm_parent" name="perm_parent" type="text" size="106" value="<?php echo esc_attr($item['perm_parent'])?>" required>
        </p>
        
        </div>

<!-- --------------------------------------------------------------------------------------------------------------- --> 
      


<!-- --------------------------------------------------------------------------------------------------------------- --> 

        <div class="form3bc">
        <p>
            <label for="dias"><?php _e('Dias:', 'wpbc')?></label> 
            <br>    
            <input id="dias" name="dias" type="text" value="<?php echo esc_attr($item['dias'])?>" required>
        </p>
        <p>   
            <label for="desde"><?php _e('Desde:', 'wpbc')?></label> 
            <br>
            <input id="desde" name="desde" type="text" value="<?php echo esc_attr($item['desde'])?>">
        </p>

        <p>   
            <label for="hasta"><?php _e('Hasta:', 'wpbc')?></label> 
            <br>
            <input id="hasta" name="hasta" type="text" value="<?php echo esc_attr($item['hasta'])?>">
        </p>

        </div>
        
<!-- --------------------------------------------------------------------------------------------------------------- -->         


<!-- --------------------------------------------------------------------------------------------------------------- --> 

        <div>   
        <p>
            <label for="nombre_pdf"><?php _e('Nombre PDF :', 'wpbc')?></label>
            <br>    
            <input id="nombre_pdf" name="nombre_pdf" type="text" size="106" value="<?php echo esc_attr($item['nombre_pdf'])?>" required>
        </p>
        
        </div>

<!-- --------------------------------------------------------------------------------------------------------------- --> 
      
<!-- --------------------------------------------------------------------------------------------------------------- --> 

        <div>   
        <p>
            <label for="dir_archivo_externo"><?php _e('Direccion archivo PDF :', 'wpbc')?></label>
            <br>    
            <input id="dir_archivo_externo" name="dir_archivo_externo" type="text" size="106" value="<?php echo esc_attr($item['dir_archivo_externo'])?>" required>
        </p>
        
        </div>

<!-- --------------------------------------------------------------------------------------------------------------- --> 
      
      

		</form>





		</div>
</tbody>








<?php
}





















