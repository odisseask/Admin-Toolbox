<?php
/*
  Plugin Name: Index Tool Setup
  Description:Used to add script header and footer section on site.
  Version: 0.0.1
  Author: Automattic
  Author URI: #
  License: GPLv2 or later
  Text Domain: Index tool Set
 */


define('INDEXTOOL_SHOW_MSG', '');
define('INDEXTOOL_DIR', $path . "/neto-supply");
define('INDEXTOOL_VERSION', '0.0.1');


/**
 * Create admin Page to list option.
 */
// Hook for adding admin menus
add_action('admin_enqueue_scripts', 'indextool_enqueue_scripts');

function indextool_enqueue_scripts() {
    wp_enqueue_style('style-name', plugin_dir_url(__FILE__));
    wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');

    wp_enqueue_script('bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
    wp_enqueue_script('sweetalert_js', 'https://unpkg.com/sweetalert/dist/sweetalert.min.js');
//     wp_enqueue_script( 'frontend-ajax', plugin_dir_url(__FILE__)  . 'frontend-ajax.js', array('jquery'), null, true );
    wp_enqueue_script('frontend-ajax', plugin_dir_url(__FILE__) . '/js/indextool.js');
    wp_localize_script('frontend-ajax', 'frontend_ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'data_var_1' => 'value 1',
        'data_var_2' => 'value 2',
            )
    );
}

/**
 * Options page callback
 */
add_action('admin_menu', 'indextool_admin_actions');

// This page will be under "Settings"
function indextool_admin_actions() {
    add_menu_page('Index Tool', 'Index Tool', 'manage_options', 'index_tool');
    add_submenu_page('index_tool', 'Index Tool', 'Index Tool', 'manage_options', 'index_tool', 'index_tool_restrict_admin', 'dashicons-update');
}

function mfwp_register_settings() {
    // creates our settings in the options table
    register_setting('indextool_google_analytics_script', 'google_analytics_script');
    register_setting('indextool_facebook_analytics_script', 'facebook_analytics_script');
    register_setting('indextool_google_pixels', 'google_google_pixels');
    register_setting('indextool_facebook_pixels', 'facebook_pixels');
    register_setting('indextool_extra_css', 'ind_extra_css');
    register_setting('indextool_google_tag_manager', 'google_tag_manager');
    register_setting('indextool_google_analytics_settings', 'google_analytics_settings');
}

add_action('admin_init', 'mfwp_register_settings');

function all_setting_setup_post_type() {
    register_post_type('google_analytics_script', array(
        'rewrite' => array('slug' => 'google_analytics_script'),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
            )
    );
    register_post_type('facebook_analytics_script', array(
        'public' => true,
        'has_archive' => true,
            )
    );
    register_post_type('google_google_pixels', array(
        'public' => true,
        'has_archive' => true,
            )
    );
    register_post_type('facebook_pixels', array(
        'public' => true,
        'has_archive' => true,
            )
    );
    register_post_type('ind_extra_css', array(
        'public' => true,
        'has_archive' => true,
            )
    );
    register_post_type('google_tag_manager', array(
        'public' => true,
        'has_archive' => true,
            )
    );
    register_post_type('google_analytics_settings', array(
        'public' => true,
        'has_archive' => true,
            )
    );
}

add_action('init', 'all_setting_setup_post_type');

