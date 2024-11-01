<?php 
if ( ! defined( 'ABSPATH' ) ) exit;


$options = get_option('wp_roster_settings');

?>

    <!-- start wrap -->
    <div class="wrap">
    <div id="poststuff">
        
    <!-- heading -->
    <img style="width:200px;" class="style-svg" alt="WP Roster Logo" src="<?php echo plugins_url( '../images/WP-Roster-Logo.svg', __FILE__ ); ?>"><h1>| <?php _e('Settings', 'wp-roster' ); ?></h1>
        
    
        
        
        
    <!-- welcome and pro note -->         
    <?php    
       
    
        
    if(!isset($options['wp_roster_hide_admin_notice'])){
        echo '<div style="margin-top:20px;" class="notice notice-warning is-dismissible wp-roster-welcome inline">
            <h3>'.__( 'Thanks for trying out WP Roster!', 'wp-roster' ) .'</h3>
            '.__( '<p>To get started simply go to the <a class="open-tab" href="#rosters">Rosters</a> tab and create your first roster and then using the "Copy Shortcode" button, copy your shortcode and place it on any page. It is strongly recommended to choose the page template "WP Roster" that way the roster takes up the entire screen.</p>
            
            <p>The plugin is brand spanking new so please be a little patient with things. I really do recommend checking out the <a class="open-tab" href="#wp-roster-support">Support</a> tab as it has some FAQ\'s which you may find very important before getting stuck into things. I would also be grateful if you could rate the plugin 5 stars, it\'s a nice way to say thank you! <a target="_blank" href="https://wordpress.org/support/plugin/wp-roster/reviews/?rate=5#new-post"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></p> 
            ', 'wp-roster' ) .' 
        </div>';      
    }    
        
     
        
    global $wp_roster_is_pro;
        
    if($wp_roster_is_pro == 'NO'){    
    echo '<div style="margin-top:20px; padding-bottom: 15px;" class="notice notice-success is-dismissible wp-roster-welcome inline">
            <h3>'.__( 'Upgrade to pro to get some must-have features', 'wp-roster' ) .'</h3>
            '.__( '<p>Upgrade to WP Roster Pro to enjoy some powerful features. This includes the ability to create advanced automatic notifications via email or SMS (SMS charges are not included) and the ability to create multiple rosters! Pro users also have the ability to upload members from a CSV file and add multiple dates with a click of a button. The main roster on the pro version of the plugin also has unavailable rows so users can add in their unavailability for those creating the roster.</p> 
            
            <a target="_blank" href="https://northernbeacheswebsites.com.au/wp-roster-pro/" class="button button-primary pro-button">GO PRO NOW</a>
            
            ', 'wp-roster' ) .' 
        </div>';     
    }
    
    ?>    
        
                
        

    <?php
        
        //function to transform titles
        
        function wp_roster_change_title($name){
            
            $nameToLowerCase = strtolower($name);
            $replaceSpaces = str_replace(' ', '_', $nameToLowerCase);    
            
            return $replaceSpaces;
            
        }
        
        
        //function to output tab titles
        function wp_roster_output_tab_titles($name,$proFeature) {
            
            global $wp_roster_is_pro;
            
            if ($wp_roster_is_pro == "YES" && $proFeature == "YES"){ 
                $iconOutput = '<i id="is-pro-check" class="icon-lock-open"></i>';    
            } elseif ($proFeature == "YES") {
                $iconOutput = '<i id="is-pro-check" class="icon-lock"></i>'; 
            } else {
                $iconOutput = '';   
            }
         
            
            echo '<li><a class="nav-tab" href="#'.wp_roster_change_title($name).'">'.$name.' '.$iconOutput.'</a></li>'; 
        }
        
        
        
        
        //function to output tab content
        function wp_roster_tab_content($tabName) {
            
            $transformedTitle = wp_roster_change_title($tabName);
            
            ?>
            <div class="tab-content" id="<?php echo $transformedTitle; ?>">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <div class="inside">
                                <table class="form-table">
                                    <?php
                                    global $wp_roster_is_pro;
                                    global $wp_roster_pro_features;
            
                                    if($wp_roster_is_pro != "YES" && $wp_roster_pro_features[$tabName][0] == "YES") {
                                        
                                        settings_fields('wp_roster_licence');
                                        do_settings_sections('wp_roster_licence');     
                                        
                                    } else {
                                        
                                        settings_fields($transformedTitle);
                                        do_settings_sections($transformedTitle);  
                                        
                                            
                                        if($wp_roster_pro_features[$tabName][1] == "YES"){
                                        ?>
                                        
                                        <table>
                                            <tr class="wp_roster_settings_row">
                                                <td>
                                                    <button type="submit" name="submit" id="submit" class="button button-primary wp-roster-save-all-settings-button"><?php _e('Save All Settings', 'wp-roster' ); ?></button>
                                                </td>
                                            </tr>    
                                        </table>    
                                        <?php    
                                        }
      
                                    }
                                    ?>
                                </table>
                             </div> <!-- .inside -->
                    </div> <!-- .postbox -->                      
                </div> <!-- .meta-box-sortables --> 
            </div> <!-- .tab-content -->  
            <?php
            
            
        }
    ?>    
    
 
        
        
        

    <!--start form-->    
    <form id="wp_roster_settings_form" action="options.php" method="post">
       
        <div id="tabs" class="nav-tab-wrapper"> 
            <ul class="tab-titles">
                <?php 

                //declare pro and non pro options into an associative array
                global $wp_roster_pro_features;

                foreach($wp_roster_pro_features as $item => $value){

                    wp_roster_output_tab_titles($item,$value[0]);
                }

                ?>

            </ul>

            <!--add tab content pages-->
            <?php

            global $wp_roster_pro_features;

            foreach($wp_roster_pro_features as $item => $value){
                wp_roster_tab_content($item);     
            }
            ?>

        </div> <!--end tabs div-->         
    </form>
        
        
        
    </div> <!--end post stuff-->    


    <?php

    if ( ! function_exists( 'northernbeacheswebsites_information' ) ) {
        require('nbw.php');  
    }

    echo northernbeacheswebsites_information();

    ?>

        
        
    </div> <!-- .wrap -->