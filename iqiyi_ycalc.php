<?
/*
01/05/2017

IQIYI YCALC FUNCTION FROM PLAZER_Z

SRC 1702633101b340d8917a69cf8a4b8c7c

EQUALS TO MD5 WITH SALT  u6fnp3eok0dpftcq9qbr4n9svk8tqh7u

STR IS TRANSFORMED THROUGH PREPARECACHE, BUT WITH THE SALT YOU MUST USE WITHOUT IT

@denobis
*/

class ycalc
{
	public $R;
	
	function _rshift($integer, $n)
		{		
		if ($n==0) return $integer;

	  	if (0xffffffff < $integer || -0xffffffff > $integer)         	
	       		$integer = fmod($integer, 0xffffffff + 1);

	    	if (0x7fffffff < $integer)
			      $integer -= 0xffffffff + 1.0;
	    	elseif (-0x80000000 > $integer)
			      $integer += 0xffffffff + 1.0;

		if (0 > $integer)
			{
			$integer &= 0x7fffffff;         
			$integer >>= $n;                   
			$integer |= 1 << (31 - $n); 
			}
		else    $integer >>= $n;
		
	  return $integer;
	  }		
		
	function Zarr($n,$m="")
		{				
		if (!is_numeric($m))
			{
			$c=4;$m="";while (--$c>=0) $m.=sprintf("%02X",$this->R[$n+$c]); 			
			return array_shift(unpack("L",strrev(pack("H*",$m))));
			}
			
		$type=array_values(unpack("C*",pack("L",$m)));
		foreach ($type as $byte) $this->R[$n++]=$byte;	
		}
			
	function si32($n,$m)
		{
		return $this->Zarr($m,$n);	
		}
	function li32($m)
		{
		return $this->Zarr($m,"");	
		}

