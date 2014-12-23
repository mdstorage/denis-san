<?php

class SiteController extends Controller
{


	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$oModelSeries = new ModelSeries();

        $aCatalogs = $oModelSeries->getCatalogs();
		
		
		

        foreach($aCatalogs as &$aCatalog){
            $aCatalog = $aCatalog['catalog'];
        }

        $this->render('vybor_regiona', array('aCatalogs'=>$aCatalogs));
	}
	
	
	
	
	public function actionModelNames($catalog){
        $oModelSeries = new ModelSeries();

        $aModelNames = $oModelSeries->getModelNames($catalog);
        foreach($aModelNames as &$modelName){
            $modelName = $modelName['model_name'];
        }
        $aModelNameCodes = array();
        foreach($aModelNames as $modelName){
            $aModelNameCodes[$modelName] = $oModelSeries->getModelNameCodes($catalog, $modelName);
        }
		
		for($i=0; $i<9; $i++)
		{
			setcookie("cookie[$i]", "");
			setcookie("diff[$i]", "");
			setcookie("compl[$i]", "");
		}
        
		$this->render(
            'vybor_modeli_2', array(
                'aModelNames'=>$aModelNames,
                'sCatalog'=>$catalog,
                'aModelNameCodes'=>$aModelNameCodes
                )
        );
		
  
    }
	
	
		
		 public function actionModelCodes($catalog, $modelSeries, $modelName)
    {
		for($i=0; $i<9; $i++)
		{
			setcookie("cookie[$i]", "");
			setcookie("diff[$i]", "");
			setcookie("compl[$i]", "");
		}
       
		$oModelCodes = new ModelSeries();
		$aModelCodes = $oModelCodes->getModelCodes($catalog, $modelSeries);
		$aModelNameCodes = $oModelCodes->getModelNameCodes($catalog, $modelName); 
		
		$aDiff = $oModelCodes->getdiff($catalog, $modelSeries);		
		
        $this->render(
            'vybor_complektacii', array(
			    'sCatalog'=>$catalog,
				'sModelSeries'=>$modelSeries,
				'sModelName'=>$modelName,
				'aModelNameCodes'=>$aModelNameCodes,
                'aModelCodes'=>$aModelCodes,
				'aDiff'=>$aDiff,
                )
        );
		
    }	
	
	 public function actionGroups ($catalog, $modelSeries, $modelName, $pos)
    {
		
       
		$oPriGroups = new PriGroups();
		$aPriGroups = $oPriGroups->getPriGroup($catalog, $modelSeries);
		
		$oPriGroupPics = new PriGroupPics();
		$aPriGroupPics = $oPriGroupPics->getPriGroupPics($catalog, $modelSeries);
		$aPriGroupCoords = $oPriGroupPics->getPriGroupCoords($catalog, $modelSeries);
		
	
		
		
			
		
		 		
		
        $this->render(
            'groups', array(
			    'sCatalog'=>$catalog,
				'sModelSeries'=>$modelSeries,
				'sModelName'=>$modelName,
				'pos'=>$pos,
				'aPriGroupPics'=>$aPriGroupPics,
				'aPriGroupCoords'=>$aPriGroupCoords
                )
        );
		
    }
	 public function actionSecgroups ($catalog, $modelSeries, $modelName, $desc_ru, $pos, $IdPriGroup, $ModelDir)
    {
		
       
		$oSecGroups = new SecGroups();
		$aSecGroups = $oSecGroups->getSecGroup($catalog, $modelSeries, $IdPriGroup);
		
		
        $this->render(
            'secgroups', array(
			    'sCatalog'=>$catalog,
				'sModelSeries'=>$modelSeries,
				'sModelName'=>$modelName,
				'sDesc_ru'=>$desc_ru,
				'pos'=>$pos,
				'IdPriGroup'=>$IdPriGroup,
				'ModelDir'=>$ModelDir,
                'aSecGroups'=>$aSecGroups
                )
        );
		
    }
	
	
	 public function actionSecgrouppics ($catalog, $modelSeries, $modelName, $sDesc_ru, $pos, $IdPriGroup, $IdSecGroup, $sDesc_en, $ModelDir , $PartCode)
    {
		$oSecGrouppics = new SecGroupPics();
		if (isset($_COOKIE["data"]))
		{
			$data = $_COOKIE["data"];
		}
		else $data = '';
		
		
		if (isset($_COOKIE["cookie"]))
		
		{
			$aSecGrouppics = $oSecGrouppics->getSecGroupPics($catalog, $modelSeries, $IdSecGroup, $data, $_COOKIE["cookie"]);
		}
		
		
		
		else
		{
		$aSecGrouppics = $oSecGrouppics->getSecGroupPics($catalog, $modelSeries, $IdSecGroup);	
		}
		 
	if ($PartCode != '') 
	{
		$oPicLabels = new PicLabels();
		
		
		$aPicNums = $oPicLabels->getPicNum($catalog, $modelSeries, $PartCode);
		
		foreach ($aSecGrouppics as $index=>$aSecGrouppic)
		{
			$anew = array();
			foreach ($aPicNums as $aPicNum)
			{
				$anew [$aPicNum ['pic_num']] = $aPicNum ['pic_num'];
							
			}
				
			if (!(in_array($aSecGrouppic['pic_num'], $anew)))
		{
			unset ($aSecGrouppics[$index]);
			
		}
		
			
			
		}
		
	}	
		
		
		
		
		
		
		
		
		
        $this->render(
            'secgrouppics', array(
			    'sCatalog'=>$catalog,
				'sModelSeries'=>$modelSeries,
				'sModelName'=>$modelName,
				'sDesc_ru'=>$sDesc_ru,
				'pos'=>$pos,
				'IdPriGroup'=>$IdPriGroup,
				'IdSecGroup'=>$IdSecGroup,
                'aSecGrouppics'=>$aSecGrouppics,
				'sDesc_en'=>$sDesc_en,
				'ModelDir'=>$ModelDir,
				'PartCode'=>$PartCode
                )
        );
		
    }
	
	
	 public function actionParts ($catalog, $modelSeries, $modelName, $sDesc_ru, $pos, $IdPriGroup, $IdSecGroup, $sDesc_en, $PicNum, $ModelDir, $PartCode)
    {
		
       $oPicLabels = new PicLabels();
	   $oPartCatalog = new PartCatalog();
	   $aPartCoords = $oPicLabels->getPartCoords($catalog, $modelSeries, $ModelDir, $PicNum, $IdSecGroup);
	  $aPartCatalogs = array();
	     
	  
	  foreach ($aPartCoords as $aPartCoord)
	  {
	  	
	  	 if (isset($_COOKIE["data"]))
		{
			$data = $_COOKIE["data"];
		}
		else $data = '';
		
	
		{
		if (isset($_COOKIE["cookie"]))
	  	$aPartCatalogs [$aPartCoord['part_code']] = $oPartCatalog->getPartCatalog($catalog, $modelSeries, $aPartCoord['part_code'], $data, $_COOKIE["cookie"]);
		else
		$aPartCatalogs [$aPartCoord['part_code']] = $oPartCatalog->getPartCatalog($catalog, $modelSeries, $aPartCoord['part_code']);
		 
		}
		
		
	  }

	  
	
	 		
		
        $this->render(
            'parts', array(
			    'sCatalog'=>$catalog,
				'sModelSeries'=>$modelSeries,
				'sModelName'=>$modelName,
				'sDesc_ru'=>$sDesc_ru,
				'pos'=>$pos,
				'IdPriGroup'=>$IdPriGroup,
				'IdSecGroup'=>$IdSecGroup,
				'sDesc_en'=>$sDesc_en,
				'PicNum'=>$PicNum, 
				'ModelDir'=>$ModelDir,
				'aPartCoords'=>$aPartCoords,
				'aPartCatalogs'=>$aPartCatalogs,
				'PartCode'=>$PartCode
				
                )
        );
		
    }
 
