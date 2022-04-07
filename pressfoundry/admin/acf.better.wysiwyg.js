(function($, acf){
    "use strict";

    acf.add_filter( 'wysiwyg_tinymce_settings', function( mceInit, id ) {

        var $fieldWrap = $( '#' + id ).closest( '.acf-field-wysiwyg' ),
            fieldNameClass = $fieldWrap.attr( 'data-name' ),
            fieldKeyClass = $fieldWrap.attr( 'data-key' );

        // put those classes on the rendered iframe's body tag
        mceInit.body_class += ' ' + fieldNameClass + ' ' + fieldKeyClass + ' ';
        return mceInit;
    });

})(jQuery, acf);