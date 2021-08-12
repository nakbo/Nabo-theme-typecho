<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$this->need('navigator.php'); ?>

<div id="nabo" class="middle">
    <div class="header">
        <div class="toolbar">
            <div class="toolbar-left"><?php _e('页面没找到'); ?></div>
        </div>
    </div>
    <div class="error-page">
        <h2 class="post-title">404</h2>
        <p><?php _e('您想查看的页面已被转移或删除了'); ?></p>
    </div>
</div>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
