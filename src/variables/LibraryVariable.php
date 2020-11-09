<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\library\variables;

use Craft;
use sitemill\library\Library;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class LibraryVariable
{
    public function settings()
    {
        return Library::$plugin->getSettings();
    }

    public function isPublic($element)
    {
        return Library::$plugin->share->validateShare($element->id);
    }

    public function damInstalled()
    {
        $dam = Craft::$app->plugins->getPlugin('dam');
        return $dam && $dam->isInstalled;
    }
}
