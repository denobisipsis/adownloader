<?
/*
from http://static.iqiyi.com/js/player_v1/pcweb.wonder.js where the cmd5x algorithm is stored as packed eval

this class computes the vf value in the call

http://cache.video.qiyi.com/vms?key=fvip&src=01010031010010000000&tvId=496130600&vid=12078ce069daab217b2632248272d722&vinfo=1&tm=506&qyid=&puid=&authKey=a6e3cd72befb37d067d2d684d74855b9&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdv=2&vf=7fff3565c6d525f625776630d571134f

where the relevant part is 

/vms?key=fvip&src=01010031010010000000&tvId=496130600&vid=12078ce069daab217b2632248272d722&vinfo=1&tm=506&qyid=&puid=&authKey=a6e3cd72befb37d067d2d684d74855b9&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdv=2


the same for ibt
*/
<?
class iqiyi
{	  		  
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
				$exp=$np*8;
				$m=hexdec($m);	
				if ($m>pow(2,$exp)-1) $m-=pow(2,$exp);
				return $m;
				} 
			
			return @array_shift(unpack($pack,strrev(pack("H*",$m))));
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
	
function Ia($b,&$RR,&$OO)
{			
	$i=1856;	
	
	$d=$e=$f=$g=$j=$k=$l=$m=$n=$o=$p=$q=$r=$s=$t=$u=$v=$w=$x=$y=$z=0;
	
	$A=$B=$C=$D=$E=$F=$G=$H=$I=$J=$K=$L=$M=$N=$O=$P=$R=$S=$T=$U=$V=$W=$X=$Y=$Z=0;
	
	$_=$dol=0;
	
	$aa=$ba=$ca=$da=$ea=$fa=$ga=$ha=$ia=$ja=$ka=$la=$ma=$na=$oa=$pa=$qa=$ra=$sa=$ta=$ua=$va=$wa=$xa=$ya=$za=0;
	
	$Aa=$Ba=$Ca=$Da=$Ea=$Fa=$Ga=$Ha=$Ia=$Ja=$Ka=$La=$Ma=$Na=$Oa=$Pa=$Qa=$Ra=$Sa=$Ta=$Va=$Wa=$Ya=$Za=0;
	
	$_a=$__a=0;
	
	$ab=$bb=$cb=$db=$eb=$fb=$gb=$hb=$ib=$jb=$kb=$lb=$mb=$nb=$ob=$pb=$qb=$rb=$sb=$tb=$ub=$vb=$wb=$xb=$yb=$zb=0;
	
	$Ab=$Bb=$Cb=$Db=$Eb=$Fb=$Gb=$Hb=$Ib=0;
	
	$qb=$i;         
	 		
	$Ga=$qb+512;
	
	$J=$qb+768;$d=$qb+776;$e=$qb+784;
	$r=$qb+792;$va=$qb+800;$za=$qb+808;$s=$qb+816;$H=$qb+824;$I=$qb+832;$U=$qb+840;$ib=$qb+848;	
	$Wa=$qb+856;$wa=$qb+864;$D=$qb+872;$E=$qb+880;$F=$qb+888;$xa=$qb+896;$G=$qb+904;$ya=$qb+912;$q=$qb+920;
	
	$pb=$qb+928;$hb=$qb+932;$C=$qb+936;
	$t=$qb+940;$Da=$qb+944;$Aa=$qb+948;$Ba=$qb+952;
	$Ta=$qb+956;$u=$qb+960;$fb=$qb+964;$v=$qb+968;
	$w=$qb+972;$cb=$qb+976;$gb=$qb+980;$l=$qb+984;
	$x=$qb+988;$y=$qb+992;$z=$qb+996;$A=$qb+1000;
	$ab=$qb+1004;$db=$qb+1008;$m=$qb+1012;$Ca=$qb+1016;
	$Va=$qb+1020;$_a=$qb+1024;$K=$qb+1028;$B=$qb+1032;
	$L=$qb+1036;$M=$qb+1040;$N=$qb+1044;$O=$qb+1048;
	$eb=$qb+1052;$bb=$qb+1056;$__a=$qb+1060;$P=$qb+1064;
	$R=$qb+1068;$S=$qb+1072;$T=$qb+1076;$o=$qb+1080;
	$Sa=$qb+1084;$Qa=$qb+1088;$Oa=$qb+1092;$Ma=$qb+1096;
	$lb=$qb+1100;$Za=$qb+1104;$nb=$qb+1108;$sa=$qb+1112;
	$qa=$qb+1116;$oa=$qb+1120;$ma=$qb+1124;$ua=$qb+1128;
	$Ka=$qb+1132;$Ia=$qb+1136;$Fa=$qb+1140;$V=$qb+1144;
	$ha=$qb+1148;$ka=$qb+1152;$Y=$qb+1156;$aa=$qb+1160;
	$fa=$qb+1164;$i=$i+1168;
		
	$f=$qb+1145;$da=$qb+1146;$g=$qb+1147;
	$ia=$qb+1149;$j=$qb+1150;$ja=$qb+1151;
	$k=$qb+1153;$W=$qb+1154;$X=$qb+1155;
	$Z=$qb+1157;$_=$qb+1158;$dol=$qb+1159;
	$ba=$qb+1161;$ca=$qb+1162;$ea=$qb+1163;
	
	$ga=$qb+1165;
	
	$ob=$qb;
	
	$this->carr($RR,$n,$J>>2,$this->Ua(33,$RR,$OO));
	
	$this->carr($RR,$n,$d>>2,$Ga);

	$n=$p=$la=$na=$pa=$ra=$ta=$Ea=$Ha=$Ja=$La=$Na=$Pa=$Ra=$Ya=$kb=$mb=0;
	
	$jb=936652527;

	
while(1)
{
switch ($jb)
{
case-1649803199:
		return $this->carr($RR,$n,$J>>2,"");

case 936652527:
case 1969546970:
		$this->Xa($RR,$this->carr($RR,$n,$d>>2,"")|0,0,256);
		$this->carr($RR,$n,$e>>2,$ob);
		$this->Xa($RR,$this->carr($RR,$n,$e>>2,""),0,512);
		$n=62;$p=$la=$na=$pa=$ra=$ta=$Ea=$Ha=$Ja=$La=$Na=$Pa=$Ra=$Ya=$kb=$mb=0;
		
		$jb=-188097831;continue;
case-188097831:
		$this->carr($RR,$n,$o>>2,$n);$this->carr($RR,$n,$Sa>>2,$Ra);
		$this->carr($RR,$n,$Qa>>2,$Pa);$this->carr($RR,$n,$Oa>>2,$Na);
		$this->carr($RR,$n,$Ma>>2,$La);$this->carr($RR,$n,$lb>>2,$kb);
		$this->carr($RR,$n,$Za>>2,$Ya);$this->carr($RR,$n,$nb>>2,$mb);
		$this->carr($RR,$n,$sa>>2,$ra);$this->carr($RR,$n,$qa>>2,$pa);
		$this->carr($RR,$n,$oa>>2,$na);$this->carr($RR,$n,$ma>>2,$la);
		$this->carr($RR,$n,$ua>>2,$ta);$this->harr($RR,$q>>3,$p);
		$this->carr($RR,$n,$Ka>>2,$Ja);$this->carr($RR,$n,$Ia>>2,$Ha);
		$this->carr($RR,$n,$Fa>>2,$Ea);	
			
		$jb=-255123066;continue;
		
case-1137547745:	/**/$jb=$n==0?-327886970:916103055;continue;		
case-524762773:		/**/$jb=$n<1?-1137547745:-107249853;continue;		
case 608838580:		/**/$jb=$n==1?-1290934332:916103055;continue;
case 304010989:		/**/$jb=$n==3?-1995522865:916103055;continue;
case-107249853:		/**/$jb=$n<3?608838580:304010989;continue;
case-2109032559:	/**/$jb=$n<5?-524762773:2088360821;continue;
case 1775530198:	/**/$jb=$n==5?439769685:916103055;continue;
case 2088360821:	/**/$jb=$n<7?1775530198:1217939919;continue;
case-1951072297:	/**/$jb=$n==7?1942162936:916103055;continue;
case-411922879:		/**/$jb=$n==9?545100308:916103055;continue;
case 1217939919:	/**/$jb=$n<9?-1951072297:-411922879;continue;
case-499972263:		/**/$jb=$n==11?809617043:916103055;continue;
case 2040419279:	/**/$jb=$n<11?-2109032559:-331915256;continue;
case-1396656085:	/**/$jb=$n==13?1153477833:916103055;continue;
case 1670387339:	/**/$jb=$n<13?-499972263:-22207083;continue;
case-22207083:		/**/$jb=$n<15?-1396656085:343102405;continue;
case 343102405:		/**/$jb=$n==15?1514554794:916103055;continue;
case 1183072760:	/**/$jb=$n==17?-1971280264:916103055;continue;
case-331915256:		/**/$jb=$n<17?1670387339:-909244188;continue;
case-1157656715:	/**/$jb=$n<19?1183072760:1826842851;continue;
case 1826842851:	/**/$jb=$n==19?-545058508:916103055;continue;
case-909244188:		/**/$jb=$n<21?-1157656715:-1266323623;continue;
case-1266323623:	/**/$jb=$n<22?153691705:151603818;continue;
case-1530939976:	/**/$jb=$n<23?2040419279:-2017858759;continue;
case-823999218:		/**/$jb=$n<24?-1892665105:635155771;continue;
case 635155771:		/**/$jb=$n<25?-1967845546:-80539691;continue;
case 775542450:		/**/$jb=$n<26?-823999218:1867803797;continue;
case-1367008151:	/**/$jb=$n==27?1203488890:916103055;continue;
case 1867803797:	/**/$jb=$n<27?1247969426:-1943746193;continue;
case-1966247896:	/**/$jb=$n==29?620960943:916103055;continue;
case-1943746193:	/**/$jb=$n<29?-1367008151:-1966247896;continue;
case-2017858759:	/**/$jb=$n<31?775542450:-1629615901;continue;
case 1370835909:	/**/$jb=$n==31?637834779:916103055;continue;
case-494102117:		/**/$jb=$n<33?1370835909:1115527364;continue;
case-204104119:		/**/$jb=$n==33?368050796:916103055;continue;
case 1115527364:	/**/$jb=$n<35?-204104119:-1579204746;continue;
case 13290759:		/**/$jb=$n==36?195832850:916103055;continue;
case-1629615901:	/**/$jb=$n<36?-494102117:-968403108;continue;		
case 1058751639:	/**/$jb=$n<38?13290759:-526301530;continue;
case-526301530:		/**/$jb=$n==38?-1341729830:916103055;continue;
case-968403108:		/**/$jb=$n<40?1058751639:-1936945228;continue;
case-1183676751:	/**/$jb=$n==41?-934444625:916103055;continue;
case-1936945228:	/**/$jb=$n<41?-1797419395:-1183676751;continue;
case 1093527402:	/**/$jb=$n==43?-1098566066:916103055;continue;
case-255123066:		/**/$jb=$n<43?-1530939976:1466680073;continue;
case-1031373064:	/**/$jb=$n<45?1093527402:-147891877;continue;
case-147891877:		/**/$jb=$n<46?1657487624:1541240532;continue;
case 852236017:		/**/$jb=$n<47?-1031373064:-86792897;continue;
case-86792897:		/**/$jb=$n<48?1102465302:-303896161;continue;
case 1315897097:	/**/$jb=$n==49?-25886128:916103055;continue;
case-303896161:		/**/$jb=$n<49?-568636039:1315897097;continue;
case-708759048:		/**/$jb=$n<51?852236017:1290413867;continue;
case 1982907982:	/**/$jb=$n==52?887924077:916103055;continue;
case-1202295682:	/**/$jb=$n<52?-1385908106:2055800044;continue;
case 2055800044:	/**/$jb=$n<54?1982907982:-2014779455;continue;
case 1290413867:	/**/$jb=$n<55?-1202295682:2120616980;continue;
case-1156946543:	/**/$jb=$n<56?-1173436005:549762434;continue;
case 2120616980:	/**/$jb=$n<57?-1156946543:1287975406;continue;
case 709849698:		/**/$jb=$n==58?-671207445:916103055;continue;
case 1287975406:	/**/$jb=$n<58?-1841591203:709849698;continue;
case 1117037785:	/**/$jb=$n==60?-602596021:916103055;continue;
case 1466680073:	/**/$jb=$n<60?-708759048:1256704313;continue;
case-1361726950:	/**/$jb=$n<62?1117037785:1010850097;continue;
case 1010850097:	/**/$jb=$n<63?-856036625:-1649803199;continue;
case 801681189:		/**/$jb=$n<64?-1361726950:1012403908;continue;
case 1012403908:	/**/$jb=$n<65?-902588506:1717331240;continue;
case-1712406553:	/**/$jb=$n==65?-1153545492:916103055;continue;
case 591681232:		/**/$jb=$n==67?-1355478599:916103055;continue;
case 1717331240:	/**/$jb=$n<67?-1712406553:591681232;continue;
case-771214760:		/**/$jb=$n==69?651068526:916103055;continue;
case 1256704313:	/**/$jb=$n<69?801681189:-1060336117;continue;
case 212826519:		/**/$jb=$n==71?1008856235:916103055;continue;
case-1266383858:	/**/$jb=$n<71?-771214760:1815387249;continue;
case 1815387249:	/**/$jb=$n<73?212826519:-252274077;continue;
case-252274077:		/**/$jb=$n==73?1347562810:916103055;continue;
case 263250548:		/**/$jb=$n==75?-1572948785:916103055;continue;
case-1060336117:	/**/$jb=$n<75?-1266383858:-743013407;continue;						
case 920364886:		/**/$jb=$n<77?263250548:-1212483299;continue;
case-1212483299:	/**/$jb=$n==77?-412272376:916103055;continue;
case-743013407:		/**/$jb=$n<79?920364886:-1414489443;continue;
case-1814214169:	/**/$jb=$n==79?-1129217909:916103055;continue;		
case-1414489443:	/**/$jb=$n<81?-1814214169:1771209720;continue;
case 1771209720:	/**/$jb=$n==81?-2074579782:916103055;continue;

case-44538672:		$jb=$this->aarr($RR,$n,$X,"")&1?2070699595:-1785460248;continue;
case-152754021:		$jb=$this->aarr($RR,$n,$ka,"")&1?-1360885125:2059037329;continue;
case 1804404662:	$jb=$this->aarr($RR,$n,$aa,"")&1?-2136717671:-828878942;continue;
case-1552799363:	$jb=$this->aarr($RR,$n,$Z,"")&1?139799944:690197071;continue;
case-1361473685:	$jb=$this->aarr($RR,$n,$ba,"")&1?-1924281938:128106704;continue;
case-1610186071:	$jb=$this->aarr($RR,$n,$fa,"")&1?-2141197378:-630729423;continue;
case-999614033:		$jb=$this->aarr($RR,$n,$Y,"")&1?331129789:1618283724;continue;
case-763186054:		$jb=$this->aarr($RR,$n,$ga,"")&1?-2051875059:2146552338;continue;
case-668795440:		$jb=$this->aarr($RR,$n,$ca,"")&1?-983205733:-1662327480;continue;
case 1667927966:	$jb=$this->aarr($RR,$n,$ia,"")&1?-777225753:1388594392;continue;
case 1410777152:	$jb=$this->aarr($RR,$n,$dol,"")&1?2045376102:-489741395;continue;
case 1951978675:	$jb=$this->aarr($RR,$n,$da,"")&1?-2014580748:481757527;continue;		
case 1980027799:	$jb=$this->aarr($RR,$n,$ha,"")&1?1297236730:-920516874;continue;		
case-424000715:		$jb=$this->aarr($RR,$n,$W,"")&1?270009349:1137039176;continue;
case-412361919:		$jb=$this->aarr($RR,$n,$_,"")&1?1775324253:1774369769;continue;		
case 60376344:		$jb=$this->aarr($RR,$n,$V,"")&1?1468918320:2014978051;continue;		
case 780107150:		$jb=$this->aarr($RR,$n,$ja,"")&1?-1781069297:-722374409;continue;		
case 618822415:		$jb=$this->aarr($RR,$n,$ea,"")&1?1432877594:2028659015;continue;

		
case 809617043:
		$this->aarr($RR,$n,$ea,$Ea<32&1);
		
		$jb=618822415;continue;		
case 887924077:
		$this->carr($RR,$n,$Aa>>2,$this->carr($RR,$n,$ua>>2,"")+1);
		
		$jb=-256536033;continue;		
case 1008856235:
		$this->aarr($RR,$n,$ha,$this->carr($RR,$n,$Fa>>2,"")<24&1);
		
		$jb=1980027799;continue;		
case 620960943:
		$this->aarr($RR,$n,$dol,$this->carr($RR,$n,$Fa>>2,"")<8&1);
		
		$jb=1410777152;continue;		
case 1102465302:
		$this->carr($RR,$n,$v>>2,$this->carr($RR,$n,$Ka>>2,"")+16);
		
		$jb=2131809869;continue;		
case 633810001:
		$this->carr($RR,$n,$G>>2,$Ga+$this->llf($this->carr($RR,$n,$xa>>2,""),2));
		
		$jb=-164314163;continue;		
case 717745890:
		$this->carr($RR,$n,$u>>2,$this->carr($RR,$n,$Ta>>2,"")+14);
		$this->carr($RR,$n,$fb>>2,$this->carr($RR,$n,$Ia>>2,"")+32>>2);
		
		$jb=-1878597151;continue;
case 195832850:
		$tb=$this->carr($RR,$n,$ua>>2,"");
		$this->carr($RR,$n,$cb>>2,$this->llf($this->aarr($RR,$n,$b+$tb,""),$this->llf($this->carr($RR,$n,$ua>>2,"")%4,3)));
		$this->carr($RR,$n,$gb>>2,$this->carr($RR,$n,$ua>>2,"")>>2);
		
		$jb=788846146;continue;
case 651068526:
		$tb=$this->llf($this->carr($RR,$n,$Fa>>2,""),2);$tb=($tb^~28)&$tb;
		$this->carr($RR,$n,$hb>>2,$this->carr($RR,$n,$qa>>2,"")>>(4&~$tb|$tb&~4));
		
		$jb=1288598934;continue;		
case 73587007:
		$this->carr($RR,$n,$y>>2,$this->carr($RR,$n,$x>>2,"")+34);
		
		$jb=167383782;continue;
case 788846146:
		$tb=$this->carr($RR,$n,$gb>>2,"");$this->carr($RR,$n,$D>>2,$ob+$this->llf($tb,2));
		$this->carr($RR,$n,$l>>2,$this->carr($RR,$n,$this->carr($RR,$n,$D>>2,"")>>2,""));
		
		$jb=108332815;continue;
case 151603818:
		$this->carr($RR,$n,$Ca>>2,$this->carr($RR,$n,$ua>>2,"")+1);
		
		$jb=1720235387;continue;
case 153691705:
		$this->carr($RR,$n,$Va>>2,$this->llf($this->carr($RR,$n,$Za>>2,"")%4,3));
		
		$jb=-86385898;continue;
case 368050796:
		$this->aarr($RR,$n,$_,$this->carr($RR,$n,$ua>>2,"")<4&1);
		
		$jb=-412361919;continue;	
case 545100308:
		$this->carr($RR,$n,$B>>2,~(~$this->carr($RR,$n,$oa>>2,"")|~$this->carr($RR,$n,$sa>>2,""))&-1);
		
		$jb=494739317;continue;
case 549762434:
		$this->harr($RR,$ib>>3,-$this->harr($RR,$q>>3,""));
		
		$jb=416259719;continue;		
case 1111318124:
		$this->harr($RR,$U>>3,sin($this->carr($RR,$n,$t>>2,"")));
		
		$jb=-1380451239;continue;
case 1129515855:
		$this->aarr($RR,$n,$W,($this->aarr($RR,$n,$k,""))!=0&1);
		
		$jb=-424000715;continue;		
case 1203488890:
		$this->carr($RR,$n,$x>>2,$this->carr($RR,$n,$Fa>>2,"")*23+$this->carr($RR,$n,$ua>>2,"")*37);
		
		$jb=73587007;continue;
case 1247969426:
		$this->aarr($RR,$n,$aa,$this->carr($RR,$n,$lb>>2,"")<10&1);
		
		$jb=1804404662;continue;
case 1347562810:
		$tb=$this->carr($RR,$n,$Fa>>2,"");$tb=($tb^~7)&$tb;
		$this->carr($RR,$n,$pb>>2,1&~$tb|$tb&~1);
		
		$jb=-991315587;continue;
case 1288598934:
		$tb=$this->carr($RR,$n,$hb>>2,"");
		$this->carr($RR,$n,$s>>2,217+(($tb^-16)&$tb));
		
		$jb=-423412824;continue;	
case 1514554794:
		$this->aarr($RR,$n,$ca,$this->carr($RR,$n,$Fa>>2,"")<16&1);
		
		$jb=-668795440;continue;
case 1541240532:
		$this->carr($RR,$n,$w>>2,$this->carr($RR,$n,$Ka>>2,"")+16);
		
		$jb=1410343841;continue;
case 1688333518:
		$this->carr($RR,$n,$ob+$this->llf($this->carr($RR,$n,$wa>>2,""),2)>>2,0);
		
		$jb=-895015477;continue;
case 1942162936:								
		$this->aarr($RR,$n,$fa,$this->carr($RR,$n,$Fa>>2,"")<48&1);
		
		$jb=-1610186071;continue;
case-1967845546:
		$this->carr($RR,$n,$A>>2,$this->carr($RR,$n,$lb>>2,"")+90);
		
		$jb=-180306226;continue;
case 2131809869:
		$this->aarr($RR,$n,$X,$this->carr($RR,$n,$v>>2,"")>=$this->carr($RR,$n,$Za>>2,"")&1);
		
		$jb=-44538672;continue;	
case-1995522865:
		$this->aarr($RR,$n,$ga,$this->carr($RR,$n,$Fa>>2,"")<64&1);
		
		$jb=-763186054;continue;
case-1841591203:
		$this->aarr($RR,$n,$ka,$this->harr($RR,$q>>3,"")<0&1);
		
		$jb=-152754021;continue;
case-1892665105:
		$this->carr($RR,$n,$ab>>2,$this->carr($RR,$n,$Za>>2,"")%4);
		
		$jb=463554092;continue;			
case-1572948785:
		$this->aarr($RR,$n,$da,$this->carr($RR,$n,$Fa>>2,"")<16&1);
		
		$jb=1951978675;continue;					
case-1385908106:
		$tb=$this->carr($RR,$n,$nb>>2,"");
		$this->aarr($RR,$n,$k,$this->aarr($RR,$n,$b+$tb,""));
		
		$jb=1129515855;continue;
case-1355478599:
		$this->aarr($RR,$n,$ia,$this->carr($RR,$n,$Fa>>2,"")<32&1);
		
		$jb=1667927966;continue;
case-1341729830:
		$this->aarr($RR,$n,$Z,$this->carr($RR,$n,$ua>>2,"")<$this->carr($RR,$n,$Ia>>2,"")&1);
		
		$jb=-1552799363;continue;
case-1173436005:
		$this->harr($RR,$Wa>>3,$this->harr($RR,$q>>3,"")*4294967296);
		
		$jb=800362374;continue;
case-1153545492:
		$tb=$this->carr($RR,$n,$Fa>>2,"");
		$this->carr($RR,$n,$C>>2,($tb^~7)&$tb);
		
		$jb=-521081237;continue;
case-1129217909:
		$this->aarr($RR,$n,$V,$this->carr($RR,$n,$Fa>>2,"")<8&1);
		
		$jb=60376344;continue;
case-1098566066:
		$this->aarr($RR,$n,$Y,$this->carr($RR,$n,$ua>>2,"")<$this->carr($RR,$n,$Za>>2,"")&1);
		
		$jb=-999614033;continue;
case-902588506:
		$this->carr($RR,$n,$I>>2,$this->carr($RR,$n,$J>>2,"")+32);
		
		$jb=-747420302;continue;
case-747420302:
		$this->aarr($RR,$n,$this->carr($RR,$n,$I>>2,""),0);
		
		$jb=601583830;continue;
case-671207445:
		$this->carr($RR,$n,$t>>2,$this->carr($RR,$n,$Fa>>2,"")+1);
		
		$jb=1111318124;continue;
case-602596021:
		$this->aarr($RR,$n,$ja,$this->carr($RR,$n,$Fa>>2,"")<64&1);
		
		$jb=780107150;continue;
case-568636039:
		$this->carr($RR,$n,$Ta>>2,$this->llf($this->carr($RR,$n,$Ia>>2,"")+40>>6,4));
		
		$jb=717745890;continue;
case-545058508:
		$this->aarr($RR,$n,$ba,$this->carr($RR,$n,$ua>>2,"")<$this->carr($RR,$n,$Ka>>2,"")&1);
		
		$jb=-1361473685;continue;
case-80539691:
		$this->carr($RR,$n,$z>>2,$this->carr($RR,$n,$lb>>2,"")+49);
		
		$jb=484876086;continue;
case-25886128:
		$this->carr($RR,$n,$Ba>>2,$this->carr($RR,$n,$Ia>>2,"")+1);
		
		$jb=-843646639;continue;			
case-390950602:
		$this->aarr($RR,$n,$f,$this->aarr($RR,$n,$this->carr($RR,$n,$r>>2,""),""));
		$ub=$this->carr($RR,$n,$Fa>>2,"");
		$tb=$va;
		$this->carr($RR,$n,$tb>>2,$ub);
		$this->carr($RR,$n,$tb+4>>2,$this->llf($ub<0,31)>>31);
		
		$jb=-275270623;continue;
case-327886970:
		$xb=$this->carr($RR,$n,$Ma>>2,"");
		$tb=$this->carr($RR,$n,$ma>>2,"");
		$yb=~(~((~(~$xb|~-2)&-1)+$tb)|~-2)&-1;
		$xb=~(~$xb|~1)&-1;
		$wb=~$yb;
		$vb=~$xb;
		$ub=~1572610025;
		$this->carr($RR,$n,$R>>2,(($wb&1572610025|$yb&$ub)^($vb&1572610025|$xb&$ub)|~($wb|$vb)&(1572610025|$ub))+(~(~$tb|~1)&-1));
		
		$jb=2008811188;continue;		
case-86385898:
		$wb=$this->llf(128,$this->carr($RR,$n,$Va>>2,""));
		$xb=$this->carr($RR,$n,$Za>>2,"")>>2;
		$this->carr($RR,$n,$F>>2,$ob+$this->llf($xb,2));
		$xb=$this->carr($RR,$n,$this->carr($RR,$n,$F>>2,"")>>2,"");
		$vb=~$xb;
		$ub=~$wb;
		$tb=~924717824;
		$this->carr($RR,$n,$_a>>2,($vb&924717824|$xb&$tb)^($ub&924717824|$wb&$tb)|~($vb|$ub)&(924717824|$tb));
		
		$jb=1264018475;continue;
case-665924408:
		$tb=$this->carr($RR,$n,$__a>>2,"");
		$ub=$this->carr($RR,$n,$oa>>2,"");
		$vb=~(~((($ub^~-2)&$ub)+$tb)|~-2)&-1;
		$ub=~(~$ub|~1)&-1;
		$this->carr($RR,$n,$P>>2,($vb&$ub|$vb^$ub)+(($tb^~1)&$tb));
		
		$jb=-401948426;continue;		
case-521081237:
		$ub=$this->llf($this->carr($RR,$n,$C>>2,""),2);
		$tb=~852477429;
		$tb=$this->carr($RR,$n,$sa>>2,"")>>((852477429&~$ub|$ub&$tb)^(~4&852477429|4&$tb));
		$this->aarr($RR,$n,$j,$this->aarr($RR,$n,217+(($tb^-16)&$tb),""));
		$tb=$this->carr($RR,$n,$Fa>>2,"");
		$this->carr($RR,$n,$H>>2,$this->carr($RR,$n,$J>>2,"")+$tb);
		
		$jb=1510822949;continue;				
case-412272376:
		$tb=~(~$this->llf($this->carr($RR,$n,$Fa>>2,""),2)|~28)&-1;
		$this->carr($RR,$n,$r>>2,217+~(~($this->carr($RR,$n,$ma>>2,"")>>(4&~$tb|$tb&~4))|-16));
		
		$jb=-390950602;continue;		
case-934444625:
		$ub=$this->carr($RR,$n,$ua>>2,"");
		$tb=$wa;
		$this->carr($RR,$n,$tb>>2,$ub);
		$this->carr($RR,$n,$tb+4>>2,$this->llf($ub<0,31)>>31);
		
		$jb=1688333518;continue;
case-991315587:
		$ub=$this->carr($RR,$n,$oa>>2,"")>>$this->llf($this->carr($RR,$n,$pb>>2,""),2);
		$this->aarr($RR,$n,$g,$this->aarr($RR,$n,217+(($ub^-16)&$ub),""));
		$ub=$this->carr($RR,$n,$Fa>>2,"");
		$tb=$za;
		$this->carr($RR,$n,$tb>>2,$ub);
		$this->carr($RR,$n,$tb+4>>2,$this->llf((($ub)<0),31)>>31);
				
		$jb=-58343100;continue;				
case-1290934332:
		$Db=$this->carr($RR,$n,$sa>>2,"");
		$Db=~$Db|$Db&~-1;
		$ub=$this->carr($RR,$n,$oa>>2,"");
		$tb=~$ub;
		$vb=~$Db;
		$wb=~2127574409;
		$wb=($tb&2127574409|$ub&$wb)^($vb&2127574409|$Db&$wb)|~($tb|$vb)&(2127574409|$wb);
		$vb=$this->carr($RR,$n,$qa>>2,"");
		$tb=~-1932706895;
		$tb=(~$vb&-1932706895|$vb&$tb)^(~$wb&-1932706895|$wb&$tb);
		$wb=$this->carr($RR,$n,$ma>>2,"");
		$vb=(~(~$wb|~-2)&-1)+$tb;
		$vb=($vb^~-2)&$vb;
		$Db=~(~$wb|~1)&-1;
		$Db=($vb&$Db|$vb^$Db)+(~(~$tb|~1)&-1);
		$vb=$this->carr($RR,$n,$Fa>>2,"");
		$vb=$this->carr($RR,$n,$Ga+$this->llf($vb,2)>>2,"");
		$ub=($this->carr($RR,$n,$Fa>>2,"")*7)%16+$this->carr($RR,$n,$ua>>2,"");
		$ub=$this->carr($RR,$n,$ob+$this->llf($ub,2)>>2,"");
		$Bb=$ub+(($vb^~-2)&$vb);
		$Bb=($Bb^~-2)&$Bb;
		$Ab=($vb^~1)&$vb;
		$zb=~$Bb;
		$yb=~$Ab;
		$xb=~193036646;
		$Cb=~(~$ub|~1)&-1;
		$Db=($Db^~-2)&$Db;
		$xb=($Db&$Cb|$Db^$Cb)-(-(($zb&193036646|$Bb&$xb)^($yb&193036646|$Ab&$xb)|~($zb|$yb)&(193036646|$xb)));
		$xb=($xb^~-2)&$xb;
		$wb+=$tb;
		$wb=($wb^~1)&$wb;
		$vb+=$ub;
		$vb=($xb&$wb|$xb^$wb)+(($vb^~1)&$vb);
		$wb=$this->carr($RR,$n,$Fa>>2,"")%4+12;
		$wb=$this->carr($RR,$n,16+$this->llf($wb,2)>>2,"");
		$xb=$this->llf($vb,$wb);
		$wb=$this->_rshift($vb,32-$wb);
		$vb=~$xb;
		$ub=~$wb;
		$tb=~850713340;
		$this->carr($RR,$n,$__a>>2,($vb&850713340|$xb&$tb)^($ub&850713340|$wb&$tb)|~($vb|$ub)&(850713340|$tb));
		
		$jb=-665924408;continue;
case 1153477833:
		$ub=$this->carr($RR,$n,$oa>>2,"");
		$ub=$ub^~$this->carr($RR,$n,$qa>>2,"")&$ub;
		$yb=$this->carr($RR,$n,$oa>>2,"");
		$xb=~1180867059;
		$xb=~(~$this->carr($RR,$n,$sa>>2,"")|~((1180867059&~$yb|$yb&$xb)^(~-1&1180867059|-1&$xb)))&-1;
		$ub=$xb&$ub|$xb^$ub;
		$xb=$this->carr($RR,$n,$ma>>2,"");
		$yb=~(~((($xb^~-2)&$xb)+$ub)|~-2)&-1;
		$xb=($xb^~1)&$xb;
		$wb=~$yb;
		$vb=~$xb;
		$tb=~1812756882;
		$this->carr($RR,$n,$K>>2,(($wb&1812756882|$yb&$tb)^($vb&1812756882|$xb&$tb)|~($wb|$vb)&(1812756882|$tb))+(($ub^~1)&$ub));
		$ub=$this->carr($RR,$n,$Fa>>2,"");
		$tb=$xa;
		$this->carr($RR,$n,$tb>>2,$ub);
		$this->carr($RR,$n,$tb+4>>2,$this->llf($ub<0,31)>>31);
		
		$jb=633810001;continue;		
case 494739317:
		$Hb=$this->carr($RR,$n,$sa>>2,"");
		$Fb=~137942632;
		$Gb=$this->carr($RR,$n,$qa>>2,"");
		$Gb=($Gb^~((137942632&~$Hb|$Hb&$Fb)^(~-1&137942632|-1&$Fb)))&$Gb;
		$Fb=$this->carr($RR,$n,$B>>2,"");
		$Hb=~$Fb;
		$vb=~$Gb;
		$xb=~-5458134;
		$xb=($Hb&-5458134|$Fb&$xb)^($vb&-5458134|$Gb&$xb)|~($Hb|$vb)&(-5458134|$xb);
		$vb=$this->carr($RR,$n,$ma>>2,"");
		$Hb=~(~((~(~$vb|~-2)&-1)+$xb)|~-2)&-1;
		$Gb=~(~$vb|~1)&-1;
		$Fb=~$Hb;
		$Eb=~$Gb;
		$Db=~-118764121;
		$ub=$this->carr($RR,$n,$Fa>>2,"");
		$ub=$this->carr($RR,$n,$Ga+$this->llf($ub,2)>>2,"");
		$tb=($this->carr($RR,$n,$Fa>>2,"")*5+1)%16+$this->carr($RR,$n,$ua>>2,"");
		$tb=$this->carr($RR,$n,$ob+$this->llf($tb,2)>>2,"");
		$Bb=~(~($tb+(~(~$ub|~-2)&-1))|~-2)&-1;
		$Ab=~(~$ub|~1)&-1;
		$zb=~$Bb;
		$yb=~$Ab;
		$wb=~35866813;
		$Cb=($tb^~1)&$tb;
		
		$Db=~(~((($Fb&-118764121|$Hb&$Db)^($Eb&-118764121|$Gb&$Db)|~($Fb|$Eb)&(-118764121|$Db))+(~(~$xb|~1)&-1))|~-2)&-1;
		$wb=($Db&$Cb|$Db^$Cb)+(($zb&35866813|$Bb&$wb)^($yb&35866813|$Ab&$wb)|~($zb|$yb)&(35866813|$wb));
		$wb=($wb^~-2)&$wb;
		$vb=$xb+$vb;
		$vb=($vb^~1)&$vb;
		$this->carr($RR,$n,$L>>2,($wb&$vb|$wb^$vb)+(~(~($tb+$ub)|~1)&-1));
		$ub=$this->carr($RR,$n,$Fa>>2,"")%4+4;
		$tb=$ya;
		$this->carr($RR,$n,$tb>>2,$ub);
		$this->carr($RR,$n,$tb+4>>2,$this->llf($ub<0,31)>>31);
		
		$jb=276665542;continue;		
case 999695174:								
		$xb=$this->carr($RR,$n,$M>>2,"");								
		$tb=$this->carr($RR,$n,$N>>2,"");
		$yb=~(~((~(~$xb|~-2)&-1)-(-$tb))|~-2)&-1;
		$xb=($xb^~1)&$xb;								
		$wb=~$yb;
		$vb=~$xb;
		$ub=~-2039534323;
		$this->carr($RR,$n,$O>>2,(($wb&-2039534323|$yb&$ub)^($vb&-2039534323|$xb&$ub)|~($wb|$vb)&(-2039534323|$ub))-(-(~(~$tb|~1)&(843895025|~843895025))));								
		$tb=$this->carr($RR,$n,$Fa>>2,"")%4+8;				
		$tb=$this->carr($RR,$n,16+$this->llf($tb,2)>>2,"");								
		$this->carr($RR,$n,$eb>>2,$this->llf($this->carr($RR,$n,$O>>2,""),$tb));
		$this->carr($RR,$n,$bb>>2,32-$tb);
		
		$jb=-738461164;continue;
case 800362374:
		$tb=$this->carr($RR,$n,$Fa>>2,"");
		$this->carr($RR,$n,$Ga+$this->llf($tb,2)>>2,~~+$this->harr($RR,$Wa>>3,""));
		$this->carr($RR,$n,$Da>>2,$this->carr($RR,$n,$Fa>>2,"")+1);
		
		$jb=228161238;continue;
case 439769685:
		$yb=$this->carr($RR,$n,$qa>>2,"");
		$tb=$this->carr($RR,$n,$oa>>2,"");
		$yb=$yb&~$tb|$tb&~$yb;
		$tb=$this->carr($RR,$n,$sa>>2,"");
		$xb=~1841611462;
		$xb=(1841611462&~$yb|$yb&$xb)^(~$tb&1841611462|$tb&$xb);
		$tb=$this->carr($RR,$n,$ma>>2,"");
		$yb=~(~((~(~$tb|~-2)&-1)-(-$xb))|~-2)&-1;
		$tb=($tb^~1)&$tb;
		$this->carr($RR,$n,$M>>2,($yb&$tb|$yb^$tb)+(($xb^~1)&$xb));
		$xb=$this->carr($RR,$n,$Fa>>2,"");
		$xb=$this->carr($RR,$n,$Ga+$this->llf($xb,2)>>2,"");
		$tb=($this->carr($RR,$n,$Fa>>2,"")*3+5)%16+$this->carr($RR,$n,$ua>>2,"");
		$tb=$this->carr($RR,$n,$ob+$this->llf($tb,2)>>2,"");
		$yb=~(~($tb+(~(~$xb|~-2)&-1))|~-2)&-1;
		$xb=($xb^~1)&$xb;
		$wb=~$yb;
		$vb=~$xb;
		$ub=~-942245303;
		$this->carr($RR,$n,$N>>2,(($wb&-942245303|$yb&$ub)^($vb&-942245303|$xb&$ub)|~($wb|$vb)&(-942245303|$ub))-(-(($tb^~1)&$tb)));
		
		$jb=999695174;continue;
case 463554092:
		$this->carr($RR,$n,$db>>2,$this->llf($this->carr($RR,$n,$lb>>2,""),$this->llf($this->carr($RR,$n,$ab>>2,""),3)));
		$tb=$this->carr($RR,$n,$Za>>2,"")>>2;
		$this->carr($RR,$n,$E>>2,$ob+$this->llf($tb,2));
		$this->carr($RR,$n,$m>>2,$this->carr($RR,$n,$this->carr($RR,$n,$E>>2,"")>>2,""));
		
		$jb=791025390;continue;
case 2008811188:
		$xb=$this->carr($RR,$n,$Oa>>2,"");
		$ub=$this->carr($RR,$n,$oa>>2,"");
		$yb=(($xb^~-2)&$xb)+$ub;
		$yb=($yb^~-2)&$yb;
		$xb=($xb^~1)&$xb;
		$wb=~$yb;
		$vb=~$xb;
		$tb=~-315119066;
		$this->carr($RR,$n,$S>>2,(($wb&-315119066|$yb&$tb)^($vb&-315119066|$xb&$tb)|~($wb|$vb)&(-315119066|$tb))+(($ub^~1)&$ub));
		$ub=$this->carr($RR,$n,$Qa>>2,"");
		$tb=$this->carr($RR,$n,$qa>>2,"");
		$vb=(($ub^~-2)&$ub)+$tb;
		$vb=($vb^~-2)&$vb;
		$ub=~(~$ub|~1)&-1;
		$this->carr($RR,$n,$T>>2,($vb&$ub|$vb^$ub)+(($tb^~1)&$tb));
		
		$jb=-1101163512;continue;		
		
case 2146552338:case -2051875059:case -630729423:case-2141197378:case 2028659015:
case 1432877594:case -1662327480:case -983205733:case -1924281938:case 1774369769:
case -489741395:case -828878942:case -2136717671:case 2045376102:case 916103055:
case 1775324253:case 690197071:case 139799944:case 1618283724:case 331129789:
case -1785460248:case 2070699595:case 1137039176:case 270009349:
case -722374409:case 2059037329:case -1360885125:case -1781069297:case 601583830:
case 1388594392:case -777225753:case -920516874:case 1297236730:case 481757527:
case -2014580748:case 2014978051:case 1468918320:case 128106704:case-401948426:	
case-1971280264:case-180306226:case 484876086:case 167383782:case 637834779:
case 1720235387:case-1579204746:case-1797419395:case 1657487624:case-895015477:	
case 1410343841:case-1878597151:case-2014779455:case-843646639:case-256536033:
case 416259719:case-1380451239:case 228161238:case-856036625:case-2074579782:

  
		$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"");$na=$this->carr($RR,$n,$oa>>2,"");
		$pa=$this->carr($RR,$n,$qa>>2,"");$ra=$this->carr($RR,$n,$sa>>2,"");$ta=$this->carr($RR,$n,$ua>>2,"");
		$Ea=$this->carr($RR,$n,$Fa>>2,"");$Ha=$this->carr($RR,$n,$Ia>>2,"");$Ja=$this->carr($RR,$n,$Ka>>2,"");
		$La=$this->carr($RR,$n,$Ma>>2,"");$Na=$this->carr($RR,$n,$Oa>>2,"");$Pa=$this->carr($RR,$n,$Qa>>2,"");
		$Ra=$this->carr($RR,$n,$Sa>>2,"");$Ya=$this->carr($RR,$n,$Za>>2,"");
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");

		if ($jb==2146552338) $n=0; 
		elseif ($jb==-2051875059) $n=1; elseif ($jb==-630729423) $n=3;
		elseif ($jb==-2141197378) $n=5; elseif ($jb==2028659015) $n=7; 
		elseif ($jb==1432877594) $n=9; elseif ($jb==-1662327480) $n=11;
		elseif ($jb==-983205733) $n=13; elseif ($jb==-1924281938) $n=17;
		elseif ($jb==1774369769) $n=21; elseif ($jb==-489741395) $n=22;
		elseif ($jb==-828878942) $n=24; elseif ($jb==-2136717671) $n=25;
		elseif ($jb==2045376102) $n=27; elseif ($jb==916103055) $n=$this->carr($RR,$n,$o>>2,"");		   
		elseif ($jb==1775324253) $n=31; elseif ($jb==690197071) $n=35;
		elseif ($jb==139799944) $n=36; elseif ($jb==1618283724) $n=40;
		elseif ($jb==331129789) $n=41; elseif ($jb==-1785460248) $n=45;
		elseif ($jb==2070699595) $n=46; elseif ($jb==1137039176) $n=48;
		elseif ($jb==270009349) $n=49; 
		elseif ($jb==-722374409) $n=54; elseif ($jb==2059037329) $n=55;
		elseif ($jb==-1360885125) $n=56; elseif ($jb==-1781069297) $n=58;
		elseif ($jb==601583830) $n=63; elseif ($jb==1388594392) $n=64;
		elseif ($jb==-777225753) $n=65; elseif ($jb==-920516874) $n=67;
		elseif ($jb==1297236730) $n=69; 
		elseif ($jb==481757527) $n=71; elseif ($jb==-2014580748) $n=73;
		elseif ($jb==2014978051) $n=75; elseif ($jb==1468918320) $n=77;
		elseif ($jb==128106704) $n=81; 		
		elseif ($jb==-401948426) 
		   {$n=3;
		   $Ea++;
		   $na=$this->carr($RR,$n,$P>>2,"");
		   $la=$this->carr($RR,$n,$sa>>2,"");
		   $ra=$this->carr($RR,$n,$qa>>2,"");
		   $pa=$this->carr($RR,$n,$oa>>2,"");}		
		elseif ($jb==-1971280264) 
		   {$n=15;
		   $Ea=0;
		   $La=$this->carr($RR,$n,$ma>>2,"");
		   $Na=$this->carr($RR,$n,$oa>>2,"");
		   $Pa=$this->carr($RR,$n,$qa>>2,"");
		   $Ra=$this->carr($RR,$n,$sa>>2,"");}
		elseif ($jb==-180306226) 
		   {$n=23;$kb=$this->carr($RR,$n,$A>>2,"");}
		elseif ($jb==484876086) 
		   {$n=23;$kb=$this->carr($RR,$n,$z>>2,"");}
		elseif ($jb==167383782) 
		   {$n=26;$kb=$this->carr($RR,$n,$y>>2,"")%32;}
		elseif ($jb==637834779) 
		   {$n=29;$Ea=0;}		
		elseif ($jb==1720235387) 
		   {$n=33;$ta=$this->carr($RR,$n,$Ca>>2,"");}		
		elseif ($jb==-1579204746) 
		   {$n=33;$ta=0;$Ya=$this->carr($RR,$n,$ua>>2,"");}	
		elseif ($jb==-1797419395) 
		   {$n=38;$ta=0;}						   
		elseif ($jb==1657487624) 
		   {$n=43;$ta=0;}
		elseif ($jb==-895015477) 
		   {$n=43;$ta++;}
		elseif ($jb==1410343841) 
		   {$n=45;$Ya=$this->carr($RR,$n,$w>>2,"");}	
		elseif ($jb==-1878597151) 
		   {$n=47;
		   $Ya=$this->carr($RR,$n,$fb>>2,"");
		   $Ja=$this->carr($RR,$n,$u>>2,"");}	
		elseif ($jb==-2014779455) 
		   {$n=52;
		   $la=1732584193;$na=-271733879;
		   $pa=-1732584194;$ra=271733878;}
		elseif ($jb==-843646639) 
		   {$n=52;$Ha=$this->carr($RR,$n,$Ba>>2,"");}
		elseif ($jb==-256536033) 
		   {$n=51;
		   $ta=$this->carr($RR,$n,$Aa>>2,"");
		   $mb=$this->carr($RR,$n,$ua>>2,"");}
		elseif ($jb==416259719) 
		   {$n=55;$p=$this->harr($RR,$ib>>3,"");}
		elseif ($jb==-1380451239) 
		   {$n=57;$p=$this->harr($RR,$U>>3,"");}
		elseif ($jb==228161238) 
		   {$n=60;$Ea=$this->carr($RR,$n,$Da>>2,"");}
		elseif ($jb==-856036625) 
		   {$n=60;$ta=0;$Ea=0;$Ha=0;}	
		elseif ($jb==-2074579782) 
		   {$n=79;$Ea=0;}
		   						   		   
		$jb=-188097831;continue;						
				
case-738461164:
		$n=$this->_rshift($this->carr($RR,$n,$O>>2,""),$this->carr($RR,$n,$bb>>2,""));					
		$la=$this->carr($RR,$n,$eb>>2,""); 
	
		$ra=~$la;
		$pa=~$n;
		$na=~656398317;
		$na=($ra&656398317|$la&$na)^($pa&656398317|$n&$na)|~($ra|$pa)&(656398317|$na);
		
		$pa=$this->carr($RR,$n,$oa>>2,"");
		$ra=(~(~$pa|~-2)&-1)+$na;
		$ra=($ra^~-2)&$ra;
		$pa=($pa^~1)&$pa;
		
		$n=7;
		$p=$this->harr($RR,$q>>3,"");
		$la=$this->carr($RR,$n,$sa>>2,"");
		$na=($ra&$pa|$ra^$pa)+(~(~$na|~1)&-1);
										
		$pa=$this->carr($RR,$n,$oa>>2,"");$ra=$this->carr($RR,$n,$qa>>2,"");$ta=$this->carr($RR,$n,$ua>>2,"");
		$Ea=$this->carr($RR,$n,$Fa>>2,"")+1;$Ha=$this->carr($RR,$n,$Ia>>2,"");
		$Ja=$this->carr($RR,$n,$Ka>>2,"");$La=$this->carr($RR,$n,$Ma>>2,"");$Na=$this->carr($RR,$n,$Oa>>2,"");
		$Pa=$this->carr($RR,$n,$Qa>>2,"");$Ra=$this->carr($RR,$n,$Sa>>2,"");$Ya=$this->carr($RR,$n,$Za>>2,"");
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");
	
		$jb=-188097831;continue;
case 276665542:
		$ra=$this->carr($RR,$n,16+$this->llf($this->carr($RR,$n,$ya>>2,""),2)>>2);
		$ta=$this->llf($this->carr($RR,$n,$L>>2,""),$ra);
		$ra=$this->_rshift($this->carr($RR,$n,$L>>2,""),32-$ra);
		$Ha=~$ra;
		$Ea=~$ta;
		$na=~-1044037601;
		$na=($Ha&-1044037601|$ra&$na)^($Ea&-1044037601|$ta&$na)|~($Ha|$Ea)&(-1044037601|$na);
		$Ea=$this->carr($RR,$n,$oa>>2,"");
		$Ha=~(~((($Ea^~-2)&$Ea)+$na)|~-2)&-1;
		$Ea=~(~$Ea|~1)&-1;
		$ta=~$Ha;
		$ra=~$Ea;
		$pa=~522919445;
		
		$n=11;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$sa>>2,"");
		$na=(($ta&522919445|$Ha&$pa)^($ra&522919445|$Ea&$pa)|~($ta|$ra)&(522919445|$pa))+(($na^~1)&$na);
		$pa=$this->carr($RR,$n,$oa>>2,"");$ra=$this->carr($RR,$n,$qa>>2,"");$ta=$this->carr($RR,$n,$ua>>2,"");
		$Ea=$this->carr($RR,$n,$Fa>>2,"")+1;$Ha=$this->carr($RR,$n,$Ia>>2,"");$Ja=$this->carr($RR,$n,$Ka>>2,"");
		$La=$this->carr($RR,$n,$Ma>>2,"");$Na=$this->carr($RR,$n,$Oa>>2,"");$Pa=$this->carr($RR,$n,$Qa>>2,"");
		$Ra=$this->carr($RR,$n,$Sa>>2,"");$Ya=$this->carr($RR,$n,$Za>>2,"");
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");
		
		$jb=-188097831;continue;
case-164314163:
		$ra=$this->carr($RR,$n,$this->carr($RR,$n,$G>>2,"")>>2,"");
		$n=$this->carr($RR,$n,$Fa>>2,"")%16+$this->carr($RR,$n,$ua>>2,"");
		$n=$this->carr($RR,$n,$ob+$this->llf($n,2)>>2,"");
		$Ha=~(~($n+(~(~$ra|~-2)&-1))|~-2)&-1;
		$Ea=~(~$ra|~1)&-1;
		$ta=~$Ha;
		$na=~$Ea;
		$pa=~372789369;
		$Ja=~(~$n|~1)&-1;
		$la=$this->carr($RR,$n,$K>>2,"");
		$La=~(~$la|~-2)&-1;
		$pa=($La&$Ja|$La^$Ja)+(($ta&372789369|$Ha&$pa)^($na&372789369|$Ea&$pa)|~($ta|$na)&(372789369|$pa));
		$pa=($pa^~-2)&$pa;
		$la=~(~$la|~1)&-1;
		$ra=($pa&$la|$pa^$la)+(~(~($n-(-$ra))|~1)&-1);
		$n=$this->carr($RR,$n,$Fa>>2,"")%4;
		$n=$this->carr($RR,$n,16+$this->llf($n,2)>>2,"");
		$la=$this->llf($ra,$n);
		$n=$this->_rshift($ra,32-$n);
		$ra=~$la;
		$pa=~$n;
		$na=~50919874;
		$na=($ra&50919874|$la&$na)^($pa&50919874|$n&$na)|~($ra|$pa)&(50919874|$na);
		$pa=$this->carr($RR,$n,$oa>>2,"");
		$ra=~(~($na+(($pa^~-2)&$pa))|~-2)&-1;
		$pa=($pa^~1)&$pa;
		
		$n=15;
		$p=$this->harr($RR,$q>>3,"");
		$la=$this->carr($RR,$n,$sa>>2,"");
		$na=($ra&$pa|$ra^$pa)+(($na^~1)&$na);
		$pa=$this->carr($RR,$n,$oa>>2,"");
		$ra=$this->carr($RR,$n,$qa>>2,"");
		$ta=$this->carr($RR,$n,$ua>>2,"");
		$Ea=$this->carr($RR,$n,$Fa>>2,"")+1;
		$Ha=$this->carr($RR,$n,$Ia>>2,"");
		$Ja=$this->carr($RR,$n,$Ka>>2,"");
		$La=$this->carr($RR,$n,$Ma>>2,"");
		$Na=$this->carr($RR,$n,$Oa>>2,"");
		$Pa=$this->carr($RR,$n,$Qa>>2,"");
		$Ra=$this->carr($RR,$n,$Sa>>2,"");
		$Ya=$this->carr($RR,$n,$Za>>2,"");		
		$kb=$this->carr($RR,$n,$lb>>2,"");
		$mb=$this->carr($RR,$n,$nb>>2,"");
		
		$jb=-188097831;continue;
case 1264018475:
		$this->carr($RR,$n,$this->carr($RR,$n,$F>>2,"")>>2,$this->carr($RR,$n,$_a>>2,""));$n=$this->carr($RR,$n,$Ka>>2,"");
		$this->carr($RR,$n,$ob+$this->llf($n,2)>>2,$this->llf($this->carr($RR,$n,$Ia>>2,""),3)+256);
		
		$n=19;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"");$na=$this->carr($RR,$n,$oa>>2,"");
		$pa=$this->carr($RR,$n,$qa>>2,"");$ra=$this->carr($RR,$n,$sa>>2,"");$ta=0;$Ea=$this->carr($RR,$n,$Fa>>2,"");
		$Ha=$this->carr($RR,$n,$Ia>>2,"");$Ja=$this->carr($RR,$n,$Ka>>2,"");$La=$this->carr($RR,$n,$Ma>>2,"");
		$Na=$this->carr($RR,$n,$Oa>>2,"");$Pa=$this->carr($RR,$n,$Qa>>2,"");$Ra=$this->carr($RR,$n,$Sa>>2,"");
		$Ya=$this->carr($RR,$n,$Za>>2,"");
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");
		
		$jb=-188097831;continue;
