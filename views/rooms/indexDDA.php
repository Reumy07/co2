<style>
	.thumb-profil-parent-dda{

	}
	.toolbar-DDA{
		position:absolute;
		top:115px;
		left:50px;
	}

	.toolbar-DDA .dropdown{
		display: inline-block;
	}

	#accordion .panel{
		margin-top:15px;
	}
	.panel-group .panel-heading + .panel-collapse > .panel-body {
	    font-size: 17px;
	    padding:10px;
	}
	

	/*#accordion .panel-title a{
		font-weight:200;
		color:white;
		font-size:18px;
	}*/

	#accordion .panel-title a:hover{
		font-weight:400;
	}
	.text-light{
		font-weight: 300;
	}
}
.datepicker{z-index:12000 !important;}

a h1.text-azure:hover{
	color:#3C5665 !important;
}
.pr10{margin-right: 10px;}
</style>

<?php 
	
	//Menu::rooms($_GET["id"],$_GET["type"]);
	//$this->renderPartial('../default/panels/toolbar');

	$urlPhotoProfil = "";
	if(!@$parent){
		if($parentType == Project::COLLECTION) { $parent = Project::getById($parentId); }
	  	if($parentType == Organization::COLLECTION) { $parent = Organization::getById($parentId); }
	  	if($parentType == Person::COLLECTION) { $parent = Person::getById($parentId); }
        if($parentType == City::COLLECTION) { $parent = City::getByUnikey($parentId); }
	}

	if(isset($parent['profilImageUrl']) && $parent['profilImageUrl'] != "")
      $urlPhotoProfil = Yii::app()->getRequest()->getBaseUrl(true).$parent['profilImageUrl'];
    else
      $urlPhotoProfil = $this->module->assetsUrl.'/images/news/profile_default_l.png';

	$icon = "comments";	
	$colorName = "dark";
	if($parentType == Project::COLLECTION) { $icon = "lightbulb-o"; $colorName = "purple"; }
  	if($parentType == Organization::COLLECTION) { $icon = "group"; $colorName = "green"; }
  	if($parentType == Person::COLLECTION) { $icon = "user"; $colorName = "dark"; }
    if($parentType == City::COLLECTION) { $icon = "group"; $colorName = "red"; }

    $urlParent = Element::getControlerByCollection($parentType).".detail.id.".$parentId; 
	if($parentType == City::COLLECTION) 
		$urlParent = Element::getControlerByCollection($parentType).".detail.insee.".$parent["insee"].".postalCode.".$parent["cp"]; 

	if(!isset($_GET["renderPartial"]) && !isset($renderPartial)){
		$this->renderPartial('../rooms/header',array(    
		   					"parent" => $parent, 
	                        "parentId" => $parentId, 
	                        "parentType" => $parentType, 
	                        "fromView" => "rooms.index",
	                        "faTitle" => "connectdevelop",
	                        "colorTitle" => "azure",
	                        "textTitle" => "",
	                        "discussions" => $discussions, 
	                        "votes" => $votes, 
	                        "actions" => $actions, 
	                        "history" => $history, 
	                        "mainPage" => true
	                        ));
		//echo '<div class="col-md-4 panel-white padding-15" id="room-container">';
   }
?>
<!-- 
<div class="labelTitleDir">
	<i class="fa fa-inbox fa-2x margin-right-10"></i> <i class="fa fa-angle-down"></i> <b>Espaces de décisions</b>
	<hr>
</div> -->


<h4 class="margin-top-50"><i class="fa fa-angle-down"></i> Espace coopératif</h4>
<hr>

<div class="col-md-12 col-sm-12 col-xs-12 panel-white no-padding margin-bottom-50" id="room-container">

<div class="panel-group" id="accordion">
	<?php 
		$auth = ((Authorisation::canParticipate(Yii::app()->session['userId'],$parentType,$parentId) /*&& (@$fromView != "entity.detail") */)?true:false);
		
		if($auth==true) {
		    	/*echo '<button onclick="selectRoomType(\''.$typeNew.'\')" data-toggle="modal" 
		    			data-target="#modal-create-room" class="btn btn-link letter-green col-md-12 no-padding" style="text-align:left;">'.
		    			'<b><i class="fa fa-plus"></i> créer un nouvel espace</b>'.
		    		'</button>';*/
		    	echo '<button onclick="dyFObj.openForm(\'room\',\'sub\')" class="btn btn-link letter-green col-md-12 no-padding" style="text-align:left;">'.
		    			'<b><i class="fa fa-plus"></i> créer un nouvel espace</b>'.
		    		'</button>';
		}

		createAccordionMenu($discussions, 1, "Discussions", "comments", "discuss", "Aucun espace de discussion", $auth, @$fromView);
		createAccordionMenu($votes, 2, "Décisions", "gavel", "vote", "Aucun espace de décision", $auth, @$fromView);
		createAccordionMenu($actions, 3, "Actions", "cogs", "actions", "Aucun espace d'action", $auth, @$fromView);
	?>
