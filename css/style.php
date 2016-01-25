<?php header("Content-type: text/css");
	$font_primario = "News Cycle";
?>
/* GENERALI */
html, body {position:relative; height:100%;}
a, a:active, a:link, a:visited {color:black;}
a:hover {color:gray;}
img {font:10px <?php echo $font_primario; ?>; color:gray;}

/* MENU SUPERIORE */
#menu_container {position:fixed; top:0; left:20px; background:white; padding-top:20px; padding-left:0px; z-index:90; min-width:990px; width:calc(100% - 40px); height:auto; color:black; font:13px <?php echo $font_primario; ?>; border-bottom:1px solid #eee; padding-bottom:10px; }
	#menu_title {float:left; background:transparent;}
	.menu {float:left; margin:0px; padding:0px; margin-left:20px; background:transparent;}
	.menu_reverse {float:right; margin:0px; padding:0px; margin-right:70px; background:transparent;}
		.menu a, .menu a:active, .menu a:link, .menu a:visited {color:gray;}
		.menu a:hover {color:black;}
		.menu_list {background:transparent; margin:0; margin-left:50px; padding:0; list-style:none;}
		.menu_list li {background:transparent; padding:0px; margin:0px 5px; padding-top:2px; float:left;
		font:11px <?php echo $font_primario; ?>;}
		.menu_list li:nth-child(1) {margin:0px; margin-right:5px;}
		.li_active a {color:black !important;}
	#menu_social {float:right; width:auto; height:auto; padding:0px; background:transparent;}
	#menu_social img {position:relative; top:-5px; max-width:50px;}
	
/* CORPO CENTRALE */
#body_container {background:transparent; position:relative; z-index:50; padding-left:240px; padding-right:10%; padding-top:70px; font:10px <?php echo $font_primario; ?>; padding-bottom:135px; height:calc(100% - 205px);}

/* PROGETTI INDEX */
#project_container {background:transparent; position:relative; z-index:50; padding:5px; padding-left:0px; min-width:770px;}
#project_list {background:transparent; margin:0; padding:0; list-style:none;}
#project_list li {background:transparent; display:inline-block; vertical-align:middle; text-align:left; width:auto; height:200px; margin:5px 0px; margin-right:60px; float:left;}
.project_image {background:transparent; width:auto; height:calc(100% - 40px); padding:0px; font:0px Arial;}
.project_image img {display:inline-block; vertical-align:middle; max-height:150px;}
.project_image:before {display:inline-block; vertical-align:middle; content:' '; height:100%;} 

.project_title {background:transparent; text-align:justify; height:40px; font:10px <?php echo $font_primario; ?>;}
.project_title_active {display:block;}

/* PROGETTI SPECIFICI */
.project_photo {display:block; min-height:200px !important; max-width:770px; margin-bottom:5px;}
.photo_attiva {display:inline-block;}
.photo_disattiva {display:none;}
img[class^=photo_] {cursor:pointer;}

#project_details {background:transparent; width:100%; margin:0px; margin-top:-70px; padding:0px; height:100%;}
	#project_details table{background:transparent; width:100%; height:100%; margin-top:70px; margin-bottom:135px;}
	#project_details td{background:transparent; vertical-align:middle; width:100%; height:100%;}
#project_photos {position:fixed; bottom:50px; z-index:80; left:0px; padding-left:240px; background:white; width:770px; height:auto; padding-bottom:10px; font:10px <?php echo $font_primario; ?>;}
#project_photos_list {background:transparent; list-style:none;}
	#project_photos_list li {background:transparent; float:left; padding-right:10px;}
	#project_photos_list li img{display:inline-block; vertical-align:middle; margin-top:10px; height:50px;}
.img_attiva {opacity:1;}
.img_disattiva {opacity:0.5;}
img[class^=img_] {cursor:pointer;}

/* INDEX */
.div_attivo {display:block;}
.div_disattivo {display:none;}

.td_left, .td_right {position:absolute; top:50%; margin-top:-10px; vertical-align:middle; width:20px; height:20px; z-index:100; cursor:pointer;}
.td_left {left:50%; margin-left:-425px; background:url('../images/arrow_left.png') transparent center center no-repeat;}
.td_right {right:50%; margin-right:-425px; background:url('../images/arrow_right.png') transparent center center no-repeat;}
.td_description {background:transparent; text-align:center; font:10px <?php echo $font_primario; ?>;}

/* FOOTER */
#foooter  {position:fixed; z-index:90; bottom:0; left:20px; min-width:990px; width:calc(100% - 40px); height:20px; padding:20px; padding-left:0px; padding-right:0px; background:white; color:black; font:10px <?php echo $font_primario; ?>; border-top:1px solid #eee; padding-top:10px;}
	#menu_social_bottom {float:right; width:auto; height:auto; padding:0px; background:transparent;}
	#menu_social_bottom img {position:relative; top:0px; max-width:50px;}

/* CONTACTS */
.contact_place {color:gray;}
.a_active {color:black !important;}

.azzurrino {font-size:10px; display:inline-block; width:15px; line-height:20px; color:rgb(0,195,207);}

/* STATISTICHE */
.statistiche_azzera, .statistiche_refresh {padding:5px 0px; text-align:center;}
.statistiche_azzera:hover, .statistiche_refresh:hover {cursor:pointer;}
.statistiche_azzera span, .statistiche_refresh span {background:#ddd; display:inline-block; padding-bottom:2px; width:98%;}
.statistiche_azzera span:hover, .statistiche_refresh span:hover {background:#eee;}