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

use craft\helpers\UrlHelper;
use sitemill\library\Library;

use Craft;
use Traversable;

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
}
