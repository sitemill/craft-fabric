<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\library\models;

use sitemill\library\Library;

use Craft;
use craft\base\Model;
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
    public $public = false;

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
     * @var array Determines the fields shown on asset page
     */
    public $assetFields = [];


    /**
     * @var array Determines the file types used within Library
     */
    public $fileKinds = [
        'image' => [
            'title' => 'Image',
            'value' => 'image',
            'icon' => ''
        ],
        'video' => [
            'title' => 'Video',
            'value' => 'video',
        ],
        'compressed' => [
            'title' => 'Compressed',
            'value' => 'compressed',
        ]
    ];

    /**
     * @var array Determines the sorting options for assets
     */
    public $ordering = [
        [
            'label' => 'Title A-Z',
            'value' => 'title asc',
        ],
        [
            'label' => 'Title Z-A',
            'value' => 'title desc',
        ],
        [
            'label' => 'Newest First',
            'value' => 'dateCreated desc',
        ],
        [
            'label' => 'Oldest First',
            'value' => 'dateCreated asc',
        ]
    ];

    // TODO: Write detailed instructions and examples

    /**
     * @var array Determines the default meta components for an asset
     */
    public $metaItems = [];


//    FRONT END

    /**
     * @var array Determines the components to be used in the navigation
     */
    public $colors = [
        // Theme colours
        'canvas' => 'white',
        'type' => '#2d2d2d',
        'primary' => '#6816D0',
        'text' => [
            'on-primary' => 'white'
        ]
    ];


// TODO: update rules
// Public Methods
// =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['public', 'boolean'],
            [
                [
                    'navigation',
                    'fileKinds',
                    'ordering',
                    'metaItems',
                    'colors'
                ],
                ArrayValidator::class,
            ],
        ];
    }
}
