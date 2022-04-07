import PageNumber from './PageNumber';

export default class Pagination extends React.Component {
	static defaultProps = {
		total: 0,
		current: 1,
		showAll: false,
		showPages: true,
		prevText: ' ',
		nextText: ' ',
		endSize: 1,
		midSize: 1,
		baseClassName: 'nav-links',
		url: '/blog/',
		onClickPage: '',
	};

	constructor() {
		super();

		this.state = {
			current: 1,
		};
	}

	handleClickPage( e, page ) {
		//e.preventDefault();
		//this.setState( { current: page } );
		if ( this.props.onClickPage ) {
			this.props.onClickPage( page );
		}
	}

	componentWillMount() {
		this.setState( { current: this.props.current } );
	}

	render() {
		if ( this.props.total < 2 ) {
			return null;
		}

		let endSize = this.props.endSize < 1 ? 1 : this.props.endSize;
		let midSize = this.props.midSize < 0 ? 2 : this.props.midSize;

		let dots = false;

		let pages = [];

		if (
			this.props.prevText &&
			this.state.current &&
			1 < this.state.current
		) {
			pages.push(
				<PageNumber
					isLink={ true }
					isCurrent={ true }
					url = { this.props.url + 'page/' + ( this.state.current - 1 ) + '/' }
					key="prev"
					onClick={ ( e ) =>
						this.handleClickPage( e, this.state.current - 1 )
					}
					className="page-numbers prev"
				>
					{ this.props.prevText }
				</PageNumber>
			);
		}

		if ( this.props.showPages ) {
			for ( let n = 1; n <= this.props.total; n++ ) {
				let isCurrent = n === this.state.current;
				if ( isCurrent ) {
					dots = true;
					pages.push(
						<PageNumber isLink={ false } isCurrent={ true } key={ n }>
							{ n }
						</PageNumber>
					);
				} else {
					if (
						this.props.showAll ||
						n <= endSize ||
							( this.state.current &&
								n >= this.state.current - midSize &&
								n <= this.state.current + midSize ) ||
							n > this.props.total - endSize
					) {
						pages.push(
							<PageNumber
								url = { this.props.url + 'page/' + n + '/' }
								isLink={ true }
								onClick={ ( e ) =>
									this.handleClickPage( e, n )
								}
								key={ n }
							>
								{ n }
							</PageNumber>
						);
						dots = true;
					} else if ( dots && ! this.props.showAll ) {
						pages.push(
							<PageNumber isLink={ false } isDots={ true } key={ n }>
								&hellip;
							</PageNumber>
						);
						dots = false;
					}
				}
			}
		}

		if (
			this.props.nextText &&
			this.state.current &&
			this.state.current < this.props.total
		) {
			pages.push(
				<PageNumber
					url = { this.props.url + 'page/' + ( this.state.current + 1 ) + '/' }
					isLink={ true }
					isCurrent={ true }
					key="next"
					onClick={ ( e ) =>
						this.handleClickPage( e, this.state.current + 1 )
					}
					className="page-numbers next"
				>
					{ this.props.nextText }
				</PageNumber>
			);
		}

		return <div className={ this.props.baseClassName }>{ pages }</div>;
	}
}