function index_tool_restrict_admin() {
    $google_analytics_script = get_option('google_analytics_script');
    $facebook_analytics_script = get_option('facebook_analytics_script');
    $google_google_pixels = get_option('google_google_pixels');
    $facebook_pixel_script = get_option('facebook_pixel_script');
    $ind_extra_css = get_option('ind_extra_css');
    $google_tag_manager = get_option('google_tag_manager');
    ?>
    <div class="container">
        <h3>Settings</h3>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#analytics">Analytics</a></li>
            <li><a data-toggle="tab"  href="#pixels">Pixels</a></li>
            <li><a data-toggle="tab"  href="#css">CSS</a></li>
            <li><a data-toggle="tab"  href="#other">Other</a></li>
        </ul>
        <div class="tab-content">
            <div id="analytics" class="tab-pane fade in active">


                <!---section one analytics---->
                <form  method="post">
                    <div class="form-group">
                        <label for="google_analytics"><h3>Google Analytics:</h3></label>
                        <textarea class="form-control" rows="5" id="google_analytics_sdata" name="google_analytics_sdata"><?php echo get_post_field('post_content', $google_analytics_script); ?></textarea>

                    </div>

                    <label class="radio-inline"><input type="radio" name="google_ana" value="header" <?php echo (get_post_meta($google_analytics_script, 'type', true) == 'header' ? 'checked' : ''); ?>>Header</label>
                    <label class="radio-inline"><input type="radio" name="google_ana" value="footer" <?php echo (get_post_meta($google_analytics_script, 'type', true) == 'footer' ? 'checked' : ''); ?>>Footer</label>



                    <input type="button" name="google_analytics" id="google_analytics" class="btn btn-default" value="Save">
                </form>

                <hr>
                <form>
                    <div class="form-group">
                        <label for="facebook_analytics"><h3>Facebook Analytics:</h3></label>
                        <textarea class="form-control" rows="5" id="facebook_analytics"><?php echo get_post_field('post_content', $facebook_analytics_script); ?></textarea>
                    </div>
                    <label class="radio-inline"><input type="radio" name="facebook_ana" value="header" <?php echo (get_post_meta($facebook_analytics_script, 'type', true) == 'header' ? 'checked' : ''); ?>>Header</label>
                    <label class="radio-inline"><input type="radio" name="facebook_ana" value="footer" <?php echo (get_post_meta($facebook_analytics_script, 'type', true) == 'footer' ? 'checked' : ''); ?>>Footer</label>
                    <input type="button" name="facebook_analytics_button" id="google_analytics_button" class="btn btn-default" value="Save">
                </form>


            </div>
            <div id="pixels" class="tab-pane fade">

                <!---section two pixels---->
                <form>
                    <div class="form-group">
                        <label for="google_google_pixels"><h3>Google Pixel:</h3></label>
                        <textarea class="form-control" name="google_google_pixels" id="google_google_pixels" rows="5"><?php echo get_post_field('post_content', $google_google_pixels); ?></textarea>
                    </div>
                    <label class="radio-inline"><input type="radio" name="google_pixel" value="header" <?php echo (get_post_meta($google_google_pixels, 'type', true) == 'header' ? 'checked' : ''); ?>>Header</label>
                    <label class="radio-inline"><input type="radio" name="google_pixel" value="footer" <?php echo (get_post_meta($google_google_pixels, 'type', true) == 'footer' ? 'checked' : ''); ?>>Footer</label>
                    <input type="button" name="google_google_pixels_button" id="google_google_pixels_button" class="btn btn-default" value="Save">
                </form>

                <hr>

                <form>
                    <div class="form-group">
                        <label for="facebook_pixel_script"><h3>Facebook Pixels:</h3></label>
                        <textarea class="form-control" rows="5" id="facebook_pixel_script"><?php echo get_post_field('post_content', $facebook_pixel_script); ?></textarea>
                    </div>
                    <label class="radio-inline"><input type="radio" name="facebook_pixel" value="header" <?php echo (get_post_meta($facebook_pixel_script, 'type', true) == 'header' ? 'checked' : ''); ?>>Header</label>
                    <label class="radio-inline"><input type="radio" name="facebook_pixel" value="footer" <?php echo (get_post_meta($facebook_pixel_script, 'type', true) == 'footer' ? 'checked' : ''); ?>>Footer</label>
                    <input type="button" name="facebook_pixel_script_button" id="facebook_pixel_script_button" class="btn btn-default" value="Save">
                </form>

            </div>
            <div id="css" class="tab-pane fade">
                <!---section three extra css ---->
                <form>
                    <div class="form-group">
                        <label for="extra_css"><h3>Extra CSS:</h3></label>
                        <textarea class="form-control" rows="5" id="extra_css"><?php echo get_post_field('post_content', $ind_extra_css); ?></textarea>
                    </div>
                    <label class="radio-inline"><input type="radio" name="css_set" value="header" <?php echo (get_post_meta($ind_extra_css, 'type', true) == 'header' ? 'checked' : ''); ?>>Header</label>
                    <label class="radio-inline"><input type="radio" name="css_set" value="footer" <?php echo (get_post_meta($ind_extra_css, 'type', true) == 'footer' ? 'checked' : ''); ?>>Footer</label>
                    <button type="button" class="btn btn-default" id="extra_css_button">Save</button>
                </form>


            </div>
            <div id="other" class="tab-pane fade">
                <!---section four extra css ---->
                <form>
                    <div class="form-group">
                        <label for="google_tag_mng"><h3>Google Tag Manager:</h3></label>
                        <textarea class="form-control" rows="5" id="google_tag_mng"><?php echo get_post_field('post_content', $google_tag_manager); ?></textarea>
                    </div>
                    <label class="radio-inline"><input type="radio" name="tag_mng" value="header" <?php echo (get_post_meta($google_tag_manager, 'type', true) == 'header' ? 'checked' : ''); ?>>Header</label>
                    <label class="radio-inline"><input type="radio" name="tag_mng" value="footer" <?php echo (get_post_meta($google_tag_manager, 'type', true) == 'footer' ? 'checked' : ''); ?>>Footer</label>
                    <button type="button" id="google_tag_manager_button" class="btn btn-default">Save</button>
                </form>


            </div>
        </div>
    </div>
    <?php
}

