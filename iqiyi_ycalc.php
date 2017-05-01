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
							
	$loc1_ = $loc37_= $ESP = $loc6_ = $loc4_= $loc3_ =  $loc21_ = 1280+16+256;
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
		
while(1)
	{
	switch($loc25_)
		{
		case 1: 
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
			$loc35_++;
			$loc25_= 3;
			$loc33_= $loc12_;
			$loc12_= $loc6_;
			$loc6_ = $loc4_ + $t9;
			$loc8_ = $loc31_;	
			break;
		case 0:
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
			$loc25_ = 19;
			break;
		case 5: 
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
			$loc35_ = $loc35_ + 1;
			$loc25_ = 7;
			$loc33_ = $loc12_;
			$loc12_ = $loc6_;
			$loc6_ = $loc5_;
			$loc8_ = $loc31_;
			break;
		case 3:
			$loc25_ = 1;
			if($loc35_ > 63)	
						$loc25_ = 0;	
			$loc25_ = $loc25_ & 1;
			$loc31_ = $loc33_;
			break;
		case 9:
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
			$loc35_++;
			$loc25_ = 11;
			$loc33_ = $loc12_;
			$loc12_ = $loc6_;
			$loc6_ = $loc4_ + $t6;
			$loc8_ = $loc31_; 
			break;
		case 7:
			$loc25_ = 5;
			if($loc35_ > 47)	
						$loc25_ = 3;	
			$loc31_ = $loc33_; 
			break;	
		case 15:
			$loc25_ = 13;
			if($loc35_ > 15)	
						$loc25_ = 11;	
			$loc31_ = $loc33_;
			break;
		case 13: 
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
			$loc35_++;
			$loc25_ = 15;
			$loc33_ = $loc12_;
			$loc12_ = $loc6_;
			$loc6_ = $loc4_ + $t7;
			$loc8_ = $loc31_;
			break;
		case 11:
			$loc25_ = 9;
			if($loc35_ >= $loc29_)	
						$loc25_ = 7;	
			$loc31_ = $loc33_; 
			break;
		case 19:
			$loc25_ = 17;
			if($loc16_ >= $loc17_)	
						$loc25_ = 81;	
			$loc31_ = $loc33_;
			break;
		case 17:
			$loc25_ = 15;
			$loc35_ = 0;
			$loc30_ = $loc8_;
			$loc33_ = $loc31_;
			$loc10_ = $loc6_;
			$loc14_ = $loc12_;
			$loc28_ = $loc31_; 
			break;
		
		case 22:
			$loc16_++;
			$loc25_ = 33;
			$loc33_ = $loc31_;
			break;
		case 21:
			$loc5_ = $loc22_ >> 31;
			$loc5_ = $loc22_ + $this->_rshift($loc5_ , 30);
			$loc5_ = $loc22_ - ($loc5_ & 536870908);
			$loc4_ = $loc19_ + ($loc22_ & -4);
			$loc5_ = (128 << ($loc5_ << 3)) | $this->li32($loc4_);
			$this->si32($loc5_,$loc4_);
			$loc4_ = $loc13_ << 3;
			$loc4_ = $loc4_ + 256;
			$this->si32($loc4_,$loc19_ + ($loc17_ << 2));
			$loc25_ = 19;
			$loc16_ = 0;
			$loc33_ = $loc31_; 
			break;
		case 24:
			$loc24_ = $loc24_ + 88;
			$loc25_ = 23;
			$loc33_ = $loc31_; 
			break;
		case 23:	
			$loc5_ = $loc22_ >> 31;
			$loc5_ = $loc22_ + $this->_rshift($loc5_ , 30);
			$loc5_ = $loc22_ - ($loc5_ & 536870908);
			$loc4_ = $loc19_ + ($loc22_ & -4);
			$loc5_ = ($loc24_ << ($loc5_ << 3)) | $this->li32($loc4_);
			$this->si32($loc5_,$loc4_);	
			$loc35_++;
			$loc22_++;
			$loc25_ = 29;
			$loc33_ = $loc31_;
			break;
		case 26:
			$loc25_ = 25;
			if($loc24_ > 9)	
						$loc25_ = 24;	
			$loc33_ = $loc31_;
			break;
		case 25:
			$loc24_ = $loc24_ + 48;
			$loc25_ = 23;
			$loc31_ = $loc33_;
			break;
		case 29:
			$loc25_ = 27;
			if($loc35_ > 3)	
						$loc25_ = 22;	
			$loc33_ = $loc31_;
			break;
		case 27: 
			$loc5_ = $loc25_ * 25;	
			$loc4_ = $loc5_ + ($loc25_ + 10) * $loc16_;	
			$loc20_1 = ($loc25_ << 1) + (($loc25_ + 2) * $loc35_) -3;	
			$loc26_ = -4 - ($loc35_ << 2);
			$loc20_ = $loc26_ + $loc25_ * ($loc35_ + 3);	
			$loc5_ = ($loc5_ / 3) + 26;	
			$loc4_1 = $loc25_ / 9;	
			$loc24_ = (($loc20_ + $loc20_1 * ($loc4_ -4) + $loc5_ * $loc16_) * ($loc4_1 + 2)) % ($loc25_ + 4);
			$loc25_ = 26;
			$loc33_ = $loc31_;		
			break;
		case 35:
			$loc25_ = 33;
			$loc22_ = $loc16_;
			$loc33_ = $loc31_;
			$loc16_ = 0;
			break;
		case 33:
			$loc25_ = 31;
			if($loc16_ > 7)	
						$loc25_ = 21;	
			$loc33_ = $loc31_;
			break;
		
		case 31:
			$loc25_ = 29;
			$loc35_ = 0;
			$loc33_ = $loc31_;
			break;
		case 55:
			$loc11_ = $loc9_ * 4294967296;
			$loc4_ = $loc11_;
			$this->si32($loc4_,$loc18_ + ($loc35_ << 2),$R,$loc25_);
			$loc35_++;
			$loc25_ = 60;
			$loc33_ = $loc31_; 
			break;
		case 58:
			$loc5_ = $loc35_ + 1;
			$loc9_ = sin($loc5_);
			$loc25_ = 57;
			$loc33_ = $loc31_;
			break;
		case 36:
			$loc5_ = $loc27_ + $loc16_;
			$loc4_ = $loc16_ >> 31;
			$loc4_ = $loc16_ + $this->_rshift($loc4_ , 30);
			$loc4_1 = $loc16_ - ($loc4_ & 536870908);
			$loc4_ = $loc19_ + ($loc16_ & -4);
			$loc5_ = ($this->R[$loc5_]<<($loc4_1<<3)) | $this->li32($loc4_);
			$this->si32($loc5_,$loc4_);
			$loc16_++;
			$loc25_ = 38;
			$loc33_ = $loc31_;
			break;
		case 38:
			$loc25_ = 36;
			if($loc16_ >= $loc13_)	
						$loc25_ = 35;	
			$loc33_ = $loc31_;
			break;
		case 40:
			$loc25_ = 38;
			$loc16_ = 0;
			$loc33_ = $loc31_;
			break;
		case 43:
			$loc25_ = 41;
			if($loc16_ >= $loc22_)	
						$loc25_ = 40;	
			$loc33_ = $loc31_;
			break;
		case 41:
			$this->si32(0,$loc19_ + ($loc16_ << 2));
			$loc16_++;
			$loc25_ = 43;
			$loc33_ = $loc31_;
			break;
		case 45:
			$loc25_ = 43;
			$loc16_ = 0;
			$loc33_ = $loc31_;
			break;
		case 47:
			$loc25_ = 45;
			if(($loc17_ + 16) >= $loc22_)	
						$loc25_ = 46;	
			$loc33_ = $loc31_;
			break;
		case 46:
			$loc22_ = $loc17_ + 16;
			$loc25_ = 45;
			$loc33_ = $loc31_;
			break;
		case 49:
			$loc13_++;
			$loc25_ = 52;
			$loc33_ = $loc31_;
			break;
		case 48: 
			$loc25_ = $loc13_ -1;
			$loc33_ = $this->R[$loc21_];
			if($loc25_ > 0)
				{
				$loc16_ = $ESP+1;
				$loc17_ = $loc25_;
				$loc22_ = $loc27_;
				do
					{
					$loc5_ = $this->R[$loc16_];
					$this->R[$loc22_]=$loc5_;
					$loc16_++;
					$loc17_--;
					$loc22_++;
					}
				while($loc17_ != 0);				
				}
				
			$loc5_ = $loc27_ + $loc25_;
			$this->R[$loc5_]=$loc33_;
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
			$loc5_ = ($loc13_ + 32);
			$loc22_ = $loc5_ >> 2;
			$loc5_ = ($loc13_ + 40);
			$loc5_ = $loc5_ >> 2;
			$loc5_ = $loc5_ & -16;
			$loc17_ = $loc5_ | 14;
			$loc25_ = 47;
			$loc33_ = $loc31_;
			break;
		case 54:
			$loc25_ = 52;
			$loc8_  = 1732584193;
			$loc6_  = -271733879;
			$loc12_ = -1732584194;
			$loc33_ = 271733878;
			break;
		case 52:
			$loc25_ = 51;
			$loc15_ = $loc16_;
			$loc31_ = $loc33_;
			$loc16_++;
			break;
		case 51:
			$loc5_ = $loc21_ + $loc15_;
			$loc25_ = 48;
			if($this->R[$loc5_] != 0)	
						$loc25_ = 49;	
			$loc33_ = $loc31_;
			break;
		case 57:
			$loc25_ = 56;
			if($loc9_ >= 0)	
						$loc25_ = 55;	
			$loc33_ = $loc31_;
			break;
		case 56:
			$loc9_ = 0 - $loc9_;
			$loc25_ = 55;
			$loc33_ = $loc31_;
			break;
		case 63:
			break 2;
		case 62:
			$loc25_ = 60;
			$loc13_ = 0;
			$loc33_ = $loc31_;
			$loc35_ = $loc13_;
			$loc16_ = $loc13_;
			break;
		case 60:
			$loc25_ = 58;
			if($loc35_ > 63)	
						$loc25_ = 54;	
			$loc33_ = $loc31_;
		        break;
		case 65:
			$loc4_ = $loc35_ << 2;
			$loc4_ = $loc4_ & 28;
			$loc4_ = $loc31_ >> ($loc4_ ^ 4);
			$loc4_ = $loc4_ & 15;
			$this->R[$loc27_ + $loc35_]=$loc4_;
			$loc35_++;
			$loc25_ = 67;
			$loc33_ = $loc31_;
			break;
		case 64:
			$this->R[$loc27_ + 32]=0;
			$loc25_ = 63;
			$loc33_ = $loc31_;
			break;
		case 69:
			$loc4_ = $loc35_ << 2;
			$loc4_ = $loc4_ & 28;
			$loc4_ = $loc12_ >> ($loc4_ ^ 4);
			$loc4_ = $loc4_ & 15;
			$this->R[$loc27_ + $loc35_]=$loc4_;
			$loc35_ = ($loc35_ + 1);
			$loc25_ = 71;
			$loc33_ = $loc31_;
			break;
		case 67:
			$loc25_ = 65;
			if($loc35_ >= $loc29_)	
						$loc25_ = 64;	
			$loc33_ = $loc31_;
			break;
		case 73:
			$loc4_ = $loc35_ << 2;
			$loc4_ = $loc4_ & 28;
			$loc4_ = $loc6_ >> ($loc4_ ^ 4);
			$loc4_ = $loc4_ & 15;
			$this->R[$loc27_ + $loc35_]=$loc4_;
			$loc35_++;
			$loc25_ = 75;
			$loc33_ = $loc31_;
			break;
		case 71:
			$loc25_ = 69;
			if($loc35_ >= 24)	
						$loc25_ = 67;	
			$loc33_ = $loc31_;
			break;
		case 77:
			$loc4_ = $loc35_ << 2;
			$loc4_ = $loc4_ & 28;
			$loc4_ = $loc8_ >> ($loc4_ ^ 4);
			$loc4_ = $loc4_ & 15;
			$this->R[$loc27_ + $loc35_]=$loc4_;
			$loc35_++;
			$loc25_ = 79;
			$loc33_ = $loc31_;
			break;
		case 75:
			$loc25_ = 73;
			if($loc35_ >= 16)	
						$loc25_ = 71;	
			$loc33_ = $loc31_;
			break;
		case 81:
			$loc25_ = 79;
			$loc33_ = $loc31_;
			$loc35_ = 0;
			break;
		case 79:
			$loc25_ = 77;
			if($loc35_ >= 8)	
						$loc25_ = 75;	
			$loc33_ = $loc31_;	
		}
	}

do	
	{
	$loc35_ = $loc27_ - $loc29_ + 32;
	$loc10_ = $this->R[$loc35_];
	$loc14_ = 48;
	if($loc10_ >= 10)		
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
}


// http://cache.video.qiyi.com/vms?key=fvip&src=1702633101b340d8917a69cf8a4b8c7c&tvId=338149200&vid=00de250f5f4bcebb8325ec622327e938&vinfo=1&tm=1516&qyid=cf66272a29d2bd6bafca991c1af76911&puid=&authKey=77b4cbced949c8872378a019f0a04fc8&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdx=n&qdv=3&vf=71ac17aebc92b53a3b9c1b183bfdcdbd
		
	$str= "/vms?key=fvip&src=1702633101b340d8917a69cf8a4b8c7c&tvId=338149200&vid=00de250f5f4bcebb8325ec622327e938&vinfo=1&tm=1516&qyid=cf66272a29d2bd6bafca991c1af76911&puid=&authKey=77b4cbced949c8872378a019f0a04fc8&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdx=n&qdv=3";
	
	$a=new ycalc();
	
	echo $a->compute($str)."<br>".md5($str."u6fnp3eok0dpftcq9qbr4n9svk8tqh7u");
