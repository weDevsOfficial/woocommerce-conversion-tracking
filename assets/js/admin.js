(function( $ ) {
    // Data Save
    $( '#wcct-submit' ).on( 'click', function( e ) {
        e.preventDefault();
        $( '#wcct-submit' ).addClass( 'updating-message' );
        wp.ajax.send( 'wcct_save_settings', {
            data: $( '#integration-form' ).serialize(),
            success: function( response ) {

                $("#ajax-message")
                    .html('<p><strong>' + response.message + '</strong></p>')
                    .show()
                    .delay(3000)
                    .slideUp('fast');

                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');

                $( '#wcct-submit' ).removeClass( 'updating-message' );
            },
            error: function(error) {
                alert('something wrong happend');
            }
        });

        return false;
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

    $('.event').on( 'change', function() {
        var target = $( this ).next('.event-label-box');
        target.addClass( 'event-label-space' );
        target.stop().toggle();

    } );

    $( '.event:checked' ).each( function( index, value ) {
        $( value ).next( '.event-label-box' ).addClass( 'event-label-space' );
        $( value ).next( '.event-label-box' ).css( 'display', 'block' );
    } );

    // Pro-Feature Message
    $( '.disabled-class' ).on( 'click', function() {
        var title =  $( this ).text();
        swal({
            title:title+' is available in Pro version',
            text:'Please upgrade to the Pro version to get all the awesome feature',
            buttons:{
                confirm:'Get the Pro Version',
                cancel:'Close',
            },
        }).then( function( is_confirm ){
            if ( is_confirm ) {
              window.open('http://www.wedevs.com', '_blank');
            }
        }, function() {});
    } );

    // Change Tooltip Text
    $( '.toogle-seller' ).on( 'change', function() {
        var tooltipText = $( this ).parents( '.switch' ).find( '.integration-tooltip' );
        var text = $( tooltipText ).text().trim();
        var newText = '';

        if ( text == 'Activate' ) {
            newText = 'Deactivate'
        } else if( text == 'Deactivate' ) {
           newText = 'Activate';
        }

        $( tooltipText ).text( newText );
    } );

})( jQuery );