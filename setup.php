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



/* Add a Sitemap page is one does not exist */
Jojo::updateQuery("UPDATE page SET pg_link='JOJO_Plugin_internal_links_scan' WHERE pg_link='internal_links_scan.php'");
$data = JOJO::selectQuery("SELECT * FROM page WHERE pg_link='JOJO_Plugin_internal_links_scan'");
if (count($data) == 0) {
    echo "Adding <b>scan</b> Page to menu<br />";
	$data = JOJO::selectQuery("SELECT * FROM page WHERE pg_title = 'Not on Menu'");
    $_NOT_NO_MENU_ID = $data[0]['pageid'];
    JOJO::insertQuery("INSERT INTO page SET pg_title='Scan', pg_link='internal_links_scan.php', pg_url='scan.php', pg_desc='page used for xinha existing page links', pg_parent=$_NOT_NO_MENU_ID");
}

/* Add Google sitemap (sitemap.xml) page if one does not exist */
/* $data = JOJO::selectQuery("SELECT * FROM page WHERE pg_link = 'xml_sitemap.php'");
if (count($data) == 0) {
    echo "Adding <b>Google Sitemap</b> Page<br />";
    JOJO::insertQuery("INSERT INTO page SET pg_title = 'XML Sitemap', pg_link = 'xml_sitemap.php', pg_url = 'sitemap.xml', pg_parent=" . JOJO::cleanInt($_NOT_NO_MENU_ID) . ", pg_order=0, pg_mainnav='no', pg_body = ''");
} */

