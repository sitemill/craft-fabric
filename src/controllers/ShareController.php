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
        $elementType = $request->getRequiredParam('elementType');
        $refreshUrl = $request->getRequiredParam('refreshUrl');
        $isHtmx = $request->getParam('htmx');

        Fabric::$plugin->share->toggleShare($elementId);

        if ($isHtmx) {
            return $this->redirect($refreshUrl);
        }
        return $this->redirectToPostedUrl();
    }

}
