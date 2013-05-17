<?php
/**
 * https://developers.google.com/analytics/devguides/collection/gajs/methods/gaJSApiBasicConfiguration
 */
namespace agile55\ga;
class Controller_Tracker extends \AbstractController {

    public $auto_track_element=true;  // don't let them add us twice

    function init(){

        parent::init(); //UA-36477683-1

        $account=$this->api->getConfig('google/analytics/account',false);
        if($account===false)return $this->destroy();

        $this->api->add('Html',null,'js_include')->set(<<<EOF
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '$account']);
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
EOF
        );

        $this->api->addHook('post-init',function($api){
            $api->page_object->js(true,"_gaq.push(['_trackPageview', '/".$api->page."']);");
        });
    }
    function setCustomVar($index,$name,$value,$opt_scope){
        // TODO
    }


}
