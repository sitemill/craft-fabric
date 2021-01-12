<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * x
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

/**
 * Library config.php
 *
 * This file exists only as a template for the Library settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'fabric.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [

    /*
     * Does the site require a login?
    */
    'private' => 1,

    /*
     * What volume, if any should we pull assets from?
     * If you are using SiteMill's Digitial Asset Manager, set this to 'dam'
    */
    'assetsSource' => null,

    /*
    * Entry Sources
    * ----------
    * Define the entry sections that will be used within Library eg.
    *
    * 'entrySources' => [
    *       'entrySectionHandle' => [
    *           'enabled' => 1,
    *           'showInSearch' => 1,
    *           'thumbnailField' => 'thumbnail',
    *           'defaultLayout' => 'grid'
    *       ],
    * ]
    *
    * Available entry source settings:
    * enabled - what it says on the tin
    * showInSearch - this section's entry's will show on the main search page
    * thumbnailField - a asset field to use as the entry's thumbnail
    * defaultLayout - can choose a default listing layout of either grid|list
    */

    'entrySources' => [],

    /*
     * Navigation
     * ----------
     * Define your navigation items as an array eg.
     * 'navigation' => [
     *      [
     *          'type' => 'link',
     *          'title' => 'Home',
     *          'source' => '/'
     *      ],
     *      [
     *          'type' => 'entryNav',
     *          'title' => 'Entry section title',
     *          'source' => 'entrySectionHandle'
     *      ],
     * ]
     *
     * Available navigation types:
     * heading - a heading of course
     * link - a straight forward redirect to a url defined in the 'source'
     * entryNav - displays all the enabled entries for the section defined in 'source'
     * entryListing - creates a link to a listing page containing all entries for the section defined in 'source'
     * categoriesNav - shows all categories for the category group defined in 'source
     */
    'navigation' => [
        [
            'type' => 'link',
            'title' => 'Home',
            'source' => '/'
        ]
    ],

    /*
     * Asset fields
     * ----------
     * Select which of the asset source's fields to show on the asset page eg.
     *
     *  'assetFields' = [
     *      'description' => [
     *          'enabled' => 1
     *      ]
     *  ]
     *
     */
    'assetFields' => []
];