public function actionFindByVin()
    {
        $request = Yii::app()->getRequest();
        $oVinCodes = new VinCodes();
        if ($request->isAjaxRequest){
			
			for($i=0; $i<9; $i++)
		{
			setcookie("cookie[$i]", "");
			setcookie("diff[$i]", "");
			setcookie("compl[$i]", "");
		}
            if (!empty($_POST['value'])){
                $value = $_POST['value'];
                $aInfByVinCode =  $oVinCodes->getInfByVinCode($value);
            }

            if(!empty($_POST['frame']) && !empty($_POST['serial'])) {
                $frame = $_POST['frame'];
				$serial = $_POST['serial'];
				$value = $frame.$serial;
                $aInfByVinCode = $oVinCodes->getInfByVinCode($value);
            }

			$oModelCodes = new ModelCodes();
            $aInfByModelCode = $oModelCodes->getInfByModelCode($aInfByVinCode['model_code']);
            
            if (empty($aInfByVinCode)){
                die('Ничего не найдено. Проверьте введенные данные.');
            }
			
		$oPriGroups = new PriGroups();
		$aPriGroups = $oPriGroups->getPriGroup($aInfByVinCode['catalog'], $aInfByModelCode['model_series']);
		
		$oModelSeries = new ModelSeries();
		$sModelName = $oModelSeries->getModelNameByCatalog($aInfByVinCode['catalog'], $aInfByModelCode['model_series']);
		
		$oPriGroupPics = new PriGroupPics();
		$aPriGroupPics = $oPriGroupPics->getPriGroupPics($aInfByVinCode['catalog'], $aInfByModelCode['model_series']);
		$aPriGroupCoords = $oPriGroupPics->getPriGroupCoords($aInfByVinCode['catalog'], $aInfByModelCode['model_series']);
		$oAbbreviatures = new Abbreviatures();
		$sDescEnInt = $oAbbreviatures->getDescEn($aInfByVinCode['catalog'], $aInfByModelCode['model_series'], 'C'.$aInfByVinCode['internal_color']);
		$sDescEnCol = $oAbbreviatures->getDescEn($aInfByVinCode['catalog'], $aInfByModelCode['model_series'], 'C#'.$aInfByVinCode['color']);
		$aModelCodes = $oModelSeries->getModelCodes($aInfByVinCode['catalog'], $aInfByModelCode['model_series']);
		$aDiff = $oModelSeries->getdiff($aInfByVinCode['catalog'],  $aInfByModelCode['model_series']);
		
		$oPosname = new Posname();	
		$aComplectation = $oPosname->getComplByPosnumDate($aInfByVinCode['catalog'], $aInfByModelCode['model_series'], $aInfByModelCode['pos_num'], $aInfByVinCode['vdate']);
		
		
			echo '<div class="col-md-4">';
            echo "<br/><b>КОД МОДЕЛИ: </b>" . $aInfByModelCode['model_series'] . "<br/>".
			 	 "<b>НАЗВАНИЕ МОДЕЛИ: </b>" . $sModelName . "<br/>";
            echo "<b>ДАТА ПРОИЗВОДСТВА: </b>".Functions::prodToDate($aInfByVinCode['vdate'])."<br/>" .
                 "<b>ЦВЕТ КУЗОВА: </b>" .$sDescEnCol. "<br/>" .
                 "<b>ЦВЕТ ИНТЕРЬЕРА: </b>" . $sDescEnInt . "<br/>";
	for($i=1; $i<=count($aDiff); $i++)
       {
	   	
		echo  '<b>'.$aDiff[$i-1].': </b>';
	   
	   $aD = array();
		
				
	/*		$s = $aModelCode["f".($i)];
			$aD[$s] = $s;*/
			echo $aComplectation["f".($i)].'<br/>';	
		
		setcookie("compl[$i]", $aComplectation["f".($i)]);
			setcookie("diff[$i]", $aDiff[$i-1]);
			
			
		$string1 = array(')','(');
	$string2 = array('', '');
   $opt =  substr($aComplectation["f".($i)], (stripos ($aComplectation["f".($i)], '(')+1), strlen($aComplectation["f".($i)]));
			if (substr_count($opt, '(')>0) {$opt =  substr($opt, (stripos ($opt, '(')+1), strlen($opt));}
			$opt = str_replace($string1, $string2, $opt);
			
		
		setcookie("cookie[$i]", "");
		setcookie("cookie[$i]", $opt);
			
        } 
		
		setcookie("data","");
		setcookie("data", $aInfByVinCode['vdate']);
		
		
		
		 echo '<br/>';
				 
     
             echo CHtml::link('Перейти в каталог', array(
                'site/groups',
                'catalog'=>$aInfByVinCode['catalog'],
				'modelSeries'=>$aInfByModelCode['model_series'],
				'modelName'=>$sModelName,
				'pos'=>$aInfByModelCode['pos_num']
				),
				
				
                array('class'=>'btn btn-default btn-lg')
                );
				
				echo '</div>';
				
				$oSpec = new Specvin();
				$oSpecdsc = new Specdsc();
				$aSpecs = $oSpec->getSpec($aInfByVinCode['catalog'], $aInfByVinCode['spec_code']);
				
				
				
		
			
				echo '</br><div class="panel-group" id="accordion">';
        echo '<div class="col-md-4">
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							
							<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#0">Детальная информация</a></h4>
							</div>';
        
		 echo 				'<div id="0" class="panel-collapse collapsing">
      								<div class="panel-body">';
		foreach($aSpecs as $aSpec){
           echo $oSpecdsc->getDescEn($aInfByVinCode['catalog'], $aInfByModelCode['model_series'], $aSpec['spec']).'</br>';
        }
echo'						 		</div>			 
		      			 	</div>
	  		   			</div>
					</div>
			  </div>
			  
	';
		
    									
	 echo '</div>';
	 
        }
    }




