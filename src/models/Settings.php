<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\fabric\models;

use sitemill\fabric\Fabric;

use Craft;
use craft\base\Model;
use craft\helpers\UrlHelper;
use craft\validators\ArrayValidator;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var bool Is the site open to the public?
     */
    public $private = 0;


    /**
     * @var string The handle of the asset volume used by Library
     */
    public $assetsSource = null;


    /**
     * @var array Determines the entry sources
     */
    public $entrySources = [];


    /**
     * @var array Determines the site navigation
     */
    public $navigation = [];


    /**
     * @var array Determines the home route
     */
    public $homeRouteOverride = '';


    /**
     * @var array Determines the fields shown on asset page
     *
     *  $assetFields = [
     *      'description' => [
     *          'enabled' => 1
     *      ]
     *  ]
     *
     */
    public $assetFields = [

    ];

    /**
     * @var array The default asset fields
     */
    public $baseAssetFields = [
        'fabric_size' => [
            'label' => 'File Size',
            'enabled' => 1
        ],
        'fabric_dimensions' => [
            'label' => 'Dimensions',
            'enabled' => 1
        ],
        'fabric_kind' => [
            'label' => 'File Kind',
            'enabled' => 1
        ]
    ];


    /**
     * @var array Determines the file types used within Library
     */
    public $filterFileKinds = [
        'image' => [
            'title' => 'Images',
            'value' => 'image',
            'icon' => ''
        ],
        'video' => [
            'title' => 'Videos',
            'value' => 'video',
        ],
        'compressed' => [
            'title' => 'Archives',
            'value' => 'compressed',
        ],
        'pdf' => [
            'title' => 'PDF\'s',
            'value' => 'pdf',
        ]
    ];

    /**
     * @var array Determines the sorting options for assets
     */
    public $filterOrdering = [
        'title asc' => [
            'label' => 'Title A-Z',
        ],
        'title desc' => [
            'label' => 'Title Z-A',
        ],
        'dateCreated desc' => [
            'label' => 'Newest First',
        ],
        'dateCreated asc' => [
            'label' => 'Oldest First',
        ]
    ];


//    FRONT END

    /**
     * @var array Determines the components to be used in the navigation
     */
    public $colors = [
        // Theme colours
        'primary' => '#6816D0',
        'secondary' => ''
    ];


//// TODO: update rules
//// Public Methods
//// =========================================================================
//
//    /**
//     * @inheritdoc
//     */
//    public function rules()
//    {
//        return [
//            ['private', 'boolean'],
//            [
//                [
//                    'navigation',
//                    'fileKinds',
//                    'ordering',
//                    'metaItems',
//                    'colors'
//                ],
//                ArrayValidator::class,
//            ],
//        ];
//    }
}
