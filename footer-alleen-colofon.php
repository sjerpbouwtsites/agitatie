<footer id='stek-voet' class='stek-voet alleen-colofon'>

	<?php get_template_part('sja/footer/colofon'); ?>

</footer>

<script>
var BASE_URL = "<?=SITE_URI?>",
	TEMPLATE_URL = "<?=THEME_URI?>",
	IMG_URL = "<?=IMG_URI?>",
	AJAX_URL = BASE_URL + "/wp-admin/admin-ajax.php";
</script>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<?php wp_footer(); ?>

</body>
</html>
