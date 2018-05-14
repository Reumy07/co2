<?php 

    $this->renderPartial("../news/newsAssets");
    
	HtmlHelper::registerCssAndScriptsFiles( 
			array('/css/timeline2.css',
				  '/css/news/index.css',
				  '/css/default/directory.css',	
				) , Yii::app()->theme->baseUrl. '/assets');


	$cssAnsScriptFilesModule = array(
		'/js/news/index.js',
		'/js/news/autosize.js',
		'/js/news/newsHtml.js',
		'/js/default/live.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);


    HtmlHelper::registerCssAndScriptsFiles(
        array('/plugins/showdown/showdown.min.js',
              '/plugins/to-markdown/to-markdown.js',
              ), Yii::app()->request->baseUrl);
    
    $page = "live";
    
    if(Yii::app()->params["CO2DomainName"] == "kgougle")
        $page = "freedom";

    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath ,
                                "type" => @$type,
                                "page" => $page
                                //"explain"=> "Live public : retrouvez tous les messages publics selon vos lieux favoris") 
                                )); 
    $randImg = rand(1, 2);
    $page = "live";
    //$randImg = 1;

    $params = CO2::getThemeParams();
?>

<style>
    <?php if($params["title"] != "Kgougle") { ?>
   /* header {
      background: url("<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/background-header/live/pexels-<?php echo $randImg; ?>.jpeg") top center;
        min-height:300px;
    }*/
    <?php } ?>
     
	/*.scope-min-header{
        float: left;
        margin-top: 23px;
        margin-left: 35px;
    }
    .main-btn-scopes{
    	margin-top:0px !important;
    }*/
    #formCreateNewsTemp .form-create-news-container{
    max-width: inherit !important;
	}
	.item-globalscope-checker.inactive{
        color:#DBBCC1 !important;
        border-bottom:0px;
        margin(top:-6px;)
    }
    .item-globalscope-checker:hover,
    .item-globalscope-checker:active,
    .item-globalscope-checker:focus{
        color:#e6344d !important;
        border-bottom:1px solid #e6344d;
        text-decoration: none !important;
    }
    #noMoreNews {
	    position: relative;
	    padding: 0px 40px;
	    bottom: 0px;
	    width: 100%;
		text-align: center;
		background: white;
	}

	/*#btn-my-co{
		margin-top: 15px;
	}
    */

    #newsstream .loader,
    #noMoreNews{
       border-radius: 50px;
        margin-left: auto;
        margin-right: auto;
        display: table;
        padding: 15px;
        margin-top: 15px;
    }

    <?php if(Yii::app()->params["CO2DomainName"] == "kgougle"){  ?>
    #scope-container,
    #filters-container{
        display: none !important;
    }

    
    #main-input-group{
        width:76%;
    }

    #formCreateNewsTemp{
        margin-left: 12%;
        width: 100%;
    }
    <?php } ?>

    .live-container{
        padding-top:50px !important;
    }


@media (min-width: 991px) {
    .subModuleTitle{
        width: 100% !important;
        margin-left: 11% !important;
    }
}

   /* .subModuleTitle{
        display: none;
    }*/
</style>
<div class="row padding-10 bg-white live-container">
<?php 
        $CO2DomainName = Yii::app()->params["CO2DomainName"];
        if($CO2DomainName == "kgougle"){ 
           $this->renderPartial($layoutPath.'headers/pod/'.$CO2DomainName.'/dayQuestion', array());
        } 
    ?>

    <div class="col-md-12 col-sm-12 col-xs-12 bg-white top-page" id="" style="padding-top:0px!important;">
    	<!--<div id="container-scope-filter" class="col-md-offset-1 col-md-11 col-lg-offset-1 col-lg-11 col-sm-12 col-xs-12 col-md-offset" style="padding:20px 0px;">
    		<?php
    	        $this->renderPartial($layoutPath.'breadcrum_communexion', array("type"=>@$type)); 
    	    ?>
    	</div>-->

    	<div class="col-lg-1 col-md-1 hidden-sm hidden-xs text-right hidden-xs" id="sub-menu-left"></div>

    	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 margin-top-10">
    		<div id="newsstream"></div>
    	</div>	

    	<!-- <div class="pull-right col-lg-3 col-md-3 col-sm-4 hidden-xs padding-20 margin-top-50" id="nowList">
    	
    	</div> -->
    </div>
