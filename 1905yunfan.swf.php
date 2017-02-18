<?
	// yunfan decryption http://sdk.yunfan.com/config/1905/1905yunfan.swf?2017218
	
function Zarr(&$R,$n,$m="")
	{			
	if ($m=="")
		{
		$c=4;
		
		while (--$c>=0) $m.=sprintf("%02X",$R[$n+$c]);
		
		return @array_shift(unpack("L",strrev(pack("H*",$m))));
		}

	$type=array_values(unpack("C*",pack("L",$m)));
	foreach ($type as $byte) {$R[$n++]=$byte;}	
	}

function _trshift($integer, $n)
	{		
	if ($n==0) return $integer;

	$integer=uint32($integer);

	if (0 > $integer)
		{
		$integer &= 0x7fffffff;         
		$integer >>= $n;                   
		$integer |= 1 << (31 - $n); 
		}
	else    $integer >>= $n;
	
  return $integer;
  }
		    
function uint32($integer)
    {
    if (0xffffffff < $integer || -0xffffffff > $integer)
            	  $integer = fmod($integer, 0xffffffff + 1);

    if (0x7fffffff < $integer)
		  $integer -= 0xffffffff + 1.0;
    elseif (-0x80000000 > $integer)
		  $integer += 0xffffffff + 1.0;
		
    return 	  $integer;
    }	     
					
function dec($param1) 
	{
	$_loc11_ = $_loc12_ =$_loc13_ =$_loc14_ =0;
	
	$_loc2_ = 2677129852557;
	$_loc3_ = $_loc2_ + 84836237;
	$_loc4_ = $_loc2_ + 278417278;
	$_loc5_ = $_loc2_ + 1995388704;
	
	$_loc7_ = 0;
	$_loc10_ = sizeof($param1);
	$rs=array(2,3,1,5);
	
	while($_loc10_ > 7)
		{
		$_loc11_ = 3816266640;
		$_loc12_ = Zarr($param1,$_loc7_);
		$_loc13_ = Zarr($param1,$_loc7_ + 4);

		$_loc14_ = 16;
		
		while($_loc14_--)
			{
			$init=4;
				
			foreach ($rs as $op)
				{		         
				$_loc13_-= (($_loc12_ << $init) + $_loc4_ ^ $_loc12_ + $_loc11_ ^ _trshift($_loc12_ , $op) + $_loc5_);		
				$_loc12_-= (($_loc13_ << $init) + $_loc2_ ^ $_loc13_ + $_loc11_ ^ _trshift($_loc13_ , $op) + $_loc3_);
				
				$init+=3;if ($init==10) ++$init;
				}
			
			$_loc11_-=2654435769;	
			}
		
		Zarr($param1,$_loc7_,$_loc12_);
		Zarr($param1,$_loc7_ + 4,$_loc13_);
		
		$_loc7_+=8;
		$_loc10_-=8;
		}
		
	while($_loc10_--)
		{
		$param1[$_loc7_++]^= 255;
		}
		
	return $param1;
	}

function tostr($arr)
	{
	foreach ($arr as $byte) $utf.=chr($byte);
	return $utf;
	}

$file= array_values(unpack("C*",file_get_contents("http://sdk.yunfan.com/config/1905/1905yunfan.swf?2017218")));//flash;
$f=tostr(dec($file));

file_put_contents("yunfandecrypted.swf",$f);
