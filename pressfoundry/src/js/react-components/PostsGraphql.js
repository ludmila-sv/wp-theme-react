import { useQuery } from '@apollo/react-hooks';
import { gql } from 'apollo-boost';

import PostCardGraphql from './PostCardGraphql';
import Pagination from '../react-modules/Pagination';
import Search from '../react-modules/Search';

const POSTS_QUERY = gql`
	query Posts($offset: Int!, $size: Int!, $categoryId: Int, $tagId: String, $search: String) {
		posts(where: {offsetPagination: {offset: $offset, size: $size}, categoryId: $categoryId, tagId: $tagId, search: $search}) {
			nodes {
				postId
				title(format: RENDERED)
				author {
					node {
						name
					}
				}
				categories {
					nodes {
						name
						link
					}
				}
				date
				excerpt(format: RENDERED)
				featuredImage {
					node {
						sourceUrl(size: LARGE)
					}
				}
				link
			}
			pageInfo {
				endCursor
				total
				pageTitle
			}
		}
	}
`;

const PostsGraphql = ( props ) => {
	const currentPage = props.archive_data.current_page ? parseInt( props.archive_data.current_page ) : 1;
	const postsPerPage = props.archive_data.posts_per_page ? parseInt( props.archive_data.posts_per_page ) : 12;

	const categoryId = props.archive_data.category ? parseInt( props.archive_data.category ) : null;
	const tagId = props.archive_data.tag ? props.archive_data.tag : null;
	//const search = props.archive_data.search ? props.archive_data.search : null;

	const urlSearch = window.location.search;
	const search = new URLSearchParams( urlSearch ).get( 's' );
	const searchValue = search ? search : '';

	const offset = ( currentPage - 1 ) * postsPerPage;

	const { loading, error, data } = useQuery( POSTS_QUERY, {
		variables: {
			offset,
			size: postsPerPage,
			categoryId,
			tagId,
			search,
		},
	} );

	if ( error ) return <p>Something wrong happened!</p>;
	if ( loading ) return <p>Loading Posts...</p>;

	const posts = data.posts.nodes;
	const pageTitle = props.archive_data.page_title ? props.archive_data.page_title : 'Blog';
	const blogUrl = props.archive_data.blog_url ? props.archive_data.blog_url : '/';
	const totalPosts = data.posts.pageInfo.total ? data.posts.pageInfo.total : 0;
	const totalPages = ( totalPosts && postsPerPage ) ? Math.ceil( totalPosts / postsPerPage ) : 0;

	return (
		<div className="container">
			<div className="blog__search">
				<Search search={ searchValue } action={ blogUrl } />
			</div>
			<h1>{ pageTitle }</h1>
			{ posts ? (
				<div className="row">
					{ posts.map( ( post ) => (
						<PostCardGraphql key={ post.postId } post={ post } />
					) ) }
				</div>
			) : ( '' ) }
			{ totalPages > 1 ? (
				<div className="pagination">
					<Pagination total={ totalPages } current={ currentPage } url= { blogUrl } />
				</div>
			) : ( '' ) }
		</div>
	);
};

export default PostsGraphql;
