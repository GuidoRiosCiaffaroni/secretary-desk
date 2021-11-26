<?php
/**
* Plugin Name: WP SecretaryDesk
* Description: Wixan SecretaryDesk
* Version:     2.1.3
* Plugin URI: https://guidorios.cl/wp-basic-crud-plugin-wordpress/
* Author:      Guido Rios Ciaffaroni
* Author URI:  https://guidorios.cl/
* License:     GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: wpbc
* Domain Path: /languages
*/

defined( 'ABSPATH' ) or die( '¡Sin trampas!' );

require plugin_dir_path( __FILE__ ) . 'includes/metabox-p1.php';

/*Importa funciones de instalacion*/
require_once plugin_dir_path( __FILE__ ) . 'includes/install.php';;



function wpbc_custom_admin_styles() {
    // Carga esta hoja de estilo para poner más bonito el formulario interno
    wp_enqueue_style('custom-styles', plugins_url('/css/styles.css', __FILE__ ));
	}

// Carga esta hoja de estilo para poner más bonito el formulario externo
wp_enqueue_style('css_aspirante', plugins_url('/css/styles.css', __FILE__));


add_action('admin_enqueue_scripts', 'wpbc_custom_admin_styles');

// traduce la pagina a otro idioma 
/*
function wpbc_plugin_load_textdomain() {
load_plugin_textdomain( 'wpbc', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}


add_action( 'plugins_loaded', 'wpbc_plugin_load_textdomain' );
*/

global $wpbc_db_version;
$wpbc_db_version = '1.1.0'; 

global $sistname;
$sistname = 'secretarydesk'; 

/*funciones de instalacion require_once plugin_dir_path( __FILE__ ) . 'includes/install.php'; */
wpbc_install();


/*
function wpbc_install()
{
    global $wpdb;
    global $wpbc_db_version;

    $table_name = $wpdb->prefix . 'secretarydesk'; 
 
    $sql = "CREATE TABLE " . $table_name . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        nint VARCHAR (50) NOT NULL, 
        date VARCHAR (100) NOT NULL,
        depto_unid VARCHAR (100) NOT NULL,
        nombres VARCHAR (100) NOT NULL,
        apellido_paterno VARCHAR (100) NOT NULL,
        apellido_materno VARCHAR (100) NOT NULL,
        rut VARCHAR (100) NOT NULL,
        email VARCHAR (100) NOT NULL,
        perm_admin VARCHAR (100) NOT NULL,
        fdo_legal VARCHAR (100) NOT NULL,
        perm_parent VARCHAR (100) NOT NULL,
        dias VARCHAR (100) NOT NULL,
        desde VARCHAR (100) NOT NULL,
        hasta VARCHAR (100) NOT NULL,
        nombre_pdf VARCHAR (100) NOT NULL,
        dir_archivo_externo VARCHAR (100) NOT NULL,
        user_id int(11) NOT NULL,
        user_name VARCHAR (100) NOT NULL,
        status_id int(11) NOT NULL,
        key_id VARCHAR (50) NOT NULL,
        PRIMARY KEY  (id)
    );";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('wpbc_db_version', $wpbc_db_version);

    $installed_ver = get_option('wpbc_db_version');
    if ($installed_ver != $wpbc_db_version) {
        $sql = "CREATE TABLE " . $table_name . " (
            id int(11) NOT NULL AUTO_INCREMENT,
            nint VARCHAR (50) NOT NULL, 
            date VARCHAR (100) NOT NULL,
            depto_unid VARCHAR (100) NOT NULL,
            nombres VARCHAR (100) NOT NULL,
            apellido_paterno VARCHAR (100) NOT NULL,
            apellido_materno VARCHAR (100) NOT NULL,
            rut VARCHAR (100) NOT NULL,
            email VARCHAR (100) NOT NULL,
            perm_admin VARCHAR (100) NOT NULL,
            fdo_legal VARCHAR (100) NOT NULL,
            perm_parent VARCHAR (100) NOT NULL,
            dias VARCHAR (100) NOT NULL,
            desde VARCHAR (100) NOT NULL,
            hasta VARCHAR (100) NOT NULL,
            nombre_pdf VARCHAR (100) NOT NULL,
            dir_archivo_externo VARCHAR (100) NOT NULL,
            user_id int(11) NOT NULL,
            user_name VARCHAR (100) NOT NULL,
            status_id int(11) NOT NULL,
            key_id VARCHAR (50) NOT NULL,
            PRIMARY KEY  (id)
        );";        


        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        update_option('wpbc_db_version', $wpbc_db_version);
    }
}
*/

