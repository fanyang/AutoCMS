<?php
include_once (dirname(__FILE__) . '/AboutControler.php');
$controler = new AboutControler();
$header = $controler->header;
include_once(dirname(__FILE__) . '/header.php');
?>
<div id="PageBody">
<div id="LeftImg">
<img src="/public/images/about_image.jpg" />
</div><!--End of LeftImg-->
<div id="RightContent">
<h1>About DealForGirl</h1>
<p>
Dear friends, thanks for visiting us!
</p>
<p>
DealForGirl brings the best deals on fabulous items that girls love. We help shoppers save money and live better. On the website you will find all the hottest sale items from hundreds of stores, including more than 200 famous brands of apparel, handbags, shoes, jewery & accessories, beauty & fragrance, health and fitness products. We guarantee that every deal is valid, and the lowest price we could find. We update the latest deal immediately so that you can buy the least expensive product as soon as possible.
</p><p>Please remember DealForGirl does not sell or ship items. DealForGirl.com is an information only resource for shoppers that posts coupons, deals for other stores. If you have a problem with any order please contact the merchant directly.
</p><p>If you have any questions, please send Email to <span>dealforgirl@dealforgirl.com</span>
</p>
</div><!--End of RightContent-->
</div><!--End of PageBody-->
<?php
include_once(dirname(__FILE__) . '/footer.php');
?>