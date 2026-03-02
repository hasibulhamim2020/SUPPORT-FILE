<div id="header">
<span class="header1"><?php echo $_SESSION['proj_name'];?></span><br />
<span class="header2"><?php echo $_SESSION['company_name'];?></span>
</div>
<div id="menuhead">
<script src="common/xaramenu.js"></script>
<script src="common/dimpletab.js"></script>
</div>
<div id="menuhead2">
<?php echo date("l g:i A d  M Y")." &nbsp;&nbsp;
		<a href=\"logout.php\"><font color='#ffffff'>Logout</a></font>";?>
</div>
