;(function( $ ) {
    'use strict';
     
    $(function() {
		/* Make an Ajax call via a GET request to the URL specified in the
         * wp_enqueue_script call. For the data parameter, pass an object with
         * the action name of the function we defined to return the user info.
         */
        $.ajax({
 
            url:    gens_demo.ajax_url,
            method: 'GET',
            data:   { postNonce: gens_demo.postNonce, action: 'get_current_user_info' }
 
        }).done(function( response ) {
 
            /* Once the request is done, determine if it was successful or not.
             * If so, parse the JSON and then render it to the console. Otherwise,
             * display the content of the failed request to the console.
             */
            if ( true === response.success ) {
 
                console.log( JSON.parse( response.data ) );
 
            } else {
 
                console.log( response.data );
 
            }
 
        });
    });
     
})( jQuery );
