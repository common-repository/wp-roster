<?php

    add_action( 'show_user_profile', 'wp_roster_profile_image' );
    add_action( 'edit_user_profile', 'wp_roster_profile_image' );

    function wp_roster_profile_image( $user ) { 

        //check if image exists
        $existingSetting = get_the_author_meta( 'wp-roster-profile-photo', $user->ID);

        if(  $existingSetting !== '' ){
            $existingValue = get_the_author_meta( 'wp-roster-profile-photo', $user->ID );
        } else {
            $existingValue = plugins_url( '../images/default-image.png', __FILE__ );   
        }

        ?>
        <h3><?php _e('WP Roster Profile Image', 'wp-roster'); ?></h3>

        <table class="form-table">
            <tr>
                <th><label for="address"><?php _e('Upload an Image', 'wp-roster'); ?></label></th>
                <td>
                    <input type="text" name="wp-roster-profile-photo" id="wp-roster-profile-photo" value="<?php echo esc_attr( $existingValue ); ?>" class="regular-text" /> <input type="button" name="upload-btn" id="upload-btn" class="button-secondary wp_roster_custom_user_profile_image" value="<?php _e('Upload Image', 'wp-roster'); ?>">
                    
                    <br />
                </td>
            </tr>
            <tr>
                <td>
                    <img id="wpRosterImagePreview" style="object-fit: cover; border-radius: 50% !important; box-shadow: 0px 0px 5px 0px rgba(0,0,0,.15);" alt="wp-roster-profile-photo" src="<?php echo esc_attr( $existingValue ); ?>" class="avatar avatar-96 photo" height="96" width="96">        
                </td>    
            </tr>


            <tr>
                <th><label for="wp-roster-phone"><?php _e("Phone",'wp-roster'); ?></label></th>
                <td>
                    <input placeholder="+61400123123" type="text" name="wp-roster-phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'wp-roster-phone', $user->ID ) ); ?>" class="regular-text" /><br />
                </td>
            </tr>


            <tr>
                <th><label for="wp-roster-preference"><?php _e("Preferred communication method",'wp-roster'); ?></label></th>
                <td>

                    <select name="wp-roster-preference" id="wp-roster-preference">

                        <?php
                            $selectItems = array(   "sms"=>__('SMS','wp-roster'),"email"=>__('Email','wp-roster'),"both"=>__('SMS & Email','wp-roster'),"none"=>__('None','wp-roster')   );

                            foreach($selectItems as $key=>$value){

                                if($key == get_the_author_meta( 'wp-roster-preference', $user->ID )){
                                    echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                                } else {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }

                            }

                        ?>
                        

                    </select><br />


                </td>
            </tr>


            <tr>
                <th><label for="wp-roster-allocation"><?php _e("Roster Allocation",'wp-roster'); ?></label></th>
                <td>
                    <div class="form-group">
                        <?php

                        
                        //get users current roster allocation
                        $existingAllocationArray = get_user_meta($user->ID,'wp-roster-roster-allocation', true);


                        //we need to get the roster names
                        $rosterNamesAndIds = array();

                        //get roster settings
                        $options = get_option('wp_roster_settings');
                            
                        $rosterSettings = $options['wp_roster_roster_settings'];
                        
                        //split setting
                        $individualRosterSettings = explode('||',$rosterSettings );

                        //cycle through settings
                        foreach($individualRosterSettings as $rosterSetting){

                            if(strlen($rosterSetting)>0){
                                //explode again
                                $expodedSetting = explode('|',$rosterSetting);

                                $rosterId = $expodedSetting[0];
                                $rosterName = $expodedSetting[1];

                                $rosterNamesAndIds[$rosterId] = $rosterName;
                            } 

                        }

                        foreach($rosterNamesAndIds as $id => $name){

                            if(in_array($id,$existingAllocationArray)){
                                echo '<input class="roster-allocation-checkbox" type="checkbox" value="'.esc_html($id).'" checked/>'.esc_html($name).'<br>';
                            } else {
                                echo '<input class="roster-allocation-checkbox" type="checkbox" value="'.esc_html($id).'"/>'.esc_html($name).'<br>';
                            }

                        }

                        //existing options imploded
                        $existingAllocationArrayImploded = implode('||',$existingAllocationArray);

                        echo '<input style="display: none !important;;" type="text" name="wp-roster-allocation" id="wp-roster-allocation" value="'.esc_html($existingAllocationArrayImploded).'" class="regular-text" /><br />';


                        ?>
            
                    </div>             


                </td>
            </tr>


            <?php 
                //we are going to start custom fields here
                
                //first see if there are any custom fields
                $options = get_option('wp_roster_settings');
                //specific data
                $existingSettings = $options['wp_roster_custom_fields_data'];


                if(isset($existingSettings)){

                    //explode the option
                    $explodedCustomFields = explode('|||',$existingSettings);

                    
                    //now lets cycle through the custom fields
                    foreach($explodedCustomFields as $customField){


                        

                        if( strlen($customField) > 0 ){


                            //explode further
                            $customFieldProperties = explode('^^',$customField);


                            $name = $customFieldProperties[0];
                            $type = $customFieldProperties[1];
                            $options = $customFieldProperties[2];
                            $segmentation = $customFieldProperties[3];
                            $frontend = $customFieldProperties[4];
                            $id = $customFieldProperties[5];

                            $identificationName = 'wp-roster-custom-field-'.$id;

                            if(strlen($name)>0){

                                echo '<tr>';
                                    echo '<th><label for="'.$identificationName.'">'.$name.'</label></th>';
                                    echo '<td>';

                                        //here is where we do conditionals based on the field type
                                        if($type == 'text'){
                                            echo '<input type="text" name="'.$identificationName.'" id="'.$identificationName.'" value="'.esc_attr( get_the_author_meta($identificationName, $user->ID ) ).'" class="regular-text" /><br />';
                                        }

                                        if($type == 'textarea'){
                                            echo '<textarea rows="5" cols="30" type="text" name="'.$identificationName.'" id="'.$identificationName.'" class="text-area">'.esc_attr( get_the_author_meta($identificationName, $user->ID ) ).'</textarea><br />';
                                        }

                                        if($type == 'select'){
                                            echo '<select name="'.$identificationName.'" id="'.$identificationName.'">';

                                                //create a blank value as well
                                                echo '<option value=""></option>';

                                                //explode the options
                                                $explodedSelectOptions = explode(',',$options);
                                                foreach($explodedSelectOptions as $selectOption){

                                                    $selectOptionTrimmed = trim($selectOption);

                                                    if($selectOption == get_the_author_meta($identificationName, $user->ID )){
                                                        echo '<option value="'.$selectOptionTrimmed.'" selected="selected">'.$selectOptionTrimmed.'</option>';
                                                    } else {
                                                        echo '<option value="'.$selectOptionTrimmed.'">'.$selectOptionTrimmed.'</option>';
                                                    }
                                                }

                                            echo '</select>';
                                        }

                                        if($type == 'date'){
                                            echo '<input type="text" name="'.$identificationName.'" id="'.$identificationName.'" value="'.esc_attr( get_the_author_meta($identificationName, $user->ID ) ).'" class="user-profile-date-selection" /><br />';
                                        }


                                    echo '</td>';

                                echo '</tr>';



                            }
                        }
                    }
                }


                

            ?>

    
             
            
             
               
            

            
            




        </table>
        <?php 
    }





    add_action( 'personal_options_update', 'wp_roster_profile_image_save' );
    add_action( 'edit_user_profile_update', 'wp_roster_profile_image_save' );

    function wp_roster_profile_image_save( $user_id ) {
        if ( !current_user_can( 'edit_user', $user_id ) ) { 
            return false; 
        }
        update_user_meta( $user_id, 'wp-roster-profile-photo', esc_url($_POST['wp-roster-profile-photo']));
        update_user_meta( $user_id, 'wp-roster-phone', sanitize_text_field($_POST['wp-roster-phone']));
        update_user_meta( $user_id, 'wp-roster-preference', sanitize_text_field($_POST['wp-roster-preference']));

        //get the field value and turn it into an array
        $allocationSanitized = sanitize_text_field($_POST['wp-roster-allocation']);
        $allocationExploded = explode('||',$allocationSanitized);

        //lets be good and remove empty values from the array
        array_filter($allocationExploded);

        update_user_meta( $user_id, 'wp-roster-roster-allocation', $allocationExploded );


        //now lets get the custom fields
        //first see if there are any custom fields
        $options = get_option('wp_roster_settings');
        //specific data
        $existingSettings = $options['wp_roster_custom_fields_data'];

        if(isset($existingSettings)){

            //explode the option
            $explodedCustomFields = explode('|||',$existingSettings);

                    
            //now lets cycle through the custom fields
            foreach($explodedCustomFields as $customField){
                if( strlen($customField) > 0 ){

                    //explode further
                    $customFieldProperties = explode('^^',$customField);

                    $id = $customFieldProperties[5];

                    $identificationName = 'wp-roster-custom-field-'.$id;

                    update_user_meta( $user_id, $identificationName, sanitize_text_field($_POST[$identificationName]));

                }    
            }
        }    



    }






?>