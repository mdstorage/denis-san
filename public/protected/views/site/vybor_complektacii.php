 
<?php 

/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

  <table class="table">
  
  <tr><td class="active"><b>Выбор комплектации</b></td>
  
  </tr>
  </table>
  
 
  

   	
  
  
  
  



<div class="container">


<?php if (!empty($aModelCodes))
{
    $this->breadcrumbs = array($sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog), $sModelName.'('.$sModelSeries.')');
	
	
	
 
$form = $this->beginWidget(
    'CActiveForm',
    array(
        'id' => 'myform',
		'action'=>Yii::app()->createUrl('site/pos'),
        'enableAjaxValidation' => false,
        
    )
);	
 /*echo  '<div name="myform"  id="myform" method="post" action="'. Yii::app()->createUrl('site/pos').'">';*/

   
       

 /* echo 'Номер: ' . CHtml::link($aModelCode['pos_num'],array(
                'site/groups',
                'catalog'=>$sCatalog,
                'modelSeries'=>$aModelCode['model_series'],
				'modelName'=>$sModelName,
				'pos'=>$aModelCode['pos_num'])).'<br/>';*/		
for($i=0; $i<count($aDiff); $i++)
       {
	   	
			echo ' <div class="row">';
		echo ' <div class="col-md-4">';
		echo  '<b>'.$aDiff[$i].': </b><br/>';
	   $aD = array();
		
		foreach($aModelCodes as $aModelCode)
		{			
			$s = $aModelCode["f".($i+1)];
			$aD[$s] = $s;
				
		}	
	/*	$a = array_unique($as);*/
		
		
	/*	 echo CHtml::dropdownlist('','type',$a ,array('id'=>$i,'class'=>"form-control",
                'ajax'=>array(
	                    'type'=>'POST',
						'url'=>Yii::app()->createUrl('site/pos'),
						'data'=>array('0'=> 'js:$("#0 option:selected").text()',
									'1'=> 'js:$("#1 option:selected").text()',
									'2'=> 'js:$("#2 option:selected").text()',
									'3'=> 'js:$("#3 option:selected").text()',
									'4'=> 'js:$("#4 option:selected").text()',
									'5'=> 'js:$("#5 option:selected").text()',
									'6'=> 'js:$("#6 option:selected").text()',
									'7'=> 'js:$("#7 option:selected").text()'),
	          /*         'success'=>'js:function(html){ $("#vin_result").html(html); }'
	                ),
	             ));*/
				 
				 echo CHtml::dropdownlist($i,'',$aD,array('id'=>$i,'class'=>"form-control"));
			
				
								
		echo '</div>';		
		echo '</div><br/>';
										
		
	}





/*echo	CHtml::textField('sCatalog', $sCatalog , array('id'=>$sCatalog,  ''=>'false'));*/
echo '<input name="sCatalog" type="hidden" id="sCatalog" value="'.$sCatalog.'">';
echo '<input name="sModelName" type="hidden" id="sModelName" value="'.$sModelName.'">';
echo '<input name="sModelSeries" type="hidden" id="sModelSeries" value="'.$sModelSeries.'">';
	
	
	
/*	echo CHtml::SubmitButton('Обработать', array('submit' => array('site/pos')));*/
    

		

/*	echo '</div>';*/
$this->endWidget();
	
	
	 

	
/*	echo CHtml::ajaxButton("Выбрать", array("site/pos"),
            array(
                'type'=>'POST',
                'data'=>array('sCatalog'=>$sCatalog, 'sModelSeries'=>$sModelSeries,
				'sModelName'=>$sModelName,
									'value0'=> 'js:$("#0 option:selected").text()',
									'value1'=> 'js:$("#1 option:selected").text()',
									'value2'=> 'js:$("#2 option:selected").text()',
									'value3'=> 'js:$("#3 option:selected").text()',
									'value4'=> 'js:$("#4 option:selected").text()',
									'value5'=> 'js:$("#5 option:selected").text()',
									'value6'=> 'js:$("#6 option:selected").text()',
									'value7'=> 'js:$("#7 option:selected").text()'),
									
									
           'success'=>'js:function(html){ $("#vin_result").html(html); }'
            ), array('class'=>'btn btn-default'));*/
			
echo CHtml::ajaxButton('Выбрать',  array("site/ajax"), array(
     	'type'  => 'POST',
		'data'=>array(
									'sCatalog'=>$sCatalog, 
									'sModelSeries'=>$sModelSeries,
									'sModelName'=>$sModelName,
									'0'=> 'js:$("#0 option:selected").text()',
									'1'=> 'js:$("#1 option:selected").text()',
									'2'=> 'js:$("#2 option:selected").text()',
									'3'=> 'js:$("#3 option:selected").text()',
									'4'=> 'js:$("#4 option:selected").text()',
									'5'=> 'js:$("#5 option:selected").text()',
									'6'=> 'js:$("#6 option:selected").text()',
									'7'=> 'js:$("#7 option:selected").text()'
					),
	/*		 'success'=>'js:function(html){if (html==="d") {alert("Ajax вернул: " + html)} else {$("#vin_result").html(html)};}'*/
			'success'=>'js:function(html){ if (html==="d") {alert("Выбранной комплектации не существует!")} else {$("#myform").submit()};}'
    
),  array('class'=>'btn btn-success'));/*  echo "<div id='vin_result'></div></div></div><br/> <hr>";*/





}



?>
</div>