function show_link() {
    $google_analytics_script = get_option('google_analytics_script');
    $facebook_analytics_script = get_option('facebook_analytics_script');
    $google_google_pixels = get_option('google_google_pixels');
    $facebook_pixel_script = get_option('facebook_pixel_script');
    $ind_extra_css = get_option('ind_extra_css');
    $google_tag_manager = get_option('google_tag_manager');

    if ($google_analytics_script && get_post_meta($google_analytics_script, 'type', true) == 'header') {
       echo get_post_field('post_content', $google_analytics_script);
    }
    if ($facebook_analytics_script && get_post_meta($facebook_analytics_script, 'type', true) == 'header') {
        echo get_post_field('post_content', $facebook_analytics_script);
    }
    if ($google_google_pixels && get_post_meta($google_google_pixels, 'type', true) == 'header') {
        echo get_post_field('post_content', $google_google_pixels);
    }
    if ($facebook_pixel_script && get_post_meta($facebook_pixel_script, 'type', true) == 'header') {
        echo get_post_field('post_content', $facebook_pixel_script);
    }
    if ($ind_extra_css && get_post_meta($ind_extra_css, 'type', true) == 'header') {
        echo get_post_field('post_content', $ind_extra_css);
    }
    if ($google_tag_manager && get_post_meta($google_tag_manager, 'type', true) == 'header') {
        echo get_post_field('post_content', $google_tag_manager);
    }
    //echo '<p>ratnesh</p>';
}

add_action('wp_head', 'show_link');
add_action('wp_footer', 'show_link_footer');

function show_link_footer() {
    $google_analytics_script = get_option('google_analytics_script');
    $facebook_analytics_script = get_option('facebook_analytics_script');
    $google_google_pixels = get_option('google_google_pixels');
    $facebook_pixel_script = get_option('facebook_pixel_script');
    $ind_extra_css = get_option('ind_extra_css');
    $google_tag_manager = get_option('google_tag_manager');

    if ($google_analytics_script && get_post_meta($google_analytics_script, 'type', true) == 'footer') {
        echo get_post_field('post_content', $google_analytics_script);
    }
    if ($facebook_analytics_script && get_post_meta($facebook_analytics_script, 'type', true) == 'footer') {
        echo get_post_field('post_content', $facebook_analytics_script);
    }
    if ($google_google_pixels && get_post_meta($google_google_pixels, 'type', true) == 'footer') {
        echo get_post_field('post_content', $google_google_pixels);
    }
    if ($facebook_pixel_script && get_post_meta($facebook_pixel_script, 'type', true) == 'footer') {
        echo get_post_field('post_content', $facebook_pixel_script);
    }
    if ($ind_extra_css && get_post_meta($ind_extra_css, 'type', true) == 'footer') {
        echo get_post_field('post_content', $ind_extra_css);
    }
    if ($google_tag_manager && get_post_meta($google_tag_manager, 'type', true) == 'footer') {
        echo get_post_field('post_content', $google_tag_manager);
    }
}
    function indextool_activate_set() {

    $array_index_post_set = array();
    // Activation code here...
    add_option('myhack_extraction_length', array_index_post_set);
}

register_activation_hook(__FILE__, 'indextool_activate_set');

add_action('wp_ajax_nopriv_save_data', 'save_data');
add_action('wp_ajax_save_data', 'save_data');

