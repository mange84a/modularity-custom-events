<?php

namespace ModularityCustomEvents;

use ModularityCustomEvents\Helper\CacheBust;

class App
{
    public function __construct()
    {

        //Init subset
        new Admin\Settings();

        //Register module
        add_action('plugins_loaded', array($this, 'registerModule'));

        //Register post type
        new \ModularityCustomEvents\Entity\PostType(__('Custom events', 'modularity-customevents'), __('Custom event', 'modularity-customevents'), 'custom-events', array(
            'description' => __('Locally stored custom events', 'modularity-customevents'),
            'menu_icon' => 'dashicons-list-view',
            'public' => true,
            'publicly_queriable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'has_archive' => false,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'rewrite' => array(
                'slug' => 'custom-events',
                'with_front' => false
            ),
            'taxonomies' => array(),
            'supports' => array('title', 'revisions', 'editor')
        ));

        

        // Add view paths
        add_filter('Municipio/blade/view_paths', array($this, 'addViewPaths'), 1, 1);
    }

    /**
     * Register the module
     * @return void
     */
    public function registerModule()
    {
        if (function_exists('modularity_register_module')) {
            modularity_register_module(
                MODULARITY_CUSTOMEVENTS_MODULE_PATH,
                'CustomEvents'
            );
        }
    }
    /**
     * Add searchable blade template paths
     * @param array  $array Template paths
     * @return array        Modified template paths
     */
    public function addViewPaths($array)
    {
        // If child theme is active, insert plugin view path after child views path.
        if (is_child_theme()) {
            array_splice($array, 2, 0, array(MODULARITY_CUSTOMEVENTS_VIEW_PATH));
        } else {
            // Add view path first in the list if child theme is not active.
            array_unshift($array, MODULARITY_CUSTOMEVENTS_VIEW_PATH);
        }

        return $array;
    }
}
