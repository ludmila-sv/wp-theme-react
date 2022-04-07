import ObjectFitImages from 'object-fit-images';

export default ( $ ) => {
	$( document ).ready( function() {
		ObjectFitImages( null, { watchMQ: true } );
	} );
};
