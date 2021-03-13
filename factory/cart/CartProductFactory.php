<?php
declare(strict_types=1);


namespace app\modules\cart\factory\cart;


use app\helpers\MathHelper;
use app\models\entities\CartItemEntity;
use app\modules\cart\src\cart\CartProduct;
use app\modules\cart\src\cart\product\CartProductImage;
use app\modules\cart\src\cart\product\CartProductOption;

class CartProductFactory
{

    /**
     * @param CartItemEntity $cartItemEntity
     * @return CartProduct
     */
    public function create(CartItemEntity $cartItemEntity): CartProduct
    {
        $productSkuEntity = $cartItemEntity->getSku();

        $cartProductImage = null;

        if ($productSkuEntity->getThumbnail()) {
            $cartProductImage = new CartProductImage(
                $productSkuEntity->getThumbnail()->getUrl(),
                $productSkuEntity->getThumbnail()->getAlt(),
            );
        }

        $cartProductOptionList = [];

        if ($productSkuEntity->getOptionsSku()) {
            foreach ($productSkuEntity->getOptionsSku() as $optionEntity) {
                $cartProductOptionList[] = new CartProductOption($optionEntity);
            }
        }

        return new CartProduct(
            $productSkuEntity->getId(),
            $productSkuEntity->getProduct()->getName(),
            $productSkuEntity->getProduct()->getUrl(),
            $productSkuEntity->getProduct()->isDigital(),
            $productSkuEntity->getVendorCode(),
            MathHelper::multiplyFloatBy100Int($productSkuEntity->getPriceOrPriceWithDiscount()),
            $productSkuEntity->getIsInPromo(),
            $cartItemEntity->getQuantity(),
            $cartItemEntity->getSku()->getAmount(),
            $cartItemEntity->getSku()->isUnlimited(),
            $productSkuEntity->getProduct()->getCategoriesIDs(),
            $productSkuEntity->getProductId(),
            $productSkuEntity->getProduct()->getPaymentSubjectId(),
            $cartProductImage,
            $cartProductOptionList,
        );
    }
}
