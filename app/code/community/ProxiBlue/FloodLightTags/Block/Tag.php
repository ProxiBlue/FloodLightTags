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
 *    If not, see <http://www.gnu.org/licenses/>.
 *
 *    ProxiBlue is in no way affiliated to DoubleCLick.
 *    This module is not an officially endorsed module for magento by DoubleCLick
 * */
?>
<?php

/**
 * Double Click Checkout Block
 *
 * @category  ProxiBlue
 * @package   ProxiBlue_FloodLightTags
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2014 Lucas van Staden / ProxiBlue
 *
 */
class ProxiBlue_FloodLightTags_Block_Tag extends Mage_Core_Block_Template
{

    const PRODUCTION_URL = 'fls.doubleclick.net';

    protected $_cat = null;
    protected $_type = null;

    public function _construct()
    {
        $this->setTemplate('floodlighttags/tag.phtml');
    }

    /**
     * The url (is there a testing site??)
     *
     * @return string
     */
    public function getProdUrl()
    {
        return self::PRODUCTION_URL;
    }

    /**
     * Get The account Id from Config
     * @return string
     */
    public function getEnabled()
    {
        return Mage::getStoreConfig('floodlighttags/options/enabled_' . $this->getEnabledCheck());
    }

    /**
     * Get The account Id from Config
     * @return string
     */
    public function getMerchantCode()
    {
        return $this->escapeHtml(Mage::getStoreConfig('floodlighttags/options/merchant'));
    }

    public function getType()
    {
        if (is_null($this->_type)) {
            return $this->getData('type');
        }
        return $this->_type;
    }

    public function getCat()
    {
        if (is_null($this->_cat)) {
            return $this->getData('cat');
        }
        return $this->_cat;
    }

    public function getUrlParams()
    {
        $data = $this->getClickTagVars();
        if(is_null($data)) {
            $data = array();
        }
        $params = array();
        if (is_array($data)) {
            if (!array_key_exists('ord', $data)) {
                $data['ord'] = rand(0, 10000000000000);
            }
            $params = http_build_query(
                array_merge(
                    array('src' => $this->getMerchantCode(),
                'type' => $this->getType(),
                'cat' => $this->getCat(),), $data)
            , '', ';');
        }
        return $params . '?';
    }

}
