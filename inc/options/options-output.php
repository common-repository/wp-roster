<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

//define all the settings in the plugin
function wp_roster_settings_init() { 
    
    //start authorisation section
	register_setting( 'rosters', 'wp_roster_settings' );
    
    //roster settings
	add_settings_section(
		'wp_roster_rosters','', 
		'wp_roster_rosters_callback', 
		'rosters'
	);
    
    add_settings_field( 
		'wp_roster_tab_memory','', 
		'wp_roster_tab_memory_render', 
		'rosters', 
		'wp_roster_rosters' 
    );

    add_settings_field( 
		'wp_roster_hide_admin_notice','', 
		'wp_roster_hide_admin_notice_render', 
		'rosters', 
		'wp_roster_rosters' 
    );
    
    add_settings_field( 
		'wp_roster_roster_settings','', 
		'wp_roster_roster_settings_render', 
		'rosters', 
		'wp_roster_rosters' 
    );
   
    //support
    register_setting( 'wp_roster_support', 'wp_roster_settings' );
    
	add_settings_section(
		'wp_roster_wp_roster_support','', 
		'wp_roster_wp_roster_support_callback', 
		'wp_roster_support'
    );

    

 
    //locked
    register_setting( 'wp_roster_licence', 'wp_roster_settings' );
    
	add_settings_section(
		'wp_roster_locked','', 
		'wp_roster_locked_callback', 
		'wp_roster_licence'
	);
    

    
 
 
}

