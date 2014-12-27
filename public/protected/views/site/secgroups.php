<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

  <table class="table">
  
  <tr><td class="active"><b>Выбор подгруппы запчастей</b></td>
  
  </tr>
  </table>
 <?php if (isset($_COOKIE["diff"])&(isset($_COOKIE["compl"]))) 

 {
 	echo '<div class="bg-info">
<b>Комплектация автомобиля</b></br></br>';
 
 
 

 	$Diff = $_COOKIE["diff"];
	$Compl = $_COOKIE["compl"];
	
 	foreach ($Diff as $name => $value)
	{
	echo '<b>'.$value. ':</b> '.$Compl[$name].'</br>';	
	}
 	
 

 echo '</div>'; 
 }
  ?>
  
 
<div class="row">
<?php if (!empty($aSecGroups))
{
    $this->breadcrumbs = array(
	$sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog), 
	$sModelName.'('.$sModelSeries.')'=>array('site/modelcodes', 'catalog'=>$sCatalog,  'modelSeries'=>$sModelSeries, 'modelName'=>$sModelName
        ),
        $pos=>array('site/modelcodes', 'catalog'=>$sCatalog,  'modelSeries'=>$sModelSeries, 'modelName'=>$sModelName, 'pos'=>$pos)			,
		$sDesc_ru);
		



	$width = Yii::app()->params['imageWidth'];
        if(file_exists(Yii::app()->basePath. '/../images/'.
            $sCatalog.'/'.$ModelDir.'/grpimg.'.$ModelDir.'.'.'00'.$NumSecGrPic.'.png'))
			
			{
				
				$size = getimagesize(Yii::app()->basePath. '/../images/'.
            $sCatalog.'/'.$ModelDir.'/grpimg.'.$ModelDir.'.'.'00'.$NumSecGrPic.'.png');

            $k = $size[0]/$size[1];
            $kc = $width/$size[0];
            $height = $width * $k;
			$kc = 0.5;          
            
            echo CHtml::image(
                Yii::app()->request->baseUrl.'/images/'.
            $sCatalog.'/'.$ModelDir.'/grpimg.'.$ModelDir.'.'.'00'.$NumSecGrPic.'.png', $IdPriGroup,  
			array("usemap"=>'#'. $IdPriGroup), array("width"=>$width));	
		
			}
		
 
  
 
 	echo '<map name='. $IdPriGroup.'>';  
   foreach($aSecGroups as $aSecGroup)
   {
   	echo '<area shape="rect" coords="'.$aSecGroup['x']*$kc.','.$aSecGroup['y']*$kc.','.($aSecGroup['x']+60)*$kc.','.($aSecGroup['y']+40)*$kc.'"
                href="'.Yii::app()->createUrl('site/secgrouppics', array(
                'catalog'=>$sCatalog,
                'modelSeries'=>$sModelSeries,
				'modelName'=>$sModelName,
				'sDesc_ru'=>$sDesc_ru,
				'pos'=>$pos,
				'IdPriGroup'=>$IdPriGroup,
				'IdSecGroup'=>$aSecGroup['Id'],
				'sDesc_en'=>$aSecGroup['desc_en'],
				'ModelDir'=>$ModelDir,
				'PartCode' =>'',
				'NumSecGrPic'=>$NumSecGrPic
				
				)).'" id="area'.$aSecGroup['Id'].'" data-name="area'.$aSecGroup['Id'].'">';
   }
   
  $aNew = array ();
  foreach($aSecGroups as $index=>$aSecGroup)
 
   {
   	if (in_array($aSecGroup['desc_en'], $aNew))
	
	unset ($aSecGroups[$index]);
   	
	$aNew[$index] = $aSecGroup['desc_en'];
    }
 
   foreach($aSecGroups as $aSecGroup)
		{
			
			echo '<div class="col-md-6">';
				echo '<a name=' .$aSecGroup['Id']. '></a><div class="btn-default" id="pncs_' .$aSecGroup['Id'].'">' .CHtml::link($aSecGroup['Id'].'. '.$aSecGroup['desc_en'],array(
                'site/secgrouppics',
                'catalog'=>$sCatalog,
                'modelSeries'=>$sModelSeries,
				'modelName'=>$sModelName,
				'sDesc_ru'=>$sDesc_ru,
				'pos'=>$pos,
				'IdPriGroup'=>$IdPriGroup,
				'IdSecGroup'=>$aSecGroup['Id'],
				'sDesc_en'=>$aSecGroup['desc_en'],
				'ModelDir'=>$ModelDir,
				'PartCode' =>'',
				'NumSecGrPic'=>$NumSecGrPic)).'<br/>'. '</div>';
        	
	    	 echo '
                    <script>
                        $("#pncs_'.$aSecGroup['Id'].'").on("mouseover", function(){
                            $(this).css("cursor", "pointer");
                        });
                        $("#pncs_'.$aSecGroup['Id'].'").on("click", function(){
                            $("#'.$aSecGroup['Id'].'").toggleClass("hidden");
                            
                            $(this).toggleClass("btn-success");
                        });
                   
                        $("area#area'.$aSecGroup['Id'].'").on("mouseover", function(){

                            $("#pncs_'.$aSecGroup['Id'].'").addClass("btn-info");
                        });
                        $("area#area'.$aSecGroup['Id'].'").on("mouseout", function(){
                            $("#pncs_'.$aSecGroup['Id'].'").removeClass("btn-info");
                        });
                    </script>
                    ';
			echo '</div>';	
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








