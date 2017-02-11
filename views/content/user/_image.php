<?php
/**
 * Блок с изображением.
 *
 * @var $values app\core\ContainerHSC
 */

use app\helpers\Html;
use app\core\Config;
use app\core\Container;
use app\core\ContainerHSC;
use app\models\User;

$thumbSize = Config::inst()->user['image']['max_thumb_size'];

$image = new Container();

if ($values->c('image_thumb') == 'exists')
{
    $urlId = urlencode($values->c('id'));

    $image->src = "/user/info?action=image&uid=$urlId";

    $thumbImage = new Container();
    $thumbImage->src = $image->src . '&thumb=1';
    $thumbImage->alt = _('User image');
}
else
{
    $thumbImage = User::getNoImageParams();
    $image->src = $thumbImage->src;
}

?>
<div class="image_container_wrapper">
    <div class="image_container">
        <a href="<?php Html::h($image->src) ?>" target="_blank"
           title="<?php Html::_h('Click to see fill-size image') ?>">

            <img
                style="max-width: <?php echo $thumbSize['width'] ?>px; max-height: <?php echo $thumbSize['height'] ?>px"
                src="<?php Html::h($thumbImage->src) ?>"
                alt="<?php Html::h($thumbImage->alt) ?>">
        </a>
    </div>
</div>