<?php
/**
 * Pressfoundry's Logo
 *
 * @package test01
 */

/**
 * Adds Press Foundry Widget metabox.
 */
function pressfoundry_add_metabox() {
	add_meta_box( 'vl_dashboard_widget', 'Made by Press Foundry', 'pressfoundry_render_dashboard_widget', 'dashboard', 'side', 'default' );
}
add_action( 'wp_dashboard_setup', 'pressfoundry_add_metabox' );

/**
 * Renders Press Foundry logo widget.
 */
function pressfoundry_render_dashboard_widget() {
	?>
	<a href="https://pressfoundry.com" style="max-width:100%;" target="_blank" title="Press Foundry">
		<svg xmlns="http://www.w3.org/2000/svg" text-rendering="geometricPrecision" fill-rule="evenodd" xml:space="preserve" shape-rendering="geometricPrecision" version="1.1" clip-rule="evenodd" image-rendering="optimizeQuality" viewBox="0 0 2761 608" preserveAspectRatio="xMinYMin meet"  style="width:100%;">
			<rect width="2761" height="608" fill="none"/>
			<path d="m897 396h40v-65c0-45 24-68 58-68h2v-41c-30-2-50 16-60 42v-39h-40v171zm207 4c32 0 54-12 70-32l-23-20c-13 13-27 20-46 20-26 0-45-15-50-43h126c1-4 1-8 1-11 0-50-28-93-82-93-49 0-84 41-84 90 0 53 38 89 88 89zm-49-101c4-27 21-45 45-45 26 0 40 19 43 45h-88zm225 101c36 0 64-18 64-54v-1c0-31-28-42-53-50-20-6-39-12-39-24v-1c0-10 9-17 24-17 14 0 32 6 48 16l16-27c-18-12-42-20-63-20-34 0-61 20-61 52v1c0 33 28 43 54 50 20 6 38 11 38 24v1c0 11-10 18-27 18s-37-7-56-21l-17 27c21 17 48 26 72 26zm159 0c36 0 64-18 64-54v-1c0-31-28-42-53-50-20-6-39-12-39-24v-1c0-10 9-17 24-17 14 0 32 6 48 16l16-27c-18-12-42-20-63-20-34 0-61 20-61 52v1c0 33 28 43 54 50 20 6 38 11 38 24v1c0 11-10 18-27 18s-37-7-56-21l-17 27c21 17 48 26 72 26zm-759 48h39v-78c12 16 30 30 58 30 41 0 80-32 80-89v-1c0-56-39-89-80-89-27 0-45 15-58 33v-29h-39v223zm88-82c-26 0-50-22-50-55v-1c0-32 24-55 50-55 27 0 49 22 49 55v1c0 34-22 55-49 55zm968 34c49 0 85-40 85-86v-1c0-46-35-86-84-86-50 0-86 40-86 87s36 86 85 86zm1-15c-39 0-69-32-69-71v-1c0-39 29-71 68-71 38 0 68 32 68 72 0 39-28 71-67 71zm191 15c30 0 48-15 59-34v30h16v-165h-16v96c0 34-25 59-57 59-33 0-53-23-53-57v-98h-16v101c0 40 25 68 67 68zm116-4h15v-95c0-35 25-59 58-59s52 22 52 56v98h16v-101c0-40-24-68-66-68-30 0-49 15-60 35v-31h-15v165zm262 4c33 0 54-19 68-41v37h16v-237h-16v108c-13-21-35-40-68-40-40 0-80 33-80 87s40 86 80 86zm2-15c-35 0-65-28-65-71v-1c0-45 29-71 65-71 34 0 67 29 67 71v1c0 42-33 71-67 71zm122 11h16v-67c0-54 34-83 72-83h2v-18c-33-1-61 20-74 50v-47h-16v165zm150 53c24 0 41-12 55-47l72-171h-17l-60 148-69-148h-18l79 164c-12 29-24 39-41 39-12 0-19-2-28-6l-6 14c12 5 21 7 33 7zm-1022-53h16v-151h58v-14h-58v-16c0-28 11-42 33-42h25v-15h-25c-34 0-49 25-49 57v16h-24v14h24v151z" fill="#333"/>
			<path d="m379 228v151c-56 0-121-1-166 37-42 34-52 86-52 137h-107v-107c51 0 103-10 138-51 38-46 36-111 36-167h151z" fill="#333"/>
			<path d="m227 553h77 249v-498h-499v249 77c107 0 109-52 109-153v-65h282v282h-66c-101 0-152 2-152 108z" fill="#1495B7"/>
		</svg>
	</a>
	<?php
}
