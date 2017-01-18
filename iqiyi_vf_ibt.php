<?
/*
from http://static.iqiyi.com/js/player_v1/pcweb.wonder.js where the cmd5x algorithm is stored as packed eval

this class computes the vf value in the call

http://cache.video.qiyi.com/vms?key=fvip&src=01010031010010000000&tvId=496130600&vid=12078ce069daab217b2632248272d722&vinfo=1&tm=506&qyid=&puid=&authKey=a6e3cd72befb37d067d2d684d74855b9&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdv=2&vf=7fff3565c6d525f625776630d571134f

where the relevant part is 

/vms?key=fvip&src=01010031010010000000&tvId=496130600&vid=12078ce069daab217b2632248272d722&vinfo=1&tm=506&qyid=&puid=&authKey=a6e3cd72befb37d067d2d684d74855b9&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdv=2


the same for ibt
*/
class iqiyi
{
	function getVrsEncodeCode($param1) 
		{
		$_loc6_ = 0;
		$_loc2_ = "";
		$_loc3_ = explode("-",$param1);
		$_loc4_ = sizeof($_loc3_);
		$_loc5_ = $_loc4_ - 1;
		
		while($_loc5_ >= 0)
			{
			$_loc6_ = $this->getVRSXORCode(hexdec($_loc3_[$_loc4_ - $_loc5_ - 1]),$_loc5_);
			$_loc2_ = chr($_loc6_).$_loc2_;
			$_loc5_--;
			}
			
		return $_loc2_;
		}
		
	function getVRSXORCode($param1, $param2)
		{
		$_loc3_ = $param2 % 3;
		if($_loc3_ == 1)
			{
			return $param1 ^ 121;
			}
		if($_loc3_ == 2)
			{
			return $param1 ^ 72;
			}
		return $param1 ^ 103;
		}
	function W(&$Sz,$s=""){$Sz=ceil($Sz/16)*16;return $Sz;}  
	
	function Zarr(&$R,$typedarr,$n,$m="")
		{		
		switch ($typedarr)
			{
			case "int8":  $np=1;$pack="i";break;
			case "uint8": $np=1;$pack="I";break;
			case "int16": $np=2;$pack="s";break;
			case "uint16": $np=2;$pack="S";break;
			case "int32": $np=4;$pack="l";break;
			case "uint32": $np=4;$pack="L";break;
			case "f32": $np=4;$pack="f";break;
			case "f64": $np=8;$pack="d";
			}
			
		$n*=$np;
		
		if (!is_numeric($m))
			{
			$c=$np;$m="";while (--$c>=0) $m.=sprintf("%02X",$R[$n+$c]);
			
			if ($np==1) 
				{				
				$m=hexdec($m);					
				if ($pack=="i")
					{$exp=$np*8;if ($m>pow(2,$exp)-1) $m-=pow(2,$exp);}
				return $m;
				} 
			
			return array_shift(unpack($pack,strrev(pack("H*",$m))));
			}

		$type=array_values(unpack("C*",pack($pack,$m)));
		foreach ($type as $byte) $R[$n++]=$byte;	
		}
		
	function Tarr(&$R,$n,$m="")
		{// Int8Array 8192 8-bit two's complement signed integer		
		return $this->Zarr($R,"int8",$n,$m);		
		}
	
	function Uarr(&$R,$n,$m="")
		{//int32 longitud 2048 32-bit two's complement signed integer		
		return $this->Zarr($R,"int32",$n,$m);
		}
	
	function Varr(&$R,$n,$m="")
		{// uint8 8192 8-bit unsigned integer		
		return $this->Zarr($R,"uint8",$n,$m);
		}
	
	function aarr(&$R,$nn,$n,$m="")
		{// Int8Array 8192 8-bit two's complement signed integer		
		return $this->Zarr($R,"int8",$n,$m);			
		}
	
	function barr(&$R,$n,$m="")
		{//Int16Array longitud 4096 16-bit two's complement signed integer		
		return $this->Zarr($R,"int16",$n,$m);
		}
	
	function carr(&$R,$v="",$n,$m="")
		{//Int32Array longitud 2048 32-bit two's complement signed integer
		return $this->Zarr($R,"int32",$n,$m);
		}
	
	function darr(&$R,$n,$m="")
		{// Uint8Array 8-bit unsigned integer		
		return $this->Zarr($R,"uint8",$n,$m);
		}

	function earr(&$R,$n,$m="")
		{//Uint16Array longitud 4096 16-bit unsigned integer		
		return $this->Zarr($R,"uint16",$n,$m);
		}
 
	function farr(&$R,$n,$m="")
		{//Uint32Array longitud 2048 32-bit unsigned integer		
		return $this->Zarr($R,"uint32",$n,$m);
		}	  
	  
	function garr(&$R,$n,$m="")
		{//Float32Array longitud 2048 32-bit 	
		return $this->Zarr($R,"f32",$n,$m);
		}

	function harr(&$R,$n,$m="")
		{//Float64Array longitud 1024 64-bit 		
		return $this->Zarr($R,"f64",$n,$m);				
		}

  	function Da($Sz,&$O){$ret=$O;$O+=$Sz|0+15&-16;return $ret;}
  	function Db($Sz,&$M){$ret=$M;$M+=$Sz|0+15&-16;return $ret;}
  	function Dc($Sz,&$N){$ret=$N;$N+=$Sz|0+15&-16;return $ret;}	
	  
  	function la($bytes,&$O)
  		{
  		if($O%4096>0){$O+=4096-$O%4096;}
  		
		return $this->Sx($bytes,$O);
  		}
		  
  	function Sx($bytes,$O)
  		{ 
  		$ret=$O;
  		if($bytes!=0){$Su=$this->Da($bytes,$O);
  			if(!$Su)return-1>>0;}
  		return $ret;
  		}

  	function X(&$R,&$O,$Sl,$Tl="i8",$Al=0,$p="") // sl es unpack
	  	{
	  	$sz=sizeof($Sl);
		
	  	$ret=$this->Ua($sz,$R,$O);

		for ($k=$ret;$k<($sz+$ret);$k++)
			$this->Varr($R,$k,$Sl[$k-$ret]); 
	 
  	        return $ret;        
	  	}

	function Sc($str,&$sx,$sz,$sy)
		{
		if(!($sy>0))return 0;
		$startIdx=$sz=0;
		$se=$sz+$sy-1;
		
		for($i=0;$i<strlen($str);++$i)
			{
			$u=ord($str[$i]);
			if($u>=55296&&$u<=57343) 
				$u=65536+(($u&1023)<<10)|ord($str[++$i])&1023;
			if($u<=127)
				{
				if($sz>=$se)break;
				$sx[$sz++]=$u;
				}
			else if($u<=2047)
				{
				if($sz+1>=$se)break;
				$sx[$sz++]=192|$u>>6;
				$sx[$sz++]=128|$u&63;
				}
			else if($u<=65535)
				{
				if($sz+2>=$se)break;
				$sx[$sz++]=224|$u>>12;
				$sx[$sz++]=128|$u>>6&63;
				$sx[$sz++]=128|$u&63;
				}
			else if($u<=2097151)
				{
				if($sz+3>=$se)break;
				$sx[$sz++]=240|$u>>18;
				$sx[$sz++]=128|$u>>12&63;
				$sx[$sz++]=128|$u>>6&63;
				$sx[$sz++]=128|$u&63;
				}
			else if($u<=67108863)
				{
				if($sz+4>=$se)break;
				$sx[$sz++]=248|$u>>24;
				$sx[$sz++]=128|$u>>18&63;
				$sx[$sz++]=128|$u>>12&63;
				$sx[$sz++]=128|$u>>6&63;
				$sx[$sz++]=128|$u&63;
				}
			else
				{
				if($sz+5>=$se)break;
				$sx[$sz++]=252|$u>>30;
				$sx[$sz++]=128|$u>>24&63;
				$sx[$sz++]=128|$u>>18&63;
				$sx[$sz++]=128|$u>>12&63;
				$sx[$sz++]=128|$u>>6&63;
				$sx[$sz++]=128|$u&63;
				}
			}
		$sx[$sz]=0;
		return $sz-$startIdx;
		}
			  
	function Y($str)
		{
		$len=0;
		for($i=0;$i<strlen($str);++$i)
			{
			$u=ord($str[$i]);
			if($u>=55296&&$u<=57343)
				{$u=65536+(($u&1023)<<10)|ord($str[++$i])&1023;}
			if($u<=127){++$len;}
			else if($u<=2047){$len+=2;}
			else if($u<=65535){$len+=3;}
			else if($u<=2097151){$len+=4;}
			else if($u<=67108863){$len+=5;}
			else{$len+=6;}
			}
		return $len;
		}
	
	function Id($stringy)
		{
		$len=$this->Y($stringy)+1;
		$u8array=array($len);
		$numBytesWritten=$this->Sc($stringy,$u8array,0,$len);
		$u8array=array_slice($u8array,0,$numBytesWritten);
		return $u8array;
		}

	function llf( $val , $shft ) 
		{
		if ($shft==0) return $val;  
		else return $val << $shft;
		} 

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
	 
	
	function Z($p,&$R) {$ret=time()|0;if($p){$ret=$this->Uarr($R,$p>>2,"");}return $ret;}
	function ma($p,&$R){return $this->Z($p,$R);}
		
	//////////////////////////////////////////////////////
	
