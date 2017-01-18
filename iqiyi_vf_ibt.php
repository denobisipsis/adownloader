<?
/*
from http://static.iqiyi.com/js/player_v1/pcweb.wonder.js where the cmd5x algorithm is stored as packed eval

this class computes the vf value in the call

http://cache.video.qiyi.com/vms?key=fvip&src=01010031010010000000&tvId=496130600&vid=12078ce069daab217b2632248272d722&vinfo=1&tm=506&qyid=&puid=&authKey=a6e3cd72befb37d067d2d684d74855b9&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdv=2&vf=7fff3565c6d525f625776630d571134f

where the relevant part is 

/vms?key=fvip&src=01010031010010000000&tvId=496130600&vid=12078ce069daab217b2632248272d722&vinfo=1&tm=506&qyid=&puid=&authKey=a6e3cd72befb37d067d2d684d74855b9&um=0&pf=b6c13e26323c537d&thdk=&thdt=&rs=1&k_tag=1&qdv=2


the same for ibt
*/
