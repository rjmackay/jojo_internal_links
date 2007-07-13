<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2007 Harvey Kane <code@ragepank.com>
 * Copyright 2007 Michael Holt <code@gardyneholt.co.nz>
 * Copyright 2007 Melanie Schulz <mel@gardyneholt.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Harvey Kane <code@ragepank.com>
 * @author  Michael Cochrane <code@gardyneholt.co.nz>
 * @author  Melanie Schulz <mel@gardyneholt.co.nz>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

function pingGoogleSitemaps($url='') {
    if ($url == '') {$url = _SITEURL.'/sitemap.xml';}
    $googleurl = "http://www.google.com/webmasters/sitemaps/ping?sitemap=" .urlencode($url);
    require_once(_BASEDIR.'/external/snoopy/Snoopy.class.php');
    $snoopy = new Snoopy;
    return $snoopy->fetch($googleurl);
}
