### Yii2 Seed General


#### 关于入口文件(index.php)说明
> 1、该文件不允许提交,防止环境冲突;文件中定义了四种环境变量,如果其他有需要使用到环境变量的,一定请使用预定义常量,全局统一。
 2、不允许在该文件中定义或者写其他的代码,如果需要预加载其他文件或者代码,请在config/bootstrap.php中加入。


```
curl -sS https://getcomposer.org/installer | php
php composer.phar require --prefer-dist yiisoft/yii2-redis
```
