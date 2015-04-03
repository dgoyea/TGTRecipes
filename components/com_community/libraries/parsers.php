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

if (!class_exists('CParsers')) {

    /**
     * Parser abstract class
     * @uses Used to get parser and provide abstract structure
     */
    abstract class CParsers extends JObject {

        /**
         *
         * @param type $name
         * @param type $data
         * @return boolean|\Parser Object
         */
        public static function getParser($name, $data = array()) {
            $parserFile = __DIR__ . '/parsers/' . $name . '.php';
            if (JFile::exists($parserFile)) {
                $className = 'CParser' . ucfirst($name);
                if (class_exists($className)) {
                    $class = new $className($data);
                    return $class;
                }
                return false;
            }
        }

        public abstract function extract();

        /**
         * Get array of url in input content string
         * @param string $content
         * @return array
         */
        public static function getUrls($content) {
            $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
            $regex .= "([A-Za-z0-9+!*(),;?&=\$_.-]+(\:[A-Za-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
            $regex .= "([A-Za-z0-9-.]*)\.([A-Za-z]{2,4})"; // Host or IP
            $regex .= "(\:[0-9]{2,5})?"; // Port
            $regex .= "(\/([A-Za-z0-9+\$_-]\.?)+)*\/?"; // Path
            $regex .= "(\?[A-Za-z+&\$_.-][A-Za-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
            $regex .= "(#[A-Za-z_.-][A-Za-z0-9+\$_.-]*)?"; // Anchor
            //$return = preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $this->get('content'), $matchs);
            $return = preg_match_all("/$regex/", $content, $matchs);

            if ($return !== false) {
                return array_unique($matchs[0]);
            }
            return array();
        }

        /**
         * Extract url from input content and do fetch link
         * @param string $content
         * @return boolean|JRegistry
         */
        public static function linkFetch($content) {
            $urls = self::getUrls($content);
            /**
             * Crawle data
             * We only work with first url
             */
            if (count($urls) > 0) {
                $url   = array_shift($urls);
                $crawl = CCrawler::getCrawler();
                $data  = $crawl->crawl('GET', $url);

                $data->set('body', self::stripNonImageTags( $data->getBody() ));

                $graphObject = $data->parse();
                return $graphObject;
            }
            return false;
        }

        /**
         * Remove/strip unused non-image tags from content.
         * @param string $content
         * @return string
         */
        public static function stripNonImageTags($content) {
            preg_match_all('/<img[^">]+(src="[^">]+")[^>]*>/i', $content, $matches);

            $images = $matches[0];
            $content = preg_replace('/<body[^>]*>.+<\/body>/is', '<body>' . implode('', $images) . '</body>', $content);

            return $content;
        }

    }

}