<?php

namespace ModularityCustomEvents\Module;

use ModularityCustomEvents\Helper\CacheBust;

/**
 * Class CustomEvents
 * @package CustomEvents\Module
 */
class CustomEvents extends \Modularity\Module
{
    public $slug = 'customevents';
    public $supports = array();

    public function init()
    {
        $this->nameSingular = __("CustomEvents", 'modularity-customevents');
        $this->namePlural = __("CustomEvents", 'modularity-customevents');
        $this->description = __("Custom Events.", 'modularity-customevents');
    }

    /**
     * Data array
     * @return array $data
     */
    public function data(): array
    {
        $data = array();

        //Append field config
        $data = array_merge($data, (array) \Modularity\Helper\FormatObject::camelCase(
            get_fields($this->ID)
        ));
        //Get categories?
        $categories = []; 
        if(!empty($data['eventCategories'])) {
            foreach ($data['eventCategories'] as $category) {
                $categories[] = $category;
            }
        
        }
        $events = $this->getEvents(5, $categories);
        $data['events'] = $this->formatEvents($events['posts']);

        return $data;
    }
    private function getEvents($limit = 5, $categories = []) {
        $tax_query = null;
        if(!empty($categories)) {
            $tax_query = [
                'taxonomy' => 'custom-events_category',
                'field' => 'term_id', 
                'terms' => $categories, 
                'include_children' => false
            ];
        }

        $query = new \WP_Query(array(
            'post_type' => 'custom-events',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'meta_query' => array(array( 'key' => 'date', 'value' => date('Ymd'), 'compare' => '>=' )),
            'meta_key' => 'date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'suppress_filters' => true,
            'tax_query' => [$tax_query]
        ));

        if(!is_wp_error($query)) {
            return [
                'postcount' => $query->found_posts,
                'posts' => $query->posts
            ];
        }

        return false; 
    }
    
    public function formatEvents($events) {

        $dateHelper = new \Modularity\Helper\Date();

        if(is_array($events) && !empty($events)) {

            foreach ($events as $key => $event) {

                $fields     = get_fields($event->ID);
                $timestamp  = $dateHelper->getTimeStamp($fields['date']);

                $formattedDate = wp_date($dateHelper->getDateFormat('date'), $timestamp); 
                $formattedStartTime = wp_date($dateHelper->getDateFormat('time'), $dateHelper->getTimeStamp($fields['start_time']));  
    
                $event->day         = wp_date("j", $timestamp);
                $event->monthShort  = wp_date("M", $timestamp);
                $event->link        = get_permalink($event->ID);
                $event->dateFormatted = "{$formattedDate}, {$formattedStartTime}";
    
                if($fields['end_time']) {
                    $formattedEndTime = wp_date($dateHelper->getDateFormat('time'), $dateHelper->getTimeStamp($fields['end_time'])); 
                    $event->dateFormatted = $event->dateFormatted . " - {$formattedEndTime}";
                }
    
                $events[$key] = $event;
            }
        }

        return $events;
    }


    /**
     * Blade Template
     * @return string
     */
    public function template(): string
    {
        return "customevents.blade.php";
    }

    /**
     * Style - Register & adding css
     * @return void
     */
    public function style()
    {
        //Register custom css
        wp_register_style(
            'modularity-customevents',
            MODULARITY_CUSTOMEVENTS_URL . '/dist/' . CacheBust::name('css/modularity-customevents.css'),
            null,
            '1.0.0'
        );

        //Enqueue
        wp_enqueue_style('modularity-customevents');
    }

    /**
     * Script - Register & adding scripts
     * @return void
     */
    public function script()
    {
        //Register custom css
        wp_register_script(
            'modularity-customevents',
            MODULARITY_CUSTOMEVENTS_URL . '/dist/' . CacheBust::name('js/modularity-customevents.js'),
            null,
            '1.0.0'
        );

        //Enqueue
        wp_enqueue_script('modularity-customevents');
    }

    /**
     * Available "magic" methods for modules:
     * init()            What to do on initialization
     * data()            Use to send data to view (return array)
     * style()           Enqueue style only when module is used on page
     * script            Enqueue script only when module is used on page
     * adminEnqueue()    Enqueue scripts for the module edit/add page in admin
     * template()        Return the view template (blade) the module should use when displayed
     */
}
