<?php 

    $nbMax = @$nbMax ? $nbMax : 12;

    $imgDefault = $this->module->assetsUrl.'/images/news/profile_default_l.png';

    $nbItem = sizeof($items);
    $col = "col-sm-2 col-xs-4";

    if($nbItem == 1) $col = "col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12";
    if(@$fullWidth && @$fullWidth == true) $col = "col-md-12";

    if($nbItem == 2) $col = "col-sm-6";
    if($nbItem == 3) $col = "col-sm-4 col-xs-4";
    if($nbItem == 4) $col = "col-sm-3 col-xs-3";
    if($nbItem == 5) $col = "col-sm-2 col-xs-4";
    if($nbItem == 6) $col = "col-sm-2 col-xs-4";
    if($nbItem >  6) $col = "col-sm-1 col-xs-4";

    $align = $nbItem > 2 && $imgShape == "square" ? "left" : "center";
    $align = "center";
    //$textBright = @$styleParams["textBright"] ? @$styleParams["textBright"] : "light";

?>

<style>

        <?php if($nbItem >=  8){ ?>
        #onepage section#<?php echo @$sectionKey; ?> .portfolio-item .item-name,
        #onepage section#<?php echo @$sectionKey; ?> .portfolio-item .item-desc,
        #onepage section#<?php echo @$sectionKey; ?> .portfolio-item .item-address{
            font-size:0.9em;
        }
        <?php } ?>
</style>



<section id="<?php echo @$sectionKey; ?>" 
         class="portfolio <?php if(@$sectionShadow==true) echo 'shadow'; ?>">
    
    <?php if(@$edit==true){ ?>
    <button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-edit-section" 
            data-id="#<?php echo @$sectionKey; ?>">
            <i class="fa fa-cog"></i>
    </button>
    <?php } ?>

    <div class="container">

        <?php if(@$sectionTitle != ""){ ?>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-title">
                    <span class="sec-title"><?php echo $sectionTitle; ?></span> 
                    <?php if(@count($items) >= 2) echo "<small>(".@count($items).")</small>"; ?>
                    <br>
                    <i class="fa fa-angle-down"></i>
                </h2>
            </div>
        </div>
        <?php } ?>

        <div class="row">
    	<?php $cnt=0; 
    		foreach ($items as $key => $item) { $cnt++; 
    		  	if($cnt<=$nbMax){
                    
                    //récupération du type de l'element
                    $typeItem = (@$item["typeSig"] && $item["typeSig"] != "") ? $item["typeSig"] : "";
                    if($typeItem == "") $typeItem = @$item["type"] ? $item["type"] : "item";
                    if($typeItem == "people") $typeItem = "citoyens";

                    //icon et couleur de l'element
                    $icon = Element::getFaIcon($typeItem) ? Element::getFaIcon($typeItem) : "";
                    $iconColor = Element::getColorIcon($typeItem) ? Element::getColorIcon($typeItem) : "";
    	?>
    		<div class="<?php echo $col; ?> portfolio-item text-<?php echo $align; ?>">

                <?php if($typeItem != "item"){ ?>
                <a href="<?php echo Element::getHash($item); ?>" class="portfolio-link" data-toggle="modal">
                <?php }else{ ?>
                <div class="">
                <?php } ?>
                    <!-- <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-search-plus fa-3x"></i>
                        </div>
                    </div> -->
                    <?php if(!isset($useImg) || @$useImg == true){ 
                        $img =  @$item['profilThumbImageUrl'] ? 
                                Yii::app()->createUrl('/'.@$item['profilThumbImageUrl']) : 
                                $imgDefault;
                    ?>
                        <img src="<?php echo $img; ?>" 
                        	 class="img-responsive thumbnail img-<?php echo $imgShape; ?> 
                                    <?php if(@$useBorderElement==true){ ?>
                                            thumb-type-color-<?php echo $iconColor; ?><?php } ?> inline"
                             width=80 height=80 alt=""><br>
                    <?php } ?>

                    <?php if(@$useBorderElement==true && $icon != "" && $iconColor != ""){ ?>
                        <div class="col-md-12 col-sm-12 no-padding text-center i-item">
                            <i class="fa fa-<?php echo $icon; ?> i-type-color-<?php echo $iconColor; ?>"></i>
                        </div>
                    <?php } ?>

                    <?php if(@$item['startDate']){ ?>
                        <div class="col-md-12 col-sm-12 no-padding text-center bold item-date">
                            <h5><?php echo Translate::pastTime(@$item['startDate'], "date"); ?></h5>
                        </div>
                    <?php } ?>

                    <div class="col-md-12 col-sm-12 no-padding item-name"><?php echo @$item['name']; ?></div>

                    <?php if($nbItem <= $nbMax){ ?>
                        <div class="col-md-12 col-sm-12 no-padding item-address text-red">
                            <?php  echo @$item['address']['addressLocality'] ?  
                                        '<i class="fa fa-map-marker"></i> '.$item['address']['addressLocality'] : ""; 
                                  echo @$item['address']['streetAddress'] ?  
                                        ' '.$item['address']['streetAddress'] : ""; 

                            ?>
                        </div>
                        </a>
                    <?php } ?>

                    <?php if($nbItem <= 4 && (!isset($useDesc) || @$useDesc == true)){ ?>
                        <div class="col-md-12 col-sm-12 no-padding item-desc  <?php if(@$fullWidth && @$fullWidth == true) echo "text-left"; ?>">
                            <?php echo @$item['shortDescription'] ? @$item['shortDescription'] :
                                        "<span class='padding-10'><center><i>- Pas de présentation -</center></i></span>"; ?>
                            
                        </div>
                        <?php if($sectionKey == "description" && @$item['shortDescription']){ ?>
                            <div class="col-xs-12 margin-top-15 no-padding text-center">
                                 <button class="btn btn-default btn-full-desc" data-sectionkey="<?php echo @$sectionKey; ?>">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                        <?php } ?>
                    <?php } ?>

                <?php if($typeItem != "item"){ ?>
                </a> <?php }else{ ?> </div> <?php } ?>

            </div>
    	<?php }} ?>

    	<?php if($cnt == 0){ ?>
    		<h5 class="text-light text-center"><?php echo $msgNoItem; ?></h5>
    	<?php } ?>

        </div>
        
    </div>
</section>

<script type="text/javascript" >
    
    jQuery(document).ready(function() {
    });
    
</script>