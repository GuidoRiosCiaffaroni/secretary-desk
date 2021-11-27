<?php
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
        status_id int(11) NOT NULL,
        key_id VARCHAR (50) NOT NULL,
        file VARCHAR (100) NOT NULL,
        create_at datetime NOT NULL DEFAULT NOW(),
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
            status_id int(11) NOT NULL,
            key_id VARCHAR (50) NOT NULL,
            file VARCHAR (100) NOT NULL,
            create_at datetime NOT NULL DEFAULT NOW(),
            PRIMARY KEY  (id)
        );";        


        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        update_option('wpbc_db_version', $wpbc_db_version);
    }
}

?>