	function preparecache($str,$flag=1)
		{		
		$l4=array_values(unpack("C*",$str));
		$l5 = sizeof($l4);
		$l6 = round($l5 / 2);
		$l7 = 0;
	
		while($l7 < $l6)
			{		
			$l4[$l7++]-=(3 * $l7) % 5;		
			}
	
		while($l7 < $l5)
			{		
			$l4[$l7]-=(($l7 % 3)*2 + 4) % 5;
			$l7++;
			}
	
		$l8 = $l4[$l5 - 1];
		$l7 = $l5 - 1;
		while($l7 >0)
			{
			$l4[$l7] = $l4[$l7-1];$l7--;
			}
		$l4[0] = $l8;
		
		if ($flag)
			return $l4;
			
		foreach ($l4 as $i) {$l3.=chr($i);}
		
	        return $l3;
		}

function compute($str)
	{
	$this->R=array();
			
	$strc=$this->preparecache($str,1);	
	
	for ($k=1;$k<50;$k++) ${"loc$k"."_"}=0;
							
	$loc1_ = $loc37_= $ESP   = $loc6_ = $loc4_= $loc3_ =  $loc21_ = 1280+16+256;
	$loc1_-= 1280;
	
	$loc7_ = $loc27_= $ESP+320; 
		
	$size  = $loc8_ =  sizeof($strc);
	
	for ($k=$ESP;$k<$ESP+$size;$k++) $this->R[$k]=$strc[$k-$ESP];
	
	$this->si32(1024,$loc1_ - 8,$R,$loc25_);
	$this->si32(0,$loc1_ - 12,$R,$loc25_);
	$loc19_ = $loc37_ - 1280;
	$this->si32($loc19_,$loc1_-16,$R,$loc25_);

	$loc23_ = $loc21_ + 1;
	$loc25_ = 62;
	$loc29_ = 32;
			
	$loc35_ = $loc16_ = 0;

	while   ($loc35_ < 64)
		{
		$loc4_ = abs(sin($loc35_ + 1))* 4294967296;
		$this->si32($loc4_,$loc35_ << 2);
		$loc35_++;				
		}

	$loc8_  = 1732584193;
	$loc6_  = -271733879;
	$loc12_ = -1732584194;
	$loc31_ = 271733878;
       
	$loc13_ = -1;		        
	do 
		{
		$loc5_ = $loc21_ + $loc16_++;
		$loc13_++;			
		}
	while ($this->R[$loc5_] != 0);
	
	$loc25_ = $loc13_ -1;
	$loc33_ = $this->R[$loc21_];
	
	if($loc25_ > 0)
		{
		$loc16_ = $ESP+1;
		$loc17_ = $loc25_;
		$loc22_ = $loc27_;
		do
			{
			$this->R[$loc22_++]=$this->R[$loc16_++];
			}
		while(--$loc17_ != 0);				
		}
		
	$loc5_ = $loc27_ + $loc25_;
	$this->R[$loc5_]=$loc33_;
	
	// transforma al original
	
	$loc16_ = 0;
	if($loc13_ > 1)
		{
		$loc5_  = $loc13_ + $this->_rshift($loc13_, 31);
		$loc16_ = $loc5_ >> 1;
		if($loc16_ <= 1)				
			$loc16_ = 1;				
		$loc17_ = 0;
		$loc22_ = 8;
		while(true)
			{
			$loc5_ = $loc27_ + $loc17_;
			$loc4_ = $this->R[$loc5_];
			$loc20_ = $loc17_ % 7;
			$loc20_ = $loc20_ * 5;
			$loc20_ = $loc22_ + $loc20_;
			$loc20_ = $loc20_ % 5;
			$loc4_ = $loc20_ + $loc4_;
			$this->R[$loc5_]=$loc4_;
			$loc22_+= 3;
			$loc17_++;
			if($loc16_ == $loc17_)	break;
			}
		}
	if($loc16_ < $loc13_)
		{
		$loc5_ = $loc16_ * 5;
		$loc22_ = $loc5_ + 4;
		$loc17_ = $loc16_;			
		while(true)
			{
			$loc5_ = $loc27_ + $loc17_;
			$loc4_ = $this->R[$loc5_];
			$loc20_ = $loc17_ % 3;
			$loc20_ = $loc20_ * 7;
			$loc20_ = $loc22_ + $loc20_;
			$loc20_ = $loc20_ % 5;
			$loc4_ = $loc20_ + $loc4_;
			$this->R[$loc5_]=$loc4_;
			$loc22_+= 5;
			$loc17_++;
			$loc16_ = $loc13_;
			if($loc13_ == $loc17_) break;
			}
		}
		
	$loc5_ = $loc13_ + 32;
	$loc22_ = $loc5_ >> 2;
	$loc5_ = (($loc13_ + 40) >> 2) & -16;
	$loc17_ = $loc5_ | 14;
	$loc33_ = $loc31_;

	if(($loc17_ + 16) >= $loc22_)					
		$loc22_ = $loc17_ + 16;							
		
        $loc16_ = 0;
	while ($loc16_ < $loc22_)
		{
		$this->si32(0,$loc19_ + ($loc16_ << 2));
		$loc16_++;				
		}
		
	// salt generator
	
				
	$loc16_ = 0;
	while ($loc16_ < $loc13_)
		{
		$loc5_ = $loc27_ + $loc16_;
		$loc4_ = $loc16_ >> 31;
		$loc4_ = $loc16_ + $this->_rshift($loc4_ , 30);
		$loc4_1 = $loc16_ - ($loc4_ & 536870908);
		$loc4_ = $loc19_ + ($loc16_ & -4);
		$loc5_ = ($this->R[$loc5_]<<($loc4_1<<3)) | $this->li32($loc4_);
		$this->si32($loc5_,$loc4_);
		$loc16_++;
		}
	

	$loc22_ = $w = 265;
	$loc16_ = 0;
	$loc25_ = 27;
	$loc35_ = 0;								

	while ($loc16_ < 8)
		{			
		$loc5_ = $loc25_ * 25;	
		$loc4_ = $loc5_ + ($loc25_ + 10) * $loc16_;	
		$loc20_1 = ($loc25_ << 1) + (($loc25_ + 2) * $loc35_) -3;	
		$loc26_ = -4 - ($loc35_ << 2);
		$loc20_ = $loc26_ + $loc25_ * ($loc35_ + 3);	
		$loc5_ = ($loc5_ / 3) + 26;	
		$loc4_1 = $loc25_ / 9;	
		$loc24_ = (($loc20_ + $loc20_1 * ($loc4_ -4) + $loc5_ * $loc16_) * ($loc4_1 + 2)) % ($loc25_ + 4);	
		
		if($loc24_ > 9)					
			$loc24_+= 88;
		else    $loc24_+= 48;							
			
		$loc5_ = $loc22_ >> 31;
		$loc5_ = $loc22_ + $this->_rshift($loc5_ , 30);
		$loc5_ = $loc22_ - ($loc5_ & 536870908);
		$loc4_ = $loc19_ + ($loc22_ & -4);
		$loc5_ = ($loc24_ << ($loc5_ << 3)) | $this->li32($loc4_);
		$this->si32($loc5_,$loc4_);
		$loc22_++;
		
		if (++$loc35_ > 3) 
			{
			++$loc16_;$loc35_=0;
			}
					
		$temp=$loc5_;		
		}
	
	
	$loc5_ = $loc22_ >> 31;
	$loc5_ = $loc22_ + $this->_rshift($loc5_ , 30);
	$loc5_ = $loc22_ - ($loc5_ & 536870908);
	$loc4_ = $loc19_ + ($loc22_ & -4);
	$loc5_ = (128 << ($loc5_ << 3)) | $this->li32($loc4_);
	$this->si32($loc5_,$loc4_);	
	
	$loc4_ = ($loc13_ << 3) + 256;
	$this->si32($loc4_,$loc19_ + ($loc17_ << 2));
	
	// salt here for ($k=536+1;$k<536+1+32;$k++) echo chr($this->R[$k]);exit;
        /**************************************************/
		
	// normal md5
	
	$loc16_ = 0;
			 
	while ($loc16_ < $loc17_)
		{
	        $loc33_ = $loc31_;
	        $loc35_ = 0;
		$loc30_ = $loc8_;				
		$loc10_ = $loc6_;
		$loc14_ = $loc12_;
		$loc28_ = $loc31_;
		
		while ($loc35_< 16)
			{
			$loc5_ = ($loc6_ & $loc12_) | ($loc31_ & ($loc6_ ^ -1));
			$loc4_ = $loc8_ & -2;
			$loc4_ = $loc4_ + $loc5_;
			$loc4_ = (($loc4_ & -2) | ($loc8_ & 1)) + ($loc5_ & 1);
		        $t1 = $loc4_ & -2;
			$loc4_ = $loc35_ >> 31;
			$loc20_ = $loc35_ + $this->_rshift($loc4_ , 28);
			$loc20_ = $loc35_ - ($loc20_ & 0x3FFFFFF0);
			$loc20_ = $loc20_ + $loc16_;
			$loc20_ = $loc19_ + ($loc20_ << 2);
			$loc20_ = $this->li32($loc20_);
			$loc34_ = $loc20_ & 1;
			$t2 = $loc34_ | $t1;
			$loc26_ = $loc18_ + ($loc35_ << 2);
			$loc26_ = $this->li32($loc26_);
			$loc32_ = $loc26_ & -2;
			$loc32_ = $loc32_ + $loc20_;
			$loc32_ = ($loc32_ & -2) | ($loc26_ & 1);
			$loc34_ = $loc32_ + $t2;
			$t3 = $loc34_ & -2;
			$loc5_ = $loc5_ + $loc8_;
			$t4=($loc5_ & 1) | $t3;
			$loc20_ = $loc26_ + $loc20_;
			$t5 = ($loc20_ & 1) + $t4;
			$loc4_ = $loc35_ + $this->_rshift($loc4_ , 30);
			$loc4_ = $loc35_ - ($loc4_ & -4);
			$loc20_ = $loc4_ * 5;
			$loc4_ = 25 - $loc20_;
			$loc4_ = $this->_rshift($t5 , $loc4_);
			$loc5_ = $t5 << ($loc20_ + 7);
			$t6 = $loc5_ | $loc4_;
			$loc4_2 = $loc6_ & -2;
			$loc4_1 = $t6 + $loc4_2;
			$loc4_ = ($loc4_1 & -2) | ($loc6_ & 1);
			$t7= $loc4_1 & 1 ;					
			$loc33_ = $loc12_;
			$loc12_ = $loc6_;
			$loc6_ = $loc4_ + $t7;
			$loc8_ = $loc31_;
			$loc31_ = $loc33_;
			$loc35_++;
			}

		while ($loc35_ < $loc29_)
			{
			$loc5_ = ($loc6_ & $loc31_) | ($loc12_ & ($loc31_ ^ -1));
			$loc4_ = $loc8_ & -2;
			$loc4_ = $loc4_ + $loc5_;
			$loc4_ = ($loc4_ & -2 | $loc8_ & 1) + ($loc5_ & 1);
			$t1 = $loc4_ & -2; 
			$loc4_ = $loc35_ * 5;
			$loc4_ = $loc4_ + 1;
			$loc26_ = $loc4_ >> 31;
			$loc26_ = $loc4_ + $this->_rshift($loc26_, 28);
			$loc4_ = $loc4_ - ($loc26_ & 0x3FFFFFF0);
			$loc4_ = $loc4_ + $loc16_;
			$loc4_ = $loc19_ + ($loc4_ << 2);
			$loc4_ = $this->li32($loc4_);
			$loc26_ = $loc4_ & 1;
			$t2 = $loc26_ | $t1;
			$loc20_ = $loc18_ + ($loc35_ << 2);
			$loc20_ = $this->li32($loc20_);
			$loc34_ = $loc20_ & -2;
			$loc34_ = $loc34_ + $loc4_;
			$loc34_ = ($loc34_ & -2) | ($loc20_ & 1);
			$loc26_ = $loc34_ + $t2;
			$t3 = $loc26_ & -2;
			$loc5_ = $loc5_ + $loc8_;
			$t4=($loc5_ & 1) | $t3;
			$loc4_ = $loc20_ + $loc4_;
			$t5 = ($loc4_ & 1) + $t4;
			$loc4_ = $loc35_ >> 31;
			$loc4_ = $loc35_ + $this->_rshift($loc4_ , 30);
			$loc4_ = $loc35_ - ($loc4_ & -4);
			$loc20_ = $loc4_ -1;
			$loc26_ = $loc20_ * $loc4_;
			$loc20_ = $loc26_ + $this->_rshift($loc26_ , 31);
			$loc4_ = $loc4_ << 2;
			$loc4_ = $loc4_ + ($loc20_ >> 1);
			$loc4_ = $loc4_ + 5;
			$loc20_ = 32 - $loc4_;
			$loc20_ = $this->_rshift($t5 , $loc20_);
			$loc5_ = $t5 << $loc4_;
			$t7 = $loc5_ | $loc20_;
			$loc4_2 = $loc6_ & -2;
			$loc4_1 = $t7 + $loc4_2;
			$loc4_ = ($loc4_1 & -2) | ($loc6_ & 1);
			$t6 = $loc4_1 & 1;
			$loc33_ = $loc12_;
			$loc12_ = $loc6_;
			$loc6_ = $loc4_ + $t6;
			$loc8_ = $loc31_;
			$loc31_ = $loc33_; 
			++$loc35_;
			}
		
		while ($loc35_ < 48)
			{
			$loc5_ = $loc35_ * 3;
			$loc5_ = $loc5_ + 5;
			$loc4_ = $loc5_ >> 31;
			$loc4_ = $loc5_ + $this->_rshift($loc4_ , 28);					
			$loc5_ = $loc5_ - ($loc4_ & 0x3FFFFFF0);					
			$loc5_ = $loc5_ + $loc16_;					
			$loc5_ = $loc19_ + ($loc5_ << 2);					
			$loc3_ = $this->li32($loc5_);					
			$loc5_ = $loc18_ + ($loc35_ << 2);					
			$loc2_ = $this->li32($loc5_);					
			$loc5_ = $loc35_ >> 31;					
			$loc5_ = $loc35_ + $this->_rshift($loc5_ , 30);					
			$loc33_ = $loc35_ - ($loc5_ & -4);					
			$loc25_ = 4;			
			if($loc33_ >= 2)		
						$loc25_ = 2;
												
			$loc5_ = $loc12_ ^ $loc31_;
			$loc5_ = $loc5_ ^ $loc6_;					
			$loc4_ = $loc8_ & -2;		
			$loc4_ = $loc4_ + $loc5_;					
			$loc4_ = $loc4_ & -2;					
			$loc20_ = $loc8_ & 1;					
			$loc4_ = $loc4_ | $loc20_;					
			$loc20_ = $loc5_ & 1;					
			$loc4_ = $loc4_ + $loc20_;					
			$loc20_ = $loc4_ & -2;					
			$loc4_ = $loc3_ & 1;	
			$loc4_ = $loc4_ | $loc20_;	
			$loc20_ = $loc2_ & -2;	
			$loc20_ = $loc20_ + $loc3_;	
			$loc26_ = $loc20_ & -2;	
			$loc20_ = $loc2_ & 1;	
			$loc20_ = $loc26_ | $loc20_;	
			$loc4_ = $loc20_ + $loc4_;	
			$loc4_ = $loc4_ & -2;	
			$loc5_ = $loc5_ + $loc8_;	
			$loc5_ = $loc5_ & 1;	
			$loc5_ = $loc4_ | $loc5_;	
			$loc4_ = $loc2_ + $loc3_;	
			$loc4_ = $loc4_ & 1;	
			$loc5_ = $loc5_ + $loc4_;	
			$loc4_ = $loc33_ * 7;	
			$loc4_ = $loc25_ + $loc4_;	
			$loc20_ = 32 - $loc4_;	
			$loc20_ = $this->_rshift($loc5_ , $loc20_);	
			$loc5_ = $loc5_ << $loc4_;	
			$loc5_ = $loc5_ | $loc20_;	
			$loc4_ = $loc6_ & -2;	
			$loc4_ = ($loc5_ + $loc4_);	
			$loc20_ = $loc4_ & -2;	
			$loc4_ = $loc6_ & 1;	
			$loc4_ = $loc20_ | $loc4_;	
			$loc5_ = $loc5_ & 1;	
			$loc5_ = $loc4_ + $loc5_;	
			$loc33_ = $loc12_;
			$loc12_ = $loc6_;
			$loc6_ = $loc5_;
			$loc8_ = $loc31_;
			$loc31_ = $loc33_;
			++$loc35_;
			}
		

		while ($loc35_ < 64)
			{
			$loc5_ = ($loc6_ | $loc31_ ^ -1) ^ $loc12_;				
			$loc4_ = ($loc8_ & -2) + $loc5_;	
			$loc4_ = ($loc4_ & -2 | $loc8_ & 1) + ($loc5_ & 1);	
			$t1    = $loc4_ & -2;	
			$loc4_ = $loc35_ * 7;
			$loc26_= $loc4_ >> 31;		
			$loc26_= $loc4_ + $this->_rshift($loc26_ , 28);		
			$loc4_ = $loc4_ - ($loc26_ & 0x3FFFFFF0);	
			$loc4_ = $loc4_ + $loc16_;	
			$loc4_ = $loc19_ + ($loc4_ << 2);	
			$loc4_ = $this->li32($loc4_);		
			$loc26_= $loc4_ & 1;	
			$t2    = $loc26_ | $t1;	
			$loc20_= $loc18_ + ($loc35_ << 2);	
			$loc20_= $this->li32($loc20_);	
			$loc34_= $loc20_ & -2;	
			$loc34_= $loc34_ + $loc4_;	
			$loc34_= $loc34_ & -2 | $loc20_ & 1;	
			$loc26_= ($loc34_ + $t2);	
			$t3    = $loc26_ & -2;	
			$loc5_ = $loc5_ + $loc8_;	
			$t4    = $loc5_ & 1;	
			$t5    = $t4 | $t3;	
			$loc4_ = $loc20_ + $loc4_;	
			$t6    = $loc4_ & 1;	
			$t7    = $t6 + $t5;	
			$loc4_ = $loc35_ >> 31;	
			$loc4_ = $loc35_ + $this->_rshift($loc4_ , 30);	
			$loc4_ = $loc35_ - ($loc4_ & -4);	
			$loc20_= $loc4_ - 1;	
			$loc26_= $loc20_ * $loc4_;	
			$loc20_= $loc26_ + $this->_rshift($loc26_ , 31);		
			$loc4_ = $loc4_ << 2;
			$loc4_ = $loc4_ + ($loc20_ >> 1);		
			$loc20_= $loc4_ + 6;	
			$loc4_ = 32 - $loc20_;	
			$loc4_ = $this->_rshift($t7 , $loc4_);	
			$loc5_ = $t7  << $loc20_;	
			$t8    = $loc5_ | $loc4_;	
			$loc4_2= $loc6_ & -2;	
			$loc4_1= $t8 + $loc4_2;	
			$loc4_ = $loc4_1 & -2 | $loc6_ & 1;	
			$t9    = $loc4_1 & 1;	

			$loc33_= $loc12_;
			$loc12_= $loc6_;
			$loc6_ = $loc4_ + $t9;
			$loc8_ = $loc31_;
			$loc31_ = $loc33_;			
			++$loc35_;
			}				
			
		$loc5_ = $loc28_ & -2;
		$loc5_ = $loc5_ + $loc31_;
		$loc33_ = ($loc5_ & -2 | $loc28_ & 1) + ($loc31_ & 1);
		$loc5_ = $loc14_ & -2;
		$loc5_ = $loc5_ + $loc12_;
		$loc12_ = ($loc5_ & -2 | $loc14_ & 1) + ($loc12_ & 1);
		$loc5_ = $loc10_ & -2;
		$loc5_ = $loc5_ + $loc6_;
		$loc6_ = ($loc5_ & -2 | $loc10_ & 1) + ($loc6_ & 1);
		$loc5_ = $loc8_ + ($loc30_ & -2);
		$loc8_ = ($loc5_ & -2 | $loc30_ & 1) + ($loc8_ & 1);
		$loc16_+= 16;			
		$loc31_ = $loc33_;
		$loc35_ = 0;
		}		
/**/
	while ($loc35_ < 8)
		{
		$loc4_ = ($loc8_ >> ((($loc35_ << 2) & 28) ^ 4)) & 15;
		$this->R[$loc27_ + $loc35_++]=$loc4_;
		}	
	
        while ($loc35_< 16)
		{
		$loc4_ = ($loc6_ >> ((($loc35_ << 2) & 28) ^ 4)) & 15;
		$this->R[$loc27_ + $loc35_++]=$loc4_;
		}
	
        while ($loc35_< 24)
		{
		$loc4_ = ($loc12_ >> ((($loc35_ << 2) & 28) ^ 4)) & 15;
		$this->R[$loc27_ + $loc35_++]=$loc4_;
		}			
							
        while ($loc35_ < $loc29_)
		{
		$loc4_ = ($loc31_ >> ((($loc35_ << 2) & 28) ^ 4)) & 15;
		$this->R[$loc27_ + $loc35_++]=$loc4_;			
		}	
					
	$this->R[$loc27_ + 32]=0;

do	
	{
	$loc35_ = $loc27_ - $loc29_ + 32;
	$loc10_ = $this->R[$loc35_];
	$loc14_ = 48;
	if($loc10_ > 9)		
				$loc14_ = 87;		
	$loc5_ = ($loc14_ + $loc10_);
	$this->R[$loc35_]=$loc5_;
	$loc29_ = $loc29_ -1;
	}
while($loc29_ != 0);
	
$vf="";	
for ($k=0;$k<32;$k++) {$vf.=chr($this->R[$loc27_ +$k]);}
return $vf;
}

// http://cache.video.qiyi.com/vms?key=fvip&src=1702633101b340d8917a69cf8a4b8c7c&tvId=338149200&vid=00de250f5f4bcebb8325ec622327e938&vinfo=1&tm=1516&qyid=cf66272a29d2bd6bafca991c1af76911&puid=&authKey=77b4cbced949c8872378a019f0a04fc8&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdx=n&qdv=3&vf=71ac17aebc92b53a3b9c1b183bfdcdbd
		
	$str= "/vms?key=fvip&src=1702633101b340d8917a69cf8a4b8c7c&tvId=338149200&vid=00de250f5f4bcebb8325ec622327e938&vinfo=1&tm=1516&qyid=cf66272a29d2bd6bafca991c1af76911&puid=&authKey=77b4cbced949c8872378a019f0a04fc8&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdx=n&qdv=3";
	
	$a=new ycalc();
	
	echo $a->compute($str)."<br>".md5($str."u6fnp3eok0dpftcq9qbr4n9svk8tqh7u");
