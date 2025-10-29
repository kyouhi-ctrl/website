<?php
/**
 * WebStack 主题功能文件
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 主题设置
function webstack_setup() {
    // 添加主题支持
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // 注册导航菜单
    register_nav_menus(array(
        'primary' => '主导航菜单',
    ));
    
    // 注册自定义文章类型
    register_post_type('sites', array(
        'labels' => array(
            'name' => '网站',
            'singular_name' => '网站',
            'add_new' => '添加网站',
            'add_new_item' => '添加新网站',
            'edit_item' => '编辑网站',
            'new_item' => '新网站',
            'view_item' => '查看网站',
            'search_items' => '搜索网站',
            'not_found' => '未找到网站',
            'not_found_in_trash' => '回收站中未找到网站'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-admin-site',
        'show_in_menu' => true,
    ));
}
add_action('after_setup_theme', 'webstack_setup');

// 注册样式和脚本
function webstack_scripts() {
    wp_enqueue_style('webstack-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_script('webstack-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'webstack_scripts');

// 添加自定义字段
function webstack_add_meta_boxes() {
    add_meta_box(
        'site_details',
        '网站详情',
        'webstack_site_details_callback',
        'sites',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'webstack_add_meta_boxes');

// 网站详情回调函数
function webstack_site_details_callback($post) {
    wp_nonce_field('webstack_save_site_details', 'webstack_site_details_nonce');
    
    $site_url = get_post_meta($post->ID, 'site_url', true);
    $site_description = get_post_meta($post->ID, 'site_description', true);
    $site_favicon = get_post_meta($post->ID, 'site_favicon', true);
    $site_category = get_post_meta($post->ID, 'site_category', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="site_url">网站URL</label></th>';
    echo '<td><input type="url" id="site_url" name="site_url" value="' . esc_attr($site_url) . '" style="width: 100%;" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="site_description">网站描述</label></th>';
    echo '<td><input type="text" id="site_description" name="site_description" value="' . esc_attr($site_description) . '" style="width: 100%;" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="site_favicon">网站图标URL</label></th>';
    echo '<td><input type="url" id="site_favicon" name="site_favicon" value="' . esc_attr($site_favicon) . '" style="width: 100%;" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="site_category">所属分类</label></th>';
    echo '<td>';
    wp_dropdown_categories(array(
        'name' => 'site_category',
        'selected' => $site_category,
        'show_option_none' => '选择分类',
        'option_none_value' => '',
        'hide_empty' => false,
    ));
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// 保存自定义字段
function webstack_save_site_details($post_id) {
    if (!isset($_POST['webstack_site_details_nonce']) || 
        !wp_verify_nonce($_POST['webstack_site_details_nonce'], 'webstack_save_site_details')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['site_url'])) {
        update_post_meta($post_id, 'site_url', sanitize_url($_POST['site_url']));
    }
    
    if (isset($_POST['site_description'])) {
        update_post_meta($post_id, 'site_description', sanitize_text_field($_POST['site_description']));
    }
    
    if (isset($_POST['site_favicon'])) {
        update_post_meta($post_id, 'site_favicon', sanitize_url($_POST['site_favicon']));
    }
    
    if (isset($_POST['site_category'])) {
        update_post_meta($post_id, 'site_category', intval($_POST['site_category']));
    }
}
add_action('save_post', 'webstack_save_site_details');

// 自动获取网站图标
function webstack_get_favicon($url) {
    $domain = parse_url($url, PHP_URL_HOST);
    $favicon_url = 'https://www.google.com/s2/favicons?domain=' . $domain . '&sz=32';
    return $favicon_url;
}

// 添加管理栏菜单
function webstack_admin_menu() {
    add_menu_page(
        'WebStack 设置',
        'WebStack',
        'manage_options',
        'webstack-settings',
        'webstack_settings_page',
        'dashicons-admin-site',
        30
    );
}
add_action('admin_menu', 'webstack_admin_menu');

// 设置页面
function webstack_settings_page() {
    ?>
    <div class="wrap">
        <h1>WebStack 主题设置</h1>
        <div class="card">
            <h2>使用说明</h2>
            <p>1. 在"网站"菜单中添加您的网站链接</p>
            <p>2. 为每个网站设置URL、描述和分类</p>
            <p>3. 系统会自动获取网站图标，您也可以手动设置</p>
            <p>4. 在"外观 > 菜单"中设置导航菜单</p>
        </div>
        
        <div class="card">
            <h2>快速添加网站</h2>
            <form method="post" action="">
                <?php wp_nonce_field('webstack_quick_add', 'webstack_quick_add_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th>网站名称</th>
                        <td><input type="text" name="site_name" required style="width: 100%;" /></td>
                    </tr>
                    <tr>
                        <th>网站URL</th>
                        <td><input type="url" name="site_url" required style="width: 100%;" /></td>
                    </tr>
                    <tr>
                        <th>网站描述</th>
                        <td><input type="text" name="site_description" style="width: 100%;" /></td>
                    </tr>
                    <tr>
                        <th>分类</th>
                        <td>
                            <?php wp_dropdown_categories(array(
                                'name' => 'site_category',
                                'show_option_none' => '选择分类',
                                'hide_empty' => false,
                            )); ?>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" name="quick_add_site" class="button-primary" value="快速添加" />
                </p>
            </form>
        </div>
    </div>
    <?php
    
    // 处理快速添加
    if (isset($_POST['quick_add_site']) && 
        isset($_POST['webstack_quick_add_nonce']) && 
        wp_verify_nonce($_POST['webstack_quick_add_nonce'], 'webstack_quick_add')) {
        
        $post_id = wp_insert_post(array(
            'post_title' => sanitize_text_field($_POST['site_name']),
            'post_type' => 'sites',
            'post_status' => 'publish',
        ));
        
        if ($post_id) {
            update_post_meta($post_id, 'site_url', sanitize_url($_POST['site_url']));
            update_post_meta($post_id, 'site_description', sanitize_text_field($_POST['site_description']));
            update_post_meta($post_id, 'site_category', intval($_POST['site_category']));
            update_post_meta($post_id, 'site_favicon', webstack_get_favicon($_POST['site_url']));
            
            echo '<div class="notice notice-success"><p>网站添加成功！</p></div>';
        }
    }
}

// 自定义搜索功能
function webstack_search_filter($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_search()) {
            $query->set('post_type', array('post', 'sites'));
        }
    }
}
add_action('pre_get_posts', 'webstack_search_filter');

// 添加主题自定义器选项
function webstack_customize_register($wp_customize) {
    // 添加颜色设置
    $wp_customize->add_setting('primary_color', array(
        'default' => '#667eea',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => '主题色',
        'section' => 'colors',
        'settings' => 'primary_color',
    )));
}
add_action('customize_register', 'webstack_customize_register');

// 输出自定义CSS
function webstack_custom_css() {
    $primary_color = get_theme_mod('primary_color', '#667eea');
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
        }
        .header {
            background: linear-gradient(135deg, <?php echo esc_attr($primary_color); ?> 0%, #764ba2 100%);
        }
        .nav-logo {
            color: <?php echo esc_attr($primary_color); ?>;
        }
        .nav-links a:hover {
            color: <?php echo esc_attr($primary_color); ?>;
        }
        .search-box:focus {
            border-color: <?php echo esc_attr($primary_color); ?>;
        }
        .site-link a:hover {
            border-left-color: <?php echo esc_attr($primary_color); ?>;
        }
        .category-icon {
            background: <?php echo esc_attr($primary_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'webstack_custom_css');
?>

