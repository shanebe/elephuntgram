elephuntgram
============

Simple Instagram Feed Reader for PHP


Usage
-----

Default Parameters

  * token - Instagram token, good for 5000 requests an hour   
  * limit - number of images to return
  * start - HTML for start of instagram feed pull
  * end - HTML for end of instagram feed pull
  * itemstart - HTML before each Instagram <img> tag
  * itemend - HTML after each Instagram <img> tag
  * width - HTML <img width> attribute
  * height - HTML <img height> attribute
  * caption - TRUE or FALSE boolean, makes caption the ALT/TITLE text of the <img> tag
  * link - TRUE or FALSE boolean, defaults to true. Wrap image in an A tag to Instagram link
  * nosize - TRUE or FALSE boolean, if TRUE do not add any width or height tags to each instagram image
  * noitemcontainer - TRUE or FALSE boolean, if TRUE do not use any itemstart or itemend around the instagram feed
  * nocontainer - TRUE or FALSE boolean, if TRUE do not use start or end around the instagram feed
  * imgclass - Define class for <img> tag
  * link - Variable "instagram" links to instagram, "fancybox" or "none"
  * fancyboxtitle - TRUE or FALSE boolean, only used with "fancybox" link
  * rel - HTML <a> rel attribute. Used with "instagram" or "fancybox" link only
 
Notes
-----
To obtain the access token, paste this into your browser:

Now let’s obtain the access token. 
Paste this in your browser(replace client_id with your newly created one):
https://instagram.com/oauth/authorize/?client_id=YOUR_CLIENT_ID&redirect_uri=YOUR_REDIRECT_URL&response_type=token

Grant the application access to your images and press OK. 
You will now receive a 404 page or something similar, that’s ok though, look in the address bar right after the # sign.
That is your access token!
