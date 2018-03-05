<!-- <?php

class Rsa
{

    public $privateKey = '';

    //public $publicKey = base64_decode('ANPpEbTFUhtZvCnnlx4fz02QcmdusxzHspmPlA9hIJO9oPijeCFaQ8Vn0/Dr0ztB+bvHR7b+N+vd7tgWWqGfc9muTC
    //udZ9gRR7LmMOYYB9dZgqpnDa3iU4cU556qi3dt/L5SPl7Q9FcG/Vpf3LFNWSfoUVfJT1lY9VT9D/2Mp9cH');
    
    public function __construct()
    {
        // $resource = openssl_pkey_new();
        // openssl_pkey_export($resource, $this->privateKey);
        // $detail = openssl_pkey_get_details($resource);
        // $this->publicKey = $detail['key'];
    }

    public function publicEncrypt($data, $publicKey)
    {
        openssl_public_encrypt($data, $encrypted, $publicKey);
        return $encrypted;
    }

    public function publicDecrypt($data, $publicKey)
    {
        openssl_public_decrypt($data, $decrypted, $publicKey);
        return $decrypted;
    }

    public function privateEncrypt($data, $privateKey)
    {
        openssl_private_encrypt($data, $encrypted, $privateKey);
        return $encrypted;
    }

    public function privateDecrypt($data, $privateKey)
    {
        openssl_private_decrypt($data, $decrypted, $privateKey);
        return $decrypted;
    }
}

$rsa = new Rsa();
echo "公钥：\n", $rsa->publicKey, "\n";
echo "私钥：\n", $rsa->privateKey, "\n";

// 使用公钥加密
$str = $rsa->publicEncrypt('hello', $rsa->publicKey);
// 这里使用base64是为了不出现乱码，默认加密出来的值有乱码
$str = base64_encode($str);
echo "公钥加密（base64处理过）：\n", $str, "\n";
$str = base64_decode($str);
$pubstr = $rsa->publicDecrypt($str, $rsa->publicKey);
echo "公钥解密：\n", $pubstr, "\n";
$privstr = $rsa->privateDecrypt($str, $rsa->privateKey);
echo "私钥解密：\n", $privstr, "\n";

// 使用私钥加密
$str = $rsa->privateEncrypt('world', $rsa->privateKey);
// 这里使用base64是为了不出现乱码，默认加密出来的值有乱码
$str = base64_encode($str);
echo "私钥加密（base64处理过）：\n", $str, "\n";
$str = base64_decode($str);
$pubstr = $rsa->publicDecrypt($str, $rsa->publicKey);
echo "公钥解密：\n", $pubstr, "\n";
$privstr = $rsa->privateDecrypt($str, $rsa->privateKey);
echo "私钥解密：\n", $privstr, "\n";

?> -->