function save_data() {
    if ($_POST['request'] == 'google_ana') {
        $google_analytics_script = get_option('google_analytics_script');
        if ($google_analytics_script != '') {
            $my_post = array(
                'ID' => $google_analytics_script,
                'post_content' => $_POST['data'],
            );
            wp_update_post($my_post);
            update_post_meta($google_analytics_script, 'type', $_POST['type']);
            update_option('google_analytics_script', $google_analytics_script);
        } else {
            $post_id = wp_insert_post(array(
                'post_type' => 'google_analytics',
                'post_title' => 'google_analytics_sdata',
                'post_content' => $_POST['data'],
                'post_status' => 'publish',
            ));
            update_post_meta($post_id, 'type', $_POST['type']);
            update_option('google_analytics_script', $post_id);
        }
    } else if ($_POST['request'] == 'facebook_ana') {
        $facebook_analytics_script = get_option('facebook_analytics_script');
        if ($facebook_analytics_script != '') {
            $my_post = array(
                'ID' => $facebook_analytics_script,
                'post_content' => $_POST['data'],
            );
            wp_update_post($my_post);
            update_post_meta($facebook_analytics_script, 'type', $_POST['type']);
            update_option('facebook_analytics_script', $facebook_analytics_script);
        } else {
            $post_id = wp_insert_post(array(
                'post_type' => 'facebook_analytics',
                'post_title' => 'facebook_analytics_script',
                'post_content' => $_POST['data'],
                'post_status' => 'publish',
            ));
            update_post_meta($post_id, 'type', $_POST['type']);
            update_option('facebook_analytics_script', $post_id);
        }
    } else if ($_POST['request'] == 'google_pixel') {
        $google_google_pixels = get_option('google_google_pixels');
        if ($google_google_pixels != '') {
            $my_post = array(
                'ID' => $google_google_pixels,
                'post_content' => $_POST['data'],
            );
            wp_update_post($my_post);
            update_post_meta($google_google_pixels, 'type', $_POST['type']);
            update_option('google_google_pixels', $google_google_pixels);
        } else {
            $post_id = wp_insert_post(array(
                'post_type' => 'google_google_pixels',
                'post_title' => 'google_pixels',
                'post_content' => $_POST['data'],
                'post_status' => 'publish',
            ));
            update_post_meta($post_id, 'type', $_POST['type']);
            update_option('google_google_pixels', $post_id);
        }
    } else if ($_POST['request'] == 'facebook_pixel') {
        $facebook_pixel_script = get_option('facebook_pixel_script');
        if ($facebook_pixel_script != '') {
            $my_post = array(
                'ID' => $facebook_pixel_script,
                'post_content' => $_POST['data'],
            );
            wp_update_post($my_post);
            update_post_meta($facebook_pixel_script, 'type', $_POST['type']);
            update_option('facebook_pixel_script', $facebook_pixel_script);
        } else {
            $post_id = wp_insert_post(array(
                'post_type' => 'facebook_pixels',
                'post_title' => 'facebook_pixel_script',
                'post_content' => $_POST['data'],
                'post_status' => 'publish',
            ));
            update_post_meta($post_id, 'type', $_POST['type']);
            update_option('facebook_pixel_script', $post_id);
        }
    } else if ($_POST['request'] == 'css_set') {
        $ind_extra_css = get_option('ind_extra_css');
        if ($ind_extra_css != '') {
            $my_post = array(
                'ID' => $ind_extra_css,
                'post_content' => $_POST['data'],
            );
            wp_update_post($my_post);
            update_post_meta($ind_extra_css, 'type', $_POST['type']);
            update_option('ind_extra_css', $ind_extra_css);
        } else {
            $post_id = wp_insert_post(array(
                'post_type' => 'ind_extra_css',
                'post_title' => 'css_set',
                'post_content' => $_POST['data'],
                'post_status' => 'publish',
            ));
            update_post_meta($post_id, 'type', $_POST['type']);
            update_option('ind_extra_css', $post_id);
        }
    } else if ($_POST['request'] == 'tag_mng') {
        $google_tag_manager = get_option('google_tag_manager');
        if ($google_tag_manager != '') {
            $my_post = array(
                'ID' => $google_tag_manager,
                'post_content' => $_POST['data'],
            );
            wp_update_post($my_post);
            update_post_meta($google_tag_manager, 'type', $_POST['type']);
            update_option('google_tag_manager', $google_tag_manager);
        } else {
            $post_id = wp_insert_post(array(

                'post_type' => 'google_tag_manager',
                'post_title' => 'tag_mng',
                'post_content' => $_POST['data'],
                'post_status' => 'publish',
            ));
            update_post_meta($post_id, 'type', $_POST['type']);
            update_option('google_tag_manager', $post_id);
        }
    }


    wp_die();
}
?>