<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_Banners
 * @copyright
 * @author
 */
class USWF_Banners_Helper_Data extends Mage_Catalog_Helper_Data
{
    const CONFIG_PATH = 'uswf_banners/';

    /**
     * Returns PDP banner html snippet
     *
     * @param $product
     * @return string
     */
    public function getPDPBanner($product) {
        if (
            $product->getPdpBanner() && ($config = Mage::getStoreConfig(self::CONFIG_PATH . $product->getPdpBanner()))
        ) {
            $image = !empty($config['image']) ? Mage::getBaseUrl('media') . 'banners/' . $config['image'] : '';
            $horizontal = !empty($config['hor']) ? $config['hor'] : 'left';
            $horPos = !empty($config['hor_pos']) ? $config['hor_pos'] : '0';
            $vertical = !empty($config['ver']) ? $config['ver'] : 'bottom';
            $verPos = !empty($config['ver_pos']) ? $config['ver_pos'] : '0';
            if ($image) {
                return "<img style='position:absolute;z-index:999;width:auto !important;" .
                    "{$horizontal}:{$horPos}px;{$vertical}:{$verPos}px;' src='{$image}' alt=''>";
            }
        }
        return '';
    }

    /**
     * Sets banner to config section
     *
     * @param Varien_Simplexml_Element $section
     * @param array $banner
     * @param string $path
     * @param int $sortOrder
     * @return void
     */
    public function setBannerConfig($section, $banner, $path, $sortOrder) {
        $pathParts = explode('/', $path);
        $hashName = (is_array($pathParts) && count($pathParts) == 2) ? end($pathParts) : null;
        $section->setNode($path, null);
        $root = $section->descend($path);
        !$root->getAttribute('translate') && $root->addAttribute('translate', 'label');
        !$root->getAttribute('module') && $root->addAttribute('module', 'uswf_banners');
        $section->setNode($path . '/label', !empty($banner['banner_name']) && $hashName ?
            $banner['banner_name'] . '<a style="color:orange;background:none;" onclick="confirmSetLocation(\'' .
            $this->__('Are You sure that You want to delete this banner ?') . '\',\'' .
                $this->_getUrl('uswf_banners/index/delete', array('_query' => array('banner_hash' => $hashName))) .
                '\')" href="javascript:void();">' . $this->__('Delete this banner') . '</a>' :
            $this->__('Enter data for creating new banner and click "Save Config"')
        );
        $section->setNode($path . '/frontend_type', 'text');
        $section->setNode($path . '/sort_order', $sortOrder);
        $section->setNode($path . '/show_in_default', 1);
        $section->setNode($path . '/show_in_website', 0);
        $section->setNode($path . '/show_in_store', 0);
        $section->setNode($path . '/frontend_model', 'adminhtml/system_config_form_fieldset');

        $section->setNode($path . '/fields/banner_name/label', 'Banner Name');
        $section->setNode($path . '/fields/banner_name/comment', 'Please set name for this banner');
        $section->setNode($path . '/fields/banner_name/frontend_type', 'text');
        $section->setNode($path . '/fields/banner_name/sort_order', '1');
        $section->setNode($path . '/fields/banner_name/show_in_default', '1');
        $section->setNode($path . '/fields/banner_name/show_in_website', '0');
        $section->setNode($path . '/fields/banner_name/show_in_store', '0');

        $section->setNode($path . '/fields/image/label', 'Image');
        $section->setNode($path . '/fields/image/comment', 'Please set image for banner');
        $section->setNode($path . '/fields/image/frontend_type', 'file');
        $section->setNode($path . '/fields/image/backend_model', 'adminhtml/system_config_backend_file');
        $section->setNode($path . '/fields/image/upload_dir', 'banners');
        $uploadDir = $section->descend($path . '/fields/image/upload_dir');
        !$uploadDir->getAttribute('config') && $uploadDir->addAttribute('config', 'system/filesystem/media');
        !$uploadDir->getAttribute('scope_info') && $uploadDir->addAttribute('scope_info', '1');
        $section->setNode($path . '/fields/image/base_url', 'banners');
        $baseUrl = $section->descend($path . '/fields/image/base_url');
        !$baseUrl->getAttribute('type') && $baseUrl->addAttribute('type', 'media');
        !$baseUrl->getAttribute('scope_info') && $baseUrl->addAttribute('scope_info', '1');
        $section->setNode($path . '/fields/image/sort_order', '2');
        $section->setNode($path . '/fields/image/show_in_default', '1');
        $section->setNode($path . '/fields/image/show_in_website', '0');
        $section->setNode($path . '/fields/image/show_in_store', '0');

        $section->setNode($path . '/fields/hor/label', 'Stick To');
        $section->setNode($path . '/fields/hor/frontend_type', 'select');
        $section->setNode($path . '/fields/hor/source_model', 'uswf_banners/source_position_horizontal');
        $section->setNode($path . '/fields/hor/sort_order', '3');
        $section->setNode($path . '/fields/hor/show_in_default', '1');
        $section->setNode($path . '/fields/hor/show_in_website', '0');
        $section->setNode($path . '/fields/hor/show_in_store', '0');

        $section->setNode($path . '/fields/hor_pos/label', 'Horizontal Position');
        $section->setNode($path . '/fields/hor_pos/tooltip', 'px');
        $section->setNode($path . '/fields/hor_pos/frontend_type', 'text');
        $section->setNode($path . '/fields/hor_pos/sort_order', '4');
        $section->setNode($path . '/fields/hor_pos/show_in_default', '1');
        $section->setNode($path . '/fields/hor_pos/show_in_website', '0');
        $section->setNode($path . '/fields/hor_pos/show_in_store', '0');

        $section->setNode($path . '/fields/ver/label', 'Stick To');
        $section->setNode($path . '/fields/ver/frontend_type', 'select');
        $section->setNode($path . '/fields/ver/source_model', 'uswf_banners/source_position_vertical');
        $section->setNode($path . '/fields/ver/sort_order', '5');
        $section->setNode($path . '/fields/ver/show_in_default', '1');
        $section->setNode($path . '/fields/ver/show_in_website', '0');
        $section->setNode($path . '/fields/ver/show_in_store', '0');

        $section->setNode($path . '/fields/ver_pos/label', 'Vertical Position');
        $section->setNode($path . '/fields/ver_pos/tooltip', 'px');
        $section->setNode($path . '/fields/ver_pos/frontend_type', 'text');
        $section->setNode($path . '/fields/ver_pos/sort_order', '6');
        $section->setNode($path . '/fields/ver_pos/show_in_default', '1');
        $section->setNode($path . '/fields/ver_pos/show_in_website', '0');
        $section->setNode($path . '/fields/ver_pos/show_in_store', '0');

        return;
    }
}