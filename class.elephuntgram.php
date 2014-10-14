<?php
global $params;

/* Default Parameters
 *
 * token - Instagram token, good for 5000 requests an hour
 * limit - number of images to return
 * start - HTML for start of instagram feed pull
 * end - HTML for end of instagram feed pull
 * itemstart - HTML before each Instagram <img> tag
 * itemend - HTML after each Instagram <img> tag
 * width - HTML <img width> attribute
 * height - HTML <img height> attribute
 * caption - TRUE or FALSE boolean, makes caption the ALT/TITLE text of the <img> tag
 * nosize - TRUE or FALSE boolean, if TRUE do not add any width or height tags to each instagram image
 * noitemcontainer - TRUE or FALSE boolean, if TRUE do not use any itemstart or itemend around the instagram feed
 * nocontainer - TRUE or FALSE boolean, if TRUE do not use start or end around the instagram feed
 * imgclass - Define class for <img> tag
 * link - Variable "instagram" links to instagram, "image" wraps it in an A tag or "none"
 * linktitle - TRUE or FALSE boolean, only used with "image" link, adds caption to fancybox title
 * linktitleurl - TRUE or FALSE boolean, only used with "image" link and "linktitle=true", adds URL to caption as link
 * linkclass - Define <A> tag class name, only used with "image" link
 * rel - HTML <a> rel attribute. Used with "instagram" or "image" link only
 
 (c)2014 Shane Bennett, @shanebe
*/

$params = array(
  'token' => '10418545.00ee1ce.0d0e565627cd465f950874e7e1b2bc08',
  'limit' => 5,
  'start' => '<ul>',
  'end' => '</ul>',
  'itemstart' => '<li>',
  'itemend' => '</li>',
  'width' => '100',
  'height' => '100',
  'caption' => false,
  'nosize' => false,
  'noitemcontainer' => false,
  'nocontainer' => false,
  'link' => 'instagram',
  'rel' => '',
  'linktitle' => true,
  'linktitleurl' => false,
  'linkclass' => '',
  'imgclass' => ''
);

function elephuntRequest($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  $result = curl_exec($ch);
  curl_close($ch); 
  return $result;
}

function GetUserID($username, $access_token) {
  $url = "https://api.instagram.com/v1/users/search?q=" . $username . "&access_token=" . $access_token;
  if($result = json_decode(elephuntRequest($url), true)) {
    return $result['data'][0]['id'];
  }
} 

function elephuntGram($param) {
  $user = GetUserID($param['username'],$param['token']);
  $result = elephuntRequest("https://api.instagram.com/v1/users/$user/media/recent/?access_token=".$param['token']);
  $result = json_decode($result);
  $string = '';
 if ($param['nocontainer'] != true)
    $string = $param['start'];
  for ($x=0;$x<$param['limit'];$x++) {
    if ($param['linktitleurl'] == true) {
      $fancylink = $result->data[$x]->caption->text . ' <a href="'.$result->data[$x]->link.'" target="_BLANK">'.$result->data[$x]->link.'</a>';
    } else {
      $fancylink = $result->data[$x]->caption->text;
    }
      if ($param['noitemcontainer'] != true) 
      $string .= $param['itemstart'];
    if ( ($param['link'] == 'instagram') || ($param['link'] == 'image') ) {
      if ($param['link'] == 'instagram') $string .= '<a href="'.$result->data[$x]->link.'" target="_BLANK" ';
      elseif ($param['link'] == "image") $string .= '<a href="'.$result->data[$x]->images->standard_resolution->url.'" ';
      if ($param['linktitle'] == true) $string .= 'title="'.htmlentities($fancylink).'" ';
      if ($param['rel'] != '') $string .= 'rel="'.$param['rel'].'" ';
      if ($param['linkclass'] != '') $string .= 'class="'.$param['linkclass'].'" ';
      $string .= '>';
    }
   $string .= '<img src="'.$result->data[$x]->images->standard_resolution->url.'" ';
    if ($param['nosize'] != true)
      $string .= 'width="'.$param['width'].'" height="'.$param['height'].'" ';
    if ($param['imgclass'] != '') 
      $string .= 'class="'.$param['imgclass'].'" ';
    if ($param['caption'] == true) 
      $string .= 'title="'.htmlentities($result->data[$x]->caption->text).'" alt="'.strip_tags(htmlentities($result->data[$x]->caption->text),'<br><br /><p>').'" ';
    elseif ($param['linktitle'] == true) $string .= 'title="" alt="" ';
    $string .= '/>';
    if ( ($param['link'] == 'image') || ($param['link'] == "instagram") ) $string .= '</a>';
    if ($param['noitemcontainer'] != true)
      $string .= $param['itemend'];
  }
  if ($param['nocontainer'] != true)
    $string .= $param['end'];
  return $string;
}
?>
