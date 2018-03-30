<?php 
	$cssAnsScriptFiles = array(
		'/assets/css/circle.css',
	); HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl);

	$cssAnsScriptFilesTheme = array(
		"/plugins/Chart-2.6.0/Chart.min.js",
	); HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

	 $cssAnsScriptFilesModule = array(
	    '/js/default/profilSocial.js',
	  );
	  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "info",
                            )
                        );


	$week = @$_POST["week"];
	$visits = CO2Stat::getStatsByHash(@$week); 
	$days = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");

	$nextWeek = $visits["numweek"] + 1;
	$backWeek = $visits["numweek"] - 1;
	$backYear = $visits["year"];
	$nextYear = $visits["year"];
	if($nextWeek < 10) $nextWeek="0".$nextWeek;
	if($backWeek < 10) $backWeek="0".$backWeek;
	if($backWeek == 0) { $backWeek=52; $backYear--;}
	if($nextWeek > 52) { $nextWeek="01"; $nextYear++;}
?>
<style>
	.stat-week .col-md-1{
		width:12%!important;
		margin:1%!important;
	}
	.title-super-admin{
		display: none;
	}
	header{
		display: none;
	}

  @media screen and (max-width: 1024px) {
  	.main-apropos{
  		padding:15px 50px;
  	}
  }

</style>



<section class="padding-top-15">
    <div class="row main-apropos padding-top-15 padding-bottom-50">
	    
        <div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10 col-sm-12 col-xs-12">

        	<h4 class="pull-left">
        		<i class="fa fa-angle-down"></i> <i class="fa fa-bar-chart"></i> <?php echo Yii::t("common","Statistics"); ?>
        	</h4>
        	
        	<a href="#" class="lbh btn btn-default pull-right margin-left-5 btn-submenu tooltips"
        		data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t("common","Back to home") ?>">
        		<b><?php echo Yii::t("common","Leave this page") ?> <i class="fa fa-arrow-right"></i></b>
        	</a> 

        	<br><hr>

        	<small class="font-montserrat text-light">
        		<i class="fa fa-angle-right"></i> 
        		<?php echo Yii::t("common","The statistics shown correspond to the number of loadings of each url.") ?><br>
        		<i class="fa fa-angle-right"></i> 
        		<?php echo Yii::t("common","Each time a person accesses for example the page #agenda, #live, or #search, the number increases.") ?><br>
        		<i class="fa fa-angle-right"></i> 
        		<?php echo Yii::t("common","The curves provide an overview of page traffic by page, day and week.") ?><br><br>
        		<i class="fa fa-angle-right"></i> 
        		<?php echo Yii::t("common","LOGIN is incremented each time a user logs in to their account.") ?>
        	</small>


			<div class="col-md-12 stat-week no-padding" id="central-container">
				<hr>
				<h5 class="text-left text-azure">
					<i class="fa fa-angle-down"></i> <?php echo Yii::t("common","Number of visits - Week") ?> <?php echo $visits["week"]; ?></span>
					<br><br>
					<button class="btn btn-default pull-left margin-right-5" id="back-week" 
							data-week="<?php echo $backWeek.$backYear; ?>">
						<i class="fa fa-chevron-left"></i> <?php echo Yii::t("common","Week") ?> <?php echo $backWeek; ?>
					</button>
					<?php if($nextWeek <= Date("W") || $nextYear < Date("Y")){ ?>
					<button class="btn btn-default pull-left" id="next-week" data-week="<?php echo $nextWeek.$nextYear; ?>">
						<?php echo Yii::t("common","Week") ?> <?php echo $nextWeek; ?> <i class="fa fa-chevron-right"></i> 
					</button>
					<?php } ?>
				</h5>
				<br>
				<hr>

				<?php foreach ($visits["hash"] as $domain => $stats) {  if($domain != "co2-power"){ ?>
				<?php 	$totalLoad = 0; 
						$domainLbl = str_replace("co2-", "", $domain);
				?>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 text-center margin-bottom-50">
							<?php foreach ($days as $key => $day) { $totalLoad += @$stats[$day]["nbLoad"] ? $stats[$day]["nbLoad"] : 0; } ?>
							<h5 class="text-left letter-azure">
								#<?php echo $domainLbl; ?> 
								<small class="">(<?php echo $totalLoad; ?>)</small>
							</h5>
							
							<canvas id="smartChart-<?php echo $domain;?>"/>
							<?php foreach ($days as $key => $day) { ?>
								<?php 	
									$bg = "white";
									$text = "dark";
									if(@$stats[$day]["nbLoad"] > 0) { $text = "azure"; }
									if(@$stats[$day]["nbLoad"] > 50) { $text = "green"; }
									if(@$stats[$day]["nbLoad"] > 100) { $text = "orange"; }
									if(@$stats[$day]["nbLoad"] > 300) { $text = "red"; }
								?>
								<div class="col-md-1 col-sm-1 col-xs-1 bg-<?php echo $bg;?> letter-<?php echo $text;?> padding-10 radius-5 border-white-2">
									<h4 class="no-margin">
										<?php echo @$stats[$day]["nbLoad"]; ?> 
										<!-- <small><?php echo $day; ?></small> -->
									</h4>
									
								</div>
							<?php } ?>
						</div>
				<?php }} ?>
			</div>

		</div>
	</div>
</section>


<script type="text/javascript" >

var titlePage = "<?php echo Yii::t("common","Statistics"); ?>";
var datas = <?php echo json_encode($visits["hash"]); ?>;

	jQuery(document).ready(function() {

		initKInterface();
		setTitle("", "", titlePage);
		//toogleNotif(false);

		$("#back-week, #next-week").click(function(){
			var numweek = $(this).data("week");
			loadAdminDashboard(numweek);
		});

		loadChart();
	});



	//GRAPH CHART
	function loadChart(){
	    var i = 0;
	    console.log("original data :: ", datas); 
	    $.each(datas, function(dataKey, val){ i++;
	        var color = "";//typeof val["color"] != "undefined" ? val["color"] : "green";
	        statChartInit("smartChart-"+dataKey, val, dataKey, "line");
	    });
	}


	function statChartInit(idCanvas, datas, dataKey, chartType, color){ //alert("start loadchart");

		if($("#"+idCanvas).length == 0 || typeof $("#"+idCanvas).get(0) == "undefined") return;

        var dataChart = new Array();
        var labelsDates = new Array();
        
        //console.log("smartTest datas chart", datas);
        $.each(datas, function(key, val){
            console.log("smartTest valchart", val, key);
            dataChart.push(val.nbLoad);
            labelsDates.push(key);
        });

        //console.log("smartTest ready dataChart ?", dataChart);
        var data = {
            datasets: [{
                label: dataKey,
                data : dataChart,
                backgroundColor: "#2BB0C61A",
                borderColor: "#2BB0C6",
                borderWidth: 1
            }],
            labels: labelsDates 
        };

        //console.log("dataChart :: ", data, "chart : ", data, "idCanvas", idCanvas);
        var ctx = $("#"+idCanvas).get(0).getContext("2d");
        var options;
        myPieChart = new Chart(ctx,{
            type: chartType,
            data: data,
            options: {
                legend: {
                    display: false
                },
                animation: {
                    duration: 300
                }
            },
            //options: options
        });
    }


</script>