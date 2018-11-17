# Lyonscg_HasOffers

    /**
     * Add support for HasOffers integration
     *
     * @category  Lyons
     * @package   Lyonscg_HasOffers
     * @author    Logan Montgomery <lmontgomery@lyonscg.com>
     * @copyright Copyright (c) 2015 Lyons Consulting Group (www.lyonscg.com)
     */
 
## Description

Uses a table `lyonscg_hasoffers_order` to link HasOffers data with orders.  The data is set by an observer
watching **controller_action_predispatch** and setting a cookie called *hasoffers* that expires after 30 days.

The observer also watches **sales_order_place_after** and creates the lyonscg_hasoffers_order entries if the
cookie is present.  The cookie is then deleted.

Modifications were necessary for Lyonscg_Sales in order to add new data to the order api.

## Database Changes

The setup script creates a new database table, **lyonscg_hasoffers_order** but no other changes are made.
