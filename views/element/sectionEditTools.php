

    <style>
    	#onepage-edition-tools input{
    		/*display: none;*/
    	}
    	#onepage-edition-tools hr{
    		float: left;
			width: 100%;
    	}

    	#onepage-edition-tools #static-head-tools{
    		position: fixed;
    		top:0px;
    		margin-left:-15px;
    		margin-right: -15px;
    		margin-bottom: 10px;
    		padding:80px 15px 10px 15px !important;
    		width:39%;
    		z-index:5;
    		background-color: white;
    		-webkit-box-shadow: -2px 0px 5px -1px rgba(0,0,0,0.5);
			-moz-box-shadow: -2px 0px 5px -1px rgba(0,0,0,0.5);
			box-shadow: -2px 0px 5px -1px rgba(0,0,0,0.5);
    	}
    	.edit-section-title{
    		font-size: 20px;
    		text-transform: uppercase;
    		margin-top: 55px !important;
    		font-weight: 800;
    		border: none;
    	}

    	.btn-edit-section,
    	.btn-show-section,
    	.btn-hide-section{
    		margin-top:-25px;
    	}
    	#onepage-edition-tools{
    		width:40%;
    		position: fixed;
    		top:0px;
    		right: 0px;
    		height:100%;
    		max-height: 100%;
			overflow-y: auto;
    		background-color:white;
    		z-index:3;
    		padding:85px 15px 10px 15px;
    		display:none;
    	}

    	#btn-bgcolor-section,
    	#btn-bgcolor-section,
    	#btn-txtcolor-section{
    		width:50px;
    		height:50px;
    		border: 1px solid lightgrey!important;
    	}
    	.btn-bgcolor-section.bg-white,
    	.btn-bgimg-section.bg-white,
    	.btn-txtcolor-section.bg-white{
    		border: 3px solid lightgrey;
    	}
    	.btn-bgcolor-section,
    	.btn-bgimg-section,
    	.btn-txtcolor-section{
    		height:40px;
    		border-radius:0px; 
    		border: 3px solid transparent;
    	}
    	.btn-bgimg-section{
    		height:100px;
    		overflow: hidden;
    		border:3px solid white;
    	}
    	.btn-bgcolor-section.active,
    	.btn-bgimg-section.active,
    	.btn-txtcolor-section.active{
    		border: 3px solid black;
    	}
    </style>

    <?php 
    	$colors = array(
    				"ed5564", "d9434e", 
    				"ed5f55", "d94c43", 
    				"f87f52", "e7663f", 
    				"fab153", "f49a42",

    				"fcce54", "f5ba42", 
    				"c2d468", "b0c151", 
    				"98d367", "82c250", 
    				"42cb6f", "3bb85d",

    				"47cec0", "3bbeb0",
    				"4ec2e7", "3bb1d9",
    				"5c9ded", "4a8bdb",
    				"9398ec", "7277d5",
    				
    				"cb93ec", "b377d9",
    				"ec87bf", "d870ad",
    				"f1f2f6", "e2e3e7",
    				"c7cbd4", "a5adb8",
    			);

    ?>

    <div class="hidden-xs shadow-left" id="onepage-edition-tools">

    	<div class="col-md-12 col-sm-12 no-padding" id="static-head-tools">
	    	<h5 class="pull-left"><i class="fa fa-angle-down"></i> <i class="fa fa-cogs"></i> Editer la section</h5>
	    	<button class="btn btn-danger pull-right margin-left-5 btn-close-edition-tools"><i class="fa fa-times"></i></button>
	    	<button class="btn btn-success pull-right btn-save-edition-tools"><i class="fa fa-save"></i> Enregistrer</button>
	    </div>

    	<div class="col-md-12 col-sm-12 no-padding margin-bottom-10">
    		<i class="fa fa-pencil letter-blue"></i> <input type="text" class="margin-top-5 edit-section-title font-montserrat">
			<hr class="margin-bottom-5 margin-top-5">
		</div>

	    <div class="col-md-12 col-sm-12 no-padding">
	    	<div class="col-md-12 col-sm-12 no-padding">
		    	<button class="btn btn-default padding-20 pull-left" id="btn-txtcolor-section"></button> 
		    	<h4 class="pull-left margin-left-10"><i class="fa fa-angle-down"></i> Couleur du text</h4>
		    	<div class="col-md-12 col-sm-12 no-padding margin-top-15">
		   			<button class="btn btn-default padding-20 btn-txtcolor-section bg-white col-md-6 col-sm-6 bg-white" data-type="light"></button>
		    		<button class="btn btn-default padding-20 btn-txtcolor-section bg-dark col-md-6 col-sm-6" data-type="dark"></button>

	    			<input type="text" id="text-color" class="pull-right margin-top-10">
		    	</div>
		    </div>
		    <br><hr>
	    </div>	

	    <div class="col-md-12 col-sm-12 no-padding margin-top-15">
		    <div class="col-md-12 col-sm-12 no-padding">
		    	<button class="btn btn-default padding-20 pull-left" id="btn-bgcolor-section"></button> 
		    	<h4 class="pull-left margin-left-10"><i class="fa fa-angle-down"></i> Couleur de fond</h4>
		    	<button class="btn btn-default padding-20 btn-bgcolor-section bg-white pull-right bg-white" data-hex="FFF"></button>
		    	<button class="btn btn-default padding-20 btn-bgcolor-section bg-dark  pull-right" data-hex="333"></button>
		    </div>	
		    <div class="col-md-12 col-sm-12 no-padding margin-top-10">
		   		<?php $class="left";
		    		  foreach ($colors as $i => $hex) {
		    	?>
		    		<?php if($i%2!=1 && $i>0) echo "</div>"; ?>
		    		<?php if($i%2!=1) echo "<div class='col-md-3 col-sm-3 no-padding'>"; ?>
		    			<button class="btn btn-default padding-20 btn-bgcolor-section col-md-6 col-sm-6 no-padding" 
		    					data-hex="<?php echo $hex; ?>" 
		    					style="background-color:#<?php echo $hex; ?>;">
		    			</button>
		    		
		    	<?php } ?>

	    		<input type="text" id="background-color" class="pull-right margin-top-10">
	    	</div>

	    	<br><hr>
	    </div>

	    <?php 
	    	$imgSections = array(array("title"=>"Minimal",
	    							   "folder"=>"white",
	    							   "repeat"=>false),

	    						array("title"=>"Abstraits",
	    							   "folder"=>"abstract",
	    							   "repeat"=>false),

	    						array("title"=>"Texture",
	    							   "folder"=>"pattern",
	    							   "repeat"=>true),
	    						);
	    ?>
	    
	    <div class="col-md-12 col-sm-12 no-padding margin-top-15">
		    <div class="col-md-12 col-sm-12 no-padding">
		    	<h4 class="pull-left margin-left-10"><i class="fa fa-angle-down"></i> Image de fond</h4>
		    </div>	
		    <?php foreach ($imgSections as $i => $sec) { ?>	    
			    <div class="col-md-12 col-sm-12 no-padding margin-top-10">
			    	<h5><?php echo $sec["title"]; ?></h5>
				   	<?php 
				   		$path = $sec["folder"]."/";
				   		$path = ".".substr(Yii::app()->theme->baseUrl.'/assets/img/background-onepage/'.$path, 3);
				   		if(file_exists ( $path )){
				          $files = glob($path.'*.{jpg,jpeg,png}', GLOB_BRACE);
				        }
				    ?>
			    	<?php
			    		 if(isset($files))
			    		 foreach ($files as $i => $img) { 
			    		 $dataUrl = explode( "/", $img); //var_dump($dataUrl);
			    		 $dataUrl = $dataUrl[6] . "/" . $dataUrl[7];
			    		 //var_dump($dataUrl);
			    	?>
			    			<button class="btn btn-default col-md-4 col-sm-4 btn-bgimg-section padding-5"
			    			data-repeat="<?php echo $sec["repeat"] ? "true" : "false"; ?>"
			    			data-url="<?php echo $dataUrl; ?>"
	    					style="background-image:url('<?php echo $img; ?>'); 
	    					 <?php if($sec["repeat"]) echo "background-repeat:repeat;"; 
	    					 	   else echo "background-size: cover;"; 
	    					 ?>"
			    					>
			    			</button>
			    	<?php } ?>
		    	</div>
			<?php } ?>
	    	<input type="text" id="background-img" class="pull-right margin-top-10">
	    	<br><hr>
	    </div>

	    
    </div>

