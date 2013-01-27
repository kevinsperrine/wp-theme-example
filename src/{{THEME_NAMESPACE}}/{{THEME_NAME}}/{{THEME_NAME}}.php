<?php

class {{THEME_NAMESPACE}}_{{THEME_NAME}}_{{THEME_NAME}}
{
    protected $wp;

    protected $themeDirectory;

    public function __construct(WordPress $facade = null)
    {
        if (! $facade) {
            $facade = new C3_Facade_WordPress();
        }

        $this->wp = $facade;
    }

    public function setFacade(WordPress $facade)
    {
        $this->wp = $facade;
    }

    public function setThemeDirectory()
    {
        $this->themeDirectory = $this->wp->get_bloginfo('template_directory') . '/';
    }

    public function initialize()
    {
        $this->setThemeDirectory();

        $this->wp->add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
        $this->wp->add_action('wp_enqueue_scripts', array($this, 'enqueueStyles'));
        $this->wp->add_action('after_setup_theme', array( $this, 'initialize' ));
        $this->wp->add_action('widgets_init', array($this, 'registerSidebars'));

        // remove the admin bar
        $this->wp->add_filter('show_admin_bar', '__return_false');

        // Set the default editor to display html
        $this->wp->add_filter('wp_default_editor', create_function('', 'return "html";'));

        // Disable the autop filter.
        $this->wp->remove_filter('the_content', 'wpautop');

        // Clean up the output of wp_head
        // Display the links to the extra feeds such as category feeds
        $this->wp->remove_action('wp_head', 'feed_links_extra', 3);

        // Display the links to the general feeds: Post and Comment Feed
        $this->wp->remove_action('wp_head', 'feed_links', 2);

        // Display the link to the Really Simple Discovery service endpoint, EditURI link
        $this->wp->remove_action('wp_head', 'rsd_link');

        // Display the link to the Windows Live Writer manifest file.
        $this->wp->remove_action('wp_head', 'wlwmanifest_link');

        // index link
        $this->wp->remove_action('wp_head', 'index_rel_link');

        // canonical link
        $this->wp->remove_action('wp_head', 'rel_canonical');

        // prev link
        $this->wp->remove_action('wp_head', 'parent_post_rel_link', 10, 0);

        // start link
        $this->wp->remove_action('wp_head', 'start_post_rel_link', 10, 0);

        // Display relational links for the posts adjacent to the current post.
        $this->wp->remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

        // Display the XHTML generator that is generated on the wp_head hook, WP version
        $this->wp->remove_action('wp_head', 'wp_generator');

        /**
        * Makes Twenty Twelve available for translation.
        *
        * Translations can be added to the /languages/ directory.
        * If you're building a theme based on Twenty Twelve, use a find and replace
        * to change 'twentytwelve' to the name of your theme in all the template files.
        */
        $this->wp->load_theme_textdomain('boilerplate', $this->getAssetUrl('/languages'));

        // This theme styles the visual editor with editor-style.css to match the theme style.
        $this->wp->add_editor_style();

        // Adds RSS feed links to <head> for posts and comments.
        $this->wp->add_theme_support('automatic-feed-links');

        // This theme uses wp_nav_menu() in one location.
        $this->wp->register_nav_menu('primary', $this->wp->__('Primary Menu', 'boilerplate'));

        // This theme uses a custom image size for featured images, displayed on "standard" posts.
        $this->wp->add_theme_support('post-thumbnails');
        $this->wp->set_post_thumbnail_size(624, 9999); // Unlimited height, soft crop
    }

    public function registerSidebars()
    {
        $this->wp->register_sidebar(
            array(
                'before_widget' => '<section>',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widgettitle">',
                'after_title' => '</h2>',
            )
        );
    }

    public function enqueueScripts()
    {
        $this->wp->wp_enqueue_script(
            'jquery',
            "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js",
            false,
            '1.8.3',
            true
        );
    }

    public function enqueueStyles()
    {
        $this->wp->wp_enqueue_style(
            'main',
            $this->getAssetUrl('css/main.css'),
            false,
            null
        );
    }

    public function getAssetUrl($filePath = '')
    {
        return $this->themeDirectory . $filePath;
    }

    public function assetUrl($filePath = '')
    {
        echo $this->getAssetUrl($filePath);
    }
}
