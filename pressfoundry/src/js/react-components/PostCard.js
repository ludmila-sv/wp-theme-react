import { Component } from 'react';

class PostCard extends Component {
	constructor( props ) {
		super( props );

		this.state = {
			imgUrl: '',
			author: '',
			postCategories: [],
		};
	}

	componentDidMount() {
		const { featured_media, author, categories } = this.props.post;
		const getImageUrl = featured_media
			? fetch(
					'http://playground/wp-json/wp/v2/media/' + featured_media
			  ).then( ( response ) => {
					if ( response.ok ) {
						return response.json();
					} else {
						//return Promise.reject( response.status );
						return false;
					}
			  } )
			: false;
		const getAuthor = fetch(
			'http://playground/wp-json/wp/v2/users/' + author
		).then( ( response ) => response.json() );
		const getCategories = fetch(
			'http://playground/wp-json/wp/v2/categories/'
		).then( ( response ) => response.json() );

		Promise.all( [ getImageUrl, getAuthor, getCategories ] ).then(
			( res ) => {
				const allCategories = res[ 2 ];

				const postCategoriesIds = categories;
				let postCategories = [];
				allCategories.map( ( item ) => {
					if ( postCategoriesIds.includes( item.id ) ) {
						postCategories.push( { name: item.name, link: item.link } );
					}
				} );
				this.setState( {
					imgUrl: res[ 0 ]
						? res[ 0 ].media_details.sizes.medium.source_url
						: '',
					author: res[ 1 ].name,
					postCategories,
				} );
			}
		);
	}

	render() {
		const { title, excerpt, link, date } = this.props.post;
		const { author, imgUrl, postCategories } = this.state;
		return (
			<div className="col-md-4">
				<div className="post-card">
					{ imgUrl ? (
						<img className="post-card__img" src={ imgUrl } alt={ title.rendered } />
					) : (
						''
					) }
					<h3>
						<a href={ link }>{ title.rendered }</a>
					</h3>
					<div className="post-card__author">
						Author: <strong>{ author }</strong>
					</div>
					<div className="post-card__date">{ date }</div>
					<div className="post-card__categories">
						Categories:
						{ postCategories.map( ( item, i ) => (
							<a key={ i } href={ item.link }>{ item.name }</a>
						) ) }
					</div>
					<div
						className="post-card__excerpt"
						dangerouslySetInnerHTML={ { __html: excerpt.rendered } }
					></div>
				</div>
			</div>
		);
	}
}

export default PostCard;
