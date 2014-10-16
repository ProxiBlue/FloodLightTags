<?php

/**
 *
 *    This Module is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This Module is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this module.
 *    If not, see <http://www.gnu.org/licenses/>.q
 *
 *    ProxiBlue is in no way affiliated to DoubleCLick.
 *    This module is not an officially endorsed module for magento by DoubleCLick
 * */
?>
<?php

/**
 * Double Click Checkout Block
 *
 * @category   ProxiBlue
 * @package    ProxiBlue_FloodLightTags
 * @author     Lucas van Staden (sales@proxiblue.com.au)
 * @copyright  2014 Lucas van Staden / ProxiBlue
 */
class ProxiBlue_FloodLightTags_Block_Checkout_Success extends ProxiBlue_FloodLightTags_Block_Tag
{

    protected $_cat = 'Place0';
    protected $_type = 'Check0';

    public function _construct()
    {
        $order = Mage::getSingleton("sales/order")->load(Mage::getSingleton("checkout/session")->getLastOrderId());
        if (is_object($order)) {
            $this->setData($order->getData());
            $this->setObjectItems($order->getAllVisibleItems());
        }
    }

    public function setClickTagVars()
    {
        $shippingAddressId = $this->getShippingAddressId();
        $address = Mage::getModel('sales/order_address')->load($shippingAddressId);
        $data = array(
            'qty' => 1,
            'cost' => $this->getGrandTotal(),
            'u1' => $address->getPostcode(),
            'u2' => urlencode($address->getRegion()),
            'u4' => floor($this->getTotalQtyOrdered()));
        $ucounter = 5;
        foreach($this->getObjectItems() as $_item) {
            $data['u'.$ucounter] = preg_replace('/[^[:print:]]/', '', $_item->getProduct()->getName());
            $ucounter++;
            if($ucounter == 15) {
                break;
            }
        }
        $data['ord'] = $this->getIncrementId();
        $this->setData('click_tag_vars',$data);
    }

}
