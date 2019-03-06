<?php

/** @var callable $c The value retrieval function. */
/** @var callable $t The i18n function. */

$shortcodes = $c('shortcodes');
$total = $c('total');
$count = $c('count');
$strings = $c('strings');
$nonce = $c('nonce');
$trash_url_template = $c('trash_url_template');
$summary = $t('Showing %1$d of %2$d records', [$count, $total]);
?>

<div class="list">
    <div class="list-head">
        <div class="list-summary">
            <?= esc_html($summary) ?>
        </div>
    </div>
    <div class="list-body">
        <table>
            <thead>
                <tr>
                    <th class="shortcode-shortcode"><?= esc_html($t('Shortcode')) ?></th>
                    <th class="shortcode-template"><?= esc_html($t('Template')) ?></th>
                    <th class="shortcode-actions"><?= esc_html($t('Actions')) ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($shortcodes as $shortcode): ?>
                <tr>
                    <td class="shortcode-shortcode"><?= esc_html(sprintf('[%1$s]', $shortcode->post_name)) ?></td>
                    <td class="shortcode-template"><?= esc_html($shortcode->post_content) ?></td>
                    <td class="shortcode-actions">
                        <a href="<?= esc_attr(vsprintf($trash_url_template, [$nonce, $shortcode->ID])) ?>" class="action action-trash"><?= esc_html($t('Trash', [], 'The trash action')) ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="list-foot">
        <div class="list-summary">
            <?= esc_html($summary) ?>
        </div>
    </div>
</div>
