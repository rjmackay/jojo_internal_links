{literal}
<script type="text/javascript">
    _editor_url  = '{/literal}{$SITEURL}{literal}/external/xinha/';
    _editor_lang = "en";
</script>
<script type="text/javascript" src="{/literal}{$SITEURL}{literal}/external/xinha/XinhaCore.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
    xinha_editors = null;
    xinha_init    = null;
    xinha_config  = null;
    xinha_plugins = null;


    // This contains the names of textareas we will make into Xinha editors
    function wysiwyg_init(field)
    {
        $('xinha_wrapper').innerHTML = '<textarea class="content" style="padding:0; margin:0; width:780px; height:470px;" name="xinha_editor_content" id="xinha_editor_content">' + $(field).value +
        '</textarea><input type="submit" class="jojo-admin-edit-done" value="Done" onclick="return hideWysiwygEditor(); "/><input type="submit" class="jojo-admin-edit-cancel" value="Cancel" onclick="$(\'wysiwyg-editor\').hide(); $(\'wysiwyg-editor-overlay\').hide(); return false;" />';

        /* Load plugins */
        xinha_plugins = xinha_plugins ? xinha_plugins :
                  [
                   'ContextMenu',
                   'Stylist',
                   'FindReplace',
                   'PasteText',
                   'ExtendedFileManager',
                   'TableOperations',
                   'InsertAnchor',
				   'Linker'
                  ];

        var res = Xinha.loadPlugins(xinha_plugins, xinha_init);

        /* Start Editors */
        setTimeout("xinha_configure(); xinha_editors = Xinha.makeEditors(['xinha_editor_content'], xinha_config, xinha_plugins); Xinha.startEditors(xinha_editors);xinha_editors.xinha_editor_content.hidePanel( xinha_editors.xinha_editor_content._stylist );", {/literal}{$xinhatimeout|default:'1000'}{literal});
    }

    function xinha_configure()
    {
        /* Create Config */
        xinha_config = new Xinha.Config();
        xinha_config.showLoading = true;
        xinha_config.stylistLoadStylesheet("{/literal}{$SITEURL}{literal}/css/styles.css");
        xinha_config.pageStyleSheets = ["{/literal}{$SITEURL}{literal}/css/styles.css", "{/literal}{$SITEURL}{literal}/css/xinha.css"];
        xinha_config.baseHref = "{/literal}{$SITEURL}{literal}/";

		xinha_config.Linker.backend = '{/literal}{$SITEURL}{literal}/scan.php/';
		//xinha_config.Linker.backend = null;
		//xinha_config.Linker.files = {/literal}{php}
		//require_once _SITEDIR . '/plugins/internal_links/internal_links_scan.php';
		//echo (JOJO_Plugin_internal_links_scan::_getContent());{/php}{literal};
		// xinha_config.Linker.files = [
			// "e.html",                        
			// ['f.html', ['g.html','h.html']], 
			// {url:'i.html',title:'I Html'},   
			// {url:'j.html',title:'J Html', children:[{url:'k.html',name:"K Html"},'l.html',['m.html',['n.html']]]} 
        // ];
		//xinha_config.Linker.files = [{title:"Articles.html",children:[{url:"articles/",title:"Article Index", children:[{url:"articles/rss",title:"Articles RSS Feed"},{url:"articles/2/pasx-206-past-380-course-frameworks-for-youth-and-ministry/",title:"PASX 206 / PAST 380 Course: Frameworks for Youth and Ministry"},{url:"articles/1/welcome-to-jojocms/",title:"Welcome to JojoCMS"}]}]}];
	
        xinha_config.ExtendedFileManager.{/literal}{php}

            // define backend configuration for the plugin
            $IMConfig = array();
            $IMConfig['images_dir'] = _DOWNLOADDIR . '/images/';
            $IMConfig['images_url'] = _SITEURL . '/downloads/images/';
            $IMConfig['files_dir'] = _DOWNLOADDIR . '/files/';
            $IMConfig['files_url'] = _SITEURL . '/downloads/files/';
            $IMConfig['thumbnail_prefix'] = 't_';
            $IMConfig['thumbnail_dir'] = 't';
            $IMConfig['resized_prefix'] = 'resized_';
            $IMConfig['resized_dir'] = '';
            $IMConfig['tmp_prefix'] = '_tmp';
            $IMConfig['max_filesize_kb_image'] = 2000;
            // maximum size for uploading files in 'insert image' mode (2000 kB here)

            $IMConfig['max_filesize_kb_link'] = 5000;
            // maximum size for uploading files in 'insert link' mode (5000 kB here)

            // Maximum upload folder size in Megabytes.
            // Use 0 to disable limit
            $IMConfig['max_foldersize_mb'] = 0;

            $IMConfig['allowed_image_extensions'] = array("jpg","gif","png");
            $IMConfig['allowed_link_extensions'] = array("jpg","gif","pdf","ip","txt",
                                                         "psd","png","html","swf",
                                                         "xml","xls");

            require_once _BASEDIR . '/external/xinha/contrib/php-xinha.php';
            xinha_pass_to_php_backend($IMConfig);

        {/php}{literal}
    }

    function wysiwyg_complete(field)
    {
        $('xinha_wrapper').onsubmit();
        $(field).value = $('xinha_editor_content').value;
    }
  /* ]]> */
  </script>
{/literal}

<form id='xinha_wrapper' action="">
    <textarea class="content" style="padding:0; margin:0; width:780px; height:470px;" name="xinha_editor_content" id="xinha_editor_content" rows="40" cols="40"></textarea>
</form>


