<?php
/**
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\fabric\services;

use sitemill\fabric\Fabric;
use sitemill\fabric\records\ShareRecord;

use Craft;
use craft\base\Component;

use DateTime;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class Share extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function createShare($elementId,$expiryDate = null)
    {

        // See if this element is already shared
        $shareRecord = ShareRecord::find()
            ->where(['elementId' => $elementId])
            ->one();

        // if share doesn't exist, create one
        if (!$shareRecord) {
            $userId = Craft::$app->getUser()->getIdentity()->id;

            $shareRecord = new ShareRecord();
            $shareRecord->setAttribute('elementId', $elementId);
            $shareRecord->setAttribute('sharerId', $userId);
            $shareRecord->setAttribute('dateCreated',(new DateTime('now'))->format('Y-m-d'));
            $shareRecord->save();
        }

        return $shareRecord->uid;
    }

    /*
     * @return mixed
     */
    public function removeShare($elementId) {
        // Find record
        $shareRecord = ShareRecord::find()
            ->where(['elementId' => $elementId])
            ->one();
        if ($shareRecord) {
            $shareRecord->delete();
        }
    }

    /*
     * @return mixed
     */
    public function toggleShare($elementId)
    {
        if ($this->isPublic($elementId)) {
            $this->removeShare($elementId);
        } else {
            $this->createShare($elementId);
        }
        return true;
    }

    /*
     * @return mixed
     */
    public function isPublic($elementId) {

        $shareRecord = ShareRecord::find()
            ->where(['elementId' => $elementId])
            ->one();

        if (!$shareRecord) {
             return false;
        }
        return true;
    }
}
