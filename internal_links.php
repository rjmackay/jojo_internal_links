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

/*
This class MUST be renamed to " Jojo_Plugin_" followed by the name of your plugin, otherwise the plugin will not work.

So if you have named your plugin "my_test_plugin" then the classname becomes "Jojo_Plugin_my_test_plugin".
*/
class JOJO_Plugin_internal_links extends Jojo_Plugin
{
    function xinha_plugins($xinha_plugins) {
        $xinha_plugins[] = 'Linker';
        return $xinha_plugins;
    }
    
    function xinha_config_start() {
        echo "\nxinha_config.Linker.backend = \""._SITEURL."/internal_links_scan/\";\n\n";

        return true;        
    }
}