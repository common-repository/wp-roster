<?php
/*
*		Plugin Name: WP Roster
*		Plugin URI: https://www.northernbeacheswebsites.com.au
*		Description: A robust roster system for WordPress 
*		Version: 2.30
*		Author: Martin Gibson
*		Text Domain: wp-roster   
*		Support: https://www.northernbeacheswebsites.com.au/contact
*		Licence: GPL2
*/


/**
* 
*
*
* Create global variables
*/
global $wp_roster_is_pro;

if(file_exists(dirname( __FILE__ ).'/inc/pro-wpr')){
    $wp_roster_is_pro = "YES";    
} else {
    $wp_roster_is_pro = "NO";    
}




//the first YES/NO in the array is if the feature is pro, the second YES/NO in the array is if a save settings button is necessary
global $wp_roster_pro_features;
$wp_roster_pro_features = array('Rosters' => array('NO','YES'), 'WP Roster Support' => array('NO','NO'),'WP Roster Pro' => array('YES','YES'),'WP Roster Notifications' => array('YES','YES'),'WP Roster Member Upload' => array('YES','NO'),'WP Roster Custom Fields' => array('YES','YES'));
/**
* 
*
*
* Get plugin version number
*/
function wp_roster_plugin_get_version() {
	if ( ! function_exists( 'get_plugins' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );
	return $plugin_folder[$plugin_file]['Version'];
}
/**
* 
*
*
* run on activating the plugin
*/
function wp_roster_plugin_activate() {
    remove_role( 'wp_roster_member' );
	add_role( 'wp_roster_member', 'WP Roster Member', array('read' => true, 'level_1' => true ));

	global $wp_roster_is_pro;

	if($wp_roster_is_pro == 'YES'){
		if( !wp_next_scheduled( 'wp_roster_send_automated_notifications' ) ) {  
			wp_schedule_event( time(), 'hourly', 'wp_roster_send_automated_notifications' );  
		}
	}

	
}
register_activation_hook( __FILE__, 'wp_roster_plugin_activate' );
/**
* 
*
*
* Remove cron event on deactivation
*/
function wp_roster_plugin_deactivate() {	
	// find out when the last event was scheduled
	$timestamp = wp_next_scheduled ('wp_roster_send_automated_notifications');
	// unschedule previous event if any
	wp_unschedule_event ($timestamp, 'wp_roster_send_automated_notifications');
} 
register_deactivation_hook (__FILE__, 'wp_roster_plugin_deactivate');
/**
* 
*
*
* add a settings link on the plugin page
*/
function wp_roster_add_settings_link( $links ) {

    $settings_link = '<a href="admin.php?page=wp_roster">' . __( 'Settings','wp-roster' ) . '</a>';
    array_unshift( $links, $settings_link );
    
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'wp_roster_add_settings_link' );
/**
* 
*
*
* Add settings page
*/
add_action( 'admin_menu', 'wp_roster_add_settings_page' );
add_action( 'admin_init', 'wp_roster_settings_init' );

function wp_roster_add_settings_page() {
    
    $menu_icon_svg = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMiIgYmFzZVByb2ZpbGU9InRpbnkiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnIGlkPSJMYXllcl8xIj48Zz48Zz48cmVjdCB4PSIxIiB5PSIxIiBmaWxsPSIjOUVBM0E3IiB3aWR0aD0iOC42IiBoZWlnaHQ9IjMiLz48cmVjdCB4PSIxMC40IiB5PSIxIiBmaWxsPSIjOUVBM0E3IiB3aWR0aD0iOC42IiBoZWlnaHQ9IjMiLz48L2c+PHJlY3QgeD0iMSIgeT0iNC44IiBmaWxsPSIjOUVBM0E3IiB3aWR0aD0iOC42IiBoZWlnaHQ9IjMiLz48cmVjdCB4PSIxIiB5PSI4LjUiIGZpbGw9IiM5RUEzQTciIHdpZHRoPSI4LjYiIGhlaWdodD0iMyIvPjxyZWN0IHg9IjEiIHk9IjEyLjMiIGZpbGw9IiM5RUEzQTciIHdpZHRoPSI4LjYiIGhlaWdodD0iMyIvPjxyZWN0IHg9IjEiIHk9IjE2IiBmaWxsPSIjOUVBM0E3IiB3aWR0aD0iOC42IiBoZWlnaHQ9IjMiLz48cmVjdCB4PSIxMC40IiB5PSI0LjgiIGZpbGw9IiM5RUEzQTciIHdpZHRoPSI4LjYiIGhlaWdodD0iMyIvPjxyZWN0IHg9IjEwLjQiIHk9IjguNSIgZmlsbD0iIzlFQTNBNyIgd2lkdGg9IjguNiIgaGVpZ2h0PSIzIi8+PHJlY3QgeD0iMTAuNCIgeT0iMTIuMyIgZmlsbD0iIzlFQTNBNyIgd2lkdGg9IjguNiIgaGVpZ2h0PSIzIi8+PHJlY3QgeD0iMTAuNCIgeT0iMTYiIGZpbGw9IiM5RUEzQTciIHdpZHRoPSI4LjYiIGhlaWdodD0iMyIvPjwvZz48L2c+PGcgaWQ9IkxheWVyXzIiIGRpc3BsYXk9Im5vbmUiPjwvZz48L3N2Zz4=';


    global $wp_roster_wp_settings_page;
    
    $wp_roster_wp_settings_page = add_menu_page( 'WP Roster', 'WP Roster', 'manage_options', 'wp_roster', 'wp_roster_settings_page_content',$menu_icon_svg);
    
}
/**
* 
*
*
* Get other PHP files
*/
//callback function of setting page
function wp_roster_settings_page_content(){
    require('inc/options/options-page-wrapper.php');  
}

//Gets, sets and renders options
require('inc/options/options-output.php');

//produces the shortcode
require('inc/shortcode/roster-shortcode.php');
require('inc/shortcode/roster-shortcode-dates.php');
require('inc/shortcode/roster-shortcode-roster.php');
require('inc/shortcode/roster-shortcode-teams.php');
require('inc/shortcode/roster-shortcode-header.php');
require('inc/shortcode/roster-shortcode-history.php');

//gets general functions
require('inc/functions/helper-functions.php');
require('inc/functions/user-profile.php');

//get pro options
if($wp_roster_is_pro=="YES"){
    require('inc/pro-wpr/wp-roster-pro.php');
}
/**
* 
*
*
* Load admin style and scripts
*/
function wp_roster_register_admin_styles($hook)
{

    global $pagenow;
    global $wp_roster_wp_settings_page;
    
    if('profile.php' == $pagenow || 'user-edit.php' == $pagenow){
        //display on user profile page
        wp_enqueue_media();  
		wp_enqueue_script( 'user-profile-script-rp-roster', plugins_url( '/inc/js/userprofile.js', __FILE__ ), array( 'jquery' ),wp_roster_plugin_get_version());
		wp_enqueue_style( 'time-date-picker-style', plugins_url( '/inc/css/flatpickr.min.css', __FILE__ ));
		wp_enqueue_script( 'time-date-picker-script-wp-roster',plugins_url('/inc/js/flatpickr.js', __FILE__ ), array( 'jquery')); 
    }
    
    
    if($hook != $wp_roster_wp_settings_page ){
        return;    
    } else {
        //css
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'custom-admin-style-wp-roster', plugins_url( '/inc/css/adminstyle.css', __FILE__ ),array(),wp_roster_plugin_get_version());
		wp_enqueue_style( 'simple-line-icons', plugins_url( '/inc/css/simple-line-icons.css', __FILE__ ));
		// wp_enqueue_style( 'alertyify', plugins_url( '/inc/css/alertify.css', __FILE__ ));

        //js
        wp_enqueue_script( 'custom-admin-script-wp-roster', plugins_url( '/inc/js/adminscript.js', __FILE__ ), array( 'jquery','wp-color-picker' ),wp_roster_plugin_get_version());
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script('jquery-ui-accordion'); 
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-form');
		wp_enqueue_media(); 

		wp_enqueue_script('clipboard', plugins_url('/inc/js/clipboard.min.js', __FILE__ ), array( 'jquery'),'2.0.4');
		wp_enqueue_script('PapaParse', plugins_url('/inc/js/papaparse.min.js', __FILE__ ), array( 'jquery'));
		wp_enqueue_script('alertify', plugins_url('/inc/js/alertify.js', __FILE__ ), array( 'jquery'),null,true);    
        
    }
    
}
add_action( 'admin_enqueue_scripts', 'wp_roster_register_admin_styles' );
/**
* 
*
*
* Load frontend  style and scripts
*/
function wp_roster_register_frontend_styles()
{

    //get settings
    $options = get_option('wp_roster_settings');
        
    //css
    wp_enqueue_style( 'custom-frontend-style-wp-roster', plugins_url( '/inc/css/frontendstyle.css', __FILE__ ),array(),wp_roster_plugin_get_version());
	//print styling
	wp_enqueue_style( 'custom-frontend-print-style-wp-roster', plugins_url( '/inc/css/print.css', __FILE__ ),array(),wp_roster_plugin_get_version(),'print');
	//external styles
	wp_enqueue_style( 'simple-line-icons', plugins_url( '/inc/css/simple-line-icons.css', __FILE__ ));
	wp_enqueue_style( 'time-date-picker-style', plugins_url( '/inc/css/flatpickr.min.css', __FILE__ ));
	wp_enqueue_style( 'google-font-wp-roster','https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i'); 

    //js
    wp_register_script( 'custom-frontend-script-wp-roster', plugins_url( '/inc/js/frontendscript.js', __FILE__ ), array( 'jquery'), wp_roster_plugin_get_version());
	wp_enqueue_script(array('custom-frontend-script-wp-roster'));
	wp_enqueue_script('alertify', plugins_url('/inc/js/alertify.js', __FILE__ ), array( 'jquery'),null,true); 
	
	wp_localize_script('custom-frontend-script-wp-roster','save_settings', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','restore_settings', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );  
	wp_localize_script('custom-frontend-script-wp-roster','add_date', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','add_member', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','use_existing_member', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','update_existing_member', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','delete_existing_member', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','update_member_information', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','update_member_information_update_data', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','add_team', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','add_notification_group', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','save_settings_attendance', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script('custom-frontend-script-wp-roster','add_file_to_roster', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	
	wp_enqueue_script('scroll-reveal-wp-roster', plugins_url('/inc/js/scrollreveal.min.js', __FILE__ ), array( 'jquery'));
	wp_enqueue_script('scroll-to-wp-roster', plugins_url('/inc/js/jquery.scrollTo.min.js', __FILE__ ), array( 'jquery'));
	wp_enqueue_script('tippy-wp-roster', plugins_url('/inc/js/tippy.all.min.js', __FILE__ ), array( 'jquery'));



	//jsPdf
	wp_enqueue_script('jspdf-wp-roster', plugins_url('/inc/js/jspdf.min.js', __FILE__ ), array( 'jquery'));
	wp_enqueue_script('jspdf-fromhtml-wp-roster', plugins_url('/inc/js/from_html.js', __FILE__ ), array( 'jquery'));
	wp_enqueue_script('jspdf-splittext-wp-roster', plugins_url('/inc/js/split_text_to_size.js', __FILE__ ), array( 'jquery'));
	wp_enqueue_script('jspdf-fontmetrics-wp-roster', plugins_url('/inc/js/standard_fonts_metrics.js', __FILE__ ), array( 'jquery'));
	wp_enqueue_script('jspdf-autotable', plugins_url('/inc/js/jspdf.plugin.autotable.min.js', __FILE__ ), array( 'jquery'));


	


	wp_enqueue_script('jquery-ui-sortable');
	
	
	wp_enqueue_script('jquery-effects-slide');
	wp_enqueue_script( 'time-date-picker-script-wp-roster',plugins_url('/inc/js/flatpickr.js', __FILE__ ), array( 'jquery')); 
	



}
add_action( 'wp_enqueue_scripts', 'wp_roster_register_frontend_styles' );
/**
* 
*
*
* Load languages
*/
function wp_roster_languages() {
  load_plugin_textdomain( 'wp-roster', false, 'wp-roster/inc/languages' );
}
add_action('init', 'wp_roster_languages');
/**
* 
*
*
* Add custom links to plugin on plugins page
*/
function wp_roster_plugin_links( $links, $file ) {
    if ( strpos( $file, 'wp-roster.php' ) !== false ) {
       $new_links = array(
                '<a href="https://northernbeacheswebsites.com.au/product/donate-to-northern-beaches-websites/" target="_blank">' . __('Donate') . '</a>',
                '<a href="https://wordpress.org/support/plugin/wp-roster" target="_blank">' . __('Support Forum') . '</a>',
             );
       $links = array_merge( $links, $new_links );
    }
    return $links;
 }
 add_filter( 'plugin_row_meta', 'wp_roster_plugin_links', 10, 2 );
/**
* 
*
*
* Adds custom template to page
*/
 class PageTemplater {

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance;

	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;

	/**
	 * Returns an instance of this class. 
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new PageTemplater();
		} 

		return self::$instance;

	} 

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	private function __construct() {

		$this->templates = array();


		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {

			// 4.6 and older
			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'register_project_templates' )
			);

		} else {

			// Add a filter to the wp 4.7 version attributes metabox
			add_filter(
				'theme_page_templates', array( $this, 'add_new_template' )
			);

		}

		// Add a filter to the save post to inject out template into the page cache
		add_filter(
			'wp_insert_post_data', 
			array( $this, 'register_project_templates' ) 
		);


		// Add a filter to the template include to determine if the page has our 
		// template assigned and return it's path
		add_filter(
			'template_include', 
			array( $this, 'view_project_template') 
		);


		// Add your templates to this array.
		$this->templates = array(
			'roster-template.php' => 'WP Roster',
		);
			
	} 

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 */
	public function register_project_templates( $atts ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list. 
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		} 

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key , 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	} 

	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_project_template( $template ) {
		
		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}

		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[get_post_meta( 
			$post->ID, '_wp_page_template', true 
		)] ) ) {
			return $template;
		} 

		$file = plugin_dir_path( __FILE__ ).'/inc/templates/'. get_post_meta( 
			$post->ID, '_wp_page_template', true
        );

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		// Return template
		return $template;

	}

} 
add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );
/**
* 
*
*
* Custom user columns
*/
function wp_roster_user_table( $column ) {
    $column['phone'] = 'Phone';
    $column['preference'] = 'Preference';
    return $column;
}
add_filter( 'manage_users_columns', 'wp_roster_user_table' );

