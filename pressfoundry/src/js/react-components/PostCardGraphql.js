import { Component } from 'react';

class PostCardGraphql extends Component {
	render() {
		const { title, author, categories, date, excerpt, featuredImage, link } = this.props.post;
		return (
			<div className="col-md-4">
				<div className="post-card">
					{ featuredImage ? (
						<img className="post-card__img" src={ featuredImage.node.sourceUrl } alt={ title } />
					) : (
						''
					) }
					<h3>
						<a href={ link }>{ title }</a>
					</h3>
					<div className="post-card__author">
						Author: <strong>{ author.node.name }</strong>
					</div>
					<div className="post-card__date">{ date }</div>
					<div className="post-card__categories">
						Categories:
						{ categories.nodes.map( ( item, i ) => (
							<a key={ i } href={ item.link }>{ item.name }</a>
						) ) }
					</div>
					<div
						className="post-card__excerpt"
						dangerouslySetInnerHTML={ { __html: excerpt } }
					></div>
				</div>
			</div>
		);
	}
}

export default PostCardGraphql;
