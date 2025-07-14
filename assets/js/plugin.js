/* global  */

/**
 * Custom JS
 */

( function ( $ ) {
	'use strict';

	window.Askai_Script = {
		init: function () {
			console.log( 'Custom Script Loaded.' );
		},
	};

	$( document ).on( 'ready', function () {
		Askai_Script.init();
	} );
} )( jQuery );
