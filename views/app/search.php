<?php 
    $cssAnsScriptFilesModule = array(
    '/plugins/jquery-simplePagination/jquery.simplePagination.js',
    '/plugins/jquery-simplePagination/simplePagination.css',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true));
    $cssAnsScriptFilesModule = array(
    '/assets/css/default/responsive-calendar.css',
    '/assets/css/default/search.css',
    '/assets/js/comments.js'
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);

    $cssAnsScriptFilesModule = array(
    '/js/default/responsive-calendar.js',
    '/js/default/search.js',
//    '/js/default/directory.js',
    '/js/news/index.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->getParentAssetsUrl());


    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

    $params = CO2::getThemeParams();

    $maxImg = 5;

    $page = "search";
    if(!@$type){  $type = "all"; }

    if(@$type=="events")    { $page = "agenda";     $maxImg = 7; }
    if(@$type=="classified"){ $page = "annonces";   $maxImg = 1; }
    if(@$type=="vote")      { $page = "power";      $maxImg = 1; }
    if(@$type=="place")     { $page = "place";      $maxImg = 1; }
    if(@$type=="ressources") { $page = "ressources"; }

    if(@$type=="cities")    { $lblCreate = ""; }

    /*if($params["title"] == "Kgougle") {
        $page = "social";
        if(@$type=="classified"){ $page = "annonces"; }
        if(@$type=="events"){ $page = "agenda"; }
    }*/

    //header + menu
    $this->renderPartial($layoutPath.'header', 
                            array(  "layoutPath"=>$layoutPath ,
                                    "page" => $page,
                                    "type" => @$type) ); 


    $randImg = rand(1, $maxImg);
    //$randImg = 2;
?>

<style>
    header .headerImg{
        background-image: url("<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/reunion/reunion5.jpg");
        background-size: 100% auto;
        height: 300px;
        margin-top: 45px;
        background-repeat: no-repeat;
        background-position: bottom center;
        /*opacity: 0.3;
        background-color: black;*/
    }
    <?php if($params["title"] != "Kgougle") {} ?>
   /* header {
      background: url("<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/background-header/<?php echo $page; ?>/pexels-<?php echo $randImg; ?>.jpeg") center center;
      /*opacity: 0.3;
      background-color: black;*/
    /*}*/
    

    #dropdown_search{
        margin-top:0px;
    }

    .container{
        padding-bottom:0px !important;
    }
    .simple-pagination{
        padding: 5px 0px;
        border-bottom: 1px solid #e9e9e9;
        font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    .simple-pagination li a, .simple-pagination li span {
        border: none;
        box-shadow: none !important;
        background: none !important;
        color: #707478 !important;
        font-size: 13px !important;
        font-weight: 500;
    }
    .simple-pagination li.active span{
        color: #d9534f !important;
        font-size: 24px !important; 
    }

    .simple-pagination li a.next,
    .simple-pagination li a.prev{
        color:#223f5c !important;
    }
</style>


<div class="col-md-12 col-sm-12 col-xs-12 bg-white no-padding shadow pageContent" 
     id="content-social" style="min-height:700px;">
    <?php if(@$type=="events"){ ?>
    <div class="col-md-12 no-padding calendar"></div>
    <div class="responsive-calendar-init hidden"> 
      <div class="responsive-calendar light col-md-12 no-padding">   
          <div class="day-headers">
            <div class="day header"><?php echo Yii::t("translate","Mon") ?></div>
            <div class="day header"><?php echo Yii::t("translate","Tue") ?></div>
            <div class="day header"><?php echo Yii::t("translate","Wed") ?></div>
            <div class="day header"><?php echo Yii::t("translate","Thu") ?></div>
            <div class="day header"><?php echo Yii::t("translate","Fri") ?></div>
            <div class="day header"><?php echo Yii::t("translate","Sat") ?></div>
            <div class="day header"><?php echo Yii::t("translate","Sun") ?></div>
          </div>
          <div class="days" data-group="days"></div>   
          <div class="controls">
              <a id="btn-month-before" class="text-white" data-go="prev"><div class="btn"><i class="fa fa-arrow-left"></i></div></a>
              <h4 class="text-white"><span data-head-month></span> <span data-head-year></span></h4>
              <a id="btn-month-next" class="text-white" data-go="next"><div class="btn"><i class="fa fa-arrow-right"></i></div></a>
          </div>
      </div>
    </div>
    <?php } ?>

	<div class="col-md-12 col-sm-12 col-xs-12 no-padding" id="page"></div>
</div>

<?php $this->renderPartial($layoutPath.'modals.'.Yii::app()->params["CO2DomainName"].'.pageCreate', array()); ?>
<?php $this->renderPartial($layoutPath.'footer', array()); ?>
<?php //$this->renderPartial($layoutPath.'footer', array("subdomain"=>$page)); ?>



<script type="text/javascript" >

var type = "<?php echo @$type ? $type : 'all'; ?>";
var typeInit = "<?php echo @$type ? $type : 'all'; ?>";
var page = "<?php echo @$page; ?>";
var titlePage = "<?php echo Yii::t("common",@$params["pages"]["#".$page]["subdomainName"]); ?>";
var pageCount=false;
search.count=true;


<?php if(@$type=="events"){ ?>
  var STARTDATE = new Date();
  var ENDDATE = new Date();
  var startWinDATE = new Date();
  var agendaWinMonth = 0;
<?php } ?>
var scrollEnd = false;
//var TPL = "kgougle";

//allSearchType = ["persons", "NGO", "LocalBusiness", "projects", "Group"];

var currentKFormType = "";

jQuery(document).ready(function() {

    setTitle(titlePage, "", titlePage);
    
    initCountType();
    var typeUrl = "?nopreload=true";
    if(type!='') typeUrl = "?type="+type+"&nopreload=true";
    //if( type=="ressources" )search.app = "ressources";
    var appUrl = (typeof search.app != "undefined") ? "&app="+search.app : "";
	getAjax('#page' ,baseUrl+'/'+moduleId+"/default/directoryjs"+typeUrl+appUrl,function(){ 

        $(".btn-directory-type").click(function(){
            var typeD = $(this).data("type");
            /*if($(this).hasClass("active")){
                typeD="all";
                $(".btn-directory-type").removeClass("active");
            }else{*/
                if(search.app != "agenda")
                    search.app="search";
                $(".btn-directory-type").removeClass("active");
                $(this).addClass("active");
            /*}*/
            scrollH= ($("#filter-thematic-menu").is(":visible")) ? 250 : 91;
            simpleScroll(scrollH);
           
            if(typeD == "events"){
                var typeEvent = $(this).data("type-event");
                searchSType = typeEvent;
                // search.app="agenda";
            }
            initTypeSearch(typeD);
            if(typeD=="all"){
                searchEngine.initInjectData();
                searchEngine.initTerritorialSearch();
            }
                //else{
               // initKInterface({"affixTop":200});
            //}
            //mylog.log("search.php",searchType);
            //setHeaderDirectory(typeD);
            loadingData = false;
            pageCount=true;
            if(Object.keys(search.countType).length>1) search.count=false; 
            else search.count=true;
            pageEvent=false;
            search.type=searchType;
            startSearch(0, indexStepInit, searchCallback);
           // KScrollTo("#content-social");
        });

        // $(".btn-open-filliaire").click(function(){
        //     KScrollTo("#content-social");
        // });
         
         //anny double section filter directory
        <?php if(@$type == "classified" || @$type == "ressources" || @$type == "place"  ){ ?>
            initClassifiedInterface();
        <?php } ?>

        bindLeftMenuFilters();

        //console.log("init Scroll");
        /*$(window).bind("scroll",function(){  
            mylog.log("test scroll", scrollEnd);
            if(!loadingData && !scrollEnd && !isMapEnd){
                  var heightWindow = $("html").height() - $("body").height();
                  if( $(this).scrollTop() >= heightWindow - 400){
                    startSearch(currentIndexMin+indexStep, currentIndexMax+indexStep, searchCallback);
                  }
            }
        });*/

        if(type=="all"){
            //searchEngine.initInjectData();
            searchEngine.initTerritorialSearch();
        }

        loadingData = false; 
        initTypeSearch(type);
        startSearch(null, null, searchCallback);
        initSearchInterface();

    },"html");

    initSearchInterface(); //themes/co2/assets/js/default/search.js

    calculateAgendaWindow(0);

    if(page == "annonces" || page == "agenda" || page == "power"){
        setTimeout(function(){
            //KScrollTo("#content-social");  
        }, 1000);
    }

    $(".tooltips").tooltip();
});


/* -------------------------
AGENDA
----------------------------- */

<?php if(@$type == "events"){ ?>

var calendarInit = false;
function showResultInCalendar(mapElements){
    //mylog.dir(mapElements);

    var events = new Array();
    var fstDate = "";
    console.log("data mapElements", mapElements);
    $.each(mapElements, function(key, thisEvent){
    
        var startDate = exists(thisEvent["startDateTime"]) ? thisEvent["startDateTime"].substr(0, 10) : "";
        var endDate = exists(thisEvent["endDateTime"]) ? thisEvent["endDateTime"].substr(0, 10) : "";

        var cp = "";
        var loc = "";
        if(thisEvent["address"] != null){
            var cp = exists(thisEvent["address"]["postalCode"]) ? thisEvent["address"]["postalCode"] : "" ;
            var loc = exists(thisEvent["address"]["addressLocality"]) ? thisEvent["address"]["addressLocality"] : "";
        }
        var position = cp + " " + loc;

        var name = exists(thisEvent["name"]) ? thisEvent["name"] : "";
        var thumb_url = notEmpty(thisEvent["profilThumbImageUrl"]) ? baseUrl+thisEvent["profilThumbImageUrl"] : "";
        
        if(typeof events[startDate] == "undefined") events[startDate] = new Array();
        events[startDate].push({  "id" : (typeof thisEvent["_id"] != "undefined") ? thisEvent["_id"]["$id"] : thisEvent["id"]  ,
                                  "thumb_url" : thumb_url, 
                                  "startDate": startDate,
                                  "endDate": endDate,
                                  "name" : name,
                                  "position" : position });
    });

    if(calendarInit == true) {
        $(".calendar").html("");
    }

    $(".calendar").html($(".responsive-calendar-init").html());

    var aujourdhui = startWinDATE; //new Date();
    //console.log("aujourdhui", aujourdhui);
    var  month = (aujourdhui.getMonth()+1).toString();
    if(aujourdhui.getMonth() < 10) month = "0" + month;
    var date = aujourdhui.getFullYear().toString() + "-" + month;

    //console.log("data events", events, "time", date);
    $(".responsive-calendar").responsiveCalendar({
          time: date,
          events: events
        });

    $(".responsive-calendar").show();


    /*$("#btn-month-next").click(function(){
        agendaWinMonth++;
        calculateAgendaWindow(agendaWinMonth);
        startSearch(0, indexStep, searchCallback);
    });
    $("#btn-month-before").click(function(){
        agendaWinMonth--;
        calculateAgendaWindow(agendaWinMonth);
        startSearch(0, indexStep, searchCallback);
    });*/


    calendarInit = true;
}

<?php } ?>

/* -------------------------
END AGENDA
----------------------------- */

</script>