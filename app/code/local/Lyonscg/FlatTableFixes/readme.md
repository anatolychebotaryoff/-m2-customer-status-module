# Lyonscg_FlatTableFixes
    /*
     * @category    Lyonscg
     * @package     Lyonscg_FlatTableFixes
     * @author      Logan Montgomery (lmontgomery@lyonscg.com)
     * @copyright   2015 Lyonscg
     */

This module was created to resolve Redmine 371871.  Because there were too many VARCHAR(255) attributes the
row size for the product flat tables was hitting 65,536 bytes, which is the max size.

Version 0.1.0 of this module converts the product attributes *instructions_step_x* into TEXT from VARCHAR(255)
to alleviate this issue.

If this pops up again, then we may need to look into forcing the flat table indexer to change the VARCHAR(255)
into VARCHAR(32) for some attributes.  This will require overrides or observers most likely, and is
a somewhat hacky approach.
