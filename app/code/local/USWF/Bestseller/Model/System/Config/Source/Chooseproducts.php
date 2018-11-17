<?php

class USWF_Bestseller_Model_System_Config_Source_Chooseproducts extends CapacityWebSolutions_Bestseller_Model_System_Config_Source_Chooseproducts {
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $array=array(
            array(
                'value'=>'1',
                'label'=> 'Auto'
            ),
            array(
                'value'=>'2',
                'label'=> 'Manually'
            ),
            array(
                'value'=>'3',
                'label'=> 'Both(Auto and Manually)'
            ),
            array(
                'value'=>'4',
                'label'=> 'Manually(Widget)'
            ),

        );
        return $array;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $options = array('1'=>'Auto','2'=>'Manually','3'=>'Both(Auto and Manually)','4'=>'Manually(Widget)');
        return $options;
    }
}