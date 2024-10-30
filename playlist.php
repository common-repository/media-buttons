<?
// Make a playlist given IP, port, and format
// format paramaters can be either ASX, PLS, M3U, RAM
// Call file like so:
// /singleplaylist.php?ip=123.45.67.89&port=8000&format=ASX
// Author: Joseph Geyer
// Email: silentjoe@silentjoe.com
// (Originally titled makelist.php)

$ip = $_GET['ip'];
$format = $_GET['format'];
$mountpoint = $_GET['mountpoint'];

$ip = strip_tags($ip);
$port = strip_tags($port);
$format = strip_tags($format);

switch($format) {
  case 'ASX': // show ASX output
         header('Content-Type: video/x-ms-asf; name="playlist.asx"');
	 	   header('Content-Transfer-Encoding: 7bit');
         header('Content-Disposition: attachment; filename="playlist.asx"');
         echo "<ASX version = \"3.0\">\r\n<Entry>\r\n";
         echo "<REF HREF=\"http://$ip/$mountpoint\" />\r\n";
         echo "</Entry>\r\n</ASX>\r\n";
        break;
  case 'M3U': // show M3U output
         header('Content-Type: audio/mpegurl; name="playlist.m3u"');
		   header('Content-Transfer-Encoding: 7bit');
         header('Content-Disposition: attachment; filename="playlist.m3u"');
         echo "#EXTM3U\r\n";
         echo "#EXTINF:-1,Live Station\r\n";
         echo "http://$ip/$mountpoint\r\n";
       break;
  case 'PLS': // show PLS output
         header('Content-Type: audio/x-scpls; name="playlist.pls"');
			header('Content-Transfer-Encoding: 7bit');
         header('Content-Disposition: attachment; filename="playlist.pls"');
         echo "[playlist]\r\n";
         echo "NumberOfEntries=1\r\n";
         echo "File1=http://$ip/$mountpoint\r\n";
         echo "Version=2";
         break;
 case 'RAM': // show RAM output
         header('Content-Type: audio/x-pn-realaudio; name="playlist.ram"');
			header('Content-Transfer-Encoding: 7bit');
         header('Content-Disposition: attachment; filename="playlist.ram"');
         echo "http://$ip/$mountpoint\r\n";
         break;
  default: // no playlist format selected
      echo 'No playlist selected';
      break;
}
