Air filter module.
This module creates new pages with url "/AirFilterFinder" and "AirFilterFinder/result".
It does not require any preinstalling. All nessesary attributes and blocks are creating with install scripts.
Usage:
    -- On the module landing page we show two sections. First section consists of dropboxes, whose number and values
    depends on given in config attribute code. Values of those dropboxes are depth. After selecting depth we send it
    to the result page.
    Second area is only one dropbox. Its values are subcategories of the category whose id is set in store config.
    After selecting subcategory from dropbox we are redirected to those subcategory landing page.
    -- Result page takes depth as a parameter, if it is not set we are redirected to page 404. If we have depth, we
    build slider from products. Slider is kind a grid. Rows are categories, columns are mprs. So for each row and
    column product is taken separately. Please mind that we are taking only one product (first in collection).