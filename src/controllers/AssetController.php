<?php
/**
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\fabric\controllers;

use sitemill\fabric\Fabric;

use Craft;
use craft\elements\Asset;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * Class AssetController
 *
 * @package sitemill\fabric\controllers
 */
class AssetController
{
//    TODO: Get rid of this
    /**
     * Returns an asset’s thumbnail.
     *
     * @param string $uid The asset's UID
     * @param int $width The thumbnail width
     * @param int $height The thumbnail height
     * @return Response
     * @since 3.0.13
     */
    public function actionThumb(string $uid, int $width, int $height): Response
    {
        $asset = Asset::find()->uid($uid)->one();


        if (!$asset) {
            $e = new NotFoundHttpException('Invalid asset UID: ' . $uid);
            Craft::$app->getErrorHandler()->logException($e);
            return $this->asBrokenImage($e);
        }

        try {
            $path = Craft::$app->getAssets()->getThumbPath($asset, $width, $height, true);
        } catch (\Throwable $e) {
            Craft::$app->getErrorHandler()->logException($e);
            return $this->asBrokenImage($e);
        }

        return $this->response
            ->setCacheHeaders()
            ->sendFile($path, $asset->getFilename(), [
                'inline' => true,
            ]);
    }

    /**
     * Sends a broken image response based on a given exception.
     *
     * @param \Throwable|null $e The exception that was thrown
     * @return Response
     * @since 3.4.8
     */
    protected function asBrokenImage(\Throwable $e = null): Response
    {
        $statusCode = $e instanceof HttpException && $e->statusCode ? $e->statusCode : 500;
        return $this->response
            ->sendFile(Craft::getAlias('@appicons/broken-image.svg'), 'nope.svg', [
                'mimeType' => 'image/svg+xml',
                'inline' => true,
            ])
            ->setStatusCode($statusCode);
    }
}