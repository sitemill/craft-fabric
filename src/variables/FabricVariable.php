<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\fabric\variables;

use Craft;
use sitemill\fabric\Fabric;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class FabricVariable
{
    public function settings()
    {
        return Fabric::$plugin->getSettings();
    }

    public function isPublic($element)
    {
        return Fabric::$plugin->share->isPublic($element->id);
    }

    public function theme()
    {
        return Fabric::$plugin->getSettings()->theme;
    }

    public function brandColor()
    {
        return Fabric::$plugin->getSettings()->brandColor;
    }

    public function brandColors()
    {
        return Fabric::$plugin->getSettings()->brandColors;
    }

    public function siloInstalled()
    {
        $silo = Craft::$app->plugins->getPlugin('silo');
        return $silo && $silo->isInstalled;
    }

    public function siloActive()
    {
        $silo = Craft::$app->plugins->getPlugin('silo');
        return $silo && $silo->isInstalled && ($this->settings()->assetsSource == 'silo');
    }
}
