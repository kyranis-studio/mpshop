<?php
/**
 * 2007-2020 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2021 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
abstract class Controller extends ControllerCore
{
    /*
    * module: ets_superspeed
    * date: 2021-12-30 10:00:04
    * version: 1.5.2
    */
    protected function smartyOutputContent($content)
    {
        if (version_compare(_PS_VERSION_, '1.7.0', '<')) {
            ob_start();
            parent::smartyOutputContent($content);
            $html = ob_get_contents();
            ob_clean();
            Hook::exec('actionOutputHTMLBefore',  array('html' => &$html));
	        echo $html;
        } else
            return parent::smartyOutputContent($content);
    }
}