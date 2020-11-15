<?php
/**
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\library\controllers;

use sitemill\library\Library;

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
        $this->requirePermission('library-manageShares');

        $request = Craft::$app->getRequest();
        $elementId = $request->getRequiredParam('elementId');
        $elementType = $request->getRequiredParam('elementType');
        $refreshUrl = $request->getRequiredParam('refreshUrl');
        $isHtmx = $request->getParam('htmx');

        Library::$plugin->share->toggleShare($elementId);

        if ($isHtmx) {
            return $this->redirect($refreshUrl);
        }
        return $this->redirectToPostedUrl();
    }

}
