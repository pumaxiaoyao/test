<?php

/**
 * 验证码类功能
 */
class ValidateCode
{
    private $_charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';//随机因子
    private $_code;//验证码
    private $_codelen = 4;//验证码长度
    private $_width = 120;//宽度
    private $_height = 50;//高度
    private $_img;//图形资源句柄
    private $_font;//指定的字体
    private $_fontsize = 18;//指定字体大小
    private $_fontcolor;//指定字体颜色
    
    /**
     * 构造方法初始化
     */
    public function __construct()
    {
        $this->_font = dirname(__FILE__).'/font/Elephant.ttf';//注意字体路径要写对，否则显示不了图片
    }
    
    /**
     * 生成随机码
     *
     * @return void
     */
    private function _createCode()
    {
        $_len = strlen($this->_charset)-1;
        for ($i=0;$i<$this->_codelen;$i++) {
            $this->_code .= $this->_charset[mt_rand(0, $_len)];
        }
    }
    
    /**
     * 生成背景
     *
     * @return void
     */
    private function _createBg()
    {
        $this->_img = imagecreatetruecolor($this->_width, $this->_height);
        $color = imagecolorallocate($this->_img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
        imagefilledrectangle($this->_img, 0, $this->_height, $this->_width, 0, $color);
    }
    
    /**
     * 生成文字
     *
     * @return void
     */
    private function _createFont()
    {
        $_x = $this->_width / $this->_codelen;
        for ($i=0;$i<$this->_codelen;$i++) {
            $this->_fontcolor = imagecolorallocate($this->_img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imagettftext($this->_img, $this->_fontsize, mt_rand(-30, 30), $_x*$i+mt_rand(1, 5), $this->_height / 1.4, $this->_fontcolor, $this->_font, $this->_code[$i]);
        }
    }
    /**
     * 生成雪花、线条
     *
     * @return void
     */
    private function _createLine()
    {
        //线条
        for ($i=0;$i<6;$i++) {
            $color = imagecolorallocate($this->_img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imageline($this->_img, mt_rand(0, $this->_width), mt_rand(0, $this->_height), mt_rand(0, $this->_width), mt_rand(0, $this->_height), $color);
        }
        //雪花
        for ($i=0;$i<100;$i++) {
            $color = imagecolorallocate($this->_img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            imagestring($this->_img, mt_rand(1, 5), mt_rand(0, $this->_width), mt_rand(0, $this->_height), '*', $color);
        }
    }
    
    /**
     * 输出
     *
     * @return void
     */
    private function _outPut()
    {
        header('Content-type:image/png');
        imagepng($this->_img);
        imagedestroy($this->_img);
    }

    /**
     * 外部调用生成验证码
     *
     * @return void
     */
    public function doimg()
    {
        $this->_createBg();
        $this->_createCode();
        $this->_createLine();
        $this->_createFont();
        $this->_outPut();
    }
 
    /**
     * 获取验证码
     *
     * @return void
     */
    public function getCode()
    {
        return strtolower($this->_code);
    }
}
?>