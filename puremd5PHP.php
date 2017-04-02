<?
/*
This is an implementation of the MD5 hash function, as specified by
RFC 1321, in pure PHP. It was implemented using Bruce Schneier's
excellent book "Applied Cryptography", 2nd ed., 1996.

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
		
    $acs=array(	"d76aa478","e8c7b756","242070db","c1bdceee",
    	        	"f57c0faf","4787c62a","a8304613","fd469501",
	            	"698098d8","8b44f7af","ffff5bb1","895cd7be",
	            	"6b901122","fd987193","a679438e","49b40821",
	       
	            	"f61e2562","c040b340","265e5a51","e9b6c7aa",
    	        	"d62f105d","2441453","d8a1e681","e7d3fbc8",
	            	"21e1cde6","c33707d6","f4d50d87","455a14ed",
	            	"a9e3e905","fcefa3f8","676f02d9","8d2a4c8a",
	       
	            	"fffa3942","8771f681","6d9d6122","fde5380c",
    	        	"a4beea44","4bdecfa9","f6bb4b60","bebfbc70",
	            	"289b7ec6","eaa127fa","d4ef3085","4881d05",
	            	"d9d4d039","e6db99e5","1fa27cf8","c4ac5665",  
	       
	            	"f4292244","432aff97","ab9423a7","fc93a039",
    	        	"655b59c3","8f0ccc92","ffeff47d","85845dd1",
	            	"6fa87e4f","fe2ce6e0","a3014314","4e0811a1",
	            	"f7537e82","bd3af235","2ad7d2bb","eb86d391"); 
            
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
