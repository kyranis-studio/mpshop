<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'prestashop.adapter.cms_page.query_handler.get_cms_page_category_name_for_listing' shared service.

return $this->services['prestashop.adapter.cms_page.query_handler.get_cms_page_category_name_for_listing'] = new \PrestaShop\PrestaShop\Adapter\CMS\PageCategory\QueryHandler\GetCmsPageCategoryNameForListingHandler(${($_ = isset($this->services['prestashop.adapter.legacy.context']) ? $this->services['prestashop.adapter.legacy.context'] : $this->getPrestashop_Adapter_Legacy_ContextService()) && false ?: '_'}->getContext()->language->id, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())) && false ?: '_'});