<div class="scroll-top page-scroll">
    <a class="btn btn-primary" href="#page-top">
        <i class="fa fa-chevron-up"></i>
    </a>
</div>

    <script type="text/javascript" >
    var typeEl = "<?php echo $type; ?>";
    var idEl = "<?php echo $id; ?>";
    var currentIdSection = "";
    var onepageEdition = <?php echo @$element["onepageEdition"] ? json_encode(@$element["onepageEdition"]) : "{}" ?>;
    var urlImgBg = "<?php echo substr(Yii::app()->theme->baseUrl.'/assets/img/background-onepage/', 3); ?>";

	jQuery(document).ready(function() { 

		initOnepage(onepageEdition);

		$(".btn-save-edition-tools").click(function(){
			
			onepageEdition[currentIdSection]["text-color"] = $("#text-color").val();
			onepageEdition[currentIdSection]["background-color"] = $("#background-color").val();
			onepageEdition[currentIdSection]["background-img"] = $("#background-img").val();
			onepageEdition[currentIdSection]["title"] = $(".edit-section-title").val();

			//console.log("on save onepageEdition", onepageEdition);
			var idSection = currentIdSection.substr(1, currentIdSection.length);
			//console.log("idSection", idSection);
			updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);

			hideEditionTools(false);
		});

		$(".btn-close-edition-tools").click(function(){
			hideEditionTools(true);
		});

		$(".btn-edit-section").click(function(){ 
			var key = $(this).data("id");
			showEditionTools(key);
		});

		$(".btn-hide-section").click(function(){ 
			var key = $(this).data("id");
			onepageEdition[key]["hidden"] = true;

			updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
			
			$("section"+key+" .btn-hide-section").addClass("active");
			$("section"+key+" .btn-show-section").removeClass("active");

			$("section"+key+" .badge-info-section").html(
				'<small class="badge letter-blue bg-white margin-right-15">'+
        			'<i class="fa fa-ban"></i> '+
        			'Cette section n\'est pas visible pour les visiteurs de votre page'+
   				'</small>');
		});

		$(".btn-show-section").click(function(){ 
			var key = $(this).data("id");
			onepageEdition[key]["hidden"] = false;

			updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
			
			$("section"+key+" .btn-show-section").addClass("active");
			$("section"+key+" .btn-hide-section").removeClass("active");

			$("section"+key+" .badge-info-section").html("");
		});



		$(".edit-section-title").keyup(function(){
			var newTitle = $(".edit-section-title").val();
			console.log("onchange title section", newTitle, "changing value", "section"+currentIdSection+" .sec-title");
			$("section"+currentIdSection+" .sec-title").html(newTitle);
		})


		/* COLOR PICKER */

		/* BGCOLOR PICKER */
		$('#onepage-edition-tools .btn-bgcolor-section').click(function(){
			$('#onepage-edition-tools .btn-bgcolor-section').removeClass("active");
			$(this).addClass("active");
				var hex = $(this).data("hex");
				$("input#background-color").val("#"+hex);
				$("input#background-img").val("");
				$("#onepage-edition-tools #btn-bgcolor-section").css("backgroundColor", "#"+hex);

				$("section"+currentIdSection).css("backgroundImage", 'url()');
				$("section"+currentIdSection).css("backgroundColor", "#"+hex);
		});

		$('#onepage-edition-tools #btn-bgcolor-section').off().ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).ColorPickerHide();
				console.log("onSubmit colorpicker");
			},
			onChange: function(hsb, hex, rgb, el) {
				$("input#background-img").val("");
				$("input#background-color").val("#"+hex);
				$("#onepage-edition-tools #btn-bgcolor-section").css("backgroundColor", "#"+hex);
				$("section"+currentIdSection).css("backgroundColor", "#"+hex);
				$('#onepage-edition-tools .btn-bgcolor-section').removeClass("active");
			},
			onBeforeShow: function () {
				var rgb = $(this).css("backgroundColor");
				var color = rgbToHex(rgb)
				$(this).ColorPickerSetColor(color);
				$("section"+currentIdSection).css("background", 'url("")!important');
				
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
				console.log("keyup colorpicker");
		});
		/* BGCOLOR PICKER */


		/* TXTCOLOR PICKER */
		$('#onepage-edition-tools .btn-txtcolor-section').click(function(){
			$('#onepage-edition-tools .btn-txtcolor-section').removeClass("active");
			$(this).addClass("active");
			var type = $(this).data("type");
			$("input#text-color").val(type);
			$("section"+currentIdSection).removeClass('dark').removeClass('light').addClass(type);
			unsetTxtColorSection();

			$("#onepage-edition-tools #btn-txtcolor-section").css("backgroundColor", $(this).css("backgroundColor"));
		});

		$('#onepage-edition-tools #btn-txtcolor-section').off().ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				//$(el).val(hex);
				//$(el).ColorPickerHide();
				//console.log("onSubmit colorpicker");
			},
			onChange: function(hsb, hex, rgb, el) {
				$("input#text-color").val("#"+hex);
				$("#onepage-edition-tools #btn-txtcolor-section").css("backgroundColor", "#"+hex);

				setTxtColorSection(hex);

				$('#onepage-edition-tools .btn-txtcolor-section').removeClass("active");
			},
			onBeforeShow: function () {
				var rgb = $(this).css("backgroundColor");
				var color = rgbToHex(rgb);
				$(this).ColorPickerSetColor(color);
				console.log("onBeforeShow colorpicker", color);
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
				console.log("keyup colorpicker");
		});
		/* TXTCOLOR PICKER */

		/* BGIMG PICKER */
		$('#onepage-edition-tools .btn-bgimg-section').click(function(){
			$('#onepage-edition-tools .btn-bgimg-section').removeClass("active");
			$(this).addClass("active");
			//var type = $(this).data("type");
			//$("input#text-color").val(type);
			
			var url = urlImgBg+$(this).data("url");
			var repeat = $(this).data("repeat");

			console.log("repeat", repeat);

			$("section"+currentIdSection).css('backgroundImage', "url('"+url+"')");

			if(repeat==true){
				$("section"+currentIdSection).css('backgroundRepeat', "repeat");
				$("section"+currentIdSection).css('backgroundSize', "unset");	
			} 
			else {
			 	$("section"+currentIdSection).css('backgroundRepeat', "no-repeat");
				$("section"+currentIdSection).css('backgroundSize', "cover");	
			}

			$("#background-color").val("");
			$("#background-img").val($(this).data("url"));
		});
		/* BGIMG PICKER */
		
		$('.edit-section-title').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'}); //[a-zA-Z0-9_] 
		
	});

	function initOnepage(onepageEdition){
		$.each(onepageEdition, function(section, options){
			console.log("initOnePage", section, options);
			if(typeof options["background-img"] != "undefined" && options["background-img"] != ""){
				$("section"+section).css('backgroundImage', "url('"+urlImgBg+options["background-img"]+"')");
				if(options["background-img"].indexOf("pattern") >= 0){
					console.log("repeat", true),
					$("section"+section).css('backgroundRepeat', "repeat");
					$("section"+section).css('backgroundSize', "unset");	
				} 
				else {
					console.log("repeat", false),
				 	$("section"+section).css('backgroundRepeat', "no-repeat");
					$("section"+section).css('backgroundSize', "cover");	
				}
			}

			if(typeof options["background-color"] != "undefined" && options["background-color"] != "")
				$("section"+section).css("backgroundColor", "#"+options["background-color"]);

			if(typeof options["text-color"] != "undefined" && options["text-color"] != ""){
				if(options["text-color"] == "light" || options["text-color"] == "dark"){
					$("section"+section).removeClass('dark').removeClass('light').addClass(options["text-color"]);
				}else{
					currentIdSection = section;
					setTxtColorSection(options["text-color"]);
				}
			}

			if(typeof options["title"] != "undefined" && options["title"] != ""){
				$("section"+section+" .sec-title").html(options["title"]);
			}

		});
    
	}

	function setTxtColorSection(hex){
		$(	"section"+currentIdSection+ " .item-name, "+
			"section"+currentIdSection+ " .item-date, "+
			"section"+currentIdSection+ " .item-desc, "+
			"section"+currentIdSection+ " .section-title, "+
			"section"+currentIdSection
			).css("color", "#"+hex);
	}
	function unsetTxtColorSection(){
		$(	"section"+currentIdSection+ " .item-name, "+
			"section"+currentIdSection+ " .item-date, "+
			"section"+currentIdSection+ " .item-desc, "+
			"section"+currentIdSection+ " .section-title, "+
			"section"+currentIdSection
			).css("color", "");
	}



	var initBgColor = "";
	var initTxtColor = "";
	var initType = "";
	function showEditionTools(idSection){
		currentIdSection = idSection;
		$("#onepage-edition-tools").show(300);
		var title = $(idSection+" .section-title .sec-title").html();
		if(currentIdSection == "#header") title = "EN-TÊTE";
		$("#onepage-edition-tools .edit-section-title").val(title);
		KScrollTo("section"+idSection);

		var rgb = $("section"+currentIdSection).css("backgroundColor");
		initBgColor = rgbToHex(rgb);
		$("#onepage-edition-tools #btn-bgcolor-section").css("backgroundColor", "#"+initBgColor);
		
		var rgb = $("section"+currentIdSection+ " .item-name").css("color");
		initTxtColor = rgbToHex(rgb);
		$("#onepage-edition-tools #btn-txtcolor-section").css("backgroundColor", "#"+initTxtColor);
				console.log("showEditionTools colorpicker", initTxtColor);

		initType = $("section"+currentIdSection).hasClass("light") ? "light" : "";
		if(initType == "") initType = $("section"+currentIdSection).hasClass("dark") ? "dark" : "";
		//$('#onepage-edition-tools input#background-color').val("#000");
		
		$("#text-color").val(onepageEdition[currentIdSection]["text-color"]);
		$("#background-color").val(onepageEdition[currentIdSection]["background-color"]);
		$("#background-img").val(onepageEdition[currentIdSection]["background-img"]);

		console.log("show section edit ", idSection);
	}

	function  hideEditionTools(cancel){
		$("#onepage-edition-tools").hide(300);

		if(cancel){
			$(	"section"+currentIdSection+ " .item-name, "+
					"section"+currentIdSection+ " .item-desc, "+
					"section"+currentIdSection+ " .section-title"
					).css("color", "#"+initTxtColor);

			$("section"+currentIdSection).css("backgroundColor", "#"+initBgColor);

			$("section"+currentIdSection).removeClass('dark').removeClass('light').addClass(initType);
		}
	}


	function componentFromStr(numStr, percent) {
	    var num = Math.max(0, parseInt(numStr, 10));
	    return percent ?
	        Math.floor(255 * Math.min(100, num) / 100) : Math.min(255, num);
	}

	function rgbToHex(rgb) {
	    var rgbRegex = /^rgb\(\s*(-?\d+)(%?)\s*,\s*(-?\d+)(%?)\s*,\s*(-?\d+)(%?)\s*\)$/;
	    var result, r, g, b, hex = "";
	    if ( (result = rgbRegex.exec(rgb)) ) {
	        r = componentFromStr(result[1], result[2]);
	        g = componentFromStr(result[3], result[4]);
	        b = componentFromStr(result[5], result[6]);

	        hex = (0x1000000 + (r << 16) + (g << 8) + b).toString(16).slice(1);
	    }
	    return hex;
	}

    </script>