public function actionFindByArticul()
    {
        $request = Yii::app()->getRequest();
        $oPartCatalog = new PartCatalog();
		$oModelSeries = new ModelSeries();
		$oPicLabels = new PicLabels();
		$oSecGroups = new SecGroups();
		$oPriGroups = new PriGroups();
		
        if ($request->isAjaxRequest){
			
			for($i=0; $i<9; $i++)
		{
			setcookie("cookie[$i]", "");
			setcookie("diff[$i]", "");
			setcookie("compl[$i]", "");
		}
            if (!empty($_POST['value'])){
                $PartNumber = $_POST['value'];
				
		$PartNumber = str_replace('-', '', $PartNumber);
		
                $aCatalogs =  $oPartCatalog->getCatByPartNumber($PartNumber);
				
            }
			

 			if (empty($aCatalogs)){
                die('Ничего не найдено. Проверьте введенные данные.');
            }
		
		foreach ($aCatalogs as $aCatalog)
		{
			
			
			$aModelNames = $oPartCatalog->getInfoByCatPartNumber($aCatalog['catalog'], $PartNumber);
			
			
			echo '<br/><div class="col-md-9">';
	/*		echo "<b>КАТАЛОГ: </b>" . $aCatalog['catalog'] . "<br/>";
			foreach ($aModelNames as $aModelName)
			{
			/*	$sModelName = $oModelSeries->getModelNameByCatalog($aInfByPartNumber, $aModelName['model_series']);
				echo "<br/><b>МОДЕЛЬ: </b>" . $aModelName['model_series'] . ")<br/>";
			}*/
			echo '<a name='.$aCatalog['catalog'].'></a><div class="btn btn-primary btn-large" id="pncs_'.$aCatalog['catalog'].'">'.$aCatalog['catalog'].'</div><br/><br/>';
                echo '<table id="table_'.$aCatalog['catalog'].'" class="hidden table table-striped">';
                echo '<thead>
                <td>Модель</td>
                <td>Период выпуска</td>
                <td>Схема</td>
                
              </thead><tbody>';
			  
			  
			  foreach ($aModelNames as $aModelName)
					{
			$sModelName = $oModelSeries->getModelNameByCatalog($aCatalog['catalog'], $aModelName['model_series']);
			$aModelNameCodes = $oModelSeries->getInfByCatMS($aCatalog['catalog'], $aModelName['model_series']);
			
			$aInfByPartCode = $oPicLabels->getInfByPartCode($aCatalog['catalog'], $aModelName['model_series'], $aModelName['part_code']);
			$aPGDescEnById = $oSecGroups->getPGDescEnById($aCatalog['catalog'], $aModelName['model_series'], $aInfByPartCode['sec_group']);
			$sDescEnById = $oPriGroups->getDescEnById($aCatalog['catalog'], $aModelName['model_series'], $aPGDescEnById['pri_group']);
			
						
                    echo '<tr>';
					echo '<td>' .$sModelName.' ('.$aModelName['model_series'].')</td>';
					echo '<td>' .Functions::prodToDate($aModelNameCodes['dt_start']).' - ' .Functions::prodToDate($aModelNameCodes['dt_end']).'</td>';
                    
                    echo '<td><a href='.Yii::app()->createUrl('site/secgrouppics', array(
                'catalog'=>$aCatalog['catalog'],
                'modelSeries'=>$aModelName['model_series'],
				'modelName'=>$sModelName,
				
				
				'sDesc_ru'=>Functions::getRusDesc($sDescEnById),
				'pos'=>'1',
				'IdPriGroup'=>$aPGDescEnById['pri_group'],
				'IdSecGroup'=>$aInfByPartCode['sec_group'],
				'sDesc_en'=>$aPGDescEnById['desc_en'],
				'ModelDir'=>$aInfByPartCode['model_dir'],
				'PartCode'=>$aModelName['part_code']
				
				)).'>Посмотреть на схеме</a></td>';
					
                    
					
                    echo '</tr>';
			/*		 echo '<tr>';
					 echo 'Код замены';
					 echo '</tr>';*/
					}
                
                echo '</tbody></table>';
           
		    echo '</div>';
			
			
			
			
			 
			  echo '
                    <script>
                        $("#pncs_'.$aCatalog['catalog'].'").on("mouseover", function(){
                            $(this).css("cursor", "pointer");
                        });
                        $("#pncs_'.$aCatalog['catalog'].'").on("click", function(){
                            $("#table_'.$aCatalog['catalog'].'").toggleClass("hidden");
                            $(this).removeClass("btn-warning btn-info");
                            $(this).toggleClass("btn-success");
                        });
                        $("area#area'.$aCatalog['catalog'].'").on("click", function(){
                            $("#pncs_'.$aCatalog['catalog'].'").removeClass("btn-info");
                            $("#pncs_'.$aCatalog['catalog'].'").toggleClass("btn-warning");
                        });
                        $("area#area'.$aCatalog['catalog'].'").on("mouseover", function(){

                            $("#pncs_'.$aCatalog['catalog'].'").addClass("btn-info");
                        });
                        $("area#area'.$aCatalog['catalog'].'").on("mouseout", function(){
                            $("#pncs_'.$aCatalog['catalog'].'").removeClass("btn-info");
                        });
                    </script>
                    ';
					
		}
	/*	print_r($aCatalogs); die;*/
		
			
		
		
		
		 echo '<br/>';
				 
     
  
		
    									
	
	 
	  
        }
    }

    

   
   

	/**
	 * This is the action to handle external exceptions.
	 */
	
	
	
	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
