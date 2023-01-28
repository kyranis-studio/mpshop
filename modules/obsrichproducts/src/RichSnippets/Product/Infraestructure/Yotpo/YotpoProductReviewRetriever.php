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

namespace OBSolutions\RichSnippets\Product\Infraestructure\Yotpo;

use OBSolutions\RichSnippets\Product\Application\ProductReviewRetrieverInterface;
use OBSolutions\RichSnippets\Product\Domain\ProductInterface;
use OBSolutions\RichSnippets\Product\Domain\ProductReview;
use OBSolutions\RichSnippets\Product\Domain\ProductReviews;

class YotpoProductReviewRetriever implements ProductReviewRetrieverInterface
{
    public static function enabled()
    {
        return (bool) \Configuration::get('yotpo_app_key');
    }

    public function getProductReviews(ProductInterface $product)
    {
        $cacheKey = 'OBSRichProducts_ProductReview_'.$product->getId();
        if (!\Cache::isStored($cacheKey)) {
            $timeout = 3;
            $url = 'https://api.yotpo.com/v1/widget/'.\Configuration::get('yotpo_app_key').'/products/'.$product->getId().'/reviews.json';

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Added by PrestaShop
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Added by PrestaShop
            $result = curl_exec($ch);
            curl_close($ch);

            $payload = json_decode($result);

            $productReviews = array();

            if (isset($payload->status, $payload->status->code)
                 &&
                200 == $payload->status->code &&
                isset($payload->response, $payload->response->reviews)
            ) {
                foreach ($payload->response->reviews as $review) {
                    if ($review->deleted) {
                        continue;
                    }

                    $productReviews[] = new ProductReview(
                        $review->content,
                        $review->created_at,
                        $review->title,
                        $review->score,
                        isset($review->user, $review->user->display_name) ? $review->user->display_name : 'unknown'
                    );
                }
            }

            \Cache::store($cacheKey, new ProductReviews(...$productReviews));
        }

        return \Cache::retrieve($cacheKey);
    }
}
