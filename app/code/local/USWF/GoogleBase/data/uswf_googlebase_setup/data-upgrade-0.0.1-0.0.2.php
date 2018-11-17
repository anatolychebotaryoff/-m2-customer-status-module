<?php
/**
 * data-upgrade-0.0.1-0.0.2.php
 *
 * @category    USWF
 * @package     USWF_GoogleBase
 * @copyright
 */

/* Install compare page predefined image files */

$installer = $this;
$installer->startSetup();

$configList = array(
    'dfs_en' => array(
        'qubit_universalvariable/QuBit_OpenTag_Settings/Gate_Script' => ";if(typeof ROIStorage === 'undefined') {
        (function(d,b,c,f){d[b]={};d[b].windowName=d.name;d[b].GoogleAnalyticsObject=c;d[b].q=[];d[c]=function(){d[b].q.push(arguments)};d[c].q=d[c].q||[];d[b].roiq=[];d[b].analyticsJsNotLoaded=true;d[c].q.push([function(){d[b].realGa=d[c];d[b].analyticsJsNotLoaded=false;d[c]=function(){if(typeof arguments[0]===\"function\"){d[b].realGa(arguments)}else{d[b].q.push(arguments)}};d[b].roiq.push=function(){d[b].realGa.apply(d,arguments)};for(f=0;f<d[b].roiq.length;f+=1){d[b].realGa.call(d,d[b].roiq[f])}}])})(window,\"ROIStorage\",\"ga\");
        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://539463a32bae86768ad2-16a09397621f41d4b19be7ac43a69919.ssl.cf2.rackcdn.com/gate.js' : 'http://1c689c4f75cf81214563-16a09397621f41d4b19be7ac43a69919.r57.cf2.rackcdn.com/gate.js');
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
        }",
        'qubit_universalvariable/QuBit_OpenTag_Settings/Gate_Enabled' => 1
    ),
    'ff_en' => array(
        'qubit_universalvariable/QuBit_OpenTag_Settings/Gate_Script' => ";if(typeof ROIStorage === 'undefined') {
        (function(d,b,c,f){d[b]={};d[b].windowName=d.name;d[b].GoogleAnalyticsObject=c;d[b].q=[];d[c]=function(){d[b].q.push(arguments)};d[c].q=d[c].q||[];d[b].roiq=[];d[b].analyticsJsNotLoaded=true;d[c].q.push([function(){d[b].realGa=d[c];d[b].analyticsJsNotLoaded=false;d[c]=function(){if(typeof arguments[0]===\"function\"){d[b].realGa(arguments)}else{d[b].q.push(arguments)}};d[b].roiq.push=function(){d[b].realGa.apply(d,arguments)};for(f=0;f<d[b].roiq.length;f+=1){d[b].realGa.call(d,d[b].roiq[f])}}])})(window,\"ROIStorage\",\"ga\");
        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://1e8bd83f2a81006b7166-e4331f47c49971b9f71a70f5f1467b26.ssl.cf2.rackcdn.com/gate.js' : 'http://73cea5cb8f6330822275-e4331f47c49971b9f71a70f5f1467b26.r70.cf2.rackcdn.com/gate.js');
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
        }",
        'qubit_universalvariable/QuBit_OpenTag_Settings/Gate_Enabled' => 1  
    ),
    'wfn_en' => array(
        'qubit_universalvariable/QuBit_OpenTag_Settings/Gate_Script' => "if(typeof ROITracker===\"undefined\"){(function(g,a,t,e){g[a]={};g[a].GoogleAnalyticsObject=t;g[a].q=[];g[t]=function(){g[a].q.push(arguments)};g[t].q=g[t].q||[];g[a].roiq=[];g[a].analyticsJsNotLoaded=true;g[t].q.push([function(){g[a].realGa=g[t];g[a].analyticsJsNotLoaded=false;g[t]=function(){if(typeof arguments[0]===\"function\"){g[a].realGa(arguments)}else{g[a].q.push(arguments)}};g[a].roiq.push=function(){g[a].realGa.apply(g,arguments)};for(e=0;e<g[a].roiq.length;e+=1){g[a].realGa.call(g,g[a].roiq[e])}}])})(window,\"ROIStorage\",\"ga\")}ROIStorage.gaq=ROIStorage.gaq||[];window._gaq={push:function(){var e;for(e=0;e<arguments.length;e++){ROIStorage.gaq.push(arguments[e])}}};var _gaq=window._gaq;
        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://541560de5ddd556bc83d-a3a97dd8fdf5f0b70cab2daadf3218e8.ssl.cf2.rackcdn.com/gate.js' : 'http://dd3e31ef376d56cdfc2b-a3a97dd8fdf5f0b70cab2daadf3218e8.r36.cf2.rackcdn.com/gate.js');
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();",
        'qubit_universalvariable/QuBit_OpenTag_Settings/Gate_Enabled' => 1
    )
);

foreach ($configList as $storeCode => $data) {
    foreach ($data as $path => $value) {
        Mage::getConfig()->saveConfig($path, $value, 'stores', Mage::app()->getStore($storeCode)->getId());       
    }
}

Mage::getConfig()->reinit();
Mage::app()->reinitStores();

$installer->endSetup();

