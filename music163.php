<?
/*
http://music.163.com/#/song?id=423406359

makes post-call to get the mp3-stream,

with params & enseckey

params is a json like {"ids":"['.$id.']","br":'.$br.',"csrf_token":"'.$csrf_token.'"}

params is twice aes-128-cbc padding encrypted:

1- with key 0CoJUm6Qyw8W8jud
2- with a random 16 bytes key, $key

Then, enseckey is rsa encryption of $key with:

- modulus 00e0b509f6259df8642dbc35662901477df22677ec152b5ff68ace615bb7b725152b3ab17a876aea8a5aa76d2e417629ec4ee341f56135fccf695280104e0312ecbda92557c93870114af6c9d05c4f7f0c3685b7a46bee255932575cce10b424d813cfe4875d3e82047b97ddef52741d546b8e289dc6935b3ece0462db0a22b8e7
- exponent 010001

*/
function getenseckey($key)
	{
	$e = "0x10001";
	$m = "0xe0b509f6259df8642dbc35662901477df22677ec152b5ff68ace615bb7b725152b3ab17a876aea8a5aa76d2e417629ec4ee341f56135fccf695280104e0312ecbda92557c93870114af6c9d05c4f7f0c3685b7a46bee255932575cce10b424d813cfe4875d3e82047b97ddef52741d546b8e289dc6935b3ece0462db0a22b8e7";
	$key=implode(array_Reverse(str_split($key)));
	return gmp_strval(gmp_powm('0x'.bin2hex($key), $e, $m),16);
	}
function pkcs5_pad ($text, $blocksize) 
	{ 
        $pad = $blocksize - (strlen($text) % $blocksize); 
    	return $text . str_repeat(chr($pad), $pad); 
	} 
function encrypt($input,$key) 
	{ 
    	$size = mcrypt_get_block_size('rijndael-128', 'cbc'); 
    	$input = pkcs5_pad($input, $size); 

    	$td = mcrypt_module_open('rijndael-128', '', 'cbc', ''); 
    	$iv = "0102030405060708"; 
    	mcrypt_generic_init($td, $key, $iv); 
    	$data = mcrypt_generic($td, $input); 
    	mcrypt_generic_deinit($td); 
    	mcrypt_module_close($td); 
    	return $data; 
	} 
function getparams($json,$key)
	{
	$p=base64_encode(encrypt($json,"0CoJUm6Qyw8W8jud"));
	return urlencode(base64_encode(encrypt($p,$key)));
	}

$b = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
$key = "";
for ($d = 0; 16 > $d; $d++)
	    {
            $e = intval(rand(0,strlen($b)-1));
            $key.= $b[$e];
	    }
$json='{"ids":"['.$id.']","br":'.$br.',"csrf_token":"'.$csrf_token.'"}';
$params=getparams($json,$key);
$enseckey=getenseckey($key);

$post='params='.$params.'&encSecKey='.$enseckey;
			
$callurl="http://music.163.com/weapi/song/enhance/player/url?csrf_token=$csrf_token";
			
?>


      
