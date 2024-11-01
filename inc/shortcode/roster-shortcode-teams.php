<?php
    function wp_roster_roster_teams($rosterId) {

        //get roster settings
        $rosterSettings = wp_roster_individual_roster_settings($rosterId);



        
        $html = '';


        //lets create a navigation menu
        $html .= '<div style="text-align: center;padding-bottom: 0px; margin-bottom: -80px;" class="roster-container">';
            $html .= '<ul class="teams-menu-navigation">';

                $html .= '<li class="active" data="members" >'.__('Members','wp-roster').' <i class="icon-info" title="'.__('Used to add members to the system. Members can be added to '.wp_roster_rename_team($rosterId,'title',true).' or '.wp_roster_rename_notification_groups($rosterId,'title',true).'.','wp-roster').'"></i></li>';

                $html .= '<li data="notification-groups" >'.wp_roster_rename_notification_groups($rosterId,'title',true).' <i class="icon-info" title="'.__(wp_roster_rename_notification_groups($rosterId,'title',true).' are optional but enable you to create groups of members and then assign these groups in the '.wp_roster_rename_team($rosterId,'title',true).' tab. By doing this it enables a whole group of members to receive a notification by just selecting the group on the roster line item. This can be necessary if the line item could be assigned to a number of different '.wp_roster_rename_notification_groups($rosterId,'title',true).' and instead of having to remember all the '.wp_roster_rename_notification_groups($rosterId,'title',false).' members you just select the '.wp_roster_rename_notification_groups($rosterId,'title',false).' and everyone in the group will receive the notification. '.wp_roster_rename_notification_groups($rosterId,'title',true).' are also used for attendance, so leaders of '.wp_roster_rename_notification_groups($rosterId,'title',true).' can login to the system and record attendance for their '.wp_roster_rename_notification_groups($rosterId,'title',false).'.','wp-roster').'"></i></li>';

                $html .= '<li data="teams" >'.wp_roster_rename_team($rosterId,'title',true).' <i class="icon-info" title="'.__(wp_roster_rename_team($rosterId,'title',true).' are row items that show on your main roster tab. '.wp_roster_rename_team($rosterId,'title',true).' can be either list items (so you can choose from a list), text items (so you can enter any text you want), or member items (so you can choose members or '.wp_roster_rename_notification_groups($rosterId,'title',true).').','wp-roster').'"></i></li>';

            $html .= '</ul>';
        $html .= '</div>';    







        //members section
        $html .= '<div class="roster-container members-section">';

            //$html .= '<h2>'.__('Members','wp-roster').'</h2>';

            $html .= '<div class="feature-box">'; 
                $html .= '<h2 class="expandable-section-activate"><i class="icon-plus"></i> '.__('Add member','wp-roster').'</h2>';    

                $html .= '<div class="expandable-section">';
                    //first name
                    $html .= '<span class="first-name-section">';
                    $html .= '<label for="firstName">'.__('First name','wp-roster').'</label>';
                    $html .= '<input class="first-name-input" type="text" name="firstName">';
                    $html .= '</span>';

                    //last name
                    $html .= '<span class="last-name-section">';
                    $html .= '<label for="lastName">'.__('Last name','wp-roster').'</label>';
                    $html .= '<input class="last-name-input" type="text" name="lastName">';
                    $html .= '</span>';

                    //email
                    $html .= '<span class="email-section">';
                    $html .= '<label for="email">'.__('Email','wp-roster').'</label>';
                    $html .= '<input class="email-input" type="text" name="email">';
                    $html .= '</span>';

                    global $wp_roster_is_pro;

                    if($wp_roster_is_pro == "YES"){
                        //phone
                        $html .= '<span class="phone-section">';
                        $html .= '<label for="phone">'.__('Phone','wp-roster').'</label>';
                        $html .= '<input placeholder="+61400000000" class="phone-input" type="text" name="phone">';
                        $html .= '</span>';

                        //preferred communication method
                        //type
                        $html .= '<span class="preference-section">';
                        $html .= '<label for="preference">'.__('Preferred communication method','wp-roster').'</label>';
                        $html .= '<select class="preference-select" name="preference">';

                            $html .= '<option value="sms">'.__('SMS','wp-roster').'</option>';
                            $html .= '<option value="email">'.__('Email','wp-roster').'</option>';
                            $html .= '<option value="both">'.__('SMS & Email','wp-roster').'</option>';
                            $html .= '<option value="none">'.__('None','wp-roster').'</option>';

                        $html .= '</select>';
                        $html .= '</span>';

                    }


                    //now lets add custom fields
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


                                    $html .= '<span class="custom-field-section">';
                                        $html .= '<label for="'.$identificationName.'">'.$name.'</label>';



                                        //here is where we do conditionals based on the field type
                                        if($type == 'text'){
                                            $html .= '<input type="text" name="'.$identificationName.'" value="" class="custom-field-add" /><br />';
                                        }

                                        if($type == 'textarea'){
                                            $html .= '<textarea rows="4" type="text" name="'.$identificationName.'" class="custom-field-add"></textarea><br />';
                                        }

                                        if($type == 'select'){
                                            $html .= '<select name="'.$identificationName.'" class="custom-field-add">';

                                                $html .= '<option value=""></option>';

                                                //explode the options
                                                $explodedSelectOptions = explode(',',$options);
                                                foreach($explodedSelectOptions as $selectOption){

                                                    $selectOptionTrimmed = trim($selectOption);

                                                    $html .= '<option value="'.$selectOptionTrimmed.'">'.$selectOptionTrimmed.'</option>';
                                                    
                                                }

                                                $html .= '</select>';
                                        }

                                        if($type == 'date'){
                                            $html .= '<input type="text" name="'.$identificationName.'" value="" class="user-profile-date-selection custom-field-add" /><br />';
                                        }


                                    $html .= '</span>';

                                }
                            }
                        }
                    }



                    

                    //button
                    $html .= '<span class="button-section">';
                    $html .= '<button class="add-a-member-button secondary-button">'.__('Add member','wp-roster').'</button>';
                    $html .= '</span>';

                $html .= '</div>';    

            $html .= '</div>'; 



            //start filter
            $html .= '<input data="user-listing" class="item-filter item-filter-teams" type="text" placeholder="'.__('Filter items','wp-roster').'"><i class="icon-magnifier search-icon"></i>';


            //here we will list out individual people
            $html .= '<ul class="user-listing">'; 

                //lets loop through our people
                
                $args = array(
                    'role'    => 'wp_roster_member',
                    'orderby' => 'display_name',
                    'order'   => 'ASC'
                );
            
                $users = get_users( $args );
    
                foreach ( $users as $user ) {

                    

                    //its important that we do a check after the query to see if their meta matches the roster id
                    $usersRosterAllocation = get_user_meta( $user->ID,'wp-roster-roster-allocation',true);

                    // print_r($usersRosterAllocation );

                    //lets split the allocation
                    // $userRosterAllocationExploded = explode('||',$usersRosterAllocation);

                    if(in_array($rosterId,$usersRosterAllocation)){
                        $html .= wp_roster_user_line_item($user->ID);
                    }
   
                }

            $html .= '</ul>'; 

        $html .= '</div>';

















        //teams section
        $html .= '<div class="roster-container teams-section">';

            $html .= '<div class="feature-box">'; 
                $html .= '<h2 class="expandable-section-activate"><i class="icon-plus"></i> '.__('Add','wp-roster').' '.esc_html(wp_roster_rename_team($rosterId,'lowercase',false)).'</h2>';    
                
                $html .= '<div class="expandable-section">';
                    //team name
                    $html .= '<span class="team-name-section">';
                    $html .= '<label for="teamName">'.esc_html(wp_roster_rename_team($rosterId,'title',false)).' name</label>';
                    $html .= '<input class="team-name-input" type="text" name="teamName">';
                    $html .= '</span>';

                    //allocations
                    $html .= '<span class="allocations-section">';
                    $html .= '<label for="allocations">'.__('Allocations','wp-roster').' <i title="'.__('Allocations are the amount of times you want the team to be shown on the main roster page. To give you a practical example of when multiple allocations come in handy is when you have an event that might have multiple singers. Instead of creating a separate team for each singer allotment on your roster and having to add the same group of singers to each team, you can simply create an allocation of 5 for example and the singers team will be shown 5 times on your main roster page with the same group of singers to choose from.','wp-roster').'" class="icon-info field-explainer "></i></label>';
                    $html .= '<input class="allocation-input" min="1" max="10" value="1" type="number" name="allocations">';
                    $html .= '</span>';

                    //type
                    $html .= '<span class="type-section">';
                    $html .= '<label for="type">'.__('Type','wp-roster').' <i title="'.__('The type is the type of data you want to have on the main roster page. For most teams you are going to probably select members as this will enable you to choose a member for each date on the roster tab. But let\'s say your event has songs then you may create a list item that way you can add songs and choose specific songs for your date. Or perhaps your event has a topic in which case you may just want a text field where you can just write whatever text you want.','wp-roster').'" class="icon-info field-explainer "></i></label>';
                    $html .= '<select class="type-select" name="type">';

                        //we start with the list that way we can populate new members into the select fields on the change
                        $html .= '<option value="list">'.__('List','wp-roster').'</option>';
                        $html .= '<option value="members">'.__('Members & ','wp-roster').wp_roster_rename_notification_groups($rosterId,'title',true).'</option>';
                        $html .= '<option value="text">'.__('Text','wp-roster').'</option>';
                        $html .= '<option value="file">'.__('File','wp-roster').'</option>';
                        

                    $html .= '</select>';
                    $html .= '</span>';

                    //list
                    $html .= '<span class="list-section">';
                        $html .= '<label for="list-builder">'.__('Add list items','wp-roster').'</label>';
                        $html .= '<ul class="list-section">';
                            $html .= '<li>';

                                $html .= '<span class="builder-action-buttons">';
                                $html .= '<i class="icon-cursor-move"></i>';
                                $html .= '<i class="icon-plus"></i>';
                                $html .= '<i class="icon-minus"></i>';
                                $html .= '</span>';

                                $html .= '<input placeholder="'.__('Item','wp-roster').'" class="list-field" type="text" name="list-builder">';

                                $html .= '<input placeholder="'.__('Tooltip','wp-roster').'" class="list-field-tooltip" type="text" name="list-builder">';

                            $html .= '</li>';
                        $html .= '</ul>';
                    $html .= '</span>';



                    //members
                    $html .= '<span class="member-section">';

                    $html .= '<label for="member-builder">'.__('Add Members & ','wp-roster').wp_roster_rename_notification_groups($rosterId,'title',true).'</label>';
                        $html .= '<ul class="member-section">';
                            $html .= '<li>';

                                $html .= '<span class="builder-action-buttons">';
                                $html .= '<i class="icon-cursor-move"></i>';
                                $html .= '<i class="icon-plus"></i>';
                                $html .= '<i class="icon-minus"></i>';
                                $html .= '</span>';

                                $html .= '<select class="member-field" type="text" name="member-builder">';

                                $html .= '</select>';

                            $html .= '</li>';
                        $html .= '</ul>';
                    $html .= '</span>';


                    //button
                    $html .= '<span class="button-section">';
                    $html .= '<button class="add-a-team-button secondary-button">'.__('Add','wp-roster').' '.esc_html(wp_roster_rename_team($rosterId,'title',false)).'</button>';
                    $html .= '</span>';

                $html .= '</div>';
            $html .= '</div>';

        
            //start filter
            $html .= '<input data="team-listing" class="item-filter item-filter-teams" type="text" placeholder="'.__('Filter items','wp-roster').'"><i class="icon-magnifier search-icon"></i>';    

            $html .= '<ul class="team-listing" id="team-listing">'; 

                //get saved data
                $data = get_option('wp_roster_data_'.$rosterId);
                //get the teams data
                $teamsData = $data['teams'];

                if(isset($teamsData)){

                    //lets explode the data to separate the notification groups from the teams
                    $notificationTeamSplit = explode('||||||',$teamsData);

                    //lets explode the data
                    $teamsDataExploded = explode('|||||',$notificationTeamSplit[0]);

                    //cycle through each data
                    foreach($teamsDataExploded as $teamInfo){

                        if(strlen($teamInfo)>0){
                            $html .= wp_roster_team_line_item($teamInfo,$rosterId);
                        }
                    }
                }
                    
            $html .= '</ul>';        

       
        $html .= '</div>';









        //notification groups section
        $html .= '<div class="roster-container notification-groups-section">';
            $html .= '<div class="feature-box">'; 
                $html .= '<h2 class="expandable-section-activate"><i class="icon-plus"></i> '.__('Add','wp-roster').' '.wp_roster_rename_notification_groups($rosterId,'title',false).'</h2>';    
                
                $html .= '<div class="expandable-section">';

                    //team name
                    $html .= '<span class="notification-group-name-section">';
                        $html .= '<label for="notificationGroupName">'.wp_roster_rename_notification_groups($rosterId,'title',false).' '.__('name','wp-roster').'</label>';
                        $html .= '<input class="notification-group-name-input" type="text" name="notificationGroupName">';
                    $html .= '</span>';


                     //members
                     $html .= '<span class="notification-leader-section">';

                     $html .= '<label for="member-builder">'.__('Add leaders','wp-roster').'</label>';
                         $html .= '<ul class="member-section">';
                             $html .= '<li>';
 
                                 $html .= '<span class="builder-action-buttons">';
                                 $html .= '<i class="icon-cursor-move"></i>';
                                 $html .= '<i class="icon-plus"></i>';
                                 $html .= '<i class="icon-minus"></i>';
                                 $html .= '</span>';
 
                                 $html .= '<select class="member-field" type="text" name="member-builder">';
 
                                 $html .= '</select>';
 
                             $html .= '</li>';
                         $html .= '</ul>';
                     $html .= '</span>';


                    //members
                    $html .= '<span class="notification-member-section">';

                    $html .= '<label for="member-builder">'.__('Add members','wp-roster').'</label>';
                        $html .= '<ul class="member-section">';
                            $html .= '<li>';

                                $html .= '<span class="builder-action-buttons">';
                                $html .= '<i class="icon-cursor-move"></i>';
                                $html .= '<i class="icon-plus"></i>';
                                $html .= '<i class="icon-minus"></i>';
                                $html .= '</span>';

                                $html .= '<select class="member-field" type="text" name="member-builder">';

                                $html .= '</select>';

                            $html .= '</li>';
                        $html .= '</ul>';
                    $html .= '</span>';


                    //button
                    $html .= '<span class="button-section">';
                    $html .= '<button class="add-a-notification-group-button secondary-button">'.__('Add','wp-roster').' '.wp_roster_rename_notification_groups($rosterId,'title',false).'</button>';
                    $html .= '</span>';

                $html .= '</div>';
            $html .= '</div>';

            
            //start filter
            $html .= '<input data="notification-group-listing" class="item-filter item-filter-teams" type="text" placeholder="'.__('Filter items','wp-roster').'"><i class="icon-magnifier search-icon"></i>';

            $html .= '<ul class="notification-group-listing" id="notification-group-listing">'; 

                //need to do work here

                //get saved data
                $data = get_option('wp_roster_data_'.$rosterId);
                //get the teams data
                $teamsData = $data['teams'];

                if(isset($teamsData)){

                    //lets explode the data to separate the notification groups from the teams
                    $notificationTeamSplit = explode('||||||',$teamsData);

                    //lets explode the data
                    $teamsDataExploded = explode('|||||',$notificationTeamSplit[1]);

                    //cycle through each data
                    foreach($teamsDataExploded as $teamInfo){

                        if(strlen($teamInfo)>0){
                            $html .= wp_roster_notification_group_line_item($teamInfo,$rosterId);
                        }
                    }
                }
                    
            $html .= '</ul>';  




        $html .= '</div>';


        return $html;

    }
?>