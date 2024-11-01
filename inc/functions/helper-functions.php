<?php


/**
* 
*
*
* setting builder
*/
function wp_roster_roster_settings_output($id,$name,$logo,$home,$teamName,$color,$rosterView,$rosterEdit,$dateViewEdit,$teamViewEdit,$historyViewEdit,$unavailableEdit,$notificationsViewEdit,$runSheetViewEdit,$notificationGroupName,$attendanceViewEdit,$unavailableRows){

    global $wp_roster_is_pro;

    //begin output
    $html = '';

    $html .= '<li data="'.$id.'"><table><tbody>';

    
    
    //name
    $html .= '<tr>';
        $html .= '<td><label>'.__('Roster Name','wp-roster').'</label></td>';
        $html .= '<td><input type="text" class="regular-text roster-name" value="'.rtrim($name).'"></td>';  
    $html .= '</tr>';
    
    //logo
    $html .= '<tr>';
        $html .= '<td><label>'.__('Roster Logo','wp-roster').'</label></td>';
        $html .= '<td><input type="text" class="regular-text roster-logo" value="'.rtrim($logo).'"> <button class="button-secondary roster-logo-upload"><i class="icon-picture"></i></button></td>';  
    $html .= '</tr>';

    //home
    $html .= '<tr>';
        $html .= '<td><label>'.__('Home URL','wp-roster').'</label></td>';
        $html .= '<td><input type="text" class="regular-text roster-home" value="'.rtrim($home).'"></td>';  
    $html .= '</tr>';

    //teamName
    $html .= '<tr>';
        $html .= '<td><label>'.__('Team Name','wp-roster').'</label></td>';
        $html .= '<td><input type="text" class="regular-text roster-team-name" value="'.rtrim($teamName).'"></td>';  
    $html .= '</tr>';

    //notificationGroupName
    $html .= '<tr>';
        $html .= '<td><label>'.__('Notification Group Name','wp-roster').'</label></td>';
        $html .= '<td><input type="text" class="regular-text roster-notification-group-name" value="'.rtrim($notificationGroupName).'"></td>';  
    $html .= '</tr>';

    //color
    $html .= '<tr>';
        $html .= '<td><label>'.__('Theme Color','wp-roster').'</label></td>';
        $html .= '<td><input type="text" class="my-color-field regular-text roster-color" value="'.rtrim($color).'"></td>';  
    $html .= '</tr>';


    $roles = array( 'guest'=>__('Guest','wp-roster'),'roster-member'=>__('Roster member','wp-roster'),'editor'=>__('Editor','wp-roster'),'administrator'=>__('Administrator','wp-roster') );


    //roster view
    $html .= '<tr>';
        $html .= '<td><label>'.__('Roster View','wp-roster').'</label></td>';
        $html .= '<td><select class="roster-view">';
            foreach($roles as $key=>$value){
                if($key == $rosterView){
                    $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                } else {
                    $html .= '<option value="'.$key.'">'.$value.'</option>';
                }
            }    
        $html .= '</select></td>'; 
    $html .= '</tr>';    

    //roster edit
    $html .= '<tr>';
        $html .= '<td><label>'.__('Roster Edit','wp-roster').'</label></td>';
        $html .= '<td><select class="roster-edit">';
            foreach($roles as $key=>$value){
                if($key == $rosterEdit){
                    $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                } else {
                    $html .= '<option value="'.$key.'">'.$value.'</option>';
                }
            }    
        $html .= '</select></td>'; 
    $html .= '</tr>'; 

    //date view/edit
    $html .= '<tr>';
        $html .= '<td><label>'.__('Date View/Edit','wp-roster').'</label></td>';
        $html .= '<td><select class="date-view-edit">';
            foreach($roles as $key=>$value){
                if($key == $dateViewEdit){
                    $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                } else {
                    $html .= '<option value="'.$key.'">'.$value.'</option>';
                }
            }    
        $html .= '</select></td>'; 
    $html .= '</tr>'; 

    //team view/edit
    $html .= '<tr>';
        $html .= '<td><label>'.__('Team View/Edit','wp-roster').'</label></td>';
        $html .= '<td><select class="team-view-edit">';
            foreach($roles as $key=>$value){
                if($key == $teamViewEdit){
                    $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                } else {
                    $html .= '<option value="'.$key.'">'.$value.'</option>';
                }
            }    
        $html .= '</select></td>'; 
    $html .= '</tr>'; 

    //history view/edit
    $html .= '<tr>';
        $html .= '<td><label>'.__('History View/Edit','wp-roster').'</label></td>';
        $html .= '<td><select class="history-view-edit">';
            foreach($roles as $key=>$value){
                if($key == $historyViewEdit){
                    $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                } else {
                    $html .= '<option value="'.$key.'">'.$value.'</option>';
                }
            }    
        $html .= '</select></td>'; 
    $html .= '</tr>'; 


    //only show these options if pro
    if($wp_roster_is_pro == "YES"){

        //unavailable edit (pro)
        $html .= '<tr>';
            $html .= '<td><label>'.__('Unavailable Edit','wp-roster').'</label></td>';
            $html .= '<td><select class="unavailable-edit">';
                foreach($roles as $key=>$value){
                    if($key == $unavailableEdit){
                        $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                    } else {
                        $html .= '<option value="'.$key.'">'.$value.'</option>';
                    }
                }    
            $html .= '</select></td>'; 
        $html .= '</tr>'; 


        //notification view/edit (pro)
        $html .= '<tr>';
            $html .= '<td><label>'.__('Notifications View/Edit','wp-roster').'</label></td>';
            $html .= '<td><select class="notifications-view-edit">';
                foreach($roles as $key=>$value){
                    if($key == $notificationsViewEdit){
                        $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                    } else {
                        $html .= '<option value="'.$key.'">'.$value.'</option>';
                    }
                }    
            $html .= '</select></td>'; 
        $html .= '</tr>'; 

        //run sheet view/edit (pro)
        $html .= '<tr>';
            $html .= '<td><label>'.__('Run Sheet View/Edit','wp-roster').'</label></td>';
            $html .= '<td><select class="run-sheet-view-edit">';
                foreach($roles as $key=>$value){
                    if($key == $runSheetViewEdit){
                        $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                    } else {
                        $html .= '<option value="'.$key.'">'.$value.'</option>';
                    }
                }    
            $html .= '</select></td>'; 
        $html .= '</tr>'; 


        //attendance view/edit (pro)
        $html .= '<tr>';
            $html .= '<td><label>'.__('Attendance View/Edit','wp-roster').'</label></td>';
            $html .= '<td><select class="attendance-view-edit">';
                foreach($roles as $key=>$value){
                    if($key == $attendanceViewEdit){
                        $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                    } else {
                        $html .= '<option value="'.$key.'">'.$value.'</option>';
                    }
                }    
            $html .= '</select></td>'; 
        $html .= '</tr>'; 

        //unavailable rows (pro)

        $html .= '<tr>';
            $html .= '<td><label>'.__('Unavailable Rows','wp-roster').'</label></td>';
            $html .= '<td><input type="number" class="regular-text unavailable-rows" value="'.rtrim($unavailableRows).'"></td>';  
        $html .= '</tr>';
                


    }


    




    
    
    //action buttons
    $html .= '<tr class="roster-action-buttons">';
        $html .= '<td colspan="2"><button class="copy-roster-shortcode button-secondary" data-clipboard-text="[wp-roster id=&quot;'.$id.'&quot;]" data="'.$id.'"><i class="icon-share-alt"></i> '.__('Copy Shortcode','wp-roster').'</button><button class="duplicate-roster button-secondary-red" data="'.$id.'"><i class="icon-docs"></i> '.__('Duplicate Roster','wp-roster').'</button><button class="delete-roster button-secondary-red" data="'.$id.'"><i class="icon-trash"></i> '.__('Delete Roster','wp-roster').'</button></td>';
    $html .= '</tr>';
 
    
    
    $html .= '</tbody></table></li>';

    return $html;

}



