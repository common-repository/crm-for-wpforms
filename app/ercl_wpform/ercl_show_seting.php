<!DOCTYPE html>
<html lang="en">
<div class="ercl_wpform">
    <form action="" method="post" class="ercl_form_id">
        <label for="form" style="color: #2d58af; font-weight: 600; font-size: 15px" >Choose a form</label>
        <select id="form_id" name="form_id" style="font-size: 14px;font-weight: 500;">
            <option value="" style="font-size: 14px;font-weight: 500;">Form ID</option>
            <?php
                $arrClwpId = (array) json_decode(get_option('clwp_id'));
                $selected = '';
                for ($i = 0; $i < count($arrClwpId); $i++) {
                    if (isset($_POST['form_id']) && $arrClwpId[$i]->id == sanitize_text_field($_POST['form_id'])) {
                        $selected = 'selected';
                    } 
                    ?>
                    <option <?php echo 'value="'. esc_attr($arrClwpId[$i]->id). '" ' . esc_attr($selected) ?> style="font-size: 14px;font-weight: 500;" >
                        <?php echo( esc_html($arrClwpId[$i]->title) )?>
                    </option>
                <?php } ?>
        </select>
        <button type="submit" style="padding-bottom: 9px; border: #2d58af; background-color: #2d58af; color: white; border-radius: 3px; font-size: 14px;
    font-weight: 500;">submit</button>
    </form>
    <!-- form_id------------------------------ -->
    <form action="" method="post" class="ercl_form_submit">
        <div class="ercl_form_field">
            <div class="ercl_box_field">
                <?php
        if (isset($_POST['form_id'])){
            $form_fields = (array) json_decode(get_option('form_clwp' . sanitize_text_field($_POST['form_id'])));
            $count_form_fields = count($form_fields);
            $request_fields = [
                'client_name',
                'client_email',
                'company_name',
                'website',
                'address',
                'office_phone',
                'city',
                'country',
                'agent_id',
                'mobile',
                'category',
                'lead_agent'
            ];
            $count_request_fields = count($request_fields);

            if (isset($_POST['form_id'])) {
                for ($i = 0; $i < $count_request_fields; $i++) { ?>
                    <div class="ercl_field">
                        <label for="form_fields" class="ercl_label_field">
                            <?php echo( esc_html($request_fields[$i])); ?>
                        </label>
                        <br>
                        <?php $ercl_select_name = 'ercl_map['.sanitize_text_field($_POST['form_id'].']['.$request_fields[$i].']') ?>
                        <select id='form_fields' name="<?php echo( esc_attr($ercl_select_name) )?>" class="ercl_select_field">
                            <option value='-1' class="ercl_option_field">Choose a field wpForm</option>
                            <?php 
                            $ercl_key_map = array();
                            if (get_option('clwf_map_'.sanitize_text_field($_POST['form_id']))){
                                $ercl_key_map = (array)json_decode(get_option('clwf_map_' . sanitize_text_field($_POST['form_id'])));
                            }
                            foreach ($form_fields as $value) {
                                $selected = '';
                                if (isset($ercl_key_map[$request_fields[$i]]) && $ercl_key_map[$request_fields[$i]] === $value->id){
                                    $selected = 'selected';
                                } ?>
                                <option <?php echo 'value="'. esc_attr($value->id) . '" ' . esc_attr($selected) ?> class="ercl_option_field"><?php echo (esc_html((string)$value->label)) ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    
            <?php 
            }
        }
        ?>
            </div>
            <button type="submit" class="ercl_submit">submit</button>
        </div>
    <?php 
    }
?>
    </form>
  <?php
    if(isset($_POST['ercl_map'])){
        $clwf_map_id = sanitize_text_field(array_key_first($_POST['ercl_map']));
        if(sanitize_text_field($_POST['ercl_map'][$clwf_map_id]['client_name']) != -1 && sanitize_text_field($_POST['ercl_map'][$clwf_map_id]['client_email'] != -1)){
            update_option('clwf_map_'. $clwf_map_id,json_encode($_POST['ercl_map'][$clwf_map_id]));
            ercl_alert_message('Map update Fields Successful', '#04AA6D');
        }
        else{
            ercl_alert_message('Choose fields client_name and client_email', '#f44336');
        }
        
    }
       
    ?>
</div>

</html>