	/*
	$ciax=file_get_contents("cia5.php");
	
	$y1=('$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;');
														
	$y2=('$mb=$tb;$kb=$ub;$Ya=$vb;$Ra=$wb;$Pa=$xb;$Na=$yb;$La=$zb;$Ja=$Ab;$Ha=$Bb;$Ea=$Cb;$ta=$Db;$ra=$Eb;$pa=$Fb;$na=$Gb;$la=$Hb;$p=$sb;$n=$Ib;');
	
	$y3=('$rb=$mb;$tb=$kb;$ub=$jb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;$mb=$rb;$kb=$tb;$jb=$ub;$Ya=$vb;$Ra=$wb;$Pa=$xb;$Na=$yb;$La=$zb;$Ja=$Ab;$Ha=$Bb;$Ea=$Cb;$ta=$Db;$ra=$Eb;$pa=$Fb;$na=$Gb;$la=$Hb;$p=$sb;$n=$Ib;');
	
	$ciax=str_replace('$va1;',$y1,$ciax);
	//$ciax=str_replace('$va2;',$y2,$ciax);
	//$ciax=str_replace('$default;',$y3,$ciax);
	
	file_put_contents("cia2.php",$ciax);
	*/
	
function Ia($b,&$RR,&$OO)
{			
	$i=1856;$j=2872;	
	
	$d=$e=$f=$g=$j=$k=$l=$m=$n=$o=$p=$q=$r=$s=$t=$u=$v=$w=$x=$y=$z=0;
	
	$A=$B=$C=$D=$E=$F=$G=$H=$I=$J=$K=$L=$M=$N=$O=$P=$R=$S=$T=$U=$V=$W=$X=$Y=$Z=0;
	
	$_=$dol=0;
	
	$aa=$ba=$ca=$da=$ea=$fa=$ga=$ha=$ia=$ja=$ka=$la=$ma=$na=$oa=$pa=$qa=$ra=$sa=$ta=$ua=$va=$wa=$xa=$ya=$za=0;
	
	$Aa=$Ba=$Ca=$Da=$Ea=$Fa=$Ga=$Ha=$Ia=$Ja=$Ka=$La=$Ma=$Na=$Oa=$Pa=$Qa=$Ra=$Sa=$Ta=$Va=$Wa=$Ya=$Za=0;
	
	$_a=$__a=0;
	
	$ab=$bb=$cb=$db=$eb=$fb=$gb=$hb=$ib=$jb=$kb=$lb=$mb=$nb=$ob=$pb=$qb=$rb=$sb=$tb=$ub=$vb=$wb=$xb=$yb=$zb=0;
	
	$Ab=$Bb=$Cb=$Db=$Eb=$Fb=$Gb=$Hb=$Ib=0;
	
	$qb=$i;          		
	
	$i=$i+1168;$Fa=$qb+1140;$Ia=$qb+1136;$Ka=$qb+1132;$q=$qb+920;$ua=$qb+1128;$ma=$qb+1124;
	
	$oa=$qb+1120;$qa=$qb+1116;$sa=$qb+1112;$nb=$qb+1108;$Za=$qb+1104;$lb=$qb+1100;$Ma=$qb+1096;
	
	$Oa=$qb+1092;$Qa=$qb+1088;$Sa=$qb+1084;$o=$qb+1080;$T=$qb+1076;$S=$qb+1072;$R=$qb+1068;
	
	$P=$qb+1064;$__a=$qb+1060;$ga=$qb+1165;$bb=$qb+1056;$eb=$qb+1052;$O=$qb+1048;$N=$qb+1044;
	
	$M=$qb+1040;$fa=$qb+1164;$ya=$qb+912;$L=$qb+1036;$B=$qb+1032;$ea=$qb+1163;$G=$qb+904;
	
	$xa=$qb+896;$K=$qb+1028;$ca=$qb+1162;$ba=$qb+1161;$_a=$qb+1024;$F=$qb+888;$Va=$qb+1020;
	
	$Ca=$qb+1016;$m=$qb+1012;$E=$qb+880;$db=$qb+1008;$ab=$qb+1004;$A=$qb+1000;$z=$qb+996;
	
	$aa=$qb+1160;$y=$qb+992;$x=$qb+988;$dol=$qb+1159;$_=$qb+1158;$l=$qb+984;$D=$qb+872;
	
	$gb=$qb+980;$cb=$qb+976;$Z=$qb+1157;$wa=$qb+864;$Y=$qb+1156;$w=$qb+972;$X=$qb+1155;
	
	$v=$qb+968;$fb=$qb+964;$u=$qb+960;$Ta=$qb+956;$Ba=$qb+952;$W=$qb+1154;$k=$qb+1153;
	
	$Aa=$qb+948;$Da=$qb+944;$Wa=$qb+856;$ib=$qb+848;$ka=$qb+1152;$U=$qb+840;$t=$qb+940;
	
	$ja=$qb+1151;$I=$qb+832;$H=$qb+824;$j=$qb+1150;$C=$qb+936;$ia=$qb+1149;$s=$qb+816;
	
	$hb=$qb+932;$ha=$qb+1148;$za=$qb+808;$g=$qb+1147;$pb=$qb+928;$da=$qb+1146;$va=$qb+800;
	
	$f=$qb+1145;$r=$qb+792;$V=$qb+1144;$e=$qb+784;$d=$qb+776;$J=$qb+768;$Ga=$qb+512;$ob=$qb;

	$this->carr($RR,$n,$J>>2,$this->Ua(33,$RR,$OO)|0);
			
	$this->carr($RR,$n,$d>>2,$Ga);

	$n=$p=$la=$na=$pa=$ra=$ta=$Ea=$Ha=$Ja=$La=$Na=$Pa=$Ra=$Ya=$kb=$mb=0;$jb=936652527;

	
while(1)
{
if(($jb)>=-22207083)
	{
	if(($jb)<1111318124) 
		{
		if(($jb)>=608838580) 
			{
			if(($jb)>=801681189)
				{
				if(($jb)<974401706) 
						{
						if(($jb)<887924077)
								{
								if(($jb)<809617043) 
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<64?-1361726950:1012403908;continue;
									}
									
								if(($jb)<852236017) 
									{
									$this->aarr($RR,$n,$ea>>0,($this->carr($RR,$n,$Fa>>2,"")|0)<32&1);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=618822415;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<47?-1031373064:-86792897;continue;
									}
								} 
	
							if(($jb)<920364886)
									if(($jb)<916103055) 
										{
										$this->carr($RR,$n,$Aa>>2,0-(0-($this->carr($RR,$n,$ua>>2,"")|0)+(0-1)));
										$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
										$jb=-256536033;continue;
										}
									else
										{
										$n=$this->carr($RR,$n,$o>>2,"")|0;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;
										$na=$this->carr($RR,$n,$oa>>2,"")|0;$pa=$this->carr($RR,$n,$qa>>2,"")|0;
										$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
										$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;
										$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;
										$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
										$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;
										$jb=-188097831;$kb=$this->carr($RR,$n,$lb>>2,"")|0;
										$mb=$this->carr($RR,$n,$nb>>2,"")|0;
										
										continue;
										}
									
							else if(($jb)<936652527)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<77?263250548:-1212483299;continue;
									}
							else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=1969546970;continue;
									}						
							} 
						
					
					if(($jb)<1012403908)
							{
							if(($jb)<1008856235)
								{
								if(($jb)<999695174)
									
								switch($jb)
									{
									case 974401706:break 2;
									default:
									{
									}
									}
									
								$xb=$this->carr($RR,$n,$M>>2,"")|0;								
								$tb=$this->carr($RR,$n,$N>>2,"")|0;
								$yb=~(~((~(~$xb|~-2)&(1469924941|~1469924941))-(0-$tb))|~-2)&(1908236319|~1908236319);
								$xb=($xb^~1)&$xb;								
								$wb=~$yb;
								$vb=~$xb;
								$ub=~-2039534323;
								$this->carr($RR,$n,$O>>2,(($wb&-2039534323|$yb&$ub)^($vb&-2039534323|$xb&$ub)|~($wb|$vb)&(-2039534323|$ub))-(0-(~(~$tb|~1)&(843895025|~843895025))));								
								$tb=(($this->carr($RR,$n,$Fa>>2,"")|0)%4|0)-137388177+8+137388177|0;				
								$tb=$this->carr($RR,$n,16+$this->llf($tb,2)>>2,"")|0;								
								$this->carr($RR,$n,$eb>>2,$this->llf($this->carr($RR,$n,$O>>2,""),$tb));
								$this->carr($RR,$n,$bb>>2,32+(0-$tb));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-738461164;continue;
								}
								
							if(($jb)<1010850097)
								{
								$this->aarr($RR,$n,$ha>>0,($this->carr($RR,$n,$Fa>>2,"")|0)<24&1);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=1980027799;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<63?-856036625:-1649803199;
								continue;
								}					
							}
					
					if(($jb)<1093527402)
							if(($jb)<1058751639)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<65?-902588506:1717331240;
								continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;$jb=($this->carr($RR,$n,$o>>2,"")|0)<38?13290759:-526301530;
								continue;
								}					
							
					else if(($jb)<1102465302)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==43?-1098566066:916103055;continue;
								}
					else
								{
								$this->carr($RR,$n,$v>>2,($this->carr($RR,$n,$Ka>>2,"")|0)+2072149329+16-2072149329);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=2131809869;continue;
								}					
							} 
			if(($jb)<690197071)
					{
					if(($jb)<633810001)
						{
						if(($jb)<618822415)
							{
							$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
							if (($this->carr($RR,$n,$o>>2,"")|0)==1) $jb=-1290934332; else $jb=916103055;continue;
							}
						if(($jb)<620960943)
							{
							$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;$jb=$this->aarr($RR,$n,$ea>>0,"")&1?1432877594:2028659015;continue;
							}
						else
							{
							$this->aarr($RR,$n,$dol>>0,($this->carr($RR,$n,$Fa>>2,"")|0)<8&1);
							$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
							$jb=1410777152;continue;
							}					
						}
						
					if(($jb)<637834779)
							if(($jb)<635155771)
								{
								$this->carr($RR,$n,$G>>2,$Ga+($this->llf($this->carr($RR,$n,$xa>>2,""),2)));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-164314163;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<25?-1967845546:-80539691;continue;
								}
							
					else if(($jb)<651068526)
								{
								$n=29;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;
								$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;
								$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
					else
								{
								$tb=$this->llf($this->carr($RR,$n,$Fa>>2,""),2);$tb=($tb^~28)&$tb;
								$this->carr($RR,$n,$hb>>2,$this->carr($RR,$n,$qa>>2,"")>>(4&~$tb|$tb&~4));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=1288598934;continue;
								}					
					}				
				
			if(($jb)<780107150)									
					if(($jb)<717745890)													
							if(($jb)<709849698)
								{
								$n=35;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==58?-671207445:916103055;continue;
								}
						
							
					else if(($jb)<775542450)
								{
								$this->carr($RR,$n,$u>>2,0-(0-($this->carr($RR,$n,$Ta>>2,"")|0)+(0-14)));
								$this->carr($RR,$n,$fb>>2,0-(0-($this->carr($RR,$n,$Ia>>2,"")|0)+(0-32))>>2);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-1878597151;continue;
								}
					else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<26?-823999218:1867803797;continue;
								}
			else if(($jb)<791025390)
							if(($jb)<788846146)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=$this->aarr($RR,$n,$ja>>0,"")&1?-1781069297:-722374409;continue;
								}
							else
								{
								$tb=$this->carr($RR,$n,$gb>>2,"")|0;$this->carr($RR,$n,$D>>2,$ob+$this->llf($tb,2));
								$this->carr($RR,$n,$l>>2,$this->carr($RR,$n,$this->carr($RR,$n,$D>>2,"")>>2,""));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=108332815;continue;
								}
							
							else if(($jb)<800362374)
								{
								$pa=$this->carr($RR,$n,$db>>2,"")|0;
								$ra=$this->carr($RR,$n,$m>>2,"")|0;
								$na=~$ra;
								$la=~$pa;
								$n=~243669087;
								$this->carr($RR,$n,$this->carr($RR,$n,$E>>2,"")>>2,($na&243669087|$ra&$n)^($la&243669087|$pa&$n)|~($na|$la)&(243669087|$n));
								$n=29;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;
								$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=($this->carr($RR,$n,$Fa>>2,"")|0)+ -468377855+1+468377855|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;
								$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;
								$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=($this->carr($RR,$n,$Za>>2,"")|0)-(0-1)|0;
								$jb=-188097831;$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$tb=$this->carr($RR,$n,$Fa>>2,"")|0;
								$this->carr($RR,$n,$Ga+$this->llf($tb,2)>>2,~~+$this->harr($RR,$Wa>>3,"")>>0);
								$this->carr($RR,$n,$Da>>2,($this->carr($RR,$n,$Fa>>2,"")|0)+ -166607654+1+166607654);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=228161238;continue;
								}					
							} 				
														
		if(($jb)<276665542)
			{
			if(($jb)<151603818)
					{
					if(($jb)<73587007)
							{
							if(($jb)<13290759)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<15?-1396656085:343102405;continue;
								}
							if(($jb)<60376344)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==36?195832850:916103055;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=$this->aarr($RR,$n,$V>>0,"")&1?1468918320:2014978051;continue;
								}					
							}
						
					if(($jb)<128106704)					
						if(($jb)<108332815)
								{
								$this->carr($RR,$n,$y>>2,0-(0-($this->carr($RR,$n,$x>>2,"")|0)+(0-34)));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=167383782;continue;
								}
							else
								{
								$pa=$this->carr($RR,$n,$cb>>2,"")|0;
								$ra=$this->carr($RR,$n,$l>>2,"")|0;
								$na=~$ra;
								$la=~$pa;
								$n=~961559109;
								$this->carr($RR,$n,$this->carr($RR,$n,$D>>2,"")>>2,($na&961559109|$ra&$n)^($la&961559109|$pa&$n)|~($na|$la)&(961559109|$n));
								$n=38;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=($this->carr($RR,$n,$ua>>2,"")|0)-(0-1)|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}				
							
					else if(($jb)<139799944)
								{
								$n=81;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$n=36;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}			
					}
				
			if(($jb)<212826519)					
					if(($jb)<167383782)						
							if(($jb)<153691705)
								{
								$this->carr($RR,$n,$Ca>>2,($this->carr($RR,$n,$ua>>2,"")|0)+1721273904+1-1721273904);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=1720235387;continue;
								}
							else
								{
								$this->carr($RR,$n,$Va>>2,$this->llf(($this->carr($RR,$n,$Za>>2,"")|0)%4|0,3));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-86385898;continue;
								}
					else if(($jb)<195832850)
								{
								$n=26;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=($this->carr($RR,$n,$y>>2,"")|0)%32|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$tb=$this->carr($RR,$n,$ua>>2,"")|0;
								$this->carr($RR,$n,$cb>>2,$this->llf($this->aarr($RR,$n,$b+$tb>>0,""),$this->llf(($this->carr($RR,$n,$ua>>2,"")|0)%4|0,3)));
								$this->carr($RR,$n,$gb>>2,$this->carr($RR,$n,$ua>>2,"")>>2);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=788846146;continue;
								}
			else if(($jb)<263250548)
						if(($jb)<228161238)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==71?1008856235:916103055;continue;
								}
							else
								{
								$n=60;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Da>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
					else if(($jb)<270009349)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==75?-1572948785:916103055;continue;
								}
							else
								{
								$n=49;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}			
					}
		else
			{
			if(($jb)<463554092)
					{
					if(($jb)<343102405)
							{
							if(($jb)<304010989)
								{
								$ra=$this->carr($RR,$n,16+$this->llf($this->carr($RR,$n,$ya>>2,""),2)>>2)|0;
								$ta=$this->llf($this->carr($RR,$n,$L>>2,""),$ra);
								$ra=$this->_rshift(($this->carr($RR,$n,$L>>2,"")|0),(32+ -1805529600-$ra+1805529600|0));
								$Ha=~$ra;
								$Ea=~$ta;
								$na=~-1044037601;
								$na=($Ha&-1044037601|$ra&$na)^($Ea&-1044037601|$ta&$na)|~($Ha|$Ea)&(-1044037601|$na);
								$Ea=$this->carr($RR,$n,$oa>>2,"")|0;
								$Ha=~(~((($Ea^~-2)&$Ea)+ -2033518013+$na+2033518013)|~-2)&(353003127|~353003127);
								$Ea=~(~$Ea|~1)&(~-1418005290|-1418005290);
								$ta=~$Ha;
								$ra=~$Ea;
								$pa=~522919445;
								$n=11;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$sa>>2,"")|0;
								$na=0-(0-(($ta&522919445|$Ha&$pa)^($ra&522919445|$Ea&$pa)|~($ta|$ra)&(522919445|$pa))+(0-(($na^~1)&$na)))|0;
								$pa=$this->carr($RR,$n,$oa>>2,"")|0;$ra=$this->carr($RR,$n,$qa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=($this->carr($RR,$n,$Fa>>2,"")|0)-(0-1)|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							if(($jb)<331129789)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==3?-1995522865:916103055;continue;
								}
							else
								{
								$n=41;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}					
							}
						
					if(($jb)<416259719)
							if(($jb)<368050796)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==15?1514554794:916103055;continue;
								}
							else
								{
								$this->aarr($RR,$n,$_>>0,($this->carr($RR,$n,$ua>>2,"")|0)<4&1);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-412361919;continue;
								}				
							
					else if(($jb)<439769685)
								{
								$n=55;$p=$this->harr($RR,$ib>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$yb=$this->carr($RR,$n,$qa>>2,"")|0;
								$tb=$this->carr($RR,$n,$oa>>2,"")|0;
								$yb=$yb&~$tb|$tb&~$yb;
								$tb=$this->carr($RR,$n,$sa>>2,"")|0;
								$xb=~1841611462;
								$xb=(1841611462&~$yb|$yb&$xb)^(~$tb&1841611462|$tb&$xb);
								$tb=$this->carr($RR,$n,$ma>>2,"")|0;
								$yb=~(~((~(~$tb|~-2)&(~-2111526991|-2111526991))-(0-$xb))|~-2)&(~-116829207|-116829207);
								$tb=($tb^~1)&$tb;
								$this->carr($RR,$n,$M>>2,($yb&$tb|$yb^$tb)-(0-(($xb^~1)&$xb)));
								$xb=$this->carr($RR,$n,$Fa>>2,"")|0;
								$xb=$this->carr($RR,$n,$Ga+$this->llf($xb,2)>>2,"")|0;
								$tb=(((($this->carr($RR,$n,$Fa>>2,"")|0)*3|0)-(0-5)|0)%16|0)+ -1093534983+($this->carr($RR,$n,$ua>>2,"")|0)+1093534983|0;
								$tb=$this->carr($RR,$n,$ob+$this->llf($tb,2)>>2,"")|0;
								$yb=~(~($tb-(0-(~(~$xb|~-2)&(~-1220437297|-1220437297))))|~-2)&(~-1967453895|-1967453895);
								$xb=($xb^~1)&$xb;
								$wb=~$yb;
								$vb=~$xb;
								$ub=~-942245303;
								$this->carr($RR,$n,$N>>2,(($wb&-942245303|$yb&$ub)^($vb&-942245303|$xb&$ub)|~($wb|$vb)&(-942245303|$ub))-(0-(($tb^~1)&$tb)));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=999695174;continue;
								}			
					}
				
			if(($jb)<545100308)
					if(($jb)<484876086)
							if(($jb)<481757527)
								{
								$this->carr($RR,$n,$db>>2,$this->llf($this->carr($RR,$n,$lb>>2,""),$this->llf($this->carr($RR,$n,$ab>>2,""),3)));
								$tb=$this->carr($RR,$n,$Za>>2,"")>>2;
								$this->carr($RR,$n,$E>>2,$ob+$this->llf($tb,2));
								$this->carr($RR,$n,$m>>2,$this->carr($RR,$n,$this->carr($RR,$n,$E>>2,"")>>2,""));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=791025390;continue;
								}
							else
								{
								$n=71;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}				
							
					else if(($jb)<494739317)
								{
								$n=23;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$z>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$Hb=$this->carr($RR,$n,$sa>>2,"")|0;
								$Fb=~137942632;
								$Gb=$this->carr($RR,$n,$qa>>2,"")|0;
								$Gb=($Gb^~((137942632&~$Hb|$Hb&$Fb)^(~-1&137942632|-1&$Fb)))&$Gb;
								$Fb=$this->carr($RR,$n,$B>>2,"")|0;
								$Hb=~$Fb;
								$vb=~$Gb;
								$xb=~-5458134;
								$xb=($Hb&-5458134|$Fb&$xb)^($vb&-5458134|$Gb&$xb)|~($Hb|$vb)&(-5458134|$xb);
								$vb=$this->carr($RR,$n,$ma>>2,"")|0;
								$Hb=~(~((~(~$vb|~-2)&(~-1815835470|-1815835470))+1571403275+$xb-1571403275)|~-2)&(~-91142349|-91142349);
								$Gb=~(~$vb|~1)&(~-846305798|-846305798);
								$Fb=~$Hb;
								$Eb=~$Gb;
								$Db=~-118764121;
								$ub=$this->carr($RR,$n,$Fa>>2,"")|0;
								$ub=$this->carr($RR,$n,$Ga+$this->llf($ub,2)>>2,"")|0;
								$tb=0-(0-(((($this->carr($RR,$n,$Fa>>2,"")|0)*5|0)-(0-1)|0)%16|0)+(0-($this->carr($RR,$n,$ua>>2,"")|0)))|0;
								$tb=$this->carr($RR,$n,$ob+$this->llf($tb,2)>>2,"")|0;
								$Bb=~(~($tb+ -294782852+(~(~$ub|~-2)&(~-584088285|-584088285))+294782852)|~-2)&(~-1342378399|-1342378399);
								$Ab=~(~$ub|~1)&(~-1689304723|-1689304723);
								$zb=~$Bb;
								$yb=~$Ab;
								$wb=~35866813;
								$Cb=($tb^~1)&$tb;
								
								$Db=~(~((($Fb&-118764121|$Hb&$Db)^($Eb&-118764121|$Gb&$Db)|~($Fb|$Eb)&(-118764121|$Db))+764325492+(~(~$xb|~1)&(621349016|~621349016))-764325492)|~-2)&(1345718901|~1345718901);
								$wb=($Db&$Cb|$Db^$Cb)+686015919+(($zb&35866813|$Bb&$wb)^($yb&35866813|$Ab&$wb)|~($zb|$yb)&(35866813|$wb))+ -686015919|0;
								$wb=($wb^~-2)&$wb;
								$vb=$xb+1952671327+$vb-1952671327|0;
								$vb=($vb^~1)&$vb;
								$this->carr($RR,$n,$L>>2,($wb&$vb|$wb^$vb)+42513759+(~(~($tb+ -1580481692+$ub+1580481692)|~1)&(220197618|~220197618))-42513759);
								$ub=0-(0-(($this->carr($RR,$n,$Fa>>2,"")|0)%4|0)+(0-4))|0;
								$tb=$ya;
								$this->carr($RR,$n,$tb>>2,$ub);
								$this->carr($RR,$n,$tb+4>>2,$this->llf((($ub|0)<0),31)>>31);
								
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=276665542;continue;
								}			
					
			else if(($jb)<591681232) 
						if(($jb)<549762434)
								{
								$this->carr($RR,$n,$B>>2,~(~$this->carr($RR,$n,$oa>>2,"")|~$this->carr($RR,$n,$sa>>2,""))&(~-1131684153|-1131684153));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=494739317;continue;
								}
							else
								{
								$this->harr($RR,$ib>>3,0- +$this->harr($RR,$q>>3,""));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=416259719;continue;
								}				
							
					else if(($jb)<601583830)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==67?-1355478599:916103055;continue;
								}
							else
								{
								$n=63;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}					
							}				
					}
		
	if(($jb)<1667927966)
		if(($jb)<1297236730)
			{
			if(($jb)<1203488890)
					{
					if(($jb)<1129515855)
							{
							if(($jb)<1115527364)
								{
								$this->harr($RR,$U>>3,sin(+(+($this->carr($RR,$n,$t>>2,"")|0))));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-1380451239;continue;
								}
							if(($jb)<1117037785)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<35?-204104119:-1579204746;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==60?-602596021:916103055;continue;
								}					
							}
						
					if(($jb)<1153477833)
							if(($jb)<1137039176)
								{
								$this->aarr($RR,$n,$W>>0,($this->aarr($RR,$n,$k>>0,"")|0)!=0&1);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-424000715;continue;
								}
							else
								{
								$n=48;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}				
							
					else if(($jb)<1183072760)
								{
								$ub=$this->carr($RR,$n,$oa>>2,"")|0;
								$ub=($ub^~$this->carr($RR,$n,$qa>>2,""))&$ub;
								$yb=$this->carr($RR,$n,$oa>>2,"")|0;
								$xb=~1180867059;
								$xb=~(~$this->carr($RR,$n,$sa>>2,"")|~((1180867059&~$yb|$yb&$xb)^(~-1&1180867059|-1&$xb)))&(~-811559434|-811559434);
								$ub=$xb&$ub|$xb^$ub;
								$xb=$this->carr($RR,$n,$ma>>2,"")|0;
								$yb=~(~((($xb^~-2)&$xb)+430366929+$ub+ -430366929)|~-2)&(~-1385448869|-1385448869);
								$xb=($xb^~1)&$xb;
								$wb=~$yb;
								$vb=~$xb;
								$tb=~1812756882;
								$this->carr($RR,$n,$K>>2,(($wb&1812756882|$yb&$tb)^($vb&1812756882|$xb&$tb)|~($wb|$vb)&(1812756882|$tb))+ -1491978542+(($ub^~1)&$ub)+1491978542);
								$ub=$this->carr($RR,$n,$Fa>>2,"")|0;
								$tb=$xa;
								$this->carr($RR,$n,$tb>>2,$ub);
								$this->carr($RR,$n,$tb+4>>2,$this->llf((($ub|0)<0),31)>>31);
								
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=633810001;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==17?-1971280264:916103055;
								continue;
								}			
					}
				
			if(($jb)<1264018475)
					if(($jb)<1247969426)
						if(($jb)<1217939919)
							{
							$this->carr($RR,$n,$x>>2,(($this->carr($RR,$n,$Fa>>2,"")|0)*23|0)-122893342+(($this->carr($RR,$n,$ua>>2,"")|0)*37|0)+122893342);
							$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
							$jb=73587007;continue;
							}
						else
							{
							$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
							$jb=($this->carr($RR,$n,$o>>2,"")|0)<9?-1951072297:-411922879;continue;
							}					
					
					else if(($jb)<1256704313)
							{
							$this->aarr($RR,$n,$aa>>0,($this->carr($RR,$n,$lb>>2,"")|0)<10&1);
							$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
							$jb=1804404662;continue;
							}
						else
							{
							$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
							$jb=($this->carr($RR,$n,$o>>2,"")|0)<69?801681189:-1060336117;continue;
							}		
					
			else if(($jb)<1288598934)
						if(($jb)<1287975406)
							{
							$this->carr($RR,$n,$this->carr($RR,$n,$F>>2,"")>>2,$this->carr($RR,$n,$_a>>2,""));$n=$this->carr($RR,$n,$Ka>>2,"")|0;
							$this->carr($RR,$n,$ob+$this->llf($n,2)>>2,($this->llf($this->carr($RR,$n,$Ia>>2,""),3))+832153837+256-832153837);
							$n=19;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
							$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=0;$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;
							$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;
							$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;
							$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
							$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
							}
						else
							{
							$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
							$jb=($this->carr($RR,$n,$o>>2,"")|0)<58?-1841591203:709849698;continue;
							}						
					
					else if(($jb)<1290413867)
							{
							$tb=$this->carr($RR,$n,$hb>>2,"")|0;
							$this->carr($RR,$n,$s>>2,217+(($tb^-16)&$tb));
							$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
							$jb=-423412824;continue;
							}
						else
							{
							$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
							$jb=($this->carr($RR,$n,$o>>2,"")|0)<55?-1202295682:2120616980;continue;
							}						
						}
		else
			{
			if(($jb)<1432877594)
					{
					if(($jb)<1370835909)
							{
							if(($jb)<1315897097)
								{
								$n=69;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							if(($jb)<1347562810)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==49?-25886128:916103055;continue;
								}
							else
								{
								$tb=$this->carr($RR,$n,$Fa>>2,"")|0;$tb=($tb^~7)&$tb;
								$this->carr($RR,$n,$pb>>2,1&~$tb|$tb&~1);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-991315587;continue;
								}							
							}
						
					if(($jb)<1410343841)
							if(($jb)<1388594392)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==31?637834779:916103055;continue;
								}
							else
								{
								$n=64;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}					
							
					else if(($jb)<1410777152)
								{
								$n=45;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$w>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=$this->aarr($RR,$n,$dol>>0,"")&1?2045376102:-489741395;continue;
								}			
					}
				
			if(($jb)<1514554794)
					if(($jb)<1468918320)
							if(($jb)<1466680073)
								{
								$n=9;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<60?-708759048:1256704313;continue;
								}
							
					else if(($jb)<1510822949)
								{
								$n=77;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$this->aarr($RR,$n,$this->carr($RR,$n,$H>>2,"")>>0,$this->aarr($RR,$n,$j>>0,"")|0);
								$n=67;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=($this->carr($RR,$n,$Fa>>2,"")|0)-(0-1)|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}			
					
			else 
					
					if(($jb)<1618283724)
							if(($jb)<1541240532)
								{
								$this->aarr($RR,$n,$ca>>0,($this->carr($RR,$n,$Fa>>2,"")|0)<16&1);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-668795440;continue;
								}
							else
								{
								$this->carr($RR,$n,$w>>2,($this->carr($RR,$n,$Ka>>2,"")|0)-(0-16));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=1410343841;continue;
								}
								
					else if(($jb)<1657487624)
								{
								$n=40;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$n=43;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}						
							}
		
	else 
		
		if(($jb)<1969546970)
			{
			if(($jb)<1775324253)
					{
					if(($jb)<1717331240)
							{
							if(($jb)<1670387339)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=$this->aarr($RR,$n,$ia>>0,"")&1?-777225753:1388594392;continue;
								}
								
							if(($jb)<1688333518)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<13?-499972263:-22207083;continue;
								}
							else
								{
								$this->carr($RR,$n,$ob+$this->llf($this->carr($RR,$n,$wa>>2,""),2)>>2,0);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-895015477;continue;
								}					
							}
						
					if(($jb)<1771209720)
							if(($jb)<1720235387)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<67?-1712406553:591681232;continue;
								}
							else
								{
								$n=33;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$Ca>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}					
						
					else if(($jb)<1774369769)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==81?-2074579782:916103055;continue;
								}
							else
								{
								$n=21;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}			
					}
				
			if(($jb)<1826842851)
					if(($jb)<1804404662)
							if(($jb)<1775530198)
								{
								$n=31;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==5?439769685:916103055;continue;
								}					
						
					else if(($jb)<1815387249)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=$this->aarr($RR,$n,$aa>>0,"")&1?-2136717671:-828878942;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<73?212826519:-252274077;continue;
								}
			else 
					
					if(($jb)<1942162936)
							if(($jb)<1867803797)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==19?-545058508:916103055;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<27?1247969426:-1943746193;continue;
								}
					else if(($jb)<1951978675)
								{								
								$this->aarr($RR,$n,$fa>>0,($this->carr($RR,$n,$Fa>>2,"")|0)<48&1);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-1610186071;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=$this->aarr($RR,$n,$da>>0,"")&1?-2014580748:481757527;continue;
								}
			}
		else
			{
			if(($jb)<2045376102)
					{
					if(($jb)<2008811188)
							{
							if(($jb)<1980027799)
								{
								$this->Xa($RR,$this->carr($RR,$n,$d>>2,"")|0,0,256)|0;
								$this->carr($RR,$n,$e>>2,$ob);
								$this->Xa($RR,$this->carr($RR,$n,$e>>2,"")|0,0,512)|0;
								$n=62;$p=0;$la=0;$na=0;$pa=0;$ra=0;$ta=0;$Ea=0;$Ha=0;$Ja=0;$La=0;$Na=0;
								$Pa=0;$Ra=0;$Ya=0;$jb=-188097831;$kb=0;$mb=0;continue;
								}
							if(($jb)<1982907982)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=$this->aarr($RR,$n,$ha>>0,"")&1?1297236730:-920516874;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==52?887924077:916103055;continue;
								}					
							}
						
					if(($jb)<2028659015)
							if(($jb)<2014978051)
								{
								$xb=$this->carr($RR,$n,$Oa>>2,"")|0;
								$ub=$this->carr($RR,$n,$oa>>2,"")|0;
								$yb=(($xb^~-2)&$xb)-(0-$ub)|0;
								$yb=($yb^~-2)&$yb;
								$xb=($xb^~1)&$xb;
								$wb=~$yb;
								$vb=~$xb;
								$tb=~-315119066;
								$this->carr($RR,$n,$S>>2,(($wb&-315119066|$yb&$tb)^($vb&-315119066|$xb&$tb)|~($wb|$vb)&(-315119066|$tb))-(0-(($ub^~1)&$ub)));
								$ub=$this->carr($RR,$n,$Qa>>2,"")|0;
								$tb=$this->carr($RR,$n,$qa>>2,"")|0;
								$vb=(($ub^~-2)&$ub)+369117907+$tb+ -369117907|0;
								$vb=($vb^~-2)&$vb;
								$ub=~(~$ub|~1)&(~-1507607054|-1507607054);
								$this->carr($RR,$n,$T>>2,0-(0-($vb&$ub|$vb^$ub)+(0-(($tb^~1)&$tb))));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-1101163512;continue;
								}
							else
								{
								$n=75;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
												
							
					else if(($jb)<2040419279)
								{
								$n=7;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<11?-2109032559:-331915256;continue;
								}					
							}				
					
				
			if(($jb)<2088360821)
					if(($jb)<2059037329)
							if(($jb)<2055800044)
								{
								$n=27;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<54?1982907982:-2014779455;continue;
								}
					else if(($jb)<2070699595)
								{
								$n=55;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$n=46;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
			else 
					
					if(($jb)<2131809869)
							if(($jb)<2120616980)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<7?1775530198:1217939919;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<57?-1156946543:1287975406;continue;
								}
					else if(($jb)<2146552338)
								{
								$this->aarr($RR,$n,$X>>0,($this->carr($RR,$n,$v>>2,"")|0)>=($this->carr($RR,$n,$Za>>2,"")|0)&1);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-44538672;continue;
								}
							else
								{
								$n=0;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}					
							}				
					}
	if(($jb)<-983205733)
		if(($jb)<-1552799363)
			if(($jb)<-1924281938)
				{
				if(($jb)<-2014580748)
						{
						if(($jb)<-2074579782)
								{
								if(($jb)<-2136717671)
									{
									$n=5;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
								if(($jb)<-2109032559)
									{
									$n=25;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<5?-524762773:2088360821;continue;
									}						
								}
							
						if(($jb)<-2017858759)
								if(($jb)<-2051875059)
									{
									$n=79;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
								else
									{
									$n=1;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}						
							
						else if(($jb)<-2014779455)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<31?775542450:-1629615901;continue;
									}
								else
									{
									$n=52;$p=$this->harr($RR,$q>>3,"");$la=1732584193;$na=-271733879;$pa=-1732584194;
									$ra=271733878;$ta=$this->carr($RR,$n,$ua>>2,"")|0;$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;
									$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;
									$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;
									$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}				
						}
					
				if(($jb)<-1966247896)
						if(($jb)<-1971280264)
								if(($jb)<-1995522865)
									{
									$n=73;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;
									
									continue;
									}
								else
									{
									$this->aarr($RR,$n,$ga>>0,($this->carr($RR,$n,$Fa>>2,"")|0)<64&1);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=-763186054;continue;
									}						
							
						else if(($jb)<-1967845546)
									{
									$n=15;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									
									$La=$this->carr($RR,$n,$ma>>2,"")|0;$Na=$this->carr($RR,$n,$oa>>2,"")|0;$Pa=$this->carr($RR,$n,$qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;
								
									continue;
									}
								else
									{
									$this->carr($RR,$n,$A>>2,($this->carr($RR,$n,$lb>>2,"")|0)-(0-90));
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=-180306226;continue;
									}
				else 		
						if(($jb)<-1943746193)
								if(($jb)<-1951072297)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)==29?620960943:916103055;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)==7?1942162936:916103055;continue;
									}						
							
						else if(($jb)<-1936945228)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<29?-1367008151:-1966247896;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<41?-1797419395:-1183676751;continue;
									}						
								}
			else
				{
				if(($jb)<-1781069297)
						{
						if(($jb)<-1841591203)
								{
								if(($jb)<-1892665105)
									{
									$n=17;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
									
								if(($jb)<-1878597151)
									{
									$this->carr($RR,$n,$ab>>2,($this->carr($RR,$n,$Za>>2,"")|0)%4|0);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=463554092;continue;
									}
								else
									{
									$n=47;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$u>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$fb>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}						
								}
								
						if(($jb)<-1797419395)
								if(($jb)<-1814214169)
									{
									$this->aarr($RR,$n,$ka>>0,$this->harr($RR,$q>>3,"")<0&1);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=-152754021;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)==79?-1129217909:916103055;continue;
									}						
							
						else if(($jb)<-1785460248)
									{
									$n=38;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
								else
									{
									$n=45;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
						}
					
				if(($jb)<-1629615901)
						if(($jb)<-1662327480)
								if(($jb)<-1712406553)
									{
									$n=58;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)==65?-1153545492:916103055;continue;
									}						
							
						else if(($jb)<-1649803199)
									{
									$n=11;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=-452257369;continue;
									}
				else 		
						if(($jb)<-1579204746)
							
								if(($jb)<-1610186071)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<36?-494102117:-968403108;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=$this->aarr($RR,$n,$fa>>0,"")&1?-2141197378:-630729423;continue;
									}
							
						else if(($jb)<-1572948785)
									{
									$n=33;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$ua>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
								else
									{
									$this->aarr($RR,$n,$da>>0,($this->carr($RR,$n,$Fa>>2,"")|0)<16&1);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=1951978675;continue;
									}						
								}
		else 	
			if(($jb)<-1212483299)
				{
				if(($jb)<-1361726950)
						{
						if(($jb)<-1396656085)
								{
								if(($jb)<-1530939976)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=$this->aarr($RR,$n,$Z>>0,"")&1?139799944:690197071;continue;
									}
								if(($jb)<-1414489443)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<23?2040419279:-2017858759;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<81?-1814214169:1771209720;continue;
									}					
								}
							
						if(($jb)<-1380451239)
								if(($jb)<-1385908106)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)==13?1153477833:916103055;continue;
									}
								else
									{
									$tb=$this->carr($RR,$n,$nb>>2,"")|0;
									$this->aarr($RR,$n,$k>>0,$this->aarr($RR,$n,$b+$tb>>0,"")|0);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=1129515855;continue;
									}						
							
						else if(($jb)<-1367008151)
									{
									$n=57;$p=$this->harr($RR,$U>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)==27?1203488890:916103055;continue;
									}					
								}
					
				if(($jb)<-1341729830)
						if(($jb)<-1360885125)
								if(($jb)<-1361473685)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<62?1117037785:1010850097;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=$this->aarr($RR,$n,$ba>>0,"")&1?-1924281938:128106704;continue;
									}						
							
						else if(($jb)<-1355478599)
									{
									$n=56;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
									}
								else
									{
									$this->aarr($RR,$n,$ia>>0,($this->carr($RR,$n,$Fa>>2,"")|0)<32&1);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=1667927966;continue;
									}				
						
				else 		
						if(($jb)<-1266383858)
								if(($jb)<-1290934332)
									{
									$this->aarr($RR,$n,$Z>>0,($this->carr($RR,$n,$ua>>2,"")|0)<($this->carr($RR,$n,$Ia>>2,"")|0)&1);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=-1552799363;continue;
									}
								else
									{
									$Db=$this->carr($RR,$n,$sa>>2,"")|0;
									$Db=~$Db|0|$Db&~-1;
									$ub=$this->carr($RR,$n,$oa>>2,"")|0;
									$tb=~$ub;
									$vb=~$Db;
									$wb=~2127574409;
									$wb=($tb&2127574409|$ub&$wb)^($vb&2127574409|$Db&$wb)|~($tb|$vb)&(2127574409|$wb);
									$vb=$this->carr($RR,$n,$qa>>2,"")|0;
									$tb=~-1932706895;
									$tb=(~$vb&-1932706895|$vb&$tb)^(~$wb&-1932706895|$wb&$tb);
									$wb=$this->carr($RR,$n,$ma>>2,"")|0;
									$vb=(~(~$wb|~-2)&(604911631|~604911631))+ -11283782+$tb+11283782|0;
									$vb=($vb^~-2)&$vb;
									$Db=~(~$wb|~1)&(~-1450542935|-1450542935);
									$Db=($vb&$Db|$vb^$Db)-61851760+(~(~$tb|~1)&(340471306|~340471306))+61851760|0;
									$vb=$this->carr($RR,$n,$Fa>>2,"")|0;
									$vb=$this->carr($RR,$n,$Ga+$this->llf($vb,2)>>2,"")|0;
									$ub=((($this->carr($RR,$n,$Fa>>2,"")|0)*7|0)%16|0)-672911061+($this->carr($RR,$n,$ua>>2,"")|0)+672911061|0;
									$ub=$this->carr($RR,$n,$ob+$this->llf($ub,2)>>2,"")|0;
									$Bb=$ub+690379117+(($vb^~-2)&$vb)+ -690379117|0;
									$Bb=($Bb^~-2)&$Bb;
									$Ab=($vb^~1)&$vb;
									$zb=~$Bb;
									$yb=~$Ab;
									$xb=~193036646;
									$Cb=~(~$ub|~1)&(1536398528|~1536398528);
									$Db=($Db^~-2)&$Db;
									$xb=($Db&$Cb|$Db^$Cb)-(0-(($zb&193036646|$Bb&$xb)^($yb&193036646|$Ab&$xb)|~($zb|$yb)&(193036646|$xb)))|0;
									$xb=($xb^~-2)&$xb;
									$wb=$tb-1022942196+$wb+1022942196|0;
									$wb=($wb^~1)&$wb;
									$vb=0-(0-$ub+(0-$vb))|0;
									$vb=($xb&$wb|$xb^$wb)-1477198952+(($vb^~1)&$vb)+1477198952|0;
									$wb=0-(0-(($this->carr($RR,$n,$Fa>>2,"")|0)%4|0)+(0-12))|0;
									$wb=$this->carr($RR,$n,16+$this->llf($wb,2)>>2,"")|0;
									$xb=$this->llf($vb,$wb);
									$wb=$this->_rshift($vb,(32-780953686-$wb+780953686|0));
									$vb=~$xb;
									$ub=~$wb;
									$tb=~850713340;
									$this->carr($RR,$n,$__a>>2,($vb&850713340|$xb&$tb)^($ub&850713340|$wb&$tb)|~($vb|$ub)&(850713340|$tb));
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=-665924408;continue;
									}						
							
						else if(($jb)<-1266323623)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<71?-771214760:1815387249;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<22?153691705:151603818;continue;
									}						
								}
			else
				{
				if(($jb)<-1137547745)
						{
						if(($jb)<-1173436005)
								{
								if(($jb)<-1202295682)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)==77?-412272376:916103055;continue;
									}
								if(($jb)<-1183676751)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<52?-1385908106:2055800044;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)==41?-934444625:916103055;continue;
									}						
								}
							
						if(($jb)<-1156946543)
								if(($jb)<-1157656715)
									{
									$this->harr($RR,$Wa>>3,$this->harr($RR,$q>>3,"")*4294967296);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=800362374;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<19?1183072760:1826842851;continue;
									}						
							
						else if(($jb)<-1153545492)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<56?-1173436005:549762434;continue;
									}
								else
									{
									$tb=$this->carr($RR,$n,$Fa>>2,"")|0;
									$this->carr($RR,$n,$C>>2,($tb^~7)&$tb);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=-521081237;continue;
									}						
								}
					
				if(($jb)<-1060336117)
						if(($jb)<-1101163512)
								if(($jb)<-1129217909)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)==0?-327886970:916103055;continue;
									}
								else
									{
									$this->aarr($RR,$n,$V>>0,($this->carr($RR,$n,$Fa>>2,"")|0)<8&1);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=60376344;continue;
									}						
							
						else if(($jb)<-1098566066)
									{
									$ta=$this->carr($RR,$n,$Sa>>2,"")|0;
									$ra=$this->carr($RR,$n,$sa>>2,"")|0;
									$Ea=(~(~$ta|~-2)&(1610295581|~1610295581))+500368708+$ra+ -500368708|0;
									$Ea=($Ea^~-2)&$Ea;
									$ta=~(~$ta|~1)&(~-705350905|-705350905);
									$n=19;
									$p=$this->harr($RR,$q>>3,"");
									$la=$this->carr($RR,$n,$R>>2,"")|0;
									$na=$this->carr($RR,$n,$S>>2,"")|0;
									$pa=$this->carr($RR,$n,$T>>2,"")|0;
									$ra=($Ea&$ta|$Ea^$ta)+1557818241+(($ra^~1)&$ra)-1557818241|0;
									$ta=0-(0-($this->carr($RR,$n,$ua>>2,"")|0)+(0-16))|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;
									$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;
									$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;
									$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;
									
									continue;
									}
								else
									{
									$this->aarr($RR,$n,$Y>>0,($this->carr($RR,$n,$ua>>2,"")|0)<($this->carr($RR,$n,$Za>>2,"")|0)&1);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=-999614033;continue;
									}
				else		
						if(($jb)<-999614033)
								if(($jb)<-1031373064)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<75?-1266383858:-743013407;continue;
									}
								else
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<45?1093527402:-147891877;continue;
									}
						else 
								
								if(($jb)<-991315587)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=$this->aarr($RR,$n,$Y>>0,"")&1?331129789:1618283724;continue;
									}
								else
									{
									$ub=$this->carr($RR,$n,$oa>>2,"")>>$this->llf($this->carr($RR,$n,$pb>>2,""),2);
									$this->aarr($RR,$n,$g>>0,$this->aarr($RR,$n,217+(($ub^-16)&$ub)>>0,"")|0);
									$ub=$this->carr($RR,$n,$Fa>>2,"")|0;
									$tb=$za;
									$this->carr($RR,$n,$tb>>2,$ub);
									$this->carr($RR,$n,$tb+4>>2,$this->llf((($ub|0)<0),31)>>31);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=-58343100;continue;
									}						
								}
	else 	
		if(($jb)<-494102117)
			if(($jb)<-743013407)
				{
				if(($jb)<-856036625)
						{
						if(($jb)<-920516874)
								{
								if(($jb)<-968403108)
									{
									$n=13;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
									$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
									$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
									$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
									$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
									$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;
									
									continue;
									}
								if(($jb)<-934444625)
									{
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=($this->carr($RR,$n,$o>>2,"")|0)<40?1058751639:-1936945228;continue;
									}
								else
									{
									$ub=$this->carr($RR,$n,$ua>>2,"")|0;
									$tb=$wa;
									$this->carr($RR,$n,$tb>>2,$ub);
									$this->carr($RR,$n,$tb+4>>2,$this->llf((($ub|0)<0),31)>>31);
									$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
									$jb=1688333518;continue;
									}						
								}
							
						if(($jb)<-902588506)
							if(($jb)<-909244188)
								{
								$n=67;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;
								
								continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<21?-1157656715:-1266323623;continue;
								}					
						
				else if(($jb)<-895015477)
								{
								$this->carr($RR,$n,$I>>2,($this->carr($RR,$n,$J>>2,"")|0)+32);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-747420302;continue;
								}
						else
								{
								
								$n=43;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;
								$ta=0-(0-($this->carr($RR,$n,$ua>>2,"")|0)+(0-1))|0;$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;
								$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;
								$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;
								$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;$kb=$this->carr($RR,$n,$lb>>2,"")|0;
								$mb=$this->carr($RR,$n,$nb>>2,"")|0;
								
								continue;
								}					
						}
						
			if(($jb)<-777225753)
					if(($jb)<-828878942)
							if(($jb)<-843646639)
								{
								$n=60;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=0;$Ea=0;$Ha=0;
								$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;
								$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;
								$jb=-188097831;$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$n=52;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ba>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}					
						
					else if(($jb)<-823999218)
								{
								$n=24;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<24?-1892665105:635155771;continue;
								}
			else 		
					if(($jb)<-763186054)
							if(($jb)<-771214760)
								{
								$n=65;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
								}
							else
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)==69?651068526:916103055;continue;
								}					
						
					else if(($jb)<-747420302)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=$this->aarr($RR,$n,$ga>>0,"")&1?-2051875059:2146552338;continue;
								}
							else
								{
								$this->aarr($RR,$n,$this->carr($RR,$n,$I>>2,"")>>0,0);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=601583830;continue;
								}					
							}
		else
			{
			if(($jb)<-630729423)
					{
					if(($jb)<-708759048)
							{
							if(($jb)<-738461164)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<79?920364886:-1414489443;continue;
								}
								
							if(($jb)<-722374409)
								{
								$n=$this->_rshift(($this->carr($RR,$n,$O>>2,"")|0),($this->carr($RR,$n,$bb>>2,"")|0));					
								$la=$this->carr($RR,$n,$eb>>2,"")|0; 
								
							
								$ra=~$la;
								$pa=~$n;
								$na=~656398317;
								$na=($ra&656398317|$la&$na)^($pa&656398317|$n&$na)|~($ra|$pa)&(656398317|$na);
								
								
								$pa=$this->carr($RR,$n,$oa>>2,"")|0;
								$ra=0-(0-(~(~$pa|~-2)&(2104648903|~2104648903))+(0-$na))|0;
								$ra=($ra^~-2)&$ra;
								$pa=($pa^~1)&$pa;
								$n=7;
								$p=$this->harr($RR,$q>>3,"");
								$la=$this->carr($RR,$n,$sa>>2,"")|0;
								$na=($ra&$pa|$ra^$pa)+1158045464+(~(~$na|~1)&(~-858883747|-858883747))+ -1158045464|0;
								
								
																
								$pa=$this->carr($RR,$n,$oa>>2,"")|0;$ra=$this->carr($RR,$n,$qa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=($this->carr($RR,$n,$Fa>>2,"")|0)+1759879971+1+ -1759879971|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;
								$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;
								$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;
								$jb=-188097831;$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;
							
								continue;
								}
							else
								{
								$n=54;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
								$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
								$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
								$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
								$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
								$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;
								
								continue;
								}					
							}
						
					if(($jb)<-668795440)
							if(($jb)<-671207445)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=($this->carr($RR,$n,$o>>2,"")|0)<51?852236017:1290413867;continue;
								}
							else
								{
								$this->carr($RR,$n,$t>>2,0-(0-($this->carr($RR,$n,$Fa>>2,"")|0)+(0-1)));
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=1111318124;continue;
								}					
						
					else if(($jb)<-665924408)
								{
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;$jb=$this->aarr($RR,$n,$ca>>0,"")&1?-983205733:-1662327480;continue;
								}
							else
								{
								$tb=$this->carr($RR,$n,$__a>>2,"")|0;
								$ub=$this->carr($RR,$n,$oa>>2,"")|0;
								$vb=~(~((($ub^~-2)&$ub)+780709209+$tb+ -780709209)|~-2)&(~-168997235|-168997235);
								$ub=~(~$ub|~1)&(~-502501551|-502501551);
								$this->carr($RR,$n,$P>>2,($vb&$ub|$vb^$ub)+ -1224380757+(($tb^~1)&$tb)+1224380757);
								$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
								$jb=-401948426;continue;
								}					
							}
						
					if(($jb)<-526301530)
							if(($jb)<-568636039)
									if(($jb)<-602596021)
										{
										$n=3;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;$na=$this->carr($RR,$n,$oa>>2,"")|0;
										$pa=$this->carr($RR,$n,$qa>>2,"")|0;$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
										$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
										$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
										$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
										$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
										}
									else
										{
										$this->aarr($RR,$n,$ja>>0,($this->carr($RR,$n,$Fa>>2,"")|0)<64&1);
										$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
										$jb=780107150;continue;
										}						
									
							else if(($jb)<-545058508)
										{
										$this->carr($RR,$n,$Ta>>2,$this->llf(($this->carr($RR,$n,$Ia>>2,"")|0)-(0-40)>>6,4));
										$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
										$jb=717745890;continue;
										}
									else
										{
										$this->aarr($RR,$n,$ba>>0,($this->carr($RR,$n,$ua>>2,"")|0)<($this->carr($RR,$n,$Ka>>2,"")|0)&1);
										$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
										$jb=-1361473685;continue;
										}
					else 		
							if(($jb)<-521081237)
								
									if(($jb)<-524762773)
										{
										$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
										$jb=($this->carr($RR,$n,$o>>2,"")|0)==38?-1341729830:916103055;continue;
										}
									else
										{
										$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
										$jb=($this->carr($RR,$n,$o>>2,"")|0)<1?-1137547745:-107249853;continue;
										}						
								
							else if(($jb)<-499972263)
										{
										$ub=$this->llf($this->carr($RR,$n,$C>>2,""),2);
										$tb=~852477429;
										$tb=$this->carr($RR,$n,$sa>>2,"")>>((852477429&~$ub|$ub&$tb)^(~4&852477429|4&$tb));
										$this->aarr($RR,$n,$j>>0,$this->aarr($RR,$n,217+(($tb^-16)&$tb)>>0,"")|0);
										$tb=$this->carr($RR,$n,$Fa>>2,"")|0;
										$this->carr($RR,$n,$H>>2,($this->carr($RR,$n,$J>>2,"")|0)+$tb);
										$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
										$jb=1510822949;continue;
										}
									else
										{	
										$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
										$jb=($this->carr($RR,$n,$o>>2,"")|0)==11?809617043:916103055;continue;
										}						
									}
			else 		
					if(($jb)<-255123066)
							{
							if(($jb)<-411922879)
									{
									if(($jb)<-424000715)
											{
											if(($jb)<-489741395)
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=($this->carr($RR,$n,$o>>2,"")|0)<33?1370835909:1115527364;continue;
												}
												
											if(($jb)<-452257369)
												{
												$n=22;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;
												$na=$this->carr($RR,$n,$oa>>2,"")|0;$pa=$this->carr($RR,$n,$qa>>2,"")|0;
												$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
												$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;
												$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;
												$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
												$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;
												$jb=-188097831;$kb=$this->carr($RR,$n,$lb>>2,"")|0;
												$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
												}
											else
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=974401706;continue;
												}							
											}
										
									if(($jb)<-412361919)
											if(($jb)<-423412824)
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=$this->aarr($RR,$n,$W>>0,"")&1?270009349:1137039176;continue;
												}
											else
												{
												$n=$this->carr($RR,$n,$Fa>>2,"")|0;
												$this->aarr($RR,$n,($this->carr($RR,$n,$J>>2,"")|0)+$n>>0,$this->aarr($RR,$n,$this->carr($RR,$n,$s>>2,"")>>0,"")|0);
												$n=71;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;
												$na=$this->carr($RR,$n,$oa>>2,"")|0;$pa=$this->carr($RR,$n,$qa>>2,"")|0;
												$ra=$this->carr($RR,$n,$sa>>2,"")|0;
												$ta=$this->carr($RR,$n,$ua>>2,"")|0;$Ea=($this->carr($RR,$n,$Fa>>2,"")|0)-(0-1)|0;
												$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
												$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;
												$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;
												$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
												$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
												}							
										
									else if(($jb)<-412272376)
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=$this->aarr($RR,$n,$_>>0,"")&1?1775324253:1774369769;continue;
												}
											else
												{
												$tb=~(~$this->llf($this->carr($RR,$n,$Fa>>2,""),2)|~28)&(133688724|~133688724);
												$this->carr($RR,$n,$r>>2,217+~(~($this->carr($RR,$n,$ma>>2,"")>>(4&~$tb|$tb&~4))|-16));
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=-390950602;continue;
												}							
											}						
									
								
							if(($jb)<-327886970)
									if(($jb)<-390950602)
											if(($jb)<-401948426)
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=($this->carr($RR,$n,$o>>2,"")|0)==9?545100308:916103055;continue;
												}
											else
												{
												$n=3;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$sa>>2,"")|0;
												$na=$this->carr($RR,$n,$P>>2,"")|0;$pa=$this->carr($RR,$n,$oa>>2,"")|0;
												$ra=$this->carr($RR,$n,$qa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
												$Ea=($this->carr($RR,$n,$Fa>>2,"")|0)+1860184337+1+ -1860184337|0;
												$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
												$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;
												$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;
												$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
												$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
												}							
										
									else if(($jb)<-331915256)
												{
												$this->aarr($RR,$n,$f>>0,$this->aarr($RR,$n,$this->carr($RR,$n,$r>>2,"")>>0,"")|0);
												$ub=$this->carr($RR,$n,$Fa>>2,"")|0;
												$tb=$va;
												$this->carr($RR,$n,$tb>>2,$ub);
												$this->carr($RR,$n,$tb+4>>2,$this->llf((($ub|0)<0),31)>>31);
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=-275270623;continue;
												}
											else
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=($this->carr($RR,$n,$o>>2,"")|0)<17?1670387339:-909244188;continue;
												}					
									
							else 		
									if(($jb)<-275270623)
											if(($jb)<-303896161)
												{
												$xb=$this->carr($RR,$n,$Ma>>2,"")|0;
												$tb=$this->carr($RR,$n,$ma>>2,"")|0;
												$yb=~(~((~(~$xb|~-2)&(158737468|~158737468))-485042156+$tb+485042156)|~-2)&(~-978858707|-978858707);
												$xb=~(~$xb|~1)&(1643252880|~1643252880);
												$wb=~$yb;
												$vb=~$xb;
												$ub=~1572610025;
												$this->carr($RR,$n,$R>>2,(($wb&1572610025|$yb&$ub)^($vb&1572610025|$xb&$ub)|~($wb|$vb)&(1572610025|$ub))+144431907+(~(~$tb|~1)&(1565796204|~1565796204))-144431907);
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=2008811188;continue;
												}
											else
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=($this->carr($RR,$n,$o>>2,"")|0)<49?-568636039:1315897097;continue;
												}							
										
									else if(($jb)<-256536033)
												{
												$this->aarr($RR,$n,($this->carr($RR,$n,$J>>2,"")|0)+($this->carr($RR,$n,$va>>2,"")|0)>>0,$this->aarr($RR,$n,$f>>0,"")|0);
												$n=79;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;
												$na=$this->carr($RR,$n,$oa>>2,"")|0;$pa=$this->carr($RR,$n,$qa>>2,"")|0;
												$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
												$Ea=($this->carr($RR,$n,$Fa>>2,"")|0)+1957808098+1-1957808098|0;
												$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
												$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;
												$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;
												$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
												$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
												}
											else
												{
												$n=51;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;
												$na=$this->carr($RR,$n,$oa>>2,"")|0;$pa=$this->carr($RR,$n,$qa>>2,"")|0;
												$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$Aa>>2,"")|0;
												$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;
												$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;
												$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
												$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;
												$jb=-188097831;$kb=$this->carr($RR,$n,$lb>>2,"")|0;
												$mb=$this->carr($RR,$n,$ua>>2,"")|0;continue;
												}							
											}						
														
							
					else
							{
							if(($jb)<-147891877)
									{
									if(($jb)<-188097831)
											{
											if(($jb)<-252274077)
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=($this->carr($RR,$n,$o>>2,"")|0)<43?-1530939976:1466680073;continue;
												}
												
											if(($jb)<-204104119)
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=($this->carr($RR,$n,$o>>2,"")|0)==73?1347562810:916103055;continue;
												}
											else
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=($this->carr($RR,$n,$o>>2,"")|0)==33?368050796:916103055;continue;
												}							
											}
										
									if(($jb)<-164314163)
											if(($jb)<-180306226)
												{
												$this->carr($RR,$n,$o>>2,$n);$this->carr($RR,$n,$Sa>>2,$Ra);
												$this->carr($RR,$n,$Qa>>2,$Pa);$this->carr($RR,$n,$Oa>>2,$Na);
												$this->carr($RR,$n,$Ma>>2,$La);$this->carr($RR,$n,$lb>>2,$kb);
												$this->carr($RR,$n,$Za>>2,$Ya);$this->carr($RR,$n,$nb>>2,$mb);
												$this->carr($RR,$n,$sa>>2,$ra);$this->carr($RR,$n,$qa>>2,$pa);
												$this->carr($RR,$n,$oa>>2,$na);$this->carr($RR,$n,$ma>>2,$la);
												$this->carr($RR,$n,$ua>>2,$ta);$this->harr($RR,$q>>3,$p);
												$this->carr($RR,$n,$Ka>>2,$Ja);$this->carr($RR,$n,$Ia>>2,$Ha);
												$this->carr($RR,$n,$Fa>>2,$Ea);
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=-255123066;continue;
												}
											else
												{
												$n=23;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;
												$na=$this->carr($RR,$n,$oa>>2,"")|0;$pa=$this->carr($RR,$n,$qa>>2,"")|0;
												$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
												$Ea=$this->carr($RR,$n,$Fa>>2,"")|0;$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;
												$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;$La=$this->carr($RR,$n,$Ma>>2,"")|0;
												$Na=$this->carr($RR,$n,$Oa>>2,"")|0;$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
												$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;$Ya=$this->carr($RR,$n,$Za>>2,"")|0;
												$jb=-188097831;$kb=$this->carr($RR,$n,$A>>2,"")|0;
												$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
												}							
										
									else if(($jb)<-152754021)
												{
												$ra=$this->carr($RR,$n,$this->carr($RR,$n,$G>>2,"")>>2,"")|0;
												$n=(($this->carr($RR,$n,$Fa>>2,"")|0)%16|0)-1178941561+($this->carr($RR,$n,$ua>>2,"")|0)+1178941561|0;
												$n=$this->carr($RR,$n,$ob+$this->llf($n,2)>>2,"")|0;
												$Ha=~(~($n+ -1142814721+(~(~$ra|~-2)&(~-1887619057|-1887619057))+1142814721)|~-2)&(1306095578|~1306095578);
												$Ea=~(~$ra|~1)&(~-2038887719|-2038887719);
												$ta=~$Ha;
												$na=~$Ea;
												$pa=~372789369;
												$Ja=~(~$n|~1)&(1643553581|~1643553581);
												$la=$this->carr($RR,$n,$K>>2,"")|0;
												$La=~(~$la|~-2)&(~-1940854541|-1940854541);
												$pa=0-(0-($La&$Ja|$La^$Ja)+(0-(($ta&372789369|$Ha&$pa)^($na&372789369|$Ea&$pa)|~($ta|$na)&(372789369|$pa))))|0;
												$pa=($pa^~-2)&$pa;
												$la=~(~$la|~1)&(1953863738|~1953863738);
												$ra=0-(0-($pa&$la|$pa^$la)+(0-(~(~($n-(0-$ra))|~1)&(687100864|~687100864))))|0;
												$n=($this->carr($RR,$n,$Fa>>2,"")|0)%4|0;
												$n=$this->carr($RR,$n,16+$this->llf($n,2)>>2,"")|0;
												$la=$this->llf($ra,$n);
												$n=$this->_rshift($ra,(32+985163289-$n+ -985163289|0));
												$ra=~$la;
												$pa=~$n;
												$na=~50919874;
												$na=($ra&50919874|$la&$na)^($pa&50919874|$n&$na)|~($ra|$pa)&(50919874|$na);
												$pa=$this->carr($RR,$n,$oa>>2,"")|0;
												$ra=~(~($na-(0-(($pa^~-2)&$pa)))|~-2)&(1048747497|~1048747497);
												$pa=($pa^~1)&$pa;
												$n=15;
												$p=$this->harr($RR,$q>>3,"");
												$la=$this->carr($RR,$n,$sa>>2,"")|0;
												$na=($ra&$pa|$ra^$pa)-(0-(($na^~1)&$na))|0;
												$pa=$this->carr($RR,$n,$oa>>2,"")|0;
												$ra=$this->carr($RR,$n,$qa>>2,"")|0;
												$ta=$this->carr($RR,$n,$ua>>2,"")|0;
												$Ea=($this->carr($RR,$n,$Fa>>2,"")|0)+ -796114441+1+796114441|0;
												$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;
												$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
												$La=$this->carr($RR,$n,$Ma>>2,"")|0;
												$Na=$this->carr($RR,$n,$Oa>>2,"")|0;
												$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;
												$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;
												$Ya=$this->carr($RR,$n,$Za>>2,"")|0;
												$jb=-188097831;
												$kb=$this->carr($RR,$n,$lb>>2,"")|0;
												$mb=$this->carr($RR,$n,$nb>>2,"")|0;
												continue;
												}
											else
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=$this->aarr($RR,$n,$ka>>0,"")&1?-1360885125:2059037329;
												continue;
												}							
											}						
									
								
							if(($jb)<-80539691)
									if(($jb)<-86792897)
											if(($jb)<-107249853)
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=($this->carr($RR,$n,$o>>2,"")|0)<46?1657487624:1541240532;
												continue;
												}
											else
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=($this->carr($RR,$n,$o>>2,"")|0)<3?608838580:304010989;
												continue;
												}							
										
									else if(($jb)<-86385898)
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=($this->carr($RR,$n,$o>>2,"")|0)<48?1102465302:-303896161;
												continue;
												}
											else
												{
												$wb=$this->llf(128,$this->carr($RR,$n,$Va>>2,""));
												$xb=$this->carr($RR,$n,$Za>>2,"")>>2;
												$this->carr($RR,$n,$F>>2,$ob+$this->llf($xb,2));
												$xb=$this->carr($RR,$n,$this->carr($RR,$n,$F>>2,"")>>2,"")|0;
												$vb=~$xb;
												$ub=~$wb;
												$tb=~924717824;
												$this->carr($RR,$n,$_a>>2,($vb&924717824|$xb&$tb)^($ub&924717824|$wb&$tb)|~($vb|$ub)&(924717824|$tb));
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=1264018475;continue;
												}					
									
							else		
									if(($jb)<-44538672)
											if(($jb)<-58343100)
												{
												$this->carr($RR,$n,$z>>2,($this->carr($RR,$n,$lb>>2,"")|0)+494575374+49-494575374);
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;$jb=484876086;continue;
												}
											else
												{
												$this->aarr($RR,$n,($this->carr($RR,$n,$J>>2,"")|0)+($this->carr($RR,$n,$za>>2,"")|0)>>0,$this->aarr($RR,$n,$g>>0,"")|0);
												$n=75;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"")|0;
												$na=$this->carr($RR,$n,$oa>>2,"")|0;$pa=$this->carr($RR,$n,$qa>>2,"")|0;
												$ra=$this->carr($RR,$n,$sa>>2,"")|0;$ta=$this->carr($RR,$n,$ua>>2,"")|0;
												$Ea=0-(0-($this->carr($RR,$n,$Fa>>2,"")|0)+(0-1))|0;
												$Ha=$this->carr($RR,$n,$Ia>>2,"")|0;$Ja=$this->carr($RR,$n,$Ka>>2,"")|0;
												$La=$this->carr($RR,$n,$Ma>>2,"")|0;$Na=$this->carr($RR,$n,$Oa>>2,"")|0;
												$Pa=$this->carr($RR,$n,$Qa>>2,"")|0;$Ra=$this->carr($RR,$n,$Sa>>2,"")|0;
												$Ya=$this->carr($RR,$n,$Za>>2,"")|0;$jb=-188097831;
												$kb=$this->carr($RR,$n,$lb>>2,"")|0;$mb=$this->carr($RR,$n,$nb>>2,"")|0;continue;
												}							
										
									else if(($jb)<-25886128)
												{
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=$this->aarr($RR,$n,$X>>0,"")&1?2070699595:-1785460248;continue;
												}
											else
												{
												$this->carr($RR,$n,$Ba>>2,($this->carr($RR,$n,$Ia>>2,"")|0)+ -1998283379+1+1998283379);
												$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
												$jb=-843646639;continue;
												}	
											}
									}					
