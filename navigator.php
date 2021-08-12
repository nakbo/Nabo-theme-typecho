<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div class="navigator">
    <div class="logo">
        <img src="<?php $this->options->logoUrl(); ?>" alt="logo"/>
    </div>
    <div class="columns">
        <div class="page">
            <a class="column-link<?php if ($this->is('index')) : ?> active <?php endif; ?>"
               href="<?php $this->options->index(); ?>">
                <i class="fa fa-fw fa-home column-icon"></i>
                <span><?php _e('主页'); ?></span>
            </a>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while ($pages->next()) : ?>
                <a class="column-link<?php if ($this->is('page', $pages->slug)) : ?> active <?php endif; ?>"
                   href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>">
                    <i class="fa fa-fw <?= $pages->fields->fontawesome ?: 'fa-star'; ?> column-icon"></i>
                    <span><?php $pages->title(); ?></span>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</div>
