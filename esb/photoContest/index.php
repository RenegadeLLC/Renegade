

<?php
 require 'facebook.php';
 $app_id = "267136803390624";
 $app_secret = "985df1f3da70ac063fd8d83fee66ac67";
 $facebook = new Facebook(array(
 'appId' => $app_id,
 'secret' => $app_secret,
 'cookie' => true
 ));

 $signed_request = $facebook->getSignedRequest();

 $page_id = $signed_request["page"]["id"];
 $page_admin = $signed_request["page"]["admin"];
 $like_status = $signed_request["page"]["liked"];
 $country = $signed_request["user"]["country"];
 $locale = $signed_request["user"]["locale"];

 // If a fan is on your page
 if ($like_status == 1) {
 $a = file_get_contents("https://tabs.wildfireapp.com/fb/9932/tabs/");
 echo ($a);
 } else {
 // If a non-fan is on your page
 $a = file_get_contents("likeGate.html");
 echo ($a);
 }

 ?>