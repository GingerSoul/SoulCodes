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
$summary = $t('Showing %1$d of %2$d records', [$count, $total]);
?>

<div class="list">
    <div class="list-head">
        <div class="list-actions">
            <a href="<?= esc_attr(vsprintf($add_url_template, [$nonce])) ?>"><?= $t('Add Shortcode') ?></a>
        </div>
        <div class="list-summary">
            <?= esc_html($summary) ?>
        </div>
    </div>
    <div class="list-body">
	    
        <?php foreach ($shortcodes as $shortcode): ?>
     	   <?php $form_id = sprintf('shortcode_row_form_%1$s', $shortcode->ID) ?>
    	
	 	   <div class="shortcode-item">                
                
                <div class="shortcode-code">
                        
                        <input form="<?= $form_id ?>" type="text" name="<?= esc_attr($params['name']) ?>" value="<?= esc_attr($shortcode->post_name) ?>" title="<?= esc_attr($t('Shortcode')) ?>" />
                        
                        <button class="copy-shortcode">Copy</button>
	                
                </div>
                
                <div class="shortcode-temp">
                        
                        <textarea form="<?= $form_id ?>" name="<?= esc_attr($params['template']) ?>" title="<?= esc_attr($t('Template')) ?>"><?= esc_html($shortcode->post_content) ?></textarea>
	                
                </div>
                
                <div class="shortcode-act">
                        
                        <form action="<?= esc_attr(vsprintf($save_url_template, [$nonce])) ?>" method="post" id="<?= $form_id ?>">
                            <input type="hidden" name="<?= esc_attr($params['id']) ?>" value="<?= esc_attr($shortcode->ID) ?>" />
                            <a href="<?= esc_attr(vsprintf($trash_url_template, [$nonce, $shortcode->ID])) ?>" class="action action-trash"><?= esc_html($t('Trash', [], 'The trash action')) ?></a>
                            <input type="submit" value="<?= $t('Save') ?>" />
                        </form>
	                
                </div>

                
	 	   </div>
<!--
                
                <tr>
                    <td class="shortcode-shortcode">
                        &lsqb;
                        <input form="<?= $form_id ?>" type="text" name="<?= esc_attr($params['name']) ?>" value="<?= esc_attr($shortcode->post_name) ?>" title="<?= esc_attr($t('Shortcode')) ?>" />
                        &rsqb;
                    </td>
                    <td class="shortcode-template">
                        <textarea form="<?= $form_id ?>" name="<?= esc_attr($params['template']) ?>" title="<?= esc_attr($t('Template')) ?>"><?= esc_html($shortcode->post_content) ?></textarea>
                    </td>
                    <td class="shortcode-actions">
                        <form action="<?= esc_attr(vsprintf($save_url_template, [$nonce])) ?>" method="post" id="<?= $form_id ?>">
                            <input type="hidden" name="<?= esc_attr($params['id']) ?>" value="<?= esc_attr($shortcode->ID) ?>" />
                            <a href="<?= esc_attr(vsprintf($trash_url_template, [$nonce, $shortcode->ID])) ?>" class="action action-trash"><?= esc_html($t('Trash', [], 'The trash action')) ?></a>
                            <input type="submit" value="<?= $t('Save') ?>" />
                        </form>
                    </td>
                </tr>
-->

            <?php endforeach; ?>
	    	
	    	
    	</div>

<!--
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
                <?php $form_id = sprintf('shortcode_row_form_%1$s', $shortcode->ID) ?>
                <tr>
                    <td class="shortcode-shortcode">
                        &lsqb;
                        <input form="<?= $form_id ?>" type="text" name="<?= esc_attr($params['name']) ?>" value="<?= esc_attr($shortcode->post_name) ?>" title="<?= esc_attr($t('Shortcode')) ?>" />
                        &rsqb;
                    </td>
                    <td class="shortcode-template">
                        <textarea form="<?= $form_id ?>" name="<?= esc_attr($params['template']) ?>" title="<?= esc_attr($t('Template')) ?>"><?= esc_html($shortcode->post_content) ?></textarea>
                    </td>
                    <td class="shortcode-actions">
                        <form action="<?= esc_attr(vsprintf($save_url_template, [$nonce])) ?>" method="post" id="<?= $form_id ?>">
                            <input type="hidden" name="<?= esc_attr($params['id']) ?>" value="<?= esc_attr($shortcode->ID) ?>" />
                            <a href="<?= esc_attr(vsprintf($trash_url_template, [$nonce, $shortcode->ID])) ?>" class="action action-trash"><?= esc_html($t('Trash', [], 'The trash action')) ?></a>
                            <input type="submit" value="<?= $t('Save') ?>" />
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
-->
    
    
    
    <div class="list-foot">
        <div class="list-summary">
            <?= esc_html($summary) ?>
        </div>
    </div>
</div>
