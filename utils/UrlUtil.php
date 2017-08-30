<?php
/**
 * Url构造工具
 * @author: Gene
 */
namespace app\utils;


class UrlUtil {


    /**
     * 获取当前链接的域名
     * @return string
     */
    public static function getCurrentDomain() {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
    }

    /**
     * 获取当前链接
     * @return string
     */
    public static function getCurrentUrl() {
        return self::getCurrentDomain() . $_SERVER['REQUEST_URI'];
    }


    /**
     * 根据已有url和新的数组重新生成url
     * @param string $url
     * @param array $param
     * @return bool|string
     */
    public static function getNewUrlByUrl(string $url, array $param) {
        try {
            $data = self::getUrlInfo($url);
            $url  = $data['url'];
            $param = array_merge($data['params'], $param);

            return $url . '?' . self::getParams($param);
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * 根据URL获取信息,返回基本Url和参数
     * @param string $url
     * @return array
     */
    public static function getUrlInfo(string $url) {
        $data = ['url' => '', 'params' => []];
        $info = explode('?', $url);
        $data['url'] = $info[0];
        if (!empty($info[1])) {
            $params = explode('&', $info[1]);
            foreach ($params as $param) {
                try {
                    $paramArr = explode('=', $param);
                    $data['params'][$paramArr[0]] = $paramArr[1];
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return $data;
    }


    /**
     * 根据数组获取URL参数字符串
     * @param array $params
     * @return string
     */
    public static function getParams(array $params) {
        $result = '';
        foreach ($params as $name => $value) {
            preg_match('/(http|https):\/\/[a-zA-Z\d.&=?_]+/', $value, $url);
            if (isset($url[0]) || !empty($url[0])) {
                $value = urlencode($value);
            }
            $result .= '&' . $name . '=' . $value;
        }

        if (!empty($result)) {
            $result = mb_substr($result, 1);
        }

        return $result;
    }


    /**
     * 获取内容里面的所有连接地址
     * @param string $content
     * @param bool $isDomain
     */
    public static function getUrlsByContent(string $content, bool $isDomain = false) {
        preg_match_all('/(http|https):\/\/[a-zA-Z\d.&=?_\/]+/i', $content, $urls);

        $data = [];
        if ($isDomain) {
            foreach ($urls[0] as $url) {
                list($pre, $domain) = explode("://", $url);
                array_push($data, $domain);
            }
        } else {
            $data = $urls[0];
        }

        return $data;
    }
}