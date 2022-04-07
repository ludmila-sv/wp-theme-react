import React, { Component } from 'react';
import { appendScript } from '../react-utils/append-js';

class Page extends Component {
	constructor( props ) {
		super( props );

		this.state = {
			content: {},
		};
	}

	componentDidMount() {
		const pageId = document.getElementById( 'react-app' ).dataset.pageid;
		const pageContent = fetch( 'http://playground/wp-json/wp/v2/pages/' + pageId )
			.then( ( response ) => response.json() )
			.then( ( responseJson ) => {
				const { content } = responseJson;
				this.setState( { content } );
			} )
			.catch( ( error ) => {
				console.error( error );
			} );
		return pageContent;
	}

	runAfterRender = () => {
		appendScript( '/wp-content/themes/pressfoundry/assets/js/main.js', 'pressfoundry-scripts-js' );
	};

	render() {
		return (
			<div onLoad={this.runAfterRender()} className= "container" dangerouslySetInnerHTML={{ __html: this.state.content.rendered }} />
		);
	}
}
export default Page;
