/**
 * Lyonscg_RewriteParams
 *
 * @category    Lyonscg
 * @package     Lyonscg_RewriteParams
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (http://www.lyonscg.com)
 * @author      Todd Wolaver (twolaver@lyonscg.com)
 */

Default functionality on a redirected (301 or 302) URL rewrite is to only direct
to the specified target URL, ignoring any _GET parameters.

The Lyonscg RewriteParams module allows either ALL or selected _GET parameters
to be passed through on a redirected URL rewrite.

Configuration is via System -> Configuration -> Web -> Search Engine Optimization
- Pass-Through All Params for Redirects (yes/no)
- Allowed Params for Redirects (CSV of allowed _GET params)