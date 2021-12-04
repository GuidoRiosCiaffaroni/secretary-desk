<?php


function wpbc_ingreso_form()
{


        global $user_id;
        global $key_id;
        global $status_id;
        global $nint;
        /*
        global $date;
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


    echo '<form action="'. get_the_permalink() .'" method="post" id="form_aspirante" class="cuestionario" enctype="multipart/form-data">';
        wp_nonce_field('graba_aspirante', 'aspirante_nonce');


/* ***************************************************************************************************************************************************** */
    echo '<div>';   
    echo '  <label >$_FILES : '. $_FILES['wp_custom_attachment']['name'] .'</label></br>';
    echo '  <label >$_FILES : '. $_FILES['wp_custom_attachment']['tmp_name'] .'</label></br>';
    echo '  <label >' . date('l jS \of F Y h:i:s A') .'</label></br>';
    echo '  <label >' . date('Y_m_d') .'</label></br>';
    echo '  <label >'. $doc_dir .'</label></br>';
                      
    $ruta = $upload_dir['basedir'];
    $ruta = $ruta . '/proyecto';

    echo 'ruta      ->' . $ruta                                     . '<br />';
    echo 'path      ->' . $upload_dir['path']                       . '/'.date('d').'<br />';
    echo 'url       ->' . $upload_dir['url']                        . '<br />';
    echo 'subdir    ->' . $upload_dir['subdir']                     . '<br />';
    echo 'basedir   ->' . $upload_dir['basedir']                    . '<br />';
    echo 'baseurl   ->' . $upload_dir['baseurl']                    . '<br />';
    echo 'upload    ->' . $upload_dir['upload']                     . '<br />';
    echo 'upload2   ->' . $upload                                   . '<br />';
    echo 'upload3   ->' . $upload['wp_custom_attachment']['name']   . '<br />';
    echo 'upload4   ->' . $upload['file']                           . '<br />';
    echo 'upload5   ->' . date('Y').'/'.date('m').'/'.date('d').'/'.time().'_'.$_FILES['wp_custom_attachment']['name']. '<br />';


    echo '-->' . $user_id . '</br>';
    echo '-->' . $key_id . '</br>';
    echo '-->' . $status_id . '</br>';
    echo '-->' . $nint . '</br>';
    echo '-->' . $date . '</br>';


    echo '</br>'; 
    echo '<p>'; 
    echo '<input id="user_id" name="user_id" type="hidden" value="' . get_current_user_id() .'">';
    echo '<input id="user_name" name="user_name" type="hidden" value="' . get_current_user() .'">';
    echo '<input id="key_id" name="key_id" type="hidden" value="' . time().'_'.wp_generate_password( 3, false ). '">';
    echo '<input id="status_id" name="status_id" type="hidden" value="1">';
    echo '</p>';
    echo '</div>';
/* ***************************************************************************************************************************************************** */                
/* ***************************************************************************************************************************************************** */
echo '
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
';   







echo '
        <div class="container d-flex justify-content-center">
            <div class=\'col-md-5\'>
                <div class="form-floating mb-3">
                    <div>
                    <p>
                        <label for="floatingInput">' . _e('N° INT:', 'wpbc') . '</label>' .'
                        </br>    
                        <input id="nint" name="nint" type="text" class="form-control" placeholder="xx-xx-xx-xx-xx" >
                    </p>
                    </div>
                </div>
            </div>
        </div>
';


echo '
        <div class="container d-flex justify-content-center">
            <div class=\'col-md-5\'>
                <div class="form-group">
                    <div class=\'input-group date\' id=\'datetimepicker7\'> 
                        <input type=\'text\' class="form-control" /> 
                            <span class="input-group-addon"> 
                            <span class="glyphicon glyphicon-calendar">
                            </span> 
                        </span> 
                    </div>
                </div>
            </div>
        </div>
';




/* ***************************************************************************************************************************************************** */


/* ***************************************************************************************************************************************************** */

    echo '         <div class="form-input">';
    echo '              <input type="submit" value="Enviar">';
    echo '          </div>';
    echo '      </form>';

/* ***************************************************************************************************************************************************** */





echo '
        <script type=\'text/javascript\' src=\'https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js\'></script>
        <script type=\'text/javascript\' src=\'\'></script>
        <script type=\'text/javascript\' src=\'\'></script>
        <script type=\'text/Javascript\'>
        $(document).ready(function() 
        {
            $(function() 
            {
                $(\'#datetimepicker6\').datetimepicker();
                $(\'#datetimepicker7\').datetimepicker(
                {
                    useCurrent: false //Important! See issue #1075
                });
                $("#datetimepicker6").on("dp.change", function(e) 
                {
                    $(\'#datetimepicker7\').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepicker7").on("dp.change", function(e) 
                {
                    $(\'#datetimepicker6\').data("DateTimePicker").maxDate(e.date);
                });
            });
        });
        </script>

';



}

?>