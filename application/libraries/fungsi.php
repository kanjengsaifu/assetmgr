<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fungsi {

    function Fungsi()
    {
        $CI =& get_instance();
    }
    
    function valid_date($str)
		{
			if($str && !preg_match("/[^0-9\^-]/", $str))
			{
				$expld = explode('-',$str);
				if(isset($expld[0])) $day = $expld[0]; else $day = 0;
				if(isset($expld[1])) $month = $expld[1]; else $month = 0;
				if(isset($expld[2])) $year = $expld[2]; else $year = 0;
				
				if(checkdate($month,$day,$year))
				{
					return TRUE;
				}else{
					$error = 'Input <b> tanggal </b> tidak valid !';
					return $error;
				}
			}else{
				$error = 'Input <b> tanggal </b> belum diisi !';
				return $error;
			}
		}
}