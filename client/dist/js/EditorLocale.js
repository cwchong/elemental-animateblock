(function($) {

    $.entwine(function($){
        /**
         * Class: .cms-edit-form .field.htmleditor.textblock
         * Author: cheewai@movingmouse.com
         */
        $('.cms-edit-form textarea.htmleditor.textblock').entwine({
            onmatch: function() {
                var _me = this;

                setTimeout(function(){  // add delay for Tinymce to load
                    var t = $('#' + _me.attr('id') + '_ifr');
                    if(t.length) {
                        t.contents().find('body').addClass('textblock');
                    }
                }, 500);
                
                this._super();
            }
        });

    });

}(jQuery));