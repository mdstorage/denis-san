<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

  <table class="table">
  
  <tr><td class="active"><b>Выбор запчасти</b></td>
  
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
 


  
 
 
 
 

<?php 


if (!empty($aPartCoords))
{
    $this->breadcrumbs = array(
	$sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog), 
	$sModelName.'('.$sModelSeries.')'=>array('site/modelcodes', 'catalog'=>$sCatalog,  'modelSeries'=>$sModelSeries, 'modelName'=>$sModelName
        ),
        $pos=>array('site/modelcodes', 'catalog'=>$sCatalog,  'modelSeries'=>$sModelSeries, 'modelName'=>$sModelName, 'pos'=>$pos),
		$sDesc_ru=>array('site/secgroups', 'catalog'=>$sCatalog,  'modelSeries'=>$sModelSeries, 'modelName'=>$sModelName, 'desc_ru'=>$sDesc_ru, 'pos'=>$pos, 'IdPriGroup'=>$IdPriGroup, 'ModelDir'=>$ModelDir),
		$sDesc_en);
		


		
		
   echo '<div class="row">';
   	echo ' <div class="col-md-8">';
   	$width = Yii::app()->params['imageWidth'];
        if(file_exists(Yii::app()->basePath. '/../images/'.
            $sCatalog.'/'.$ModelDir.'/secimg.'.$ModelDir.'.'.$PicNum.'.png'))
			
			
            $size = getimagesize(Yii::app()->basePath . '/../images/'.
            $sCatalog.'/'.$ModelDir.'/secimg.'.$ModelDir.'.'.$PicNum.'.png');

            $k = $size[0]/$size[1];
            $kc = $width/$size[0];
            $height = $width * $k;
			$kc = $kc*0.72;
						

          
            
         echo CHtml::image(
                Yii::app()->request->baseUrl.'/images/'.
            $sCatalog.'/'.$ModelDir.'/secimg.'.$ModelDir.'.'.$PicNum.'.png',
                
				$PicNum, array("width"=>$width, "usemap"=>'#'. $PicNum));
				
				          
           
		echo '<map name='. $PicNum.'>';
			
		
			foreach($aPartCoords as $aPartCoord)
			{
			
			
				$aPartCoord['part_code']= trim($aPartCoord['part_code']); 
				if ((strlen($aPartCoord['part_code'])<10) && (strlen($aPartCoord['part_code'])>3))
				{
					echo '<area shape="rect" coords="'.$aPartCoord['label_x']*$kc.','.$aPartCoord['label_y']*$kc.','.($aPartCoord['label_x']+150)*$kc.','.($aPartCoord['label_y']+50)*$kc.'"
                href="#'.$aPartCoord['part_code'].'" id="area'.$aPartCoord['part_code'].'"data-name="area'.$aPartCoord['part_code'].'"alt="'.$aPartCoord['part_code'].'">';
				}
				else {
					
				
				if (strlen($aPartCoord['part_code'])>3)
				{
				echo '<area shape="rect" coords="'.$aPartCoord['label_x']*$kc.','.$aPartCoord['label_y']*$kc.','.($aPartCoord['label_x']+250)*$kc.','.($aPartCoord['label_y']+50)*$kc.'" title="Стандартная запчасть. Нажмите, чтобы узнать цену"
                href="'.Yii::app()->params['outUrl'].$aPartCoord['part_code'].'"  id="area'.$aPartCoord['part_code'].'"data-name="area'.$aPartCoord['part_code'].'">';	
				}
				}
				if (strlen($aPartCoord['part_code'])==4)
				{
					
				echo '<area shape="rect" coords="'.($aPartCoord['label_x'])*$kc.','.$aPartCoord['label_y']*$kc.','.($aPartCoord['label_x']+50)*$kc.','.($aPartCoord['label_y']+50)*$kc.'"
                href="'.
				Yii::app()->createUrl('site/secgrouppics', array(
                'catalog'=>$sCatalog,
                'modelSeries'=>$sModelSeries,
				'modelName'=>$sModelName,
				'sDesc_ru'=>$sDesc_ru,
				'pos'=>$pos,
				'IdPriGroup'=>$IdPriGroup,
				'IdSecGroup'=>$aPartCoord['part_code'],
				'sDesc_en'=>$sDesc_en,
				'ModelDir'=>$ModelDir,
				'PartCode'=>$PartCode)).
				
				'" id="area'.$aPartCoord['part_code'].'"data-name="area'.$aPartCoord['part_code'].'">';
				}
			
			}
		echo '</map><br/>';	
		echo '</div>';
		echo '<div class="col-md-4">';
		
		
		$aNew = array();
			foreach($aPartCoords as $index=>$aPartCoord)
 
   {
   	if (in_array($aPartCoord['part_code'], $aNew))
	
	unset ($aPartCoords[$index]);
   	
	$aNew[$index] = $aPartCoord['part_code'];
    }
		
		
		
         foreach($aPartCoords as $aPartCoord)
		{
			
			
		$aPartCoord['part_code']= trim($aPartCoord['part_code']); 
		if ((strlen($aPartCoord['part_code'])<10) && (strlen($aPartCoord['part_code'])>3))
		{
			
			
			
					
		 echo '<a name='.$aPartCoord['part_code'].'></a><div class="btn-default" id="pncs_'.$aPartCoord['part_code'].'">'.$aPartCoord['part_code']." ".$aPartCoord['desc_en'] . '</div><br/>';
                echo '<table id="table_'.$aPartCoord['part_code'].'" class="';
				if ($aPartCoord['part_code'] == $PartCode) echo 'table table-striped">';
				else echo 'hidden table table-striped">';
                echo '<thead>
                <td>Код</td>
                <td>Период выпуска</td>
                <td>Описание</td>
                
              </thead><tbody>';
		
			  
			  
             /*  $oPartCatalog = new PartCatalog();
			   $aPartCatalogs =  $oPartCatalog->getPartCatalog($sCatalog, $sModelSeries, $aPartCoord['part_code']);*/
	/*		   $aPartCatalogs = $oPartCatalog->getPartCatalog($sCatalog, $sModelSeries, $aPartCoord['part_code']); */
	
				
				
				foreach($aPartCatalogs[$aPartCoord['part_code']] as $aPartCatalog)
					{
						
						
                    echo '<tr>';
                    echo '<td><a href='.Yii::app()->params['outUrl'].$aPartCatalog['part_number'].' target="_blank" >'.$aPartCatalog['part_number'].'</a>';
					
					if ($aPartCatalog['alter_code'])
					echo '</br>Код замены:</br>'.$aPartCatalog['alter_code'].'</td>';
					else echo '</td>';
                    echo '<td>' .Functions::prodToDate($aPartCatalog['production_start']).' - ' .Functions::prodToDate($aPartCatalog['production_end']).'</td>';
                    echo '<td>' .$aPartCatalog['complect_restr']; 
					
					if ($aPartCatalog['specification'])
					echo '<br/>'.$aPartCatalog['specification'];
					
					if ($aPartCatalog['option_restr'])
					echo '<br/>speccode: '.$aPartCatalog['option_restr'];
					
					
					
					echo'</td>';	
					 
					
					
					
                    echo '</tr>';
			/*		 echo '<tr>';
					 echo 'Код замены';
					 echo '</tr>';*/
					}
                
                echo '</tbody></table>';
				}
			/*else echo '<a href=' . Yii::app()->params['outUrl'] . $aPartCoord['part_code'] . 'id="pncs_' . $aPartCoord['part_code'].'">' . $aPartCoord['part_code']  .'</a></br>';*/
				
					
				$aPartCoord['part_code'] = str_replace ('+','\+',$aPartCoord['part_code']);
				
        	
	    	 echo '
                    <script>
					 
                        $("#pncs_'.addslashes($aPartCoord['part_code']).'").on("mouseover", function(){
                            $(this).css("cursor", "pointer");
                        });
                        $("#pncs_'.addslashes($aPartCoord['part_code']).'").on("click", function(){
                            $("#table_'.addslashes($aPartCoord['part_code']).'").toggleClass("hidden");
                            $(this).removeClass("btn-warning btn-info");
                            $(this).toggleClass("btn-success");
                        });
                        $("area#area'.addslashes($aPartCoord['part_code']).'").on("click", function(){
                            $("#pncs_'.addslashes($aPartCoord['part_code']).'").removeClass("btn-info");
                            $("#pncs_'.addslashes($aPartCoord['part_code']).'").toggleClass("btn-warning");
                        });
                        $("area#area'.addslashes($aPartCoord['part_code']).'").on("mouseover", function(){

                            $("#pncs_'.addslashes($aPartCoord['part_code']).'").addClass("btn-info");
                        });
                        $("area#area'.addslashes($aPartCoord['part_code']).'").on("mouseout", function(){
                            $("#pncs_'.addslashes($aPartCoord['part_code']).'").removeClass("btn-info");
                        });
                    </script>
                    ';
					
			}
			
			echo '</div>';
				
				
	
	echo ' </div>';
	
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