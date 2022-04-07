export const appendScript = ( scriptToAppend, scriptId ) => {
	const script = document.createElement( 'script' );
	script.src = scriptToAppend;
	script.id = scriptId;
	//script.async = true;
	document.body.appendChild( script );
};