/**
* 
*
*
* Adds a roster
*/
function wp_roster_add_roster() {

    //get options
    $options = get_option('wp_roster_settings');
    
    //get is pro
    global $wp_roster_is_pro;

    //get javascript inputs
    $rosterName = wp_roster_sanitization_validation($_POST['rosterName'],'rostername');
    $rosterCount = intval($_POST['rosterCount']);

    if($rosterName == false){
        wp_die(); 
    }

    $addRosterValidation = 0;

    //if count is 0 all good
    if($rosterCount == 0){
        $addRosterValidation++;
    }

    //if pro all good
    if($wp_roster_is_pro == 'YES' && isset($options['wp_roster_purchase_email']) && isset($options['wp_roster_order_id']) && strlen($options['wp_roster_purchase_email']) > 0 && strlen($options['wp_roster_order_id'])>0   ){
        $addRosterValidation++;       
    }

    if($addRosterValidation == 0 && $wp_roster_is_pro !== 'YES'){
        echo 'NOT PRO';  
        wp_die();  
    }

    if($addRosterValidation == 0 && $wp_roster_is_pro == 'YES'){
        echo 'PRO ISSUE';  
        wp_die();  
    }

    if($addRosterValidation > 0){

        $newRosterId = wp_roster_data_counter('roster');

        echo wp_roster_roster_settings_output($newRosterId,$rosterName,'','','','#da405c','guest','editor','editor','editor','editor','guest','administrator','editor','','administrator',10);

        //add an option for the roster
        add_option('wp_roster_data_'.$newRosterId, array()); 
        add_option('wp_roster_data_history_'.$newRosterId, array()); 
        add_option('wp_roster_data_log_'.$newRosterId, array()); 
        add_option('wp_roster_data_attendance_'.$newRosterId, array()); 

        wp_die(); 
    }

    
  
    

 
}
add_action( 'wp_ajax_add_roster', 'wp_roster_add_roster' );



/**
* 
*
*
* validates and sanitizes input data
*/
function wp_roster_sanitization_validation($data,$type){
    
    //types include email, name, post id, board name
    
    //if the data is LOGGED-IN MAKE IT PASS
    if($data == 'LOGGED-IN'){
        return $data;     
    }
    
    
    
    //first sanitize inputs
    if($type == 'email'){
        $data = sanitize_email($data);      
    } elseif ($type == 'name'){
        $data = sanitize_text_field($data);    
    } elseif($type == 'id') {
        $data = sanitize_text_field($data);  
    } elseif($type == 'rostername'){
        $data = sanitize_text_field($data);    
    } elseif($type == 'phone'){
        $data = sanitize_text_field($data); 
    } else { 
    }
    
    return $data;
    
    
    //lets now validate the input
   
    if($type == 'email' && strlen($data) > 254 && strpos($data, '@') === false){
        
        return false;

    } elseif ($type == 'name' && 1 === preg_match('~[0-9]~', $data)){
        
        return false;    
        
    } elseif ($type == 'id' && strlen($data) > 9 && is_numeric($data) == false) {
        
        return false;      
        
    } elseif($type == 'rostername' && strlen($data) > 254) {
        
        return false;    
        
    } elseif($type == 'phone' && strlen($data) > 15 && $data[0] !== '+' && !is_numeric(substr($data, 1)) &  $data !== '' ){

        return false; 

    } else {
        
        return $data;
        
    }
     
}
/**
* 
*
*
* Adds a counter to either rosters, teams or dates or members
* input should be either roster,team,date, notification,autonotification
*/
function wp_roster_data_counter($type) {

    $optionName = 'wp_roster_counter';

    //get existing option
    $existingValue = get_option($optionName);

    //if the option doesnt even exist we need to create it
    if($existingValue == false){
        //the option doesn't exist so we need to create it
        $existingValue = array($type=>1);  
        $updatedNumber = 1; 
    } else {
        //the option at least exists
        //check to see if the type is in the array
        if(array_key_exists($type,$existingValue)){
            //the item exists so we need to update it
            $typeValue = $existingValue[$type];
            //add one to it
            $typeValue++;
            //now update the option
            $existingValue[$type] = $typeValue;

            $updatedNumber = $typeValue;
            
        } else {
            //the option exists but the type doesnt
            $existingValue[$type] = 1;
            $updatedNumber = 1; 

        }
    }


    update_option($optionName,$existingValue);
    return $updatedNumber;

} 
/**
* 
*
*
* Deletes a roster
*/
function wp_roster_delete_roster() {

    //get javascript inputs
    $rosterID = intval($_POST['rosterID']);

    delete_option('wp_roster_data_'.$rosterID); 
    
    //also delete the history and log
    delete_option('wp_roster_data_history_'.$rosterID); 
    delete_option('wp_roster_data_log_'.$rosterID); 
    delete_option('wp_roster_data_attendance_'.$rosterID); 


    //now we also need to remove the roster id from all wp roster users
    //lets first get all users
    $args = array(
        'role' => 'wp_roster_member',
    ); 
    $allWpRosterUsers = get_users( $args );

    foreach ( $allWpRosterUsers as $user ) {
        //get id
        $userId = $user->ID;
        //get user meta
        $userRosterAllocation = get_user_meta($userId,'wp-roster-roster-allocation', true);

        //remove the rosterid from the user
        $userAllocationWithoutRoster = array_diff($userRosterAllocation, array($rosterID));

        //update the meta
        update_user_meta($userId,'wp-roster-roster-allocation', $userAllocationWithoutRoster);

    }

    wp_die(); 
 
}
add_action( 'wp_ajax_delete_roster', 'wp_roster_delete_roster' );





