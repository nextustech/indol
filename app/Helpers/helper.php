<?php

use Illuminate\Support\Facades\Http;

/**
 * @return string
 *
 * @return loggedUser url
 */
function loggedUser(){
    $loggedUser = Auth::user();
    return $loggedUser;
}

function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees Only ' : '') . $paise ;
}

/**
 * @param string $option_key
 * @return string
 */
function get_option($option_key = ''){
    global $options;

    if (array_key_exists($option_key, $options)){
        return $options[$option_key];
    }

    /*$get = \App\Option::where('option_key', $option_key)->first();
    if($get) {
        return $get->option_value;
    }
    */

    return $option_key;
}

/**
 * @param string $text
 * @return mixed
 */
function get_text_tpl($text = ''){
    $tpl = ['[year]', '[copyright_sign]', '[site_name]'];
    $variable = [date('Y'), '&copy;', get_option('site_name')];

    $tpl_option = str_replace($tpl,$variable,$text);
    return $tpl_option;
}

/**
 * @param string $title
 * @param $model
 * @return string
 */

function unique_slug($title = '', $model = 'Campaign'){
    $slug = str_slug($title);

    if (empty($slug)){
        $string = mb_strtolower($title, "UTF-8");;
        $string = preg_replace("/[\/\.]/", " ", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $slug = preg_replace("/[\s_]/", '-', $string);
    }

    //get unique slug...
    $nSlug = $slug;
    $i = 0;

    $model = str_replace(' ','',"\App\Models\ ".$model);
    while( ($model::whereSlug($nSlug)->count()) > 0){
        $i++;
        $nSlug = $slug.'-'.$i;
    }
    if($i > 0) {
        $newSlug = substr($nSlug, 0, strlen($slug)) . '-' . $i;
    } else
    {
        $newSlug = $slug;
    }
    return $newSlug;
}


