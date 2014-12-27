<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

  <table class="table">
  
  <tr><td class="active"><b>Выбор схемы</b></td>
  
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
 
 
 

<?php if (!empty($aSecGrouppics))
{
    $this->breadcrumbs = array(
	$sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog), 
	$sModelName.'('.$sModelSeries.')'=>array('site/modelcodes', 'catalog'=>$sCatalog,  'modelSeries'=>$sModelSeries, 'modelName'=>$sModelName
        ),
        $pos=>array('site/modelcodes', 'catalog'=>$sCatalog,  'modelSeries'=>$sModelSeries, 'modelName'=>$sModelName, 'pos'=>$pos),
		$sDesc_ru=>array('site/secgroups', 'catalog'=>$sCatalog,  'modelSeries'=>$sModelSeries, 'modelName'=>$sModelName, 'desc_ru'=>$sDesc_ru, 'pos'=>$pos, 'IdPriGroup'=>$IdPriGroup, 'ModelDir'=>$ModelDir, 'NumSecGrPic'=>$NumSecGrPic),
		$sDesc_en);
		


$i=1;		
		
   echo '<div class="row">';
   foreach($aSecGrouppics as $aSecGrouppic)
   {
   

   {
   	echo ' <div class="col-md-6">';
   	$width = Yii::app()->params['imageWidth'];
        if(file_exists(Yii::app()->basePath. '/../images/'.
            $sCatalog.'/'.$aSecGrouppic['model_dir'].'/'.substr($aSecGrouppic['img_path'], -19)))
			
			
            $size = getimagesize(Yii::app()->basePath . '/../images/' .
            $sCatalog.'/'.$aSecGrouppic['model_dir'].'/'.substr($aSecGrouppic['img_path'], -19));
			

            $k = $size[0]/$size[1];
            $kc = $width/$size[0];
            $height = $width * $k;
			$kc = 0.5;
			if (!$aSecGrouppic['applied_model'])
			$s = $aSecGrouppic['options'];
			else $s = $aSecGrouppic['applied_model'];			

          
            
            echo CHtml::link('Схема '.$i.' из '.count($aSecGrouppics).'</br><b>'. $s.'</b> '.Functions::prodToDate($aSecGrouppic['production_start']) . ' - ' .Functions::prodToDate($aSecGrouppic['production_end']).'</br>'. CHtml::image(
                Yii::app()->request->baseUrl.'/images/'.
            $sCatalog.'/'.$aSecGrouppic['model_dir'].'/'.substr($aSecGrouppic['img_path'], -19),
                
				$aSecGrouppic['sec_group'], array("width"=>$width*5/8)),
				array(
                'site/parts',
                'catalog'=>$sCatalog,
                'modelSeries'=>$sModelSeries,
				'modelName'=>$sModelName,
				'sDesc_ru'=>$sDesc_ru,
				'pos'=>$pos,
				'IdPriGroup'=>$IdPriGroup,
				'IdSecGroup'=>$IdSecGroup,
				'sDesc_en'=>$sDesc_en,
				'PicNum'=>$aSecGrouppic['pic_num'],
				'ModelDir'=>$aSecGrouppic['model_dir'],
				'PartCode'=>$PartCode,
				'NumSecGrPic'=>$NumSecGrPic)).'';
				$i++;
				echo '</div>';
	}}
	echo ' </div>';
	
}
?>










