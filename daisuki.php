<?

// always the same, the key is generated every time you get a video, so it doesnt matter

	$key="DyZIQx2LUnEEl4Wk";
	
// here you find the public pem key

	$libs="http://www.daisuki.net/etc/designs/daisuki/clientlibs_anime_watch.min.js";
	
	$headers = array(
		          "User-Agent: 		android",
		          "Accept: */*",
		          "Connection: 		keep-alive",
		          "Accept-Encoding: 	"
		        );
					
	$publickeypem=trim(extrae(curl_proxy($libs,"",$topenlace,$headers),'var publickeypem','"','"'));
	
	// after extracted the public pem key must be fixed 
	
	$publickeypem=hex2bin(str_replace("5c6e","0a",bin2hex($publickeypem)));
	
	/* 
	
	we need to make a call with parameters 
	e-> url
	a-> local key rsa encrypted with public pem key
	d-> api_parameters from flashvars aes_encrypted with local key
	c-> language/Region
	*/
	
	$ClavePublica = openssl_pkey_get_public($publickeypem);
	openssl_public_encrypt($key, $encrypted, $ClavePublica);
	$a = urlencode(base64_encode($encrypted));
	
	$api_params["s"] 		= extrae($contenth,"'s'",':"','"');
	$api_params["mv_id"] 		= extrae($contenth,'"mv_id"',':"','"');
	$api_params["device_cd"] 	= extrae($contenth,'"device_cd"',':"','"');
	$api_params["ss1_prm"] 		= extrae($contenth,'"ss1_prm"',':"','"');
	$api_params["ss2_prm"] 		= extrae($contenth,'"ss2_prm"',':"','"');
	$api_params["ss3_prm"] 		= extrae($contenth,'"ss3_prm"',':"','"');
	 
	$d=urlencode(base64_encode(mcrypt_cbc(MCRYPT_RIJNDAEL_128,$key,json_encode($api_params),MCRYPT_ENCRYPT)));
	
	// we make the call to get a json with rtn encrypted, to aes_decrypt with local key
	
	$rtn=json_decode(curl_proxy("http://www.daisuki.net/bin/bgn/init?e=".urlencode($topenlace)."&d=$d&s=ServerControlled&a=$a&c=".$api_params["ss3_prm"],"","",$headers));
	
	$rtn=$rtn->rtn;
	
	$f4m=json_decode(trim(mcrypt_cbc(MCRYPT_RIJNDAEL_128,$key,base64_decode($rtn),MCRYPT_DECRYPT,"")));
	
	// we obtain an adobe hds manifest downloadable with AdobeHDS.php by KSV. All mechanized in Adownloader
	
	$f4m=$f4m->play_url."&hdcore=2.10.3&g=UPEJFFLSWBFW";exit;
	?>
