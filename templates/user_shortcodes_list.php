<?php

/** @var callable $c The value retrieval function. */
/** @var callable $t The i18n function. */

$shortcodes = $c('shortcodes');
$total = $c('total');
$count = $c('count');
$strings = $c('strings');
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
                </tr>
            </thead>
            <tbody>
            <?php foreach ($shortcodes as $shortcode): ?>
                <tr>
                    <td class="shortcode-shortcode"><?= esc_html(sprintf('[%1$s]', $shortcode->post_name)) ?></td>
                    <td class="shortcode-template"><?= esc_html($shortcode->post_content) ?></td>
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