register_activation_hook(__FILE__, 'wpbc_install');


function wpbc_install_data()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'secretarydesk'; 

}


register_activation_hook(__FILE__, 'wpbc_install_data');


function wpbc_update_db_check()
{
    global $wpbc_db_version;
    if (get_site_option('wpbc_db_version') != $wpbc_db_version) {
        wpbc_install();
    }
}

add_action('plugins_loaded', 'wpbc_update_db_check');



if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}


/* Inicio clase tabla*/
class Custom_Table_Example_List_Table extends WP_List_Table
{
    /* Inicio Funcion constructor*/ 
    function __construct()
        {
            global $status, $page;

            parent::__construct(array(
                'singular' => 'registro',
                'plural'   => 'registros',
            ));
        }
    /*Fin inicio construcctor*/

    /*Inicio datos columna predeterminado*/
    function column_default($item, $column_name)
        {
            return $item[$column_name];
        }
    /*Fin datos columna predeterminado*/

    /*Inicio controles editar y borrar en la columna id*/
    function column_id($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=registro_form&id=%s">%s</a>', $item['id'], __('Editar', 'wpbc')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Borrar', 'wpbc'))
        );

        return sprintf('%s %s',
            $item['id'],
            $this->row_actions($actions)
        );
    }
    /*Fin controles editar y borrar en la columna id*/

    /*Inicio input en la columan cb*/
    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="id[]" value="%s" />', $item['id'] );
    }
    /*Fin input en la columan cb*/

    /*Inicio controles en la columna detalle*/
    function column_Detalle($item)
    {
        return sprintf('<a href="?page=%s&action=detail&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Detalle', 'wpbc'));
    }
    /*Fin controles en la columna detalle*/


    /*Inicio Muestra columnas */
    function get_columns()
    {
        $columns = array(
            'cb'                    => '<input type="checkbox" />',
            'id'                    => __('', 'wpbc'),
            'nint'                  => __('N° INT', 'wpbc'),
            'date'                  => __('Fecha', 'wpbc'),
            'depto_unid'            => __('Dep/Uni', 'wpbc'),
            'nombres'               => __('Nombre', 'wpbc'),
            'apellido_paterno'      => __('A Paterno', 'wpbc'),
            'apellido_materno'      => __('A Materno', 'wpbc'),
            'rut'                   => __('Rut', 'wpbc'),
            'Detalle'   => '<lavel>Detalle </label>',

        );
        return $columns;

    }
    /*Fin Muestra Columnas*/



    /* Inicio Ordenar Columnas*/
   function get_sortable_columns()
    {
        $sortable_columns = array(
            'nint'                  => array('N° INT', true),
            'date'                  => array('Fecha', true),
            'depto_unid'            => array('Departamento/Unidad', true),
            'nombres'               => array('Nombre', true),
            'apellido_paterno'      => array('Apellido Paterno', true),
            'apellido_materno'      => array('Apellido Materno', true),
            'rut'                   => array('Rut', true),
            'email'                 => array('E-Mail', true),
            'perm_admin'            => array('Permiso Administrativo', true),
            'fdo_legal'             => array('Feriado Legal', true),
            'perm_parent'           => array('Permiso Parental', true),
            'dias'                  => array('Dias', true),
            'desde'                 => array('Desde', true),
            'hasta'                 => array('Hasta', true),
            'nombre_pdf'            => array('Nombre PDF', true),
            'dir_archivo_externo'   => array('Archivo', true),

        );
        return $sortable_columns;
    }
    /*Fin Ordenar Columnas*/

    /*Inicio Funcion para borrar por lotes*/    
    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Borrar'
        );
        return $actions;
    }

    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'secretarydesk'; 

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }
    /*Fin Funcion para borrar por lotes*/

    /*Inicio Funcion para paginacion de tabla interior */
    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'secretarydesk'; 

        $per_page = 10; 

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
       
        $this->process_bulk_action();

        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");


        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        

        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';

        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';


        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);



        $this->set_pagination_args(array(
            'total_items' => $total_items, 
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page) 
        ));
    }
    /*Fin Funcion para paginacion de tabla interior */

}

