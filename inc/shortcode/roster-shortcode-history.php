<?php
    function wp_roster_roster_history($rosterId) {

        $html = '';

        $html .= '<div class="roster-container">';

            //here we will get the save history of the data and cycle through each list item
            //lets start by printing just one list item
            $html .= '<ul class="save-history">';

            
                $html .= '<li class="list-header">';
                    $html .= '<span>'.__('Date','wp-roster').'</span>';
                    $html .= '<span>'.__('Time','wp-roster').'</span>';
                    $html .= '<span>'.__('User','wp-roster').'</span>';
                    $html .= '<span>'.__('Module','wp-roster').'</span>';
                    $html .= '<span>'.__('Restore','wp-roster').'</span>';
                $html .= '</li>';


                //the option name
                $optionName = 'wp_roster_data_history_'.$rosterId;

                //get the current options
                $existingHistoryItems = get_option($optionName);

            
          
                //reverse the array
                $existingHistoryItemsReversed = array_reverse($existingHistoryItems,true);

                foreach($existingHistoryItemsReversed as $key=>$value){

                    $html .= wp_roster_history_list_item($key,$value[0],$value[1]);

                }


            $html .= '</ul>';


        $html .= '</div>';

        return $html;

    }
?>