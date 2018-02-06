<?php

namespace App;
class Lib 
{
    public static function ext($file = ''){
        $ex = explode('.', $file);
        $ls = count($ex) -1;
        return '.' . $ex[$ls];
	}
	
	public static function active($status){
		if( $status == 'Y'){
			return '<span class="badge badge-success" >Active</span>';
		}else{
			return '<span class="badge badge-danger" >Unactive</span>';
		}                 
	}
    public static function encodelink($value=''){
		$link = strtolower($value);
		$link = str_replace(' ', '-', $link);
		$link = str_replace('/', '-', $link);
		$link = str_replace('%', '-', $link);
		$link = str_replace('*', '-', $link);
		$link = str_replace('&', '-', $link);
		$link = str_replace('+', '-', $link);
		$link = str_replace('?', '-', $link);
		$link = str_replace('=', '-', $link);
		$link = str_replace('+', '-', $link);
		$link = str_replace('#', '', $link);
		$link = str_replace(',', '-', $link);
		$link = str_replace(';', '-', $link);
		$link = str_replace('@', '', $link);
		$link = str_replace('!', '', $link);
		$link = str_replace('?', '', $link);
		$link = str_replace('<', '', $link);
		$link = str_replace('>', '', $link);
		$link = str_replace('\"', '', $link);
		$link = str_replace('(', '', $link);
		$link = str_replace(')', '', $link);
		return $link;
	}
    public static function encodefile($value=''){
		$link = strtolower($value);
		$link = str_replace(' ', '-', $link);
		$link = str_replace('/', '-', $link);
		$link = str_replace('%', '-', $link);
		$link = str_replace('*', '-', $link);
		$link = str_replace('&', '-', $link);
		$link = str_replace('+', '-', $link);
		$link = str_replace('?', '-', $link);
		$link = str_replace('=', '-', $link);
		$link = str_replace('+', '-', $link);
		$link = str_replace('#', '', $link);
		$link = str_replace(',', '-', $link);
		$link = str_replace(';', '-', $link);
		$link = str_replace('@', '', $link);
		$link = str_replace('!', '', $link);
		$link = str_replace('?', '', $link);
		$link = str_replace('<', '', $link);
		$link = str_replace('>', '', $link);
		$link = str_replace('\"', '', $link);
		$link = str_replace('(', '', $link);
		$link = str_replace(')', '', $link);
		return substr($link,0,20) .'.';
    }
}