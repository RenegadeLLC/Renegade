jQuery(document).ready(function($) {
    tinymce.create('tinymce.plugins.waq_plugin', {
        init : function(ed, url) {
                // Register command for when button is clicked
                ed.addCommand('waq_insert_shortcode', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();

                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[wpajax]'+selected+'[/wpajax]';
                    }else{
                        content =  '[wpajax]';
                    }
                    tinymce.execCommand('mceInsertContent', false, content);
                });

            // Register buttons - trigger above command when clicked
            ed.addButton('waq_button', {title : 'Insert Ajax Query Shortcode', cmd : 'waq_insert_shortcode', image: url + '/button.png' });
        },   
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('waq_button', tinymce.plugins.waq_plugin);
});