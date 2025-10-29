<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- 头部区域 -->
<header class="header">
    <div class="main-container">
        <h1><?php bloginfo('name'); ?></h1>
        <p><?php bloginfo('description'); ?></p>
    </div>
</header>

<!-- 导航菜单 -->
<nav class="nav-menu">
    <div class="nav-container">
        <a href="<?php echo home_url(); ?>" class="nav-logo"><?php bloginfo('name'); ?></a>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_class' => 'nav-links',
            'container' => false,
            'fallback_cb' => false
        ));
        ?>
    </div>
</nav>

<!-- 搜索框 -->
<div class="main-container">
    <div class="search-container">
        <form role="search" method="get" action="<?php echo home_url('/'); ?>">
            <input type="search" class="search-box" placeholder="搜索网站..." value="<?php echo get_search_query(); ?>" name="s" />
        </form>
    </div>
</div>

<!-- 主要内容 -->
<main class="main-container">
    <div class="category-grid">
        <?php
        // 获取所有分类
        $categories = get_categories(array(
            'hide_empty' => false,
            'parent' => 0
        ));
        
        foreach ($categories as $category) :
            // 获取该分类下的网站链接
            $sites = get_posts(array(
                'post_type' => 'sites',
                'posts_per_page' => 10,
                'meta_query' => array(
                    array(
                        'key' => 'site_category',
                        'value' => $category->term_id,
                        'compare' => '='
                    )
                )
            ));
            
            if (!empty($sites)) :
        ?>
        <div class="category-card">
            <h2 class="category-title">
                <span class="category-icon"><?php echo substr($category->name, 0, 1); ?></span>
                <?php echo $category->name; ?>
            </h2>
            <ul class="site-links">
                <?php foreach ($sites as $site) : 
                    $site_url = get_post_meta($site->ID, 'site_url', true);
                    $site_desc = get_post_meta($site->ID, 'site_description', true);
                    $site_favicon = get_post_meta($site->ID, 'site_favicon', true);
                ?>
                <li class="site-link">
                    <a href="<?php echo esc_url($site_url); ?>" target="_blank" rel="noopener">
                        <?php if ($site_favicon) : ?>
                        <img src="<?php echo esc_url($site_favicon); ?>" alt="" class="site-favicon">
                        <?php endif; ?>
                        <span class="site-name"><?php echo $site->post_title; ?></span>
                        <?php if ($site_desc) : ?>
                        <span class="site-desc"><?php echo $site_desc; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php 
            endif;
        endforeach; 
        ?>
        
        <!-- 如果没有分类，显示示例内容 -->
        <?php if (empty($categories)) : ?>
        <div class="category-card">
            <h2 class="category-title">
                <span class="category-icon">🔍</span>
                搜索引擎
            </h2>
            <ul class="site-links">
                <li class="site-link">
                    <a href="https://www.google.com" target="_blank" rel="noopener">
                        <img src="https://www.google.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">Google</span>
                        <span class="site-desc">全球最大的搜索引擎</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://www.baidu.com" target="_blank" rel="noopener">
                        <img src="https://www.baidu.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">百度</span>
                        <span class="site-desc">中文搜索引擎</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://www.bing.com" target="_blank" rel="noopener">
                        <img src="https://www.bing.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">Bing</span>
                        <span class="site-desc">微软搜索引擎</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="category-card">
            <h2 class="category-title">
                <span class="category-icon">💻</span>
                开发工具
            </h2>
            <ul class="site-links">
                <li class="site-link">
                    <a href="https://github.com" target="_blank" rel="noopener">
                        <img src="https://github.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">GitHub</span>
                        <span class="site-desc">代码托管平台</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://stackoverflow.com" target="_blank" rel="noopener">
                        <img src="https://stackoverflow.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">Stack Overflow</span>
                        <span class="site-desc">程序员问答社区</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://developer.mozilla.org" target="_blank" rel="noopener">
                        <img src="https://developer.mozilla.org/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">MDN</span>
                        <span class="site-desc">Web开发文档</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="category-card">
            <h2 class="category-title">
                <span class="category-icon">🎨</span>
                设计资源
            </h2>
            <ul class="site-links">
                <li class="site-link">
                    <a href="https://dribbble.com" target="_blank" rel="noopener">
                        <img src="https://dribbble.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">Dribbble</span>
                        <span class="site-desc">设计师作品展示</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://www.behance.net" target="_blank" rel="noopener">
                        <img src="https://www.behance.net/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">Behance</span>
                        <span class="site-desc">创意作品平台</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://unsplash.com" target="_blank" rel="noopener">
                        <img src="https://unsplash.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">Unsplash</span>
                        <span class="site-desc">免费高质量图片</span>
                    </a>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</main>

<!-- 页脚 -->
<footer class="footer">
    <div class="main-container">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 基于 WebStack 主题构建</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
