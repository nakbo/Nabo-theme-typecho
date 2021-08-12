<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * friends
 * 朋友
 * @package custom
 *
 */
if (isset($this->options->plugins['activated']['Links'])) {
    Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = function ($content, $thiz) {
        return '<div class="friend-links">' .
            Links_Plugin::output_str('
<a href="{url}" class="friend" target="_blank" rel="noopener">
   <div class="card">
        <img src="{image}" alt="{name}" />
        <div class="master">
           <div class="name">{name}</div>
           <div class="link">{url}</div>
      </div>
   </div>
</a>
') . '<div class="clear"></div></div>' . $content;
    };
}
$this->need('post.php');
