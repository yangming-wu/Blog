<?php

/**
 * 基础模型类
 */
class Model {
	// 定义用来存储dao对象的属性,要求可以在子类中被访问
	protected $dao;
	/**
	 * 构造方法
	 */
	public function __construct() {
		// 初始化dao
		$this->initDAO();
	}
	/**
	 * 初始化dao
	 */
	protected function initDAO() {
		// 初始化dao
		$config = $GLOBALS['conf']['db'];
		// 根据配置文件,选择相应的数据库类文件
		switch($GLOBALS['conf']['App']['dao']) {
			case 'mysql' : $dao_class = 'MySQLDB';break;
			case 'pdo'   : $dao_class = 'PDODB';
		}
		$this->dao = $dao_class::getInstance($config);
	}

	/**
     * 对用户的数据进行安全过滤
     */
		protected function escapeData($data) {
			return addslashes(strip_tags(trim($data)));
		}

	protected function getExcelContent($filename) {
		// 载入读取EXCEL文件的插件
		require PHPEXCEL_DIR . "Classes/PHPExcel.php";
		require PHPEXCEL_DIR . "Classes/PHPExcel/IOFactory.php";
		require PHPEXCEL_DIR . "Classes/PHPExcel/Shared/Date.php";

		$list = array();
		$objPHPExcelReader = PHPExcel_IOFactory::load($filename);  //加载excel文件

		$sheet = $objPHPExcelReader->getSheet(0);
		foreach($sheet->getRowIterator() as $row) {
			$tmp_list = array();
			// 逐列读取数据
			foreach($row->getCellIterator() as $cell){
				$data = $cell->getValue();
				if(is_null($data) or $data == ""){
					$data = "NA";
				}
				$data = $this->escapeData($data);
				array_push($tmp_list,$data);
			}
			array_push($list,$tmp_list);
		}
		return $list;
	}


		/**
	 * 读取Excel文件格式化到Array
	 * 
	 * @prams Excel file  sheetname
	 * 
	 * @return array("statu" => 0, "Info" => Data)
	 */
	protected function formatExeclToArray($filePath='',$sheet=0){
		// 载入读取EXCEL文件的插件
		require PHPEXCEL_DIR . "Classes/PHPExcel.php";
		require PHPEXCEL_DIR . "Classes/PHPExcel/IOFactory.php";
		require PHPEXCEL_DIR . "Classes/PHPExcel/Shared/Date.php";

		if(empty($filePath) or !file_exists($filePath)){
			die('file not exists');
			return array("statu" => 1, "Info" => "$filePath is not exists!");
		}

		// 实例化对象
		$PHPReader = new PHPExcel_Reader_Excel2007();

		if(!$PHPReader->canRead($filePath)){
			$PHPReader = new PHPExcel_Reader_Excel5();
			if(!$PHPReader->canRead($filePath)){
				return array("statu" => 1, "Info" => "$filePath: Is the file format correct?");
			}
		}

		$PHPExcel = $PHPReader->load($filePath);
		$currentSheet = $PHPExcel->getSheet($sheet);

		$allColumn = $currentSheet->getHighestColumn();
		$allRow = $currentSheet->getHighestRow();

		$data = array();
		for($rowIndex=1; $rowIndex<=$allRow; $rowIndex++){

			for($colIndex='A'; $colIndex<=$allColumn; $colIndex++){

				$address = $colIndex.$rowIndex;
				$cell = $currentSheet->getCell($address);
				$cvalue = $cell->getValue();

				// 判断单元格内容是否为日期格式
				if($cell->getDataType()==\PHPExcel_Cell_DataType::TYPE_NUMERIC){
					$cellstyleformat = $cell->getStyle($cell->getCoordinate())->getNumberFormat(); 
					$formatcode = $cellstyleformat->getFormatCode();

					if (preg_match('/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatcode)){
						$cvalue = gmdate("Y-m-d",\PHPExcel_Shared_Date::ExcelToPHP($cvalue));
					}else{
						$cvalue=\PHPExcel_Style_NumberFormat::toFormattedString($cvalue,$formatcode);
					}
				}

				// 保存数据到data
				$data[$rowIndex][$colIndex] = $cvalue;
			}

		}
		return array("statu" => 0, "Info" => $data);
	}






}