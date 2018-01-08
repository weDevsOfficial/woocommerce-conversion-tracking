(function( $ ) {
    // Data Save
    $( '#integration-form' ).on( 'submit', function( e ) {
        e.preventDefault();

        wp.ajax.send( 'wcct_save_settings', {
            data: $( this ).serialize(),
            success: function( response ) {

                $("#ajax-message")
                    .html('<p><strong>' + response.message + '</strong></p>')
                    .show()
                    .delay(3000)
                    .slideUp('fast');

                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');
            },
            error: function(error) {
                alert('something wrong happend');
            }
        });
    });

    // Toggoling the settings
    $( '.slider' ).on( 'click', function() {
        var id = $( this ).attr( 'data-id' );
        var target = $( '#setting-'+id );
        target.stop().toggle('fast');
    });

    // Default Settings
    $( '.toogle-seller:checked' ).each( function( index, value ) {
        var id =  $( value ).attr( 'data-id' );
        var target = $( '#setting-'+id );

        $( target ).css( 'display', 'block' );
    } );
})( jQuery );