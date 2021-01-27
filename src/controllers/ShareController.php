<?php
/**
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\fabric\controllers;

use sitemill\fabric\Fabric;

use Craft;
use craft\web\Controller;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class ShareController extends Controller
{

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionToggle()
    {
        $this->requirePostRequest();
        $this->requirePermission('fabric-manageShares');

        $request = Craft::$app->getRequest();
        $elementId = $request->getRequiredParam('elementId');
        $redirect = $request->getRequiredParam('redirect');

        Fabric::$plugin->share->toggleShare($elementId);

        return $this->redirect($redirect);
    }

}
