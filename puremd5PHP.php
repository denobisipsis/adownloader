<?
/*
This is an implementation of the MD5 hash function, as specified by
RFC 1321, in pure PHP. It was implemented using Bruce Schneier's
excellent book "Applied Cryptography", 2nd ed., 1996.

I have simplified the main iteration

@denobisipsis 2017
;)
*/
class MD
{
function WordToHex($lValue) 
    { 
    while ($lCount<4) 
        $WordToHexValue.= sprintf("%02x",$lValue>>($lCount++*8) & 255);
    return $WordToHexValue;
    }		
function AddUnsigned($a,$b) 
    {
    return(($a>>1)+($b>>1)<<1)+(1&$a)+(1&$b);       
    }
function shiftright($decimal , $right)
    { 
    $shift=$decimal >> $right;    
    if($decimal >= 0) return $shift;
    return bindec(substr(decbin($shift),$right));
    }		
function calc($string)
	{
	$A = 1732584193;$B = -271733879;$C = ~$A;$D = ~$B;;
	
	$k=strlen($string);$words=array();	  
	  	
	for($m=0;$k>$m;) $words[$m>>2]|=ord($string[$m]) << (8 * ($m++ % 4));
	
	$words[$m >> 2] |= 0x80 << (($m % 4) * 8);		
	$words[($wl=(($k+8)>>6)*16+14)] = 8 * $k;	
	$vr=$wr=array("A","B","C","D");    	
	$it=array(7,12,17,22,5,9,14,20,4,11,16,23,6,10,15,21);	       
	$moduls=array(0,1,1,5,5,3,0,7); 			
			               
	for($i = 0; $i < $wl/16; $i++)
		    {	    
		    $w=-1;while($w++<4) ${chr($w+65+32)}=${chr($w+65)};
		    
		    for ($n=0;$n<64;$n++)
			{
			$m = $n >> 4;
							    				
			$minit=$moduls[($m % 16) * 2];
			$madd =$moduls[($m % 16) * 2+1];				    					    				
															
		        $X = ${"$vr[1]"}; 
		        $Y = ${"$vr[2]"};
		        $Z = ${"$vr[3]"};
			
			$t = sprintf("%'.04d",decbin(1 << $m));
		        
			$calc = (($X&$Y)|((~$X)&$Z))*$t[3] | 
				(($X&$Z)|($Y&(~$Z)))*$t[2] | 
				($X^$Y^$Z)*$t[1] | 
				($Y^($X|(~$Z)))*$t[0];
						 													
			$level12 = $this->AddUnsigned(
					$this->AddUnsigned($calc,$words[($minit+$madd*$n)%16+($i*16)])
					,abs(sin($n+1))*4294967296); 
			
		        ${"$vr[0]"} = $this->AddUnsigned((${"$vr[0]"}),$level12);			
			${"$vr[0]"} = (${"$vr[0]"}<<($bits=$it[4*$m+$n%4]))|
					$this->shiftright(${"$vr[0]"},(32 - $bits));
		        ${"$vr[0]"} = $this->AddUnsigned(${"$vr[0]"},(${"$vr[1]"}));
								
			array_pop(array_unshift($vr,$vr[3]));
			}
		    
		    foreach ($wr as $w) ${"$w"}=$this->AddUnsigned(${"$w"},${chr(ord($w)+32)});	      		    		    
	    	    }
		
	return $this->WordToHex($A).$this->WordToHex($B).$this->WordToHex($C).$this->WordToHex($D);
	}
}
$str='test';$a=new MD();echo md5($str).'<br>'.$a->calc($str);
