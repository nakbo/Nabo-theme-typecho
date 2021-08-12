<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * dynamics
 * 动态
 * @package custom
 *
 */
$this->need('header.php');
$this->need('navigator.php'); ?>

<div id="nabo" class="middle">
    <div class="header">
        <div class="toolbar">
            <div class="toolbar-left"><?php $this->title() ?></div>
        </div>
    </div>

    <div class="article home">
        <?php $dyn = Dynamics_Plugin::get();
        while ($dyn->dynamics->next()): ?>
            <article class="dynamic" itemscope itemtype="http://schema.org/BlogPosting">
                <div class="twitter">
                    <div class="created">
                        <time datetime="<?php $dyn->dynamic->created('c'); ?>"
                              itemprop="datePublished"><?php $dyn->dynamic->created(); ?></time>
                    </div>
                    <div class="avatar">
                        <img src="<?php $dyn->dynamic->avatar(100, 'G', 'mm'); ?>" alt="author">
                    </div>
                    <div class="display">
                        <div class="name"><?php $dyn->dynamic->screenName(); ?></div>
                    </div>
                    <div class="markdown-body describe">
                        <?= lazyload_filter($dyn->dynamic->content); ?>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>

    <div class="navigation">
        <?php $dyn->dynamics->navigator('&laquo;', '&raquo;',
            3, '...',
            'wrapClass=page-navigator'
        ); ?>
    </div>

    <?php $this->need('comments.php'); ?>
</div>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>

