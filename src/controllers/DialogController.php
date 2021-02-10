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
class DialogController extends Controller
{

    // Public Methods
    // =========================================================================

    /**
     * @param string $action
     * @param string $elementType
     * @param int $id
     * @return mixed
     */
    public function actionIndex(string $action, int $id)
    {
        return $this->renderTemplate('_fabric/components/dialog/' . $action, [
            'action' => $action,
            'id' => $id
        ]);
    }

}
