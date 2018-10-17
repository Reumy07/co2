<?php 
    HtmlHelper::registerCssAndScriptsFiles( 
        array(  //'/css/onepage.css',
                '/vendor/colorpicker/js/colorpicker.js',
                '/vendor/colorpicker/css/colorpicker.css',
                '/css/news/index.css',  
                '/css/timeline2.css',
                //'/css/circle.css',    
                '/css/default/directory.css',   
                //'/js/comments.js',
                '/css/profilSocial.css',
                '/css/calendar.css',
        ) , 
    Yii::app()->theme->baseUrl. '/assets');

 $cssAnsScriptFilesModule = array(
    '/js/default/calendar.js',
    '/js/news/index.js',
    '/js/dataHelpers.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

    $cssAnsScriptFilesTheme = array(
        "/plugins/jquery-cropbox/jquery.cropbox.css",
        "/plugins/jquery-cropbox/jquery.cropbox.js",
        // SHOWDOWN
        '/plugins/showdown/showdown.min.js',
        //MARKDOWN
        '/plugins/to-markdown/to-markdown.js',
        '/plugins/jquery.qrcode/jquery-qrcode.min.js',
        '/plugins/fullcalendar/fullcalendar/fullcalendar.min.js',
        '/plugins/fullcalendar/fullcalendar/fullcalendar.css', 
        '/plugins/fullcalendar/fullcalendar/locale/'.Yii::app()->language.'.js',
        
        
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
    $this->renderPartial("../news/newsAssets");

	HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css') , Yii::app()->theme->baseUrl. '/assets');
	//$cssAnsScriptFilesModule = array('');
	//HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
    
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu

    //le param USEHEADER de params.json sert à afficher ou non le header, 
    //donc normalement pas besoin de faire de IF ici
        $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "page",
                                "dontShowMenu"=>true,
                                "useFilter"=>false) ); 
?>
<style type="text/css">
    .social-main-container{
        padding-top: 20px !important;
    }
    #home .timeline > li.timeline-inverted > .timeline-badge{
        display: none;
    }
    #home .timeline > li > .timeline-panel{
        width: 100%
    }
    #home .timeline > li.timeline-inverted > .timeline-panel:before, #home .timeline > li.timeline-inverted > .timeline-panel:after{
        border-right-width:0px;
    }
    #home .timeline::before{
        width: 0px;
    }
    .menu-left-home, #notif-column{
        position: fixed;
    }
    #notif-column{
        right: 0;
    }

    .menu-left-home{
        left: 52px;
    }
    .content-home-user-info .link-user-menu{
        text-decoration: none;
    }
    .content-home-user-info .img-profil{
        border-radius:10px;
    }
    .content-home-user-info .username{
        font-size: 20px;
        vertical-align: bottom;
        text-decoration: underline;
    }
    .content-home-user-info .username:hover{
        color:#4285f4!important;
    }
    .content-home-user-info .label-gammification{
        text-transform: uppercase; 
    }
    .content-home-user-info .label-gammification, .content-home-user-info .points-gammification{
        vertical-align: sub;
    }
    #btnGamificationInfos:hover{
        cursor: pointer;
    }
    .contribute-panel .title-rubrique{
        font-size: 16px;
        color:#777;
        padding-top: 5px;
        padding-bottom: 5px;
        margin-bottom: 5px !important;
        float: left;
    }
    /*.contribute-panel .btn-open-form{
        margin-bottom: 3px;
    }*/
    .contribute-panel .btn-open-form i{
        font-size: 15px;
        vertical-align: baseline;
        width: 25px;
        height: 25px;
        text-align: center;
        padding: 5px;
        border-radius: 100%;
        color: white !important;

    }
    .breadcrumb-gammification .content-level{
        display: inline-block;
        width: 60px;
        text-align: center;
        margin:0px 15px; 
    }
    .breadcrumb-gammification .label-level-game{
        font-variant: small-caps;
    }
    .breadcrumb-gammification .mylevel{
        font-variant: small-caps;
        font-weight: bolder;
    }
