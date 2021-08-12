<?php
/**
 * 南博主题
 *
 * @package Nabo
 * @author 南博工作室
 * @version 1.0.0
 * @link https://github.com/krait-team/Nabo-theme-typecho
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$this->need('navigator.php'); ?>

<div id="nabo" class="middle">
    <div class="header">
        <div class="toolbar">
            <div class="toolbar-left"><?php if ($isIndex = $this->is('index')) {
                    _e('主页');
                } else {
                    $this->archiveTitle(array(
                        'category' => _t('分类 %s 下的文章'),
                        'search' => _t('包含关键字 %s 的文章'),
                        'tag' => _t('标签 %s 下的文章'),
                        'author' => _t('%s')
                    ), '', '');
                } ?></div>
            <div class="toolbar-right">
                <div class="menu" onclick="window.function.navigator()">
                    <i class="fa fa-align-right"></i>
                </div>
            </div>
        </div>
        <?php if ($isIndex || $this->is('author')):
            if ($isIndex) {
                $author = $this->widget('Widget_Users_Author', ['uid' => $this->options->uid]);
            } else {
                $author = $this->author;
            } ?>
            <?php if ($bannerUrl = $this->options->bannerUrl): ?>
            <div class="banner have" style="background-image: url(<?= $bannerUrl ?>);"></div>
        <?php else: ?>
            <div class="banner"></div>
        <?php endif; ?>
            <div class="author">
                <?php $author->gravatar(100, 'G', 'mm', 'avatar'); ?>
            </div>
            <div class="nick">
                <div class="name"><?php $author->screenName(); ?></div>
                <div class="uib"><?= '@' . $author->name . '/' . $_SERVER['SERVER_NAME']; ?></div>
            </div>
            <div class="extra">
                <div class="describe"><?php $this->options->describe(); ?></div>
            </div>
        <?php endif; ?>
    </div>

    <!--    <div class="nav">-->
    <!--        <a href="#stream" class="active"><span>推文</span></a>-->
    <!--        <a href="#article"><span>文章</span></a>-->
    <!--        <a href="#dynamic"><span>动态</span></a>-->
    <!--    </div>-->

    <div class="article home">
        <?php while ($this->next()): ?>
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
                        <div class="name"><?php $this->author(); ?></div>
                    </div>
                    <div class="markdown-body describe">
                        <?= lazyload_filter($this->type == 'dynamic' ?
                            $this->excerpt : get_summary($this->content)); ?>
                    </div>
                </div>
                <?php if ($this->type != 'dynamic'): ?>
                    <div class="related">
                        <a class="permalink" href="<?php $this->permalink() ?>">
                            <div class="left">
                                <i class="fa fa-link" aria-hidden="true"></i>
                            </div>
                            <div class="line"></div>
                            <div class="right">
                                <div class="title"><?php $this->title(); ?></div>
                            </div>
                        </a>
                        <div class="extra">
                            <div class="view">
                                <i class="fa fa-thermometer-full"></i><span><?= get_post_view($this) ?></span>
                            </div>
                            <div class="commentNum">
                                <i class="fa fa-commenting-o"></i><span><?php $this->commentsNum(); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($this->commentsNum) : ?>
                    <div class="comment-latest">
                        <?php foreach (get_post_comment($this) as $item): ?>
                            <div class="content">
                                <img src="<?= get_gravatar($item['mail']) ?>" alt="<?= $item['author'] ?>">
                                <span class="author"><?= $item['author'] ?></span>
                                <span class="text"><?= $item['text'] ?></span>
                                <span class="created"><?= date('n月j日', $item['created']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>

    <div class="navigation">
        <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    </div>
</div>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
