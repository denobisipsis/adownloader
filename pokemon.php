<?
	function encodeurl($data,$key)
		{
		$code=hash_hmac('sha256', $data, $key,true);
		return rtrim(strtr(base64_encode($code), '+/', '-_'), '='); 
		}
	function arcdecrypt($data,$key)
		{
		for($i,$c;$i<256;$i++)$c[$i]=$i;
		for($i=0,$d,$e,$g=strlen($key);$i<256;$i++)
			{
			 $d=($d+$c[$i]+ord($key[$i%$g]))%256;
			 $e=$c[$i];
			 $c[$i]=$c[$d];
			 $c[$d]=$e;
			}
		for($y,$i,$d=0,$f;$y<strlen($data);$y++)
			{
			 $i=($i+1)%256;
			 $d=($d+$c[$i])%256;
			 $e=$c[$i];
			 $c[$i]=$c[$d];
			 $c[$d]=$e;
			 $f.=chr(ord($data[$y])^$c[($c[$i]+$c[$d])%256]);
			}		
		return gzuncompress($f);				
		}
	
	echo "pokemon<br>";
	
  $contenth=file_get_contents($url));
	
	$id=extrae($contenth,'data-video-id=','"','"');
	
	$key2= "S2i$+PX,Xf!,5|^8";
	$aKEY= "RC4\n$key2";
	$key = "ja->>GBcLka9?hbT";
	
	$c1=encodeurl($aKEY,$key);
	$c2=encodeurl("Media",$key);
	$c3=encodeurl($id,$key);
	
	$streams=arcdecrypt(file_get_contents("http://cache2.delvenetworks.com/ps/c/v1/$c1/$c2/$c3"),$key2);
	?>
