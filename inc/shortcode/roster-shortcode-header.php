<?php
    function wp_roster_roster_header($rosterId,$page){

        //get roster settings
        $options = get_option('wp_roster_settings');


        $rosterSettings = wp_roster_individual_roster_settings($rosterId);

        //print_r($rosterSettings);

        //start output
        $html = '';

        $html .= '<div data="'.esc_attr($rosterId).'" class="roster-header">';


            //left main menu
            $html .= '<div class="roster-header-left">';

                //if there's a logo output a logo otherwise output the rostername
                if(strlen($rosterSettings[2]) > 1){
                    $logo = '<img src="'.esc_url($rosterSettings[2]).'" alt="'.esc_attr($rosterSettings[1]).'" class="roster-logo" />';
                } else {
                    $logo = $rosterSettings[1];   
                }


                // $html .= '<h1>'.$rosterSettings[1].'</h1>';
                global $wp;
                $current_url = home_url( add_query_arg( array(), $wp->request ) );

                //get leaders of notification groups so we can enable them access to attendance as well
                $leadersOfNotificationGroups = wp_roster_get_leaders_of_notification_groups($rosterId);

                $currentUserId = get_current_user_id();

                // var_dump($leadersOfNotificationGroups);
                // var_dump($currentUserId);
                // var_dump($page);





                $html .= '<ul class="roster-main-menu">';

                    //this will hold an array which contains the page value as key and then an array with the output value and the permission view settings from the roster settings and also whether it is a pro item or not
                    $menuItems = array('roster'=> array($logo,$rosterSettings[6],false), 'teams'=> array(wp_roster_rename_team($rosterId,'title',true),$rosterSettings[9],false), 'dates'=> array(__('Dates','wp-roster'),$rosterSettings[8],false), 'notifications'=> array(__('Notifications','wp-roster'),$rosterSettings[12],true), 'run-sheet'=> array(__('Run Sheet','wp-roster'),$rosterSettings[13],true), 'attendance'=> array(__('Attendance','wp-roster'),$rosterSettings[15],true), 'history'=> array(__('History','wp-roster'),$rosterSettings[10],false)   );

                    $currentUser = wp_get_current_user();
                    $userRoles = $currentUser->roles;

                    if( empty($userRoles) ){
                        $userRoles = array(0);
                    }

                    $permissions = array('guest'=> array(0,'wp_roster_member','editor','administrator'),'roster-member'=> array('wp_roster_member','editor','administrator'),'editor'=> array('editor','administrator'),'administrator'=> array('administrator'));

                    

                    global $wp_roster_is_pro;

                    $html .= '<li class="mobile-only"><i class="icon-close"></i></li>';

                    foreach($menuItems as $key=>$value){

                        if($key == $page){
                            $class = 'active';
                            // $url = '#';
                            $url = $current_url.'?roster-page='.$key;   
                        } else {
                            $class = ''; 
                            $url = $current_url.'?roster-page='.$key;    
                        }
                        
                        if(!is_array( $permissions[$menuItems[$key][1]] )){
                            $permissions_array = array();
                        } else {
                            $permissions_array = $permissions[$menuItems[$key][1]];
                        }

                        $intersectionBetweenRolesAndPermissions = array_intersect($userRoles, $permissions_array);

                        //we only want to output pages to particular roles or if attendance and user is a leader of notification group
                        if(!empty($intersectionBetweenRolesAndPermissions) || ($key == 'attendance' && in_array($currentUserId,$leadersOfNotificationGroups))   ){

                            //dont show notifications tab if not pro or run sheet or attendance
                            $isMenuItemPro = $menuItems[$key][2];

                            if($isMenuItemPro){
                                //its a pro menu item
                                if($wp_roster_is_pro == 'YES'){
                                    $html .= '<li class="menu-item-'.esc_attr($key).'"><a data="'.esc_attr($key).'" class="'.esc_attr($class).'" href="'.esc_url($url).'">'.$value[0].'</a></li>';    
                                }

                            } else {
                                //its not pro
                                $html .= '<li class="menu-item-'.esc_attr($key).'"><a data="'.esc_attr($key).'" class="'.esc_attr($class).'" href="'.esc_url($url).'">'.$value[0].'</a></li>';
                            }


                        }

                    }

                $html .= '</ul>';
            $html .= '</div>';








            //right menu
            $html .= '<div class="roster-header-right">';

                $html .= '<ul class="roster-right-menu">';   
                
                    //display menu link
                    $html .= '<li class="mobile-menu"><a href="#"><i class="icon-menu"></i></a></li>';

                    //only download link if it is the main roster page
                    if($page == '' || $page == 'roster'){
                        $html .= '<li><a href="#"><i title="'.__('Download PDF','wp-roster').'" class="download-pdf icon-arrow-down-circle"></i></a></li>';
                    }

                    //only display home link if it is requested in the settings
                    if(strlen($rosterSettings[3])>1){
                        $html .= '<li><a href="'.esc_url($rosterSettings[3]).'"><i title="'.__('Visit home page','wp-roster').'" class="icon-home"></i></a></li>';
                    }

                    //only display settings if admin
                    if(in_array('administrator',$userRoles)){
                        $html .= '<li><a href="'.get_admin_url(null,'admin.php?page=wp_roster').'"><i title="'.__('Edit roster settings','wp-roster').'" class="icon-settings"></i></a></li>';
                    }

                    //do profile image
                    $html .= '<li><a href="'.get_admin_url(null,'profile.php').'"><img title="'.__('Edit profile','wp-roster').'" data="'.$currentUserId.'" class="user-profile-image" src="'.wp_roster_get_user_avatar($currentUserId).'" /></a></li>';

                    //do save button
                    //dont show save settings button on history page because theres nothing to save on the history 

                    if($page !== 'history' ){

                        
                        //we need to figure out if the person can edit unavailability or edit roster

                        if(!is_array( $permissions[$rosterSettings[11]] )){
                            $permissions_array_two = array();
                        } else {
                            $permissions_array_two = $permissions[$rosterSettings[11]];
                        }

                        if(!is_array( $permissions[$rosterSettings[7]] )){
                            $permissions_array_three = array();
                        } else {
                            $permissions_array_three = $permissions[$rosterSettings[7]];
                        }

                        $editUnavailabilityPermission = array_intersect($userRoles, $permissions_array_two);
                        $editRosterPermission = array_intersect($userRoles, $permissions_array_three);

                        if( empty($editUnavailabilityPermission) && empty($editRosterPermission) ){

                        } else {
                            $html .= '<li><button class="save-settings"><i class="icon-check"></i> <span>'.__('Save','wp-roster').'</span></button></li>';
                        }

                    }

                $html .= '</ul>';

            $html .= '</div>';

        $html .= '</div>';


        return $html;
    }
?>