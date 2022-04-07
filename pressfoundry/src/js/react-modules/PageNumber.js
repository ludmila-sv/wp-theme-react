export default class PageNumber extends React.Component {
	static defaultProps = {
		url: '/blog/',
		isLink: true,
		isCurrent: false,
		isDots: false,
		className: 'page-numbers',
		onClick: '',
	};

	render() {
		let className = this.props.className;
		if ( this.props.isCurrent ) {
			className += ' current';
		}
		if ( this.props.isDots ) {
			className += ' dots';
		}
		const item = this.props.isLink ? (
			<a className={ className } href={ this.props.url } onClick={ this.props.onClick }>
				{ this.props.children }
			</a>
		) : (
			<span className={ className }>{ this.props.children }</span>
		);

		return item;
	}
}
