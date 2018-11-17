<?php
/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @copyright  Copyright (c) 2014 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */

$installer = $this;
$installer->run("
INSERT INTO `{$this->getTable('seosuite_template')}` ( `template_code`, `template_name`, `comment`, `status`) VALUES
    ('product_gallery',
    'Product Image Alt and Title Values',
    '<p>\r\n<b>Earlier input data for product image labels will be rewriting.</b>\r\n<p>
     <b>Template variables</b>\r\n<p>[attribute] — e.g. [name], [price], [manufacturer], [color] — will be replaced with the respective product attribute value or removed if value is not available\r\n<p>[attribute1|attribute2|...] — e.g. [manufacturer|brand] — if the first attribute value is not available for the product the second will be used and so on untill it finds a value\r\n<p>[prefix {attribute} suffix] or\r\n<p>[prefix {attribute1|attribute2|...} suffix] — e.g. [({color} color)] — if an attribute value is available it will be prepended with prefix and appended with suffix, either prefix or suffix can be used alone\r\n
     <p><b>Examples</b>\r\n<p>[name][ - color is {color}] will be transformed (if attribute <i>color</i> exist) into\r\n<p>BlackBerry 8100 Pearl - color is Silver.',
    0);
");
$installer->endSetup();