case-1101163512:
		$ta=$this->carr($RR,$n,$Sa>>2,"");
		$ra=$this->carr($RR,$n,$sa>>2,"");
		$Ea=(~(~$ta|~-2)&-1)+$ra;
		$Ea=($Ea^~-2)&$Ea;
		$ta=~(~$ta|~1)&-1;
		
		$n=19;
		$p=$this->harr($RR,$q>>3,"");
		$la=$this->carr($RR,$n,$R>>2,"");
		$na=$this->carr($RR,$n,$S>>2,"");
		$pa=$this->carr($RR,$n,$T>>2,"");
		$ra=($Ea&$ta|$Ea^$ta)+(($ra^~1)&$ra);
		$ta=$this->carr($RR,$n,$ua>>2,"")+16;
		
		$Ea=$this->carr($RR,$n,$Fa>>2,"");$Ha=$this->carr($RR,$n,$Ia>>2,"");
		$Ja=$this->carr($RR,$n,$Ka>>2,"");$La=$this->carr($RR,$n,$Ma>>2,"");
		$Na=$this->carr($RR,$n,$Oa>>2,"");$Pa=$this->carr($RR,$n,$Qa>>2,"");
		$Ra=$this->carr($RR,$n,$Sa>>2,"");$Ya=$this->carr($RR,$n,$Za>>2,"");		
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");
		
		$jb=-188097831;continue;	
