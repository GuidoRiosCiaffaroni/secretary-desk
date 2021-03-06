<?php
/**
* Plugin Name: WP SecretaryDesk
* Description: Wixan SecretaryDesk
* Version:     2.1.6
* Plugin URI: https://guidorios.cl/wp-basic-crud-plugin-wordpress/
* Author:      Guido Rios Ciaffaroni
* Author URI:  https://guidorios.cl/
* License:     GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: wpbc
* Domain Path: /languages
*/

defined( 'ABSPATH' ) or die( '¡Sin trampas!' );


/*Importa funciones admnistracion backend*/
require plugin_dir_path( __FILE__ ) . 'includes/backend.php';

/*Importa funciones administracion frontend*/
require_once plugin_dir_path( __FILE__ ) . 'includes/frontend_ingreso.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/frontend_ingreso_form.php';

require_once plugin_dir_path( __FILE__ ) . 'includes/frontend_buscar.php';


/*Importa funciones de instalacion*/
require_once plugin_dir_path( __FILE__ ) . 'includes/install.php';

/*Importa funciones de menu*/
require_once(ABSPATH . 'wp-content/plugins/secretary-desk/includes/backend_menu.php');

/*Funciones requeridas para subir archivos */
/* https://wordpress.stackexchange.com/questions/251236/upload-images-to-custom-database-table-in-admin-backend */
 require_once(ABSPATH . "wp-admin" . '/includes/image.php');
 require_once(ABSPATH . "wp-admin" . '/includes/file.php');
 require_once(ABSPATH . "wp-admin" . '/includes/media.php');




function wpbc_custom_admin_styles() {
    // Carga esta hoja de estilo para poner más bonito el formulario interno
    //wp_enqueue_style('custom-styles', plugins_url('/css/styles.css', __FILE__ ));

    }
add_action('admin_enqueue_scripts', 'wpbc_custom_admin_styles');
    // Carga esta hoja de estilo para poner más bonito el formulario externo
    //wp_enqueue_style('css_aspirante', plugins_url('/css/styles.css', __FILE__));


    // Carga esta hoja de estilo para poner más bonito el formulario externo
    wp_enqueue_style('css_aspirante', plugins_url('/assets/dist/css/bootstrap.min.css', __FILE__));


    wp_enqueue_style('css_aspirante', plugins_url('css/mdb.min.css', __FILE__));



    // Archivos adicionales para boostrap
    //https://kinsta.com/es/blog/wp-enqueue-scripts/
    /*
    function my_plugin_assets() 
    {
        wp_register_style( 'custom-gallery', plugins_url( '/css/gallery.css' , __FILE__ ) );
        wp_register_script( 'custom-gallery', plugins_url( '/js/gallery.js' , __FILE__ ) );

        wp_enqueue_style( 'custom-gallery' );
        wp_enqueue_script( 'custom-gallery' );
    }
    add_action( 'wp_enqueue_scripts', 'my_plugin_assets' );
    */


/*
    function my_plugin_assets() 
    {
        wp_register_style( 'bootstrap', plugins_url( 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' , __FILE__ ) );
  

        wp_register_script( 'jquery', plugins_url( 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js' , __FILE__ ) );
   
        wp_enqueue_style( 'bootstrap' );
  

        wp_enqueue_script( 'jquery' );


    }
    add_action( 'wp_enqueue_scripts', 'my_plugin_assets' );

*/






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

/* inicio funciones de instalacion require_once plugin_dir_path( __FILE__ ) . 'includes/install.php'; */
wpbc_install();


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
    if (get_site_option('wpbc_db_version') != $wpbc_db_version) 
    {
        wpbc_install();
    }
}

add_action('plugins_loaded', 'wpbc_update_db_check');



if (!class_exists('WP_List_Table')) 
{
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

/*Fin clase tabla*/








/*Fin funciones para validar datos tabla backend*/
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
/*Fin funciones para validar datos tabla backend*/


function wpbc_languages()
{
    load_plugin_textdomain('wpbc', false, dirname(plugin_basename(__FILE__)));
}


add_action('init', 'wpbc_languages');


?>

