<?php
//wpkgr.com
$wpkgr_lang_url = 'http://wordpress.org/latest.tar.gz';
$install_data = <<< EOD
<?php function wp_install_defaults(\$user_id) {global \$wpdb, \$wp_rewrite, \$current_site, \$table_prefix;
\$wpkgr_selected_plugins = array (
  0 => 'contact-form-7',
  1 => 'wordpress-seo',
  2 => 'mainwp-child',
  3 => 'simple-wordpress-backup',
  4 => 'html-editor-syntax-highlighter',
  5 => 'search-and-replace',
  6 => 'sem-external-links',
  7 => 'display-widgets',
  8 => 'wordpress-seo',
  9 => 'ricg-responsive-images',
  10 => 'simple-sitemap',
  11 => 'all-in-one-wp-security-and-firewall',
  12 => 'contact-form-7-to-database-extension',
  13 => 'contact-form-7-recaptcha-extension',
  14 => 'master-slider',
  15 => 'bwp-recaptcha',
  16 => 'better-admin-bar',
  17 => 'wp-meta-seo',
  18 => 'backwpup',
  19 => 'wp-smushit'
);
\$wpkgr_selected_theme = '';
\$wpkgr_custom_front = 'no_blog';
\$wpkgr_permalinks = '/%postname%/';
\$wpkgr_delete_dolly = 'delete_dolly';
\$wpkgr_delete_example_post = 'delete_example_post';
\$wpkgr_delete_example_page = 'delete_example_page';
\$wpkgr_uploads = 'uploads';
\$wpkgr_site_slogan = 'Another Optimized WordPress Site';
\$wpkgr_timezone = 'America/Los_Angeles';
\$wpkgr_first_day = 0;
// Default category
\$cat_name = __('Uncategorized');
/* translators: Default category slug */
\$cat_slug = sanitize_title(_x('Uncategorized', 'Default category slug'));
	if ( global_terms_enabled() ) {
		\$cat_id = \$wpdb->get_var( \$wpdb->prepare( "SELECT cat_ID FROM {\$wpdb->sitecategories} WHERE category_nicename = %s", \$cat_slug ) );
		if ( \$cat_id == null ) {
			\$wpdb->insert( \$wpdb->sitecategories, array('cat_ID' => 0, 'cat_name' => \$cat_name, 'category_nicename' => \$cat_slug, 'last_updated' => current_time('mysql', true)) );
			\$cat_id = \$wpdb->insert_id;
		}
		update_option('default_category', \$cat_id);
	} else {
		\$cat_id = 1;
	}

	\$wpdb->insert( \$wpdb->terms, array('term_id' => \$cat_id, 'name' => \$cat_name, 'slug' => \$cat_slug, 'term_group' => 0) );
	\$wpdb->insert( \$wpdb->term_taxonomy, array('term_id' => \$cat_id, 'taxonomy' => 'category', 'description' => '', 'parent' => 0, 'count' => 1));
	\$cat_tt_id = \$wpdb->insert_id;

/**WPKGR**/
if (\$wpkgr_delete_example_post !== 'delete_example_post') {

	// First post
	\$now = date('Y-m-d H:i:s');
	\$now_gmt = gmdate('Y-m-d H:i:s');
	\$first_post_guid = get_option('home') . '/?p=1';

	if ( is_multisite() ) {
		\$first_post = get_site_option( 'first_post' );

		if ( empty(\$first_post) )
			\$first_post = stripslashes( __( 'Welcome to <a href="SITE_URL">SITE_NAME</a>. This is your first post. Edit or delete it, then start blogging!' ) );

		\$first_post = str_replace( "SITE_URL", esc_url( network_home_url() ), \$first_post );
		\$first_post = str_replace( "SITE_NAME", \$current_site->site_name, \$first_post );
	} else {
		\$first_post = __('Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!');
	}

	\$wpdb->insert( \$wpdb->posts, array(
								'post_author' => \$user_id,
								'post_date' => \$now,
								'post_date_gmt' => \$now_gmt,
								'post_content' => \$first_post,
								'post_excerpt' => '',
								'post_title' => __('Hello world!'),
								/* translators: Default post slug */
								'post_name' => sanitize_title( _x('hello-world', 'Default post slug') ),
								'post_modified' => \$now,
								'post_modified_gmt' => \$now_gmt,
								'guid' => \$first_post_guid,
								'comment_count' => 1,
								'to_ping' => '',
								'pinged' => '',
								'post_content_filtered' => ''
								));
	\$wpdb->insert( \$wpdb->term_relationships, array('term_taxonomy_id' => \$cat_tt_id, 'object_id' => 1) );

	// Default comment
	\$first_comment_author = __('Mr WordPress');
	\$first_comment_url = 'http://wordpress.org/';
	\$first_comment = __('Hi, this is a comment.
To delete a comment, just log in and view the post&#039;s comments. There you will have the option to edit or delete them.');
	if ( is_multisite() ) {
		\$first_comment_author = get_site_option( 'first_comment_author', \$first_comment_author );
		\$first_comment_url = get_site_option( 'first_comment_url', network_home_url() );
		\$first_comment = get_site_option( 'first_comment', \$first_comment );
	}
	\$wpdb->insert( \$wpdb->comments, array(
								'comment_post_ID' => 1,
								'comment_author' => \$first_comment_author,
								'comment_author_email' => '',
								'comment_author_url' => \$first_comment_url,
								'comment_date' => \$now,
								'comment_date_gmt' => \$now_gmt,
								'comment_content' => \$first_comment
								));
/**WPKGR -- end if delete_post **/ }

if (\$wpkgr_delete_example_page !== 'delete_example_page') {

	// First Page
	\$first_page = sprintf( __( "This is an example page. It's different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:

<blockquote>Hi there! I'm a bike messenger by day, aspiring actor by night, and this is my blog. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin' caught in the rain.)</blockquote>

...or something like this:

<blockquote>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</blockquote>

As a new WordPress user, you should go to <a href=\"%s\">your dashboard</a> to delete this page and create new pages for your content. Have fun!" ), admin_url() );
	if ( is_multisite() )
		\$first_page = get_site_option( 'first_page', \$first_page );
	\$first_post_guid = get_option('home') . '/?page_id=2';
	\$wpdb->insert( \$wpdb->posts, array(
								'post_author' => \$user_id,
								'post_date' => \$now,
								'post_date_gmt' => \$now_gmt,
								'post_content' => \$first_page,
								'post_excerpt' => '',
								'post_title' => __( 'Sample Page' ),
								/* translators: Default page slug */
								'post_name' => __( 'sample-page' ),
								'post_modified' => \$now,
								'post_modified_gmt' => \$now_gmt,
								'guid' => \$first_post_guid,
								'post_type' => 'page',
								'to_ping' => '',
								'pinged' => '',
								'post_content_filtered' => ''
								));
	\$wpdb->insert( \$wpdb->postmeta, array( 'post_id' => 2, 'meta_key' => '_wp_page_template', 'meta_value' => 'default' ) );

/**WPKGR -- end if delete_page **/ }

	// Set up default widgets for default theme.
	update_option( 'widget_search', array ( 2 => array ( 'title' => '' ), '_multiwidget' => 1 ) );
	update_option( 'widget_recent-posts', array ( 2 => array ( 'title' => '', 'number' => 5 ), '_multiwidget' => 1 ) );
	update_option( 'widget_recent-comments', array ( 2 => array ( 'title' => '', 'number' => 5 ), '_multiwidget' => 1 ) );
	update_option( 'widget_archives', array ( 2 => array ( 'title' => '', 'count' => 0, 'dropdown' => 0 ), '_multiwidget' => 1 ) );
	update_option( 'widget_categories', array ( 2 => array ( 'title' => '', 'count' => 0, 'hierarchical' => 0, 'dropdown' => 0 ), '_multiwidget' => 1 ) );
	update_option( 'widget_meta', array ( 2 => array ( 'title' => '' ), '_multiwidget' => 1 ) );
	update_option( 'sidebars_widgets', array ( 'wp_inactive_widgets' => array ( ), 'sidebar-1' => array ( 0 => 'search-2', 1 => 'recent-posts-2', 2 => 'recent-comments-2', 3 => 'archives-2', 4 => 'categories-2', 5 => 'meta-2', ), 'sidebar-2' => array ( ), 'sidebar-3' => array ( ), 'array_version' => 3 ) );

	if ( ! is_multisite() )
		update_user_meta( \$user_id, 'show_welcome_panel', 1 );
	elseif ( ! is_super_admin( \$user_id ) && ! metadata_exists( 'user', \$user_id, 'show_welcome_panel' ) )
		update_user_meta( \$user_id, 'show_welcome_panel', 2 );

	if ( is_multisite() ) {
		// Flush rules to pick up the new page.
		\$wp_rewrite->init();
		\$wp_rewrite->flush_rules();

		\$user = new WP_User(\$user_id);
		\$wpdb->update( \$wpdb->options, array('option_value' => \$user->user_email), array('option_name' => 'admin_email') );

		// Remove all perms except for the login user.
		\$wpdb->query( \$wpdb->prepare("DELETE FROM \$wpdb->usermeta WHERE user_id != %d AND meta_key = %s", \$user_id, \$table_prefix.'user_level') );
		\$wpdb->query( \$wpdb->prepare("DELETE FROM \$wpdb->usermeta WHERE user_id != %d AND meta_key = %s", \$user_id, \$table_prefix.'capabilities') );

		// Delete any caps that snuck into the previously active blog. (Hardcoded to blog 1 for now.) TODO: Get previous_blog_id.
		if ( !is_super_admin( \$user_id ) && \$user_id != 1 )
			\$wpdb->delete( \$wpdb->usermeta, array( 'user_id' => \$user_id , 'meta_key' => \$wpdb->base_prefix.'1_capabilities' ) );
	}

if(\$wpkgr_selected_plugins !== NULL) {

	foreach (\$wpkgr_selected_plugins as \$plugin) {
		\$request = new StdClass();
		\$request->slug = stripslashes(\$plugin);
		\$post_data = array(
		'action' => 'plugin_information',
		'request' => serialize(\$request)
		);
		\$options = array(
		CURLOPT_URL => 'http://api.wordpress.org/plugins/info/1.0/',
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => \$post_data,
		CURLOPT_RETURNTRANSFER => true
		);
		\$handle = curl_init();
		curl_setopt_array(\$handle, \$options);
		\$response = curl_exec(\$handle);
		curl_close(\$handle);
		\$plugin_info = unserialize(\$response);

		if (!file_exists(WP_CONTENT_DIR . '/plugins/' . \$plugin_info->slug)) {

			echo "Downloading and Extracting \$plugin_info->name<br />";

			\$file = WP_CONTENT_DIR . '/plugins/' . basename(\$plugin_info->download_link);

			\$fp = fopen(\$file,'w');

			\$ch = curl_init();
			curl_setopt(\$ch, CURLOPT_USERAGENT, 'WPKGR');
			curl_setopt(\$ch, CURLOPT_URL, \$plugin_info->download_link);
			curl_setopt(\$ch, CURLOPT_FAILONERROR, TRUE);
			curl_setopt(\$ch, CURLOPT_HEADER, 0);
			@curl_setopt(\$ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt(\$ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt(\$ch, CURLOPT_BINARYTRANSFER, TRUE);
			curl_setopt(\$ch, CURLOPT_TIMEOUT, 120);
			curl_setopt(\$ch, CURLOPT_FILE, \$fp);
			\$b = curl_exec(\$ch);

			if (!\$b) {
				\$message = 'Download error: '. curl_error(\$ch) .', please try again';
				curl_close(\$ch);
				throw new Exception(\$message);
			}

			fclose(\$fp);

			if (!file_exists(\$file)) throw new Exception('Zip file not downloaded');

			if (class_exists('ZipArchive')) {
				\$zip = new ZipArchive;

				if(\$zip->open(\$file) !== TRUE) throw new Exception('Unable to open Zip file');

				\$zip->extractTo(ABSPATH . 'wp-content/plugins/');

				\$zip->close();
			}
			else {
				// try unix shell command
				@shell_exec('unzip -d ../wp-content/plugins/ '. \$file);
			}
			unlink(\$file);
			echo "<strong>Done!</strong><br />";
		} //end if file exists

	} //end foreach

} //if plugins

if(\$wpkgr_selected_theme != '') {
	\$request = new StdClass();
	\$request->slug = stripslashes(\$wpkgr_selected_theme);
	\$post_data = array(
    'action' => 'theme_information',
    'request' => serialize(\$request)
	);
	\$options = array(
    CURLOPT_URL => 'http://api.wordpress.org/themes/info/1.0/',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => \$post_data,
    CURLOPT_RETURNTRANSFER => true
	);
	\$handle = curl_init();
	curl_setopt_array(\$handle, \$options);
	\$response = curl_exec(\$handle);
	curl_close(\$handle);
	\$theme_info = unserialize(\$response);

	if (!file_exists(WP_CONTENT_DIR . '/themes/' . \$theme_info->slug)) {
		echo "Downloading and Extracting \$theme_info->name<br />";

		\$file = WP_CONTENT_DIR . '/themes/' . basename(\$theme_info->download_link);

		\$fp = fopen(\$file,'w');

		\$ch = curl_init();
		curl_setopt(\$ch, CURLOPT_USERAGENT, 'WPKGR');
		curl_setopt(\$ch, CURLOPT_URL, \$theme_info->download_link);
		curl_setopt(\$ch, CURLOPT_FAILONERROR, TRUE);
		curl_setopt(\$ch, CURLOPT_HEADER, 0);
		@curl_setopt(\$ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt(\$ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt(\$ch, CURLOPT_BINARYTRANSFER, TRUE);
		curl_setopt(\$ch, CURLOPT_TIMEOUT, 120);
		curl_setopt(\$ch, CURLOPT_FILE, \$fp);
		\$b = curl_exec(\$ch);

		if (!\$b) {
			\$message = 'Download error: '. curl_error(\$ch) .', please try again';
			curl_close(\$ch);
			throw new Exception(\$message);
		}

		fclose(\$fp);

		if (!file_exists(\$file)) throw new Exception('Zip file not downloaded');

		if (class_exists('ZipArchive')) {
			\$zip = new ZipArchive;

				if(\$zip->open(\$file) !== TRUE) throw new Exception('Unable to open Zip file');

					\$zip->extractTo(ABSPATH . 'wp-content/themes/');

					\$zip->close();
		}
		else {
			// try unix shell command
			@shell_exec('unzip -d ../wp-content/themes/ '. \$file);
		}

		unlink(\$file);
		echo "<strong>Done!</strong><br />";

	} //end if file exists

}//if theme

echo "Configuring WordPress<br>";

	function run_activate_plugin( \$plugin ) {
		\$current = get_option( 'active_plugins' );
		\$plugin = plugin_basename( trim( \$plugin ) );
		\$current[] = \$plugin;
		sort( \$current );
		do_action( 'activate_plugin', trim( \$plugin ) );
		update_option( 'active_plugins', \$current );
		do_action( 'activate_' . trim( \$plugin ) );
		do_action( 'activated_plugin', trim( \$plugin) );
	}

if(\$wpkgr_selected_plugins !== NULL) {

	foreach (\$wpkgr_selected_plugins as \$plugin) {
		\$request = new StdClass();
		\$request->slug = stripslashes(\$plugin);
		\$post_data = array(
		'action' => 'plugin_information',
		'request' => serialize(\$request)
		);
		\$options = array(
		CURLOPT_URL => 'http://api.wordpress.org/plugins/info/1.0/',
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => \$post_data,
		CURLOPT_RETURNTRANSFER => true
		);
		\$handle = curl_init();
		curl_setopt_array(\$handle, \$options);
		\$response = curl_exec(\$handle);
		curl_close(\$handle);
		\$plugin_info = unserialize(\$response);
		\$daplugins = get_plugins( '/' . \$plugin_info->slug );
		\$paths = array_keys(\$daplugins);
		\$plugin_file = \$plugin_info->slug . '/' . \$paths[0];
		run_activate_plugin(\$plugin_file);
	} //end foreach
} //if plugins

	if(\$wpkgr_selected_theme != '') {
		//ENABLE THEME
		update_option( 'template', \$wpkgr_selected_theme );
		update_option( 'stylesheet', \$wpkgr_selected_theme );
	}

//custom_front

	if (\$wpkgr_custom_front == 'custom_front') {

		//create home page
		\$page['post_type']    = 'page';
		\$page['post_content'] = '';
		\$page['post_parent']  = 0;
		\$page['post_author']  = 1;
		\$page['post_status']  = 'publish';
		\$page['post_title']   = 'Home';
		\$page['comment_status'] = 'closed';
		\$pageid = wp_insert_post (\$page);
		//create blog page
		\$page['post_type']    = 'page';
		\$page['post_content'] = '';
		\$page['post_parent']  = 0;
		\$page['post_author']  = 1;
		\$page['post_status']  = 'publish';
		\$page['post_title']   = 'Blog';
		\$page['comment_status'] = 'closed';
		\$pageid = wp_insert_post (\$page);

		//static front page
		\$home = get_page_by_title( 'Home' );
		update_option( 'page_on_front', \$home->ID );
		update_option( 'show_on_front', 'page' );

		//set the blog page
		\$blog   = get_page_by_title( 'Blog' );
		update_option( 'page_for_posts', \$blog->ID );
	}

	if (\$wpkgr_custom_front == 'no_blog') {
		//create home page
		\$page['post_type']    = 'page';
		\$page['post_content'] = '';
		\$page['post_parent']  = 0;
		\$page['post_author']  = 1;
		\$page['post_status']  = 'publish';
		\$page['post_title']   = 'Home';
		\$page['comment_status'] = 'closed';
		\$pageid = wp_insert_post (\$page);
		//static front page
		\$home = get_page_by_title( 'Home' );
		update_option( 'page_on_front', \$home->ID );
		update_option( 'show_on_front', 'page' );
	}

//permalinks

	if (\$wpkgr_permalinks != 'default') {

		if (get_option('permalink_structure') != \$wpkgr_permalinks)
		{

			if (empty(\$wp_rewrite) || !(\$wp_rewrite instanceof WP_Rewrite))
			{
				\$wp_rewrite = new WP_Rewrite();
			}

			// Update permalink structure
			\$wp_rewrite->set_permalink_structure(\$wpkgr_permalinks);

			// Recreate rewrite rules
			\$wp_rewrite->flush_rules();

		}

	}

//delete dolly

	if (\$wpkgr_delete_dolly == 'delete_dolly') {
		delete_plugins(array('hello.php'));
	}

//month and year folders for uploads

	if (\$wpkgr_uploads !== 'uploads') {
	update_option('uploads_use_yearmonth_folders',0);
	}

//site slogan

	if (\$wpkgr_site_slogan !== 'Just another WordPress site') {
	update_option( 'blogdescription', \$wpkgr_site_slogan );
	}

//timezone

	if (\$wpkgr_timezone !== 'default') {

	 update_option('timezone_string',\$wpkgr_timezone);

	}

//first day of week

	if (\$wpkgr_first_day !== 1) {
	update_option('start_of_week',0);
	}

//Search engine visibility
	update_option('blog_public', '0');

echo "<strong>Done!</strong>";

//delete install.php

	unlink(ABSPATH . 'wp-content/install.php');
}
?>
EOD;

//check if curl and exec are available
		if ( !in_array('curl', get_loaded_extensions()) || exec('echo EXEC') !== 'EXEC'){

			echo "<h2>Sorry:</h2>";

			if (!in_array('curl', get_loaded_extensions())) {
				echo "<p>The required <strong>cURL</strong> package for PHP is not enabled on this server.</p>";
			}

			if (exec('echo EXEC') !== 'EXEC') {
				echo "<p>The required PHP <strong>exec</strong> command is not enabled on this server.</p>";
			}

		exit;
}

//download latest wordpress
		echo "<p>Downloading and extracting the latest version of WordPress...";
		$wpkgr_dl_file = explode('/',$wpkgr_lang_url);
		$wpkgr_dl_file = $wpkgr_dl_file[3];
        $ch = curl_init($wpkgr_lang_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);

			if (!$data) {
				$message = 'Download error: '. curl_error($ch) .', please try again';
				curl_close($ch);
				throw new Exception($message);
			}

        curl_close($ch);

        file_put_contents($wpkgr_dl_file, $data);

		exec("tar -zxvf $wpkgr_dl_file");
		exec("cp -rvf wordpress/* .");
		exec("rm -R wordpress");
		exec("rm $wpkgr_dl_file");

		echo "<span style='font-weight: bold; color: green'>DONE!</span></p>";

//create custom install.php
		echo "<p>Creating your custom install file...";
		$install_file = 'wp-content/install.php';
		$handle = fopen($install_file, 'w') or die('Cannot open file:  '.$install_file);

		fwrite($handle, $install_data);

		fclose($handle);

		echo "<span style='font-weight: bold; color: green'>DONE!</span></p>";
		echo "<p><strong>After you <a href='http://cp.optimizehere.co/phpmyadmin' target='_blank'>create the database and user</a>, you can <a href='wp-admin/setup-config.php'>click here to install WordPress</a></p>";

//delete this file
		exec('rm wp.php');

?>