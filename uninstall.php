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



/* Remove the Sitemap page */
JOJO::deleteQuery("DELETE FROM `page` WHERE pg_link='internal_links_scan.php'");