</style>
<div class="col-md-12 col-sm-12 col-xs-12 no-padding social-main-container">
	<div class="" id="onepage">
		<div class="hidden-xs hidden-sm col-md-2 col-lg-3 menu-left-home content-home-user-info">
            <?php 
               // if( isset( Yii::app()->session['userId']) ){
                 //   print_r(Yii::app()->session["user"]);
                $profilThumbImageUrl = $this->module->getParentAssetsUrl().'/images/thumbnail-default.jpg';
                if(@Yii::app()->session["user"]["profilThumbImageUrl"])
                    $profilThumbImageUrl=Yii::app()->getRequest()->getBaseUrl(true).Yii::app()->session["user"]["profilThumbImageUrl"];
                  //$profilThumbImageUrl = Element::getImgProfil($me, "profilThumbImageUrl", );
                  //$countNotifElement = ActivityStream::countUnseenNotifications(Yii::app()->session["userId"], Person::COLLECTION, Yii::app()->session["userId"]);
                $pointGammif=Gamification::calcPoints( Person::COLLECTION, Yii::app()->session["userId"] );
                $labelBadgeGammif=Gamification::badge(  Yii::app()->session["userId"], $pointGammif );
                $iconBadgeGammif=Gamification::badge(  Yii::app()->session["userId"], $pointGammif, $this->module->getParentAssetsUrl() );
            ?>     
            <a href="#page.type.<?php echo Person::COLLECTION ?>.id.<?php echo Yii::app()->session["userId"] ?>" class="link-user-menu lbh text-dark no-margin margin-bottom" data-toggle="dropdown">
                <img class="img-profil" id="" width="25" height="25" src="<?php echo $profilThumbImageUrl ?>" alt="image">            
                <span class="username"><?php echo "@".Yii::app()->session["user"]["username"] ?></span> 
            </a>
            <div id="btnGamificationInfos" class="col-xs-12 valueAbout no-padding margin-bottom-10 btnGamificationInfos margin-top-10">
                <span style="line-height: 25px;"> 
                    <img class="" width="25" height="25" src="<?php echo $iconBadgeGammif ?>" alt="image">
                    <span class="label-gammification"><?php echo $labelBadgeGammif ?></span>
                    <span class="points-gammification">&middot; <span class="letter-red"><?php echo $pointGammif."</span>"." ".Yii::t("common","points"); ?></span>
                </span>  
            </div>
            <div class="contribute-panel col-xs-12 no-padding margin-top-20">
                <span class="title-rubrique"><?php echo Yii::t("common","Create your network")?></span>
                <a href="#element.invite" class="lbhp btn-open-form col-xs-12 no-padding margin-bottom-10"><i class="fa fa-user-plus bg-yellow"></i> <?php echo Yii::t("common", "Invite your friend") ?></a>
                <a href="javascript:;" data-form-type="organization" class="btn-open-form col-xs-12 no-padding margin-bottom-10"><i class="fa fa-users bg-green"></i> <?php echo Yii::t("common", "Add an organization") ?></a>
                <a href="javascript:;" data-form-type="project" class="btn-open-form col-xs-12 no-padding"><i class="fa fa-lightbulb-o bg-purple"></i> <?php echo Yii::t("common", "Reference a project") ?></a>
            </div>
             <div class="contribute-panel col-xs-12 no-padding margin-top-20">
                <span class="title-rubrique"><?php echo Yii::t("common", "Useful links") ?></span>
                <a href="#docs.page.elements" class="col-xs-12 no-padding">#<?php echo Yii::t("common","User guide") ?></a><br/>
                <a href="#settings.index" class="lbh margin-top-10 col-xs-12 no-padding">#<?php echo Yii::t("common", "Settings") ?></a><br/>
                <a href="javascript:;" class="margin-top-10 col-xs-12 no-padding">#<?php echo Yii::t("common", "Contact us") ?></a><br/>
            </div>

            <!--<div class="contribute-panel">
            <a href="javascript:;" class="margin-top-10 col-xs-12 no-padding">Concours des assos</a><br/>-->
        </div>
        <div class="col-xs-12 col-sm-9 col-md-7 col-lg-6 col-md-offset-2 col-lg-offset-3" id="home">
            <div class="content-home-user-info visible-xs col-xs-12 no-padding margin-bottom-10">
                <a href="#page.type.<?php echo Person::COLLECTION ?>.id.<?php echo Yii::app()->session["userId"] ?>" class="link-user-menu lbh text-dark no-margin margin-bottom" data-toggle="dropdown">
                    <img class="img-profil" id="" width="35" height="35" src="<?php echo $profilThumbImageUrl ?>" alt="image">            
                    <span class="username" style="font-size:25px;"><?php echo "@".Yii::app()->session["user"]["username"] ?></span> 
                </a>
                <strong class="margin-right-5 margin-left-5" style="font-size: 20px;vertical-align: middle;text-align: center;width: 20px;display: inline-block;"> • </strong>
                <div id="btnGamificationInfos" class="valueAbout no-padding margin-bottom-10 margin-top-10 btnGamificationInfos" style="display: initial;">
                    <span style="line-height: 25px;"> 
                        <img class="" width="25" height="25" src="<?php echo $iconBadgeGammif ?>" alt="image">
                        <span class="label-gammification"><?php echo $labelBadgeGammif ?></span>
                        <span class="points-gammification">&middot; <span class="letter-red"><?php echo $pointGammif."</span>"." ".Yii::t("common","points"); ?></span>
                    </span>  
                </div>
            </div>
            <div class="col-xs-12 no-padding">
            </div>
            <div class="col-xs-12 no-padding" id="central-container">
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-3 hidden-xs" id="notif-column">
             <div class="content-home-user-info visible-sm">
                <a href="#page.type.<?php echo Person::COLLECTION ?>.id.<?php echo Yii::app()->session["userId"] ?>" class="link-user-menu lbh text-dark no-margin margin-bottom" data-toggle="dropdown">
                    <img class="img-profil" id="" width="25" height="25" src="<?php echo $profilThumbImageUrl ?>" alt="image">            
                    <span class="username"><?php echo "@".Yii::app()->session["user"]["username"] ?></span> 
                </a>
                <div id="btnGamificationInfos" class="col-xs-12 valueAbout no-padding margin-bottom-10 btnGamificationInfos margin-top-10">
                    <span style="line-height: 25px;"> 
                        <img class="" width="25" height="25" src="<?php echo $iconBadgeGammif ?>" alt="image">
                        <span class="label-gammification"><?php echo $labelBadgeGammif ?></span>
                        <span class="points-gammification">&middot; <span class="letter-red"><?php echo $pointGammif."</span>"." ".Yii::t("common","points"); ?></span>
                    </span>  
                </div>
            </div>
            <div id="territorial-notif-column">
                <?php if(@$element["custom"] && @$element["custom"]["pubTpl"])
                    echo $this->renderPartial($element["custom"]["pubTpl"]); ?>
            </div>
        </div>
	</div>
