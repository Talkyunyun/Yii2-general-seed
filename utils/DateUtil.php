<?php
/**
 * 日期工具类
 * @author: Gene
 */
namespace app\utils;

class DateUtil {
    /**
     * 根据两个日期或者范围日期
     * @param bool $startDate
     * @param bool $endDate
     * @return array
     */
    public static function getDateByDate($startTime = false, $endTime = false) {
        $data[0] = date('Y-m-d', $startTime);
        while (($startTime = strtotime('+1 day', $startTime)) <= $endTime) {
            $data[] = date('Y-m-d', $startTime);
        }

        return $data;
    }

    /**
     * 时间格式化处理
     * @author: Gene
     * @param int $time
     * @param string $format
     * @return false|string
     */
    public static function showFormatDate($time = 0, $format = 'Y-m-d H:i:s') {
        try {
            if (empty($time) || !is_numeric($time)) {
                return '';
            }

            return date($format, $time);
        } catch (\Exception $e) {
            return '';
        }
    }
}