</div>

<!-- <div id="endOfRoom">
	<a href='javascript:urlCtrl.loadByHash("#rooms.index.type.organizations.id.<?php echo (String) $parentId; ?>")'>
		<i class='fa fa-sign-in'></i> Entrer dans l'espace coopératif 
	</a>
</div> -->

<?php 
	function createAccordionMenu($elements, $index, $title, $icon, $typeNew, $emptyMsg, $auth, $fromView){
	
	$in =  "";//$index == 1 ? "in" : "";
	
	echo '<div class="col-md-12 no-padding">';
	echo '<div class="panel panel-default">';

	echo    '<div class="panel-heading text-dark no-padding">
		      <div class="panel-title">
		        <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$index.'" class="show-menu-co">
		        	<i class="fa fa-'.$icon.'"></i> <span class="hide-on-reduce-menu bold">'.$title.'</span>
		        	<span class="badge pull-right hide-on-reduce-menu">'.count($elements).'</span>
		        </a>
		      </div>
		      
		    </div>';

	echo 	'<div id="collapse'.$index.'" class="panel-collapse collapse '.$in.'">';

		        foreach ($elements as $key => $value) {
		        	$created = ( @$value["created"] ) ? date("d/m/y h:i",$value["created"]) : ""; 
		        	$col = Survey::COLLECTION;
			        $attr = 'survey';
		        	if( @$value["type"] == ActionRoom::TYPE_ACTIONS ){
			        	$col = ActionRoom::TYPE_ACTIONS;
			        	$attr = 'room';
			        }
			        $onclick = 'loadRoom(\''.$typeNew.'\', \''.(string)$value["_id"].'\')';
			        if(@$value["type"] == "entry") $onclick = 'urlCtrl.loadByHash(\'#survey.entry.id.'.(string)$value["_id"].'\')';
			        if(@$value["type"] == "action") $onclick = 'urlCtrl.loadByHash(\'#room.action.id.'.(string)$value["_id"].'\')';
			        if(@$fromView == "entity.detail") $onclick = 'loadRoom(\''.$typeNew.'\', \''.(string)$value["_id"].'\')';
			        
			        $updated = (@$value["updated"]) ? "<span class='text-extra-small fromNowDDA'>(".DateHelper::fromNow($value["updated"]).")</span>" : "";
			        $parentContext = ( @$_GET['type'] == Person::COLLECTION && @$value["parentType"] && @$value["parentId"] ) ? "<div class='pr10 btn btn-default pull-right'>".Element::getLink( $value["parentType"], $value["parentId"])."</div>" : "";
			        $count = 0;
					if( @$value["type"] == ActionRoom::TYPE_VOTE )
						$count = PHDB::count(Survey::COLLECTION,array("survey"=>(string)$value["_id"]));
					else if( @$value["type"] == ActionRoom::TYPE_ACTIONS )
						$count = PHDB::count(Survey::COLLECTION,array("room"=>(string)$value["_id"]));
					else if( @$value["type"] == ActionRoom::TYPE_DISCUSS )
						$count = (empty($value["commentCount"])?0:$value["commentCount"]);
					echo '<div class="panel-body no-padding hide-on-reduce-menu">'.
							'<a href="javascript:'.$onclick.'" class="text-dark  padding-top-15 padding-bottom-15">'.
								'<small><i class="fa fa-angle-right"></i> '.$value["name"]./*" ".$updated.*/" <div class='badge badge-success pull-right'>".$count."</div> "./*$parentContext.*/"</small>".
							'</a>'.
						 '</div>';
		        } 

		         if(empty($elements)) 
			      	echo '<div class="panel-body hide-on-reduce-menu"><small><i class="fa fa-times"></i> '.$emptyMsg.'</small></div>';

			     

	echo 	'</div>';

	echo '</div>';
	echo '</div>';
}

if(!isset($_GET["renderPartial"]) && !isset($renderPartial)){
  echo "</div>"; // ferme le id="room-container"
}

?>

<script type="text/javascript">
jQuery(document).ready(function() {
	alert("indexDDA");
	setTitle("Espaces Coopératifs","connectdevelop");
	$(".main-col-search").addClass("assemblyHeadSection");
	$(".explainLink").click(function() {
		showDefinition( $(this).data("id") );
		return false;
	});
});

</script>

<style>
@media screen and (min-width: 1400px) {
  .mixcontainer .mix, .mixcontainer .gap{
    width: 48%;
  }
}
</style>