case 791025390:
		$pa=$this->carr($RR,$n,$db>>2,"");
		$ra=$this->carr($RR,$n,$m>>2,"");
		$na=~$ra;
		$la=~$pa;
		$n=~243669087;
		$this->carr($RR,$n,$this->carr($RR,$n,$E>>2,"")>>2,($na&243669087|$ra&$n)^($la&243669087|$pa&$n)|~($na|$la)&(243669087|$n));
		
		$n=29;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"");
		$na=$this->carr($RR,$n,$oa>>2,"");
		$pa=$this->carr($RR,$n,$qa>>2,"");$ra=$this->carr($RR,$n,$sa>>2,"");$ta=$this->carr($RR,$n,$ua>>2,"");
		$Ea=$this->carr($RR,$n,$Fa>>2,"")+1;$Ha=$this->carr($RR,$n,$Ia>>2,"");
		$Ja=$this->carr($RR,$n,$Ka>>2,"");$La=$this->carr($RR,$n,$Ma>>2,"");$Na=$this->carr($RR,$n,$Oa>>2,"");
		$Pa=$this->carr($RR,$n,$Qa>>2,"");$Ra=$this->carr($RR,$n,$Sa>>2,"");$Ya=$this->carr($RR,$n,$Za>>2,"")+1;
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");
		
		$jb=-188097831;continue;		
