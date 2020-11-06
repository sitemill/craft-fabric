<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\library\assetbundles\library;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class LibraryAssets extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@sitemill/library/assetbundles/library/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'manifest.js',
            'vendor.js',
            'library.js'
        ];

        $this->css = [
            'library.scss',
        ];

        parent::init();
    }
}
