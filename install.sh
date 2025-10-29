#!/bin/bash

# WebStack 主题安装脚本
# 使用方法: ./install.sh

echo "🚀 WebStack 主题安装脚本"
echo "=========================="

# 检查是否在正确的目录
if [ ! -f "style.css" ]; then
    echo "❌ 错误: 请在 webstack 主题目录中运行此脚本"
    exit 1
fi

echo "📁 当前目录: $(pwd)"
echo ""

# 检查文件是否存在
echo "🔍 检查必要文件..."
files=("style.css" "index.php" "functions.php" "demo.html" "js/main.js" "README.md")

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file"
    else
        echo "❌ $file (缺失)"
    fi
done

echo ""
echo "📋 安装选项:"
echo "1. WordPress 安装"
echo "2. 直接使用 HTML 版本"
echo "3. 查看演示"
echo "4. 退出"

read -p "请选择 (1-4): " choice

case $choice in
    1)
        echo ""
        echo "📝 WordPress 安装说明:"
        echo "1. 将此文件夹复制到 wp-content/themes/ 目录"
        echo "2. 在 WordPress 后台激活主题"
        echo "3. 设置固定链接 (设置 > 固定链接 > 保存更改)"
        echo "4. 在后台添加网站链接和分类"
        echo ""
        echo "📁 WordPress 主题路径:"
        echo "   wp-content/themes/webstack/"
        ;;
    2)
        echo ""
        echo "🌐 HTML 版本使用说明:"
        echo "1. 直接打开 demo.html 文件"
        echo "2. 编辑 demo.html 修改网站链接"
        echo "3. 修改 style.css 自定义样式"
        echo ""
        echo "📁 直接打开: $(pwd)/demo.html"
        ;;
    3)
        echo ""
        echo "🎬 打开演示页面..."
        if command -v open >/dev/null 2>&1; then
            open demo.html
        elif command -v xdg-open >/dev/null 2>&1; then
            xdg-open demo.html
        else
            echo "请手动打开 demo.html 文件"
        fi
        ;;
    4)
        echo "👋 再见!"
        exit 0
        ;;
    *)
        echo "❌ 无效选择"
        exit 1
        ;;
esac

echo ""
echo "🎉 安装完成!"
echo ""
echo "📚 更多信息请查看 README.md"
echo "🔧 自定义样式请编辑 style.css"
echo "⚙️  添加功能请编辑 functions.php (WordPress版本)"
echo ""
echo "💡 提示:"
echo "   - 支持响应式设计"
echo "   - 支持暗色主题切换"
echo "   - 支持搜索功能"
echo "   - 支持自定义颜色"

