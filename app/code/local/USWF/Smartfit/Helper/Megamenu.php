<?php
/**
 * Megamenu.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Helper_Megamenu extends Cmsmart_Megamenu_Helper_Data
{
    /**
     * Fix for Cmsmart_Megamenu
     * @return mixed
     */
    public function toOptionArray()
    {
        $children = $this->getCategory()->getChildren();
        $cchildren = !empty($children) ? explode(",", $children) : array();
        $count = count($cchildren);
        $data = array();

        if ($children) {
            for ($i = 1; $i <= $count; $i++) {
                $data['value'] = $i;
                $data['label'] = $i . ' Columns';
                $dat[] = $data;
            }
            return $dat;
        } else {
            return array();
        }
    }

    /**
     * Fix for Cmsmart_Megamenu
     * @return string
     */
    public function getShowthumbnail($id){
        $thumbnail = $this->Megamenu($id);
        return isset($thumbnail[0]['active_thumbail']) ? $thumbnail[0]['active_thumbail'] : '';
    }
}