<?php
namespace app\utils;

/**
 * Excel工具类
 * Class ExcelUtil
 * 依赖安装：composer require phpoffice/phpexcel
 * @package app\utils
 * @author Gene <https://github.com/Talkyunyun>
 */
class ExcelUtil {
    // excel对象
    private $phpReader;

    // excel资源对象
    private $phpExcel;

    // 文件路径
    private $filePath;

    // 最终获取的数据资源
    private $data = [];

    public function __construct($filePath) {
        $this->filePath = $filePath;
        $this->phpReader = new \PHPExcel_Reader_Excel2007();

        // 优先excel2007,再excel2005
        if (!$this->phpReader->canRead($this->filePath)) {
            $this->phpReader = new \PHPExcel_Reader_Excel5();
            if (!$this->phpReader->canRead($this->filePath)) {
                dd('不支持该类型文件');
            }
        }

        $this->phpExcel = $this->phpReader->load($this->filePath);
    }


    /**
     * 获取excel文件数据
     * @param int $valueIndex
     * @return array
     */
    public function getExcelFileData($valueIndex = 2) {
        try {
            $sheetCount = $this->phpExcel->getSheetCount();

            $i = 0;
            while ($i < $sheetCount) {
                $this->getSheetData($i, $valueIndex);
                $i++;
            }

            return $this->data;
        } catch (\Exception $e) {
            return [];
        }
    }


    /**
     * * 获取指定sheet的数据
     * @param $index  sheet索引
     * @param int $valueIndex  excel值开始行数位置
     * @return bool
     */
    private function getSheetData($index, $valueIndex = 2) {
        $sheetObj    = $this->phpExcel->getSheet($index);// 获取第一个sheet
        $totalLine   = $sheetObj->getHighestRow();// 获取总行
        $totalColumn = $sheetObj->getHighestDataColumn();// 获取总列

        for ($line = $valueIndex; $line <= $totalLine; $line++) {
            $data = [];
            if ($sheetObj->getCell('A' . $line)->getValue() === null) {
                continue;
            }

            for ($column = 'A'; $column <= $totalColumn; $column++) {
                $val = $sheetObj->getCell($column . $line)->getValue();
                if ($val === null) continue;

                $data[] = $val;
            }

            array_push($this->data, $data);
        }

        return true;
    }
}