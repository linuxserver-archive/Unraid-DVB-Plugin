<?php

#Variables 
$mediaPaths['tempFiles']  = "/tmp/mediabuild";
$mediaPaths['sources'] = $mediaPaths['tempFiles']."/sources.json";
$mediaPaths['reboot'] = $mediaPaths['tempFiles']."/reboot";

#If temp dir does not exist then create.
if ( ! is_dir($mediaPaths['tempFiles']) ) {
  exec("mkdir -p ".$mediaPaths['tempFiles']);
}

function download_url($url, $path = "", $bg = false){
  exec("curl --max-time 60 --silent --insecure --location --fail ".($path ? " -o '$path' " : "")." $url ".($bg ? ">/dev/null 2>&1 &" : "2>/dev/null"), $out, $exit_code );
  return ($exit_code === 0 ) ? implode("\n", $out) : false;
}

switch ($_POST['action']) {

case 'show_description':
  $build = isset($_POST['build']) ? urldecode(($_POST['build'])) : false;

  $sources = json_decode(file_get_contents($mediaPaths['sources']),true);

  echo "<font size='2'>".$sources[$build]['imageDescription']."</font>";;
  break;

#Sets Text to be displayed in Dropdown Menu
case 'build_buttons':
  $types['ddexp']        = "Digital Devices (Experimental)";
  $types['dd']           = "Digital Devices (Github)";
  $types['libreelec']    = "LibreELEC";
  $types['openelec']     = "OpenELEC";
  $types['tbs']          = "TBS (Official) DVB-S(2) and DVB-T(2)";
  $types['tbs-dvbst']    = "TBS (Official) DVB-S(2) and DVB-T(2)";
  $types['tbs-dvbc']     = "TBS (Official) DVB-C";
  $types['crazy-dvbst']  = "TBS (CrazyCat) DVB-S(2) and DVB-T(2)";
  $types['crazy-dvbc']   = "TBS (CrazyCat) DVB-C";
  $types['tbs-os-dvbst'] = "TBS (Open Source) DVB-S(2) and DVB-T(2)";
  $types['tbs-os-dvbc']  = "TBS (Open Source) DVB-C";
  $types['stock']        = "unRaid";
  
  
  $downloadURL = "http://files.linuxserver.io/unraid-dvb/";
  $tempFile = $mediaPaths['tempFiles']."/temp";
  $description = $mediaPaths['tempFiles']."/description";

  @unlink($tempFile);
  
  download_url($downloadURL, $tempFile);

  if ( ! is_file($tempFile) ) {
    echo "Error Downloading Source Files";
    break;
  }
  
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
          
# now get the description

            download_url($mediaTypes['imageURL']."/unraid-media",$description);
 
            if ( is_file($description) ) {
              $mediaTypes['imageDescription'] = $tempVar = parse_ini_file($description); 
			  $mediaTypes['imageDescription'] = "This will install the ".$tempVar['base']." unRAID DVB build with V".$tempVar['driver']. " drivers";
            } else {
              $mediaTypes['imageDescription'] = "This will install stock unRAID";
            }
          
            @unlink($description);
          
            $mediaVersions[] = $mediaTypes;

          }
        }
      }
    }
  }

  unlink($tempFile);

  $build = array();
  foreach ($mediaVersions as $key => $row){
    $build[$key] = $row['imageType'];
  }
  array_multisort($build, SORT_ASC, $mediaVersions);


  file_put_contents($mediaPaths['sources'],json_encode($mediaVersions, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

# set to true for separate menus, or false for all in one
# doesn't really work for true

  $separate = false;  

  exec('mkdir -p "'.$mediaPaths['tempFiles'].'"');

  if ( is_file($mediaPaths['reboot']) )
  {
    $reboot = "true";
  }


  $sources = json_decode(file_get_contents($mediaPaths['sources']),true);
  $i = 0;
  foreach ($sources as $source)
  {
    $source['id'] = $i;
    if ( $source['imageType'] == "unRaid" )
    {
      $buttons['unRaid']['name'] = "unRaid";
      $buttons['unRaid']['builds'][] = $source;
    } else {
      $buttons['MediaBuilds']['name'] = "Media Builds";
      $buttons['MediaBuilds']['builds'][] = $source;
    }
    $i = ++$i;
  }

  foreach ( $buttons as $button )
  {
    if ( $button['name'] == "unRaid" )
    {
      $o .= "Stock unRaid Builds: <select id='unRaid' onchange='showDescription0(value);'>";
    } else {
      $o .= "DVB unRAID Builds: <select id='Media' onchange='showDescription1(value);'>";
    }

    $o .= "<option value='default' disabled selected>Select an image to install</option>";
    foreach ($button['builds'] as $option)
    {
      $o .= '<option value="'.$option['id'].'" onselect="showDescription();">'.$option['imageType'].' '.$option['imageVersion'].'</option>';
    }
    $o .= "</select>";
  }
  echo $o;
  break;

case "check_reboot":
  if ( is_file("/tmp/mediabuild/reboot") ) {
    echo "reboot required";
  }
  break;
}
?>
