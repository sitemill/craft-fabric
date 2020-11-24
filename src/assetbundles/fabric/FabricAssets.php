<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\fabric\assetbundles\fabric;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class FabricAssets extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@sitemill/fabric/assetbundles/fabric/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'manifest.js',
            'vendor.js',
            'fabric.js'
        ];

        $this->css = [
            'fabric.scss',
        ];

        parent::init();
    }
}
