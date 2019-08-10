<?php
function redbonzaiBB($chaination,$too) {
	global $ifing_r ;
$chaine= $chaination ;
// br \ // spcchars
$chaine= nl2br(htmlspecialchars("$chaine"));

// URL and EMAIL
$chaine= preg_replace("/[url](.*?)[/url]/i", "<a href="http://$1" title="$1" rel="out" class="externe">$1</a>", $chaine); // SITE WEB
$chaine= preg_replace("/[url=(.*?)](.*?)[/url]/i", "<a href="$1" title="$1" rel="out" class="externe">$2</a>", $chaine); // URL 
$chaine= preg_replace("/[url2=(.*?)](.*?)[/url2]/i", "<a href="$1" title="$2">$2", $chaine); // URL 
$chaine= preg_replace("/[email=(.*?)](.*?)[/email]/i", "<a href="mailto:$1" class="urlmail">$2</a>",$chaine);

// PICTURES
$chaine= preg_replace("/[image]([^[]*)[/image]/i", "<img src="$1" alt=" " />", $chaine); // Simple Image
$chaine= preg_replace("/[imageLeft]([^[]*)[/imageLeft]/i", "<img src="$1" alt=" " class="img_left" />", $chaine); // Float left
$chaine= preg_replace("/[imageRight]([^[]*)[/imageRight]/i", "<img src="$1" alt=" " class="img_right" />", $chaine); // Float left

// FONT STYLES
$chaine= preg_replace("/[b]([^[]*)[/b]/i", "<strong>$1</strong>", $chaine);
$chaine= preg_replace("/[em]([^[]*)[/em]/i", "<em>$1</em>", $chaine);

// DESIGN
$chaine= preg_replace("/[center]([^[]*)[/center]/i", "<div class="center">$1</div>", $chaine);
$chaine= preg_replace("/[left]([^[]*)[/left]/i", "<div class="left">$1</div>", $chaine);
$chaine= preg_replace("/[right]([^[]*)[/right]/i", "<div class="right">$1</div>", $chaine);

// LIST
$chaine= preg_replace("/[ul]([^[]*)/i", "<ul class="list_arrow">$1", $chaine); // Opening list
$chaine= preg_replace("/[/ul]([^[]*)/i", "</ul>$1", $chaine); // Closing list
$chaine= preg_replace("/[li]([^[]*)[/li]/i", "<li>$1</li>", $chaine); // List element

// HEADINGS
$chaine= preg_replace("/[h1]([^[]*)[/h1]/i", "<h1>$1</h1>", $chaine);
$chaine= preg_replace("/[h2]([^[]*)[/h2]/i", "<h2>$1</h2>", $chaine);
$chaine= preg_replace("/[h3]([^[]*)[/h3]/i", "<h3>$1</h3>", $chaine);
$chaine= preg_replace("/[h4]([^[]*)[/h4]/i", "<h4>$1</h4>", $chaine);
                                      
// Note block								  
$chaine= preg_replace("/[note]([^[]*)[/note]/i", "<div class="note"><p>$1</p></div>", $chaine);

        //Code BLOCK by Christian
        $chaine = preg_replace("/[code]([^[]*)[/code]/i", '<xmp>$1</xmp>', $chaine);
		
		
		// CHAIN LONGER
 		 $chaine = wordwrap($chaine, 60, "n", 1);
		 
		// KEYWORDS SEARCH RESULT
		if(isset($ifing_r) && !empty($ifing_r)) {
		  $ye = $ifing_r ;
		  $expl = explode(" ",$ye);

		  for($i=0;$i < count($expl);$i++) { 
                   $chaine  = preg_replace($expl[$i],"<span class="word_search">$expl[$i]</span>",$chaine);
                  }
                }
		return ($chaine);
}