/**
* 
*
*
* The following functions output the callback of the sections
*/
function wp_roster_rosters_callback(){

    //get settings
    $options = get_option('wp_roster_settings');
    

    ?>

    <tr class="wp_roster_settings_row" valign="top">
        <td scope="row" colspan="2">
            <div class="inside">
                <label for="wp_roster_create_roster">Create Roster</label>
        
                <input type="text" class="regular-text" style="margin-left:10px;" id="wp_roster_create_roster">
                
                <button class="button-secondary" style="margin-left:5px;" id="wp_roster_create_roster_button">Add</button>
                
                <br></br>
                <ul id="roster-settings">
                <?php 


                $rosterSettings = $options['wp_roster_roster_settings'];
                
                if(isset($rosterSettings)){
                    //lets split the settings
                    $individualRosterSettings = explode('||',$rosterSettings);


                    foreach($individualRosterSettings as $rosterSetting){

                        if(strlen($rosterSetting)>0){

                            $rosterSettingFields = explode('|',$rosterSetting);

                            //output the list item
                            echo wp_roster_roster_settings_output($rosterSettingFields[0],$rosterSettingFields[1],$rosterSettingFields[2],$rosterSettingFields[3],$rosterSettingFields[4],$rosterSettingFields[5],$rosterSettingFields[6],$rosterSettingFields[7],$rosterSettingFields[8],$rosterSettingFields[9],$rosterSettingFields[10],$rosterSettingFields[11],$rosterSettingFields[12],$rosterSettingFields[13],$rosterSettingFields[14],$rosterSettingFields[15],$rosterSettingFields[16]);

                        }
                    }
                }
                
                ?>
                </ul>
                <br></br>  
                
                
                <h3><?php _e( 'Roster Setting Information', 'wp-roster' ) ?></h3>
                <ul style="list-style: disc; margin-left: 20px;">

                    <li><strong><?php _e( 'Roster Name', 'wp-roster' ) ?></strong><?php _e( ' - this is the name of the roster which is used to identify each roster. If you have no logo selected in the next option this name is used as the title of the roster.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Roster Logo', 'wp-roster' ) ?></strong><?php _e( ' - upload a custom logo which is used instead of the roster name in the previous option. The logo is displayed at the top of the roster.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Home URL', 'wp-roster' ) ?></strong><?php _e( ' - you can add a custom home button to the roster so users can go back to your website home page if necessary. Please leave blank for no home button or enter a full URL including https://.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Team Name', 'wp-roster' ) ?></strong><?php _e( ' - maybe for your requirements the word "Teams" is not the best way to describe your groupings, maybe "Groups" or "Services" is a better term so you can use this setting to translate the term. Please make sure this is a plural, so don\'t put down "Ministry", put down "Ministries" here instead.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Notification Group Name', 'wp-roster' ) ?></strong><?php _e( ' - in a church context a suitable name for this might be "Bible sudies" or "community groups" or "small groups" or whatever name is given to people who meet up. In other contexts perhaps just leave blank to use the term "Notifications groups".', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Theme Color', 'wp-roster' ) ?></strong><?php _e( ' - pick a main color for your roster which is used for links and other items on your roster. I recommend picking a color that is not too dark or too light that it blends into black or white.', 'wp-roster' ) ?></li>
                    
                    <li><strong><?php _e( 'Roster View', 'wp-roster' ) ?></strong><?php _e( ' - the minimum role required to view the roster.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Roster Edit', 'wp-roster' ) ?></strong><?php _e( ' - the minimum role required to edit the roster.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Date View/Edit', 'wp-roster' ) ?></strong><?php _e( ' - the minimum role required to view and edit the dates.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Team View/Edit', 'wp-roster' ) ?></strong><?php _e( ' - the minimum role required to view and edit teams.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'History View/Edit', 'wp-roster' ) ?></strong><?php _e( ' - the minimum role required to view and edit the history.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Unavailable Edit', 'wp-roster' ) ?></strong><?php _e( ' - the minimum role required to edit the unavailability roles on the roster.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Notifications View/Edit', 'wp-roster' ) ?></strong><?php _e( ' - the minimum role required to view and edit the notifications.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Run Sheet View/Edit', 'wp-roster' ) ?></strong><?php _e( ' - the minimum role required to view and edit the run sheet.', 'wp-roster' ) ?></li>

                    <li><strong><?php _e( 'Attendance View/Edit', 'wp-roster' ) ?></strong><?php _e( ' - the minimum role required to view and edit the attendance. Note, that notification group leaders will also be able to view and edit attandance of their notification group.', 'wp-roster' ) ?></li>


                </ul>
            
            </div>
        </td>
    </tr>        
            
    <?php
}


function wp_roster_wp_roster_support_callback(){
    ?>
    <tr class="wp_roster_settings_row" valign="top">
        <td scope="row" colspan="2">
            <div class="inside">
                
                
                
                
                
                <h2><?php _e( 'Frequently Asked Questions', 'wp-roster' ); ?></h2>

                
                
                <div id="accordion">
                    <h3><i class="icon-info"></i> <?php _e( 'How do I setup the plugin?', 'wp-roster' ); ?></h3>
                    <div>
                        <?php _e( 'First go to the <a class="open-tab" href="#rosters">Rosters</a> tab and create your first roster and optionally change the roster settings as you desire and click the "Save All Settings" button. Click the "Copy Shortcode" button for the roster and then paste this shortcode on a page of your choice and publish the page. The plugin has only been tested and is very much designed for a full-window design. So we strongly recommend changing the page template on your page to the provided template "WP Roster" - please see this article <a href="https://ithemes.com/tutorials/applying-wordpress-page-template/">here</a> if you don\'t know how to change your page template. It is possible that other plugins or your theme may effect the styles output by the plugin so you may need to modify your CSS to make things just right. However if you want to emulate the design shown in the plugin screenshots please use the stock standard <a href="https://wordpress.org/themes/twentysixteen/">Twenty Sixteen</a> theme which is free. Now that you have created your roster page you can start adding data to the roster which is done from the frontend of your site. I recommend by starting on either the teams or dates pages to start entering your base data. Then when you go to your main roster page you will see all your dates and teams and you can start allocating members or list items to specific dates or enter custom text depending on the team type.', 'wp-roster' ); ?>
                    </div>

                    <h3><i class="icon-info"></i> <?php _e( 'How does saving work on the frontend?', 'wp-roster' ); ?></h3>
                    <div>
                        <?php _e( 'To save data your you need to click the "Save" button in the top right hand corner of the page. If you make changes and don\'t press the save button your data will not be saved. There is an exception to this rule though which are the members on the "teams" menu item. WP Roster uses the built in user system for WordPress so when members are added, edited and removed these changes take place live.', 'wp-roster' ); ?>
                    </div>

                    <h3><i class="icon-info"></i> <?php _e( 'How do permissions work?', 'wp-roster' ); ?></h3>
                    <div>
                        <?php _e( 'Users with the roles "administrator" can edit all parts of the plugin. Users with the role "editor" can edit the main roster user allocations and they can edit everything on the "team" and "dates" pages. Depending on your <a class="open-tab" href="#rosters">roster settings</a>, the main roster page can be either hidden or visible to non-logged in users. Non-logged in users can\'t view any other pages.', 'wp-roster' ); ?>
                    </div>

                    <h3><i class="icon-info"></i> <?php _e( 'What\'s the difference between members, notification groups and teams?', 'wp-roster' ); ?></h3>
                    <div>
                        <?php _e( 'Good question, because the terminology can be a little confusing depending on your context and background. Members are individual people/users. Teams are individual line items which show on your main roster tab. You can add members to teams and on the main roster tab you can select what members you want allocated to a particular team for a given date. Ok great, that\'s pretty straight forward I think. Now let\'s use a church metaphor to explain notification groups. Church\'s are normally made up of Bible study groups or in a business context this might be a work team/group, like developer group 1 or developer group 2 for example. Maybe you have a team called "Clean up" and instead of allocating an individual to clean up it may make sense for you to allocate a Bible study group to do that work. So what you can do is create a notification group called "Bob\'s Bible Study" and put down the members of that particular Bible study in that notification group. Now for the "Clean up" team you can add in "Bob\'s Bible Study" as a member, and then on the main roster page allocate "Bob\'s Bible Study" to "Clean up". Now for free users of this plugin notification groups are\'t all that valuable, but for pro users they make things heaps easier because when you create automated notifications it will send a notification to all members in "Bob\'s Bible Study" when they are on "Clean up". What this means is in your main roster page each week you just need to select one Bible Study Group as oppose to perhaps having a team with 6 or however many allocations and assigning each individual member to the particular team allocation - this saves heaps of time and minimises mistakes as well.', 'wp-roster' ); ?>
                    </div>

                    <h3><i class="icon-info"></i> <?php _e( 'What do the team settings mean: allocations and types?', 'wp-roster' ); ?></h3>
                    <div>
                        <?php _e( 'Allocations are the amount of times you want the team to be shown on the main roster page. To give you a practical example of when multiple allocations come in handy is when you have an event that might have multiple singers. Instead of creating a separate team for each singer allotment on your roster and having to add the same group of singers to each team, you can simply create an allocation of 5 for example and the singers team will be shown 5 times on your main roster page with the same group of singers to choose from. The type is the type of data you want to have on the main roster page. For most teams you are going to probably select "Members & Notification Groups" as this will enable you to choose a member or notification group for each date on the roster tab. But let\'s say your event has songs then you may create a list item that way you can add songs and choose specific songs for your date. Or perhaps your event has a topic or a sepcific Bible reading in which case you may just want a text field where you can just write whatever text you want.', 'wp-roster' ); ?>
                    </div>

                    <h3><i class="icon-info"></i> <?php _e( 'How do members work?', 'wp-roster' ); ?></h3>
                    <div>
                        <?php _e( 'Members can be added via the teams page on your roster. You can add the same member to multiple rosters with that user having one profile. When you add a member which is already in the system to a new roster you will be prompted whether you want to update the members details or pull the members data from the system. The plugin works this way so you can have just one contact profile for each individual member which is handy for notifications, whilst giving you the ability to  have or not have a particular member on a roster. Duplicates are identified by the members email address (just like standard WordPress) which means you can have 2 members with the same first and last name. However for practicalities sake you may want to further identify members with the same first and last name with perhaps a middle name included on either the first or last name of the member or with a number like Michael Smith1 and Michael Smith2.', 'wp-roster' ); ?>
                    </div>

                    <h3><i class="icon-info"></i> <?php _e( 'A note of caution...', 'wp-roster' ); ?></h3>
                    <div>
                        <?php _e( 'An important thing to know when deleting teams and dates is that when you delete these items the data that was associated to them in the main roster is now essentially lost. If you delete a date or team and then recreate a new date or team with the same name the roster data won\'t just magically reconnect with these items. This is because each team and date is given a unique id and once it is deleted the associated data can\'t find it anymore.', 'wp-roster' ); ?>
                    </div>
                    
                    <h3><i class="icon-info"></i> <?php _e( 'Restoration and backups?', 'wp-roster' ); ?></h3>
                    <div>
                        <?php _e( 'The plugin comes with the history page so you can easily restore settings to a previous time - but note only a few items are saved to this history so the plugins storage doesn\'t get out of a hand. As a result of this we strongly recommend doing at least daily database backups which can be done from the many great free WordPress backup plugins. Another option is if you are using the pro version of the plugin you can also duplicate rosters and duplicated rosters actually inherit all of the data of the roster so this can be used a backup option or for testing purposes.', 'wp-roster' ); ?>
                    </div>
                            
                    <?php 
                    //pro options
                    global $wp_roster_is_pro;
                    if($wp_roster_is_pro == "YES"){
                    ?>

                    <h3><i class="icon-info"></i> <?php _e( 'Improving the reliability/frequency of notifications', 'wp-roster' ); ?></h3>
                    <div>
                        <?php _e( 'The plugin relies on the WordPress cron system to send out notifications. The problem with the WordPress cron is that it only fires/clears the queue when someone visits your site. This means if it\'s really important that your notifications are sent at 3pm rather than 5pm then the WordPress cron is not ideal - especially if your site may not be visited too frequently. There are elaborate ways to get around this using your server cron instead, but in my opinion the easiest way to get this going is just using an external ping service which hits your website every 5 minutes that way it will clear the cron more frequently. There are many great free services that do this, but here\'s just one of them: <a href="https://uptimerobot.com/">Uptime Roboto</a>. As well as making the cron run more frequently these services are really great for monitoring your server anyway!', 'wp-roster' ); ?>
                    </div>

                    <h3><i class="icon-info"></i> <?php _e( 'Not everyone is receiving emails?', 'wp-roster' ); ?></h3>
                    <div>
                        <?php _e( 'Emails sent by the plugin are HTTP emails (like all standard WordPress emails) and some email systems, typically exchange email servers block these or send them to junk or spam. To get around this I recommend entering a custom SMTP server and port number on the <a class="open-tab" href="#wp_roster_notifications">WP Roster Notifications</a> tab which will send emails via your STMP server instead of via WordPress HTTP. There are also other great <a href="https://wordpress.org/plugins/search/smtp+email/">free plugins</a> which can do this as well. Using an external email server can be a good idea anyway as it means all sent emails from the plugin will show in your sent folder for your email account which can be good for testing purposes.', 'wp-roster' ); ?>
                    </div>

                    <?php } ?>
                    
 
                    
                </div>  
                <br></br>
                <h2><?php _e( 'Support', 'wp-roster' ); ?></h2>
                
                <p><?php _e( 'Before making a support request please read the above frequently asked questions. When submitting a request on the WordPress forum please include the following information:', 'wp-roster' ); ?></p>
                
        

                <p><code><?php echo 'PHP Version: <strong>'.phpversion().'</strong>'; ?></br>
                <?php echo 'Wordpress Version: <strong>'.get_bloginfo('version').'</strong>'; ?></br>
                Plugin Version: <strong><?php echo wp_roster_plugin_get_version(); ?></strong></br>
                Current Theme: <strong><?php 
                $user_theme = wp_get_theme();    
                echo esc_html( $user_theme->get( 'Name' ) );
                ?></strong></br></code></p>
                
                <p><?php _e( 'URL\'s and Screenshots of issues can also be extremely helpful in diagnosing things so please include this where possible. We typically reply to support requests within 48 hours. To show your appreciation of our support we would be grateful if you could give us a <a target="_blank" href="https://wordpress.org/support/plugin/wp-roster/reviews/?rate=5#new-post">positive review <i class="icon-star" ></i><i class="icon-star" ></i><i class="icon-star" ></i><i class="icon-star" ></i><i class="icon-star" ></i></a>.', 'wp-roster' ); ?></p>

                <a class="button-secondary" target="_blank" href="https://wordpress.org/support/plugin/wp-roster" >Create a support request on the forum</a>

                <p>For priority support please <a target="_blank" href="https://northernbeacheswebsites.com.au/wp-roster-pro/">upgrade to the pro version of the plugin</a>.</p>
                
                
            </div>
        </td>
    </tr>
    <?php
    
}











function wp_roster_locked_callback(){
    ?>
    <tr class="wp_roster_settings_row" valign="top">
        <td scope="row" colspan="2">
            <div class="inside">
                You need to purchase the <a href="https://northernbeacheswebsites.com.au/wp-roster-pro/">pro version</a> of the plugin to enjoy this feature. Upgrade to WP Roster Pro to enjoy some powerful features. This includes the ability to create advanced automatic notifications via email or SMS (SMS charges are not included) and the ability to create multiple rosters! Pro users also have the ability to upload members from a CSV file and add multiple dates with a click of a button. The main roster on the pro version of the plugin also has unavailable rows so users can add in their unavailability for those creating the roster.
            </div>
        </td>
    </tr>
    <?php
    
}


//Roster Settings

function wp_roster_tab_memory_render() {                                     
    wp_roster_settings_code_generator('wp_roster_tab_memory','Tab Memory','Remembers the last settings tab','text','','','','hidden-row');   
}

function wp_roster_hide_admin_notice_render() {     
    wp_roster_settings_code_generator('wp_roster_hide_admin_notice','Hide admin notice','','checkbox','','','','hidden-row');   
}

function wp_roster_roster_settings_render() {                                     
    wp_roster_settings_code_generator('wp_roster_roster_settings','Roster Settings','','text','','','','hidden-row');   
}





//function to generate settings rows
function wp_roster_settings_code_generator($id,$label,$description,$type,$default,$parameter,$importantNote,$rowClass) {
    
    //get options
    $options = get_option('wp_roster_settings');
    
    //value
    if(isset($options[$id])){  
        $value = $options[$id];    
    } elseif(strlen($default)>0) {
        $value = $default;   
    } else {
        $value = '';
    }
    
    
    //the label
    echo '<tr class="wp_roster_settings_row '.$rowClass.'" valign="top">';
    echo '<td scope="row">';
    echo '<label for="'.$id.'">'.$label;
    if(strlen($description)>0){
        echo ' <i class="icon-info"></i>';
        echo '<p class="hidden"><em>'.$description.'</em></p>';
    }
    if(strlen($importantNote)>0){
        echo '</br><span style="color: #CC0000;">';
        echo $importantNote;
        echo '</span>';
    } 
    echo '</label>';
    
    
    
    if($type == 'shortcode') {
        echo '</br>';
        
        foreach($parameter as $shortcodevalue){
            echo '<a value="['.$shortcodevalue.']" class="wp_roster_append_buttons">['.$shortcodevalue.']</a>';
        }       
    }
    
    if($type == 'textarea-advanced') {
        echo '</br>';
        
        foreach($parameter as $shortcodevalue){
            echo '<a value="['.$shortcodevalue.']" data="'.$id.'" class="wp_roster_append_buttons_advanced">['.$shortcodevalue.']</a>';
        }       
    }
    
    
    if($type == 'shortcode-advanced') {
        echo '</br>';
        
        foreach($parameter as $shortcodevalue){
            echo '<a value="'.$shortcodevalue[1].'" class="wp_roster_append_buttons">'.$shortcodevalue[0].'</a>';
        }       
    }
    
    

    //the setting    
    echo '</td><td>';
    
    //text
    if($type == "text"){
        echo '<input type="text" class="regular-text" name="wp_roster_settings['.$id.']" id="'.$id.'" value="'.$value.'">';     
    }
    
    //select
    if($type == "select"){
        echo '<select name="wp_roster_settings['.$id.']" id="'.$id.'">';
        
        foreach($parameter as $x => $xvalue){
            echo '<option value="'.$x.'" ';
            if($x == $value) {
                echo 'selected="selected"';    
            }
            echo '>'.$xvalue.'</option>';
        }
        echo '</select>';
    }
    
    
    //checkbox
    if($type == "checkbox"){
        echo '<label class="switch">';
        echo '<input type="checkbox" id="'.$id.'" name="wp_roster_settings['.$id.']" ';
        echo checked($value,1,false);
        echo 'value="1">';
        echo '<span class="slider round"></span></label>';
    }
        
    //color
    if($type == "color"){ 
        echo '<input name="wp_roster_settings['.$id.']" id="'.$id.'" type="text" value="'.$value.'" class="my-color-field" data-default-color="'.$default.'"/>';    
    }
    
    //page
    if($type == "page"){
        $args = array(
            'echo' => 0,
            'selected' => $value,
            'name' => 'wp_roster_settings['.$id.']',
            'id' => $id,
            'show_option_none' => $default,
            'option_none_value' => "default",
            'sort_column'  => 'post_title',
            );
        
            echo wp_dropdown_pages($args);     
    }
    
    //textarea
    if($type == "textarea" || $type == "shortcode" || $type == "shortcode-advanced"){
        echo '<textarea cols="46" rows="3" name="wp_roster_settings['.$id.']" id="'.$id.'">'.$value.'</textarea>';
    }
    
    
    if($type == "textarea-advanced"){
        if(isset($value)){    
            wp_editor(html_entity_decode(stripslashes($value)), $id, $settings = array(
            'wpautop' => false,    
            'textarea_name' => 'wp_roster_settings['.$id.']',
            'drag_drop_upload' => true,
            'textarea_rows' => 7, 
            ));    
        } else {
            wp_editor("", $id, $settings = array(
            'wpautop' => false,    
            'textarea_name' => 'wp_roster_settings['.$id.']',
            'drag_drop_upload' => true,
            'textarea_rows' => 7,
            ));         
        }
    }
    
    //number
    if($type == "number"){
        echo '<input type="number" class="regular-text" name="wp_roster_settings['.$id.']" id="'.$id.'" value="'.$value.'">';     
    }

    echo '</td></tr>';

}

?>