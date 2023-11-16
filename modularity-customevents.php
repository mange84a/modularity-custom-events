<?php

/**
 * Plugin Name:       Modularity Custom Events
 * Plugin URI:        https://github.com/mange84a/modularity-customevents
 * Description:       Custom Events.
 * Version:           1.0.0
 * Author:            Magnus Andersson @ Webbma
 * Author URI:        https://github.com/mange84a
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       mod-customevents
 * Domain Path:       /languages
 */

 // Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('MODULARITY_CUSTOMEVENTS_PATH', plugin_dir_path(__FILE__));
define('MODULARITY_CUSTOMEVENTS_URL', plugins_url('', __FILE__));
define('MODULARITY_CUSTOMEVENTS_TEMPLATE_PATH', MODULARITY_CUSTOMEVENTS_PATH . 'templates/');
define('MODULARITY_CUSTOMEVENTS_VIEW_PATH', MODULARITY_CUSTOMEVENTS_PATH . 'views/');
define('MODULARITY_CUSTOMEVENTS_MODULE_VIEW_PATH', plugin_dir_path(__FILE__) . 'source/php/Module/views');
define('MODULARITY_CUSTOMEVENTS_MODULE_PATH', MODULARITY_CUSTOMEVENTS_PATH . 'source/php/Module/');

load_plugin_textdomain('modularity-customevents', false, plugin_basename(dirname(__FILE__)) . '/languages');

require_once MODULARITY_CUSTOMEVENTS_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once MODULARITY_CUSTOMEVENTS_PATH . 'Public.php';

// Instantiate and register the autoloader
$loader = new ModularityCustomEvents\Vendor\Psr4ClassLoader();
$loader->addPrefix('ModularityCustomEvents', MODULARITY_CUSTOMEVENTS_PATH);
$loader->addPrefix('ModularityCustomEvents', MODULARITY_CUSTOMEVENTS_PATH . 'source/php/');
$loader->register();

// Acf auto import and export
$acfExportManager = new \AcfExportManager\AcfExportManager();
$acfExportManager->setTextdomain('modularity-customevents');
$acfExportManager->setExportFolder(MODULARITY_CUSTOMEVENTS_PATH . 'source/php/AcfFields/');
$acfExportManager->autoExport(array(
    'customevents-module' => 'group_6552378ea7e89', //Update with acf id here, module view
    //'customevents-settings' => 'group_61ea7a87e8nnn' //Update with acf id here, settings view
));
$acfExportManager->import();

// Modularity 3.0 ready - ViewPath for Component library
add_filter('/Modularity/externalViewPath', function ($arr) {
    $arr['mod-customevents'] = MODULARITY_CUSTOMEVENTS_MODULE_VIEW_PATH;
    return $arr;
}, 10, 3);

// Start application
new ModularityCustomEvents\App();
