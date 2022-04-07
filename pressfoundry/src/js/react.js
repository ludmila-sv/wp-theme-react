const { render } = wp.element;
import ApolloClient from 'apollo-boost';
import { ApolloProvider } from '@apollo/react-hooks';

import React from 'react';

import Page from './react-components/Page';
//import Posts from './react-components/Posts';
import PostsGraphql from './react-components/PostsGraphql';

const client = new ApolloClient( {
	uri: 'http://playground/graphql',
} );

const ApolloApp = () => {
	return (
		<ApolloProvider client={ client }>
			<div>
				<PostsGraphql archive_data={ archive_data } />
			</div>
		</ApolloProvider>
	);
};

if ( document.getElementById( 'react-app' ) ) {
	render( <Page />, document.getElementById( 'react-app' ) );
} else if ( document.getElementById( 'react-app-posts' ) ) {
	render( <ApolloApp />, document.getElementById( 'react-app-posts' ) );
	//render( <Posts archive_data={ archive_data } />, document.getElementById( 'react-app-posts' ) );
}
