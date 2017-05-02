<?
/*

This is an implementation of the MD5 hash function, as specified by
RFC 1321, in pure PHP. It was implemented using Bruce Schneier's
excellent book "Applied Cryptography", 2nd ed., 1996.

Pure php md5 implementation

I have simplified the main iteration

@denobisipsis 2017


;)
*/
function MD($string)
    {
    $A = $a = "67452301";
    $B = $b = "efcdab89";
    $C = $c = "98badcfe";
    $D = $d = "10325476";
    
    $words = str2blks_MD5($string);   
    
    $torot=array("A","B","C","D");    

    $it=array(7,12,17,22,5,9,14,20,4,11,16,23,6,10,15,21);

    $funcs=array("F","G","H","I");    
	       
    $moduls=array(0,1,1,5,5,3,0,7);
		
    $i = 0;
            
    while   ($i++ < 64)
    	   {
    	   $acs[$i-1]=dechex(abs(sin($i))* 4294967296);				
    	   } 
            
    for($i = 0; $i < count($words)/16; $i++)
	    {
            $a  = $A;
            $b  = $B;
            $c  = $C;
            $d  = $D;
            $n  = 0; 
	    
	    for ($rot3=0;$rot3<4;$rot3++)
	    	{
	    	$minit=$moduls[$rot3*2];
	   	$madd=$moduls[$rot3*2+1];	
							
	    	for ($rot2=0;$rot2<4;$rot2++)
		    	{
		    	for ($rot=0;$rot<4;$rot++)
			    {
			    $word=$words[$minit + ($i * 16)];
			    $nit=$it[$rot+4*$rot3];
									
			    FGHI (${"$torot[0]"}, ${"$torot[1]"}, ${"$torot[2]"}, ${"$torot[3]"}, $word, $nit, $acs[$n],$funcs[$rot3]); 
									
		    	    array_unshift($torot,$torot[3]);
		            array_pop($torot);
									
			    $minit=($minit+$madd)%16;
			    ++$n;
			    }	    
		    	 }
	    	}
	    
            $A=AddUnsigned(hexdec2($A),hexdec2($a));
            $B=AddUnsigned(hexdec2($B),hexdec2($b));
            $C=AddUnsigned(hexdec2($C),hexdec2($c));
            $D=AddUnsigned(hexdec2($D),hexdec2($d));    
    	    }

   	return WordToHex($A).WordToHex($B).WordToHex($C).WordToHex($D);
	}

function WordToHex($lValue) 
   { 
    $WordToHexValue = "";
    for ($lCount = 0;$lCount<4;$lCount++) 
        { 
        $lByte = hexdec2($lValue)>>($lCount*8) & 255; 
        $WordToHexValue.= sprintf("%02x",$lByte);
        }
    return $WordToHexValue;
    }

function FGHI(&$A, $B, $C, $D, $M, $s, $t, $func)
        {
        $Level1 = hexdec2(AddUnsigned(FGHI2($B, $C, $D, $func) , bindec($M) ));
        $level2 = hexdec2(AddUnsigned($Level1, hexdec2($t)));  
        $A = hexdec2(AddUnsigned(hexdec2($A),$level2));
        $A = rotate($A, $s); 
        $A = AddUnsigned($A , hexdec2($B)) ; 
        }

function FGHI2($X, $Y, $Z,$func)
        {    
        $X = hexdec2($X); 
        $Y = hexdec2($Y);
        $Z = hexdec2($Z);
        
	switch ($func)
		{
		case "F":
	        	$calc = (($X & $Y) | ((~ $X) & $Z));break;
		case "G":
			$calc = (($X & $Z) | ($Y & (~ $Z)));break;
		case "H":
			$calc = ($X ^ $Y ^ $Z);break;
		case "I":
			$calc = ($Y ^ ($X | (~ $Z)));
		}
        return  $calc; 
  	}

function dectohex($res)
	{
        if($res < 0)
            return '-'.dechex(abs($res));

        return dechex($res);	
	}
	
function hexdec2($hex)
    {  
    if($hex[0] == "-")   
        return doubleval('-'.hexdec(str_replace("-", "", $hex )));
    
    return hexdec($hex);
    }
	
function AddUnsigned($lX,$lY) 
   { 
    $lX8 = ($lX & 0x80000000);
    $lY8 = ($lY & 0x80000000);
    $lX4 = ($lX & 0x40000000);
    $lY4 = ($lY & 0x40000000);
    
    $lResult = ($lX & 0x3FFFFFFF)+($lY & 0x3FFFFFFF);
    
    $res=$lResult ^ $lX8 ^ $lY8;
    
    if ($lX4 & $lY4)                       return dectohex($res ^ 0x80000000);   
    if ($lX4 | $lY4) 
	{
        if ($lResult & 0x40000000)         return dectohex($res ^ 0xC0000000);
        else                               return dectohex($res ^ 0x40000000);       
    	}                                  return dectohex($res);
    }

function rotate ($decimal, $bits) 
    { 
    return  (($decimal << $bits) |  shiftright($decimal, (32 - $bits))  & 0xffffffff);
    }

function shiftright($decimal , $right)
    { 
    $shift=$decimal >> $right;
    
    if($decimal >= 0) return $shift;

    return bindec(substr(decbin($shift),$right));
    }
    	
function str2blks_MD5($str)
  {
  $nblk = ((strlen($str) + 8) >> 6) + 1;
	
  $blks = array($nblk * 16);
	
  for($i = 0; $i < $nblk * 16; $i++) 
				$blks[$i] = 0;
				
  for($i = 0; $i < strlen($str); $i++)
    		$blks[$i >> 2] |= ord($str[$i]) << (($i % 4) * 8);
				
  $blks[$i >> 2] |= 0x80 << (($i % 4) * 8);
	
  $blks[$nblk * 16 - 2] = strlen($str) * 8;
	
  for ($i=0; $i < $nblk * 16; $i++) 			
      	$blks[$i] = decbin($blks[$i]);
           
  return $blks;
  }

$str='test';
echo md5($str); // 098f6bcd4621d373cade4e832627b4f6
echo'<br>';
echo MD($str); //  098f6bcd4621d373cade4e832627b4f6
