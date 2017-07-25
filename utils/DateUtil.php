<?php
/**
 * 日期工具类
 * @author: Gene
 */
namespace app\utils;

class DateUtil {
    public static $weeks = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];


    /**
     * 根据时间戳获取星期名称
     * @param int $time
     * @return mixed
     */
    public static function getWeekByTime($time = false) {
        if (!is_numeric($time)) {
            return '';
        }
        $weekNum = date('w', $time);

        return self::$weeks[$weekNum];
    }


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