</div>


<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array("subdomain"=>$page)); ?>


<script type="text/javascript" >

<?php  $parent = Person::getById(@Yii::app()->session["userId"]); ?>


var indexStepInit = 5;
//var searchType = ["organizations", "projects", "events", "needs", "proposals"];
var allNewsType = ["news"];//, "idea", "question", "announce", "information"];

//var liveTypeName = { "news":"<i class='fa fa-rss'></i> Les messages",
					 //"idea":"<i class='fa fa-info-circle'></i> Les idées",
					 //"question":"<i class='fa fa-question-circle'></i> Les questions",
					 //"announce":"<i class='fa fa-ticket'></i> Les annonces",
					 //"information":"<i class='fa fa-newspaper-o'></i> Les informations"
//					};

//var page = "<?php echo $page; ?>";

<?php if(Yii::app()->params["CO2DomainName"] == "kgougle") $page = "freedom"; ?>
var titlePage = "<?php echo @$params["pages"]["#".$page]["subdomainName"]; ?>";

var scrollEnd = false;
/*<?php if(@$type && !empty($type)){ ?>
	searchType = ["<?php echo $type; ?>"];
<?php }else{ ?>
	searchType = $.merge(allNewsType, searchType);
<?php } ?>*/

var loadContent = '<?php echo @$_GET["content"]; ?>';
var dataNewsSearch = {};
var	dateLimit=0;

//var personCOLLECTION = "<?php echo Person::COLLECTION; ?>";

//var contextData = <?php echo json_encode( Element::getElementForJS(@$parent, Person::COLLECTION) ); ?>; 

//var scrollEnd = false;
jQuery(document).ready(function() {
	$(".subsub").hide();

	//initFilterLive();
	//showTagsScopesMin("#list_tags_scopes");
	$("#btn-slidup-scopetags").click(function(){
      slidupScopetagsMin();
    });
	$('#btn-start-search').click(function(e){
		startNewsSearch(true);
    });
		
	
    
    searchPage = true;
	startNewsSearch(true);

	$(".titleNowEvents .btnhidden").hide();

	//init loading in scroll
   
    initKInterface({"affixTop":200});//{"affixTop":10});
    
    Sig.restartMap(Sig.map);

    $(".theme-header-filter").off().on("click",function(){
            if(!$("#filter-thematic-menu").is(":visible") || $(this).hasClass("toogle-filter"))
                $("#filter-thematic-menu").toggle();
    });
    $(".btn-select-filliaire").off().on("click",function(){
        mylog.log(".btn-select-filliaire");
        var fKey = $(this).data("fkey");
        myMultiTags = {};
        searchObject.text="";
        $.each(filliaireCategories[fKey]["tags"], function(key, tag){
            tag=(typeof tradTags[tag] != "undefined") ? tradTags[tag] : tag;
            searchObject.text+="#"+tag+" ";
        });
        $("#filter-thematic-menu").hide();
        $("#main-search-bar, #second-search-bar").val(searchObject.text);
        mylog.log("myMultiTags", myMultiTags);
        
        searchObject.page=0;
        pageCount=true;
        searchObject.count=true;
        if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
        
        startSearch(0, indexStepInit, searchCallback);
    });
    $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13 || $(this).val() == ""){
            startNewsSearch(true); 
            KScrollTo("#content-social");
        }
    });
    $("#main-search-bar").change(function(){
        $("#second-search-bar").val($(this).val());
    });

    $("#second-search-bar").keyup(function(e){
        $("#main-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13 || $(this).val() == ""){            
            startNewsSearch(true);
            KScrollTo("#content-social");
         }
    });

    $("#input-search-map").keyup(function(e){
        $("#second-search-bar").val($("#input-search-map").val());
        $("#main-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            startNewsSearch(true);
         }
    });

    $("#main-btn-start-search, #main-search-bar-addon, .menu-btn-start-search").click(function(){
        startNewsSearch(true);
    });
    $(".subModuleTitle .btn-refresh").click(function(){
        $("#main-search-bar").val("");
        $("#second-search-bar").val("");
        startNewsSearch(true);
    });

    setTitle(titlePage, "stack-exchange", titlePage);
    //KScrollTo(".main-btn-scopes");
});


</script>