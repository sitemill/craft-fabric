<?php
/**
 * Library plugin for Craft CMS 3.x
 *
 * Library is a drop in digital asset manager for Craft CMS 3.5+
 *
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\fabric;

use sitemill\fabric\variables\FabricVariable;
use sitemill\fabric\models\Settings;
use sitemill\fabric\services\Share as ShareService;

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
class Fabric extends Plugin
{

    // Static Properties
    // =========================================================================

    /**
     * @var Fabric
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

        // Trigger loading of global back-end asset bundle
        if ($request->isCpRequest) {
            $this->registerCpBundles();
        }

        // Register front-end templates
        Event::on(
            View::class,
            View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['_fabric'] = __DIR__ . '/templates/_frontend';
            }
        );


        // Register routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function(RegisterUrlRulesEvent $event) {
                $event->rules['/'] = ['template' => '_fabric/pages/home'];
                $event->rules['login'] = ['template' => '_fabric/pages/login'];
                $event->rules['register'] = ['template' => '_fabric/pages/register'];
                $event->rules['forgotpassword'] = ['template' => '_fabric/pages/forgotpassword'];
                $event->rules['all'] = ['template' => '_fabric/pages/listing'];
                $event->rules['search'] = ['template' => '_fabric/pages/listing'];
                $event->rules['asset/<assetId:\d+>/?<assetSlug>'] = ['template' => '_fabric/pages/asset'];
                $event->rules['account'] = ['template' => '_fabric/pages/account'];
                $event->rules['<section>/entry/<entryId:\d+>/?<entrySlug>'] = ['template' => '_fabric/pages/entry'];
                $event->rules['<section>/listing/'] = ['template' => '_fabric/pages/entryListing'];
                $event->rules['category/<categoryId:\d+>/?<categorySlug>'] = ['template' => '_fabric/pages/listing'];
                $event->rules[] = [
                    'pattern' => 'dialog/<action>/<elementType>/<id:\d+>',
                    'template' => '_fabric/dialogs/index',
                    'defaults' => [
                        'elementType' => '',
                    ]
                ];
                $event->rules[] = [
                    'pattern' => 'listing/<elementType>/<elementSource>',
                    'template' => '_fabric/pages/listing',
                    'defaults' => [
                        'elementType' => 'all',
                        'elementSource' => '',
                    ]
                ];
            }
        );


        // Register CP Routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function(RegisterUrlRulesEvent $event) {
            }
        );


        // Register Library variable
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('fabric', FabricVariable::class);
            }
        );


        // Do something on install
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function(PluginEvent $event) {
                if ($event->plugin === $this) {
                    // Send them to our welcome screen
                    $request = Craft::$app->getRequest();
                    if ($request->isCpRequest) {
                        Craft::$app->getResponse()->redirect(UrlHelper::cpUrl(
                            'settings/plugins/fabric'
                        ))->send();
                    }
                }
            }
        );


        Craft::info(
            Craft::t(
                'fabric',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );


        // Register permissions
        Event::on(UserPermissions::class, UserPermissions::EVENT_REGISTER_PERMISSIONS, function(RegisterUserPermissionsEvent $event) {
            $event->permissions[Craft::t('fabric', 'Fabric')] = [
                'fabric-manageShares' => ['label' => Craft::t('fabric', 'Toggle sharing on elements')]
            ];
        });


        // Register public switch
        if ($this->getSettings()->private and is_array($this->getSettings()->entrySources)) {
            // Add public lightswitch to entries
            Craft::$app->view->hook('cp.entries.edit.settings', function(&$context) {
                $sectionHandle = $context['sectionHandle'];
                if (array_key_exists($sectionHandle, $this->getSettings()->entrySources) && $this->getSettings()->entrySources[$sectionHandle]['enabled']) {
                    return Craft::$app->getView()->renderTemplate('fabric/_components/switch.twig', ['element' => $context['element']]);
                }
            });

            // Add public lightswitch to assets
            Craft::$app->view->hook('cp.assets.edit.settings', function(&$context) {
                if ($context['element']['volume']->handle == $this->getSettings()->assetsSource) {
                    return Craft::$app->getView()->renderTemplate('fabric/_components/switch.twig', ['element' => $context['element']]);
                }
            });

            // If Silo is installed, hook onto that template
            if (Craft::$app->plugins->getPlugin('silo')) {
                Craft::$app->view->hook('silo.assets.edit.settings', function(&$context) {
                    return Craft::$app->getView()->renderTemplate('fabric/_components/switch.twig', ['element' => $context['element']]);
                });
            }
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
                    Fabric::$plugin->share->createShare($elementId);
                } else {
                    Fabric::$plugin->share->removeShare($elementId);
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
            'fabric/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }

    protected function registerFrontEndAssetBundles()
    {
        $view = Craft::$app->getView();
        $view->registerAssetBundle('sitemill\\fabric\\assetbundles\\frontend\\FabricFrontendAssets');
    }

    protected function registerCpBundles()
    {
        $view = Craft::$app->getView();
        $view->registerAssetBundle('sitemill\\fabric\\assetbundles\\cp\\FabricCpAssets');
    }

}
