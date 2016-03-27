	<?
	function getNumber1($str)
		{
		if (strlen($str) >= 2)    $pos=(238 ^ 228) - 1;
		else			                $pos=192 >> 2 * 3;
		
		$s = substr(substr(substr("kekokola".$str,$pos,1),(7 & 0) & 107,1),((204 ^ 119) >> 8) >> 10 - 3,1);
		
		return $s;
		}	
		
	function method_2() // og
		{				
		$_loc2_ = getNumber1("k");
		$_loc3_ = getNumber1("ggnotice");
		return $_loc2_.$_loc3_;
		}
	
	function method_3($n) 
		{
		$x = $i = 0;
		$s = "";
		$str	="0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
		
		while($i < $n)
			{
			$x = mt_rand(0,strlen($str));
			$s.= substr($str,$x,1);
			$i++;
			}
			
		return $s;
		}
			
	function getHashCash($tokenvv) 
		{	
		while(substr(sha1($tokenvv.$s, true),0,2) != "og")
			{
			$s = method_3(16);
			}
			
		return $s;
		}
	
	$sidtoken	=ee("becaf9be",base64_decode(($json12->data->security->encrypt_string)));
	
	$sid		  =explode("_",$sidtoken)[0];
	$token		=explode("_",$sidtoken)[1];	
	
	$tokenvv	=$json10->data->token->vv;
	$tokenup	=$json10->data->token->up;
		
	$hashcash = getHashCash($tokenvv."o");

	$post="videoid=$v&url=$topenlace&sid=$sid&referer=null&uid=0&totalseg=&totalsec=&h=$hashcash&fullflag=0&t=$tokenvv&ikuflag=u1%5Fm1&source=video";
	
	$call="http://stat.youku.com/player/addPlayerStaticReport";
	
	$stat=curl_proxy($call,"","",$headers,1,$post,0,$cookie);

	$cookie.=getcookie($stat,"_f");
	?>
