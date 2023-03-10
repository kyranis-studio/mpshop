{**
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License 3.0 (AFL-3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/AFL-3.0
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2018 PrestaShop SA
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
* International Registered Trademark & Property of PrestaShop SA
*}

<div class="block_newsletter col-lg-8 col-md-12 col-sm-12">
    <div class="newsletter-title">
        <h2 id="block-newsletter-label" class="footer-block-title">
            <span>{l s='Soyez le' d='Shop.Theme.Global'} 
                <i>{l s='Premier' d='Shop.Theme.Global'}</i>
            </span>
        </h2>
    </div>
    <div class="footer-block-toggle-content">
        <p>{l s='Inscrivez-vous pour ne pas rater les nouveaux produits et les réductions de prix.' d='Shop.Theme.Global'}</p>
        <form action="{$urls.pages.index}#footer" method="post">
            <div class="col-xs-12 subscribe-block">
                <div class="input-wrapper">
                    <input
                        name="email"
                        type="text"
                        value="{$value}"
                        placeholder="{l s='Your email address' d='Shop.Forms.Labels'}"
                        aria-labelledby="block-newsletter-label"
                        >
                </div>
                <input
                    class="btn btn-primary float-xs-right hidden-xs-down"
                    name="submitNewsletter"
                    type="submit"
                    value="{l s='Send' d='Shop.Theme.Actions'}"
                    >
                <input
                    class="btn btn-primary float-xs-right hidden-sm-up"
                    name="submitNewsletter"
                    type="submit"
                    value="{l s='OK' d='Shop.Theme.Actions'}"
                    >
                <input type="hidden" name="action" value="0">
            </div>
            <div class="condition">
                {if $conditions}
                    <p>{$conditions}</p>
                {/if}
                {if $msg}
                    <p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">
                        {$msg}
                    </p>
                {/if}
                {if isset($id_module)}
                    {hook h='displayGDPRConsent' id_module=$id_module}
                {/if}
            </div>
        </form>
    </div>
</div>