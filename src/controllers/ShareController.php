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

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    public $allowAnonymous = true;

    // Public Methods
    // =========================================================================

//    /**
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        // Do they have permission?
//        $this->requirePermission('library-manageShares');
//
//        $request = Craft::$app->getRequest();
//        $elementId = $request->getRequiredParam('elementId');
//
//        return Library::$plugin->share->createShare($elementId);
//    }
//
//    /**
//     * @return mixed
//     */
//    public function actionDelete(int $elementId)
//    {
//        // Do they have permission?
//        $this->requirePermission('library-manageShares');
//        return Library::$plugin->share->removeShare($elementId);
//    }

    /**
     * @return mixed
     */
    public function actionToggle()
    {

        $this->requirePostRequest();
        $this->requirePermission('library-manageShares');

        $request = Craft::$app->getRequest();
        $elementId = $request->getRequiredParam('elementId');
        $isHtmx = $request->getParam('htmx');

        Library::$plugin->share->toggleShare($elementId);

        if ($isHtmx) {
            return $this->renderTemplate('_library/dialogs/share', ['id' => $elementId]);
        }
        return $this->redirectToPostedUrl();
    }

}
