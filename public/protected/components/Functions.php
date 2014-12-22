<?php
class Functions
{
    const GROUP_1 = "Двигатель / Топливная система / Принадлежности";
    const GROUP_2 = "Трансмиссия / Подвеска";
    const GROUP_3 = "Кузов";
    const GROUP_4 = "Электрика";

    public static function prodToDate($prod)
    {
        if ($prod && $prod != 65535){
			
			if ($prod[0]==0 || $prod[0]==1)
            return substr($prod, -2) . '/20' . substr($prod, 0, 2);
			else  return substr($prod, -2) . '/19' . substr($prod, 0, 2);
			
        } else {
            return '...';
        }

    }
	
	 public static function relation($prod)
    {
        if ($prod!= 65535)
            return (substr(Functions::prodToDate($prod), -4)*12+substr(Functions::prodToDate($prod),0,2));
			else return ($prod);
     }
	
	

    public static function getGroupName($groupNumber)
    {
        switch ($groupNumber){
            case 1:
                $groupName = self::GROUP_1;
                break;
            case 2:
                $groupName = self::GROUP_2;
                break;
            case 3:
                $groupName = self::GROUP_3;
                break;
            case 4:
                $groupName = self::GROUP_4;
                break;
        }

        return $groupName;
    }
	public static function getRusDesc($desc_en)
    {
        switch ($desc_en){
            case 'ENGINE MECHANICAL':
                $desc_en = 'ДВИГАТЕЛЬ (МЕХАНИКА)';
                break;
            case 'ENGINE ELECTRICAL':
                $desc_en = 'ДВИГАТЕЛЬ (ЭЛЕКТРИКА)';
                break;
            case 'POWER TRAIN':
                $desc_en = 'ТРАНСМИССИЯ';
                break;
            case 'FUEL & ENGINE CONTROL':
                $desc_en = 'ТОПЛИВНАЯ СИСТЕМА И СИСТЕМА УПРАВЛЕНИЯ ДВИГАТЕЛЕМ';
                break;
			case 'EXHAUST & COOLING':
                $desc_en = 'СИСТЕМЫ ОХЛАЖДЕНИЯ И ВЫХЛОПА';
                break;
			case 'BODY ELECTRICAL':
                $desc_en = 'ЭЛЕКТРИКА КУЗОВА';
                break;
			case 'AXLE & SUSPENSION':
                $desc_en = 'МОСТ И ПОДВЕСКА';
                break;
			case 'BRAKE':
                $desc_en = 'ТОРМОЗА';
				break;
			case 'STEERING':
                $desc_en = 'РУЛЕВОЕ УПРАВЛЕНИЕ';	
                break;
			case 'BODY(FRONT,ROOF & FLOOR)':
                $desc_en = 'КУЗОВ (ПЕРЕДНЯЯ ЧАСТЬ, КРЫША И ПОЛ)';	
                break;
			case 'BODY(SIDE & REAR)':
                $desc_en = 'КУЗОВ (БОКОВАЯ И ЗАДНЯЯ ЧАСТЬ)';	
                break;
			case 'SEAT & SEAT BELT':
                $desc_en = 'СИДЕНИЯ И РЕМНИ БЕЗОПАСНОСТИ';	
                break;
			case 'MISCELLANEOUS':
                $desc_en = 'ДРУГОЕ';	
                break;
			case 'BODY(SIDE & REAR)':
                $desc_en = 'КУЗОВ (БОКОВАЯ И ЗАДНЯЯ ЧАСТЬ)';	
                break;
			case 'BODY(BACK DOOR & REAR BODY)':
                $desc_en = 'КУЗОВ (ЗАДНЯЯ ДВЕРЬ И ЗАДНЯЯ ЧАСТЬ)';	
                break;
						
        }

        return $desc_en;
    }
	
	 public static function getString($string)
	 {
	 	
		$string1 = array(';',',','..','(',')');
		$string2 = array('; ',', ','.. ',' (',') ');
		$string = str_replace($string1, $string2, $string);
		 
		 return $string;
	 }
	 
	 public static function getNumberbyLetter($s)
    {
	/*	if ($s<10)
		$s = '0'.$s;
		else $s = $s;*/
		
      switch ($s)
		
		{
            case 'A':
                $s = '00';
               break;
           case 'B':
                $s = '01';
				 break;
			case 'C':
                $s = '02';
				 break;
			case 'D':
                $s = '03';
				 break;
			case 'E':
                $s = '04';
               break;
           case 'F':
                $s = '05';
				 break;
			case 'G':
                $s = '06';
				 break;
			case 'H':
                $s = '07';
				 break;
			case 'I':
                $s = '08';
				 break;
			case 'J':
                $s = '09';
				 break;
			case 'K':
                $s = '10';
				 break;
			case 'L':
                $s = '11';
				 break;
			case 'M':
                $s = '12';
				 break;
			case 'N':
                $s = '13';
				 break;
				 				
        }

        return $s;
    }
	
	public static function getNumberSubstring($string)
	 {
	 	
		$string1 = 'WHL DRV';
		$string2 = 'WHLDRV';
		$string = str_replace($string1, $string2, $string);
		
		
		
		$a = str_word_count($string, 1);
		
		return $a;
	 }
	
}