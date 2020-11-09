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
use sitemill\library\services\Share as ShareService;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use craft\events\ElementEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\helpers\UrlHelper;
use craft\services\Elements;
use craft\services\UserPermissions;


use yii\base\Event;

/**
 * Class Library
 *
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 *
 * @property  ShareService $share
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
                $event->rules['/'] = ['template' => '_library/pages/all'];
                $event->rules['login'] = ['template' => '_library/pages/login'];
                $event->rules['register'] = ['template' => '_library/pages/register'];
                $event->rules['all'] = ['template' => '_library/pages/all'];
                $event->rules['search'] = ['template' => '_library/pages/all'];
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
                    // Send them to our welcome screen
                    $request = Craft::$app->getRequest();
                    if ($request->isCpRequest) {
                        Craft::$app->getResponse()->redirect(UrlHelper::cpUrl(
                            'settings/plugins/library'
                        ))->send();
                    }
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

        // Register permissions
        Event::on(UserPermissions::class, UserPermissions::EVENT_REGISTER_PERMISSIONS, function(RegisterUserPermissionsEvent $event) {
            $event->permissions[Craft::t('library', 'Library')] = [
                'library-manageShares' => ['label' => Craft::t('library', 'Toggle sharing on elements')]
            ];
        });


        // Add the lightswitch to entries
        Craft::$app->view->hook('cp.entries.edit.settings', function(&$context) {
            return Craft::$app->getView()->renderTemplate('library/_components/switch.twig', $context);
        });

        // Add the lightswitch to assets
        Craft::$app->view->hook('cp.assets.edit.settings', function(&$context) {
            return Craft::$app->getView()->renderTemplate('library/_components/switch.twig', $context);
        });

        // If DAM is installed, hook onto that template
        if (Craft::$app->plugins->getPlugin('dam')) {
            Craft::$app->view->hook('dam.assets.edit.settings', function(&$context) {
                return Craft::$app->getView()->renderTemplate('library/_components/switch.twig', $context);
            });
        }

        // Toggle share status on element save
        Event::on(
            Elements::class,
            Elements::EVENT_AFTER_SAVE_ELEMENT,
            function(ElementEvent $event) {
                $request = Craft::$app->getRequest();
                $elementId = $event->element->id;
                $isPublic = $request->getParam('elementPublic');
                if ($isPublic) {
                    Library::$plugin->share->createShare($elementId);
                } else {
                    Library::$plugin->share->removeShare($elementId);
                }
            }
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
