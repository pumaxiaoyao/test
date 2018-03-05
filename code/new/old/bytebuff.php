<?php     
// i为标识，为1时，后面数据为数值，为2时，后面数据为字符串，为3时，后面数据为bool, 暂时这样处理
echo strlen(pack("c", 1)).'<br/>';
echo strlen(pack("i",99999)).'<br/>';
echo strlen(pack("a","a")).'<br/>';
echo strlen(pack("a*","abc")).'<br/>';
echo strlen(pack("c","0")).'<br/>';
echo strlen(pack("c","11")).'<br/>';
echo join("", unpack("a*", pack("a*", "abc"))).'<br/>';
echo join("", unpack("i", pack("i", 9999111119))).'<br/>';
$binarydata = pack("cica*cc", "i", 999, "s", "alien", "b", "0");

$_file = fopen("test.txt", "w");
fwrite($_file, $binarydata);
fclose($_file);

class writehandler{
    public $streambuffer = "";

    function writeData($format, $data){
        $ret = pack($format, $data);
    }
}

class readhandler{
    public $streambuffer = "";
    public $pos = 0;
    public $leftLength = 0;
    public $totalLength = 0;

    private $Charfmt = "c";
    private $charsize = 1;
    
    private $Strfmt = "a*";
    private $Strsize = 1;
    
    private $Intfmt = "i";
    private $Intsize = 4;
    
    function setStream($fstream, $filelen)
    {
        $this->streambuffer = $fstream;
        $fd = fread($this->streambuffer, $filelen);
        echo $fd.'<br/>';
        $this->totalLength = strlen($fd);
        fseek($this->streambuffer, 0);
    }

    function readData($format, $length = 0){
        echo "当前指针位置是 -- ".ftell($this->streambuffer);
        echo '<br/>'."当前数据类型是 -- ".$format;
        $ret = '';
        if (in_array($format, array("i", "c", "b"))){
            // 定长数据读取
            $ret = unpack($format, fread($this->streambuffer, $length));
        }elseif ($format == "b"){
            $_ret = unpack($format, fread($this->streambuffer, $length));
            if ($_ret == "0"){
                $ret = false;
            }else{
                $ret = true;
            }
        }else{
            // str 支持变长数据，format可以填写为a*，读取到字符串的结尾或文件尾
            $ret = unpack($format, fread($this->streambuffer, $this->leftLength));
        }
        echo '<br/>'."当前读取到的内容是 -- ".join("", $ret);
        return $ret;
    }
    function readBoolean(){
        return $this->readData("b", 1);
    }

    function readChar(){
        return $this->readData('c', 1);
    }

    function readNumber(){
        return $this->readData("i", 4);
    }

    function readString(){
        return $this->readData('a*');
    }

    function parseData(){
        do{
            $dataType = $this->readChar();
            $val = "";
            switch($dataType){
                case "b":
                    // boolean, php's char - c
                    $val = $this->readBoolean();
                    break;
                case "i":
                    // int
                    $val = $this->readNumber();
                    break;
                case "s":
                    // string
                    $val = $this->readString();
                    break;
                
            }
            echo $val.'<br/>';
            $this->leftLength = $this->totalLength - ftell($this->streambuffer);
            echo '<br/>'."剩余长度还有 -- ".$this->leftLength;    
            echo '<br/>'."------------<br/>";
        }while($this->leftLength >0);
    }
}
echo "<br/>-----------debug info ----------------------<br/>";
$_file = fopen("test.txt", "rb");
$kodo = new readhandler();
$kodo->setStream($_file, filesize("test.txt"));
$kodo->parseData();
fclose($_file);


// // session_start();

// function showHeader(){
//     $page = file_get_contents('./html/header.html');
//     echo $page;
// };

// function showFooter(){
//     $page = file_get_contents('./html/footer.html');
//     echo $page;
// };

// function showIndex(){
//     $page = file_get_contents('./html/index.html');
//     echo $page;
// };

// showIndex();
?>   