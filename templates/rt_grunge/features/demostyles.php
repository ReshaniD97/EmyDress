<?php
/**
 * @package   Grunge Template - RocketTheme
* @version   1.6 November 19, 2019
* @author    RocketTheme http://www.rockettheme.com
* @copyright Copyright (C) 2007 - 2019 RocketTheme, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Rockettheme Grunge Template uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

class GantryFeatureDemoStyles extends GantryFeature {
    var $_feature_name = 'demostyles';

    function isEnabled() {
        return true;
    }

    function isInPosition($position) {
        return false;
    }

	function init() {
        global $gantry;

		//demo styles
        $gantry->addStyle("demo-styles.css");

	}

}