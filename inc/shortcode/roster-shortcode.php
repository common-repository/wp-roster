<?php
// shortcode
function wp_roster_shortcode($atts) {
    
    //get the roster id from the shortcode attribute
    $a = shortcode_atts(array('id' => ''),$atts);
    $rosterId = $a['id'];

    
    //only do output if the id is set
    if($rosterId !== ''){

        $rosterSettings = wp_roster_individual_roster_settings($rosterId);

        //start output
        //output style
        $html = '<style>
        

        .roster-main-menu .active, .roster-right-menu a > i, .secondary-button, .alertify .cancel, .icon-trash, .icon-pencil, .roster-container > h2, .user-edit-form-action-buttons i, .team-listing i, .notification-group-listing i, #roster-container .duplicate-item, .tippy-popper a, .notification-listing .builder-action-buttons i, .notification-listing .start-filter-display, .ql-snow.ql-toolbar button:hover, .ql-snow .ql-toolbar button:hover, .ql-snow.ql-toolbar button:focus, .ql-snow .ql-toolbar button:focus, .ql-snow.ql-toolbar button.ql-active, .ql-snow .ql-toolbar button.ql-active, .ql-snow.ql-toolbar .ql-picker-label:hover, .ql-snow .ql-toolbar .ql-picker-label:hover, .ql-snow.ql-toolbar .ql-picker-label.ql-active, .ql-snow .ql-toolbar .ql-picker-label.ql-active, .ql-snow.ql-toolbar .ql-picker-item:hover, .ql-snow .ql-toolbar .ql-picker-item:hover, .ql-snow.ql-toolbar .ql-picker-item.ql-selected, .ql-snow .ql-toolbar .ql-picker-item.ql-selected, .ql-snow a, .ql-snow.ql-toolbar button:hover .ql-stroke, .ql-snow .ql-toolbar button:hover .ql-stroke, .ql-snow.ql-toolbar button:focus .ql-stroke, .ql-snow .ql-toolbar button:focus .ql-stroke, .ql-snow.ql-toolbar button.ql-active .ql-stroke, .ql-snow .ql-toolbar button.ql-active .ql-stroke, .ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke, .ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke, .ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke, .ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke, .ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke, .ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke, .ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke, .ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke, .ql-snow.ql-toolbar button:hover .ql-stroke-miter, .ql-snow .ql-toolbar button:hover .ql-stroke-miter, .ql-snow.ql-toolbar button:focus .ql-stroke-miter, .ql-snow .ql-toolbar button:focus .ql-stroke-miter, .ql-snow.ql-toolbar button.ql-active .ql-stroke-miter, .ql-snow .ql-toolbar button.ql-active .ql-stroke-miter, .ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke-miter, .ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke-miter, .ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke-miter, .ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke-miter, .ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke-miter, .ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke-miter, .ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke-miter, .ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke-miter, .teams-menu-navigation .active, .search-icon, .search-icon-dates, .zoom-to-now, .file-upload, .file-download {
            color: '.esc_html($rosterSettings[5]).' !important;
        }

        .save-settings, .list-header,.alertify .ok, .feature-box, .flatpickr-day.selected, .roster-header-left, #roster-container thead tr, .roster-container-left-run-sheet, .note-btn-primary, .member-away-section {
            background-color: '.esc_html($rosterSettings[5]).' !important;    
        }

        .secondary-button,.alertify .cancel,.alertify .ok, .flatpickr-day.selected, .item-filter {
            border-color: '.esc_html($rosterSettings[5]).' !important; 
        }

        @media print {
            a {
                color: '.esc_html($rosterSettings[5]).' !important;
            }
        }

        @media screen and (min-width: 1201px){
            .roster-main-menu a:hover {
                color: '.esc_html($rosterSettings[5]).' !important;    
            }    
        }

        
        
        </style>
        ';


        //get the page of roster from the query string

        if(array_key_exists('roster-page',$_GET)){
            $page = $_GET['roster-page'];
        } else {
            $page = 'roster';
        }


        //check whether the user can access the page or not!
        $currentUser = wp_get_current_user();
        //this is an array of roles of the current user below
        $userRoles = $currentUser->roles; 

        if( empty($userRoles) ){
            $userRoles = array(0);
        }

        $leadersOfNotificationGroups = wp_roster_get_leaders_of_notification_groups($rosterId);
        $currentUserId = get_current_user_id();



        $permissions = array('guest'=> array(0,'wp_roster_member','editor','administrator'),'roster-member'=> array('wp_roster_member','editor','administrator'),'editor'=> array('editor','administrator'),'administrator'=> array('administrator'));

        $pagesAndSettingsTranslation = array('roster'=>$rosterSettings[6],'teams'=>$rosterSettings[9],'dates'=>$rosterSettings[8],'notifications'=>$rosterSettings[12],'run-sheet'=>$rosterSettings[13],'attendance'=>$rosterSettings[15],'history'=>$rosterSettings[10]);

        if(!is_array( $permissions[$pagesAndSettingsTranslation[$page]] )){
            $permissions_array = array();
        } else {
            $permissions_array = $permissions[$pagesAndSettingsTranslation[$page]];    
        }

        $intersectionBetweenRolesAndPermissions = array_intersect($userRoles,$permissions_array );



        if( !empty($intersectionBetweenRolesAndPermissions) || ($page == 'attendance' && in_array($currentUserId,$leadersOfNotificationGroups)) ){

            //add header
            //we are going to send it the roster id so it can use this if necessary
            //we are also going to send it the page so we know what the active link should be
            $html .= wp_roster_roster_header($rosterId,$page);

            //now we will do a switch depending on the page to call the appropriate data
            switch ($page) {
                case 'roster':
                    $html .= wp_roster_roster_home($rosterId);
                    break;    
                case 'teams':
                    $html .= wp_roster_roster_teams($rosterId);
                    break;
                case 'dates':
                    $html .= wp_roster_roster_dates($rosterId);
                    break;
                case 'notifications':
                    $html .= wp_roster_roster_notifications($rosterId);
                    break;
                case 'run-sheet':
                    $html .= wp_roster_roster_run_sheet($rosterId);
                    break;
                case 'attendance':
                    $html .= wp_roster_roster_attendance($rosterId);
                    break;    
                case 'history':
                    $html .= wp_roster_roster_history($rosterId);
                    break;    
            }

            $html .= '';

            echo $html;

        } else {
    
            global $wp;
            $current_url = home_url( add_query_arg( array(), $wp->request ) );

            $html .= '<style>.cancel{display:none !important;}</style>';

            $html .= '<div id="no-roster-access" data="'.wp_login_url().'?redirect_to="></div>';
            return $html;
        }










    } //end if roster id exists

 
}
add_shortcode('wp-roster', 'wp_roster_shortcode');



?>