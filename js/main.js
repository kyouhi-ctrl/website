/**
 * WebStack 主题 JavaScript 功能
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // 搜索框增强
        enhanceSearchBox();
        
        // 网站链接点击统计
        trackSiteClicks();
        
        // 添加动画效果
        addAnimations();
        
        // 响应式菜单
        initResponsiveMenu();
        
        // 懒加载图标
        lazyLoadFavicons();
        
    });
    
    /**
     * 增强搜索框功能
     */
    function enhanceSearchBox() {
        const searchBox = $('.search-box');
        
        // 搜索建议
        searchBox.on('input', function() {
            const query = $(this).val();
            if (query.length > 2) {
                showSearchSuggestions(query);
            } else {
                hideSearchSuggestions();
            }
        });
        
        // 键盘导航
        searchBox.on('keydown', function(e) {
            const suggestions = $('.search-suggestions');
            if (suggestions.is(':visible')) {
                const items = suggestions.find('.suggestion-item');
                const current = suggestions.find('.suggestion-item.active');
                
                if (e.keyCode === 40) { // 下箭头
                    e.preventDefault();
                    if (current.length) {
                        current.removeClass('active').next().addClass('active');
                    } else {
                        items.first().addClass('active');
                    }
                } else if (e.keyCode === 38) { // 上箭头
                    e.preventDefault();
                    if (current.length) {
                        current.removeClass('active').prev().addClass('active');
                    } else {
                        items.last().addClass('active');
                    }
                } else if (e.keyCode === 13) { // 回车
                    e.preventDefault();
                    if (current.length) {
                        window.location.href = current.find('a').attr('href');
                    } else {
                        $(this).closest('form').submit();
                    }
                } else if (e.keyCode === 27) { // ESC
                    hideSearchSuggestions();
                }
            }
        });
        
        // 点击外部关闭建议
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-container').length) {
                hideSearchSuggestions();
            }
        });
    }
    
    /**
     * 显示搜索建议
     */
    function showSearchSuggestions(query) {
        // 这里可以添加AJAX请求获取搜索建议
        // 暂时使用静态数据演示
        const suggestions = [
            { name: 'Google', url: 'https://www.google.com', desc: '搜索引擎' },
            { name: 'GitHub', url: 'https://github.com', desc: '代码托管' },
            { name: 'Stack Overflow', url: 'https://stackoverflow.com', desc: '技术问答' }
        ];
        
        const filtered = suggestions.filter(item => 
            item.name.toLowerCase().includes(query.toLowerCase()) ||
            item.desc.toLowerCase().includes(query.toLowerCase())
        );
        
        if (filtered.length > 0) {
            let html = '<div class="search-suggestions">';
            filtered.forEach(item => {
                html += `
                    <div class="suggestion-item">
                        <a href="${item.url}" target="_blank">
                            <span class="suggestion-name">${item.name}</span>
                            <span class="suggestion-desc">${item.desc}</span>
                        </a>
                    </div>
                `;
            });
            html += '</div>';
            
            $('.search-container').append(html);
        }
    }
    
    /**
     * 隐藏搜索建议
     */
    function hideSearchSuggestions() {
        $('.search-suggestions').remove();
    }
    
    /**
     * 跟踪网站点击
     */
    function trackSiteClicks() {
        $('.site-link a').on('click', function() {
            const siteName = $(this).find('.site-name').text();
            
            // 发送点击统计（可以集成Google Analytics等）
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'site_link',
                    'event_label': siteName
                });
            }
            
            // 本地存储点击记录
            const clicks = JSON.parse(localStorage.getItem('site_clicks') || '{}');
            clicks[siteName] = (clicks[siteName] || 0) + 1;
            localStorage.setItem('site_clicks', JSON.stringify(clicks));
        });
    }
    
    /**
     * 添加动画效果
     */
    function addAnimations() {
        // 滚动动画
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);
        
        // 观察所有卡片
        $('.category-card').each(function() {
            observer.observe(this);
        });
        
        // 鼠标悬停效果
        $('.category-card').hover(
            function() {
                $(this).addClass('hover-effect');
            },
            function() {
                $(this).removeClass('hover-effect');
            }
        );
    }
    
    /**
     * 初始化响应式菜单
     */
    function initResponsiveMenu() {
        // 创建移动端菜单按钮
        if ($(window).width() <= 768) {
            $('.nav-container').prepend('<button class="mobile-menu-toggle">☰</button>');
            
            $('.mobile-menu-toggle').on('click', function() {
                $('.nav-links').toggleClass('mobile-open');
                $(this).toggleClass('active');
            });
        }
        
        // 窗口大小改变时重新初始化
        $(window).on('resize', function() {
            if ($(window).width() > 768) {
                $('.nav-links').removeClass('mobile-open');
                $('.mobile-menu-toggle').remove();
            } else if (!$('.mobile-menu-toggle').length) {
                $('.nav-container').prepend('<button class="mobile-menu-toggle">☰</button>');
                $('.mobile-menu-toggle').on('click', function() {
                    $('.nav-links').toggleClass('mobile-open');
                    $(this).toggleClass('active');
                });
            }
        });
    }
    
    /**
     * 懒加载网站图标
     */
    function lazyLoadFavicons() {
        const images = $('.site-favicon');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });
            
            images.each(function() {
                imageObserver.observe(this);
            });
        }
    }
    
    /**
     * 添加键盘快捷键
     */
    $(document).on('keydown', function(e) {
        // Ctrl/Cmd + K 聚焦搜索框
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 75) {
            e.preventDefault();
            $('.search-box').focus();
        }
        
        // ESC 清除搜索
        if (e.keyCode === 27) {
            $('.search-box').val('').blur();
            hideSearchSuggestions();
        }
    });
    
    /**
     * 添加主题切换功能
     */
    function initThemeToggle() {
        // 检查本地存储的主题设置
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.body.classList.add(savedTheme + '-theme');
        
        // 创建主题切换按钮
        $('.nav-container').append('<button class="theme-toggle">🌙</button>');
        
        $('.theme-toggle').on('click', function() {
            const currentTheme = document.body.classList.contains('dark-theme') ? 'dark' : 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.body.classList.remove(currentTheme + '-theme');
            document.body.classList.add(newTheme + '-theme');
            
            localStorage.setItem('theme', newTheme);
            
            $(this).text(newTheme === 'dark' ? '☀️' : '🌙');
        });
        
        // 设置初始图标
        $('.theme-toggle').text(savedTheme === 'dark' ? '☀️' : '🌙');
    }
    
    // 初始化主题切换
    initThemeToggle();
    
})(jQuery);

