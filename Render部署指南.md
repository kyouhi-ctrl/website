# Render 部署指南

## 🚀 将未命名星球网站部署到 Render

### 方法一：直接上传文件（推荐）

#### 1. 准备工作
- 确保所有文件都在 `webstack` 文件夹中
- 主要文件：`crypto-demo.html`、`style.css`、`js/main.js` 等

#### 2. 创建 Render 账户
1. 访问 [render.com](https://render.com)
2. 点击 "Get Started" 注册账户
3. 可以使用 GitHub 账户登录（推荐）

#### 3. 创建新项目
1. 登录后点击 "New +"
2. 选择 "Static Site"
3. 连接 GitHub 仓库或直接上传文件

#### 4. 配置项目
- **Name**: `未命名星球` 或 `unnamed-planet`
- **Build Command**: 留空（静态网站不需要构建）
- **Publish Directory**: `/` 或留空
- **Root Directory**: 留空

#### 5. 部署设置
- **Branch**: `main` 或 `master`
- **Auto-Deploy**: 开启（如果使用GitHub）

### 方法二：通过 GitHub 部署（推荐）

#### 1. 创建 GitHub 仓库
```bash
# 在 webstack 文件夹中执行
git init
git add .
git commit -m "Initial commit: 未命名星球网站"
git branch -M main
git remote add origin https://github.com/你的用户名/unnamed-planet.git
git push -u origin main
```

#### 2. 在 Render 中连接 GitHub
1. 选择 "New Static Site"
2. 选择 "Build and deploy from a Git repository"
3. 连接你的 GitHub 账户
4. 选择刚创建的仓库

#### 3. 配置部署
- **Name**: `unnamed-planet`
- **Branch**: `main`
- **Root Directory**: 留空
- **Build Command**: 留空
- **Publish Directory**: 留空

### 方法三：直接拖拽部署

#### 1. 压缩文件
将 `webstack` 文件夹压缩为 ZIP 文件

#### 2. 上传到 Render
1. 选择 "New Static Site"
2. 选择 "Deploy without connecting to a Git repository"
3. 上传 ZIP 文件
4. 配置项目名称和设置

## 📁 文件结构确认

确保以下文件存在：
```
webstack/
├── crypto-demo.html          # 主页面
├── style.css                 # 主样式文件
├── css/
│   └── crypto-theme.css      # 主题样式
├── js/
│   └── main.js              # JavaScript文件
├── images/
│   └── binance.png          # 图片文件
└── README.md                # 说明文件
```

## ⚙️ 部署后配置

### 1. 自定义域名（可选）
- 在 Render 项目设置中添加自定义域名
- 配置 DNS 记录指向 Render

### 2. 环境变量（如果需要）
- 在项目设置中添加环境变量
- 目前项目不需要特殊环境变量

### 3. 自动部署
- 如果使用 GitHub，每次推送代码会自动部署
- 如果直接上传，需要手动重新部署

## 🔧 常见问题解决

### 1. 页面无法访问
- 检查文件路径是否正确
- 确保 `crypto-demo.html` 是主页面
- 检查 CSS 和 JS 文件路径

### 2. 样式不显示
- 检查 `style.css` 文件是否存在
- 确认文件路径正确
- 清除浏览器缓存

### 3. 视频无法播放
- 检查 YouTube 链接是否正确
- 确认网络连接正常
- 检查浏览器是否阻止自动播放

## 📱 测试部署

部署完成后，访问你的 Render URL：
- 格式：`https://你的项目名.onrender.com`
- 检查所有功能是否正常
- 测试在不同设备上的显示效果

## 🎉 完成！

部署成功后，你的未命名星球网站就可以通过互联网访问了！

### 后续维护
- 修改代码后重新部署
- 定期检查网站运行状态
- 根据需要更新内容

---

**注意**: 如果使用免费计划，网站可能会在无访问时进入休眠状态，首次访问可能需要几秒钟唤醒。