/**
* 
*
*
* Duplicates a roster
*/
function wp_roster_duplicate_roster() {

    //get options
    $options = get_option('wp_roster_settings');
    
    //get is pro
    global $wp_roster_is_pro;

    //get javascript inputs
    $rosterId = intval($_POST['rosterId']);
    $rosterCount = intval($_POST['rosterCount']);
    $rosterName = sanitize_text_field($_POST['rosterName']);
    $rosterLogo = sanitize_text_field($_POST['rosterLogo']);
    $homeUrl = sanitize_text_field($_POST['homeUrl']);
    $teamName = sanitize_text_field($_POST['teamName']);
    $notificationGroupName = sanitize_text_field($_POST['notificationGroupName']);
    $themeColor = sanitize_text_field($_POST['themeColor']);

    $rosterView = sanitize_text_field($_POST['rosterView']);
    $rosterEdit = sanitize_text_field($_POST['rosterEdit']);
    $dateViewEdit = sanitize_text_field($_POST['dateViewEdit']);
    $teamViewEdit = sanitize_text_field($_POST['teamViewEdit']);
    $historyViewEdit = sanitize_text_field($_POST['historyViewEdit']);
    $unavailableEdit = sanitize_text_field($_POST['unavailableEdit']);
    $notificationsViewEdit = sanitize_text_field($_POST['notificationsViewEdit']);
    $runSheetViewEdit = sanitize_text_field($_POST['runSheetViewEdit']);
    $attendanceViewEdit = sanitize_text_field($_POST['attendanceViewEdit']);
    $unavailableRows = sanitize_text_field($_POST['unavailableRows']);



    $addRosterValidation = 0;

    //if count is 0 all good
    if($rosterCount == 0){
        $addRosterValidation++;
    }

    //if pro all good
    if($wp_roster_is_pro == 'YES' && isset($options['wp_roster_purchase_email']) && isset($options['wp_roster_order_id']) && strlen($options['wp_roster_purchase_email']) > 0 && strlen($options['wp_roster_order_id'])>0   ){
        $addRosterValidation++;       
    }

    if($addRosterValidation == 0 && $wp_roster_is_pro !== 'YES'){
        echo 'NOT PRO';  
        wp_die();  
    }

    if($addRosterValidation == 0 && $wp_roster_is_pro == 'YES'){
        echo 'PRO ISSUE';  
        wp_die();  
    }

    if($addRosterValidation > 0){

        $newRosterId = wp_roster_data_counter('roster');

        echo wp_roster_roster_settings_output($newRosterId,$rosterName.' (copy)',$rosterLogo,$homeUrl,$teamName,$themeColor,$rosterView,$rosterEdit,$dateViewEdit,$teamViewEdit,$historyViewEdit,$unavailableEdit,$notificationsViewEdit,$runSheetViewEdit,$notificationGroupName,$attendanceViewEdit,$unavailableRows);


        //get previous data
        $previousData = get_option('wp_roster_data_'.$rosterId);

        //add an option for the roster
        add_option('wp_roster_data_'.$newRosterId,$previousData); 
        add_option('wp_roster_data_history_'.$newRosterId, array());
        add_option('wp_roster_data_log_'.$newRosterId, array());
        add_option('wp_roster_data_attendance_'.$newRosterId, array());
        
        //we also need to copy the users that were on this roster to the new roster
        //lets first get all users
        $args = array(
            'role' => 'wp_roster_member',
        ); 
        $allWpRosterUsers = get_users( $args );





        foreach ( $allWpRosterUsers as $user ) {
            //get id
            $userId = $user->ID;
            //get user meta
            $userRosterAllocation = get_user_meta($userId,'wp-roster-roster-allocation', true);

            //if the person is in the array add the new roster id to the array
            if(in_array($rosterId,$userRosterAllocation)){
                array_push($userRosterAllocation,$newRosterId);
            }    
            
            //update the meta
            update_user_meta($userId,'wp-roster-roster-allocation', $userRosterAllocation);

        }


        wp_die(); 
    }

    
  
    

 
}
add_action( 'wp_ajax_duplicate_roster', 'wp_roster_duplicate_roster' );


/**
* 
*
*
* Gets individual roster settings
*/
function wp_roster_individual_roster_settings($rosterId){

     //get roster settings
     $options = get_option('wp_roster_settings');
        
     $rosterSettings = $options['wp_roster_roster_settings'];
     
     //split setting
     $individualRosterSettings = explode('||',$rosterSettings );

     //cycle through settings
     foreach($individualRosterSettings as $rosterSetting){
         //explode again
         $expodedSetting = explode('|',$rosterSetting);

         if($expodedSetting[0] == $rosterId){

             $matchingSettings = $expodedSetting;

         }

     }

     return $matchingSettings;
}




/**
* 
*
*
* Gets the user profile image
*/
function wp_roster_get_user_avatar($userId){

        
        $imageUrl = get_user_meta($userId, 'wp-roster-profile-photo', true);

    
        if(empty($imageUrl)){
    
            $imageUrl = plugins_url( '../images/default-image.png', __FILE__ );
    
        }
    
        return $imageUrl;
        
}


/**
* 
*
*
* Saves the settings
*/
function wp_roster_save_settings(){
    
    $rosterId = intval($_POST['rosterId']);
    $userId = get_current_user_id();
    $module = sanitize_text_field($_POST['module']);
    $newData = $_POST['newData'];
    
    if( $module !== 'roster' && $module !== 'teams' && $module !== 'dates' && $module !== 'notifications' && $module !== 'run-sheet' ){
        echo "ERROR";
        wp_die(); 
    }


    $currentTime = current_time('timestamp');

    //get the option names
    $optionName = 'wp_roster_data_'.$rosterId;
    $historyOptionName = 'wp_roster_data_history_'.$rosterId;

    //first lets get our existing data
    $existingSettings = get_option($optionName);

    //now lets update the specific module 
    $existingSettings[$module] = $newData;

    //now lets update the option
    update_option($optionName,$existingSettings);


    //second lets update history option
    //get the current history
    $existingHistoryItems = get_option($historyOptionName);

    //add the item to the history
    $existingHistoryItems[$currentTime] = array($userId,$module,$existingSettings);

    //now lets update the option
    //but before we do we want to boot out any old items so the history doesnt get too massive
    //lets get the current count
    $currentCount = count($existingHistoryItems);
    //only do something if the count is over some number
    if($currentCount>20){
        //remove the first element from the array
        reset($existingHistoryItems);    
        $key = key($existingHistoryItems);
        unset($existingHistoryItems[$key]);
    }

    update_option($historyOptionName,$existingHistoryItems);



    echo "SUCCESS";
    wp_die();    
}

add_action( 'wp_ajax_save_settings', 'wp_roster_save_settings' );
add_action( 'wp_ajax_nopriv_save_settings', 'wp_roster_save_settings' );

/**
* 
*
*
* Restores the settings
*/
function wp_roster_restore_settings(){
    
    $rosterId = intval($_POST['rosterId']);
    $dataId = intval($_POST['dataId']);
    $userId = get_current_user_id();
    $module = sanitize_text_field($_POST['module']);
    
    if($userId == false && $module !== 'roster' && $module !== 'teams' && $module !== 'dates' && $module !== 'notifications' && $module !== 'run-sheet' ){
        echo "ERROR";
        wp_die(); 
    }

    $currentTime = current_time('timestamp');

    //the option name
    $optionName = 'wp_roster_data_'.$rosterId;
    $historyOptionName = 'wp_roster_data_history_'.$rosterId;

    //what we need to do is grab the specific setting from the history
    $existingHistoryItems = get_option($historyOptionName);
    //now we need to just get the key and data
    $specificSettings = $existingHistoryItems[$dataId][2];

    //then we need to update the normal option with this data
    update_option($optionName,$specificSettings);

    //we should then add this new setting to the history
    $existingHistoryItems[$currentTime] = array($userId,$module,$specificSettings);
    
    //now lets update the option
    //but before we do we want to boot out any old items so the history doesnt get too massive
    //lets get the current count
    $currentCount = count($existingHistoryItems);
    //only do something if the count is over some number
    if($currentCount>20){
        //remove the first element from the array
        reset($existingHistoryItems);    
        $key = key($existingHistoryItems);
        unset($existingHistoryItems[$key]);
    }

    //now lets update the history settings option
    update_option($historyOptionName,$existingHistoryItems);

    //we are going to return our new line item so we can append this to the top of the list
    echo wp_roster_history_list_item($currentTime,$userId,$module);

    wp_die();    
}

