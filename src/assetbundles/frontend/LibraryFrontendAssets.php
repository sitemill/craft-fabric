<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\library\assetbundles\frontend;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use craft\web\View;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class LibraryFrontendAssets extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        $this->sourcePath = '@sitemill/library/assetbundles/frontend/dist';
        $this->css = [
            ['app.scss', 'position' => \yii\web\View::POS_END]
        ];
        $this->js = [
            'manifest.js',
            'vendor.js',
            'app.js'
        ];
        parent::init();
    }
}