case 108332815:
		$pa=$this->carr($RR,$n,$cb>>2,"");
		$ra=$this->carr($RR,$n,$l>>2,"");
		$na=~$ra;
		$la=~$pa;
		$n=~961559109;
		$this->carr($RR,$n,$this->carr($RR,$n,$D>>2,"")>>2,($na&961559109|$ra&$n)^($la&961559109|$pa&$n)|~($na|$la)&(961559109|$n));
		
		$n=38;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"");$na=$this->carr($RR,$n,$oa>>2,"");
		$pa=$this->carr($RR,$n,$qa>>2,"");$ra=$this->carr($RR,$n,$sa>>2,"");$ta=$this->carr($RR,$n,$ua>>2,"")+1;
		$Ea=$this->carr($RR,$n,$Fa>>2,"");$Ha=$this->carr($RR,$n,$Ia>>2,"");$Ja=$this->carr($RR,$n,$Ka>>2,"");
		$La=$this->carr($RR,$n,$Ma>>2,"");$Na=$this->carr($RR,$n,$Oa>>2,"");$Pa=$this->carr($RR,$n,$Qa>>2,"");
		$Ra=$this->carr($RR,$n,$Sa>>2,"");$Ya=$this->carr($RR,$n,$Za>>2,"");
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");
		
		$jb=-188097831;continue;					
