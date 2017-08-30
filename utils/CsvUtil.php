<?php
/**
 * CSV 操作类
 * @author: Gene
 */
namespace app\utils;

class CsvUtil {

    /**
     * 获取CSV文件的内容
     * @param $filePath
     * @param int $valLine
     * @return array
     */
    public static function getData($filePath, $valLine = 1) {
        $file = fopen($filePath, 'r');

        $data = [];
        $i    = 0;
        while ($row = fgetcsv($file)) {
            $i++;
            if ($i <= $valLine) continue;
            if ($row[0] == '') continue;
            $data[] = $row;
        }
        fclose($file);

        return $data;
    }




    /**
     * 导出CSV文件
     * @param array $title 标题 ['姓名', '性别']
     * @param array $value 值 [['gene1', '男'], ['gene2', '女']]
     * @param String $fileName 文件名,不需要csv后缀
     */
    public static function export($title, $value, $fileName = false) {
        $data = join(',', $title) . "\n";

        foreach ($value as $row) {
            $data .= join(',', $row) . "\n";
        }

        if (empty($fileName)) {
            $fileName = date('Y-m-d') . '.csv';
        }

        header('Content-type:text/csv');
        header('Content-Disposition:attachment;filename=' . $fileName);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        echo $data;
    }
}