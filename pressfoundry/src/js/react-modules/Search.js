import { useState } from 'react';

const SearchBar = ( props ) => {
	const [value, setSearchQuery] = useState( props.search );
	return (
		<form action={ props.action } method="get" autoComplete="off">
			<label htmlFor="header-search">
				<span className="visually-hidden">Search blog posts</span>
			</label>
			<input
				value={ value }
				type="text"
				id="header-search"
				placeholder="Search blog posts"
				name="s"
				onInput={ ( e ) => setSearchQuery( e.target.value ) }
			/>
			<button type="submit">Search</button>
		</form>
	);
};

export default SearchBar;
