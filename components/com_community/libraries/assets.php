<?php

/**
 * @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
 * @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author iJoomla.com <webmaster@ijoomla.com>
 * @url https://www.jomsocial.com/license-agreement
 * The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
 * More info at https://www.jomsocial.com/license-agreement
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');

/**
 * Class exists checking
 */
if (!class_exists('CAssets')) {

    /**
     * Global asset manager
     */
    class CAssets {

        /**
         * Constructor
         * @param string $name
         */
        protected function __construct($name = 'default') {
            $this->_init($name);
        }

        /**
         *
         * @staticvar CPath $instances
         * @param type $name
         * @return \CPath
         */
        public static function &getInstance($name = 'default') {
            static $instances;
            if (!isset($instances[$name])) {
                $instances[$name] = new CAssets();
            }
            return $instances[$name];
        }

        /**
         * Centralized location to attach asset to any page. It avoids duplicate attachement
         *
         * @staticvar boolean $added
         * @param string $path
         * @param string $type
         * @param string $assetPath
         * @return mixed
         */
        public static function attach($path, $type, $assetPath = '') {
            $document = JFactory::getDocument();
            $app = JFactory::getApplication();
            /* Do nothing if is not html document */
            if ($document->getType() != 'html')
                return;

            $template = new CTemplateHelper();

            /* Load our joms.jquery instance */
            if (!defined('C_ASSET_JQUERY')) {
                $template->getTemplateAsset('joms.jquery', 'js');
                $document->addScript(JURI::root(true) . '/components/com_community/assets/joms.jquery-1.8.1.min.js');
                define('C_ASSET_JQUERY', 1);
            }

            static $added = false;

            /* Load our script-1.2.js */
            if (!$added && $app->isSite()) {
                $script = $template->getTemplateAsset('script-1.2', 'js');
                $document->addScript($script->url);

                $signature = md5($script->url);
                define('C_ASSET_' . $signature, 1);
                $added = true;
            }

            if (!empty($assetPath)) {
                $path = $assetPath . $path;
            } else {
                $path = JURI::root(true) . '/components/com_community/' . JString::ltrim($path, '/');
            }

            if (!defined('C_ASSET_' . md5($path))) {
                define('C_ASSET_' . md5($path), 1);

                switch ($type) {
                    case 'js':
                        $document->addScript($path);
                        break;
                    case 'css':
                        $document->addStyleSheet($path);
                }
            }
        }

        /**
         * Load init asset file and attach it
         * @param string $name
         */
        protected function _init($name) {
            /* Assets init */
            /* Get assets config file */
            $assetFile = CFactory::getPath('assets://' . $name . '.json');
            if ($assetFile) {
                $assets = json_decode(file_get_contents($assetFile));
                /* Get assets's css files and attach it */
                foreach ($assets->core->css as $css) {
                    /* Get file path from assets namespace */
                    $cssFile = CFactory::getPath('assets://' . $css . '.css');
                    /* If file exists */
                    if ($cssFile) {
                        self::attach(JFile::getName($css) . '.css', 'css', CPath::getInstance()->toUrl(dirname($cssFile)) . '/');
                    }
                }
                /* Get assets's js files and attach it */
                foreach ($assets->core->js as $js) {
                    /* Get file path from assets namespace */
                    $jsFile = CFactory::getPath('assets://' . $js . '.js');
                    /* If file exists */
                    if ($jsFile) {
                        self::attach(JFile::getName($js) . '.js', 'js', CPath::getInstance()->toUrl(dirname($jsFile)) . '/');
                    }
                }
            }
            /* Template init */
            if (JFactory::getApplication()->isSite()) {
                /* Get template profile config */
                $templateFile = CFactory::getPath('template://profile.json');
                if ($templateFile) {
                    $assets = json_decode(file_get_contents($templateFile));
                    /* Get assets's css files and attach it */
                    foreach ($assets->core->css as $css) {
                        /* Get file path from template namespace */
                        $cssFile = CFactory::getPath('template://css/' . $css . '.css');
                        /* If file exists */
                        if ($cssFile) {
                            self::attach(JFile::getName($css) . '.css', 'css', CPath::getInstance()->toUrl(dirname($cssFile)) . '/');
                        }
                    }
                    /* Get assets's js files and attach it */
                    foreach ($assets->core->js as $js) {
                        /* Get file path from template namespace */
                        $jsFile = CFactory::getPath('template://js/' . $js . '.js');
                        /* If file exists */
                        if ($jsFile) {
                            self::attach(JFile::getName($js) . '.js', 'js', CPath::getInstance()->toUrl(dirname($jsFile)) . '/');
                        }
                    }
                }
            }
        }

    }

}