<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\library;

use sitemill\library\variables\LibraryVariable;
use sitemill\library\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;

use yii\base\Event;

/**
 * Class Library
 *
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 *
 */
class Library extends Plugin
{

    // Static Properties
    // =========================================================================

    /**
     * @var Library
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Trigger loading of front-end Bundles
        $request = Craft::$app->getRequest();
        if (
            $this->isInstalled
            && !$request->isConsoleRequest
            && !$request->isCpRequest
        ) {
            $this->registerFrontEndAssetBundles();
        }


        // Register front-end templates
        Event::on(
            View::class,
            View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['/'] = __DIR__ . '/templates/frontend';
            }
        );

        // Register routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function(RegisterUrlRulesEvent $event) {
                $event->rules['/'] = ['template' => '_library/pages/home'];
                $event->rules['login'] = ['template' => '_library/pages/login'];
                $event->rules['register'] = ['template' => '_library/pages/register'];
                $event->rules['all'] = ['template' => '_pages/all'];
                $event->rules['asset/<assetId:\d+>/?<assetSlug>'] = ['template' => '_library/pages/asset'];
                $event->rules['category/<categoryId:\d+>/?<categorySlug>'] = ['template' => '_library/pages/category'];
                $event->rules['account'] = ['template' => '_library/pages/account'];
                $event->rules['dialog/<action>/?<id:\d+>'] = ['template' => '_library/dialogs/index'];
                $event->rules['<section>/entry/<entryId:\d+>/?<entrySlug>'] = ['template' => '_library/pages/entry'];
                $event->rules['<section>/listing/'] = ['template' => '_library/pages/entryListing'];
            }
        );



        // Register CP Routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function(RegisterUrlRulesEvent $event) {
                $event->rules['settings/plugins/library/library-assets'] = 'library/library-assets/edit-field-layout';
            }
        );


        // Register Library variable
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('library', LibraryVariable::class);
            }
        );



        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function(PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'library',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'library/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }

    protected function registerFrontEndAssetBundles()
    {
        $view = Craft::$app->getView();
        $view->registerAssetBundle('sitemill\\library\\assetbundles\\frontend\\LibraryFrontendAssets');
    }
}