function wpbc_admin_menu()
{
    add_menu_page(
        __('Registro', 'wpbc'), 
        __('Registro', 'wpbc'), 
        'activate_plugins', 
        'registros', 
        'wpbc_contacts_page_handler'
    );


    add_submenu_page(
        'Registro', 
        __('Registro', 'wpbc'), 
        __('Registro', 'wpbc'), 
        'activate_plugins', 
        'registros', 
        'wpbc_contacts_page_handler'
    );
   
    add_submenu_page(
        'Registro', 
        __('Nuevo', 'wpbc'), 
        __('Nuevo', 'wpbc'), 
        'activate_plugins', 
        'registro_form', 
        'wpbc_contacts_form_page_handler'
    );

}

add_action(
    'admin_menu', 
    'wpbc_admin_menu'
);



function wpbc_validate_contact($item)
{
    $messages = array();

/*
    if (empty($item['nint'])) $messages[] = __('Name is required', 'wpbc');


    if (empty($item['lastname'])) $messages[] = __('Last Name is required', 'wpbc');
    if (!empty($item['email']) && !is_email($item['email'])) $messages[] = __('E-Mail is in wrong format', 'wpbc');
    if(!empty($item['phone']) && !absint(intval($item['phone'])))  $messages[] = __('Phone can not be less than zero');
    if(!empty($item['phone']) && !preg_match('/[0-9]+/', $item['phone'])) $messages[] = __('Phone must be number');
    */

    if (empty($messages)) return true;
    return implode('<br />', $messages);
}


function wpbc_languages()
{
    load_plugin_textdomain('wpbc', false, dirname(plugin_basename(__FILE__)));
}


add_action('init', 'wpbc_languages');



/*Inicio crear shortcode en la pagina de inicio */
add_shortcode('kfp_aspirante_form', 'Kfp_Aspirante_form');
/*Fin crear shortcode enla pagina de inicio*/ 

/*Inicio funcion para crear shortcode en la pagina de inicio */
function Kfp_Aspirante_form() 
{

global $wpdb; // Este objeto global permite acceder a la base de datos de WP
    // Si viene del formulario  graba en la base de datos
    // Cuidado con el último igual de la condición del if que es doble

        
        
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

    echo "<p class='exito'><b>Tus datos han sido registrados</b>. Gracias por tu interés. En breve contactaré contigo.<p>";


    // Esta función de PHP activa el almacenamiento en búfer de salida (output buffer)
    // Cuando termine el formulario lo imprime con la función ob_get_clean
    ob_start();
    ?>

    <form action="<?php get_the_permalink(); ?>" method="post" id="form_aspirante" class="cuestionario">
        <?php wp_nonce_field('graba_aspirante', 'aspirante_nonce'); ?>
<!-- --------------------------------------------------------------------------------------------------------------- -->        
        <div class="form-input">
        <p> 
            <!--        
            <label for="user_id"><?php echo get_current_user_id(); ?></label>
            <br>
            <label for="user_name"><?php// echo get_current_user(); ?></label>
            <br>
            <label for="key_id"><?php echo time().'_'.wp_generate_password( 3, false ); ?></label>
            <br>
            <label for="status_id"><?php echo '1' ?></label>
            <br>
        -->
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






























