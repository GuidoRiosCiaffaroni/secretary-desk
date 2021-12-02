<?php
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



?>