case 1510822949:
		$this->aarr($RR,$n,$this->carr($RR,$n,$H>>2,""),$this->aarr($RR,$n,$j,""));
		
		$n=67;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"");$na=$this->carr($RR,$n,$oa>>2,"");
		$pa=$this->carr($RR,$n,$qa>>2,"");$ra=$this->carr($RR,$n,$sa>>2,"");$ta=$this->carr($RR,$n,$ua>>2,"");
		$Ea=$this->carr($RR,$n,$Fa>>2,"")+1;$Ha=$this->carr($RR,$n,$Ia>>2,"");$Ja=$this->carr($RR,$n,$Ka>>2,"");
		$La=$this->carr($RR,$n,$Ma>>2,"");$Na=$this->carr($RR,$n,$Oa>>2,"");$Pa=$this->carr($RR,$n,$Qa>>2,"");
		$Ra=$this->carr($RR,$n,$Sa>>2,"");$Ya=$this->carr($RR,$n,$Za>>2,"");
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");
		
		$jb=-188097831;continue;		
case-423412824:
		$n=$this->carr($RR,$n,$Fa>>2,"");
		$this->aarr($RR,$n,$this->carr($RR,$n,$J>>2,"")+$n,$this->aarr($RR,$n,$this->carr($RR,$n,$s>>2,""),""));
		
		$n=71;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"");
		$na=$this->carr($RR,$n,$oa>>2,"");$pa=$this->carr($RR,$n,$qa>>2,"");
		$ra=$this->carr($RR,$n,$sa>>2,"");
		$ta=$this->carr($RR,$n,$ua>>2,"");$Ea=($this->carr($RR,$n,$Fa>>2,""))-(-1);
		$Ha=$this->carr($RR,$n,$Ia>>2,"");$Ja=$this->carr($RR,$n,$Ka>>2,"");
		$La=$this->carr($RR,$n,$Ma>>2,"");$Na=$this->carr($RR,$n,$Oa>>2,"");
		$Pa=$this->carr($RR,$n,$Qa>>2,"");$Ra=$this->carr($RR,$n,$Sa>>2,"");
		$Ya=$this->carr($RR,$n,$Za>>2,"");
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");
		
		$jb=-188097831;continue;		
case-58343100:
		$this->aarr($RR,$n,$this->carr($RR,$n,$J>>2,"")+$this->carr($RR,$n,$za>>2,""),$this->aarr($RR,$n,$g,""));
		
		$n=75;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"");
		$na=$this->carr($RR,$n,$oa>>2,"");$pa=$this->carr($RR,$n,$qa>>2,"");
		$ra=$this->carr($RR,$n,$sa>>2,"");$ta=$this->carr($RR,$n,$ua>>2,"");
		$Ea=$this->carr($RR,$n,$Fa>>2,"")+1;
		$Ha=$this->carr($RR,$n,$Ia>>2,"");$Ja=$this->carr($RR,$n,$Ka>>2,"");
		$La=$this->carr($RR,$n,$Ma>>2,"");$Na=$this->carr($RR,$n,$Oa>>2,"");
		$Pa=$this->carr($RR,$n,$Qa>>2,"");$Ra=$this->carr($RR,$n,$Sa>>2,"");
		$Ya=$this->carr($RR,$n,$Za>>2,"");
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");
		
		$jb=-188097831;continue;		
case-275270623:
		$this->aarr($RR,$n,$this->carr($RR,$n,$J>>2,"")+$this->carr($RR,$n,$va>>2,""),$this->aarr($RR,$n,$f,""));
		
		$n=79;$p=$this->harr($RR,$q>>3,"");$la=$this->carr($RR,$n,$ma>>2,"");
		$na=$this->carr($RR,$n,$oa>>2,"");$pa=$this->carr($RR,$n,$qa>>2,"");
		$ra=$this->carr($RR,$n,$sa>>2,"");$ta=$this->carr($RR,$n,$ua>>2,"");
		$Ea=$this->carr($RR,$n,$Fa>>2,"")+1;
		$Ha=$this->carr($RR,$n,$Ia>>2,"");$Ja=$this->carr($RR,$n,$Ka>>2,"");
		$La=$this->carr($RR,$n,$Ma>>2,"");$Na=$this->carr($RR,$n,$Oa>>2,"");
		$Pa=$this->carr($RR,$n,$Qa>>2,"");$Ra=$this->carr($RR,$n,$Sa>>2,"");
		$Ya=$this->carr($RR,$n,$Za>>2,"");
		$kb=$this->carr($RR,$n,$lb>>2,"");$mb=$this->carr($RR,$n,$nb>>2,"");
		
		$jb=-188097831;		
		}
		
