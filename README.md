# WebStack WordPress 主题

一个简洁美观的网站导航主题，基于原版 WebStack 主题重新设计，具有现代化的界面和丰富的功能。

## 功能特性

- 🎨 **现代化设计** - 简洁美观的界面设计
- 📱 **响应式布局** - 完美适配各种设备
- 🌙 **暗色主题** - 支持明暗主题切换
- 🔍 **智能搜索** - 带搜索建议的搜索功能
- ⚡ **快速加载** - 优化的性能和加载速度
- 🎯 **易于管理** - 简单的后台管理界面
- 🔧 **高度可定制** - 支持自定义颜色和样式

## 安装方法

### 方法一：WordPress 安装

1. 下载主题文件到 `wp-content/themes/webstack/` 目录
2. 在 WordPress 后台的"外观" > "主题"中激活主题
3. 设置固定链接（设置 > 固定链接 > 保存更改）

### 方法二：直接使用 HTML 版本

直接打开 `demo.html` 文件即可在浏览器中查看效果。

## 使用说明

### WordPress 版本

1. **添加网站链接**
   - 在后台"网站"菜单中添加新的网站
   - 填写网站名称、URL、描述和分类
   - 系统会自动获取网站图标

2. **管理分类**
   - 在"文章" > "分类目录"中创建分类
   - 最多支持两级分类
   - 父级分类不要添加内容

3. **设置导航菜单**
   - 在"外观" > "菜单"中设置导航菜单
   - 在菜单项的CSS类中添加图标

4. **自定义主题**
   - 在"外观" > "自定义"中可以修改主题色
   - 支持实时预览

### HTML 版本

直接编辑 `demo.html` 文件，修改网站链接和分类即可。

## 文件结构

```
webstack/
├── style.css          # 主题样式文件
├── index.php          # WordPress 主模板文件
├── functions.php      # 主题功能文件
├── demo.html          # HTML 演示文件
├── js/
│   └── main.js        # JavaScript 功能文件
├── css/               # 额外样式文件目录
├── images/            # 图片资源目录
├── inc/               # 包含文件目录
├── templates/         # 模板文件目录
└── languages/         # 语言文件目录
```

## 自定义开发

### 修改样式

编辑 `style.css` 文件来自定义样式：

```css
/* 修改主题色 */
:root {
    --primary-color: #your-color;
}
```

### 添加新功能

在 `functions.php` 中添加自定义功能：

```php
// 添加自定义功能
function your_custom_function() {
    // 你的代码
}
add_action('init', 'your_custom_function');
```

### JavaScript 功能

在 `js/main.js` 中添加交互功能：

```javascript
// 添加自定义 JavaScript 功能
function yourCustomFunction() {
    // 你的代码
}
```

## 浏览器支持

- Chrome 60+
- Firefox 60+
- Safari 12+
- Edge 79+

## 技术栈

- **前端**: HTML5, CSS3, JavaScript (jQuery)
- **后端**: PHP 7.0+, WordPress 4.4+
- **样式**: CSS Grid, Flexbox, CSS Variables
- **图标**: Font Awesome (可选)

## 更新日志

### v1.0.0 (2024-01-01)
- 初始版本发布
- 基础导航功能
- 响应式设计
- 暗色主题支持
- 搜索功能

## 贡献

欢迎提交 Issue 和 Pull Request 来改进这个主题。

## 许可证

MIT License

## 致谢

感谢原版 WebStack 主题的作者 [owen0o0](https://github.com/owen0o0) 提供的灵感。

## 演示

查看在线演示：[demo.html](demo.html)

## 支持

如果你在使用过程中遇到问题，可以：

1. 查看本文档
2. 提交 Issue
3. 联系开发者

---

**注意**: 这是一个基于原版 WebStack 主题的重新实现，保持了原有的设计理念，但使用了更现代的技术栈和更好的用户体验。

# website
