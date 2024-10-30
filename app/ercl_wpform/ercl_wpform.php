<?php
define('CLWF_BASE_API','https://erp.cloodo.com/api/v1/');

add_filter('wpforms_ajax_submit_success_response','clwf',10,3);
function clwf($value_clwf,$post_wf,$form_data){
    $ercl_map = (array)json_decode(get_option('clwf_map_'.$post_wf));

    $client_email = $client_name = $note = '';
    foreach($_POST['wpforms']['complete'] as $field){
        switch ($field['type']){
            case 'name': 
                $client_name = $field['value'];
                break;
            case 'email':
                $client_email = $field['value'];
                break;
        }
        $note .= $field['name'] . ' : ' . $field['value']. "\r\n";
    }

    $arr_lead_clwf = [
        'method'=> 'POST',
        'body'=>[
            'client_name' => $client_name,
            'client_email' => $client_email,
            'company_name'=>sanitize_text_field($_POST["wpforms"]["fields"][$ercl_map['company_name']]),
            'website'=>sanitize_text_field($_POST["wpforms"]["fields"][$ercl_map['website']]),
            'address'=>sanitize_text_field($_POST["wpforms"]["fields"][$ercl_map['address']]),
            'office_phone'=>sanitize_text_field($_POST["wpforms"]["fields"][$ercl_map['office_phone']]),
            'city'=>sanitize_text_field($_POST["wpforms"]["fields"][$ercl_map['city']]),
            'country'=>sanitize_text_field($_POST["wpforms"]["fields"][$ercl_map['country']]),
            'mobile'=>sanitize_text_field($_POST["wpforms"]["fields"][$ercl_map['mobile']]),
            'category'=>sanitize_text_field($_POST["wpforms"]["fields"][$ercl_map['category']]),
            'next_follow_up' => 'yes',
            'note' => $note,
        ],
        'timeout'=> 30,
        'redirection'=> 5,
        'blocking'=> true,
        'headers'=> ['Authorization' => 'Bearer'.' '.get_option('cloodo_token')],
        'cookie'=> [],
        ];
    $api_lead_clwf = CLWF_BASE_API.'lead';
    wp_remote_request( $api_lead_clwf, $arr_lead_clwf );
    return $value_clwf;
}


// add_filter('wpforms_overview_table_column_value', 'clwf_get_form',1,3);

add_filter('wpforms_overview_row_actions', 'clwf_get_form',1,2);

function clwf_get_form ($value,$form) {
    $arrValue = [];
    $Form_title = (string)$form->post_title;
    $FormId=[
                'id' => $form->ID,
                'title' => $Form_title
            ];
    $option ='form_clwp'.$form->ID;
// -----------add fields
    $arrFields = (array)json_decode($form->post_content)->fields;
    $countArrFields = (int)count($arrFields);
    for ($i=0; $i < $countArrFields ; $i++) {
        if($arrFields[$i] == null || !isset($arrFields[$i])){
            $countArrFields =  $countArrFields+1;
            continue;
        }
        else{

            $id_fields = $arrFields[$i]->id;
            $label_fields= $arrFields[$i]->label;

            $arrValue[$i]['id'] = $id_fields;
            $arrValue[$i]['label'] =  $label_fields;
            $arrValue[$i]['type'] = $arrFields[$i]->type;
            $arrValue[$i]['name'] = $i;
        
        }
    }

    if(get_option($option) && get_option($option) != json_encode($arrValue)){
        update_option($option,json_encode($arrValue));
    }
    elseif(!get_option($option)){
        add_option($option,json_encode($arrValue));
    }
// -------------formId
    if(get_option('clwp_id') && get_option('clwp_id') !== null){
        $arrFormId = (array)json_decode(get_option('clwp_id'),true);
        $count_id_wpform = count($arrFormId);
        for ($i=0; $i < $count_id_wpform; $i++) {
            if ($arrFormId[$i]['id'] == $form->ID ) {
                break;
            }
            if($i == $count_id_wpform - 1){
                $arrFormId[$count_id_wpform] = $FormId;
                update_option('clwp_id',json_encode($arrFormId));
            }
        }
    }
    elseif(get_option('clwp_id')==null){
        $FormId = [['id' => $form->ID, 'title' => $Form_title]];
        update_option('clwp_id', json_encode($FormId));
    }
    else {
        $FormId = [['id' => $form->ID, 'title' => $Form_title]];
        add_option('clwp_id',json_encode($FormId));
    }
}



