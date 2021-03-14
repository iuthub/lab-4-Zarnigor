<?php 
$playlist = $_REQUEST['playlist'];
$shuffle = $_REQUEST['shuffle'];  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Music Viewer</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="viewer.css" type="text/css" rel="stylesheet" />
  </head>
  <body>
    <div id="header">

      <h1>190M Music Playlist Viewer</h1>
      <h2>Search Through Your Playlists and Music</h2>
    </div>
    <div id="listarea">
    <?php
    
    $music_items = [];
    if (isset($shuffle)&& $shuffle&& $shuffle !=NULL && $shuffle !="")
    {
    	$shuffle = "songs/". $shuffle;
    	if($file){ 
    		while(!feof($file)) {

	          $string = trim(fgets($file));
	          if (preg_match("/(\.mp3)$/", $string))
	          $music_items[] = "songs/" . $string;
	          
	          }
	          		shuffle($music_items);
   
	      }
	  }
        else{
      		$music_items = glob("songs/*.mp3");
			}

    if (isset($playlist) && $playlist && $playlist != NULL && $playlist != "")
    {
      $playlist = "songs/" . $playlist;
      $file = fopen($playlist,"r");
      if ($file)
      {
        while(!feof($file)) {
          $string = trim(fgets($file));
          if (preg_match("/(\.mp3)$/", $string))
            $music_items[] = "songs/" . $string;
        }
        fclose($file);
      }
    ?>  
        <button onclick="history.go(-1);">Back </button>
        <?php
    } else {
      $music_items = glob("songs/*.mp3");
    }
    foreach ($music_items as $filename) { ?>
      <ul>
        <li class="mp3item">
          <a href="<?=$filename?>">
          <?=basename($filename)?>
          <?php
          $size=filesize(trim($filename));
          //var_dump($filename);
          if($size <1023){
            $size= round($size, 2);
            print(" " . $size . "b");
          }
          elseif ($size>1023 && $size <1048575){
            $size/=1024;
            $size=round($size, 2);
            print(" " . $size . "Kb");
            # code...
          }
          elseif ($size>1048576){
            $size=$size/pow(1024, 2);
            $size=round($size, 2);
            print(" " . $size . "Mb");
            # code...
          }
          ?>
          </a>
        </li>
      </ul>  
    <?php }
    if (!isset($playlist) || !$playlist || $playlist == NULL || $playlist == "")
    foreach (glob("songs/*.m3u") as $filename) { ?>
      <ul>
        <li class= "playlistitem">
          <a href="<?=$filename?>">
          <?=basename($filename)?>
          </a>
        </li> 
      </ul>
    <?php } ?>  
    </div>
  </body>
</html>