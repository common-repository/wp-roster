<?php
    function wp_roster_roster_home($rosterId) {

        //get roster settings
        $rosterSettings = wp_roster_individual_roster_settings($rosterId);

        //get roster data
        $data = get_option('wp_roster_data_'.$rosterId);
        //get the date data
        $dateData = $data['dates'];
        //get the teams data
        $teamData = $data['teams'];
        //get the roster data
        $rosterData = $data['roster'];


        //get the existing settings and turn it into a usable form
        //split to fields
        $rosterDataFields = explode('|||||',$rosterData);

        $rosterDataArray = array();

        foreach($rosterDataFields as $rosterDataField){

            //explode further
            $rosterDataFieldExplode = explode('^^',$rosterDataField);

            $rosterDataFieldAllocation = $rosterDataFieldExplode[0];
            $rosterDataFieldTeam = $rosterDataFieldExplode[1];
            $rosterDataFieldDate = $rosterDataFieldExplode[2];
            $rosterDataFieldValue = $rosterDataFieldExplode[3];

            // print_r($rosterDataFieldValue);
            // print_r($rosterDataFieldTeam.'-'.$rosterDataFieldDate);

            //lets push this to the array
            $rosterDataArray[$rosterDataFieldAllocation.'-'.$rosterDataFieldTeam.'-'.$rosterDataFieldDate] = $rosterDataFieldValue; 

        }

        


        //get all team members and put into an associative array based on id
        $rosterMembers = array();

        $args = array(
            'role' => 'wp_roster_member',
        ); 
        $allWpRosterUsers = get_users( $args );

        foreach ( $allWpRosterUsers as $rosterMember ) {

            $userId = $rosterMember->ID;    
            $userName = $rosterMember->first_name.' '.$rosterMember->last_name;

            //we do want to filter these users so we can use them for the unavailability columns
            

            if(get_user_meta($userId,'wp-roster-roster-allocation', true)){
                $existingRosterAllocation = get_user_meta($userId,'wp-roster-roster-allocation', true);
                //only add the person if they have the roster id in their meta
                if(in_array($rosterId,$existingRosterAllocation)){
                    $rosterMembers[$userId] = $userName;
                }
            }

            
        }    




        //now lets add our notification groups to the same array - very sneaky of me
        $notificationTeamSplit = explode('||||||',$teamData);

        //lets explode the data
        $teamsDataExploded = explode('|||||',$notificationTeamSplit[1]);

        //  |||||g18||||My Group||||33|||27|||26|||25


        foreach ( $teamsDataExploded as $notificationGroup ) {


            if(strlen($notificationGroup)>0){

                $explodeNotificationGroupParameter = explode('||||',$notificationGroup);

                $notificationGroupId = $explodeNotificationGroupParameter[0];
                $notificationGroupName = $explodeNotificationGroupParameter[1];

                $rosterMembers[$notificationGroupId] = $notificationGroupName;

            }

        }    






        //start output
        $html = '';

        //only do stuff if data is found
        if(isset($dateData) && isset($teamData)){


            //dates id array
            $datesIdArray = array();



            //lets create an outer container
            $html .= '<div id="roster-container">';


                $html .= '<table>';  
                    //tabe head
                    $html .= '<thead>'; 

                        $html .= '<tr>'; 

                            $html .= '<th class="team-heading">'; 
                                $html .= esc_html(stripslashes(wp_roster_rename_team($rosterId,'title',true))); 
                                //do now icon
                                $html .= '<i title="'.__('Zoom to next date','wp-roster').'" class="icon-exclamation now-icon"></i>';
                            $html .= '</th>'; 

                            //get current date
                            $currentTime = current_time('timestamp');

                            //loop through dates
                            //now we need to loop through our dates and sort them
                            //explode data
                            $explodedDates = explode('||',$dateData);

                            $sortArray = array();

                            $pastDatesArray = array();

                            //cycle through each date
                            foreach($explodedDates as $date){

                                if(strlen($date)>0){

                                    //explode again
                                    $dateProperties = explode('^^',$date);

                                    $key = strtotime($dateProperties[1]);

                                    //lets add this to our sort array
                                    $sortArray[$key] = $dateProperties;

                                    if($currentTime > $key){
                                        array_push($pastDatesArray,$dateProperties[0]);
                                    }

                                }
                            }

                            //not lets sort by array key
                            ksort($sortArray);

                            $nextDate = '';

                            //lets determine the id of the next date
                            foreach($sortArray as $key=>$value){
                                if($currentTime < strtotime($value[1])){
                                    $nextDate = $value[0];
                                    break;
                                }
                            }    

                            

                            //now lets cycle through the new array and output the actual data
                            foreach($sortArray as $key=>$value){

                                //id
                                $dateId = $value[0];
                                //date
                                $dateTime = strtotime($value[1]);
                                //label
                                $label = $value[2];

                                //lets push the id to the array
                                array_push($datesIdArray,$dateId);

                                $class = '';
                                if(in_array($dateId,$pastDatesArray)){
                                    $class .= 'past-date ';    
                                }

                                if($dateId == $nextDate){
                                    $class .= 'now '; 
                                }

                                //to assist with the PDF export lets also add a future class
                                if(!in_array($dateId,$pastDatesArray) && $dateId != $nextDate){
                                    $class .= 'future '; 
                                }

                                $html .= '<th data="'.esc_attr($dateId).'" class="date '.$class.'">';  
                                    //lets format the date and time nicer
                                    //date
                                    $dateFormat = get_option('date_format');
                                    $html .= '<span class="date-detail">';
                                        $html .= date_i18n($dateFormat, esc_html($dateTime));

                                        //do label
                                        if(strlen($label)>0){
                                            $html .= '<i title="'.esc_attr($label).'" class="date-label-tooltip icon-info"></i>';    
                                        }

                                    $html .= '</span>';

                                    //time
                                    $timeFormat = get_option('time_format');
                                    $html .= '<span class="time-detail">'.date_i18n($timeFormat, esc_html($dateTime)).'</span>';

                                $html .= '</th>'; 

                            }
                        $html .= '</tr>'; 


                    $html .= '</thead>'; 
                    









                    //table body
                    $html .= '<tbody>'; 

                        

                        //we need the following fields to check whether the user can edit the fields
                        //check whether the user can access the page or not!
                        $currentUser = wp_get_current_user();
                        //this is an array of roles of the current user below
                        $userRoles = $currentUser->roles; 

                        if( empty($userRoles) ){
                            $userRoles = array(0);
                        }

                        $permissions = array('guest'=> array(0,'wp_roster_member','editor','administrator'),'roster-member'=> array('wp_roster_member','editor','administrator'),'editor'=> array('editor','administrator'),'administrator'=> array('administrator'));


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


                        $intersectionBetweenRolesAndPermissions = array_intersect($userRoles, $permissions_array_three);

                        $intersectionBetweenRolesAndPermissionsForUnavailability = array_intersect($userRoles, $permissions_array_two);

                            

                        //now we need to cycle through each row (team)
                        //lets explode the data

                        $notificationTeamSplit = explode('||||||',$teamData);

                        //lets explode the data
                        $teamsDataExploded = explode('|||||',$notificationTeamSplit[0]);



                        //cycle through each data
                        foreach($teamsDataExploded as $team){
                            if(strlen($team)>0){

                                //get the variables for the team
                                $teamProperties = explode('||||',$team);

                                $teamId = $teamProperties[0];
                                $teamName = $teamProperties[1];
                                $teamAllocations = $teamProperties[2];
                                $teamType = $teamProperties[3];
                                $teamItems = explode('|||',$teamProperties[4]); //we will do some more exciting stuff with this later

                                

                                //we now need to cycle through the allocations
                                for ($a = 1 ; $a <= $teamAllocations; $a++){ 
                               
                                    $html .= '<tr>';

                                        if($teamAllocations>1){
                                            $teamNameMod = $teamName.' ('.$a.')';
                                        } else {
                                            $teamNameMod = $teamName;    
                                        }

                                        //we need to create the first column data which will be the team name
                                        $html .= '<th data="'.esc_attr($teamId).'">';
                                            $html .= esc_html(stripslashes($teamNameMod));
                                        $html .= '</th>';


                                        //now we need to cycle through each date
                                        foreach($datesIdArray as $dateId){

                                            //if the date is in the past lets give it some styling
                                            $class = '';
                                            $readOnly = ''; 
                                            $selectReadOnly = ''; 

                                            if(in_array($dateId,$pastDatesArray)){
                                                $class .= 'past-date '; 
                                                $readOnly = 'readonly';  
                                                $selectReadOnly = 'disabled="true"';  
                                            }


                                            //if user is logged out prevent editing of fields as well
                                            if( empty($intersectionBetweenRolesAndPermissions) ){
                                                $readOnly = 'readonly';  
                                                $selectReadOnly = 'disabled="true"'; 
                                            }


                                            if($dateId == $nextDate){
                                                $class .= 'now '; 
                                            }
                                            
                                            


                                                //now we need to present the 3 inputs depending on the type
                                                //the type can be list, members, text

                                                if( array_key_exists($a.'-'.$teamId.'-'.$dateId , $rosterDataArray ) ){
                                                    $inputValue = $rosterDataArray[$a.'-'.$teamId.'-'.$dateId];
                                                } else {
                                                    $inputValue = '';   
                                                }

                                           


                                                //text
                                                if($teamType == 'text'){

                                                    $html .= '<td class="'.$class.'">';

                                                    $html .= '<input data-allocation="'.$a.'" data-team="'.esc_attr($teamId).'" data-date="'.esc_attr($dateId).'"  class="roster-data-input text" type="text" value="'.esc_html(stripslashes($inputValue)).'" '.$readOnly.'>';

                                                    $html .= '</td>';

                                                }


                                                //file
                                                if($teamType == 'file'){

                                                    $html .= '<td class="'.$class.'">';

                                                    $html .= '<input name="fileurl" data-allocation="'.$a.'" data-team="'.esc_attr($teamId).'" data-date="'.esc_attr($dateId).'"  class="roster-data-input file" type="text" value="'.esc_html($inputValue).'" '.$readOnly.'>';

                                                    $html .= '<i class="file-download icon-arrow-down-circle"></i>';
                                                    $html .= '<i class="file-upload icon-arrow-up-circle"></i>';

                                                    $html .= '</td>';

                                                }

                                                //members
                                                if($teamType == 'members'){

                                                    $html .= '<td class="'.$class.'">';

                                                    $html .= '<select data-allocation="'.$a.'" data-team="'.esc_attr($teamId).'" data-date="'.esc_attr($dateId).'" class="roster-data-input members" '.$selectReadOnly.'>';

                                                        // //print out no option if the saved value is blank or if not set
                                                     
                                                        $html .= '<option title=""></option>';

                                                        foreach($teamItems as $teamMember){

                                                            if($teamMember == $inputValue){
                                                                $html .= '<option value="'.esc_attr($teamMember).'" selected="selected">'.esc_html(stripslashes($rosterMembers[$teamMember])).'</option>';
                                                            } else {
                                                                $html .= '<option value="'.esc_attr($teamMember).'">'.esc_html(stripslashes($rosterMembers[$teamMember])).'</option>';
                                                            }

                                                        }    

                                                    $html .= '</select>';
                                                    $html .= '</td>';
                                                }



                                                //list
                                                if($teamType == 'list'){


                                                    //what we need to do is loop through the options first so we can get the appropriate title for the select
                                                    $selectTitle = '';

                                                    foreach($teamItems as $listItem){
                                                        $listProperties = explode('^^',$listItem);
                                                        if($listProperties[0] == $inputValue){ 
                                                            $selectTitle = $listProperties[1];
                                                        }    
                                                    }    


                                                    // //now lets do our youtube/spotify replacement
                                                    // if(strpos($selectTitle, 'spotify:track:') !== false){
                                                        
                                                    //     //find the position of the text
                                                    //     $positionOfSpotifyText = strpos($selectTitle,'spotify:track:');
                                                    //     // $lastPositionOfSpotifyText = $positionOfSpotifyText+36;


                                                    //     // if($lastPositionOfSpotifyText == $positionOfSpotifyText){
                                                    //     //     $lastPositionOfSpotifyText = strlen($selectTitle);
                                                    //     // }


                                                    //     $spotifyText = substr($selectTitle,$positionOfSpotifyText,36);

                                                    //     echo 'position:'.$positionOfSpotifyText.' spotifytext:'.$spotifyText.'</br>';

                                                    //     //explode the spotify track
                                                    //     $spotifyTextExploded = explode(':',$spotifyText);

                                                    //     $spotifyTrack = $spotifyTextExploded[2];

                                                    //     $replacementText = '<iframe src="https://open.spotify.com/embed/track/'.$spotifyTrack.'" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>';

                                                    //     //now lets do the replacement
                                                    //     $selectTitle = str_replace($spotifyText,$replacementText,$selectTitle);
                                                        
                                                    // }


                                                    $html .= '<td title="'.htmlentities(stripslashes($selectTitle)) .'" class="'.$class.' list-item-tooltip">';

                                                    $html .= '<select data-allocation="'.$a.'" data-team="'.esc_attr($teamId).'" data-date="'.esc_attr($dateId).'" class="roster-data-input list" '.$selectReadOnly.'>';

                                                    //print out no option if the saved value is blank or if not set
                                                  
                                                    $html .= '<option title=""></option>';
                                                    


                                                    //further explode the list items
                                                    foreach($teamItems as $listItem){
                                                        $listProperties = explode('^^',$listItem);



                                                        if($listProperties[0] == $inputValue){ 

                                                            $html .= '<option title="'.htmlentities(stripslashes($listProperties[1])).'" value="'.esc_html(stripslashes($listProperties[0])).'" selected="selected">'.esc_html(stripslashes($listProperties[0])).'</option>';

                                                        } else {

                                                            $html .= '<option title="'.htmlentities(stripslashes($listProperties[1])).'" value="'.esc_html(stripslashes($listProperties[0])).'">'.esc_html(stripslashes($listProperties[0])).'</option>';

                                                        }    

                                                    }

                                                    $html .= '</select>';
                                                    $html .= '</td>';


                                                }//end list

                                        }

                                    $html .= '</tr>';


                                }

                            }
                        }

                        //do unavailability columns for pro
                        global $wp_roster_is_pro;

                        if($wp_roster_is_pro == "YES"){

                            if(!isset($rosterSettings[16]) && strlen($rosterSettings[16])<1){
                                $unavailabilityRows = 10;
                            } else {
                                $unavailabilityRows = intval($rosterSettings[16]);
                            }

                            $html .= wp_roster_unavailability($rosterMembers,$datesIdArray,$pastDatesArray,$rosterDataArray,$intersectionBetweenRolesAndPermissionsForUnavailability,$unavailabilityRows);
                        }




                    $html .= '</tbody>';   


                $html .= '</table>';    


            $html .= '</div>'; //container
        }

        return $html;

    }
?>