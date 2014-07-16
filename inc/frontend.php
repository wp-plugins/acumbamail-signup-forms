<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('#submit_acumba').click(function(){
        var initialText=jQuery('#submit_acumba').prop('value');
        var datatosend={};
        jQuery("input[id*='acumba_']").each(function(index){
            if(jQuery(this).prop('type')=='checkbox'){
                if(jQuery(this).is(':checked')){
                    datatosend[jQuery(this).prop('name')] = true;
                }else{
                    datatosend[jQuery(this).prop('name')] = false;
                }
            }else{
                datatosend[jQuery(this).prop('name')]=jQuery(this).val();
            }
        });

        jQuery('#submit_acumba').prop('value',"Cargando...");

        datatosend['action']="send_acumbaform";
        console.log(JSON.stringify(datatosend));
        jQuery.ajax({type:"POST",url:ajaxurl, data:datatosend}).done(function(data) {
            console.log(data);
            if(data=="Te has suscrito correctamente."){
                jQuery('#acumba_info').css('color','green');
            } else {
                jQuery('#acumba_info').css('color','red');
            }
            jQuery('#acumba_info').html(data);
            jQuery('#submit_acumba').prop('value',initialText);
        });

    });
});


<?php
    echo "</script>";

    $widget_fields_get = get_option('acumba_widget_fields');
    $list = get_option('acumba_chosen_list');
    $ordered = get_option('acumba_ordered_fields');

    if($list != ''){
            $chosen_list=$list['acumba_chosen_list'];
            if (empty($title)) $title = "Suscríbete a nuestro newsletter";
            if (empty($button)) $button = "Suscríbete";

            if(get_option('theme_style')=='y'){
                echo $before_widget;
                echo $before_title . $title . $after_title;
                echo '<div style="padding:5px 5% 5% 5%;">';
                if ($subtitle) echo "<div id=\"acumba_info\" style=\"margin-button: 5px\">$subtitle</div>";
                echo '<form action="http://acumbamail.com/signup/'.$chosen_list.'/" method="POST">';

                foreach ($ordered as $key => $value) {
                    if($widget_fields_get[$value]['type']=="email" || $widget_fields_get[$value]['type']=="char"){
                        echo '<p style="margin:5px 0 0 0;"><input type="text" class="widefat" id="acumba_'.$widget_fields_get[$value]['name'].'" name="'.$widget_fields_get[$value]['name'].'" placeholder="'.$widget_fields_get[$value]['name_given'].'" style="width:100%"></p>';
                    } elseif ($widget_fields_get[$value]['type']=="boolean") {
                        echo '<p style="margin:5px 0 0 0;"><input type="checkbox" style=\"width: 100%\" id="acumba_'.$widget_fields_get[$value]['name'].'" name="'.$widget_fields_get[$value]['name'].'"> '.$widget_fields_get[$value]['name_given'].'</p>';
                    }/* elseif ($widget_fields_get[$widget_field]=="combobox") {

                    }*/
                }

                echo "<p style=\"margin:8px 0 0 0;\"><input type=\"button\" value=\"$button\" id=\"submit_acumba\" style=\"width: 100%\"></p>";
                echo $after_widget;
                echo "</form></div>";
            }else{
                echo '<section class="subscribe block"><div class="subscribe-pitch"><h3>'.$title.'</h3><p id="acumba_info">'.$subtitle.'<p></div><form action="http://acumbamail.com/signup/'.$chosen_list.'/" method="POST" class="subscribe-form">';
                    foreach ($ordered as $key => $value) {
                        if($widget_fields_get[$value]['type']=="email" || $widget_fields_get[$value]['type']=="char"){
                            echo '<input type="email" name="'.$widget_fields_get[$value]['name'].'" class="subscribe-input" placeholder="'.$widget_fields_get[$value]['name_given'].'" id="acumba_'.$widget_fields_get[$value]['name'].'">';
                        }elseif ($widget_fields_get[$value]['type']=="boolean"){
                            echo '<span class="sep"><input type="checkbox" id="acumba_'.$widget_fields_get[$value]['name'].'" name="acumba_'.$widget_fields_get[$value]['name'].'"><label>'.$widget_fields_get[$value]['name_given'].'</label></span>';
                        }
                    }
                echo '<button type="button" id="submit_acumba" class="subscribe-submit">'.$button.'</button></form></section>';
            }
    }else{
        echo $before_widget.'Configura el plugin de Acumbamail en la interfaz para visualizar el Widget'.$after_widget;
    }
?>
