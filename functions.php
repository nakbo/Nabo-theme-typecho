<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * @param $form
 */
function themeConfig($form)
{
    $uid = new Typecho_Widget_Helper_Form_Element_Text(
        'uid', NULL, Typecho_Cookie::get('__typecho_uid'),
        _t('主要博主'), _t('<strong>注意是正整数</strong>. 在这里填入一个主要博主的 uid (一般为1)')
    );
    $uid->input->setAttribute('class', 'mono w-35');
    $form->addInput($uid);

    $options = Helper::options();
    $themeUrl = dirname($options->themeUrl) . '/Nabo/';

    $faviconUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'faviconUrl', NULL, $themeUrl . 'image/logo.png',
        _t('Favicon'), _t('在这里填入一个图片 URL 地址, 标题前加上一个 LOGO')
    );
    $form->addInput($faviconUrl);

    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'logoUrl', NULL, $themeUrl . 'image/logo.png',
        _t('LOGO'), _t('在这里填入一个图片 URL 地址, 侧栏顶部加上一个 LOGO')
    );
    $form->addInput($logoUrl);

    $bannerUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'bannerUrl', NULL, $themeUrl . 'image/bg.jpg',
        _t('Banner'), _t('在这里填入一个图片 URL 地址, 用在用户背景图片')
    );
    $form->addInput($bannerUrl);

    $describe = new Typecho_Widget_Helper_Form_Element_Text(
        'describe', NULL, '正在创作一切未来',
        _t('博主描述'), _t('在这里填入签名, 描述博主')
    );
    $form->addInput($describe);

    $galleryValve = new Typecho_Widget_Helper_Form_Element_Text(
        'galleryValve', NULL, 2,
        _t('画廊阀门'), _t('<strong>注意是正整数</strong>. 在这里填入构建画廊的连续图片数目. 连续图片表示两个图片之间有且只有一个换行.')
    );
    $galleryValve->input->setAttribute('class', 'mono w-35');
    $form->addInput($galleryValve);

    $copyright = new Typecho_Widget_Helper_Form_Element_Text(
        'copyright', NULL, '南博网络科技工作室 版权所有',
        _t('版权信息'), _t('在这里填入版权信息, 用于侧栏显示')
    );
    $form->addInput($copyright);
}

/**
 * @param $html
 * @param int $limit
 * @return string
 */
function get_summary($html, $limit = 3)
{
    $content = '';
    if ($parts = preg_split("/(<\/\s*(?:p|q|h[0-9]|blockquote|ol|ul|pre')\s*>)/i",
        $html, $limit, PREG_SPLIT_DELIM_CAPTURE)) {
        for ($i = 0; $i < $limit; $i++) {
            $content .= $parts[$i];
        }
    }
    return $content;
}

/**
 * @param $email
 * @param int $size
 * @param null $rating
 * @param null $default
 * @return string
 */
function get_gravatar($email, $size = 100, $rating = 'G', $default = 'mm')
{
    $options = Helper::options();
    return Typecho_Common::gravatarUrl($email, $size,
        $rating ?: $options->commentsAvatarRating,
        $default ?: $options->avatarRandomString,
        true
    );
}

/**
 * @param $archive
 * @return int
 * @throws Typecho_Db_Exception
 */
function get_post_view($archive)
{
    if (empty($cid = $archive->cid)) {
        return 0;
    }

    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();

    $data = $db->fetchRow($db->select()
        ->from('table.contents')->where('cid = ?', $cid));
    if (!array_key_exists('views', $data)) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        return 0;
    }

    if ($archive->is('single')) {
        $data['views']++;
        $db->query('UPDATE `' . $prefix . 'contents` SET `views` = `views` + 1 WHERE `cid` = ' . $cid . ';');
    }
    return $data['views'];
}

/**
 * @param $archive
 * @return array
 * @throws Typecho_Db_Exception
 */
function get_post_comment($archive)
{
    $db = Typecho_Db::get();
    return $db->fetchAll($db->select()->from('table.comments')
        ->where("cid = ? AND status = 'approved' AND type = 'comment' AND parent = 0", $archive->cid)
        ->limit(3)->order('created', Typecho_Db::SORT_DESC)
    );
}

/**
 * @param $html
 * @return string|string[]|null
 */
function lazyload_filter($html)
{
    return preg_replace('/<img\s+src="([^"]+)"/is',
        '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="$1" class="lazyload"', $html
    );
}

/**
 * @param $requestUri
 * @return string
 */
function pjax_url_filter($requestUri)
{
    $parts = parse_url($requestUri);

    if (isset($parts['query'])) {
        parse_str($parts['query'], $args);

        if (isset($args['_pjax'])) {
            unset($args['_pjax']);
            $parts['query'] = $args ? http_build_query($args) : NULL;
            return Typecho_Common::buildUrl($parts);
        }
    }

    return $requestUri;
}