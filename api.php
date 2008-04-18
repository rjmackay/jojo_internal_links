<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2007-2008 Harvey Kane <code@ragepank.com>
 * Copyright 2007-2008 Michael Cochrane <mikec@jojocms.org>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Harvey Kane <code@ragepank.com>
 * @author  Michael Cochrane <mikec@jojocms.org>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 * @package jojo_sitemap
 */

$_provides['pluginClasses'] = array(
        'JOJO_Plugin_internal_links_scan'    => 'Internal Links - scan.php',
        );

Jojo::addFilter('xinha_plugins', 'xinha_plugins', 'internal_links');

Jojo::addHook('xinha_config_start', 'xinha_config_start', 'internal_links');