public function actionPos()
{
	
				
			{
			$catalog = $_POST['sCatalog'];
			$modelSeries = $_POST['sModelSeries'];
			$modelName = $_POST['sModelName'];	
			$oModelCodes = new ModelSeries();
			$aDiff = $oModelCodes->getdiff($catalog, $modelSeries);		
			$oPosname = new Posname();
		
		$string1 = array(')','(');
			$string2 = array('', '');
		for($i=0; $i<count($aDiff); $i++)
		{
/*			setcookie("cookie[$i]", "");
			setcookie("diff[$i]", "");
			setcookie("compl[$i]", "");*/
			
			
			
			$f[$i+1] =  substr($_POST[$i], (stripos ($_POST[$i] , '(')+1), strlen($_POST[$i]));
			
				
			
			$f[$i+1] = trim($f[$i+1]);
			if (substr_count($f[$i+1], '(')>0) {$f[$i+1] =  substr($f[$i+1], (stripos ($f[$i+1] , '(')+1), strlen($f[$i+1]));}
			$f[$i+1] = str_replace($string1, $string2, $f[$i+1]);
			
			$f[$i+1] = trim($f[$i+1]);
			
			
			
		}
			
		
		
		for($i=count($aDiff); $i<9; $i++)	
			{$f[$i+1]='';}
			
			
			
			$pos = $oPosname->getPosnum($catalog, $modelSeries, $f[1], $f[2], $f[3], $f[4], $f[5], $f[6], $f[7], $f[8]);
			
			
		
			
			
			$oPriGroups = new PriGroups();
		$aPriGroups = $oPriGroups->getPriGroup($catalog, $modelSeries);
		
		$oPriGroupPics = new PriGroupPics();
		$aPriGroupPics = $oPriGroupPics->getPriGroupPics($catalog, $modelSeries);
		$aPriGroupCoords = $oPriGroupPics->getPriGroupCoords($catalog, $modelSeries);  
		
		/* if (empty($pos)){
                die('Ничего не найдено. Проверьте введенные данные.');
            }*/	 
			 $this->render(
            'groups', array(
			    'sCatalog'=>$catalog,
				'sModelSeries'=>$modelSeries,
				'sModelName'=>$modelName,
				'pos'=>$pos,
				'aPriGroupPics'=>$aPriGroupPics,
				'aPriGroupCoords'=>$aPriGroupCoords
                )
        );
			
			} 
			
}
	/**
	 * Displays the contact page
	 */



