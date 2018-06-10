<?php 
	$xls->getActiveSheet()->getColumnDimension('A')->setWidth(12);
	$xls->getActiveSheet()->getColumnDimension('B')->setWidth(14);
	$xls->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$xls->getActiveSheet()->getColumnDimension('D')->setWidth(24);
	$xls->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $xls->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $xls->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$xls->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $xls->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $xls->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $xls->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    $xls->getActiveSheet()->getColumnDimension('L')->setWidth(14.5);

//-----------------// HEADER TITLE //------------------------------//
$xls->getActiveSheet()->getRowDimension(1)->setRowHeight(24);
$xls->getActiveSheet()->getRowDimension(2)->setRowHeight(24);
$xls->getActiveSheet()->getRowDimension(3)->setRowHeight(24);
$xls->getActiveSheet()->mergeCells('A1:L1');
$xls->getActiveSheet()->getStyle('A1')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
$xls->getActiveSheet()->getStyle('J2')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$xls->getActiveSheet()->mergeCells('A2:G2');
$xls->getActiveSheet()->mergeCells('K2:L2');

$xls->getActiveSheet()->getStyle('A1')->getFont()->setSize(18)->setBold(true);
$xls->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);

$xls->getActiveSheet()->SetCellValue('A1','ORDER REPORT');
$xls->getActiveSheet()->SetCellValue('A2','FILTER FROM : ' . date('M d, Y', strtotime($start) ) . ' To ' . date('M d, Y', strtotime($end) ) );
$xls->getActiveSheet()->SetCellValue('J2','EXPORT DATE : ');
$xls->getActiveSheet()->SetCellValue('K2',date('M d, Y') );

//-----------------// HEADER TITLE //------------------------------//
//----------------:: TABLE HEADER ::-------------------------------//
$xls->getActiveSheet()->getStyle('A3:L3')->applyFromArray( $style_head_title );
$xls->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$xls->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
$xls->getActiveSheet()->getStyle('A3:L3')->getFont()->setSize(16)->setBold(true);

$xls->getActiveSheet()->SetCellValue('A3','Order No');
$xls->getActiveSheet()->SetCellValue('B3','Date');
$xls->getActiveSheet()->SetCellValue('C3','Job Name');
$xls->getActiveSheet()->SetCellValue('D3','Job Address');
$xls->getActiveSheet()->SetCellValue('E3','Customer');
$xls->getActiveSheet()->SetCellValue('F3','Food');
$xls->getActiveSheet()->SetCellValue('G3','Restourant');
$xls->getActiveSheet()->SetCellValue('H3','Price');
$xls->getActiveSheet()->SetCellValue('I3','Quantity');
$xls->getActiveSheet()->SetCellValue('J3','Amount');
$xls->getActiveSheet()->SetCellValue('K3','Total');
$xls->getActiveSheet()->SetCellValue('L3','Status');


$row = 4;
$total = 0;
foreach( $rows as $rs ){
    if( $x == 0 || ( isset($node[$x-1]) && $node[$x-1] != $rs->head_id ) ){
        $hide = false;
    }else{
        $hide = true;
    }
    $amount = $rs->per_price * $rs->qty;
    $total += $amount;
    $qty   += $rs->qty;
    $xls->getActiveSheet()->getRowDimension($row)->setRowHeight(24);

    $xls->getActiveSheet()->getStyle("A$row:L$row")->applyFromArray( $all_border );

    $xls->getActiveSheet()->SetCellValue("A$row",( $hide == false ) ? '#'. sprintf('%05d',$rs->head_id) : '' );
    $xls->getActiveSheet()->SetCellValue("B$row",( $hide == false ) ? date('d M Y',strtotime( $rs->created_at) ) :'' );
    $xls->getActiveSheet()->SetCellValue("C$row",( $hide == false ) ? $rs->jobname :'' );
    $xls->getActiveSheet()->SetCellValue("D$row",( $hide == false ) ? $rs->address :'' );
    $xls->getActiveSheet()->SetCellValue("E$row",( $hide == false ) ? App\User::field( $rs->user_id ): '' );
    $xls->getActiveSheet()->SetCellValue("F$row",$rs->food_name );
    $xls->getActiveSheet()->SetCellValue("G$row",$rs->restourant_name );
    $xls->getActiveSheet()->SetCellValue("H$row",$rs->per_price );
    $xls->getActiveSheet()->SetCellValue("I$row",$rs->qty );
    $xls->getActiveSheet()->SetCellValue("J$row",$amount );
    $xls->getActiveSheet()->SetCellValue("K$row",( $amount != 0 ) ? $total : '');
    $xls->getActiveSheet()->SetCellValue("L$row",( $hide == false ) ? Lib::statusText( $rs->status ) : ''  );

    $node[$x] = $rs->head_id; 
    $x++;
    $row++;
}
$xls->getActiveSheet()->getStyle('A3:L'. $row)
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
                    ->setWrapText(true); 

$xls->getActiveSheet()->mergeCells("A$row:G$row");
$xls->getActiveSheet()->getStyle("I$row")->applyFromArray( $standard_border );
$xls->getActiveSheet()->getStyle("I$row")->applyFromArray( $bottom_line_double );
$xls->getActiveSheet()->getStyle("K$row")->applyFromArray( $standard_border );
$xls->getActiveSheet()->getStyle("K$row")->applyFromArray( $bottom_line_double );

$xls->getActiveSheet()->SetCellValue("I$row",$qty);
$xls->getActiveSheet()->SetCellValue("K$row",$total);

//----------------:: TABLE HEADER ::-------------------------------//
// ตั้งชื่อ Sheet
$xls->getActiveSheet()->setTitle($subject);
// บันทึกไฟล์ Excel 2007
$objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
$objWriter->save($excel); 
