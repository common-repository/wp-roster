<?php
    function wp_roster_roster_dates($rosterId) {

        $html = '';

        //left section
        $html .= '<div class="roster-container roster-container-left">';

            $html .= '<div class="fixed-div">';
                //add dates
                $html .= '<div class="feature-box feature-box-fixed add-a-date">'; 
                    $html .= '<h2>'.__('Add a date','wp-roster').'</h2>';    

                    //date/time input
                    $html .= '<span class="datetime-section">';
                    $html .= '<label for="datetime">'.__('Date/Time','wp-roster').'</label>';
                    $html .= '<input class="date-time-input" type="text" name="datetime">';
                    $html .= '</span>';

                    //description
                    $html .= '<span class="description-section">';
                    $html .= '<label for="description">'.__('Description (optional)','wp-roster').'</label>';
                    $html .= '<input class="description-input" type="text" name="description">';
                    $html .= '</span>';

                    //button
                    $html .= '<span class="button-section">';
                    $html .= '<button class="add-a-date-button secondary-button">'.__('Add date','wp-roster').'</button>';
                    $html .= '</span>';

                $html .= '</div>'; 
                
                //add multiple dates if pro
                global $wp_roster_is_pro;
                if($wp_roster_is_pro == "YES"){
                    $html .= '<div class="feature-box feature-box-fixed add-multiple-dates">';    
                        $html .= wp_roster_add_multiple_dates();
                    $html .= '</div>'; 
                }

            $html .= '</div>';
        $html .= '</div>';


        //right section
        $html .= '<div class="roster-container roster-container-right">';

            //show filter
            $html .= '<i title="Zoom to next date" class="zoom-to-now icon-exclamation"></i><input data="user-listing" class="item-filter item-filter-dates" type="text" placeholder="'.__('Filter items','wp-roster').'"><i class="icon-magnifier search-icon search-icon-dates"></i>';

            $html .= '<ul id="dates-listing" class="dates-listing">';

                //get data
                $data = get_option('wp_roster_data_'.$rosterId);
                //get the data data
                $dateData = $data['dates'];


                //only do something if is set
                if(isset($dateData)){

                    $sortArray = array();

                    //explode data
                    $explodedDates = explode('||',$dateData);


                    //cycle through each date
                    foreach($explodedDates as $date){

                        if(strlen($date)>0){

                            //explode again
                            $dateProperties = explode('^^',$date);

                            $key = strtotime($dateProperties[1]);

                            //lets add this to our sort array
                            $sortArray[$key] = $dateProperties;

                        }
                    }

                    //not lets sort by array key
                    ksort($sortArray);



                    //now lets cycle through the new array and output the actual data
                    foreach($sortArray as $key=>$value){

                        $html .= wp_roster_date_line_item($value[0],$value[1],$value[2]);
                   
                    }



                }



          

            $html .= '</ul>';
        $html .= '</div>';

        return $html;

    }
?>