add_action( 'wp_ajax_restore_settings', 'wp_roster_restore_settings' );
add_action( 'wp_ajax_nopriv_restore_settings', 'wp_roster_restore_settings' );


/**
* 
*
*
* Creates history line item
*/
function wp_roster_history_list_item($timeStamp,$user,$module){

    $dateFormat = get_option( 'date_format' );
    $timeFormat = get_option( 'time_format' );

    if($user == 0){
        $userName = __('Guest User','wp-roster');
    } else {
        $userDetails = get_user_by('id', $user );
        $userName = esc_html($userDetails->first_name.' '.$userDetails->last_name);
    }

    $timeStamp = esc_html($timeStamp);

    $html = '';

    $html .= '<li>';
        $html .= '<span>'.date_i18n($dateFormat,$timeStamp).'</span>';
        $html .= '<span>'.date_i18n($timeFormat,$timeStamp).'</span>';
        $html .= '<span>'.$userName.'</span>';
        $html .= '<span>'.esc_html($module).'</span>';
        $html .= '<span><button class="restore-settings secondary-button" data="'.$timeStamp.'">'.__('Restore','wp-roster').'</button></span>';
    $html .= '</li>';

    return $html;

}
/**
* 
*
*
* Creates date line item
*/
function wp_roster_date_line_item($id,$dateTimeInput,$description){

    $html = '';

    $class = '';


    //get current date
    $currentTime = current_time('timestamp');

    if($currentTime > strtotime($dateTimeInput)){
        $class .= 'past-date';
    } else {
        $class .= 'future-date';   
    }

    $html .= '<li class="'.$class.'" data="'.esc_attr($id).'">';

        //date/time
        $html .= '<span class="date-time-field"><label for="datetime">'.__('Date/Time','wp-roster').':</label><input class="date-time-input date-time-input-'.esc_attr($id).'" type="text" name="datetime" value="'.esc_html($dateTimeInput).'"></span>';

        // //time
        // $html .= '<span class="time-field"><label for="time">'.__('Time','wp-roster').':</label><input type="text" name="time"></span>';

        //description
        $html .= '<span class="description-field"><label for="description">'.__('Description','wp-roster').':</label><input class="description-input" type="text" name="description" value="'.esc_html(stripslashes($description)).'"></span>';

        //delete
        $html .= '<span class="delete-date-section"><i class="delete-date icon-trash"></i></span>';

    $html .= '</li>';

    return $html;

}    

/**
* 
*
*
* Add date
*/
function wp_roster_add_date(){
    
    $dateTimeInput = sanitize_text_field($_POST['dateTimeInput']);
    $description = sanitize_text_field($_POST['description']);

    if(strlen($dateTimeInput) > 16){
        wp_die(); 
    }

    
    //get a unique id for the date
    $id = wp_roster_data_counter('dates');

    //we need to add the id so we can re-initialise the date picker on the unique element only - such a major pain!
    echo $id.'|'.wp_roster_date_line_item($id,$dateTimeInput,$description);

    wp_die();    
}

add_action( 'wp_ajax_add_date', 'wp_roster_add_date' );
add_action( 'wp_ajax_nopriv_add_date', 'wp_roster_add_date' );


/**
* 
*
*
* Add member
*/
function wp_roster_add_member(){
    
    //get variables
    $rosterId = intval($_POST['rosterId']);
    $firstName = wp_roster_sanitization_validation($_POST['firstName'],'name');
    $lastName = wp_roster_sanitization_validation($_POST['lastName'],'name');
    $email = wp_roster_sanitization_validation($_POST['email'],'email');
    $phone = wp_roster_sanitization_validation($_POST['phone'],'phone');
    $preference = wp_roster_sanitization_validation($_POST['preference'],'name');
    $customFields = sanitize_text_field($_POST['customFields']);


    

    if($phone == ''){
        $phone = 'true';
    }

    if($firstName == false || $lastName == false || $email == false || $phone == false || $preference == false){
        echo 'ERROR';
        wp_die();  
    }


    //we are actually going to do the check by email because wordpress requires the email be unique!
    $existingUser = get_user_by( 'email',$email);
    
    if($existingUser == false){

        //ok we are good to continue
        $userId = 'wp-roster-'.wp_roster_data_counter('members');

        //lets create the user
        $userdata = array(
            'user_login'  =>  $userId,
            'display_name'  =>  $firstName.' '.$lastName,
            'nickname'  =>  $firstName,
            'first_name'  =>  $firstName,
            'last_name'  =>  $lastName,
            'role'  =>  'wp_roster_member',
    //        'role'  =>  'contributor',
            'description'  =>  'This user was created automatically by the WP Roster plugin.',
            'user_email'  =>  $email,
            'user_pass'   =>  NULL  // When creating an user, `user_pass` is expected.
        );


        $user_id = wp_insert_user($userdata);
        
        //lets add meta
        add_user_meta($user_id, 'wp-roster-preference', $preference); 


        if($phone == 'true'){
            $phone = '';
        }

         

        add_user_meta($user_id, 'wp-roster-phone', $phone); 
        add_user_meta($user_id, 'wp-roster-roster-allocation', array($rosterId)); 

        //now lets cycle through custom fields
        if( strlen($customFields)>0 ){

            //explode the option
            $customFieldsExploded = explode('|||',$customFields);

            //cycle through the fields
            foreach($customFieldsExploded as $customField){

                if( strlen($customField)>0 ){

                    $customFieldExploded = explode('^^',$customField);
                    $fieldName = $customFieldExploded[0];
                    $fieldValue = $customFieldExploded[1];

                    //now lets update the option with the value
                    add_user_meta($user_id, $fieldName, $fieldValue); 

                }

            }

        }

        //here we will actually get the html for the list item instead of doing this
        echo wp_roster_user_line_item($user_id);

    } else {
        echo 'EXISTING MEMBER';
    }



    wp_die();    
}

add_action( 'wp_ajax_add_member', 'wp_roster_add_member' );
add_action( 'wp_ajax_nopriv_add_member', 'wp_roster_add_member' );



/**
* 
*
*
* Creates user line item
*/
function wp_roster_user_line_item($id){

    $user = get_user_by('id', $id);    

    $html = '';

    $html .= '<li data="'.$id.'">';

        //name
        $html .= '<span class="full-name filter-name">'.$user->first_name.' '.$user->last_name.'</span>';

        //action section
        $html .= '<span class="user-action-section"><i data="'.$id.'" class="edit-user icon-pencil"></i><i data="'.$id.'" class="delete-user icon-trash"></i></span>';

        //need to add fields here!
        $html .= wp_roster_update_member_information($id);

    $html .= '</li>';

    return $html;

}   




