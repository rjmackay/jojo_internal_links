<?php
/**
 *                    Jojo CMS - Internal links plugin
 *                ================
 *
 * Copyright 2007-2008 Robbie MacKay <rjmackay@gmail.com>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Robbie MacKay <rjmackay@gmail.com>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://rjmackay.wordpress.org/code/
 * @package internal_links
 */

$_provides['pluginClasses'] = array(
        'JOJO_Plugin_internal_links_scan'    => 'Internal Links - scan.php',
        );

Jojo::addFilter('xinha_plugins', 'xinha_plugins', 'internal_links');

Jojo::addHook('xinha_config_start', 'xinha_config_start', 'internal_links');