$i=$qb;return $this->carr($RR,$n,$J>>2,"")|0;
}


function Ua($a,&$RR,&$O)
			{			
			$a=$a|0;
			$b=0;$d=0;$e=0;$f=0;$g=0;$h=0;$i=0;$j=0;$k=0;$l=0;$m=0;$n=0;
			$o=0;$p=0;$q=0;$r=0;$s=0;$t=0;$u=0;$v=0;$w=0;$x=0;$y=0;$z=0;
			$A=0;$B=0;$C=0;$D=0;$E=0;$F=0;$G=0;$H=0;$I=0;$J=0;$K=0;$L=0;
			
			$nn=0;
			
			do if($a>>0<245)
				{
				$o=($a<11?16:$a+11&-8);
				$a=$this->_rshift($o,3);
				$j=$this->carr($RR,$nn,72,"")|0;
				$b=$this->_rshift($j,$a);
				
				if($b&3|0)
					{
					$b=($b&1^1)+$a|0;
					$d=328+($b<<1<<2)|0;
					$e=$d+8|0;
					$f=$this->carr($RR,$nn,$e>>2,"")|0;
					$g=$f+8|0;
					$h=$this->carr($RR,$nn,$g>>2,"")|0;
					
					do 	if(($d|0)!=($h|0))
							{								
							$a=$h+12|0;
							
							if(($this->carr($RR,$nn,$a>>2,"")|0)==($f|0))
								{
								$this->carr($RR,$nn,$a>>2,$d);
								$this->carr($RR,$nn,$e>>2,$h);
								break;
								}
							}
						 else   $this->carr($RR,$nn,72,$j&~(1<<$b));
						 
					while(0);
				
					$L=$b<<3;
					$this->carr($RR,$nn,$f+4>>2,$L|3);
					$L=$f+$L+4|0;
					$this->carr($RR,$nn,$L>>2,$this->carr($RR,$nn,$L>>2,"")|1);
					$L=$g;
					return $L|0;
					} 
				
				$h=$this->carr($RR,$nn,74,"")|0;
				
				if($o>$h)
					{
					if($b|0)
						{
						$d=2<<$a;
						$d=$b<<$a&($d|0-$d);
						$d=($d&0-$d)+ -1|0;
						$i=$this->_rshift($d,12&16);
						$d=$this->_rshift($d,$i);
						$f=$this->_rshift($d,5&8);
						$d=$this->_rshift($d,$f);
						$g=$this->_rshift($d,2&4);
						$d=$this->_rshift($d,$g);
						$e=$this->_rshift($d,1&2);
						$d=$this->_rshift($d,$e);
						$b=$this->_rshift($d,1&1);
						$b=($f|$i|$g|$e|$b)+($this->_rshift($d,$b))|0;
						$d=328+($b<<1<<2)|0;
						$e=$d+8|0;
						$g=$this->carr($RR,$nn,$e>>2,"")|0;
						$i=$g+8|0;
						$f=$this->carr($RR,$nn,$i>>2,"")|0;
						
						do 		if(($d|0)!=($f|0))
									{										
									$a=$f+12|0;
									
									if(($this->carr($RR,$nn,$a>>2,"")|0)==($g|0))
										{
										$this->carr($RR,$nn,$a>>2,$d);
										$this->carr($RR,$nn,$e>>2,$f);
										$k=$this->carr($RR,$nn,74,"")|0;
										break;
										}
									}
								else
									{
									$this->carr($RR,$nn,72,$j&~(1<<$b));
									$k=$h;
									}
						while(0);
				
						$h=($b<<3)-$o|0;
						$this->carr($RR,$nn,$g+4>>2,$o|3);
						$e=$g+$o|0;
						$this->carr($RR,$nn,$e+4>>2,$h|1);
						$this->carr($RR,$nn,$e+$h>>2,$h);
						
						if($k|0)
								{
								$f=$this->carr($RR,$nn,77,"")|0;
								$b=$this->_rshift($k,3);
								$d=328+($b<<1<<2)|0;
								$a=$this->carr($RR,$nn,72,"")|0;
								$b=1<<$b;
								
								if($a&$b)
									{
									$a=$d+8|0;
									$b=$this->carr($RR,$nn,$a>>2,"")|0;
																		
									$l=$a;
									$m=$b;									
									}
								else
									{
									$this->carr($RR,$nn,72,$a|$b);
									$l=$d+8|0;
									$m=$d;
									}
									
								$this->carr($RR,$nn,$l>>2,$f);
								$this->carr($RR,$nn,$m+12>>2,$f);
								$this->carr($RR,$nn,$f+8>>2,$m);
								$this->carr($RR,$nn,$f+12>>2,$d);
								}
							
						$this->carr($RR,$nn,74,$h);
						$this->carr($RR,$nn,77,$e);
						$L=$i;
						return $L|0;
						}
						
					$a=$this->carr($RR,$nn,73,"")|0;
					
					if($a)
						{
						$d=($a&0-$a)+ -1|0;
						$K=$this->_rshift($d,12&16);
						$d=$this->_rshift($d,$K);
						$J=$this->_rshift($d,5&8);
						$d=$this->_rshift($d,$J);
						$L=$this->_rshift($d,2&4);
						$d=$this->_rshift($d,$L);
						$b=$this->_rshift($d,1&2);
						$d=$this->_rshift($d,$b);
						$e=$this->_rshift($d,1&1);
						$e=$this->carr($RR,$nn,592+(($J|$K|$L|$b|$e)+($this->_rshift($d,$e))<<2)>>2,"")|0;
						$d=($this->carr($RR,$nn,$e+4>>2,"")&-8)-$o|0;
						$b=$e;
						
						while(1)
								{
								$a=$this->carr($RR,$nn,$b+16>>2,"")|0;
								
								if(!$a)
									{
									$a=$this->carr($RR,$nn,$b+20>>2,"")|0;
									
									if(!$a)
										{
										$j=$e;
										break;
										}
									}
									
								$b=($this->carr($RR,$nn,$a+4>>2,"")&-8)-$o|0;
								$L=$b<$d;
								$d=$L?$b:$d;
								$b=$a;
								$e=$L?$a:$e;
								}
							
						$g=$this->carr($RR,$nn,76,"")|0;
							
						$i=$j+$o|0;
						
						$h=$this->carr($RR,$nn,$j+24>>2,"")|0;
						$e=$this->carr($RR,$nn,$j+12>>2,"")|0;
						
						do if(($e|0)==($j|0))
								{
								$b=$j+20|0;
								$a=$this->carr($RR,$nn,$b>>2,"")|0;
								
								if(!$a)
									{
									$b=$j+16|0;
									$a=$this->carr($RR,$nn,$b>>2,"")|0;
									
									if(!$a)
										{
										$n=0;
										break;
										}
									}
									
								while(1)
									{
									$e=$a+20|0;
									$f=$this->carr($RR,$nn,$e>>2,"")|0;
									
									if($f|0)
										{
										$a=$f;
										$b=$e;
										continue;
										}
										
									$e=$a+16|0;
									$f=$this->carr($RR,$nn,$e>>2,"")|0;
									
									if(!$f)
										break;
									else
										{
										$a=$f;
										$b=$e;
										}
									}
																	
								$this->carr($RR,$nn,$b>>2,0);
								$n=$a;
								break;
								}
							 else
								{
								$f=$this->carr($RR,$nn,$j+8>>2,"")|0;
								$a=$f+12|0;
								$b=$e+8|0;
								
								if(($this->carr($RR,$nn,$b>>2,"")|0)==($j|0))
									{
									$this->carr($RR,$nn,$a>>2,$e);
									$this->carr($RR,$nn,$b>>2,$f);
									$n=$e;
									break;
									}
								}
							 while(0);
				
							do if($h|0)
									{
									$a=$this->carr($RR,$nn,$j+28>>2,"")|0;
									$b=592+($a<<2)|0;
									
									if(($j|0)==($this->carr($RR,$nn,$b>>2,"")|0))
										{
										$this->carr($RR,$nn,$b>>2,$n);
										
										if(!$n)
											{
											$this->carr($RR,$nn,73,$this->carr($RR,$nn,73,"")&~(1<<$a));
											break;
											}
										}
									else
										{	
										$a=$h+16|0;
										
										if(($this->carr($RR,$nn,$a>>2,"")|0)==($j|0))
											$this->carr($RR,$nn,$a>>2,$n);
										else 	$this->carr($RR,$nn,$h+20>>2,$n);
										
										if(!$n)
											break;
										}
										
									$b=$this->carr($RR,$nn,76,"")|0;
									$this->carr($RR,$nn,$n+24>>2,$h);
									$a=$this->carr($RR,$nn,$j+16>>2,"")|0;
									
									do if($a|0)
									        {
										$this->carr($RR,$nn,$n+16>>2,$a);
										$this->carr($RR,$nn,$a+24>>2,$n);
										break;
										}
									while(0);
								
									$a=$this->carr($RR,$nn,$j+20>>2,"")|0;
									
									if($a|0)
										{
										$this->carr($RR,$nn,$n+20>>2,$a);
										$this->carr($RR,$nn,$a+24>>2,$n);
										break;
										}
									}
								while(0);
				
						
						if($d<16)
								{
								$L=$d+$o|0;
								$this->carr($RR,$nn,$j+4>>2,$L|3);
								$L=$j+$L+4|0;
								$this->carr($RR,$nn,$L>>2,$this->carr($RR,$nn,$L>>2,"")|1);
								}
						else
								{
								$this->carr($RR,$nn,$j+4>>2,$o|3);
								$this->carr($RR,$nn,$i+4>>2,$d|1);
								$this->carr($RR,$nn,$i+$d>>2,$d);
								$a=$this->carr($RR,$nn,74,"")|0;
								
								if($a|0)
									{
									$f=$this->carr($RR,$nn,77,"")|0;
									$b=$this->_rshift($a,3);
									$e=328+($b<<1<<2)|0;
									$a=$this->carr($RR,$nn,72,"")|0;
									$b=1<<$b;
									
									if($a&$b)
										{
										$a=$e+8|0;
										$b=$this->carr($RR,$nn,$a>>2,"")|0;
										$p=$a;
										$q=$b;
										}
									else
										{
										$this->carr($RR,$nn,72,$a|$b);
										$p=$e+8|0;
										$q=$e;
										}
										
									$this->carr($RR,$nn,$p>>2,$f);
									$this->carr($RR,$nn,$q+12>>2,$f);
									$this->carr($RR,$nn,$f+8>>2,$q);
									$this->carr($RR,$nn,$f+12>>2,$e);
									}
									
								$this->carr($RR,$nn,74,$d);
								$this->carr($RR,$nn,77,$i);
								}
							
						$L=$j+8|0;
						return $L|0;
						}
					}
				}
			else if($a<=4294967231)
				{
				$a=$a+11|0;
				$o=$a&-8;
				$j=$this->carr($RR,$nn,73,"")|0;
				
				if($j)
					{
					$d=0-$o|0;
					$a=$this->_rshift($a,8);
					
					if($a)	
							if($o>16777215)
								$i=31;
							else
								{
								$q=$this->_rshift(($a+1048320|0),16&8);
								$E=$a<<$q;
								$p=$this->_rshift(($E+520192|0),16&4);
								$E=$E<<$p;
								$i=$this->_rshift(($E+245760|0),16&2);
								$i=14-($p|$q|$i)+($E<<$this->_rshift($i,15))|0;
								
								$i=$this->_rshift($o,($i+7|0)&1)|$i<<1;
								}
							
					else    	$i=0;
					
					$b=$this->carr($RR,$nn,592+($i<<2)>>2,"")|0;
					
					do if(!$b)
							{
							$a=0;
							$b=0;
							$E=86;
						        }
					else
							{
							$f=$d;
							$a=0;
							$g=$o<<(($i|0)==31?0:25-$this->_rshift($i,1)|0);
							$h=$b;
							$b=0;
							while(1)
								{
								$e=$this->carr($RR,$nn,$h+4>>2,"")&-8;
								$d=$e-$o|0;
								
								if($d<$f)
									
									if(($e|0)==($o|0))
										{
										$a=$h;
										$b=$h;
										$E=90;
										break 2;
										}
									else    $b=$h;
									
								else    $d=$f;
								
								$e=$this->carr($RR,$nn,$h+20>>2,"")|0;
								$h=$this->carr($RR,$nn,$h+16+($this->_rshift($g,31)<<2)>>2,"")|0;
								$a=($e|0)==0|($e|0)==($h|0)?$a:$e;
								$e=($h|0)==0;
								
								if($e)
									{
									$E=86;
									break;
									}
								else
									{
									$f=$d;
									$g=$g<<($e&1^1);
									}
									
								}
							}
					while(0);
			
					if(($E|0)==86)
						{
						if(($a|0)==0&($b|0)==0)
							{
							$a=2<<$i;
							$a=$j&($a|0-$a);
							
							if(!$a)
								break;
								
							$q=($a&0-$a)+ -1|0;
							$m=$this->_rshift($q,12&16);
							$q=$this->_rshift($q,$m);
							$l=$this->_rshift($q,5&8);
							$q=$this->_rshift($q,$l);
							$n=$this->_rshift($q,2&4);
							$q=$this->_rshift($q,$n);
							$p=$this->_rshift($q,1&2);
							$q=$this->_rshift($q,$p);
							$a=$this->_rshift($q,1&1);
							$a=$this->carr($RR,$nn,592+(($l|$m|$n|$p|$a)+($this->_rshift($q,$a))<<2)>>2,"")|0;
							}
							
						if(!$a)
							{
							$i=$d;
							$j=$b;
							}
						else    $E=90;
						}
						
					if(($E|0)==90)
						while(1)
							{
							$E=0;
							$q=($this->carr($RR,$nn,$a+4>>2,"")&-8)-$o|0;
							$e=$q<$d;
							$d=$e?$q:$d;
							$b=$e?$a:$b;
							$e=$this->carr($RR,$nn,$a+16>>2,"")|0;
							
							if($e|0)
								{
								$a=$e;
								$E=90;
								continue;
								}
								
							$a=$this->carr($RR,$nn,$a+20>>2,"")|0;
							
							if(!$a)
								{
								$i=$d;
								$j=$b;
								break;
								}
							else    $E=90;
							}
						
					if(($j|0)!=0 and $i<($this->carr($RR,$nn,74,"")-$o))
						{
						$f=$this->carr($RR,$nn,76,"")|0;
						
						$h=$j+$o|0;
						$g=$this->carr($RR,$nn,$j+24>>2,"")|0;
						$d=$this->carr($RR,$nn,$j+12>>2,"")|0;
						
						do if(($d|0)==($j|0))
								{
								$b=$j+20|0;
								$a=$this->carr($RR,$nn,$b>>2,"")|0;
								
								if(!$a)
									{
									$b=$j+16|0;
									$a=$this->carr($RR,$nn,$b>>2,"")|0;
									
									if(!$a)
										{
										$s=0;
										break;
										}
									}
								while(1)
									{
									$d=$a+20|0;
									$e=$this->carr($RR,$nn,$d>>2,"")|0;
									
									if($e|0)
										{
										$a=$e;
										$b=$d;
										continue;
										}
										
									$d=$a+16|0;
									$e=$this->carr($RR,$nn,$d>>2,"")|0;
									
									if(!$e) 
										break;
									else
										{
										$a=$e;
										$b=$d;
										}
									}
								
									$this->carr($RR,$nn,$b>>2,0);
									$s=$a;
									break;
								
								}
							else
								{
								$e=$this->carr($RR,$nn,$j+8>>2,"")|0;
									
								$a=$e+12|0;
								$b=$d+8|0;
								
								if(($this->carr($RR,$nn,$b>>2,"")|0)==($j|0))
									{
									$this->carr($RR,$nn,$a>>2,$d);
									$this->carr($RR,$nn,$b>>2,$e);
									$s=$d;
									break;
									}
							
								}
						while(0);
					
						do if($g|0)
							{
							$a=$this->carr($RR,$nn,$j+28>>2,"")|0;
							$b=592+($a<<2)|0;
							
							if(($j|0)==($this->carr($RR,$nn,$b>>2,"")|0))
								{
								$this->carr($RR,$nn,$b>>2,$s);
								
								if(!$s)
									{
									$this->carr($RR,$nn,73,$this->carr($RR,$nn,73,"")&~(1<<$a));
									break;
									}
								}
							else
								{	
								$a=$g+16|0;
								
								if(($this->carr($RR,$nn,$a>>2,"")|0)==($j|0))
									$this->carr($RR,$nn,$a>>2,$s);
								else 	$this->carr($RR,$nn,$g+20>>2,$s);
								
								if(!$s)
									break;
								}
								
							$b=$this->carr($RR,$nn,76,"")|0;
							$this->carr($RR,$nn,$s+24>>2,$g);
							$a=$this->carr($RR,$nn,$j+16>>2,"")|0;
							
							do if($a|0)
								{
								$this->carr($RR,$nn,$s+16>>2,$a);
								$this->carr($RR,$nn,$a+24>>2,$s);
								break;
								}
							while(0);
						
							$a=$this->carr($RR,$nn,$j+20>>2,"")|0;
							
							if($a|0)
								
								{
								$this->carr($RR,$nn,$s+20>>2,$a);
								$this->carr($RR,$nn,$a+24>>2,$s);
								break;
								}
							}
						while(0);
				
						do if($i>=16)
							{
							$this->carr($RR,$nn,$j+4>>2,$o|3);
							$this->carr($RR,$nn,$h+4>>2,$i|1);
							$this->carr($RR,$nn,$h+$i>>2,$i);
							$a=$this->_rshift($i,3);
							
							if($i<256)
								{
								$d=328+($a<<1<<2)|0;
								$b=$this->carr($RR,$nn,72,"")|0;
								$a=1<<$a;
								
								if($b&$a)
									{
									$a=$d+8|0;
									$b=$this->carr($RR,$nn,$a>>2,"")|0;
									
									$u=$a;
									$v=$b;
									}
								else
									{
									$this->carr($RR,$nn,72,$b|$a);
									$u=$d+8|0;
									$v=$d;
									}
									
								$this->carr($RR,$nn,$u>>2,$h);
								$this->carr($RR,$nn,$v+12>>2,$h);
								$this->carr($RR,$nn,$h+8>>2,$v);
								$this->carr($RR,$nn,$h+12>>2,$d);
								break;
								}
								
							$a=$this->_rshift($i,8);
							
							if($a)
									
								if($i>16777215)
									$d=31;
								else
									{
									$K=$this->_rshift(($a+1048320|0),16&8);
									$L=$a<<$K;
									$J=$this->_rshift(($L+520192|0),16&4);
									$L=$L<<$J;
									$d=$this->_rshift(($L+245760|0),16&2);
									$d=14-($J|$K|$d)+($L<<$this->_rshift($d,15))|0; 
									$d=$this->_rshift($i,($d+7|0)&1)|$d<<1;
									}
									
							else    $d=0;
							
							$e=592+($d<<2)|0;
							$this->carr($RR,$nn,$h+28>>2,$d);
							$a=$h+16|0;
							$this->carr($RR,$nn,$a+4>>2,0);
							$this->carr($RR,$nn,$a>>2,0);
							$a=$this->carr($RR,$nn,73,"")|0;
							$b=1<<$d;
							
							if(!($a&$b))
								{
								$this->carr($RR,$nn,73,$a|$b);
								$this->carr($RR,$nn,$e>>2,$h);
								$this->carr($RR,$nn,$h+24>>2,$e);
								$this->carr($RR,$nn,$h+12>>2,$h);
								$this->carr($RR,$nn,$h+8>>2,$h);
								break;
								}
								
							$f=$i<<(($d|0)==31?0:25-($this->_rshift($d,1))|0);
							$a=$this->carr($RR,$nn,$e>>2,"")|0;
							
							while(1)
								{
								if(($this->carr($RR,$nn,$a+4>>2,"")&-8|0)==($i|0))
										{
										$d=$a;
										$E=148;
										break;
										}
									
								$b=$a+16+($this->_rshift($f,31)<<2)|0;
								$d=$this->carr($RR,$nn,$b>>2,"")|0;
								
								if(!$d)
										{
										$E=145;
										break;
										}
								else
										{
										$f=$f<<1;
										$a=$d;
										}
								}
								
							if(($E|0)==145)
									{
									$this->carr($RR,$nn,$b>>2,$h);
									$this->carr($RR,$nn,$h+24>>2,$a);
									$this->carr($RR,$nn,$h+12>>2,$h);
									$this->carr($RR,$nn,$h+8>>2,$h);
									break;
									}
							else 	
									if(($E|0)==148)
										{
										$a=$d+8|0;
										$b=$this->carr($RR,$nn,$a>>2,"")|0;
										$L=$this->carr($RR,$nn,76,"")|0;
										
										$this->carr($RR,$nn,$b+12>>2,$h);
										$this->carr($RR,$nn,$a>>2,$h);
										$this->carr($RR,$nn,$h+8>>2,$b);
										$this->carr($RR,$nn,$h+12>>2,$d);
										$this->carr($RR,$nn,$h+24>>2,0);
										break;
										}
							}
						else
							{
							$L=$i+$o|0;
							$this->carr($RR,$nn,$j+4>>2,$L|3);
							$L=$j+$L+4|0;
							$this->carr($RR,$nn,$L>>2,$this->carr($RR,$nn,$L>>2,"")|1);
							}
						while(0);
						
						$L=$j+8|0;
						return $L|0;
						}
					}
				}
			else    $o=-1;
			
			while (0);
	
			$d=$this->carr($RR,$nn,74,"")|0;
				
			if($d>=$o)
				{
				$a=$d-$o|0;
				$b=$this->carr($RR,$nn,77,"")|0;
				
				if($a>15)
					{
					$L=$b+$o|0;
					$this->carr($RR,$nn,77,$L);
					$this->carr($RR,$nn,74,$a);
					$this->carr($RR,$nn,$L+4>>2,$a|1);
					$this->carr($RR,$nn,$L+$a>>2,$a);
					$this->carr($RR,$nn,$b+4>>2,$o|3);
					}
				else
					{
					$this->carr($RR,$nn,74,0);
					$this->carr($RR,$nn,77,0);
					$this->carr($RR,$nn,$b+4>>2,$d|3);
					$L=$b+$d+4|0;
					$this->carr($RR,$nn,$L>>2,$this->carr($RR,$nn,$L>>2,"")|1);
					}
					
				$L=$b+8|0;
				return $L|0;
				}
				
			$a=$this->carr($RR,$nn,75,"")|0;
				
			if($a>$o)
				{
				
				$J=$a-$o|0;
				$this->carr($RR,$nn,75,$J);
				$L=$this->carr($RR,$nn,78,"")|0;
				$K=$L+$o|0;
				$this->carr($RR,$nn,78,$K);
			
				$this->carr($RR,$nn,$K+4>>2,$J|1); 
				$this->carr($RR,$nn,$L+4>>2,$o|3);
			
				$L=$L+8|0;

				return $L|0;
				}
				
			do if(!($this->carr($RR,$nn,190,"")|0))
				{
				$a=4096|0;
				$this->carr($RR,$nn,192,$a);
				$this->carr($RR,$nn,191,$a);
				$this->carr($RR,$nn,193,-1);
				$this->carr($RR,$nn,194,-1);
				$this->carr($RR,$nn,195,0);
				$this->carr($RR,$nn,183,0);
				$this->carr($RR,$nn,190,($this->ma(0,$RR)|0)&-16^1431655768);
				break;
				}
			 while(0);
			 

			$h=$o+48|0;
			$g=$this->carr($RR,$nn,192,"")|0;
			$i=$o+47|0;
			$f=$g+$i|0;
			$g=0-$g|0;
			$j=$f&$g;
			
			if($j<=$o)
				{
				return 0;
				}
				
			$a=$this->carr($RR,$nn,182,"")|0;
			
			if($a|0)
				{
				$u=$this->carr($RR,$nn,180,"")|0;
				$v=$u+$j|0;
				
				if ($v<=$u|$v>$a)
					{
					return 0;
					}
				}
			do 	
				if(!($this->carr($RR,$nn,183,"")&4))
					{
					$a=$this->carr($RR,$nn,78,"")|0;
					
					do 
						if($a)
							{
							$d=736;
							while(1)
								{
								$b=$this->carr($RR,$nn,$d>>2,"")|0;
								
								if($b<=$a)
									{
									$r=$d+4|0;
									if ($this->_rshift(($b+($this->carr($RR,$nn,$r>>2,"")|0)|0),0)>$a)
										{
										$e=$d;
										$d=$r;
										break;
										}
									}
									
								$d=$this->carr($RR,$nn,$d+8>>2,"")|0;
								
								if(!$d)
									{
									$E=173;
									break 2;
									}
								}
							$a=$f-($this->carr($RR,$nn,75,"")|0)&$g;
							
							if($a<2147483647)
								{
								$b=$this->la($a|0,$O)|0;
								
								if(($b|0)==(($this->carr($RR,$nn,$e>>2,"")|0)+($this->carr($RR,$nn,$d>>2,"")|0)|0))
									{
									if(($b|0)!=(-1|0))
										{
										$h=$b;
										$f=$a;
										$E=193;
										break 2; 
										}
									}
								else    $E=183;
								}
							}
						else    $E=173;
						while(0);
					
		
					do 
						 if(($E|0)==173)
						 	{
						 	$t=$this->la(0,$O)|0;
							 
							if (($t|0)!=(-1|0))
								{
								$a=$t;
								$b=$this->carr($RR,$nn,191,"")|0;
								$d=$b+ -1|0;
								
								if(!($d&$a))
									$a=$j;
								else 	$a=$j-$a+($d+$a&0-$b)|0;
								
								$b=$this->carr($RR,$nn,180,"")|0;
								$d=$b+$a|0;
								
								if($a>$o&$a<2147483647)
									{
									$v=$this->carr($RR,$nn,182,"")|0;
									
									if($v|0 and ($d<=$b|$d>$v))
										break;
										
									$b=$this->la($a|0,$O)|0;
									
									if(($b|0)==($t|0))
										{
										$h=$t;
										$f=$a;
										$E=193;
										break 2;
										}
									else    $E=183;
									}
								}
							}
						while(0);
			
					
					do  	
						 if(($E|0)==183)
							{
							$d=0-$a|0;
							
							do 	
								 if($h>$a&($a<2147483647&($b|0)!=(-1|0)))
									 {
									 $w=$this->carr($RR,$nn,192,"")|0;
									 $w=$i-$a+$w&0-$w;
									 
									 if ($w<2147483647)
										 {
										 if(($this->la($w|0,$O)|0)==(-1|0))
											{
											$this->la($d|0,$O)|0;
											break 2;
											}
										 }
									}
								 else
									{
									$a=$w+$a|0;
									break;
									}	
								        
								 while(0);
									
							if(($b|0)!=(-1|0))
								{
								$h=$b;
								$f=$a;
								$E=193;
								break 3;
								}
							}
						while(0);
						
		
					$this->carr($RR,$nn,183,$this->carr($RR,$nn,183,"")|4);
					$E=190;
					}
				else    $E=190;
				while(0);

			
			if (($E|0)==190 and $j<2147483647)
				{			
				$x=$this->la($j|0,$O)|0;
				$y=$this->la(0,$O)|0;
								
				if ($x<$y&(($x|0)!=(-1|0)&($y|0)!=(-1|0)))
					{			
					$z=$y-$x|0;
					
					if ($z>$this->_rshift(($o+40|0),0))				
						{
						$h=$x;
						$f=$z;
						$E=193;
						}
					}
				}
				
			if(($E|0)==193)
				{
				$a=($this->carr($RR,$nn,180,"")|0)+$f|0;
				$this->carr($RR,$nn,180,$a);
				
				if($a>$this->_rshift(($this->carr($RR,$nn,181,"")|0),0))
					$this->carr($RR,$nn,181,$a);
					
				$i=$this->carr($RR,$nn,78,"")|0;
				
				do  
				
				if($i)
					{
					$e=736;
					
					do 
						{
						$a=$this->carr($RR,$nn,$e>>2,"")|0;
						$b=$e+4|0;
						$d=$this->carr($RR,$nn,$b>>2,"")|0;
						
						if(($h|0)==($a+$d|0))
							{
							$A=$a;
							$B=$b;
							$C=$d;
							$D=$e;
							$E=203;
							break;
							}
							
						$e=$this->carr($RR,$nn,$e+8>>2,"")|0;
						}
					while(($e|0)!=0);
					
					if(($E|0)==203 and ($this->carr($RR,$nn,$D+12>>2,"")&8|0)==0 and $i<$h and $i>=$A)
						{
						$this->carr($RR,$nn,$B>>2,$C+$f);
						$L=$i+8|0;
						$L=($L&7|0)==0?0:0-$L&7;
						$K=$i+$L|0;
						$L=$f-$L+($this->carr($RR,$nn,75,"")|0)|0;
						$this->carr($RR,$nn,78,$K);
						$this->carr($RR,$nn,75,$L);
						$this->carr($RR,$nn,$K+4>>2,$L|1);
						$this->carr($RR,$nn,$K+$L+4>>2,40);
						$this->carr($RR,$nn,79,$this->carr($RR,$nn,194,""));
						break;
						}
						
					$a=$this->carr($RR,$nn,76,"")|0;
					
					if($h<$a)
						{
						$this->carr($RR,$nn,76,$h);
						$j=$h;
						}
					else    $j=$a;
					
					$d=$h+$f|0;
					$a=736;
					
					while(1)
						{
						if(($this->carr($RR,$nn,$a>>2,"")|0)==($d|0))
							{
							$b=$a;
							$E=211;
							break;
							}
							
						$a=$this->carr($RR,$nn,$a+8>>2,"")|0;
						
						if(!$a)
							{
							$b=736;
							break;
							}
						}
						
					if(($E|0)==211)
						{
						if(!($this->carr($RR,$nn,$a+12>>2,"")&8))
							{
							$this->carr($RR,$nn,$b>>2,$h);
							$l=$a+4|0;
							$this->carr($RR,$nn,$l>>2,($this->carr($RR,$nn,$l>>2,"")|0)+$f);
							$l=$h+8|0;
							$l=$h+(($l&7|0)==0?0:0-$l&7)|0;
							$a=$d+8|0;
							$a=$d+(($a&7|0)==0?0:0-$a&7)|0;
							$k=$l+$o|0;
							$g=$a-$l-$o|0;
							$this->carr($RR,$nn,$l+4>>2,$o|3);
							
							do 
							 
							 if(($a|0)!=($i|0))
								{
								if(($a|0)==($this->carr($RR,$nn,77,"")|0))
									{
									$L=($this->carr($RR,$nn,74,"")|0)+$g|0;
									$this->carr($RR,$nn,74,$L);
									$this->carr($RR,$nn,77,$k);
									$this->carr($RR,$nn,$k+4>>2,$L|1);
									$this->carr($RR,$nn,$k+$L>>2,$L);
									break;
									}
									
								$b=$this->carr($RR,$nn,$a+4>>2,"")|0;
								
								if(($b&3|0)==1)
									{
									$i=$b&-8;
									$f=$this->_rshift($b,3);
									
									do  
									
									 if($b>=256)
										{
										$h=$this->carr($RR,$nn,$a+24>>2,"")|0;
										$e=$this->carr($RR,$nn,$a+12>>2,"")|0;
										do 
											
											 if(($e|0)==($a|0))
												{
												$d=$a+16|0;
												$e=$d+4|0;
												$b=$this->carr($RR,$nn,$e>>2,"")|0;
												
												if(!$b)
													{
													$b=$this->carr($RR,$nn,$d>>2,"")|0;
													if(!$b)
														{
														$J=0;
														break;
														}
													}
												else    $d=$e;
												
												while(1)
													{
													$e=$b+20|0;
													$f=$this->carr($RR,$nn,$e>>2,"")|0;
													
													if($f|0)
														{
														$b=$f;
														$d=$e;
														continue;
														}
														
													$e=$b+16|0;
													$f=$this->carr($RR,$nn,$e>>2,"")|0;
													
													if(!$f)
														break;
													else
														{
														$b=$f;
														$d=$e;
														}
													}
													
												$this->carr($RR,$nn,$d>>2,0);
												$J=$b;
												break;
												}
											else
												{
												$f=$this->carr($RR,$nn,$a+8>>2,"")|0;
												$b=$f+12|0;
												$d=$e+8|0;
												
												$this->carr($RR,$nn,$b>>2,$e);
												$this->carr($RR,$nn,$d>>2,$f);
												$J=$e;
												break;
												}
										while(0);
									
										if(!$h)
											break;
										
										$b=$this->carr($RR,$nn,$a+28>>2,"")|0;
										$d=592+($b<<2)|0;
										
										do 
											
											if(($a|0)!=($this->carr($RR,$nn,$d>>2,"")|0))
												{	
												$b=$h+16|0;
												
												if(($this->carr($RR,$nn,$b>>2,"")|0)==($a|0))
													$this->carr($RR,$nn,$b>>2,$J);
												else 	$this->carr($RR,$nn,$h+20>>2,$J);
												
												if(!$J)
													break 3;
												}
											else
												{
												$this->carr($RR,$nn,$d>>2,$J);
												
												if($J|0)
													break;
													
												$this->carr($RR,$nn,73,$this->carr($RR,$nn,73,"")&~(1<<$b));
												break 3;
												}
										while(0) ;
									
										$e=$this->carr($RR,$nn,76,"")|0;
										$this->carr($RR,$nn,$J+24>>2,$h);
										$b=$a+16|0;
										$d=$this->carr($RR,$nn,$b>>2,"")|0;
										
										do 	
											if($d|0)
												{
												$this->carr($RR,$nn,$J+16>>2,$d);
												$this->carr($RR,$nn,$d+24>>2,$J);
												break;
												}
										while(0);
									
										$b=$this->carr($RR,$nn,$b+4>>2,"")|0;
										
										if(!$b)
											break;
											
										$this->carr($RR,$nn,$J+20>>2,$b);
										$this->carr($RR,$nn,$b+24>>2,$J);
										break;
										}
									else
										{
										$d=$this->carr($RR,$nn,$a+8>>2,"")|0;
										$e=$this->carr($RR,$nn,$a+12>>2,"")|0;
										$b=328+($f<<1<<2)|0;
										
										do 	
											 if(($d|0)!=($b|0))
												{	
												if(($this->carr($RR,$nn,$d+12>>2,"")|0)==($a|0))
													break;
												}
										while(0);
									
										if(($e|0)==($d|0))
											{
											$this->carr($RR,$nn,72,$this->carr($RR,$nn,72,"")&~(1<<$f));
											break;
											}
											
										do 
											
											if(($e|0)==($b|0))
												$G=$e+8|0;
											else
												{	
												$b=$e+8|0;
												
												if(($this->carr($RR,$nn,$b>>2,"")|0)==($a|0))
													{
													$G=$b;
													break;
													}
												}
										while(0) ;
								
										$this->carr($RR,$nn,$d+12>>2,$e);
										$this->carr($RR,$nn,$G>>2,$d);
										}
									while(0);
							
									$a=$a+$i|0;
									$g=$i+$g|0;
									}
									
								$a=$a+4|0;
								$this->carr($RR,$nn,$a>>2,$this->carr($RR,$nn,$a>>2,"")&-2);
								$this->carr($RR,$nn,$k+4>>2,$g|1);
								$this->carr($RR,$nn,$k+$g>>2,$g);
								$a=$this->_rshift($g,3);
								
								if($this->_rshift($g,0)<256)
									{
									$d=328+($a<<1<<2)|0;
									$b=$this->carr($RR,$nn,72,"")|0;
									$a=1<<$a;
									
									do 	
										 if(!($b&$a))
											{
											$this->carr($RR,$nn,72,$b|$a);
											$K=$d+8|0;
											$L=$d;
											}
										 else
											{
											$a=$d+8|0;
											$b=$this->carr($RR,$nn,$a>>2,"")|0;
											if($b>=$this->_rshift(($this->carr($RR,$nn,76,"")|0),0))
												{
												$K=$a;
												$L=$b;
												break;
												}
									
											}
										 while(0);
							
									$this->carr($RR,$nn,$K>>2,$k);
									$this->carr($RR,$nn,$L+12>>2,$k);
									$this->carr($RR,$nn,$k+8>>2,$L);
									$this->carr($RR,$nn,$k+12>>2,$d);
									break;
									}
									
								$a=$this->_rshift($g,8);
								
								do	
									 if(!$a)
									 	$d=0;
									 else
										{
										if($g>16777215)
											{
											$d=31;
											break;
											}
											
										$K=$this->_rshift(($a+1048320|0),16)&8;
										$L=$a<<$K;
										$J=$this->_rshift(($L+520192|0),16)&4;
										$L=$L<<$J;
										$d=$this->_rshift(($L+245760|0),16)&2;
										$d=14-($J|$K|$d)+($L<<$this->_rshift($d,15))|0;
										$d=$this->_rshift($g,($d+7|0))&1|$d<<1;
										}
									while(0);
									
						
								$e=592+($d<<2)|0;
								$this->carr($RR,$nn,$k+28>>2,$d);
								$a=$k+16|0;
								$this->carr($RR,$nn,$a+4>>2,0);
								$this->carr($RR,$nn,$a>>2,0);
								$a=$this->carr($RR,$nn,73,"")|0;
								$b=1<<$d;
								
								if(!($a&$b))
									{
									$this->carr($RR,$nn,73,$a|$b);
									$this->carr($RR,$nn,$e>>2,$k);
									$this->carr($RR,$nn,$k+24>>2,$e);
									$this->carr($RR,$nn,$k+12>>2,$k);
									$this->carr($RR,$nn,$k+8>>2,$k);
									break;
									}
									
								$f=$g<<(($d|0)==31?0:25-($this->_rshift($d,1))|0);
								$a=$this->carr($RR,$nn,$e>>2,"")|0;
								
								while(1)
									{
									if(($this->carr($RR,$nn,$a+4>>2,"")&-8|0)==($g|0))
										{
										$d=$a;
										$E=281;
										break;
										}
										
									$b=$a+16+($this->_rshift($f,31)<<2)|0;
									$d=$this->carr($RR,$nn,$b>>2,"")|0;
									
									if(!$d)
										{
										$E=278;
										break;
										}
									else
										{
										$f=$f<<1;
										$a=$d;
										}
									}
									
								if(($E|0)==278)
									{
									$this->carr($RR,$nn,$b>>2,$k);
									$this->carr($RR,$nn,$k+24>>2,$a);
									$this->carr($RR,$nn,$k+12>>2,$k);
									$this->carr($RR,$nn,$k+8>>2,$k);
									break;
									}
								else 
									{
									if(($E|0)==281)
										{
										$a=$d+8|0;
										$b=$this->carr($RR,$nn,$a>>2,"")|0;
										$L=$this->carr($RR,$nn,76,"")|0;
										
										if($b>=$L&$d>=$L)
											{
											$this->carr($RR,$nn,$b+12>>2,$k);
											$this->carr($RR,$nn,$a>>2,$k);
											$this->carr($RR,$nn,$k+8>>2,$b);
											$this->carr($RR,$nn,$k+12>>2,$d);
											$this->carr($RR,$nn,$k+24>>2,0);
											break;
											}
										}
									}
								}
							else
								{
								$L=($this->carr($RR,$nn,75,"")|0)+$g|0;
								$this->carr($RR,$nn,75,$L);
								$this->carr($RR,$nn,78,$k);
								$this->carr($RR,$nn,$k+4>>2,$L|1);
								}
								while(0);
						
							$L=$l+8|0;
							return $L|0;
						}
					else $b=736;
					}
					
					while(1)
						{
						$a=$this->carr($RR,$nn,$b>>2,"")|0;
						if($a<=$i and $this->_rshift(($F=$a+($this->carr($RR,$nn,$b+4>>2,"")|0)|0),0)>$i)
							{
							$b=$F;
							break;
							}
							
						$b=$this->carr($RR,$nn,$b+8>>2,"")|0;
						}
						
					$g=$b+ -47|0;
					$d=$g+8|0;
					$d=$g+(($d&7|0)==0?0:0-$d&7)|0;
					$g=$i+16|0;
					$d=$d<$g?$i:$d;
					$a=$d+8|0;
					$e=$h+8|0;
					$e=($e&7|0)==0?0:0-$e&7;
					$L=$h+$e|0;
					$e=$f+ -40-$e|0;
					$this->carr($RR,$nn,78,$L);
					$this->carr($RR,$nn,75,$e);
					$this->carr($RR,$nn,$L+4>>2,$e|1);
					$this->carr($RR,$nn,$L+$e+4>>2,40);
					$this->carr($RR,$nn,79,$this->carr($RR,$nn,194,""));
					$e=$d+4|0;
					$this->carr($RR,$nn,$e>>2,27);
					$this->carr($RR,$nn,$a>>2,$this->carr($RR,$nn,184,""));
					$this->carr($RR,$nn,$a+4>>2,$this->carr($RR,$nn,185,""));
					$this->carr($RR,$nn,$a+8>>2,$this->carr($RR,$nn,186,""));
					$this->carr($RR,$nn,$a+12>>2,$this->carr($RR,$nn,187,""));
					$this->carr($RR,$nn,184,$h);
					$this->carr($RR,$nn,185,$f);
					$this->carr($RR,$nn,187,0);
					$this->carr($RR,$nn,186,$a);
					$a=$d+24|0;
					
					do
						{
						$a=$a+4|0;
						$this->carr($RR,$nn,$a>>2,7);
						}
					while(($a+4)<$b);
					
					if(($d|0)!=($i|0))
						{
						$h=$d-$i|0;
						$this->carr($RR,$nn,$e>>2,$this->carr($RR,$nn,$e>>2,"")&-2);
						$this->carr($RR,$nn,$i+4>>2,$h|1);
						$this->carr($RR,$nn,$d>>2,$h);
						$a=$this->_rshift($h,3);
						
						if($h>>0<256)
							{
							$d=328+($a<<1<<2)|0;
							$b=$this->carr($RR,$nn,72,"")|0;
							$a=1<<$a;
							
							if($b&$a)
								{
								$a=$d+8|0;
								$b=$this->carr($RR,$nn,$a>>2,"")|0;
								$H=$a;
								$I=$b;	
								}
							else
								{
								$this->carr($RR,$nn,72,$b|$a);
								$H=$d+8|0;
								$I=$d;
								}
								
							$this->carr($RR,$nn,$H>>2,$i);
							$this->carr($RR,$nn,$I+12>>2,$i);
							$this->carr($RR,$nn,$i+8>>2,$I);
							$this->carr($RR,$nn,$i+12>>2,$d);
							break;
							}
							
						$a=$this->_rshift($h,8);
						
						if($a)
							{
							if($h>>0>16777215)
								$d=31;
							else
								{
								$K=$this->_rshift(($a+1048320|0),16)&8;
								$L=$a<<$K;
								$J=$this->_rshift(($L+520192|0),16)&4;
								$L=$L<<$J;
								$d=$this->_rshift(($L+245760|0),16)&2;
								$d=14-($J|$K|$d)+($L<<$this->_rshift($d,15))|0;
								$d=$this->_rshift($h,($d+7|0))&1|$d<<1;
								}
							}
						else    $d=0;
						
						$f=592+($d<<2)|0;
						$this->carr($RR,$nn,$i+28>>2,$d);
						$this->carr($RR,$nn,$i+20>>2,0);
						$this->carr($RR,$nn,$g>>2,0);
						$a=$this->carr($RR,$nn,73,"")|0;
						$b=1<<$d;
						
						if(!($a&$b))
							{
							$this->carr($RR,$nn,73,$a|$b);
							$this->carr($RR,$nn,$f>>2,$i);
							$this->carr($RR,$nn,$i+24>>2,$f);
							$this->carr($RR,$nn,$i+12>>2,$i);
							$this->carr($RR,$nn,$i+8>>2,$i);
							break;
							}
							
						$e=$h<<(($d|0)==31?0:25-($this->_rshift($d,1))|0);
						$a=$this->carr($RR,$nn,$f>>2,"")|0;
						
						while(1)
							{
							if(($this->carr($RR,$nn,$a+4>>2,"")&-8|0)==($h|0))
								{
								$d=$a;
								$E=307;
								break;
								}
								
							$b=$a+16+($this->_rshift($e,31)<<2)|0;
							$d=$this->carr($RR,$nn,$b>>2,"")|0;
							
							if(!$d)
								{
								$E=304;
								break;
								}
							else
								{
								$e=$e<<1;
								$a=$d;
								}
							}
							
						if(($E|0)==304)
							{
							$this->carr($RR,$nn,$b>>2,$i);
							$this->carr($RR,$nn,$i+24>>2,$a);
							$this->carr($RR,$nn,$i+12>>2,$i);
							$this->carr($RR,$nn,$i+8>>2,$i);
							break;
							}
						else 
							{
							if(($E|0)==307)
								{
								$a=$d+8|0;
								$b=$this->carr($RR,$nn,$a>>2,"")|0;
								$L=$this->carr($RR,$nn,76,"")|0;
								
								if($b>>0>=$L>>0&$d>>0>=$L>>0)
									{
									$this->carr($RR,$nn,$b+12>>2,$i);
									$this->carr($RR,$nn,$a>>2,$i);
									$this->carr($RR,$nn,$i+8>>2,$b);
									$this->carr($RR,$nn,$i+12>>2,$d);
									$this->carr($RR,$nn,$i+24>>2,0);
									break;
									}
							
								}
							}
						}
					}
				else
					{
					$L=$this->carr($RR,$nn,76,"")|0;
					
					if(($L|0)==0|$h>>0<$L>>0)
						$this->carr($RR,$nn,76,$h);
						
					$this->carr($RR,$nn,184,$h);
					$this->carr($RR,$nn,185,$f);
					$this->carr($RR,$nn,187,0);
					$this->carr($RR,$nn,81,$this->carr($RR,$nn,190,""));
					$this->carr($RR,$nn,80,-1);
					
					$a=0;
					
					do 
						{
						$L=328+($a<<1<<2)|0;
						$this->carr($RR,$nn,$L+12>>2,$L);
						$this->carr($RR,$nn,$L+8>>2,$L);
						$a=$a+1|0;
						}
					while(($a|0)!=32);
					
					$L=$h+8|0;
					$L=($L&7|0)==0?0:0-$L&7;
					$K=$h+$L|0;
					$L=$f+ -40-$L|0;
					$this->carr($RR,$nn,78,$K);
					$this->carr($RR,$nn,75,$L);
					$this->carr($RR,$nn,$K+4>>2,$L|1);
					$this->carr($RR,$nn,$K+$L+4>>2,40);
					$this->carr($RR,$nn,79,$this->carr($RR,$nn,194,""));
					}
					
				while(0);
			
				$a=$this->carr($RR,$nn,75,"")|0;
				
				if($a>>0>$o>>0)
					{
					$J=$a-$o|0;
					$this->carr($RR,$nn,75,$J);
					$L=$this->carr($RR,$nn,78,"")|0;
					$K=$L+$o|0;
					$this->carr($RR,$nn,78,$K);
					$this->carr($RR,$nn,$K+4>>2,$J|1);
					$this->carr($RR,$nn,$L+4>>2,$o|3);
					$L=$L+8|0;
					return $L|0;
					}
				}
				
			$this->carr($RR,$nn,(0|0)>>2,12);
			return 0;
			}
	
  	function Pb(&$R,$p)
  		{
		$t=$this->Varr($R,$p,"");$i=1;
  		while($t!=0)
		  {
		  ++$i;$t=$this->Varr($R,$p+$i,"");
		  }
	
		$curr=array_slice($R,$p,$i);
		
		$vf="";
		
		foreach ($curr as $c) $vf.=chr($c);

		return $vf;
  		}

	function Xa($R,$b,$d,$e)
		{
		$b=$b|0;
		$d=$d|0;
		$e=$e|0;
		$f=0;$g=0;$h=0;$i=0;
		$f=$b+$e|0;
		if(($e|0)>=20)
			{
			$d=$d&255;
			$h=$b&3;
			$i=$d|$d<<8|$d<<16|$d<<24;
			$g=$f&~3;
			if($h)
				{
				$h=$b+4-$h|0;
				while(($b|0)<($h|0))
					{
					$this->aarr($R,$b,$b>>0,$d);
					$b=$b+1|0;
					}
				}
			while(($b|0)<($g|0))
				{
				$this->carr($R,$b,$b>>2,$i);
				$b=$b+4|0;
				}
			}
		while(($b|0)<($f|0))
			{
			$this->aarr($R,$b,$b>>0,$d);
			$b=$b+1|0;
			}
		return $b-$e|0;
	       }
	
	function getvf($str)
		{
	        $M=1848;
	  	$N=0;
		$O=0;
	  	$P=2872;
	
	  	$R=array(8192);//arraybuffer
		  		
		for ($k=0;$k<8192;$k++) $R[$k]=0;
		
		$this->Uarr($R,0,255);
		$this->Uarr($R,75,3800);
		$this->Uarr($R,78,4900);	
		  
	  	$S=array(228); 
		for ($k=0;$k<228;$k++) $S[$k]=0;
		  
	  	$S1=array(7,12,17,22,5,9,14,20,4,11,16,23,6,10,15,21,5);
	
	  	for($i=8,$j=0;$i<73;$i+=4,$j++){$S[$i]=$S1[$j];}
	  	for($i=209,$j=48;$i<=218;$i++,$j++)$S[$i]=$j;
	  	for($i=219,$j=97;$i<=224;$i++,$j++)$S[$i]=$j;
		
		for ($k=0;$k<228;$k++) $R[$k+8]=$S[$k];  
	 	
	  	$N=$this->W($M);
	  	$O=$this->W($P);
		
		return $this->Pb($R,$this->Ia($this->X($R,$O,$this->Id($str)),$R,$O));
		}
}