</div>
<div class="modal fade" role="dialog" id="modalExplainGamification" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green text-white">
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> <?php echo Yii::t("docs"," Gamification (ou ludification) Citoyenne") ?></h4>
            </div>
            <div class="modal-body center text-dark"> 
                <span class="text-short-explain">
                    La valeur par l'<span class="letter-red">usage</span>. <br/>Celle-ci est calculée <span class="letter-red">par rapport à chaque lienque vous faites</span> avec des personnes, organisations, événements, projets.<br/>Pour résumer, la valeur calculée par les liens que vous avez avec votre environnement permet de pondérer <span class="letter-red">votre activité locale</span>.<br/>Plus tard viendront s'ajouter l"échange de ressources, la qualité de vos posts, le nombre de votes et de contributions au système et donc à votre société locale.<br/>
                </span>
                <div class="content-user-game-info margin-top-20">
                    <span class="bold">Vous avez aujourd'hui <span class="letter-red"><?php echo $pointGammif ?> point<?php if($pointGammif>1) echo "s" ?></span></span><br/><br/>
                    <div class="breadcrumb-gammification">
                        <?php $level=Gamification::getAllLevelAndCurent($pointGammif, Yii::app()->session["userId"], $this->module->getParentAssetsUrl());
                          //  print_r($level);
                            foreach($level as $key => $v){ ?>
                                <div class="content-level <?php if(@$v["current"]) echo "current" ?>">
                                    <?php if(@$v["current"]){
                                        echo "<span class='mylevel letter-red'>".Yii::t("common", "You are")."</span>";
                                    } ?>
                                    <span class="label-level-game"><?php echo @$v["label"]; ?></span>
                                    <img src="<?php echo @$v["icon"]; ?>"/>
                                    <span class="nb-points"><?php echo @$v["points"]; ?> pt <?php if($v["points"] > 1) echo "s"; ?></span>
                                </div>
                            <?php }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" >

