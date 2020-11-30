<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\fabric\assetbundles\cp;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class FabricCpAssets extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@sitemill/fabric/assetbundles/cp";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'fabric-cp.js'
        ];

        $this->css = [
            'fabric-cp.css',
        ];

        parent::init();
    }
}
