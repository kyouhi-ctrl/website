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
<header class="crypto-header">
    <div class="main-container">
        <h1><?php bloginfo('name'); ?></h1>
        <p><?php bloginfo('description'); ?></p>
    </div>
</header>

<!-- 导航菜单 -->
<nav class="crypto-nav">
    <div class="nav-container">
        <a href="<?php echo home_url(); ?>" class="crypto-nav-logo"><?php bloginfo('name'); ?></a>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'crypto',
            'menu_class' => 'crypto-nav-links',
            'container' => false,
            'fallback_cb' => false
        ));
        ?>
    </div>
</nav>

<!-- 搜索框 -->
<div class="main-container">
    <div class="crypto-search">
        <form role="search" method="get" action="<?php echo home_url('/'); ?>">
            <input type="search" class="crypto-search-box" placeholder="搜索币圈工具、交易所、项目..." value="<?php echo get_search_query(); ?>" name="s" />
        </form>
    </div>
</div>

<!-- 主要内容 -->
<main class="main-container">
    <!-- 币圈数据概览 -->
    <div class="crypto-stats">
        <h3>📊 币圈实时数据</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value" id="total-market-cap">$2.1T</div>
                <div class="stat-label">总市值</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="volume-24h">$89.2B</div>
                <div class="stat-label">24h交易量</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="active-cryptos">8,456</div>
                <div class="stat-label">活跃币种</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="btc-dominance">1.2%</div>
                <div class="stat-label">BTC占比</div>
            </div>
        </div>
    </div>

    <div class="category-grid">
        <!-- 未命名星球推荐 -->
        <div class="crypto-card">
            <h2 class="category-title">
                <span class="crypto-icon">🚗</span>
                星球推荐
                <span class="crypto-badge">HOT</span>
            </h2>
            <ul class="site-links">
                <?php
                // 获取推荐工具
                $featured_tools = get_posts(array(
                    'post_type' => 'crypto_tools',
                    'posts_per_page' => 6,
                    'meta_query' => array(
                        array(
                            'key' => 'tool_featured',
                            'value' => '1',
                            'compare' => '='
                        )
                    )
                ));
                
                if (!empty($featured_tools)) :
                    foreach ($featured_tools as $tool) :
                        $tool_url = get_post_meta($tool->ID, 'tool_url', true);
                        $tool_desc = get_post_meta($tool->ID, 'tool_description', true);
                        $tool_favicon = get_post_meta($tool->ID, 'tool_favicon', true);
                ?>
                <li class="site-link">
                    <a href="<?php echo esc_url($tool_url); ?>" target="_blank" rel="noopener" class="crypto-link">
                        <?php if ($tool_favicon) : ?>
                        <img src="<?php echo esc_url($tool_favicon); ?>" alt="" class="site-favicon">
                        <?php endif; ?>
                        <span class="site-name"><?php echo $tool->post_title; ?></span>
                        <?php if ($tool_desc) : ?>
                        <span class="site-desc"><?php echo $tool_desc; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php 
                    endforeach;
                else :
                ?>
                <li class="site-link">
                    <a href="https://coinmarketcap.com" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://coinmarketcap.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">CoinMarketCap</span>
                        <span class="site-desc">最权威的币圈行情数据</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://www.binance.com" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://www.binance.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">币安</span>
                        <span class="site-desc">全球最大交易所</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- 交易所大全 -->
        <div class="crypto-card">
            <h2 class="category-title">
                <span class="crypto-icon">🏦</span>
                交易所大全
                <span class="crypto-badge">20%返佣</span>
            </h2>
            <div class="exchange-highlight">
                💰 注册即享20%手续费返佣
            </div>
            <ul class="site-links">
                <?php
                // 获取交易所
                $exchanges = get_posts(array(
                    'post_type' => 'exchanges',
                    'posts_per_page' => 8,
                    'orderby' => 'meta_value',
                    'meta_key' => 'exchange_featured',
                    'order' => 'DESC'
                ));
                
                if (!empty($exchanges)) :
                    foreach ($exchanges as $exchange) :
                        $exchange_url = get_post_meta($exchange->ID, 'exchange_url', true);
                        $exchange_desc = get_post_meta($exchange->ID, 'exchange_description', true);
                        $exchange_favicon = get_post_meta($exchange->ID, 'exchange_favicon', true);
                        $exchange_rebate = get_post_meta($exchange->ID, 'exchange_rebate', true);
                        $exchange_featured = get_post_meta($exchange->ID, 'exchange_featured', true);
                ?>
                <li class="site-link">
                    <a href="<?php echo esc_url($exchange_url); ?>" target="_blank" rel="noopener" class="crypto-link">
                        <?php if ($exchange_favicon) : ?>
                        <img src="<?php echo esc_url($exchange_favicon); ?>" alt="" class="site-favicon">
                        <?php endif; ?>
                        <span class="site-name">
                            <?php echo $exchange->post_title; ?>
                            <?php if ($exchange_rebate) : ?>
                            (<?php echo $exchange_rebate; ?>返佣)
                            <?php endif; ?>
                        </span>
                        <?php if ($exchange_desc) : ?>
                        <span class="site-desc"><?php echo $exchange_desc; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php 
                    endforeach;
                else :
                ?>
                <li class="site-link">
                    <a href="https://www.binance.com" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://www.binance.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">币安 (20%返佣)</span>
                        <span class="site-desc">全球最大加密货币交易所</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://www.bybit.com" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://www.bybit.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">Bybit (20%返佣)</span>
                        <span class="site-desc">专业合约交易平台</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- 币圈投研工具 -->
        <div class="crypto-card">
            <h2 class="category-title">
                <span class="crypto-icon">🔬</span>
                币圈投研工具
            </h2>
            <ul class="site-links">
                <?php
                // 获取投研工具分类
                $research_tools = get_posts(array(
                    'post_type' => 'crypto_tools',
                    'posts_per_page' => 8,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'tool_type',
                            'field' => 'slug',
                            'terms' => 'research'
                        )
                    )
                ));
                
                if (!empty($research_tools)) :
                    foreach ($research_tools as $tool) :
                        $tool_url = get_post_meta($tool->ID, 'tool_url', true);
                        $tool_desc = get_post_meta($tool->ID, 'tool_description', true);
                        $tool_favicon = get_post_meta($tool->ID, 'tool_favicon', true);
                ?>
                <li class="site-link">
                    <a href="<?php echo esc_url($tool_url); ?>" target="_blank" rel="noopener" class="crypto-link">
                        <?php if ($tool_favicon) : ?>
                        <img src="<?php echo esc_url($tool_favicon); ?>" alt="" class="site-favicon">
                        <?php endif; ?>
                        <span class="site-name"><?php echo $tool->post_title; ?></span>
                        <?php if ($tool_desc) : ?>
                        <span class="site-desc"><?php echo $tool_desc; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php 
                    endforeach;
                else :
                ?>
                <li class="site-link">
                    <a href="https://rootdata.com" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://rootdata.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">RootData</span>
                        <span class="site-desc">专业投研工具</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://coinmarketcap.com" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://coinmarketcap.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">CoinMarketCap</span>
                        <span class="site-desc">币圈行情查询工具</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- 币圈数据工具 -->
        <div class="crypto-card">
            <h2 class="category-title">
                <span class="crypto-icon">📊</span>
                币圈数据工具
            </h2>
            <ul class="site-links">
                <?php
                // 获取数据工具分类
                $data_tools = get_posts(array(
                    'post_type' => 'crypto_tools',
                    'posts_per_page' => 8,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'tool_type',
                            'field' => 'slug',
                            'terms' => 'data'
                        )
                    )
                ));
                
                if (!empty($data_tools)) :
                    foreach ($data_tools as $tool) :
                        $tool_url = get_post_meta($tool->ID, 'tool_url', true);
                        $tool_desc = get_post_meta($tool->ID, 'tool_description', true);
                        $tool_favicon = get_post_meta($tool->ID, 'tool_favicon', true);
                ?>
                <li class="site-link">
                    <a href="<?php echo esc_url($tool_url); ?>" target="_blank" rel="noopener" class="crypto-link">
                        <?php if ($tool_favicon) : ?>
                        <img src="<?php echo esc_url($tool_favicon); ?>" alt="" class="site-favicon">
                        <?php endif; ?>
                        <span class="site-name"><?php echo $tool->post_title; ?></span>
                        <?php if ($tool_desc) : ?>
                        <span class="site-desc"><?php echo $tool_desc; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php 
                    endforeach;
                else :
                ?>
                <li class="site-link">
                    <a href="https://www.aicoin.com" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://www.aicoin.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">AIcoin</span>
                        <span class="site-desc">K线查看工具</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://www.tradingview.com" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://www.tradingview.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">TradingView</span>
                        <span class="site-desc">专业交易者投资工具</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- DeFi 工具 -->
        <div class="crypto-card">
            <h2 class="category-title">
                <span class="crypto-icon">🔄</span>
                DeFi 工具
            </h2>
            <ul class="site-links">
                <?php
                // 获取DeFi工具分类
                $defi_tools = get_posts(array(
                    'post_type' => 'crypto_tools',
                    'posts_per_page' => 6,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'tool_type',
                            'field' => 'slug',
                            'terms' => 'defi'
                        )
                    )
                ));
                
                if (!empty($defi_tools)) :
                    foreach ($defi_tools as $tool) :
                        $tool_url = get_post_meta($tool->ID, 'tool_url', true);
                        $tool_desc = get_post_meta($tool->ID, 'tool_description', true);
                        $tool_favicon = get_post_meta($tool->ID, 'tool_favicon', true);
                ?>
                <li class="site-link">
                    <a href="<?php echo esc_url($tool_url); ?>" target="_blank" rel="noopener" class="crypto-link">
                        <?php if ($tool_favicon) : ?>
                        <img src="<?php echo esc_url($tool_favicon); ?>" alt="" class="site-favicon">
                        <?php endif; ?>
                        <span class="site-name"><?php echo $tool->post_title; ?></span>
                        <?php if ($tool_desc) : ?>
                        <span class="site-desc"><?php echo $tool_desc; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php 
                    endforeach;
                else :
                ?>
                <li class="site-link">
                    <a href="https://defillama.com" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://defillama.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">DeFiLlama</span>
                        <span class="site-desc">DeFi数据工具</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://uniswap.org" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://uniswap.org/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">Uniswap</span>
                        <span class="site-desc">去中心化交易所</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- AI 工具 -->
        <div class="crypto-card">
            <h2 class="category-title">
                <span class="crypto-icon">🤖</span>
                AI 工具
                <span class="crypto-badge">NEW</span>
            </h2>
            <ul class="site-links">
                <?php
                // 获取AI工具分类
                $ai_tools = get_posts(array(
                    'post_type' => 'crypto_tools',
                    'posts_per_page' => 6,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'tool_type',
                            'field' => 'slug',
                            'terms' => 'ai'
                        )
                    )
                ));
                
                if (!empty($ai_tools)) :
                    foreach ($ai_tools as $tool) :
                        $tool_url = get_post_meta($tool->ID, 'tool_url', true);
                        $tool_desc = get_post_meta($tool->ID, 'tool_description', true);
                        $tool_favicon = get_post_meta($tool->ID, 'tool_favicon', true);
                ?>
                <li class="site-link">
                    <a href="<?php echo esc_url($tool_url); ?>" target="_blank" rel="noopener" class="crypto-link">
                        <?php if ($tool_favicon) : ?>
                        <img src="<?php echo esc_url($tool_favicon); ?>" alt="" class="site-favicon">
                        <?php endif; ?>
                        <span class="site-name"><?php echo $tool->post_title; ?></span>
                        <?php if ($tool_desc) : ?>
                        <span class="site-desc"><?php echo $tool_desc; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php 
                    endforeach;
                else :
                ?>
                <li class="site-link">
                    <a href="https://chat.openai.com" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://chat.openai.com/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">ChatGPT</span>
                        <span class="site-desc">AI助手</span>
                    </a>
                </li>
                <li class="site-link">
                    <a href="https://claude.ai" target="_blank" rel="noopener" class="crypto-link">
                        <img src="https://claude.ai/favicon.ico" alt="" class="site-favicon">
                        <span class="site-name">Claude</span>
                        <span class="site-desc">AI分析工具</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</main>

<!-- 页脚 -->
<footer class="crypto-footer">
    <div class="main-container">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Design by <strong>WebStack</strong> Modify by <strong>iowen</strong></p>
        <p>⚠️ 风险提示：数字货币投资有风险，请谨慎投资</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>




