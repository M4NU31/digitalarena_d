wp.domReady( () => {

	wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'fill' );

    wp.blocks.registerBlockStyle( 'core/button', {
        name: 'secondary',
        label: 'Primary'
    } );

    wp.blocks.registerBlockStyle( 'core/button', {
        name: 'tertiary',
        label: 'Tertiary'
    } );

} );