<?php

namespace App;
use File;
use Exception;
class Lib 
{
    public static function ext($file = ''){
        $ex = explode('.', $file);
        $ls = count($ex) -1;
        return '.' . ( !empty($ex[$ls]) ? $ex[$ls] : 'jpg');
	}

	public static function uploadfrombase64($data = '',$dir=''){
		if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
			$data = substr($data, strpos($data, ',') + 1);
			$type = strtolower($type[1]); // jpg, png, gif

			if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
				throw new \Exception('invalid image type');
			}

			$data = base64_decode($data);

			if ($data === false) {
				throw new \Exception('base64_decode failed');
			}
		} else {
			throw new \Exception('did not match data URI with image data');
		}
		$filename = time() .".{$type}";

		 file_put_contents( $dir . $filename, $data);
		return $filename;
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
	
	public static function exsImg( $path,$img ){
		$file = $path .'/'. $img;
		if( !empty($img) && file_exists( $file ) ){
			$image = asset($file);
			
		}else{
			$image = asset('public/images/no-image.svg');
		}
		
		return $image;
	}
}