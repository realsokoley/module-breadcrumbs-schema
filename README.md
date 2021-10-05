# Magento 2 Module Sokoley

## Overview

Extention allows to add schema.org script for breadcrumbs at product page
For this purpucies was realized method `getCrumbs` in `ViewModel\Breadcrumbs` class, that gets an array with all titles and breadcrumbs links.

## How to use

`app/design/frontend/VENDOR/THEME/Magento_Catalog/templates/product/breadcrumbs.phtml`

`<?php
/** @var \Magento\Theme\Block\Html\Breadcrumbs $block */
/** @var \Magento\Catalog\ViewModel\Product\Breadcrumbs $viewModel */
/** @var \Sokoley\BreadcrumbsSchema\ViewModel\Breadcrumbs $viewModelSchema */
/** @var array $crumbs */
$viewModel = $block->getData('viewModel');
$viewModelSchema = $block->getData('viewModelSchema');
$crumbs = $viewModelSchema->getCrumbs();
?>
<div class="breadcrumbs"></div>
<script type="text/x-magento-init">
        {
            ".breadcrumbs": <?= $viewModel->getJsonConfigurationHtmlEscaped() ?>
        }
</script>
<?php if ($crumbs && is_array($crumbs)) : ?>
<script type="application/ld+json">{
        "@context":"https://schema.org",
        "@type":"BreadcrumbList",
        "itemListElement":[
            <?php $i = 0; foreach ($crumbs as $crumbName => $crumbInfo) : ?>
            {
                "@type":"ListItem",
                "position":"<?= ++$i ?>",
                "name":"<?= $block->escapeHtml($crumbInfo['label']) ?>",
                "item":"<?= $crumbInfo['link'] ? $block->escapeUrl($crumbInfo['link']) : $block->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]) ?>"
            }
            <?= ($i < count($crumbs)) ? ',' : '' ?>
            <?php endforeach; ?>
        ]
    }
</script>
<?php endif; ?>`