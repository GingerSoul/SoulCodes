<?php

/** @var callable $c The value retrieval function. */
/** @var callable $t The i18n function. */

$shortcodes = $c('shortcodes');
$total = $c('total');
$count = $c('count');
$strings = $c('strings');
$nonce = $c('nonce');
$trash_url_template = $c('trash_url_template');
$add_url_template = $c('add_url_template');
$save_url_template = $c('save_url_template');
$params = $c('params');
$summary = $t('Showing %1$d of %2$d items', [$count, $total]);
?>

<div class="user-shortcode-list">
    <div class="user-shortcode-list__head">
        <div class="user-shortcode-list__actions">
            <a href="<?= esc_attr(vsprintf($add_url_template, [$nonce])) ?>"><?= $t('Add Shortcode') ?></a>
        </div>
        <div class="user-shortcode-list__summary">
            <?= esc_html($summary) ?>
        </div>
    </div>

    <div class="user-shortcode-list__body">
        <?php foreach ($shortcodes as $shortcode): ?>

            <?php $form_id = sprintf('shortcode_row_form_%1$s', $shortcode->ID) ?>
            <div class="user-shortcode-list__item">
                <div class="user-shortcode-box">
                    <div class="user-shortcode-box__code">
                        <input form="<?= $form_id ?>" type="text" name="<?= esc_attr($params['name']) ?>"
                               value="<?= esc_attr($shortcode->post_name) ?>" title="<?= esc_attr($t('Shortcode')) ?>"/>
                        <button class="button-copy-to-clipboard" title="<?= $t('Copy to Clipboard') ?>">Copy</button>
                    </div>
                    <div class="user-shortcode-box__template">
                        <textarea
                                form="<?= $form_id ?>" name="<?= esc_attr($params['template']) ?>"
                                title="<?= esc_attr($t('Template')) ?>"
                        ><?= esc_html($shortcode->post_content) ?></textarea>
                    </div>

                    <div class="user-shortcode-box__actions">
                        <form action="<?= esc_attr(vsprintf($save_url_template, [$nonce])) ?>" method="post" id="<?= $form_id ?>">
                            <input type="hidden" name="<?= esc_attr($params['id']) ?>" value="<?= esc_attr($shortcode->ID) ?>"/>
                            <a
                                    href="<?= esc_attr(vsprintf($trash_url_template, [$nonce, $shortcode->ID])) ?>"
                                    class="user-shortcode-box__action user-shortcode-box__action--trash">
                                <?= esc_html($t('Trash', [], 'The trash action')) ?>
                            </a>
                            <input class="user-shortcode-box__action user-shortcode-box__action--save" type="submit" value="<?= $t('Save') ?>"/>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="user-shortcode-list__foot">
        <div class="user-shortcode-list__summary">
            <?= esc_html($summary) ?>
        </div>
    </div>
</div>
