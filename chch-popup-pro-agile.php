<?php
/**
 *
 * @package   ChChPopUpProAgile
 * @author    Martin Petts <martin@netizn.co>
 * @license   GPL-2.0+
 * @link      https://netizn.co
 * @copyright 2016
 *
 * @wordpress-plugin
 * Plugin Name:       Pop-Up Pro CC AgileCRM
 * Plugin URI:        http://netizn.co
 * Description:       Force all Pop-Up Pro instances to go to AgileCRM.
 * Version:           1.0.0
 * Author:            Martin Petts <martin@netizn.co>
 * Author URI:        http://netizn.co
 * Text Domain:       cc-pop-up-agile
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

if(!function_exists('pr')) {
  function pr($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
  }
}

define( 'CHCH_POP_UP_PRO_AGILE_URL', plugin_dir_url( __FILE__ ) );
define( 'CHCH_POP_UP_PRO_AGILE_DIR', plugin_dir_path( __FILE__ ) );

// If saving a pop-up ensure that the AgileCRM Adapter is set always
function chch_popup_pro_agile_set_adapter() {
  if(!empty($_POST['_chch_pop_up_pro_newsletter_adapter'])) {
    $_POST['_chch_pop_up_pro_newsletter_adapter'] = 'AgileCRM';
  }
}
add_action('admin_init', 'chch_popup_pro_agile_set_adapter');

function chch_popup_pro_agile_init() {
  require_once(CHCH_POP_UP_PRO_AGILE_DIR . 'vendor/agilecrm/php-api-master/CurlLib/curlwrap_v2.php');

  require_once(CHCH_POP_UP_PRO_AGILE_DIR . 'newsletter/Newsletter/AgileCRM.php');
}
add_action('plugins_loaded', 'chch_popup_pro_agile_init');
