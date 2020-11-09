<?php
/**
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\library\records;

use sitemill\library\Library;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class ShareRecord extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%library_shares}}';
    }
}
