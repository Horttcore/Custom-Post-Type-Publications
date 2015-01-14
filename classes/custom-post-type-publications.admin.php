<?php
/**
 * Custom Post Type Publications Admin
 *
 * @package Custom Post Type Publications
 * @author Ralf Hortt
 */
final class Custom_Post_Type_Publications_Admin
{



	/**
	 * Plugin constructor
	 *
	 * @access public
	 * @since 2.0
	 * @author Ralf Hortt
	 **/
	public function __construct()
	{

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'manage_publication_posts_custom_column', array( $this, 'manage_publication_posts_custom_column' ), 10, 2 );
		add_action( 'save_post', array( $this, 'publication_save_metabox' ) );

		add_filter( 'manage_edit-publication_columns', array( $this, 'manage_edit_publication_columns' ) );
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );

	} // END __construct



	/**
	 * Register Metaboxes
	 *
	 * @access public
	 * @since 2.0
	 * @author Ralf Hortt
	 **/
	public function add_meta_boxes()
	{

		add_meta_box( 'publication-meta', __( 'Information', 'custom-post-type-publication' ), array( $this, 'publication_meta' ), 'publication', 'normal' );

	} // END add_meta_boxes



	/**
	 * Add custom columns
	 *
	 * @access public
	 * @param array $columns Columns
	 * @return array Columns
	 * @since 2.0
	 * @author Ralf Hortt
	 **/
	public function manage_edit_publication_columns( $columns )
	{

		$columns['publication-author'] = __( 'Publication Author' );
		$columns['soure'] = __( 'Source' );
		$columns['publishing-date'] = __( 'Publishing Date' );

		return $columns;

	} // END manage_edit_publication_columns



	/**
	 * Print custom columns
	 *
	 * @access public
	 * @param str $column Column name
	 * @param int $post_id Post ID
	 * @since 2.0
	 * @author Ralf Hortt
	 **/
	public function manage_publication_posts_custom_column( $column, $post_id )
	{

		global $post;

		$meta = get_post_meta( $post_id, '_publication-meta', TRUE );

		switch( $column ) :

			case 'thumbnail' :
				if ( !has_post_thumbnail( $post_id ) ) :
					echo '<img src="http://www.gravatar.com/avatar/' . md5( $meta['email'] ) . '?d=mm" />';
				else :
					echo get_the_post_thumbnail( $post_id, 'thumbnail' );
				endif;
				break;

			case 'phone' :
				echo $meta['phone'];
				break;

			case 'mobile' :
				echo $meta['mobile'];
				break;

			case 'fax' :
				echo $meta['fax'];
				break;

			case 'email' :
				echo '<a href="mailto:' . $meta['email'] . '">' . $meta['email'] . '</a>';
				break;

			default :
				break;

		endswitch;

	} // END manage_publication_posts_custom_column



	/**
	 * Update messages
	 *
	 * @access public
	 * @param array $messages Messages
	 * @return array Messages
	 * @since 2.0
	 * @author Ralf Hortt
	 **/
	public function post_updated_messages( $messages )
	{

		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( 'publication' );

		$messages['publication'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Publication updated.', 'custom-post-type-publications' ),
			2  => __( 'Custom field updated.' ),
			3  => __( 'Custom field deleted.' ),
			4  => __( 'Publication updated.', 'custom-post-type-publications' ),
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Publication restored to revision from %s', 'custom-post-type-publications' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Publication published.', 'custom-post-type-publications' ),
			7  => __( 'Publication saved.', 'custom-post-type-publications' ),
			8  => __( 'Publication submitted.', 'custom-post-type-publications' ),
			9  => sprintf( __( 'Publication scheduled for: <strong>%1$s</strong>.', 'custom-post-type-publications' ), date_i18n( __( 'M j, Y @ G:i', 'custom-post-type-publications' ), strtotime( $post->post_date ) ) ),
			10 => __( 'Publication draft updated.', 'custom-post-type-publications' )
		);

		if ( $post_type_object->publicly_queryable ) :

			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View publication', 'custom-post-type-publications' ) );
			$messages[ 'publication' ][1] .= $view_link;
			$messages[ 'publication' ][6] .= $view_link;
			$messages[ 'publication' ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview publication', 'custom-post-type-publications' ) );
			$messages[ 'publication' ][8]  .= $preview_link;
			$messages[ 'publication' ][10] .= $preview_link;

		endif;

		return $messages;

	} // END post_updated_messages



	/**
	 * Information meta box
	 *
	 * @access public
	 * @param obj $post Post object
	 * @since 2.0
	 * @author Ralf Hortt
	 **/
	public function publication_meta( $post )
	{

		$meta = apply_filters( 'publication-meta', get_post_meta( $post->ID, '_publication-meta', TRUE ) );

		do_action( 'publication-meta-table-before', $post, $meta );

		?>

		<table class="form-table">

			<?php do_action( 'publication-meta-before', $post, $meta ) ?>

			<tr>
				<th><label for="publication-author"><?php _e( 'Author:', 'custom-post-type-publication' ); ?></label></th>
				<td><input size="50" type="text" value="<?php if ( $meta ) echo esc_attr( $meta['author'] ) ?>" name="publication-author" id="publication-author"></td>
			</tr>
			<tr>
				<th><label for="publication-source"><?php _e( 'Source:', 'custom-post-type-publication' ); ?></label></th>
				<td><input size="50" type="text" value="<?php if ( $meta ) echo esc_attr( $meta['source'] ) ?>" name="publication-source" id="publication-source"></td>
			</tr>
			<tr>
				<th><label for="publication-publishing-date"><?php _e( 'Publishing Date:', 'custom-post-type-publication' ); ?></label></th>
				<td><input size="50" type="text" value="<?php if ( $meta ) echo esc_attr( $meta['publishing-date'] ) ?>" name="publication-publishing-date" id="publication-publishing-date"></td>
			</tr>

			<?php do_action( 'publication-meta-after', $post, $meta ) ?>

		</table>

		<?php

		do_action( 'publication-meta-table-after', $post, $meta );

		wp_nonce_field( 'save-publication-meta', 'publication-meta-nonce' );

	} // END publication_meta



	/**
	 * Save Metabox
	 *
	 * @access public
	 * @param int $post_id Post ID
	 * @since 2.0
	 * @author Ralf Hortt
	 **/
	public function publication_save_metabox( $post_id )
	{

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( !isset( $_POST['publication-meta-nonce'] ) || !wp_verify_nonce( $_POST['publication-meta-nonce'], 'save-publication-meta' ) )
			return;

		$meta = array(
			'author' => sanitize_text_field( $_POST['publication-author'] ),
			'source' => sanitize_text_field( $_POST['publication-source'] ),
			'publishing-date' => sanitize_text_field( $_POST['publication-publishing-date'] ),
		);

		update_post_meta( $post_id, '_publication-meta', apply_filters( 'save-publication-meta', $meta, $post_id ) );

	} // END publication_save_metabox



} // END Custom_Post_Type_Publications_Admin

new Custom_Post_Type_Publications_Admin;
