<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'PrestaShop\Module\PsEventbus\Decorator\CustomPriceDecorator' shared service.

return $this->services['PrestaShop\\Module\\PsEventbus\\Decorator\\CustomPriceDecorator'] = new \PrestaShop\Module\PsEventbus\Decorator\CustomPriceDecorator(${($_ = isset($this->services['ps_eventbus.context']) ? $this->services['ps_eventbus.context'] : $this->load('getPsEventbus_ContextService.php')) && false ?: '_'}, ${($_ = isset($this->services['PrestaShop\\Module\\PsEventbus\\Service\\SpecificPriceService']) ? $this->services['PrestaShop\\Module\\PsEventbus\\Service\\SpecificPriceService'] : ($this->services['PrestaShop\\Module\\PsEventbus\\Service\\SpecificPriceService'] = new \PrestaShop\Module\PsEventbus\Service\SpecificPriceService())) && false ?: '_'});
