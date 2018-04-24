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
	public static function bcm($_breadcrumb){
		$bcm = '';
		  if( is_array($_breadcrumb) ){
			  $max = count($_breadcrumb)-1;
			  foreach( $_breadcrumb as $i => $text ){
				  $bcm .= '<li class="breadcrumb-item '.( $i == $max ? 'active':'' ).'">'. $text .'</li>';
			  }
		  }else{
			  $bcm .= '<li class="breadcrumb-item active">'. $_breadcrumb .'</li>';
		  }
	  return $bcm;
	}

	public static function nb($a,$dec = 0,$cm = ','){
		$a = floatval($a);
		if(empty($a)){
			return 0;
		}else{
			return $dec != 0 ? number_format($a,$dec,'.',$cm): number_format($a,$dec,'',$cm);
		}
	}
	public static function statusLabel($key=''){
		$label = [
			'new'			=>	'<span class="badge badge-pill badge-info">รายการใหม่</span>',
			'pending'		=>	'<span class="badge badge-pill badge-info">ชำระผ่านเน็ต</span>',
			'remittance'	=>	'<span class="badge badge-pill badge-danger">รอการโอนเงิน</span>',
			'confirmation'	=>	'<span class="badge badge-pill badge-warning">รอตรวจสอบ</span>',
			'processing'	=>	'<span class="badge badge-pill badge-primary">กำลังดำเนินการ</span>',
			'waiting'		=>	'<span class="badge badge-pill badge-light">รอสินค้า</span>',
			'shipment'		=>	'<span class="badge badge-pill badge-warning">ระหว่างจัดส่งสินค้า</span>',
			'collecting'	=>	'<span class="badge badge-pill badge-info">รับสินค้า</span>',
			'completed'		=>	'<span class="badge badge-pill badge-success">เรียบร้อยแล้ว</span>',
			'cancelled'		=>	'<span class="badge badge-pill badge-secondary">ยกเลิก</span>',
		];
		return @$label[$key];
	}
	public static function statusText($key=''){
		$text = Lib::statusValue();
		return @$text[$key];
	}
	public static function statusValue(){
		return [
			'new'			=>	'รายการใหม่',
			'pending'		=>	'ชำระผ่านเน็ต',
			'remittance'	=>	'รอการโอนเงิน',
			'confirmation'	=>	'รอตรวจสอบ',
			'processing'	=>	'กำลังดำเนินการ',
			'waiting'		=>	'รอสินค้า',
			'shipment'		=>	'ระหว่างจัดส่งสินค้า',
			'collecting'	=>	'รับสินค้า',
			'completed'		=>	'เรียบร้อยแล้ว',
			'cancelled'		=>	'ยกเลิก',
		];
	}
	public static function filename($path = '', $name=''){
        if( file_exists( $path . $name ) ){
            $getName    = explode('.', $name);
            $exname     = explode('-',$getName[0]);
            $last       = count( $exname ) -1;
            if( strlen( $exname[$last]) > 2 ){
                $rename = $getName[0].'-2.pdf';
            }else{
				$n = [];
				$node = count( $exname );
				$max = $node-1;
				for($i = 0; $i < $node; $i++){
					if($i != $max){
						$n[] = $exname[$i];
					}else{
						$n[] = (int)$exname[$i] + 1;
					}
					
				}
                $rename = implode('-',$n) . '.pdf';
            }
            return Lib::filename($path, $rename);
        }else{ 
            return $name;
        }
    }

  
}