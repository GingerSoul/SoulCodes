<?php

/** @var callable $c The value retrieval function. */
/** @var callable $t The i18n function. */

$list = $c('list');
$heading = $c('heading');
?>

<h1><?= $t('SoulCodes') ?></h1>
<div class="soulcodes-shortcodes-list">
    <?php echo $list ?>
</div>
