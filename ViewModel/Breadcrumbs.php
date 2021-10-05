<?php

/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley_BreadcrumbsSchema
 */
namespace Sokoley\BreadcrumbsSchema\ViewModel;

use Magento\Catalog\Helper\Data as CatalogData;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

class Breadcrumbs implements ArgumentInterface
{
    /**
     * @var CatalogData
     */
    private $catalogData;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var array
     */
    private $crumbs = [];

    public function __construct(
        CatalogData $catalogData,
        StoreManagerInterface $storeManager
    ) {
        $this->catalogData = $catalogData;
        $this->storeManager = $storeManager;
    }

    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return array
     */
    public function getCrumbs()
    {
        if (!empty($this->crumbs)) {
            return $this->crumbs;
        }

        $this->crumbs[] = [
            'label' => __('Home'),
            'link' => $this->storeManager->getStore()->getBaseUrl(),
        ];
        $path = $this->catalogData->getBreadcrumbPath();
        foreach ($path as $name => $breadcrumb) {
            if ($name == 'product') {
                $this->crumbs[] = [
                    'label' => $breadcrumb['label'],
                    'link' => null,
                ];
                continue;
            }
            $this->crumbs[] = $breadcrumb;
        }

        return $this->crumbs;
    }
}
