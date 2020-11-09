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
    protected $allowAnonymous = ['validate'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        // Do they have permission?
        $this->requirePermission('library-manageShares');

        $request = Craft::$app->getRequest();
        $elementId = $request->getRequiredParam('elementId');

        return Library::$plugin->share->createShare($elementId);
    }

    /**
     * @return mixed
     */
    public function actionDelete($shareId)
    {
        // Do they have permission?
        $this->requirePermission('library-manageShares');
        return Library::$plugin->share->removeShare($shareId);
    }

    /**
     * @return mixed
     */
    public function actionValidate()
    {
        $request = Craft::$app->getRequest();
        $elementId = $request->getRequiredParam('elementId');
        return Library::$plugin->share->validateShare($elementId);
    }

}
