<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

  <table class="table">
  
  <tr><td class="active"><b>Выбор группы запчастей</b></td>
  
  </tr>
  </table>
  
 
 <div class="bg-info">
  
 <b>Комплектация автомобиля</b></br></br>
  <?php 
 
 if (isset($_COOKIE["diff"])&(isset($_COOKIE["compl"])))
 {
 	$Diff = $_COOKIE["diff"];
	$Compl = $_COOKIE["compl"];
	
 	foreach ($Diff as $name => $value)
	{
	echo '<b>'.$value. '</b>: '.$Compl[$name].'</br>';	
	}
 	
 }
 ?> 
 </div> 
  
 
 
  



<div class="row">

<?php if (!empty($aPriGroupPics))
{
    $this->breadcrumbs = array(
	$sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog), 
	$sModelName.'('.$sModelSeries.')'=>array('site/modelcodes', 'catalog'=>$sCatalog,  'modelSeries'=>$sModelSeries, 'modelName'=>$sModelName
        ),
        $pos);
		
		
		
		 
		  
			
			
		
				
		 foreach($aPriGroupPics as $aPriGroupPic)
			{
		 			
			
				$width = Yii::app()->params['imageWidth'];
        if(file_exists(Yii::app()->basePath. '/../images/'.
            $sCatalog.'/'.$aPriGroupPic['model_dir'].'/'.substr($aPriGroupPic['img_path'], -19)))
			
			{
            $size = getimagesize(Yii::app()->basePath . '/../images/' .
            $sCatalog.'/'.$aPriGroupPic['model_dir'].'/'.substr($aPriGroupPic['img_path'], -19));

            $k = $size[0]/$size[1];
            $kc = $width/$size[0];
            $height = $width * $k;
			$kc = 0.5;

           
            
            echo CHtml::image(
                Yii::app()->request->baseUrl.'/images/'.
            $sCatalog.'/'.$aPriGroupPic['model_dir'].'/'.substr($aPriGroupPic['img_path'], -19),
                
				$aPriGroupPic['pri_group'],
   /*  array("width"=>$width, "usemap"=>'#' . $aPriGroupPic['model_dir']));*/
    array("usemap"=>'#'. $aPriGroupPic['pri_group']));            
           
		echo '<map name='. $aPriGroupPic['pri_group'].'>';
			foreach($aPriGroupCoords as $aPriGroupCoord)
			{		
			echo '<area shape="rect" coords="'.$aPriGroupCoord['label_x']*$kc.','.$aPriGroupCoord['label_y']*$kc.','.($aPriGroupCoord['label_x']+60)*$kc.','.($aPriGroupCoord['label_y']+60)*$kc.'"
                href="'.Yii::app()->createUrl('site/secgroups', array(
                'catalog'=>$sCatalog,
                'modelSeries'=>$sModelSeries,
				'modelName'=>$sModelName,
				'desc_ru'=>Functions::getRusDesc($aPriGroupCoord['desc_en']),
				'pos'=>$pos,
				'IdPriGroup'=>$aPriGroupCoord['pri_group'],
				'ModelDir'=>$aPriGroupCoord['model_dir'])).'" id="area'.$aPriGroupCoord['pri_group'].'" data-name="area'.$aPriGroupCoord['pri_group'].'">';
			
			
			}
		echo '</map><br/>';	
		
		
		
         foreach($aPriGroupCoords as $aPriGroupCoord)
		{
			echo '<div class="col-md-6">';
				echo '<a name=' .$aPriGroupCoord['pri_group']. '></a><div class="btn-default" id="pncs_' .$aPriGroupCoord['pri_group'].'">' .CHtml::link($aPriGroupCoord['pri_group'].'. '.Functions::getRusDesc($aPriGroupCoord['desc_en']), 
			array(
                'site/secgroups',
                'catalog'=>$sCatalog,
                'modelSeries'=>$sModelSeries,
				'modelName'=>$sModelName,
				'desc_ru'=>Functions::getRusDesc($aPriGroupCoord['desc_en']),
				'pos'=>$pos,
				'IdPriGroup'=>$aPriGroupCoord['pri_group'],
				'ModelDir'=>$aPriGroupCoord['model_dir'])).'<br/>'. '</div>';
        	
	    	 echo '
                    <script>
                        $("#pncs_'.$aPriGroupCoord['pri_group'].'").on("mouseover", function(){
                            $(this).css("cursor", "pointer");
                        });
                        $("#pncs_'.$aPriGroupCoord['pri_group'].'").on("click", function(){
                            $("#'.$aPriGroupCoord['pri_group'].'").toggleClass("hidden");
                            
                            $(this).toggleClass("btn-success");
                        });
                   
                        $("area#area'.$aPriGroupCoord['pri_group'].'").on("mouseover", function(){

                            $("#pncs_'.$aPriGroupCoord['pri_group'].'").addClass("btn-info");
                        });
                        $("area#area'.$aPriGroupCoord['pri_group'].'").on("mouseout", function(){
                            $("#pncs_'.$aPriGroupCoord['pri_group'].'").removeClass("btn-info");
                        });
                    </script>
                    ';
			echo '</div>';	
			}
		
			
			
 			}
			
		}
																	
}
?>
<script>
	$('img').mapster({
		fillColor: '70daf1',
		fillOpacity: 0.3,
		mapKey: 'data-name',
		clickNavigate: true,
		staticState: true
	});
</script>
</div>








