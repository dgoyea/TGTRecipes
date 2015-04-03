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

/**
 * Class exists checking
 */
if (!class_exists('CParserMetas')) {

    /* Use 3rd Simple HTML DOM */
    require_once JPATH_ROOT . '/components/com_community/libraries/vendor/simple_html_dom.php';

    /**
     * Extract data in <head>
     */
    class CParserMetas extends CParsers {

        /**
         *
         * @var SimpleHtmlDOM
         */
        private $_dom;

        /**
         *
         * @var array
         */
        private $_domBlocks = array();

        /**
         * Parsed properties
         * @var JRegistry 
         */
        private $_extracted;

        /**
         * 
         * @param type $properties
         */
        public function __construct($properties = null) {
            parent::__construct($properties);
            $this->_extracted = new JRegistry();
            $this->_init();
        }

        /**
         * 
         * @return \CParserMetas
         */
        protected function _init() {
            $this->_dom = str_get_html($this->get('content'));
            $this->_domBlocks['head'] = $this->_dom->find('head', 0);
            $this->_domBlocks['body'] = $this->_dom->find('body', 0);
            $this->_extracted->def('type', 'website');
            $this->_extracted->def('url', $this->get('url'));
            return $this;
        }

        private function _addArray($name, $array) {
            if (!is_array($array))
                $array = array($array);
            $data = $this->_extracted->get($name, array());
            $data = array_unique(array_merge_recursive($data, $array));
            $this->_add($name, $data);
            return $this;
        }

        private function _add($name, $value) {
            $this->_extracted->set($name, $value);
            return $this;
        }

        /**
         * Extract meta elements
         * @return \CParserMetas
         */
        private function _extractMeta() {
            /**
             * Init default values
             */
            $title = $this->_domBlocks['head']->find('title', 0);
            if ($title) {
                $this->_extracted->def('title', $title->plaintext);
            }

            $meta = $this->_domBlocks['head']->find('meta');

            /* Process all meta elements */
            foreach ($meta as $element) {
                $attributes = $element->attr;

                /**
                 * Opengraph
                 * @todo We can improve to get more opengraph information
                 */
                if (isset($attributes['property'])) {
                    /* We need to work with same specific property */
                    switch ($attributes['property']) {
                        case 'og:image':
                            $this->_addArray('image', $attributes['content']);
                            break;
                        case 'og:title':
                            $this->_add('title', $attributes['content']);
                            break;
                        case 'og:description':
                            $this->_add('description', $attributes['content']);
                            break;
                        /* add more opengraph here if need */
                        default:
                            $this->_add($attributes['property'], $attributes['content']);
                            break;
                    }
                } else {
                    /* meta with attribute "name" */
                    if (isset($attributes['name'])) {
                        if (isset($attributes['content']))
                            $this->_add($attributes['name'], $attributes['content']);
                        if (isset($attributes['value']))
                            $this->_add($attributes['name'], $attributes['value']);
                    } elseif (isset($attributes['http-equiv'])) { /* meta with attribute "http-equiv" */
                        $this->_add($attributes['http-equiv'], $attributes['content']);
                    }
                    if (isset($attributes['itemprop'])) {
                        switch ($attributes['itemprop']) {
                            case 'image':
                                $this->_addArray('image', $attributes['content']);
                                break;
                        }
                    }
                    /**
                     * Put your extend parsing here
                     */
                }
            }
            return $this;
        }

        /**
         * Extract elements in body
         * @return \CParserMetas
         */
        private function _extractBody() {
            $image = $this->_domBlocks['body']->find('img');
            foreach ($image as $element) {
                $attributes = $element->attr;
                if (isset($attributes['src'])) {
                    $this->_addArray('image', $attributes['src']);
                }
            }
            /**
             * @todo extract css with background have image
             * @todo extract a href with image link
             */
            return $this;
        }

        /**
         * @todo extract more information by know well about html standard
         * @return \JObject
         */
        public function extract() {
            $this
                    ->_extractMeta()
                    ->_extractBody();
            return $this->_extracted;
        }

    }

}