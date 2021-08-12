<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div class="sidebar">
    <div class="columns">
        <div class="search">
            <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
                <label><input type="text" id="s" name="s" class="text" placeholder="<?php _e('搜索'); ?>"/></label>
                <button class="submit" type="submit">
                    <i role="img" class="fa fa-search"></i>
                </button>
            </form>
        </div>

        <div class="copyright">
            <p><?php $this->options->copyright(); ?></p>
        </div>
    </div>
</div>
