#!/usr/bin/php
<?

$types['ddexp']    = "DDExp";
$types['openelec'] = "OpenElec";
$types['tbs']      = "TBS";
$types['stock']    = "unRaid";


function download_url($url, $path = "", $bg = false){
  exec("curl --max-time 60 --silent --insecure --location --fail ".($path ? " -o '$path' " : "")." $url ".($bg ? ">/dev/null 2>&1 &" : "2>/dev/null"), $out, $exit_code );
  return ($exit_code === 0 ) ? implode("\n", $out) : false;
}

$downloadURL = "http://files.linuxserver.io/mediabuild/";
$tempFile = "/tmp/mediabuild.tmp";
download_url($downloadURL, $tempFile);

$contents = explode("\n",file_get_contents($tempFile));

foreach ($contents as $line) {
  if ( strpos($line,"href") ) {
    if ( preg_match('/"([^"]+)"/', $line, $m) ) {
      $versionInfo['unRaidVersion'] = $m[1];
      $versionInfo['basePath'] = $downloadURL.$m[1];
      $versions[] = $versionInfo;
    }
  }
}
unset($versions[0]);

foreach ( $versions as $unRaidVersion) {
  download_url($unRaidVersion['basePath'],$tempFile);

  $contents = explode("\n",file_get_contents($tempFile));
  unset($mediaTemp);
  foreach ($contents as $line) {
    if ( strpos($line,"href") ) {
      if ( preg_match('/"([^"]+)"/', $line, $m) ) {
        if ( ! stripos($line,"parent") ) {
          $type = str_replace("/","",$m[1]);
          if ( $types[$type] ) {
            $mediaTypes['imageType'] = $types[$type];
          } else {
            $mediaTypes['imageType'] = $type;
          }

          $mediaTypes['imageURL'] = $unRaidVersion['basePath'].$m[1];
          $mediaTypes['imageVersion'] = str_replace("-",".",$unRaidVersion['unRaidVersion']);
          $mediaTypes['imageVersion'] = str_replace("/","",$mediaTypes['imageVersion']);
          $mediaVersions[] = $mediaTypes;
        }
      }
    }
  }
}
print_r($mediaVersions);
?>