$tb=$mb;$ub=$kb;$vb=$Ya;$wb=$Ra;$xb=$Pa;$yb=$Na;$zb=$La;$Ab=$Ja;
$Bb=$Ha;$Cb=$Ea;$Db=$ta;$Eb=$ra;$Fb=$pa;$Gb=$na;$Hb=$la;$sb=$p;$Ib=$n;
}					
}

function Ua($a,&$RR,&$O)
			{			
			$b=$d=$e=$f=$g=$h=$i=$j=$k=$l=$m=$n=0;
			$o=$p=$q=$r=$s=$t=$u=$v=$w=$x=$y=$z=0;
			$A=$B=$C=$D=$E=$F=$G=$H=$I=$J=$K=$L=0;
			
			$nn=0;
			
			do if($a<245)
				{
				$o=$a<11?16:$a+11&-8;
				$a=$this->_rshift($o,3);
				$j=$this->carr($RR,$nn,72,"");
				$b=$this->_rshift($j,$a);
				
				if($b&3)
					{
					$b=($b&1^1)+$a;
					$d=328+($b<<1<<2);
					$e=$d+8;
					$f=$this->carr($RR,$nn,$e>>2,"");
					$g=$f+8;
					$h=$this->carr($RR,$nn,$g>>2,"");
					
					do 	if($d!=$h)
							{								
							$a=$h+12;
							
							if($this->carr($RR,$nn,$a>>2,"")==$f)
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
					$L=$f+$L+4;
					$this->carr($RR,$nn,$L>>2,$this->carr($RR,$nn,$L>>2,"")|1);

					return $g;
					} 
				
				$h=$this->carr($RR,$nn,74,"");
				
				if($o>$h)
					{
					if($b)
						{
						$d=2<<$a;
						$d=$b<<$a&($d-$d);
						$d=($d&-$d)+ -1;
						$i=$this->_rshift($d,12&16);
						$d=$this->_rshift($d,$i);
						$f=$this->_rshift($d,5&8);
						$d=$this->_rshift($d,$f);
						$g=$this->_rshift($d,2&4);
						$d=$this->_rshift($d,$g);
						$e=$this->_rshift($d,1&2);
						$d=$this->_rshift($d,$e);
						$b=$this->_rshift($d,1&1);
						$b=($f|$i|$g|$e|$b)+($this->_rshift($d,$b));
						$d=328+($b<<1<<2);
						$e=$d+8;
						$g=$this->carr($RR,$nn,$e>>2,"");
						$i=$g+8;
						$f=$this->carr($RR,$nn,$i>>2,"");
						
						do 		
							if($d!=$f)
								{
								$a=$f+12;
								
								if($this->carr($RR,$nn,$a>>2,"")==$g)
									{
									$this->carr($RR,$nn,$a>>2,$d);
									$this->carr($RR,$nn,$e>>2,$f);
									$k=$this->carr($RR,$nn,74,"");
									break;
									}
								}
							else
								{
								$this->carr($RR,$nn,72,$j&~(1<<$b));
								$k=$h;
								}
						while(0);
				
						$h=($b<<3)-$o;
						$this->carr($RR,$nn,$g+4>>2,$o|3);
						$e=$g+$o;
						$this->carr($RR,$nn,$e+4>>2,$h|1);
						$this->carr($RR,$nn,$e+$h>>2,$h);
						
						if($k)
							{
							$f=$this->carr($RR,$nn,77,"");
							$b=$this->_rshift($k,3);
							$d=328+($b<<1<<2);
							$a=$this->carr($RR,$nn,72,"");
							$b=1<<$b;
							
							if($a&$b)
								{
								$a=$d+8;
								$b=$this->carr($RR,$nn,$a>>2,"");
																	
								$l=$a;
								$m=$b;									
								}
							else
								{
								$this->carr($RR,$nn,72,$a|$b);
								$l=$d+8;
								$m=$d;
								}
								
							$this->carr($RR,$nn,$l>>2,$f);
							$this->carr($RR,$nn,$m+12>>2,$f);
							$this->carr($RR,$nn,$f+8>>2,$m);
							$this->carr($RR,$nn,$f+12>>2,$d);
							}
							
						$this->carr($RR,$nn,74,$h);
						$this->carr($RR,$nn,77,$e);

						return $i;
						}
						
					$a=$this->carr($RR,$nn,73,"");
					
					if($a)
						{
						$d=($a&-$a)+ -1;
						$K=$this->_rshift($d,12&16);
						$d=$this->_rshift($d,$K);
						$J=$this->_rshift($d,5&8);
						$d=$this->_rshift($d,$J);
						$L=$this->_rshift($d,2&4);
						$d=$this->_rshift($d,$L);
						$b=$this->_rshift($d,1&2);
						$d=$this->_rshift($d,$b);
						$e=$this->_rshift($d,1&1);
						$e=$this->carr($RR,$nn,592+(($J|$K|$L|$b|$e)+($this->_rshift($d,$e))<<2)>>2,"");
						$d=($this->carr($RR,$nn,$e+4>>2,"")&-8)-$o;
						$b=$e;
						
						while(1)
							{
							$a=$this->carr($RR,$nn,$b+16>>2,"");
							
							if(!$a)
								{
								$a=$this->carr($RR,$nn,$b+20>>2,"");
								
								if(!$a)
									{
									$j=$e;
									break;
									}
								}
								
							$b=($this->carr($RR,$nn,$a+4>>2,"")&-8)-$o;
							$L=$b<$d;
							$d=$L?$b:$d;
							$b=$a;
							$e=$L?$a:$e;
							}
							
						$g=$this->carr($RR,$nn,76,"");
							
						$i=$j+$o;
						
						$h=$this->carr($RR,$nn,$j+24>>2,"");
						$e=$this->carr($RR,$nn,$j+12>>2,"");
						
						do 
							if($e==$j)
								{
								$b=$j+20;
								$a=$this->carr($RR,$nn,$b>>2,"");
								
								if(!$a)
									{
									$b=$j+16;
									$a=$this->carr($RR,$nn,$b>>2,"");
									
									if(!$a)
										{
										$n=0;
										break;
										}
									}
									
								while(1)
									{
									$e=$a+20;
									$f=$this->carr($RR,$nn,$e>>2,"");
									
									if($f)
										{
										$a=$f;
										$b=$e;
										continue;
										}
										
									$e=$a+16;
									$f=$this->carr($RR,$nn,$e>>2,"");
									
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
								$f=$this->carr($RR,$nn,$j+8>>2,"");
								$a=$f+12;
								$b=$e+8;
								
								if(($this->carr($RR,$nn,$b>>2,""))==($j))
									{
									$this->carr($RR,$nn,$a>>2,$e);
									$this->carr($RR,$nn,$b>>2,$f);
									$n=$e;
									break;
									}
								}
						while(0);
				
						do 
							if($h)
								{
								$a=$this->carr($RR,$nn,$j+28>>2,"");
								$b=592+($a<<2);
								
								if($j==$this->carr($RR,$nn,$b>>2,""))
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
									$a=$h+16;
									
									if($this->carr($RR,$nn,$a>>2,"")==$j)
										$this->carr($RR,$nn,$a>>2,$n);
									else 	$this->carr($RR,$nn,$h+20>>2,$n);
									
									if(!$n)
										break;
									}
									
								$b=$this->carr($RR,$nn,76,"");
								$this->carr($RR,$nn,$n+24>>2,$h);
								$a=$this->carr($RR,$nn,$j+16>>2,"");
								
								do 
									if($a)
									        {
										$this->carr($RR,$nn,$n+16>>2,$a);
										$this->carr($RR,$nn,$a+24>>2,$n);
										break;
										}
									
								while(0);
							
								$a=$this->carr($RR,$nn,$j+20>>2,"");
								
								if($a)
									{
									$this->carr($RR,$nn,$n+20>>2,$a);
									$this->carr($RR,$nn,$a+24>>2,$n);
									break;
									}
								}
						while(0);
				
						
						if($d<16)
								{
								$L=$d+$o;
								$this->carr($RR,$nn,$j+4>>2,$L|3);
								$L+=$j+4;
								$this->carr($RR,$nn,$L>>2,$this->carr($RR,$nn,$L>>2,"")|1);
								}
						else
								{
								$this->carr($RR,$nn,$j+4>>2,$o|3);
								$this->carr($RR,$nn,$i+4>>2,$d|1);
								$this->carr($RR,$nn,$i+$d>>2,$d);
								$a=$this->carr($RR,$nn,74,"");
								
								if($a)
									{
									$f=$this->carr($RR,$nn,77,"");
									$b=$this->_rshift($a,3);
									$e=328+($b<<1<<2);
									$a=$this->carr($RR,$nn,72,"");
									$b=1<<$b;
									
									if($a&$b)
										{
										$a=$e+8;
										$b=$this->carr($RR,$nn,$a>>2,"");
										$p=$a;
										$q=$b;
										}
									else
										{
										$this->carr($RR,$nn,72,$a|$b);
										$p=$e+8;
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

						return $j+8;
						}
					}
				}
			else if($a<=4294967231)
				{
				$a+=11;
				$o=$a&-8;
				$j=$this->carr($RR,$nn,73,"");
				
				if($j)
					{
					$d=-$o;
					$a=$this->_rshift($a,8);
					
					if($a)	
							if($o>16777215)
								$i=31;
							else
								{
								$q=$this->_rshift(($a+1048320),16&8);
								$E=$a<<$q;
								$p=$this->_rshift(($E+520192),16&4);
								$E=$E<<$p;
								$i=$this->_rshift(($E+245760),16&2);
								$i=14-($p|$q|$i)+($E<<$this->_rshift($i,15));
								
								$i=$this->_rshift($o,($i+7)&1)|$i<<1;
								}
							
					else    	$i=0;
					
					$b=$this->carr($RR,$nn,592+($i<<2)>>2,"");
					
					do 
						if(!$b)
								{
								$a=0;
								$b=0;
								$E=86;
							        }
						else
								{
								$f=$d;
								$a=0;
								$g=$o<<($i==31?0:25-$this->_rshift($i,1));
								$h=$b;
								$b=0;
								while(1)
									{
									$e=$this->carr($RR,$nn,$h+4>>2,"")&-8;
									$d=$e-$o;
									
									if($d<$f)
										
										if($e==$o)
											{
											$a=$h;
											$b=$h;
											$E=90;
											break 2;
											}
										else    $b=$h;
										
									else    $d=$f;
									
									$e=$this->carr($RR,$nn,$h+20>>2,"");
									$h=$this->carr($RR,$nn,$h+16+($this->_rshift($g,31)<<2)>>2,"");
									$a=$e==0|$e==$h?$a:$e;
									$e=$h==0;
									
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
			
					if($E==86)
						{
						if($a==0&$b==0)
							{
							$a=2<<$i;
							$a=$j&($a-$a);
							
							if(!$a)
								break;
								
							$q=($a&-$a)+ -1;
							$m=$this->_rshift($q,12&16);
							$q=$this->_rshift($q,$m);
							$l=$this->_rshift($q,5&8);
							$q=$this->_rshift($q,$l);
							$n=$this->_rshift($q,2&4);
							$q=$this->_rshift($q,$n);
							$p=$this->_rshift($q,1&2);
							$q=$this->_rshift($q,$p);
							$a=$this->_rshift($q,1&1);
							$a=$this->carr($RR,$nn,592+(($l|$m|$n|$p|$a)+($this->_rshift($q,$a))<<2)>>2,"");
							}
							
						if(!$a)
							{
							$i=$d;
							$j=$b;
							}
						else    $E=90;
						}
						
					if($E==90)
						while(1)
							{
							$E=0;
							$q=($this->carr($RR,$nn,$a+4>>2,"")&-8)-$o;
							$e=$q<$d;
							$d=$e?$q:$d;
							$b=$e?$a:$b;
							$e=$this->carr($RR,$nn,$a+16>>2,"");
							
							if($e)
								{
								$a=$e;
								$E=90;
								continue;
								}
								
							$a=$this->carr($RR,$nn,$a+20>>2,"");
							
							if(!$a)
								{
								$i=$d;
								$j=$b;
								break;
								}
							else    $E=90;
							}
						
					if($j!=0 and $i<($this->carr($RR,$nn,74,"")-$o))
						{
						$f=$this->carr($RR,$nn,76,"");
						
						$h=$j+$o;
						$g=$this->carr($RR,$nn,$j+24>>2,"");
						$d=$this->carr($RR,$nn,$j+12>>2,"");
						
						do 
							if(($d)==($j))
								{
								$b=$j+20;
								$a=$this->carr($RR,$nn,$b>>2,"");
								
								if(!$a)
									{
									$b=$j+16;
									$a=$this->carr($RR,$nn,$b>>2,"");
									
									if(!$a)
										{
										$s=0;
										break;
										}
									}
								while(1)
									{
									$d=$a+20;
									$e=$this->carr($RR,$nn,$d>>2,"");
									
									if($e)
										{
										$a=$e;
										$b=$d;
										continue;
										}
										
									$d=$a+16;
									$e=$this->carr($RR,$nn,$d>>2,"");
									
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
								$e=$this->carr($RR,$nn,$j+8>>2,"");
									
								$a=$e+12;
								$b=$d+8;
								
								if($this->carr($RR,$nn,$b>>2,"")==$j)
									{
									$this->carr($RR,$nn,$a>>2,$d);
									$this->carr($RR,$nn,$b>>2,$e);
									$s=$d;
									break;
									}
							
								}
						while(0);
					
						do 
							if($g)
								{
								$a=$this->carr($RR,$nn,$j+28>>2,"");
								$b=592+($a<<2);
								
								if($j==$this->carr($RR,$nn,$b>>2,""))
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
									$a=$g+16;
									
									if($this->carr($RR,$nn,$a>>2,"")==$j)
										$this->carr($RR,$nn,$a>>2,$s);
									else 	$this->carr($RR,$nn,$g+20>>2,$s);
									
									if(!$s)
										break;
									}
									
								$b=$this->carr($RR,$nn,76,"");
								$this->carr($RR,$nn,$s+24>>2,$g);
								$a=$this->carr($RR,$nn,$j+16>>2,"");
								
								do 
									if($a)
										{
										$this->carr($RR,$nn,$s+16>>2,$a);
										$this->carr($RR,$nn,$a+24>>2,$s);
										break;
										}
								while(0);
							
								$a=$this->carr($RR,$nn,$j+20>>2,"");
								
								if($a)								
									{
									$this->carr($RR,$nn,$s+20>>2,$a);
									$this->carr($RR,$nn,$a+24>>2,$s);
									break;
									}
								}
						while(0);
				
						do 
							if($i>=16)
								{
								$this->carr($RR,$nn,$j+4>>2,$o|3);
								$this->carr($RR,$nn,$h+4>>2,$i|1);
								$this->carr($RR,$nn,$h+$i>>2,$i);
								$a=$this->_rshift($i,3);
								
								if($i<256)
									{
									$d=328+($a<<1<<2);
									$b=$this->carr($RR,$nn,72,"");
									$a=1<<$a;
									
									if($b&$a)
										{
										$a=$d+8;
										$b=$this->carr($RR,$nn,$a>>2,"");
										
										$u=$a;
										$v=$b;
										}
									else
										{
										$this->carr($RR,$nn,72,$b|$a);
										$u=$d+8;
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
										$K=$this->_rshift(($a+1048320),16&8);
										$L=$a<<$K;
										$J=$this->_rshift(($L+520192),16&4);
										$L=$L<<$J;
										$d=$this->_rshift(($L+245760),16&2);
										$d=14-($J|$K|$d)+($L<<$this->_rshift($d,15)); 
										$d=$this->_rshift($i,($d+7)&1)|$d<<1;
										}
										
								else    $d=0;
								
								$e=592+($d<<2);
								$this->carr($RR,$nn,$h+28>>2,$d);
								$a=$h+16;
								$this->carr($RR,$nn,$a+4>>2,0);
								$this->carr($RR,$nn,$a>>2,0);
								$a=$this->carr($RR,$nn,73,"");
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
									
								$f=$i<<($d==31?0:25-$this->_rshift($d,1));
								$a=$this->carr($RR,$nn,$e>>2,"");
								
								while(1)
									{
									if(($this->carr($RR,$nn,$a+4>>2,"")&-8)==$i)
											{
											$d=$a;
											$E=148;
											break;
											}
										
									$b=$a+16+($this->_rshift($f,31)<<2);
									$d=$this->carr($RR,$nn,$b>>2,"");
									
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
									
								if($E==145)
									{
									$this->carr($RR,$nn,$b>>2,$h);
									$this->carr($RR,$nn,$h+24>>2,$a);
									$this->carr($RR,$nn,$h+12>>2,$h);
									$this->carr($RR,$nn,$h+8>>2,$h);
									break;
									}
								else 	
									if($E==148)
										{
										$a=$d+8;
										$b=$this->carr($RR,$nn,$a>>2,"");
										$L=$this->carr($RR,$nn,76,"");
										
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
								$L=$i+$o;
								$this->carr($RR,$nn,$j+4>>2,$L|3);
								$L+=$j+4;
								$this->carr($RR,$nn,$L>>2,$this->carr($RR,$nn,$L>>2,"")|1);
								}
						while(0);

						return $j+8;
						}
					}
				}
			else    $o=-1;
			
			while (0);
	
			$d=$this->carr($RR,$nn,74,"");
				
			if($d>=$o)
				{
				$a=$d-$o;
				$b=$this->carr($RR,$nn,77,"");
				
				if($a>15)
					{
					$L=$b+$o;
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
					$L=$b+$d+4;
					$this->carr($RR,$nn,$L>>2,$this->carr($RR,$nn,$L>>2,"")|1);
					}

				return $b+8;
				}
				
			$a=$this->carr($RR,$nn,75,"");
				
			if($a>$o)
				{				
				$J=$a-$o;
				$this->carr($RR,$nn,75,$J);
				$L=$this->carr($RR,$nn,78,"");
				$K=$L+$o;
				$this->carr($RR,$nn,78,$K);
			
				$this->carr($RR,$nn,$K+4>>2,$J|1); 
				$this->carr($RR,$nn,$L+4>>2,$o|3);

				return $L+8;
				}
				
			do 
				if(!($this->carr($RR,$nn,190,"")))
					{
					$a=4096;
					$this->carr($RR,$nn,192,$a);
					$this->carr($RR,$nn,191,$a);
					$this->carr($RR,$nn,193,-1);
					$this->carr($RR,$nn,194,-1);
					$this->carr($RR,$nn,195,0);
					$this->carr($RR,$nn,183,0);
					$this->carr($RR,$nn,190,$this->ma(0,$RR)&-16^1431655768);
					break;
					}
			 while(0);
			 
			$h=$o+48;
			$g=$this->carr($RR,$nn,192,"");
			$i=$o+47;
			$f=$g+$i;
			$g=-$g;
			$j=$f&$g;
			
			if($j<=$o)				
				return 0;
								
			$a=$this->carr($RR,$nn,182,"");
			
			if($a)
				{
				$u=$this->carr($RR,$nn,180,"");
				$v=$u+$j;
				
				if ($v<=$u|$v>$a)					
					return 0;					
				}
			do 	
				if(!($this->carr($RR,$nn,183,"")&4))
					{
					$a=$this->carr($RR,$nn,78,"");
					
					do 
						if($a)
							{
							$d=736;
							while(1)
								{
								$b=$this->carr($RR,$nn,$d>>2,"");
								
								if($b<=$a)
									{
									$r=$d+4;
									if (($b+$this->carr($RR,$nn,$r>>2,""))>$a)
										{
										$e=$d;
										$d=$r;
										break;
										}
									}
									
								$d=$this->carr($RR,$nn,$d+8>>2,"");
								
								if(!$d)
									{
									$E=173;
									break 2;
									}
								}
							$a=$f-($this->carr($RR,$nn,75,""))&$g;
							
							if($a<2147483647)
								{
								$b=$this->la($a,$O);
								
								if($b==($this->carr($RR,$nn,$e>>2,"")+$this->carr($RR,$nn,$d>>2,"")))
									{
									if($b!=-1)
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
						 if($E==173)
						 	{
						 	$t=$this->la(0,$O);
							 
							if ($t!=-1)
								{
								$a=$t;
								$b=$this->carr($RR,$nn,191,"");
								$d=$b-1;
								
								if(!($d&$a))
									$a=$j;
								else 	$a=$j-$a+($d+$a&-$b);
								
								$b=$this->carr($RR,$nn,180,"");
								$d=$b+$a;
								
								if($a>$o&$a<2147483647)
									{
									$v=$this->carr($RR,$nn,182,"");
									
									if($v and ($d<=$b|$d>$v))
										break;
										
									$b=$this->la($a,$O);
									
									if($b==$t)
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
						 if($E==183)
							{
							$d=-$a;
							
							do 	
								 if($h>$a&($a<2147483647&$b!=-1))
									 {
									 $w=$this->carr($RR,$nn,192,"");
									 $w=$i-$a+$w&-$w;
									 
									 if ($w<2147483647)
										 {
										 if($this->la($w,$O)==-1)
											{
											$this->la($d,$O);
											break 2;
											}
										 }
									}
								 else
									{
									$a+=$w;
									break;
									}	
								        
							while(0);
									
							if($b!=-1)
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

			
			if ($E==190 and $j<2147483647)
				{			
				$x=$this->la($j,$O);
				$y=$this->la(0,$O);
								
				if ($x<$y&$x!=-1&$y!=-1)
					{			
					$z=$y-$x;
					
					if ($z>($o+40))				
						{
						$h=$x;
						$f=$z;
						$E=193;
						}
					}
				}
				
			if($E==193)
				{
				$a=$this->carr($RR,$nn,180,"")+$f;
				$this->carr($RR,$nn,180,$a);
				
				if($a>$this->carr($RR,$nn,181,""))
					$this->carr($RR,$nn,181,$a);
					
				$i=$this->carr($RR,$nn,78,"");
				
				do  
				
				if($i)
					{
					$e=736;
					
					do 
						{
						$a=$this->carr($RR,$nn,$e>>2,"");
						$b=$e+4;
						$d=$this->carr($RR,$nn,$b>>2,"");
						
						if(($h)==($a+$d))
							{
							$A=$a;
							$B=$b;
							$C=$d;
							$D=$e;
							$E=203;
							break;
							}
							
						$e=$this->carr($RR,$nn,$e+8>>2,"");
						}
					while($e!=0);
					
					if($E==203 and ($this->carr($RR,$nn,$D+12>>2,"")&8)==0 and $i<$h and $i>=$A)
						{
						$this->carr($RR,$nn,$B>>2,$C+$f);
						$L=$i+8;
						$L=($L&7)==0?0:-$L&7;
						$K=$i+$L;
						$L=$f-$L+($this->carr($RR,$nn,75,""));
						$this->carr($RR,$nn,78,$K);
						$this->carr($RR,$nn,75,$L);
						$this->carr($RR,$nn,$K+4>>2,$L|1);
						$this->carr($RR,$nn,$K+$L+4>>2,40);
						$this->carr($RR,$nn,79,$this->carr($RR,$nn,194,""));
						break;
						}
						
					$a=$this->carr($RR,$nn,76,"");
					
					if($h<$a)
						{
						$this->carr($RR,$nn,76,$h);
						$j=$h;
						}
					else    $j=$a;
					
					$d=$h+$f;
					$a=736;
					
					while(1)
						{
						if($this->carr($RR,$nn,$a>>2,"")==$d)
							{
							$b=$a;
							$E=211;
							break;
							}
							
						$a=$this->carr($RR,$nn,$a+8>>2,"");
						
						if(!$a)
							{
							$b=736;
							break;
							}
						}
						
					if($E==211)
						{
						if(!($this->carr($RR,$nn,$a+12>>2,"")&8))
							{
							$this->carr($RR,$nn,$b>>2,$h);
							$l=$a+4;
							$this->carr($RR,$nn,$l>>2,$this->carr($RR,$nn,$l>>2,"")+$f);
							$l=$h+8;
							$l=$h+(($l&7)==0?0:-$l&7);
							$a=$d+8;
							$a=$d+(($a&7)==0?0:-$a&7);
							$k=$l+$o;
							$g=$a-$l-$o;
							$this->carr($RR,$nn,$l+4>>2,$o|3);
							
							do 
							 
							 if($a!=$i)
								{
								if($a==$this->carr($RR,$nn,77,""))
									{
									$L=($this->carr($RR,$nn,74,""))+$g;
									$this->carr($RR,$nn,74,$L);
									$this->carr($RR,$nn,77,$k);
									$this->carr($RR,$nn,$k+4>>2,$L|1);
									$this->carr($RR,$nn,$k+$L>>2,$L);
									break;
									}
									
								$b=$this->carr($RR,$nn,$a+4>>2,"");
								
								if(($b&3)==1)
									{
									$i=$b&-8;
									$f=$this->_rshift($b,3);
									
									do  
									
									 if($b>=256)
										{
										$h=$this->carr($RR,$nn,$a+24>>2,"");
										$e=$this->carr($RR,$nn,$a+12>>2,"");
										do 
											
											 if($e==$a)
												{
												$d=$a+16;
												$e=$d+4;
												$b=$this->carr($RR,$nn,$e>>2,"");
												
												if(!$b)
													{
													$b=$this->carr($RR,$nn,$d>>2,"");
													if(!$b)
														{
														$J=0;
														break;
														}
													}
												else    $d=$e;
												
												while(1)
													{
													$e=$b+20;
													$f=$this->carr($RR,$nn,$e>>2,"");
													
													if($f)
														{
														$b=$f;
														$d=$e;
														continue;
														}
														
													$e=$b+16;
													$f=$this->carr($RR,$nn,$e>>2,"");
													
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
												$f=$this->carr($RR,$nn,$a+8>>2,"");
												$b=$f+12;
												$d=$e+8;
												
												$this->carr($RR,$nn,$b>>2,$e);
												$this->carr($RR,$nn,$d>>2,$f);
												$J=$e;
												break;
												}
										while(0);
									
										if(!$h)
											break;
										
										$b=$this->carr($RR,$nn,$a+28>>2,"");
										$d=592+($b<<2);
										
										do 
											
											if($a!=$this->carr($RR,$nn,$d>>2,""))
												{	
												$b=$h+16;
												
												if(($this->carr($RR,$nn,$b>>2,""))==($a))
													$this->carr($RR,$nn,$b>>2,$J);
												else 	$this->carr($RR,$nn,$h+20>>2,$J);
												
												if(!$J)
													break 3;
												}
											else
												{
												$this->carr($RR,$nn,$d>>2,$J);
												
												if($J)
													break;
													
												$this->carr($RR,$nn,73,$this->carr($RR,$nn,73,"")&~(1<<$b));
												break 3;
												}
										while(0) ;
									
										$e=$this->carr($RR,$nn,76,"");
										$this->carr($RR,$nn,$J+24>>2,$h);
										$b=$a+16;
										$d=$this->carr($RR,$nn,$b>>2,"");
										
										do 	
											if($d)
												{
												$this->carr($RR,$nn,$J+16>>2,$d);
												$this->carr($RR,$nn,$d+24>>2,$J);
												break;
												}
										while(0);
									
										$b=$this->carr($RR,$nn,$b+4>>2,"");
										
										if(!$b)
											break;
											
										$this->carr($RR,$nn,$J+20>>2,$b);
										$this->carr($RR,$nn,$b+24>>2,$J);
										break;
										}
									else
										{
										$d=$this->carr($RR,$nn,$a+8>>2,"");
										$e=$this->carr($RR,$nn,$a+12>>2,"");
										$b=328+($f<<1<<2);
										
										do 	
											 if($d!=$b)
												{	
												if($this->carr($RR,$nn,$d+12>>2,"")==$a)
													break;
												}
										while(0);
									
										if($e==$d)
											{
											$this->carr($RR,$nn,72,$this->carr($RR,$nn,72,"")&~(1<<$f));
											break;
											}
											
										do 											
											if($e==$b)
												$G=$e+8;
											else
												{	
												$b=$e+8;
												
												if($this->carr($RR,$nn,$b>>2,"")==$a)
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
							
									$a+=$i;
									$g+=$i;
									}
									
								$a+=4;
								$this->carr($RR,$nn,$a>>2,$this->carr($RR,$nn,$a>>2,"")&-2);
								$this->carr($RR,$nn,$k+4>>2,$g|1);
								$this->carr($RR,$nn,$k+$g>>2,$g);
								$a=$this->_rshift($g,3);
								
								if($g<256)
									{
									$d=328+($a<<1<<2);
									$b=$this->carr($RR,$nn,72,"");
									$a=1<<$a;
									
									do 	
										 if(!($b&$a))
											{
											$this->carr($RR,$nn,72,$b|$a);
											$K=$d+8;
											$L=$d;
											}
										 else
											{
											$a=$d+8;
											$b=$this->carr($RR,$nn,$a>>2,"");
											if($b>=$this->carr($RR,$nn,76,""))
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
											
										$K=$this->_rshift($a+1048320,16)&8;
										$L=$a<<$K;
										$J=$this->_rshift($L+520192,16)&4;
										$L=$L<<$J;
										$d=$this->_rshift($L+245760,16)&2;
										$d=14-($J|$K|$d)+($L<<$this->_rshift($d,15));
										$d=$this->_rshift($g,$d+7)&1|$d<<1;
										}
								while(0);
									
						
								$e=592+($d<<2);
								$this->carr($RR,$nn,$k+28>>2,$d);
								$a=$k+16;
								$this->carr($RR,$nn,$a+4>>2,0);
								$this->carr($RR,$nn,$a>>2,0);
								$a=$this->carr($RR,$nn,73,"");
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
									
								$f=$g<<($d==31?0:25-($this->_rshift($d,1)));
								$a=$this->carr($RR,$nn,$e>>2,"");
								
								while(1)
									{
									if(($this->carr($RR,$nn,$a+4>>2,"")&-8)==$g)
										{
										$d=$a;
										$E=281;
										break;
										}
										
									$b=$a+16+($this->_rshift($f,31)<<2);
									$d=$this->carr($RR,$nn,$b>>2,"");
									
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
									
								if($E==278)
									{
									$this->carr($RR,$nn,$b>>2,$k);
									$this->carr($RR,$nn,$k+24>>2,$a);
									$this->carr($RR,$nn,$k+12>>2,$k);
									$this->carr($RR,$nn,$k+8>>2,$k);
									break;
									}
								else 
									{
									if($E==281)
										{
										$a=$d+8;
										$b=$this->carr($RR,$nn,$a>>2,"");
										$L=$this->carr($RR,$nn,76,"");
										
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
								$L=$this->carr($RR,$nn,75,"")+$g;
								$this->carr($RR,$nn,75,$L);
								$this->carr($RR,$nn,78,$k);
								$this->carr($RR,$nn,$k+4>>2,$L|1);
								}
						while(0);
						
						return $l+8;
						}
					else $b=736;
					}
					
					while(1)
						{
						$a=$this->carr($RR,$nn,$b>>2,"");
						if($a<=$i and $this->_rshift(($F=$a+($this->carr($RR,$nn,$b+4>>2,""))),0)>$i)
							{
							$b=$F;
							break;
							}
							
						$b=$this->carr($RR,$nn,$b+8>>2,"");
						}
						
					$g=$b-47;
					$d=$g+8;
					$d=$g+(($d&7)==0?0:-$d&7);
					$g=$i+16;
					$d=$d<$g?$i:$d;
					$a=$d+8;
					$e=$h+8;
					$e=($e&7)==0?0:-$e&7;
					$L=$h+$e;
					$e=$f-4-$e;
					$this->carr($RR,$nn,78,$L);
					$this->carr($RR,$nn,75,$e);
					$this->carr($RR,$nn,$L+4>>2,$e|1);
					$this->carr($RR,$nn,$L+$e+4>>2,40);
					$this->carr($RR,$nn,79,$this->carr($RR,$nn,194,""));
					$e=$d+4;
					$this->carr($RR,$nn,$e>>2,27);
					$this->carr($RR,$nn,$a>>2,$this->carr($RR,$nn,184,""));
					$this->carr($RR,$nn,$a+4>>2,$this->carr($RR,$nn,185,""));
					$this->carr($RR,$nn,$a+8>>2,$this->carr($RR,$nn,186,""));
					$this->carr($RR,$nn,$a+12>>2,$this->carr($RR,$nn,187,""));
					$this->carr($RR,$nn,184,$h);
					$this->carr($RR,$nn,185,$f);
					$this->carr($RR,$nn,187,0);
					$this->carr($RR,$nn,186,$a);
					$a=$d+24;
					
					do
						{
						$a+=4;
						$this->carr($RR,$nn,$a>>2,7);
						}
					while(($a+4)<$b);
					
					if($d!=$i)
						{
						$h=$d-$i;
						$this->carr($RR,$nn,$e>>2,$this->carr($RR,$nn,$e>>2,"")&-2);
						$this->carr($RR,$nn,$i+4>>2,$h|1);
						$this->carr($RR,$nn,$d>>2,$h);
						$a=$this->_rshift($h,3);
						
						if($h<256)
							{
							$d=328+($a<<1<<2);
							$b=$this->carr($RR,$nn,72,"");
							$a=1<<$a;
							
							if($b&$a)
								{
								$a=$d+8;
								$b=$this->carr($RR,$nn,$a>>2,"");
								$H=$a;
								$I=$b;	
								}
							else
								{
								$this->carr($RR,$nn,72,$b|$a);
								$H=$d+8;
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
							if($h>16777215)
								$d=31;
							else
								{
								$K=$this->_rshift(($a+1048320),16)&8;
								$L=$a<<$K;
								$J=$this->_rshift(($L+520192),16)&4;
								$L=$L<<$J;
								$d=$this->_rshift(($L+245760),16)&2;
								$d=14-($J|$K|$d)+($L<<$this->_rshift($d,15));
								$d=$this->_rshift($h,($d+7))&1|$d<<1;
								}
							}
						else    $d=0;
						
						$f=592+($d<<2);
						$this->carr($RR,$nn,$i+28>>2,$d);
						$this->carr($RR,$nn,$i+20>>2,0);
						$this->carr($RR,$nn,$g>>2,0);
						$a=$this->carr($RR,$nn,73,"");
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
							
						$e=$h<<(($d)==31?0:25-($this->_rshift($d,1)));
						$a=$this->carr($RR,$nn,$f>>2,"");
						
						while(1)
							{
							if(($this->carr($RR,$nn,$a+4>>2,"")&-8)==($h))
								{
								$d=$a;
								$E=307;
								break;
								}
								
							$b=$a+16+($this->_rshift($e,31)<<2);
							$d=$this->carr($RR,$nn,$b>>2,"");
							
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
							
						if($E==304)
							{
							$this->carr($RR,$nn,$b>>2,$i);
							$this->carr($RR,$nn,$i+24>>2,$a);
							$this->carr($RR,$nn,$i+12>>2,$i);
							$this->carr($RR,$nn,$i+8>>2,$i);
							break;
							}
						else 
							{
							if($E==307)
								{
								$a=$d+8;
								$b=$this->carr($RR,$nn,$a>>2,"");
								$L=$this->carr($RR,$nn,76,"");
								
								if($b>=$L&$d>=$L)
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
					$L=$this->carr($RR,$nn,76,"");
					
					if($L==0|$h<$L)
						$this->carr($RR,$nn,76,$h);
						
					$this->carr($RR,$nn,184,$h);
					$this->carr($RR,$nn,185,$f);
					$this->carr($RR,$nn,187,0);
					$this->carr($RR,$nn,81,$this->carr($RR,$nn,190,""));
					$this->carr($RR,$nn,80,-1);
					
					$a=0;
					
					do 
						{
						$L=328+($a<<1<<2);
						$this->carr($RR,$nn,$L+12>>2,$L);
						$this->carr($RR,$nn,$L+8>>2,$L);
						$a++;
						}
					while(($a)!=32);
					
					$L=$h+8;
					$L=($L&7)==0?0:-$L&7;
					$K=$h+$L;
					$L=$f-4-$L;
					$this->carr($RR,$nn,78,$K);
					$this->carr($RR,$nn,75,$L);
					$this->carr($RR,$nn,$K+4>>2,$L|1);
					$this->carr($RR,$nn,$K+$L+4>>2,40);
					$this->carr($RR,$nn,79,$this->carr($RR,$nn,194,""));
					}
					
				while(0);
			
				$a=$this->carr($RR,$nn,75,"");
				
				if($a>$o)
					{
					$J=$a-$o;
					$this->carr($RR,$nn,75,$J);
					$L=$this->carr($RR,$nn,78,"");
					$K=$L+$o;
					$this->carr($RR,$nn,78,$K);
					$this->carr($RR,$nn,$K+4>>2,$J|1);
					$this->carr($RR,$nn,$L+4>>2,$o|3);
					return $L+8;
					}
				}
				
			$this->carr($RR,$nn,0>>2,12);
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
		$f=$g=$h=$i=0;
		$f=$b+$e;
		if($e>=20)
			{
			$d=$d&255;
			$h=$b&3;
			$i=$d|$d<<8|$d<<16|$d<<24;
			$g=$f&~3;
			if($h)
				{
				$h=$b+4-$h;
				while(($b)<($h))
					{
					$this->aarr($R,$b,$b,$d);
					$b++;
					}
				}
			while($b<($g))
				{
				$this->carr($R,$b,$b>>2,$i);
				$b+=4;
				}
			}
		while(($b)<($f))
			{
			$this->aarr($R,$b,$b,$d);
			$b++;
			}
		return $b-$e;
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
		
		$u=$this->Id($str);		
		$v=$this->X($R,$O,$u);		
		$w=$this->Ia($v,$R,$O);		
		$x=$this->Pb($R,$w);
		
		return $x;
		}
}

	$str= "/vms?key=fvip&src=01010031010000000000&tvId=597396500&vid=515e35fcd99b69f571d0f1e762ca2ce0&vinfo=1&tm=506&qyid=0e53b94433a4b1bdeec0b5b3f56975f5&puid=&authKey=8df6571453fcda5c33a53d508c00e9d5&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdv=2";

	$a=new iqiyi();
	
	echo $a->getvf($str);;	
?>	
