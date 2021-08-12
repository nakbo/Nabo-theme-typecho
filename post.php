<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$this->need('navigator.php'); ?>

<div id="nabo" class="middle">
    <div class="article post">
        <article class="<?php $this->type(); ?>" itemscope itemtype="http://schema.org/BlogPosting">
            <div class="twitter">
                <div class="created">
                    <time datetime="<?php $this->date('c'); ?>"
                          itemprop="datePublished"><?php $this->date(); ?></time>
                </div>
                <div class="avatar">
                    <?php $this->author->gravatar(100, 'G', 'mm'); ?>
                </div>
                <div class="display">
                    <div class="name"><?php $this->author->screenName(); ?></div>
                </div>
                <div class="title" itemprop="name headline"><?php $this->title() ?></div>
            </div>
            <div class="markdown-body content"><?= lazyload_filter($this->content); ?></div>

            <div class="other">
                <div class="tags"><span>#</span><?php $this->tags(', ', true, 'none'); ?></div>
                <div class="modified">
                    更新于: <?php echo date('Y年m月d日 H:i', $this->modified) ?>
                </div>
            </div>

            <div class="copyright">
                <p>作者: <?php $this->author(); ?></p>
                <p>链接: <a href="<?php $this->permalink(); ?>"><?php $this->permalink(); ?></a></p>
                <p>版权: 除特别声明,均采用
                    <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/">BY-NC-SA 4.0</a> 许可协议,转载请表明出处
                </p>
            </div>
            <div class="extras">
                <div class="extra">
                    <div class="view">
                        <i class="fa fa-thermometer-full"></i><span><?= get_post_view($this) ?></span>
                    </div>
                    <div class="commentNum">
                        <i class="fa fa-commenting-o"></i><span><?php $this->commentsNum(); ?></span>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <?php $this->need('comments.php'); ?>
</div>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
