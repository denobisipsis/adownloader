/*
extractors/pptv.py

You need to make the call to api as 

http://web-play.pptv.com/webplay3-0-$id.xml?version=4&param=type=web.fpp&ahl_ver=1

to get HD streams

Then, in dt tree you can find key & iv, sh & bh servers, id & flag & st

mp4 is armed as follows

$mp4="http://$dtsh/$no/0/1023/$rid?fpp.ver=1.3.0.23&type=web.fpp&k=$k&key=$key";

where 

$k=kdecrypt($dtkey, $dtflag, $dtsh, $VodPlayst, $dtid, $dtbh, $dtiv);

&

$key=ckey::encrypt(dechex(strtotime($VodPlayst)-60),"qqqqqww");

i.e.

ckey::encrypt(dechex(strtotime("Fri May 26 22:32:19 2017 UTC")-60),"qqqqqww") -> 43feaf57e8875f76fc96753953e2583e
*/

	
function kdecrypt($dtkey, $dtflag, $dtsh, $VodPlayst, $dtid, $dtbh, $dtiv)
	{
	$playAppKey="V8oo0Or1f047NaiMTxK123LMFuINTNeI";
		
	$decrypt = substr($dtkey,0,32);
	
	$key=hash("sha256",$dtsh.$VodPlayst.$dtid.$dtbh.$dtiv.$playAppKey);
	
	$d=bin2hex(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128,pack("H*",$key),pack("H*",$decrypt),MCRYPT_MODE_ECB),"\x00..\x1F"));
	
	return $d.substr($dtkey,32);
	}
  
class ckey
{
function shiftright($decimal , $right)
	{
	$decimal&=0xFFFFFFFF;
	$shift=$decimal >> $right;    
	if($decimal >= 0) return $shift;
	return bindec(substr(decbin($shift),$right));
	}
    
function charsToLongs($arg)
	{
	$l2 = array();$l3 = -1;
	
	while (++$l3 < ceil((sizeof($arg) / 4))) 
		{
		$temp=0;
		
		for ($t=0;$t<4;$t++) 
			$temp+=$arg[$l3*4+$t] << $t*8;
		
		$l2[] = $temp;
		}
	return $l2;
	}
	    	
function longsToChars($arg)
	{     
	$l3 = -1;$l2="";
	
	while (++$l3 < sizeof($arg)) 	
		for ($t=0;$t<4;$t++) $l2.=strrev(bin2hex(chr(($arg[$l3] >> 8*$t) & 0xFF)));		
	
	return $l2;
	}  
	    
function getkey($key)
	{
	$l2=array_values(unpack("C*",$key));
	
	$l4=$l3=0;
	
	while($l4<sizeof($l2))	     
		$l3^=$l2[$l4]<<($l4++ %4)*8;
	
	return $l3;	 
	}

function encrypt($string, $key) 
	{
	$key = ckey::getkey($key);//1896220160

	for ($k=1;$k<4;$k++)
		${"k$k"} = $key << 8*$k | ckey::shiftright($key , 32 - 8*$k);
			
	$p=ckey::charsToLongs(array_map("ord",str_split($string)));

	$x = 0; $y = -1;
	
	while(++$y < 32)
		{
		$x+= 2654435769;
		
		$t1 = ($p[1] << 4) + $key;
		$t2 = $p[1] + $x;
		$t3 = ckey::shiftright($p[1] , 5) + $k1;
		$p[0]+= $t1 ^ $t2 ^ $t3;		
		
		$t4 = ($p[0] << 4) + $k2;
		$t5 = $p[0] + $x;
		$t6 = ckey::shiftright($p[0] , 5);
		$p[1]+= $t4 ^ $t5 ^ ($t6 + $k3);			
		}

         for ($i=0;$i<8;$i++)		     		     
		$z.=dechex(intval(rand(0,15))).dechex(intval(rand(0,15)));
	    		    				
	return ckey::longsToChars(array($p[0],$p[1])).$z;
	}
}
