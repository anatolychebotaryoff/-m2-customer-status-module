/**
 * Improved Cache Clearing/Warming
 *
 * @category    Lyonscg
 * @package     Lyonscg_ImprovedCache
 * @copyright   Copyright (c) 2014 Lyons Consulting Group (http://www.lyonscg.com)
 * @author      Nick Hughart (nhughart@lyonscg.com)
 */

When saving products and categories, there are no direct mechanisms in Magento to
clear out appropriate entries in the full page cache.  This module adds some extra
cleanup operations to try and ensure that saving a category or product, through
any means, will not require manually clearing all of FPC for no reason.

This module also blocks Magento from flushing all of full page cache when a product
is saved in Magento 1.12 and below.  Magento 1.13+ does not clear the full page
cache on product save, but will set the invalid flag.

When a product or category has it's cache cleared, an entry will be made in the
database table lyonscg_improvedcache_cache_item.  This will allow an external
cache warmer to go through the table and begin warming the pages.