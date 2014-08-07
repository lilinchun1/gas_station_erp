<?php
class ExportAction extends Action{
	function __construct(){
		parent::__construct();
		//phpexecl引用
		require_once dirname(dirname(__FILE__))."/../MyClass/PHPExcel.php";
		require_once dirname(dirname(__FILE__)).'/../MyClass/PHPExcel/IOFactory.php';
		require_once dirname(dirname(__FILE__)).'/../MyClass/PHPExcel/Writer/Excel2007.php';
		//获取用户信息
		$this->userinfo = getUserInfo();
		//获取可查看菜单路径
		$this->assign('urlStr', $this->userinfo['urlstr']);
		$this->assign('username', $this->userinfo['realname']);
		
	}
	
	public function index(){
		null;
	}
	
	/*明细execl导出*/
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
		if(!empty($list) && !empty($where)){
			
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
			$resultPHPExcel->getActiveSheet()->setCellValue('A1', '加油站安装量日报');
			
			$resultPHPExcel->getActiveSheet()->setCellValue('A2', '日期');
			$resultPHPExcel->getActiveSheet()->setCellValue('B2', '安装总量');
			$resultPHPExcel->getActiveSheet()->setCellValue('C2', 'IOS安装量');
			$resultPHPExcel->getActiveSheet()->setCellValue('D2', 'Android安装量');
			$resultPHPExcel->getActiveSheet()->setCellValue('E2', '已统计加油站数量');
			$resultPHPExcel->getActiveSheet()->setCellValue('F2', '未统计加油站数量');
			$resultPHPExcel->getActiveSheet()->setCellValue('G2', '异常加油站数量');
			foreach($list as $k => $v){
				$coll = $k+4;
				$resultPHPExcel->getActiveSheet()->setCellValue('A'.$coll, date("Y-m-d",$v['reg_date']));
				$resultPHPExcel->getActiveSheet()->setCellValue('B'.$coll, $v['install_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('C'.$coll, $v['ios_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('D'.$coll, $v['android_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('E'.$coll, $v['succ_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('F'.$coll, $v['fail_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('G'.$coll, $v['unfind_num']);
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
	
	
	public function smart_export(){
		$master_id = I("get.id");
		$model = I("get.model");
		switch ($model){
			case 'succ':
				$this->_succ_export($master_id);//已统计
				break;
			case 'fail':
				$this->_fail_export($master_id);//未统计
				break;
			case 'unfind':
				$this->_undefine_export($master_id);//异常统计
				break;
			default:
				break;
		}
	}
	
	//已统计
	private function _succ_export($master_id){
		$where = "master_id='$master_id'";
		$Model = M("statistics_report_succ");
		$list = $Model->where($where)->order('reg_date DESC')->select();
		if(!empty($list) && !empty($where)){
				
			$resultPHPExcel = new PHPExcel();
			$resultPHPExcel->getActiveSheet()->mergeCells('A1:F1');
			//高度
			$resultPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
			$resultPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
		
			//宽度
			$resultPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
				
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
			$resultPHPExcel->getActiveSheet()->setCellValue('A1', '已统计加油站安装量明细');
				
			$resultPHPExcel->getActiveSheet()->setCellValue('A2', '网点名称');
			$resultPHPExcel->getActiveSheet()->setCellValue('B2', '点位信息');
			$resultPHPExcel->getActiveSheet()->setCellValue('C2', 'MAC');
			$resultPHPExcel->getActiveSheet()->setCellValue('D2', '安装总量');
			$resultPHPExcel->getActiveSheet()->setCellValue('E2', 'IOS安装量');
			$resultPHPExcel->getActiveSheet()->setCellValue('F2', 'Android安装量');
			foreach($list as $k => $v){
				$coll = $k+3;
				$resultPHPExcel->getActiveSheet()->setCellValue('A'.$coll, $v['point_address']);
				$resultPHPExcel->getActiveSheet()->setCellValue('B'.$coll, $v['point_info']);
				$resultPHPExcel->getActiveSheet()->setCellValue('C'.$coll, $v['mac']);
				$resultPHPExcel->getActiveSheet()->setCellValue('D'.$coll, $v['all_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('E'.$coll, $v['ios_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('F'.$coll, $v['android_num']);
			}
			//设置导出文件名
			$outputFileName = date("Ymd").'_已统计加油站安装量明细.xls';
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
	//未统计	
	private function _fail_export($master_id){
		$where = "master_id='$master_id' and flag = '0'";
		$Model = M("statistics_report_fail");
		$list = $Model->where($where)->order('reg_date DESC')->select();
		if(!empty($list) && !empty($where)){
	
			$resultPHPExcel = new PHPExcel();
			$resultPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			//高度
			$resultPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
			$resultPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
	
			//宽度
			$resultPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	
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
			$resultPHPExcel->getActiveSheet()->setCellValue('A1', '未统计加油站明细');
	
			$resultPHPExcel->getActiveSheet()->setCellValue('A2', '网点名称');
			$resultPHPExcel->getActiveSheet()->setCellValue('B2', '点位信息');
			$resultPHPExcel->getActiveSheet()->setCellValue('C2', 'MAC');
			foreach($list as $k => $v){
				$coll = $k+3;
				$resultPHPExcel->getActiveSheet()->setCellValue('A'.$coll, $v['point_address']);
				$resultPHPExcel->getActiveSheet()->setCellValue('B'.$coll, $v['point_info']);
				$resultPHPExcel->getActiveSheet()->setCellValue('C'.$coll, $v['mac']);
			}
			//设置导出文件名
			$outputFileName = date("Ymd").'_未统计加油站明细.xls';
			$xlsWriter = new PHPExcel_Writer_Excel5($resultPHPExcel);
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
	
	//异常统计
	private function _undefine_export($master_id){
		$where = "master_id='$master_id'";
		$Model = M("statistics_report_fail");
		$list = $Model->where($where)->order('reg_date DESC')->select();
		if(!empty($list) && !empty($where)){
	
			$resultPHPExcel = new PHPExcel();
			$resultPHPExcel->getActiveSheet()->mergeCells('A1:D1');
			//高度
			$resultPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
			$resultPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
	
			//宽度
			$resultPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$resultPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	
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
			$resultPHPExcel->getActiveSheet()->setCellValue('A1', '异常加油站安装量明细');
	
			$resultPHPExcel->getActiveSheet()->setCellValue('A2', 'MAC');
			$resultPHPExcel->getActiveSheet()->setCellValue('B2', '安装总量');
			$resultPHPExcel->getActiveSheet()->setCellValue('C2', 'IOS安装量');
			$resultPHPExcel->getActiveSheet()->setCellValue('D2', 'Android安装量');
			foreach($list as $k => $v){
				$coll = $k+3;
				$resultPHPExcel->getActiveSheet()->setCellValue('A'.$coll, $v['mac']);
				$resultPHPExcel->getActiveSheet()->setCellValue('B'.$coll, $v['all_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('C'.$coll, $v['ios_num']);
				$resultPHPExcel->getActiveSheet()->setCellValue('C'.$coll, $v['android_num']);
			}
			//设置导出文件名
			$outputFileName = date("Ymd").'_异常加油站安装量明细.xls';
			$xlsWriter = new PHPExcel_Writer_Excel5($resultPHPExcel);
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