/**
* 
*
*
* Use existing member
*/
function wp_roster_use_existing_member(){
    
    //get variables
    $rosterId = intval($_POST['rosterId']);
    $email = wp_roster_sanitization_validation($_POST['email'],'email');


    if($email == false ){
        wp_die();  
    }


    //then we need to get the current user and add the roster id to their custom meta
    $existingUser = get_user_by('email',$email);
    $existingUserId = $existingUser->ID;

    //also add the capability
    //if user doesnt have capability add it to them
    if(!user_can( $existingUser,'wp_roster_member')){
        $existingUser->add_cap('wp_roster_member');
    }
    

    //get current meta
    $existingRosterAllocation = get_user_meta($existingUserId,'wp-roster-roster-allocation', true);

    //we need to run a check if empty
    if(empty($existingRosterAllocation)){
        update_user_meta($existingUserId,'wp-roster-roster-allocation',array($rosterId));    
    } else {
        //add item
        array_push($existingRosterAllocation,$rosterId);
        //now lets update the meta
        update_user_meta($existingUserId,'wp-roster-roster-allocation', $existingRosterAllocation);

    }

    //and then return the list item
    echo wp_roster_user_line_item($existingUserId);

    wp_die();    
}

add_action( 'wp_ajax_use_existing_member', 'wp_roster_use_existing_member' );
add_action( 'wp_ajax_nopriv_use_existing_member', 'wp_roster_use_existing_member' );









/**
* 
*
*
* update existing member
*/
function wp_roster_update_existing_member(){
    
    //get variables
    $rosterId = intval($_POST['rosterId']);
    $firstName = wp_roster_sanitization_validation($_POST['firstName'],'name');
    $lastName = wp_roster_sanitization_validation($_POST['lastName'],'name');
    $email = wp_roster_sanitization_validation($_POST['email'],'email');
    $phone = wp_roster_sanitization_validation($_POST['phone'],'phone');
    $preference = wp_roster_sanitization_validation($_POST['preference'],'name');
    $customFields = sanitize_text_field($_POST['customFields']);
    
    if($phone == ''){
        $phone = 'true';
    }

    if($firstName == false || $lastName == false || $email == false || $phone == false || $preference == false){
        echo 'ERROR';
        wp_die();  
    }

    //we are good to continue
    //then we need to get the current user and add the roster id to their custom meta
    $existingUser = get_user_by('email',$email);
    $existingUserId = $existingUser->ID;

    //also add the capability
    //if user doesnt have capability add it to them
    if(!user_can( $existingUser,'wp_roster_member')){
        $existingUser->add_cap('wp_roster_member');
    }


    //here we need to update the first and last name
    wp_update_user( array( 'ID' => $existingUserId, 'first_name' => $firstName, 'last_name' => $lastName, 'display_name' => $firstName.' '.$lastName, 'nickname' => $firstName       ) );



    //this is how we handle the roster allocation
    //get current meta
    $existingRosterAllocation = get_user_meta($existingUserId,'wp-roster-roster-allocation', true);

    if(empty($existingRosterAllocation)){
        update_user_meta($existingUserId,'wp-roster-roster-allocation', array($rosterId));    
    } else {
        array_push($existingRosterAllocation,$rosterId);
        //now lets update the meta
        update_user_meta($existingUserId,'wp-roster-roster-allocation', $existingRosterAllocation);
    }


    //here we need to update the phone and preference
    //we dont need to do any checks we just do a straight update
    update_user_meta($existingUserId,'wp-roster-preference', $preference);
    if($phone == 'true'){
        $phone = '';
    }
    update_user_meta($existingUserId,'wp-roster-phone', $phone);


    //now lets do custom fields
    if( strlen($customFields)>0 ){

        //explode the option
        $customFieldsExploded = explode('|||',$customFields);

        //cycle through the fields
        foreach($customFieldsExploded as $customField){

            if( strlen($customField)>0 ){

                $customFieldExploded = explode('^^',$customField);
                $fieldName = $customFieldExploded[0];
                $fieldValue = $customFieldExploded[1];

                //now lets update the option with the value
                update_user_meta($existingUserId, $fieldName, $fieldValue); 

            }

        }

    }



    //and then return the list item
    echo wp_roster_user_line_item($existingUserId);

    wp_die();    
}

add_action( 'wp_ajax_update_existing_member', 'wp_roster_update_existing_member' );
add_action( 'wp_ajax_nopriv_update_existing_member', 'wp_roster_update_existing_member' );






/**
* 
*
*
* delete existing member
*/
function wp_roster_delete_existing_member(){
    
    //get variables
    $rosterId = wp_roster_sanitization_validation($_POST['rosterId'],'id');
    $userId = wp_roster_sanitization_validation($_POST['userId'],'id');
    
    //lets keep this sanitization and error checking because its critical in this case
    if($rosterId == false || $userId == false){
        echo 'ERROR';
        wp_die();  
    }

    //we are good to continue
    //now we need to get the user meta
    $existingRosterAllocation = get_user_meta($userId,'wp-roster-roster-allocation', true);


    //first remove the current roster
    $userAllocationWithoutRoster = array_diff($existingRosterAllocation, array($rosterId));

    $amountOfCapabilities = count(get_user_meta($userId,'wp_capabilities',true));


    //if the array is now empty() and the user does have another role then also delete the user fully
    //otherwise update the meta
    if(empty($userAllocationWithoutRoster) && $amountOfCapabilities < 2){
        wp_delete_user($userId);
    } else {
        update_user_meta($userId,'wp-roster-roster-allocation', $userAllocationWithoutRoster);
    }



    wp_die();    
}

add_action( 'wp_ajax_delete_existing_member', 'wp_roster_delete_existing_member' );
add_action( 'wp_ajax_nopriv_delete_existing_member', 'wp_roster_delete_existing_member' );




