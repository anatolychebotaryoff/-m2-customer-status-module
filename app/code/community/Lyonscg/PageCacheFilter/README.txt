Lyonscg_PageCacheFilter
===================================================================================================
This module will allow specific GET query parameters to be excluded from the calculation of the
Enterprise page cache ID calculation for any given page.  It attempts to have little to no effect
on any other code that may be looking at the GET parameters.

The filters can be created via the admin panel under the System -> Full Page Cache Filter menu
entry.

The filters are stored in serialized form in the full page cache.  This is necessary to allow them
to be inspected on page loads that are completely from cache.  It's generally bad practice to be
making calls to the databae when loading something from full page cache.  It's also difficult as
the autoloader isn't running and the connection to the database hasn't been setup.  In the end
this is a necessity that also happens to be fairly efficient.  The cached values will be updated
whenever the filters are adjusted in the admin panel or any time full page cache is cleared.