public function actionAjax()
{
			
			$request = Yii::app()->getRequest();
			if ($request->isAjaxRequest)
			{
				
			$catalog = $_POST['sCatalog']; 
			$modelSeries = $_POST['sModelSeries']; 
			$modelName = $_POST['sModelName'];	
			$oModelCodes = new ModelSeries();
			$aDiff = $oModelCodes->getdiff($catalog, $modelSeries);		
			$oPosname = new Posname(); 
		
		$string1 = array(')','(');
			$string2 = array('', '');
		
		
		for($i=0; $i<count($aDiff); $i++)
		{
			setcookie("compl[$i]", $_POST[$i]);
			setcookie("diff[$i]", $aDiff[$i]);
			
			$f[$i+1] =  substr($_POST[$i], (stripos ($_POST[$i] , '(')+1), strlen($_POST[$i]));
			$f[$i+1] = trim($f[$i+1]);
			if (substr_count($f[$i+1], '(')>0) {$f[$i+1] =  substr($f[$i+1], (stripos ($f[$i+1] , '(')+1), strlen($f[$i+1]));}
			$f[$i+1] = str_replace($string1, $string2, $f[$i+1]);
			
			$f[$i+1] = trim($f[$i+1]);
		
		setcookie("cookie[$i]", $f[$i+1]);
		}
		for($i=count($aDiff); $i<9; $i++)	
			{$f[$i+1]='';}
			
			
			$pos = $oPosname->getPosnum($catalog, $modelSeries, $f[1], $f[2], $f[3], $f[4], $f[5], $f[6], $f[7], $f[8]);
			if (empty($pos))
			die ("d");
			else die ($pos);
		
			
			} 
			
}



	
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}