/**
* 
*
*
* member form
*/
function wp_roster_update_member_information($userId){
    

    // //lets get our user information
    $user = get_user_by( 'ID', $userId );

    //lets create our form
    $html = '';

    $html .= '<span class="user-edit-form">';

        //first name
        $html .= '<span class="firstName">';
        $html .= '<label for="firstName">'.__('First name','wp-roster').'</label>';
        $html .= '<input class="user-edit-form-first-name" type="text" name="firstName" value="'.esc_html($user->first_name).'">';
        $html .= '</span>';

        //last name
        $html .= '<span class="lastName">';
        $html .= '<label for="lastName">'.__('Last name','wp-roster').'</label>';
        $html .= '<input class="user-edit-form-last-name" type="text" name="lastName" value="'.esc_html($user->last_name).'">';
        $html .= '</span>';

        //email
        $html .= '<span class="email">';
        $html .= '<label for="email">'.__('Email','wp-roster').'</label>';
        $html .= '<input class="user-edit-form-email" type="text" name="email" value="'.esc_html($user->user_email).'">';
        $html .= '</span>';

        global $wp_roster_is_pro;

        if($wp_roster_is_pro == "YES"){

            //phone
            $html .= '<span class="phone">';
            $html .= '<label for="phone">'.__('Phone','wp-roster').'</label>';
            $html .= '<input class="user-edit-form-phone" type="text" name="phone" value="'.esc_html(get_user_meta($userId ,'wp-roster-phone', true)).'">';
            $html .= '</span>';

            //preferred communication method
            //type
            $html .= '<span class="preference">';
            $html .= '<label for="preference">'.__('Preferred communication method','wp-roster').'</label>';
            $html .= '<select class="user-edit-form-preference" name="preference">';

                $selectItems = array(   "sms"=>__('SMS','wp-roster'),"email"=>__('Email','wp-roster'),"both"=>__('SMS & Email','wp-roster'),"none"=>__('None','wp-roster')   );

                $existingPreference = get_user_meta($userId ,'wp-roster-preference', true);

                foreach($selectItems as $key=>$value){

                    if($key == $existingPreference){
                        $html .= '<option value="'.esc_attr($key).'" selected="selected">'.esc_html($value).'</option>';
                    } else {
                        $html .= '<option value="'.esc_attr($key).'">'.esc_html($value).'</option>';
                    }

                    
                }


            $html .= '</select>';
            $html .= '</span>';

        }

        //lets do custom fields

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

                    if(strlen($name)>0 && $frontend == 'true'){


                        $html .= '<span class="custom-field-section-edit">';
                            $html .= '<label for="'.$identificationName.'">'.$name.'</label>';



                            //here is where we do conditionals based on the field type
                            if($type == 'text'){
                                $html .= '<input type="text" name="'.$identificationName.'" value="'.get_user_meta($userId,$identificationName, true).'" class="custom-field-edit" /><br />';
                            }

                            if($type == 'textarea'){
                                $html .= '<textarea rows="4" type="text" name="'.$identificationName.'" class="custom-field-edit">'.get_user_meta($userId,$identificationName, true).'</textarea><br />';
                            }

                            if($type == 'select'){
                                $html .= '<select name="'.$identificationName.'" class="custom-field-edit">';

                                $html .= '<option value=""></option>';

                                    //explode the options
                                    $explodedSelectOptions = explode(',',$options);
                                    foreach($explodedSelectOptions as $selectOption){

                                        

                                        $selectOptionTrimmed = trim($selectOption);

                                        if( $selectOption == get_user_meta($userId,$identificationName, true) ){
                                            $html .= '<option value="'.$selectOptionTrimmed.'" selected="selected">'.$selectOptionTrimmed.'</option>';
                                        } else {
                                            $html .= '<option value="'.$selectOptionTrimmed.'">'.$selectOptionTrimmed.'</option>';
                                        }
                                        
                                    }

                                    $html .= '</select>';
                            }

                            if($type == 'date'){
                                $html .= '<input type="text" name="'.$identificationName.'" value="'.get_user_meta($userId,$identificationName, true).'" class="user-profile-date-selection custom-field-edit" /><br />';
                            }


                        $html .= '</span>';

                    }
                }
            }
        }



        //submit and cancel buttons - maybe these can be just circle icons to save space!
        $html .= '<span class="user-edit-form-action-buttons">';
            $html .= '<i data="'.esc_attr($userId).'" class="update-user-information icon-check"></i>';
            $html .= '<i class="cancel-update-user-information icon-close"></i>';
        $html .= '</span>';



    $html .= '</span>';

    // echo $html;
    return $html;

    
    // wp_die();    
}

// add_action( 'wp_ajax_update_member_information', 'wp_roster_update_member_information' );
// add_action( 'wp_ajax_nopriv_update_member_information', 'wp_roster_update_member_information' );


/**
* 
*
*
* update existing user data update
*/
function wp_roster_update_member_information_update_data(){
    
    //get variables
    $userId = intval($_POST['userId']);
    $firstName = wp_roster_sanitization_validation($_POST['firstName'],'name');
    $lastName = wp_roster_sanitization_validation($_POST['lastName'],'name');
    $email = wp_roster_sanitization_validation($_POST['email'],'email');
    $phone = wp_roster_sanitization_validation($_POST['phone'],'phone');
    $preference = wp_roster_sanitization_validation($_POST['preference'],'name');
    $customFields = sanitize_text_field($_POST['customFields']);
    
    if($phone == ''){
        $phone = 'true';
    }

    if($firstName == false || $lastName == false || $email == false || $phone == false || $preference == false){
        echo 'ERROR';
        wp_die();  
    }


    //we are good to continue

    //here we need to update the standard fields
    wp_update_user( array( 'ID' => $userId, 'first_name' => $firstName, 'last_name' => $lastName, 'display_name' => $firstName.' '.$lastName, 'nickname' => $firstName, 'user_email' => $email ) );


    //here we need to update the phone and preference
    //we dont need to do any checks we just do a straight update
    update_user_meta($userId,'wp-roster-preference', $preference);


    if( $phone == 'true' ){
        $phone = '';
    }

    // echo $phone;

    update_user_meta($userId,'wp-roster-phone', $phone);



    //now lets do custom fields
    if( strlen($customFields)>0 ){

        //explode the option
        $customFieldsExploded = explode('|||',$customFields);

        //cycle through the fields
        foreach($customFieldsExploded as $customField){

            if( strlen($customField)>0 ){

                $customFieldExploded = explode('^^',$customField);
                $fieldName = $customFieldExploded[0];
                $fieldValue = $customFieldExploded[1];

                //now lets update the option with the value
                update_user_meta($userId, $fieldName, $fieldValue); 

            }
        }
    }



    wp_die();    
}

add_action( 'wp_ajax_update_member_information_update_data', 'wp_roster_update_member_information_update_data' );
add_action( 'wp_ajax_nopriv_update_member_information_update_data', 'wp_roster_update_member_information_update_data' );


/**
* 
*
*
* member item builder
*/
function wp_roster_member_builder($id,$name){
    return '<li>
        <span class="builder-action-buttons"><i class="icon-cursor-move"></i><i class="icon-plus"></i><i class="icon-minus"></i></span>
        
        <select class="member-field" type="text" name="member-builder">
        
            <option value="'.esc_html($id).'" selected="selected">'.esc_html($name).'</option>
        
        </select>
    </li>';
}

/**
* 
*
*
* list item builder
*/

function wp_roster_list_builder($item,$toolTip){
    return '<li>
    
    <span class="builder-action-buttons">
        <i class="icon-cursor-move"></i>
        <i class="icon-plus"></i>
        <i class="icon-minus"></i>
    </span>
    
    <input placeholder="Item" class="list-field" type="text" name="list-builder" value="'.esc_html(stripslashes($item)).'">
    <input placeholder="Tooltip" class="list-field-tooltip" type="text" name="list-builder" value="'.htmlentities (stripslashes($toolTip)).'">
    
    </li>';
}


