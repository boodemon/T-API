<?php
	// :: SET EXCEL FORM :://
	$xls->getProperties()->setCreator('Customer order ');
	$xls->getProperties()->setLastModifiedBy("Customer order ");
	$xls->getProperties()->setTitle('Customer order ');
	$xls->getProperties()->setSubject('Customer order' );
	$xls->getProperties()->setDescription('Customer order ');

	//$label=$xls->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setBold(true);
	$xls->getActiveSheet()->getDefaultStyle()->getFont()->setName("Browallia New")->setSize(14);
	$xls->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$xls->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	$xls->getActiveSheet()->getPageSetup()->setFitToWidth(1);
	$xls->getActiveSheet()->getPageSetup()->setFitToHeight(0);

	//:: Set Array Style :://
	$default_border = array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('rgb'=>'000000')
	);
	$border_none = array(
		'style' => PHPExcel_Style_Border::BORDER_NONE
	);
	$bold_border2 = array(
		'style' => PHPExcel_Style_Border::BORDER_HAIR,
		'color' => array('rgb'=>'000000')
	);
	$bold_border = array(
		'style' => PHPExcel_Style_Border::BORDER_THICK,
		'color'	=> array('rgb'=>'000000')
	);	
	$double_border = array(
		'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
		'color' => array('rgb'=>'000000')
	);
	$style_header = array(
		'borders' => array(
			'top'	 => $bold_border,
			'bottom' => $default_border,
			'left'	 => $default_border,
			'right'	 => $default_border
		),
	);
	$bottom_line = array(
		'borders' => array(
			'bottom' => $default_border,
		),
	);
	$bgwhite = array(
			'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'ffffff')
		),
	);

	$style_head_title = array(
		'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      ),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'cccccc')
		),
		'font'  => array(
			'color' => array('rgb' => '000000'),
		)
	);

	$all_border = array(
		'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
	);

	$standard_border = array(
		'borders' => array(
			'top'	 => $default_border,
			'bottom' => $default_border,
			'left'	 => $default_border,
			'right'	 => $default_border,
		),
	);
	$standard_border_bold = array(
		'borders' => array(
			'top'	 => $bold_border,
			'bottom' => $bold_border,
			'left'	 => $bold_border,
			'right'	 => $bold_border
		),
	);

	$border_left_top = array(
		'borders' => array(
			'top'	 => $default_border,
			'left'	 => $default_border,
		),
	);


	$border_left_bottom = array(
		'borders' => array(
			'bottom' => $default_border,
			'left'	 => $default_border,
		),
	);

	$bottom_line_double = array(
		'borders' => array(
			'bottom' => $double_border,
		),
	);

	$border_top_rignt = array(
		'borders' => array(
			'top'	 => $default_border,
			'right'	 => $default_border
		),
	);

	$border_bottom_rignt = array(
		'borders' => array(
			'bottom' => $default_border,
			'right'	 => $default_border
		),
	);

	$border_left = array(
		'borders' => array(
			'left'	 => $default_border
		),
	);

	$border_rignt = array(
		'borders' => array(
			'right'	 => $default_border,
		),
	);

	$border_top = array(
		'borders' => array(
			'top'	 => $default_border,
		),
	);	
	$border_bottom = array(
		'borders' => array(
			'bottom' => $default_border,
		),
	);
	$border_bottom_no = array(
		'borders' => array(
			'bottom' => $border_none
		),
	);
	$bank_name = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '9C0533'),
        'size'  => 16
	));

	$sum_day = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '008C23'),
        'size'  => 16
	));

	$total_money = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '0000FF'),
        'size'  => 16
	));

	$fontred = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FF0000'),
        'size'  => 16
	));

	$color_green = array(
    'font'  => array(
        'color' => array('rgb' => '008C23'),
	));

	$color_blue = array(
    'font'  => array(
        'color' => array('rgb' => '0000FF'),
	));

	$color_red = array(
    'font'  => array(
        'color' => array('rgb' => 'FF0000'),
	));

	$color_black = array(
    'font'  => array(
        'color' => array('rgb' => '000000'),
	));
