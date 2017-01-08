<style type="text/css">
/* Tiles */
.seller-tile {
	margin-bottom: 15px;
	border-radius: 3px;
	background-color: #2CCA6D;
	color: #FFFFFF;
	transition: all 1s;
}
.seller-tile:hover {
	opacity: 0.95;
}

.seller-tile a {
	color: #FFFFFF;
}
.seller-tile-heading {
	padding: 5px 8px;
	text-transform: uppercase;
	background-color: #1EBD60;
	color: #FFF;
}
.seller-tile .seller-tile-heading .pull-right {
	transition: all 1s;
	opacity: 0.7;
}
.seller-tile:hover .seller-tile-heading .pull-right {
	opacity: 1;
}
.seller-tile-body {
	padding: 15px;
	color: #FFFFFF;
	line-height: 48px;
}
.seller-tile .seller-tile-body i {
	font-size: 50px;
	opacity: 0.3;
	transition: all 1s;
}
.seller-tile:hover .seller-tile-body i {
	color: #FFFFFF;
	opacity: 1;
}
.seller-tile .seller-tile-body h2 {
	font-size: 42px;
}
.seller-tile-footer {
	padding: 5px 8px;
	background-color: #43D680;
}
 </style>

<div class="seller-tile">
  <div class="seller-tile-heading"><?php echo $heading_title; ?> <span class="pull-right">
    <?php if ($percentage > 0) { ?>
    <i class="fa fa-caret-up"></i>
    <?php } elseif ($percentage < 0) { ?>
    <i class="fa fa-caret-down"></i>
    <?php } ?>
    <?php echo $percentage; ?>%</span></div>
  <div class="seller-tile-body"><i class="fa fa-user"></i>
    <h2 class="pull-right"><?php echo $total; ?></h2>
  </div>
  <div class="seller-tile-footer"><a href="<?php echo $seller; ?>"><?php echo $text_view; ?></a></div>
</div>