/**
* 
*
*
* Creates team line item
*/
function wp_roster_team_line_item($data,$rosterId){

    //99||||Team Awesome||||1||||list||||Item 1|||Item 2|||item 3

    //get team name
    //get roster settings
    $rosterSettings = wp_roster_individual_roster_settings($rosterId);
        

    //lets split the data
    $dataExploded = explode('||||',$data);

    $teamId = $dataExploded[0];
    $teamName = $dataExploded[1];
    $teamAllocations = $dataExploded[2];
    $teamType = $dataExploded[3];
    $teamItems = explode('|||',$dataExploded[4]);

    $html = '';

    $html .= '<li data="'.esc_attr($teamId).'">';

    $html .= '<span class="team-name filter-name">'.esc_html(stripslashes($teamName)).'</span>';
    
    $html .= '<span class="user-action-section">
                <i data="'.esc_attr($teamId).'" class="edit-team icon-pencil"></i>
                <i data="'.esc_attr($teamId).'" class="delete-team icon-trash"></i>
                <i class="icon-cursor-move"></i>
            </span>';

    $html .= '<span class="team-data-edit">';   

        //team name
        $html .= '<span class="team-name-section"><label for="teamName">'.esc_html(wp_roster_rename_team($rosterId,'title',false)).' name</label><input class="team-name-input" type="text" name="teamName" value="'.esc_html(stripslashes($teamName)).'"></span>';

        //team allocations
        $html .= '<span class="allocations-section"><label for="allocations">'.__('Allocations','wp-roster').'</label><input class="allocation-input" min="1" max="10" value="'.esc_html($teamAllocations).'" type="number" name="allocations"></span>';

        //team type
        $html .= '<span class="type-section"><label for="type">'.__('Type','wp-roster').'</label><select class="type-select" name="type">';
        
        $teamTypeOptions = array('list'=> __('List','wp-roster'), 'members'=> __('Members & ','wp-roster').wp_roster_rename_notification_groups($rosterId,'title',true), 'text'=> __('Text','wp-roster'), 'file'=> __('File','wp-roster'));


        

        foreach($teamTypeOptions as $key=>$value){

            if($key == $teamType){
                $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
            } else {
                $html .= '<option value="'.$key.'">'.$value.'</option>';

            }

        }
        $html .= '</select></span>';

        //members
        $html .= '<span class="member-section"><label for="member-builder">'.__('Add members','wp-roster').'</label><ul class="member-section">';

        //check if team type is set to members
        if($teamType == 'members'){


            //we are also going to put a count on this because if no members are in the list display a blank list item so they can start building again
            $countOfMemberListItems = 0;

            foreach($teamItems as $member){

                if($member !== ''){


                    //the member could be a notification group or member!
                    if (strpos($member, 'g') !== false) {
                        //its a notification group
                        $html .= wp_roster_member_builder($member,'');
                        $countOfMemberListItems++;
                    } else {
                        //its a person
                        //get user first and last name
                        $userObject = get_user_by( 'ID', $member);

                        //if the user exists add the user to the line otherwise the user has been deleted!
                        if($userObject !== false){
                            $userName = $userObject->first_name.' '.$userObject->last_name;
                            $html .= wp_roster_member_builder($member,$userName);
                            $countOfMemberListItems++;
                        }
                    }    
                }
            }

            //if no members in the list add a blank item
            if($countOfMemberListItems == 0){
                $html .= wp_roster_member_builder('','');
            }


            
        } else {
            $html .= wp_roster_member_builder('','');
        }

        $html .= '</ul></span>';

        //lists
        $html .= '<span class="list-section"><label for="list-builder">'.__('Add list items','wp-roster').'</label><ul class="list-section">';

        //check if team type is set to list
        if($teamType == 'list'){

            foreach($teamItems as $list){

                if($list !== ''){
                    //explode the list some more
                    $listItemsExploded = explode('^^',$list);

                    $html .= wp_roster_list_builder($listItemsExploded[0],$listItemsExploded[1]);
                }
  
            }
            
        } else {
            $html .= wp_roster_list_builder('','');
        }

        $html .= '</ul></span>';




    
    
    $html .= '</span>';   

    $html .= '</li>';


    return $html;

}   




/**
* 
*
*
* add team
*/
function wp_roster_add_team(){
    
    //get variables
    $teamName = wp_roster_sanitization_validation($_POST['teamName'],'name');
    $allocations = intval($_POST['allocations']);
    $type = wp_roster_sanitization_validation($_POST['type'],'name');
    $builderItems = $_POST['builderItems']; //unfortunately we can't sanitize this because we want to allow HTML
    $rosterId = intval($_POST['rosterId']);


    if( $teamName == false || ($type != 'list' && $type != 'members' && $type != 'text' && $type != 'file') ){
        echo 'ERROR';
        wp_die();  
    }

    //lets construct the string and return the list item
    $teamId = wp_roster_data_counter('team');

    $data = $teamId.'||||'.$teamName.'||||'.$allocations.'||||'.$type.'||||'.$builderItems;

    echo wp_roster_team_line_item($data,$rosterId);


    wp_die();    
}

add_action( 'wp_ajax_add_team', 'wp_roster_add_team' );
add_action( 'wp_ajax_nopriv_add_team', 'wp_roster_add_team' );





/**
* 
*
*
* add notification group
*/
function wp_roster_add_notification_group(){
    
    //get variables
    $teamName = wp_roster_sanitization_validation($_POST['teamName'],'name');
    $rosterId = intval($_POST['rosterId']);
    $builderItems = sanitize_text_field($_POST['builderItems']);
    $builderItemsLeader = sanitize_text_field($_POST['builderItemsLeader']);


    if($teamName == false){
        echo 'ERROR';
        wp_die();  
    }


    //lets construct the string and return the list item
    $teamId = wp_roster_data_counter('notification-group');

    $data = $teamId.'||||'.$teamName.'||||'.$builderItems.'||||'.$builderItemsLeader;

    echo wp_roster_notification_group_line_item($data,$rosterId);

    wp_die();    
}

add_action( 'wp_ajax_add_notification_group', 'wp_roster_add_notification_group' );
add_action( 'wp_ajax_nopriv_add_notification_group', 'wp_roster_add_notification_group' );


