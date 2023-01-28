<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @PrestaShop/Admin/Common/Grid/Actions/Grid/link.html.twig */
class __TwigTemplate_614136a8389a19a41b9d913ac8195ff25c241ad5226bb90c0a347abe81b1ab88 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 25
        echo "
";
        // line 26
        $context["ps"] = $this->loadTemplate("@PrestaShop/Admin/macros.html.twig", "@PrestaShop/Admin/Common/Grid/Actions/Grid/link.html.twig", 26)->unwrap();
        // line 27
        if (($this->getAttribute($this->getAttribute(($context["action"] ?? null), "options", []), "route", []) == "admin_orders_viewtrash")) {
            // line 28
            echo "    <a href=\"";
            echo twig_escape_filter($this->env, ($context["ets_odm_link_order_viewtrash"] ?? null), "html", null, true);
            echo "\" class=\"dropdown-item\">
      ";
            // line 29
            if ( !twig_test_empty($this->getAttribute(($context["action"] ?? null), "icon", []))) {
                // line 30
                echo "        <i class=\"material-icons\">";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["action"] ?? null), "icon", []), "html", null, true);
                echo "</i>
      ";
            }
            // line 32
            echo "      ";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["action"] ?? null), "name", []), "html", null, true);
            echo "
    </a>
";
        } elseif (($this->getAttribute($this->getAttribute(        // line 34
($context["action"] ?? null), "options", []), "route", []) == "admin_customers_storage")) {
            // line 35
            echo "    <a class=\"dropdown-item arrange_customer_list\" href=\"";
            echo twig_escape_filter($this->env, ($context["link_customer_manager"] ?? null), "html", null, true);
            echo "\" target=\"_blank\">
        <i class=\"material-icons\">storage</i>
        ";
            // line 37
            echo twig_escape_filter($this->env, ($context["ets_tc_custom_column_text"] ?? null), "html", null, true);
            echo "
    </a>
";
        } else {
            // line 40
            echo "    ";
            $this->loadTemplate("PrestaShopBundle:Admin/Common/Grid/Actions/Grid:link.html.twig", "@PrestaShop/Admin/Common/Grid/Actions/Grid/link.html.twig", 40)->display($context);
        }
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Common/Grid/Actions/Grid/link.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 40,  64 => 37,  58 => 35,  56 => 34,  50 => 32,  44 => 30,  42 => 29,  37 => 28,  35 => 27,  33 => 26,  30 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@PrestaShop/Admin/Common/Grid/Actions/Grid/link.html.twig", "/home/mpshop/public_html/modules/ets_delete_order/views/PrestaShop/Admin/Common/Grid/Actions/Grid/link.html.twig");
    }
}
