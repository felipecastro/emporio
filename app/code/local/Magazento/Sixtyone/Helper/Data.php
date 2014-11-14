<?php
/**
 * 
 * @category  Magazento
 * @author    Ivan Proskuryakov http://www.magazento.com <volgodark@gmail.com>
 * @copyright Copyright (C)2013 Magazento
 *
 */

class Magazento_Sixtyone_Helper_Data extends Mage_Core_Helper_Abstract {

    function getPromoLabels($_product) {
        $today =  time();
        $_promo_sale='';
        $normalprice = Mage::getModel('catalog/product')->load($_product->getId())->getPrice(); 
        $specialprice = Mage::getModel('catalog/product')->load($_product->getId())->getSpecialPrice(); 
        $specialPriceFromDate = Mage::getModel('catalog/product')->load($_product->getId())->getSpecialFromDate();
        $specialPriceToDate = Mage::getModel('catalog/product')->load($_product->getId())->getSpecialToDate();

        if ($specialprice):
            if($today >= strtotime( $specialPriceFromDate) && $today <= strtotime($specialPriceToDate) 
                    || $today >= strtotime( $specialPriceFromDate) && is_null($specialPriceToDate)):
                    
                //$_promo_price = (($normalprice - $specialprice)*100)/normalprice;
                //$_promo_price = percentage($specialprice, $normalprice, 2);
                $_promo_price = round( ( ($specialprice / $normalprice) * 100 )-100, 0 );
                //$_promo_sale = '<div class="promo-sale">'.Mage::helper('core')->__('oferta').' '.$_promo_price.'</div>';
                $_promo_sale = '<div class="promo-sale">'.$_promo_price.'%</div>';
            endif;
        endif;     

        $_promo_new='';
        $newFromDate = $_product->getData('news_from_date');
        $newToDate = $_product->getData('news_to_date');
        if ($newFromDate):

            if($today >= strtotime( $newFromDate) && $today <= strtotime($newToDate) 
                    || $today >= strtotime( $newFromDate) && is_null($newToDate)):
                $_promo_new = '<div class="promo-new"> '.Mage::helper('core')->__('novo').'</div>';
            endif;
        endif;     
        
        $array = array('new'=>$_promo_new,'sale'=>$_promo_sale);
        return $array;
    }
    
    function percentage($val1, $val2, $precision) 
	{
		$division = $val1 / $val2;

		$res = $division * 100;

		$res = round($res, $precision);
	
		return $res;
}
}
