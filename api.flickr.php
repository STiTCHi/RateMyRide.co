 <?php
  $params = array(
'api_key'   => 'b0fe6d2eb3d67fd208d5c2775830f274',
'method'    => 'flickr.photos.search',
'text'      => 'toyota mr2',
'extras'    => 'original_format, geo'
  );
  $encoded_params = array();
  foreach ($params as $k => $v){ $encoded_params[] = urlencode($k).'='.urlencode($v); }

   $ch = curl_init();
   $timeout = 5; // set to zero for no timeout
   curl_setopt ($ch, CURLOPT_URL, 'https://api.flickr.com/services/rest/?'.implode('&',             $encoded_params));
   curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
   //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   $file_contents = curl_exec($ch);
   curl_close($ch);

   echo $file_contents;

   $rsp_obj = unserialize($file_contents);

   if ($rsp_obj['stat'] == 'ok') {

    $photos = $rsp_obj["photos"]["photo"];

echo "
     <ul>";

foreach($photos as $photo) {

           $farm              = $photo['farm'];
           $server            = $photo['server'];
           $photo_id          = $photo['id'];
           $secret            = $photo['secret'];
           $photo_title       = $photo['title'];

         echo '<li><img          src="http://farm'.$photo['farm'].'.static.flickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'_t.jpg" alt="'.$photo['title'].'" ></li>';

     }
       echo "
           </ul>

            ";

} else {
        echo "Error getting photos";
   }
   ?>