var type = "<?php echo Person::COLLECTION; ?>";
var id = "<?php echo Yii::app()->session["userId"]; ?>";
var view = "<?php echo @$view; ?>";
var indexStepGS = 20;
var dateLimit = 0;
var isLiveBool=true;
jQuery(document).ready(function() {
    bindLBHLinks();
	initKInterface({"affixTop":0});
	$("#mainNav").addClass("affix");
	initPageInterface();
    loadNewsStream(isLiveBool);
    // var tpl = '<?php //echo @$_GET["tpl"] ? $_GET["tpl"] : "profilSocial"; ?>';
	// getAjax('#onepage' ,baseUrl+'/'+moduleId+"/element/detail/type/"+type+"/id/"+id+"/view/"+view+"?tpl="+tpl,function(){ 
	// 	initPageInterface();
	// },"html");
});
function loadLiveNow () {
    //mylog.log("loadLiveNow1", contextData.address);

    var level = {} ;
    if( notNull(userConnected.address)) {
        mylog.log("loadLiveNow2", userConnected.address);
        if(notNull(userConnected.address.level4)){
            mylog.log("loadLiveNow3", userConnected.address.level4);
            level[userConnected.address.level4] = {id : userConnected.address.level4, type : "level4", name : userConnected.address.level4Name } ;
        } else if(notNull(userConnected.address.level3)){
            level[userConnected.address.level3] = {id : userConnected.address.level3, type : "level3", name : userConnected.address.level3Name } ;
        } else if(notNull(userConnected.address.level2)){
            level[userConnected.address.level2] = {id : userConnected.address.level2, type : "level2", name : userConnected.address.level2Name } ;
        } else if(notNull(userConnected.address.level1)){
            level[userConnected.address.level1] = {id : userConnected.address.level1, type : "level1", name : userConnected.address.level1Name } ;
        }
    }
    mylog.log("loadLiveNow4", level);
    if( jQuery.isEmptyObject(level) ) {
        //alert("Vous n'êtes pas communecté ?");
    } //else{
        var searchParams = {
          "tpl":"/pod/nowList",
          "searchLocality" : level,
          "indexMin" : 0, 
          "indexMax" : 30 
        };

        ajaxPost( "#territorial-notif-column", baseUrl+'/'+moduleId+'/element/getdatadetail/type/citoyens/id/'+userId+'/dataName/liveNow?tpl=nowList',
                        searchParams, function() { 
                        bindLBHLinks();
         } , "html" );
    //}
}
function loadNewsStream(isLiveBool){

    KScrollTo("#profil_imgPreview");
    //isLiveNews=isLiveBool;
    isLiveNews = isLiveBool==true ? "/isLive/true" : ""; 
    dateLimit = 0;
    scrollEnd = false;
    loadingData = true;
    toogleNotif(true);

    var url = "news/index/type/citoyens/id/"+userId+isLiveNews+"/date/"+dateLimit+
              "?isFirst=1&tpl=co2&renderPartial=true";
    
    setTimeout(function(){ //attend que le scroll retourn en haut (kscrollto)
        showLoader('#central-container');
        ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
            null,
            function(){ 
                loadLiveNow();
                $(window).bind("scroll",function(){ 
                    if(!loadingData && !scrollEnd && colNotifOpen){
                          var heightWindow = $("html").height() - $("body").height();
                          if( $(this).scrollTop() >= heightWindow - 1000){
                            loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep, "citoyens", userId);
                          }
                    }
                });
                loadingData = false;
        },"html");
    }, 700);
}
var colNotifOpen = true;
function toogleNotif(open){
    if(typeof open == "undefined") open = false;
    
    if(open==false){
        //$('#notif-column').removeClass("col-md-3 col-sm-3 col-lg-3").addClass("hidden");
        //$('#central-container').removeClass("col-md-9 col-lg-9").addClass("col-md-12 col-lg-12");
    }else{
        //$('#notif-column').addClass("col-md-3 col-sm-3 col-lg-3").removeClass("hidden");
        //$('#central-container').addClass("col-sm-12 col-md-9 col-lg-9").removeClass("col-md-12 col-lg-12");
    }

    colNotifOpen = open;
}
function initPageInterface(){
    $(".btnGamificationInfos").off().on("click",function(){
        $("#modalExplainGamification").modal("show"); 
    });
	$("#second-search-bar").addClass("input-global-search");

    $("#main-btn-start-search, .menu-btn-start-search").click(function(){
        startGlobalSearch(0, indexStepGS);
    });

    $("#second-search-bar").keyup(function(e){ console.log("keyup #second-search-bar");
        $("#input-search-map").val($("#second-search-bar").val());
        if(e.keyCode == 13){
            searchObject.text=$(this).val();
            myScopes.type="open";
            myScopes.open={};
            urlCtrl.loadByHash("#search");
            //startGlobalSearch(0, indexStepGS);
         }
    });
    
    $("#input-search-map").keyup(function(e){ console.log("keyup #input-search-map");
        $("#second-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            startGlobalSearch(0, indexStepGS);
         }
    });

    $("#menu-map-btn-start-search").click(function(){
        $("#second-search-bar").val($("#input-search-map").val());
        startGlobalSearch(0, indexStepGS);
    });

    $(".social-main-container").mouseenter(function(){
    	$(".dropdown-result-global-search").hide();
    });

    $(".tooltips").tooltip();
   
    $('.sub-menu-social').affix({
      offset: {
          top: 320
      }
    });
    //$(".dropdown-result-global-search").hide();
    

}

</script>