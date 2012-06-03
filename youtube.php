<?php
// function to parse a video <entry> 

function parseVideoEntry($entry) 
{       
      $obj= new stdClass; 
       
      // get nodes in media: namespace for media information 
      $media = $entry->children('http://search.yahoo.com/mrss/'); 
      $obj->title = $media->group->title; 
      $obj->description = $media->group->description; 
       
      // get video player URL 
      $attrs = $media->group->player->attributes(); 
      $obj->watchURL = $attrs['url'];  
       
      // get video thumbnail 
      $attrs = $media->group->thumbnail[0]->attributes(); 
      $obj->thumbnailURL = $attrs['url'];  
             
      // get <yt:duration> node for video length 
      $yt = $media->children('http://gdata.youtube.com/schemas/2007'); 
      $attrs = $yt->duration->attributes(); 
      $obj->length = $attrs['seconds'];  
       
      // get <yt:stats> node for viewer statistics 
      $yt = $entry->children('http://gdata.youtube.com/schemas/2007'); 
      $attrs = $yt->statistics->attributes(); 
      $obj->viewCount = $attrs['viewCount'];  
       
      // get <gd:rating> node for video ratings 
      $gd = $entry->children('http://schemas.google.com/g/2005');  
      if ($gd->rating) {  
        $attrs = $gd->rating->attributes(); 
        $obj->rating = $attrs['average'];  
      } else { 
        $obj->rating = 0;          
      } 
         
      // get <gd:comments> node for video comments 
      $gd = $entry->children('http://schemas.google.com/g/2005'); 
      if ($gd->comments->feedLink) {  
        $attrs = $gd->comments->feedLink->attributes(); 
        $obj->commentsURL = $attrs['href'];  
        $obj->commentsCount = $attrs['countHint'];  
      } 
       
      //Get the author 
      $obj->author = $entry->author->name; 
      $obj->authorURL = $entry->author->uri; 
       
       
      // get feed URL for video responses 
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom'); 
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/ 
      2007#video.responses']");  
      if (count($nodeset) > 0) { 
        $obj->responsesURL = $nodeset[0]['href'];       
      } 
          
      // get feed URL for related videos 
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom'); 
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/ 
      2007#video.related']");  
      if (count($nodeset) > 0) { 
        $obj->relatedURL = $nodeset[0]['href'];       
      } 
     
      // return object to caller   
      return $obj;       
}    
/*
    // get video ID from $_GET  
    if (!isset($_GET['url'])) { 
      die ('Please enter a youtube video URL');   
    } else { 
        $vid = stripslashes($_GET['url']); 
        $string = $vid; 
        $url = parse_url($string); 
        parse_str($url['query']); 
          
   
    } 
     
    // set video data feed URL 
    $feedURL = 'http://gdata.youtube.com/feeds/api/videos/'. $v; 

    // read feed into SimpleXML object 
    $entry = simplexml_load_file($feedURL); 
     
    // parse video entry 
    $video = parseVideoEntry($entry); 


	//These variables include the video information 
		$video_title = stripslashes($video->title); 
		$video_description = stripslashes($video->description); 
		$video_thumbnail = stripslashes($video->thumbnailURL); 
		$video_author = stripslashes($video->author); 
		$embed = '<object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/'.$v.'&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$v.'&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>';

	//	echo 'The title of the video is '.$video_title;
	//	echo '</br>';
	//	echo $embed;
	*/
?>	