/**
* 
*
*
* Creates notification group line item
*/
function wp_roster_notification_group_line_item($data,$rosterId){

    //99||||Team Awesome||||1||||list||||Item 1|||Item 2|||item 3

    //lets split the data
    $dataExploded = explode('||||',$data);

    $teamId = $dataExploded[0];
    $teamName = $dataExploded[1];
    $teamItems = explode('|||',$dataExploded[2]);
    $teamItemsLeader = explode('|||',$dataExploded[3]);

    // var_dump($teamItemsLeader);
    // var_dump($teamItems);

    $html = '';

    if (strpos($teamId, 'g') !== false) {
        $html .= '<li data="'.esc_attr($teamId).'">';
    } else {
        $html .= '<li data="g'.esc_attr($teamId).'">';
    }    

    




    $html .= '<span class="team-name filter-name">'.esc_html(stripslashes($teamName)).'</span>';
    
    $html .= '<span class="user-action-section">
                <i data="'.esc_attr($teamId).'" class="edit-notification-group icon-pencil"></i>
                <i data="'.esc_attr($teamId).'" class="delete-notification-group icon-trash"></i>
                <i class="icon-cursor-move"></i>
            </span>';

    $html .= '<span class="notification-group-data-edit">';   

        //team name
        $html .= '<span class="notification-group-name-section"><label for="notificationGroupName">'.wp_roster_rename_notification_groups($rosterId,'title',false).__(' name','wp-roster').'</label><input class="notification-group-name-input" type="text" name="notificationGroupName" value="'.esc_html(stripslashes($teamName)).'"></span>';

        //leaders
        $html .= '<span class="member-section-leader"><label for="member-builder">'.__('Add leaders','wp-roster').'</label><ul class="member-section">';

            $countOfNotificationListItems = 0;

            foreach($teamItemsLeader as $member){
                if($member !== ''){
                    //get user first and last name
                    $userObject = get_user_by( 'ID', $member);

                    //if the user exists add the user to the line otherwise the user has been deleted!
                    if($userObject !== false){
                        $userName = $userObject->first_name.' '.$userObject->last_name;
                        $html .= wp_roster_member_builder($member,$userName);
                        $countOfNotificationListItems++;
                    }


                }
            }

            if($countOfNotificationListItems == 0){
                $html .= wp_roster_member_builder('','');
            }
       

        $html .= '</ul></span>';


        //members
        $html .= '<span class="member-section"><label for="member-builder">'.__('Add members','wp-roster').'</label><ul class="member-section">';

            $countOfNotificationListItems = 0;

            foreach($teamItems as $member){
                if($member !== ''){
                    //get user first and last name
                    $userObject = get_user_by( 'ID', $member);

                    //if the user exists add the user to the line otherwise the user has been deleted!
                    if($userObject !== false){
                        $userName = $userObject->first_name.' '.$userObject->last_name;
                        $html .= wp_roster_member_builder($member,$userName);
                        $countOfNotificationListItems++;
                    }


                }
            }

            if($countOfNotificationListItems == 0){
                $html .= wp_roster_member_builder('','');
            }
       

        $html .= '</ul></span>';


    $html .= '</span>';   

    $html .= '</li>';


    return $html;

}  



/**
* 
*
*
* renames the team based on specifications - accepts case uppercase, lowercase and title  - accepts plural true or false
*/
function wp_roster_rename_team($rosterId,$case,$plural){

    //first lets get the rosters settings
    $rosterSettings = wp_roster_individual_roster_settings($rosterId);
        
    //team translation
    if($rosterSettings[4] == ' ' ){
        $name = __('Teams','wp-roster');
    } else {
        $name = $rosterSettings[4];
    }


    if($plural === false){

        //if string contains ies at the end, replace it with a y
        //get the last 3 letters
        $lastThreeLetters = substr($name, -3);

        if(strtolower($lastThreeLetters) == 'ies' ){
            $name = str_replace("ies","y",$name);
        } else {
            //else just remove the s
            $name = substr($name, 0, -1);
        }

    } //if its not plural we will just leave it to how things are


    //lets do case replacement
    if($case == 'lowercase'){
        $name = strtolower($name);
    } elseif ($case == 'uppercase'){
        $name = strtoupper($name);
    } else {
        //it is title case
        $name = ucwords($name);
    }

    return $name;

}    
/**
* 
*
*
* renames the notification based on specifications - accepts case uppercase, lowercase and title  - accepts plural true or false
*/
function wp_roster_rename_notification_groups($rosterId,$case,$plural){

    //first lets get the rosters settings
    $rosterSettings = wp_roster_individual_roster_settings($rosterId);
        
    //team translation
    if($rosterSettings[14] == ' ' ){
        $name = __('Notification Groups','wp-roster');
    } else {
        $name = $rosterSettings[14];
    }


    if($plural === false){

        //if string contains ies at the end, replace it with a y
        //get the last 3 letters
        $lastThreeLetters = substr($name, -3);

        if(strtolower($lastThreeLetters) == 'ies' ){
            $name = str_replace("ies","y",$name);
        } else {
            //else just remove the s
            $name = substr($name, 0, -1);
        }

    } //if its not plural we will just leave it to how things are


    //lets do case replacement
    if($case == 'lowercase'){
        $name = strtolower($name);
    } elseif ($case == 'uppercase'){
        $name = strtoupper($name);
    } else {
        //it is title case
        $name = ucwords($name);
    }

    return $name;

}    


//
/**
* 
*
*
* get leaders of a notification groups - returns an array of ids of leaders
*/
function wp_roster_get_leaders_of_notification_groups($rosterId){

    $data = get_option('wp_roster_data_'.$rosterId);
    //get the teams data
    $teamData = $data['teams'];

    //we need to get the matching team id that matches $teamSelection 
    //lets explode the data to separate the notification groups from the teams
    $notificationTeamSplit = explode('||||||',$teamData);

    //we are going to do a preloop to assist us with notification groups
    $notificationGroupsDataExploded = explode('|||||',$notificationTeamSplit[1]);


    $idsOfLeadersOfNotificationGroups = array();

    foreach($notificationGroupsDataExploded as $notificationGroup){

        if(strlen($notificationGroup)>0){

            $notificationGroupParameters = explode('||||',$notificationGroup);

            $notificationGroupLeaderIdsString = $notificationGroupParameters[3];
            
            //lets loop through the leaders and just add them to array simply
            //explode the leaders
            $explodedLeaders = explode('|||',$notificationGroupLeaderIdsString);

            foreach($explodedLeaders as $leader){
                if( strlen($leader) > 0 ){
                    array_push($idsOfLeadersOfNotificationGroups,intval($leader));
                }
            }

        }        
    }

    return array_unique($idsOfLeadersOfNotificationGroups);

}


/**
* 
*
*
* add file to roster
*/
function wp_roster_add_file_to_roster(){
    
    //get variables
    if(isset($_FILES['attachment'])){
            
        $uploadedFile = $_FILES['attachment']; 

        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }



        $upload_overrides = array( 'test_form' => false );
        $moveFile = wp_handle_upload( $uploadedFile, $upload_overrides );



        if ( $moveFile && ! isset( $moveFile['error'] ) ) {

            $filePath = $moveFile['file'];
            $fileType = wp_check_filetype( basename( $filePath ), null );

            $wp_upload_dir = wp_upload_dir();

            $attachmentData = array(
                'guid'           => $wp_upload_dir['url'] . '/' . basename( $filePath ), 
                'post_mime_type' => $fileType['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filePath ) ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            $attach_id = wp_insert_attachment( $attachmentData, $filePath);

            require_once( ABSPATH . 'wp-admin/includes/image.php' );

            $attach_data = wp_generate_attachment_metadata($attach_id, $filePath);

            wp_update_attachment_metadata($attach_id, $attach_data);

            $imageURL = wp_get_attachment_image_src( $attach_id, 'full', false);
                        
        } else {

        }


    }
    
    echo $imageURL[0];




    wp_die();    
}

add_action( 'wp_ajax_add_file_to_roster', 'wp_roster_add_file_to_roster' );
add_action( 'wp_ajax_nopriv_add_file_to_roster', 'wp_roster_add_file_to_roster' );




?>