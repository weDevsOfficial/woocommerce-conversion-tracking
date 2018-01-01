(function($) {
    // Data Save
    $( "#integration-form" ).on( "submit", function( e ) {
        e.preventDefault();
        var self = $( this );
        $.ajax({
            url:wc_tracking.ajaxurl,
            type:'POST',
            data:{
                action:'wc_integration',
                fields:self.serialize(),
            },
            success: function( response ) {
                if ( response.success ) {
                    $("#message").show();
                }
            }
        });
    });

    // Toggoling the settings
    $( '.slider' ).on( 'click', function(){
        var id = $( this ).attr( 'data-id' );
        var target = $( '#setting-'+id );
        target.stop().toggle('slow');

        var checked = $( '#integration-'+id );

        if ( $( checked ).prop( 'checked') == false ) {
            $( target.find( 'input[type=checkbox]' ) ).removeAttr( 'checked' );
        }
    });

    // Default Settings
    $('.toogle-seller:checked').each( function( index, value ) {
        var id =  $( value ).attr( 'data-id' );
        var target = $( '#setting-'+id );

        $( target ).css( 'display', 'block' );
    } );
})( jQuery );