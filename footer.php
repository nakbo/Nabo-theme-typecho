<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
<script type="text/javascript">window.function.execute('image', 'targetAll');</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/katex@0.10.0/dist/katex.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/katex@0.10.0/dist/katex.min.css"/>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/katex@0.10.0/dist/contrib/auto-render.min.js"></script>
<script type="text/javascript">window.function.katex();</script>

<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/OwO.min.css'); ?>">
<script src="<?php $this->options->themeUrl('assets/OwO.js'); ?>"></script>
<script>window.function.OwO();</script>

<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.loli.net/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>
<script>window.function.highlight();</script>

<?php $this->footer(); ?>

<script src="https://cdnjs.loli.net/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
<script src="https://cdnjs.loli.net/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
<script>window.function.footer()</script>

</body>
</html>