function wp_roster_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'phone' :
            return get_the_author_meta( 'wp-roster-phone', $user_id );
            break;
        case 'preference' :
		return get_the_author_meta( 'wp-roster-preference', $user_id );
            break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'wp_roster_user_table_row', 10, 3 );







/**
* 
*
*
* Do pro updates
*/
if($wp_roster_is_pro == 'YES'){

    require 'inc/pro-wpr/plugin-update-checker/plugin-update-checker.php';
	global $plugin_update_checker_wp_roster;
    $plugin_update_checker_wp_roster = Puc_v4_Factory::buildUpdateChecker(
        'https://northernbeacheswebsites.com.au/?update_action=get_metadata&update_slug=wp-roster', //Metadata URL.
        __FILE__, //Full path to the main plugin file.
        'wp-roster' //Plugin slug. Usually it's the same as the name of the directory.
    );


    //add queries to the update call
    $plugin_update_checker_wp_roster->addQueryArgFilter('filter_update_checks_wp_roster');
    function filter_update_checks_wp_roster($queryArgs) {

	
        $pluginSettings = get_option('wp_roster_settings');

        if(isset($pluginSettings['wp_roster_purchase_email']) && isset($pluginSettings['wp_roster_order_id'])){

            $purchaseEmailAddress = $pluginSettings['wp_roster_purchase_email'];
            $orderId = $pluginSettings['wp_roster_order_id'];
            $siteUrl = get_site_url();
			$siteUrl = parse_url($siteUrl);
			$siteUrl = $siteUrl['host'];

            if (!empty($purchaseEmailAddress) &&  !empty($orderId)) {
                $queryArgs['purchaseEmailAddress'] = $purchaseEmailAddress;
                $queryArgs['orderId'] = $orderId;
                $queryArgs['siteUrl'] = $siteUrl;
                $queryArgs['productId'] = '10972';
            }

        }

        return $queryArgs;   
    }






    // define the puc_request_info_result-<slug> callback 
	$plugin_update_checker_wp_roster->addFilter(
		'request_info_result', 'filter_puc_request_info_result_slug_wp_roster', 10, 2
	);
	
    function filter_puc_request_info_result_slug_wp_roster( $plugininfo, $result ) { 
        //get the message from the server and set as transient
        set_transient('wp-roster-update',$plugininfo->{'message'},YEAR_IN_SECONDS * 1);

        return $plugininfo; 
    }; 







    $path = plugin_basename( __FILE__ );

    add_action("after_plugin_row_{$path}", function( $plugin_file, $plugin_data, $status ) {

        //get plugin settings
        $pluginSettings = get_option('wp_roster_settings');


        if (!empty($pluginSettings['wp_roster_purchase_email']) &&  !empty($pluginSettings['wp_roster_order_id'])) {

			$order_id = $pluginSettings['wp_roster_order_id'];

            //get transient
            $message = get_transient('wp-roster-update');

            if($message !== 'Yes' && $message !== false){

                $purchaseLink = 'https://northernbeacheswebsites.com.au/wp-roster-pro/';

                if($message == 'Incorrect Details'){
                    $displayMessage = 'The Order ID and Purchase ID you entered is not correct. Please double check the details you entered to receive product updates.';    
                } elseif ($message == 'Licence Expired'){
                    $displayMessage = 'Your licence has expired. Please <a href="'.$purchaseLink.'" target="_blank">purchase a new licence</a> to receive further updates for this plugin.';    
                } elseif ($message == 'Website Mismatch') {
                    $displayMessage = 'This plugin has already been registered on another website using your details. Under the licence terms this plugin can only be used on one website. Please <a href="'.$purchaseLink.'" target="_blank">click here</a> to purchase an additional licence. To change the website assigned to your licence, please click <a href="https://northernbeacheswebsites.com.au/my-account/view-order/'.$order_id.'/" target="_blank">here</a>.';    
                } else {
                    $displayMessage = '';    
                }

                echo '<tr class="plugin-update-tr active"><td colspan="3" class="plugin-update colspanchange"><div class="update-message notice inline notice-error notice-alt"><p class="installer-q-icon">'.$displayMessage.'</p></div></td></tr>';

            }

        } else {

            echo '<tr class="plugin-update-tr active"><td colspan="3" class="plugin-update colspanchange"><div class="update-message notice inline notice-error notice-alt"><p class="installer-q-icon">Please enter your Order ID and Purchase ID in the plugin settings to receive automatics updates.</p></div></td></tr>';

        }


    }, 10, 3 );


	/**
	* 
	*
	*
	* Force check for updates
	*/
	function wp_roster_force_check_for_updates(){
		global $plugin_update_checker_wp_roster;
		
		$plugin_update_checker_wp_roster->checkForUpdates();
	}


}






?>