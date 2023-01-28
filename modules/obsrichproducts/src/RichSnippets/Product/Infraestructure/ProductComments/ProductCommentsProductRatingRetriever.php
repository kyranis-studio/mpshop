<?php
/**
 * 2011-2021 OBSOLUTIONS WD S.L. All Rights Reserved.
 *
 * NOTICE:  All information contained herein is, and remains
 * the property of OBSOLUTIONS WD S.L. and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to OBSOLUTIONS WD S.L.
 * and its suppliers and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from OBSOLUTIONS WD S.L.
 *
 *  @author    OBSOLUTIONS WD S.L. <http://addons.prestashop.com/en/65_obs-solutions>
 *  @copyright 2011-2021 OBSOLUTIONS WD S.L.
 *  @license   OBSOLUTIONS WD S.L. All Rights Reserved
 *  International Registered Trademark & Property of OBSOLUTIONS WD S.L.
 */

namespace OBSolutions\RichSnippets\Product\Infraestructure\ProductComments;

use OBSolutions\RichSnippets\Product\Application\ProductRatingRetrieverInterface;
use OBSolutions\RichSnippets\Product\Domain\ProductInterface;
use OBSolutions\RichSnippets\Product\Domain\ProductRating;
use ProductComment;
use ProductComments;

class ProductCommentsProductRatingRetriever implements ProductRatingRetrieverInterface
{
    /**
     * @return bool
     */
    public static function enabled()
    {
        if (!class_exists('ProductComments')) {
            return false;
        }
        if (!class_exists('ProductComment')) {
            return false;
        }

        return is_callable('ProductComment', 'getCommentNumber');
    }

    /**
     * @param int $productId
     *
     * @return ProductRating
     */
    public function getProductRating(ProductInterface $product)
    {
        if (class_exists('ProductComments')) {
            $p = new ProductComments();
            if (method_exists(new ProductComments(), 'hookProductTab')) {
                $p->hookProductTab(array());   //we do not want the result, just want to force include of class ProductComment
            }
        }

        $ratingCount = (int) (ProductComment::getCommentNumber($product->getId()));
        $average = ProductComment::getAverageGrade($product->getId());

        return new ProductRating($ratingCount, round($average['grade']));
    }
}
