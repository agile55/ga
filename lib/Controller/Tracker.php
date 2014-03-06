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

        $this->api->add('Text',null,'js_block')->setHTML(<<<EOF
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '$account');
</script>        
EOF
        );

        $this->api->addHook('post-init',function($api){
            $p=$api->page;
            if($p=='index')$p='';
            $api->page_object->js(true,"ga('send','pageview', '/".$p."');");
        });
    }
    function setCustomVar($index,$name,$value,$opt_scope){
        // TODO
    }


}
