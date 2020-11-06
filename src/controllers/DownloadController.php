<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\library\controllers;

use craft\helpers\FileHelper;

use Craft;
use craft\web\Controller;
use sitemill\library\Library;
use sitemill\library\services\LibraryAssets;
use yii\base\Exception;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class DownloadController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $libraryAssetsEnabled = Library::$plugin->getSettings()->assetsSource == 'libraryAssets';

        $request = Craft::$app->getRequest();

        // Get the files
        $fileIds = $request->getRequiredParam('files');

        // Decide whether or not to archive em'
        if (count($fileIds) > 1) {
            $file = Library::$plugin->download->archive($fileIds);
        } else {
            // Handle library asset if enabled
            if ($libraryAssetsEnabled) {
                $file = \sitemill\library\elements\LibraryAsset::find()->id($fileIds[0])->one()->file->getCopyOfFile();
            } else {
                $file = Craft::$app->assets->getAssetById($fileIds[0])->getCopyOfFile();
            }
        }

        // Push the download
        if (!$response = Craft::$app->getResponse()->sendFile($file, null, ['forceDownload' => true])) {
            throw new Exception(Craft::t('library', 'Failed to download files'));
        }

        // Record the downloads
        if ($libraryAssetsEnabled) {
            foreach ($fileIds as $libraryAssetId) {
                LibraryAssets::instance()->incrementDownloads($libraryAssetId);
            }
        }

        // Delete the temp file
        FileHelper::unlink($file);

        return $response;

    }
}
