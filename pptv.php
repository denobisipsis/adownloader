/*
extractors/pptv.py

You need to make the call to api as 

http://web-play.pptv.com/webplay3-0-$id.xml?version=4&param=type=web.fpp&ahl_ver=1

to get HD streams

Then, in dt tree you can find key & iv, sh & bh servers, id & flag & st

mp4 is armed as follows

$mp4="http://$dtsh/$no/0/1023/$rid?fpp.ver=1.3.0.20&type=web.fpp&k=$k";

where $k=kdecrypt($dtkey, $dtflag, $dtsh, $VodPlayst, $dtid, $dtbh, $dtiv);
*/

	
function kdecrypt($dtkey, $dtflag, $dtsh, $VodPlayst, $dtid, $dtbh, $dtiv)
	{
	$playAppKey="V8oo0Or1f047NaiMTxK123LMFuINTNeI";
		
	$decrypt = substr($dtkey,0,32);
	
	$key=hash("sha256",$dtsh.$VodPlayst.$dtid.$dtbh.$dtiv.$playAppKey);
	
	$d=bin2hex(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128,pack("H*",$key),pack("H*",$decrypt),MCRYPT_MODE_ECB),"\x00..\x1F"));
	
	return $d.substr($dtkey,32);
	}
  
