<?php
class ExportAction extends Action{
	function __construct(){
		parent::__construct();
		//获取用户信息
		$this->userinfo = getUserInfo();
		//获取可查看菜单路径
		$this->assign('urlStr', $this->userinfo['urlstr']);
		$this->assign('username', $this->userinfo['realname']);
		require_once dirname(dirname(__FILE__))."/../MyClass/PHPExcel.php";
		require_once dirname(dirname(__FILE__)).'/../MyClass/PHPExcel/IOFactory.php';
		require_once dirname(dirname(__FILE__)).'/../MyClass/PHPExcel/Writer/Excel2007.php';
	}
	
	public function index(){
		null;
	}
	
	/*execl导出*/
	public function all_export(){
		$where = "";
		$select_province = I("get.select_province");
		$select_city = I("get.select_city");
		$contract_end_time_1 = I("get.contract_end_time_1");
		$contract_end_time_2 = I("get.contract_end_time_2");
		if(!empty($select_province)){
			$where .=" province_name='".$select_province."'";
		}
		if (!empty($select_city)){
			$where .=" and city_name='".$select_city."'";
		}
		
		if (!empty($contract_end_time_1)){
			$where .=" and reg_date >='".strtotime($contract_end_time_1)."'";
		}
		if (!empty($contract_end_time_2)){
			$where .=" and reg_date <'".(strtotime($contract_end_time_2)+24*3600)."'";
		}

		$Model = M("statistics_report_all");
		$list = $Model->where($where)->order('reg_date DESC')->select();
		//echo $Model->getLastSql();
		if(!empty($list)){
			$resultPHPExcel = new PHPExcel();
			$resultPHPExcel->getActiveSheet()->mergeCells('A1:G1');
			//高度
			$resultPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
			$resultPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);

			//宽度
			$resultPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
			
			//居中
			$styleArray1 = array(
					'font' => array(
							'bold' => true,
							'size'=>12,
							'color'=>array(
									'argb' => '00000000',
							),
					),
					'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
			);
			$resultPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);
			$resultPHPExcel->getActiveSheet()->setCellValue('A1', date("Y年m月d日").'——加油站安装量日报');
			
			$resultPHPExcel->getActiveSheet()->setCellValue('A2', '日期');
			$resultPHPExcel->getActiveSheet()->setCellValue('B2', '安装总量');
			$resultPHPExcel->getActiveSheet()->setCellValue('C2', 'IOS安装量');
			$resultPHPExcel->getActiveSheet()->setCellValue('D2', 'Android安装量');
			$resultPHPExcel->getActiveSheet()->setCellValue('E2', '已统计加油站数量');
			$resultPHPExcel->getActiveSheet()->setCellValue('F2', '未统计加油站数量');
			$resultPHPExcel->getActiveSheet()->setCellValue('G2', '未统计加油站数量');
			foreach($list as $k => $v){
				$coll = $k+4;
				$resultPHPExcel->getActiveSheet()->setCellValue('A'.$coll, date("Y-m-d",$v['reg_date']));
				$resultPHPExcel->getActiveSheet()->setCellValue('B'.$coll, $v['install_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('C'.$coll, $v['ios_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('D'.$coll, $v['android_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('E'.$coll, $v['succ_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('F'.$coll, $v['fail_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('G'.$coll, $v['fail_num']);
			}
			
			//汇总
			$resultPHPExcel->getActiveSheet()->setCellValue('A3', '汇总');
			$resultPHPExcel->getActiveSheet()->setCellValue('B3', "=SUM(B4:B$coll)");
			$resultPHPExcel->getActiveSheet()->setCellValue('C3', "=SUM(C4:C$coll)");
			$resultPHPExcel->getActiveSheet()->setCellValue('D3', "=SUM(D4:D$coll)");
			$resultPHPExcel->getActiveSheet()->setCellValue('E3', "=SUM(E4:E$coll)");
			$resultPHPExcel->getActiveSheet()->setCellValue('F3', "=SUM(F4:F$coll)");
			$resultPHPExcel->getActiveSheet()->setCellValue('G3', "=SUM(G4:G$coll)");
			
			//设置导出文件名
			$outputFileName = date("Ymd").'_加油站安装量日报.xls';
			$xlsWriter = new PHPExcel_Writer_Excel5($resultPHPExcel);
			//ob_start(); ob_flush();ob_clean();
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header('Content-Disposition:inline;filename="'.$outputFileName.'"');
			header("Content-Transfer-Encoding: binary");
			header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
			header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			$xlsWriter->save( "php://output" );
		}
	}
}