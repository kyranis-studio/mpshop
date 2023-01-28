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
{extends file='page.tpl'}

{block name='page_header_container'}{/block}

{block name='left_column'}
  <div id="left-column" class="col-xs-12 col-sm-3">
    {widget name="ps_contactinfo" hook='displayLeftColumn'}
  </div>
{/block}

{block name='page_content'}

<ul>
	<li class="contact-title"><strong>HORAIRES DE TRAVAILLE :</strong></li>
	<li>Lundi à Vendredi de 9h à 14h et de 15h à 18h</li>
	<li>Samedi de 9h à 15h</li>
	<li class="contact-title"><strong>CONTACT</strong></li>
	<li>Adresse : 43, Rue de Marseille - Tunis</li>
	<li>Téléphone : (+216) 71 240 275</li>
	<li>Mobile / whatsapp : (+216) 23 746 196</li>
	<li>Email : <a href="mailto:commercial@mpshop.tn" style="color: #227ed1;">commercial@mpshop.tn</a></li>
	<li>Page Facebook : <a href="https://facebook.com/MPSHOPTUNISIE/" target="_blank" style="color: #227ed1;">facebook.com/MPSHOPTUNISIE/</a></li>
	<li>Page Instagram : <a href="https://www.instagram.com/mpshop.tn/" target="_blank" style="color: #227ed1;">instagram.com/mpshop.tn/</a></li>
</ul>
  {widget name="contactform"}
  <div>
	{hook h='displayContactForm'}
  </div>
</section>
{/block}
