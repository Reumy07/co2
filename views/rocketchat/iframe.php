<?php if ( !@$iframeOnly ){ ?>
<!DOCTYPE html>
<html>
	<body>
<?php } ?>

<?php 
if ( @Yii::app()->session["userId"] ){ 
$embedPath = (@$embed) ? $path."?layout=embedded" : "" ;
?>

	
<script type="text/javascript">
	window.addEventListener('message', function(e) {
	    console.info(">>>>>>>>>> ifroame ", e.data.eventName); // event name
	    console.log(e.data.data); // event data

		if(e.data.eventName=="startup" && e.data.data== true){

			toastr.info("startup Rocket Chat");

			document.querySelector('iframe').contentWindow.postMessage({
			  externalCommand: 'login-with-token',
			  token: '<?php echo Yii::app()->session["loginToken"]; ?>' }, '*');

			<?php if ( @$path ) { ?>
				document.querySelector('iframe').contentWindow.postMessage({
				  externalCommand: 'go',
				  path: '<?php echo $path ?>'}, '*');
			<?php } ?>

		} 
		
		//fired on direct conversation or when pinged in a channel
		if(e.data.eventName=="notification" ){
			console.info("xxxxxxxxxxxxxx NOTIFICATION ", e.data.eventName,e.data.data);
			toastr.info("notification received");	
		} 

		if(e.data.eventName=="new-message" ){
			console.info("xxxxxxxxxxxxxx NEW MSG ", e.data.eventName,e.data.data);
			toastr.info("new-message");
		} 


		if(e.data.eventName=="unread-changed" ){
			console.info("xxxxxxxxxxxxxx UNREAD ","<?php echo Yii::app()->session["loginToken"]; ?>", e.data.eventName,e.data.data);
			toastr.info("unread-changed :: "+e.data.data);
			
			if(e.data.data)
				 $(".chatNotifs").html(e.data.data);
			else {
				//can be when messages arrives, like notifiactions
				//or disconnect so forcing reconnect
				alert("unread-changed :: relogin");
				setTimeout(function(){
					document.querySelector('iframe').contentWindow.postMessage({
					  externalCommand: 'login-with-token',
					  token: '<?php echo Yii::app()->session["loginToken"]; ?>' }, '*');
				}, 500);
			}

		}

		if( typeof e.data.eventName == "undefined" ){
				document.querySelector('iframe').contentWindow.postMessage({
					  externalCommand: 'login-with-token',
					  token: '<?php echo Yii::app()->session["loginToken"]; ?>' }, '*');
		}

		//away
		//online
		if(e.data.eventName=="status-changed"){
			console.info("xxxxxxxxxxxxxx STATUS CHANGED ", e.data.eventName,e.data.data);
			toastr.error("status changed : "+e.data.data);	
		}

		if(e.data.eventName=="unread-changed-by-subscription" && ( e.data.data.name == contextData.type+"_"+slugify(contextData.name) || e.data.data.name == contextData.username )  ){
			//console.info("xxxxxxxxxxxxxx unread-changed-by-subscription ", e.data.eventName,e.data.data);
			//alert("unread-changed-by-subscription",e.data.data.unread);
			$(".elChatNotifs").html( (e.data.data.unread > 0) ?  e.data.data.unread : ""  );	
		}
		
	});
</script>
<style>
	.iframe-rocketchat{
		overflow:hidden;
		overflow-x:hidden;
		overflow-y:hidden;
		height:100%;
		width:100%;
		position:absolute;
		top:0px;
		left:0px;
		right:0px;
		bottom:0px;
	}
</style>

<iframe id="rc" src="https://chat.communecter.org<?php echo $embedPath ?>" 
		frameborder="0" class="iframe-rocketchat">
</iframe>

<?php 
} else 
	echo Yii::t('common',"Access denied") ?>

<?php if ( !@$iframeOnly ){ ?>
	</body>
</html>
<?php } ?>