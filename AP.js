(function() {
    tinymce.create('tinymce.plugins.allowPHP', {
        init : function(ed, url) {
            ed.addButton('allowPHP', {
                title : 'Allow PHP',
                image : url+'/ap.png',
                onclick : function() {
					 var functionId = prompt("Function ID: ");
                    if (functionId != null && functionId != '0')
                        ed.execCommand('mceInsertContent', false, ' [php function='+functionId+'] ');
					else
						return;
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Allow PHP button code",
                author : 'Hit Reach',
                authorurl : 'http://www.hireach.co.uk/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('allowPHP', tinymce.plugins.allowPHP);
})();
