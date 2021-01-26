<?php
/*
 * Copyright (C) joomla-monster.com
 * Website: http://www.joomla-monster.com
 * Support: info@joomla-monster.com
 *
 * JM Testimonials is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * JM Testimonials is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with JM Testimonials. If not, see <http://www.gnu.org/licenses/>.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$version = new JVersion;
$jversion = '3';
if (version_compare($version->getShortVersion(), '3.0.0', '<')) {
		$jversion = '2.5';
}

$doc = JFactory::getDocument();

$moduleId = $module->id;
$id = 'jmm-testimonials-' . $moduleId;

$data = $params->get('testimonials');
$json_data = ( !empty($data) ) ? json_decode($data) : false;

if ($json_data === false) {
	echo JText::_('MOD_JM_TESTIMONIALS_NO_ITEMS');
	return false;
}

$field_pattern = '#^jform\[params\]\[([a-zA-Z0-9\_\-]+)\]#i';

$output_data = array();
foreach ($json_data as $item) {
	$item_obj = new stdClass();
	foreach($item as $field) {
		if (preg_match($field_pattern, $field->name, $matches)) {
			$attr = $matches[1];
			if (isset($item_obj->$attr)) {
				if (is_array($item_obj->$attr)) {
					$temp = $item_obj->$attr;
					$temp[] = $field->value;
					$item_obj->$attr = $temp;
				} else {
					$temp = array($item_obj->$attr);
					$temp[] = $field->value;
					$item_obj->$attr = $temp;
				}
			} else {
				$item_obj->$attr = $field->value;
			}
		}
	}
	$output_data[] = $item_obj;
}

$elements = count($output_data);

if( $elements < 1 ) {
	echo JText::_('MOD_JM_TESTIMONIALS_NO_ITEMS');
	return false;
}

$interval = $params->get('play_interval', 0);
$interval = intval($interval);
$autoplay = ( $params->get('auto_play', 0) == 1 && $interval > 0 ) ? ' data-interval="' . $interval . '"' : ' data-interval="0"';

$columns = $params->get('columns', 1);

$show_indicators = $params->get('show_indicators', 0);

$theme = $params->get('theme', 1);
$theme_class = ( $theme == 1 ) ? 'default' : 'override';

if( $theme == 1 ) { //default
	$doc->addStyleSheet(JURI::root(true).'/modules/mod_jm_testimonials/assets/default.css');
}

$bs_js = $params->get('bootstrap_js', 1);
$bs_css = $params->get('bootstrap_css', 0);

if( $bs_js == 1 ) { //default
	JHtml::_('bootstrap.framework');
}

if( $bs_css == 1 ) { //default
	JHtml::_('bootstrap.loadCss', true, JFactory::getDocument()->direction);
}

$doc->addScript(JURI::root(true).'/modules/mod_jm_testimonials/assets/jquery.touchSwipe.min.js');

$doc->addScript(JURI::root(true).'/modules/mod_jm_testimonials/assets/script.js');

$mod_class_suffix = $params->get('moduleclass_sfx', '');

require JModuleHelper::getLayoutPath('mod_jm_testimonials', $params->get('layout', 'default'));

?>
