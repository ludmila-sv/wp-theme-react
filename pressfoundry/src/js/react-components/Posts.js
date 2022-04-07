import React, { Component } from 'react';
//import axios from 'axios';
import PostCard from './PostCard';
import Pagination from '../react-modules/Pagination';

class Posts extends Component {
	constructor( props ) {
		super( props );

		this.state = {
			posts: [],
			totalPosts: 1,
			pageTitle: 'Blog',
			currentPage: this.props.archive_data.current_page ? parseInt( props.archive_data.current_page ) : 1,
			blogUrl: this.props.archive_data.blog_url ? props.archive_data.blog_url : '/',
		};
	}

	componentDidMount() {
		const queryPar = this.props.archive_data.query_parameters;
		const queryParameters = queryPar ? '?' + queryPar : '';
		const pageContent = fetch( 'http://playground/wp-json/wp/v2/posts' + queryParameters )
			.then( ( response ) => {
				this.setState( {
					pageTitle: response.headers.get( 'X-WP-Archive-Header' ),
					totalPosts: response.headers.get( 'X-WP-TotalPages' ),
				} );
				return response.json();
			} )
			.then( ( responseJson ) => {
				this.setState( {
					posts: responseJson,
				} );
			} )
			.catch( ( error ) => {
				console.error( error );
			} );
		return pageContent;
	}

	render() {
		const { posts, totalPosts, pageTitle, currentPage, blogUrl } = this.state;
		return (
			<div className="container">
				<h1>{ pageTitle }</h1>
				<div className="row">
					{ posts.map( ( post ) => (
						<PostCard key={ post.id } post={ post } />
					) ) }
				</div>
				<div className="pagination">
					<Pagination total={ totalPosts } current={ currentPage } url= { blogUrl } />
				</div>
			</div>
		);
	}
}

export default Posts;
