<?php

class Ag_basis_class {
	function __construct($a = array()) {
		if (is_array($a)) {
			foreach ($a as $k=>$v) {
				$this->$k = $v;
			}
		} else {
			$this->naam = $a;
		}
	}
}

class Ag_knop extends Ag_basis_class{

	public $class, $link, $tekst, $extern, $schakel, $html;

	public function __construct ($a = array()) {
		parent::__construct($a);
		$this->klaar = false;
	}

	public function nalopen () {
		if (!ag_cp_truthy('ikoon', $this)) $this->ikoon = "arrow-right-thick";
		if (!ag_cp_truthy('link', $this)) $this->link = "#";
		if (!ag_cp_truthy('geen_ikoon', $this)) $this->geen_ikoon = false;
		$this->class = $this->class . ($this->geen_ikoon ? " geen-ikoon": "");
		$this->klaar = true;
	}

	public function print_ikoon() {

		return $this->geen_ikoon ? "" : "</span><i class='mdi mdi-{$this->ikoon}'></i>";
	}

	public function maak() {

		if (!$this->klaar) $this->nalopen();

		$e = $this->extern ? " target='_blank' " : "";
		$this->html = "<a {$e}
				class='knop {$this->class}'
				href='{$this->link}'
				{$this->schakel}
			><span>{$this->tekst}{$this->print_ikoon()}</a>";
		return $this->html;
	}

	public function print () {
		$this->maak();
		echo $this->html;
	}
}

class Ag_Widget_M extends Ag_basis_class {

	public $naam, $verp_open, $verp_sluit, $gemaakt, $css_klassen, $vernietigd;

	public function __construct ($a) {
		parent::__construct($a);
	}

	public function maak() {

		if (!$this->css_klassen) $this->css_klassen = preg_replace('~[^\p{L}\p{N}]++~u', '', strtolower($this->naam));
		$this->extra_voor_verp();
		$this->verp_open = "<section class='widget $this->css_klassen'>";
		$this->verp_sluit = "</section>";
		$this->zet_inhoud();
		$this->gemaakt = true;

	}

	public function zet_inhoud() {
		$this->inhoud = "lege widget";
	}

	public function extra_voor_verp (){
		//voor kinderen om na te bewerken
	}

	public function vernietig() {
		$this->vernietigd = true;
	}

	public function print(){

		if ($this->vernietigd) return;

		if (!$this->inhoud || $this->inhoud === '') return;

		if (!$this->gemaakt) $this->maak();

		echo $this->verp_open;
		echo
		"<header><h2>{$this->naam}</h2></header>

			{$this->inhoud}

		";

		echo $this->verp_sluit;
	}
}

class Ag_Zijbalk_Posts extends Ag_Widget_M {

	public function __construct ($a = array()) {
		parent::__construct($a);
	}

	public function zet_inhoud () {

		//

	}
}

class Ag_article_c extends Ag_basis_class{

	public $art, $gecontroleerd, $data_src;

	public function __construct ($config, $post) {
		parent::__construct($config);
		$this->art = $post;
	}

	public function test() {
		return "test";
	}

	public function controleer () {
		if ($this->gecontroleerd) return;

		//initialiseer negatieve waarden hier
		$c = array(
			'is_categorie',
			'geen_afb',
			'geen_tekst',
			'class',
			'geen_datum',
			'taxonomieen',
			'korte_titel'
		);

		foreach ($c as $cc) {
			$this->$cc = property_exists($this, $cc) ? $this->$cc : false;
		}

		$this->zet_permalink();
		$this->maak_titel();

		$this->htype = ag_cp_truthy('htype',$this) ? $this->htype : "3";
		$this->exc_lim = ag_cp_truthy('exc_lim',$this) ? $this->exc_lim : "300";
		$this->afb_formaat = ag_cp_truthy('afb_formaat',$this) ? $this->afb_formaat : "lijst";

		$this->gecontroleerd = true;
	}

	public function maak_titel () {
		if ($this->is_categorie) {
			$this->art->post_title = $this->art->name;
		} else {
			if ($this->korte_titel) {
				$this->art->post_title = ag_beperk_woordental(30, $this->art->post_title);
			} else {
				//goed zo
			}
		}
	}


	public function zet_permalink() {
		if ($this->is_categorie) {
			$this->permalink = get_category_link( $this->art->term_id );
		} else {
			$this->permalink = get_permalink($this->art->ID);
		}
	}

	public function print_afb () {
		if ($this->is_categorie) {

			$afb_verz = get_field('cat_afb', 'category_'.$this->art->term_id);

			$img = "<img
				src='{$afb_verz['sizes']['lijst']}'
				alt='{$afb_verz['alt']}'
				height='{$afb_verz['sizes']['lijst-width']}'
				width='{$afb_verz['sizes']['lijst-height']}'
			/>";

		} else {

			if (has_post_thumbnail($this->art->ID)) {
				$img = get_the_post_thumbnail($this->art, $this->afb_formaat);
			} else {

				$img_f = get_field('ta_afbeelding', 'option');
				$w = $this->afb_formaat.'-width';
				$h = $this->afb_formaat.'-height';
				$img = "
					<img
						src='{$img_f['sizes'][$this->afb_formaat]}'
						alt='{$img_f['alt']}'
						width='{$img_f['sizes'][$w]}'
						height='{$img_f['sizes'][$h]}'
					/>";
			}

		}

		echo $img;

	}

	public function maak_tekst (){
		return "<p class='tekst-zwart'>". ag_maak_excerpt($this->art, $this->exc_lim) .

		//als geen afbeelding, dan pijltje achter tekst zodat klikbaarheid duidelijker is.
		($this->geen_afb ? "<span class='lees-meer'>Meer ".ag_mdi('arrow-right-bold-circle', false) . "</span>" : '') .

		"</p>";
	}

	public function datum() {
		if ($this->geen_datum || $this->is_categorie) return;

		echo "<time class='post-datum tekst-zwart'>" . get_the_date(get_option('date_format'), $this->art->ID) . "</time>";
	}

	public function maak_taxlijst() {

			$uitsluiten = array(
				'post_format', 'post_tag'
			);

			$lijst = get_object_taxonomies($this->art);
			$p_lijst = array();

			foreach ($lijst as $l) {
				if (!in_array($l, $uitsluiten)) {
					$p_lijst[] = $l;
				}
			}

			$GLOBALS[$this->art->post_type . '-taxlijst'] = $p_lijst;


	}

	public function taxonomieen() {

		// slaat in globale variabele op hoe de taxonomieen heten van deze posttype, als dat niet reeds gedaan is
		// bepaalde waarden worden opgeslagen
		// verwerkt de taxonomieen tot bv "categorie"
		// @TODO meervoud van taxonomieen dient nog correct ingesteld te worden in posttypes.php en die hier uitgedraaid te worden via
		// https://developer.wordpress.org/reference/functions/get_taxonomy_labels/

		if (!$this->taxonomieen || $this->is_categorie) return;


		$tl_str = $this->art->post_type . '-taxlijst';
		//niet iedere keer opnieuw doen.
		if (!array_key_exists($tl_str, $GLOBALS)) {
			$this->maak_taxlijst();
		}


		$terms = wp_get_post_terms( $this->art->ID, $GLOBALS[$tl_str] );

		$overslaan = array('Geen categorie');

		$print_ar = array();

		if (count($terms)) :

			foreach ( $terms as $term ) :

				if (in_array($term->name, $overslaan)) continue;

				if (array_key_exists($term->taxonomy, $print_ar)) {
					$print_ar[$term->taxonomy][] = $term->name;
				} else {
					$print_ar[$term->taxonomy] = array($term->name);
				}

			endforeach;

			///

			if (count($print_ar)) {

				$teller = 0;

				foreach ($print_ar as $tax_naam => $tax_waarden) :

					if ($tax_naam === 'category') $tax_naam = 'categorie';

					//als geen datum, dan eerste tax waarde geen streepje links.

					$str = "- ";

					if ($this->geen_datum && $teller < 1) {
						$str = "";
						$teller++;
					}

					echo "<span class='tax tekst-zwart'> $str". strtolower(implode(', ', $tax_waarden)) . "</span>";


				endforeach; //iedere print_ar
			}
		endif; //als count terms


	}

	public function extra_class(){

		$r = '';
		if ($this->geen_afb) $r .= 'geen-afb ';
		if ($this->geen_tekst) $r .= 'geen-tekst ';
		if ($this->geen_datum) $r .= 'geen-datum ';
		return trim($r);

	}

	public function maak_artikel ($maak_html = false) {

		if (!$this->gecontroleerd) $this->controleer();

		if ($maak_html) ob_start();

		?>

		<article class="flex art-c <?=$this->class?> <?=$this->extra_class()?>" <?=$this->data_src?> >

			<?php if (!$this->geen_afb) : ?>
			<div class='art-links'>
				<a href='<?=$this->permalink?>'>
					<?php $this->print_afb(); ?>
				</a>
			</div>
			<?php endif;?>

			<div class='art-rechts'>
				<a class='tekst-zwart' href='<?=$this->permalink?>'>
					<header>
						<h<?=$this->htype?> class='tekst-zwart'>
							<?=$this->art->post_title?>
						</h<?=$this->htype?>>
						<?php $this->datum();
						 $this->taxonomieen(); ?>
					</header>
					<?php

					if (!$this->geen_tekst) :
						echo $this->maak_tekst();
					endif;  ?>
				</a>
			</div>

		</article>
		<?php

		if ($maak_html) {
			$this->html = ob_get_clean();
		}



	}

	public function print () {
		$this->maak_artikel(false);
	}
}

class Ag_agenda extends Ag_basis_class {

	public $omgeving;

	public function __construct ($a = array()) {
		parent::__construct($a);
		//filter, /omgeving, etc.
	}

	public function zet_is_widget(){
		$this->is_widget = $this->omgeving === "widget";
	}

	public function in_pagina_queryarg (){


		$this->console = [];

		$archief = array_key_exists('archief', $_POST) || array_key_exists('archief', $_GET);

		$datum_vergelijking = ($archief ? '<' : '>=' );

		$datum_sortering = ($archief ? 'DESC' : 'ASC');

		$args = array(
		    'post_type' 		=> 'agenda',
		    'post_status' 		=> 'publish',
		    'meta_key' 			=> 'datum',
			'orderby'			=> 'meta_value',
			'order'				=> $datum_sortering,
			'meta_query' 		=> array(
				array(
					'key' => 'datum',
					'value' => date('Ymd'),
					'type' => 'DATE',
					'compare' => $datum_vergelijking
				)
			),
		);

		$tax_query = array();
		$tax_namen = array('locatie', 'soort',);

		foreach ($tax_namen as $t) {
			if (array_key_exists($t, $_POST) && $_POST[$t] !== '') {
				$tax_query[] = array(
		           'taxonomy' => $t,
		           'field'    => 'slug',
		           'terms'    => $_POST[$t],
				);
			}
		}

		if (count($tax_query)) {
			$args['tax_query'] = $tax_query;
		}

		$args_paged = $args;

		$args['posts_per_page'] = -1;
		$args_paged['posts_per_page'] = $this->aantal;

		$this->query_args = array($args_paged, $args);
	}

	public function widget_queryarg () {

		$args = array(
		    'post_type' 		=> 'agenda',
		    'post_status' 		=> 'publish',
		    'posts_per_page'	=> $this->aantal,
		    'meta_key' 			=> 'datum',
			'orderby'			=> 'meta_value',
			'order'				=> 'ASC',
			'meta_query' 		=> array(
				array(
					'key' => 'datum',
					'value' => date('Ymd'),
					'type' => 'DATE',
					'compare' => '>='
				)
			),
		);

		$this->query_args = array($args, $args);
	}

	public function zet_agendastukken() {

		$this->is_widget ? $this->widget_queryarg() : $this->in_pagina_queryarg();

		$this->console[] = $this->is_widget;
		$this->console[] = $this->query_args[0];

		$this->agendastukken = get_posts($this->query_args[0]);

		$this->is_widget ? NULL : $this->zet_totaal_aantal();
	}

	public function nalopen () {
		if (!ag_cp_truthy('aantal', $this)) $this->aantal = 5;
		if (!ag_cp_truthy('agenda_link', $this)) $this->agenda_link = get_post_type_archive_link('agenda');
	}

	public function zet_totaal_aantal() {
		$query_voor_tellen = get_posts($this->query_args[1]);
		//echo count($query_voor_tellen) . " / " . $this->aantal . " = " . $wp_query->max_num_pages;
		global $wp_query;
	   	$wp_query->max_num_pages = ceil(count($query_voor_tellen) / $this->aantal);
	}

	public function tax_string ($post, $str = '') {
		$obj = wp_get_post_terms( $post->ID, $str);
		$r = '';
		if (count($obj)) {
			foreach ($obj as $t) {
				$r .= $t->name . ", ";
			}
		}
		$r = substr($r, 0, strlen($r) -2); //laatste ', ' eraf
		return $r;
	}

	public function print () {

		$this->zet_is_widget();
		$this->zet_agendastukken();
		$this->nalopen();

		$verpakking_el = $this->is_widget ? "section" : "div";

		?>
		<<?=$verpakking_el?> class='agenda <?=$this->omgeving?>'>
			<?=($this->omgeving==="widget" ? "<h2>Ag_agenda</h2>" : "")?>

			<div class=''>
				<ul>
					<?php

						foreach ($this->agendastukken as $a) :

							if (!$this->is_widget) {
								$content = ag_maak_excerpt($a, 320);
								$this->rechts = "<div class='agenda-rechts'><span>".$content."</span></div>";
							} else {
								$this->rechts = '';
							}

							$stad = $this->tax_string($a, 'locatie');
							$soort = $this->tax_string($a, 'soort');

							$afb = wp_get_attachment_image_src( get_post_thumbnail_id( $a->ID ), 'large' );


							echo
							"<li>

								<a class='flex' href='".get_the_permalink($a->ID)."'>

									<div class='agenda-links'>
										".$this->format_datum(get_field('datum', $a->ID))."
									</div>

									<div class='agenda-midden flex'>

										<span
											class='locatie'>
											$stad ".
											($this->is_widget ? "" : " - $soort") ."
										</span>

										<span class='titel' >".$a->post_title."</span>
									</div>

									{$this->rechts}

								</a>
							</li>";
						endforeach; //agendastukken

					?>

				</ul>


				<?php

				if ($this->is_widget) {
					echo "<footer>";

					$agenda_Ag_knop = new Ag_knop(array(
						'class'=> 'in-kleur',
						'link' => $this->agenda_link,
						'tekst'=> 'Hele agenda'
					));
					$agenda_Ag_knop->print();
					echo "</footer>";
				}


				?>


			</div>
		</<?=$verpakking_el?>>
		<?php
	}

	public function format_datum ($datum) {
		//if (!$this->is_widget) return $datum;

		// 0 = dag
		// 1 = maand
		// 2 = jaar
		// 3 = tijd

		$ma_ = array(
			'jan' => '01',
			'feb' => '02',
			'mrt' => '03',
			'apr' => '04',
			'mei' => '05',
			'jun' => '06',
			'jul' => '07',
			'aug' => '08',
			'sep' => '09',
			'okt' => '10',
			'nov' => '11',
			'dec' => '12'
		);

		$expl = explode(' ', $datum);

		$expl[1] = substr($expl[1], 0, 3);

		if ($expl[1] === 'maa') $expl[1] === 'mrt';

		$jaar_en_tijd = '';

		$dt_str = $expl[2]."-".$ma_[$expl[1]]."-".$expl[0]."T".$expl[3];
		$datetime = "<time
						itemprop='startDate'
						dateTime='$dt_str'
						>$dt_str
					</time>";

		if (!$this->is_widget) {
			return "$datetime<span><span>".$expl[0]." ".$expl[1]."</span> <span>".$expl[2]."</span><span class='met-streepje'>".$expl[3]."</span></span>";
		} else {
			return "$datetime<span><span>".$expl[0] . "</span> <span>" . $expl[1] . "</span></span>";
		}

	}
}

class Ag_pag_fam extends Ag_Zijbalk_Posts{

	public $inhoud;

	public function __construct ($a = array()) {
		parent::__construct($a);
	}

	public function extra_voor_verp () {
		$this->css_klassen = $this->css_klassen . " pag-fam";
	}

	public function zet_inhoud () {

		$post = $GLOBALS['post'];

		if ($post->post_type !== 'page') {
			return;
		}

		$this->is_kind = $post->post_parent !== 0;
		if ($this->is_kind) {
			$this->ouder = $post->post_parent;
		} else {
			$this->ouder = $post->ID;
		}

		$pagina_query = new WP_Query();
		$alle_paginas = $pagina_query->query(array('post_type' => 'page', 'posts_per_page' => '-1'));
		$this->kinderen = get_page_children( $this->ouder, $alle_paginas );

		//als er geen kinderen zijn (0 of alleen zichzelf) dan zit deze pagina niet in een familie.
		if (count($this->kinderen) < 2)  {
			$this->vernietig();
			return;
		}

		ob_start();

		$hui = ($this->ouder === $post->ID ? 'huidige' : '');

		$art = new Ag_article_c(
			array(
				'class' => "in-lijst $hui",
				'htype' => 3,
				'geen_tekst' => true,
				'in_zijbalk' => true,
				'geen_afb'	=> true,
				'geen_datum'=> true,
			),
		get_post($this->ouder));

		$art->print();


		foreach ($this->kinderen as $k) {

			$hui = ($k->ID === $post->ID ? 'huidige' : "");

			$art = new Ag_article_c(
				array(
					'class' => "in-lijst $hui",
					'htype' => 3,
					'geen_afb'	=> true,
					'geen_tekst' => true,
					'geen_datum'=> true,
					'in_zijbalk' => true
				),
			get_post($k));

			$art->print();
		}

		$this->inhoud .= ob_get_clean();

	}
}

class Ag_tax_blok extends Ag_basis_class {

	//aantal uitgesloten tax namen, post_tag en post_format
	public $uitgesloten = array();

	public function __construct ($a = array()) {
		parent::__construct($a);
	}

	public function nalopen () {
		if (!ag_cp_truthy('post', $this)) die();
		if (!ag_cp_truthy('titel', $this)) $this->titel = "";
		if (!ag_cp_truthy('html', $this)) $this->html = "";
		if (!ag_cp_truthy('basis', $this)) $this->basis = $this->zet_basis();
		if (!ag_cp_truthy('reset', $this)) $this->reset = false;
		if (!ag_cp_truthy('archief', $this)) $this->archief = is_archive();
	}


	public function zet_basis() {
		$this->basis = get_post_type_archive_link($this->post->post_type);
	}

	public function verwerk_tax_naam($a) {

		//LEGACY ?

		if ($this->archief) {
			return $a;
		} else {
			return "_$a";
		}
	}

	public function maak_li ($tax_term){
		$href = get_term_link($tax_term->term_id);
		return "<li><a href='$href'>".ucfirst($tax_term->name)."</a></li>";
	}

	public function controleer_tax_titel($str) {

		//vervangt tax titel namen

		$controle = array(
			'category'		=> 'categorie',
		);

		if(array_key_exists($str, $controle)) {
			return $controle[$str];
		} else {
			return $str;
		}

	}

	public function uitsluiten ($naam) {

		//sluit bepaalde namen uit en slaat dit op in uitgesloten.

		if ($naam === 'post_format' || $naam === 'post_tag') {
			if (!in_array($naam, $this->uitgesloten)) $this->uitgesloten[] = $naam;
			return true;
		} else {
			return false;
		}
	}

	public function maak() {

		$this->nalopen();

		$titel = $this->titel !== '' ? "<h2>{$this->titel}</h2>" : "";

		$taxs = get_object_taxonomies($this->post, 'objects');
		$tax_en_terms = array();

		foreach ($taxs as $t) :
			$tax_en_terms[$t->name] = get_terms( $t->name, array('hide_empty' => true,) );
		endforeach;

		$linkblokken = '';

		//eerst mogelijk maken te berekenen of we meer dan 1 tax krijgen...hoeveel sluiten we uit.
		foreach ($tax_en_terms as $naam => $waarden) :
			$this->uitsluiten($naam);
		endforeach;

		foreach ($tax_en_terms as $naam => $waarden) :

			if ($this->uitsluiten($naam)) continue;

			$linkblokken .= "<section>";
			if ( (count($tax_en_terms) - count($this->uitgesloten) ) > 1) {
				$linkblokken .= "<h3>".ucfirst($this->controleer_tax_titel($naam))."</h3>";
			}
			if (count($waarden)) :
				$linkblokken .= "<ul class='reset'>";
				if ($this->reset) {
					$linkblokken .= "<li><a href='{$this->basis}'>Alles</a></li>";
				}
				foreach ($waarden as $tax_term) {
					$linkblokken .= $this->maak_li($tax_term);
				}
				$linkblokken .= "</ul>";
			endif;
			$linkblokken .= "</section>";
		endforeach;

		if ($linkblokken !== '') {
			$this->html = "

				<nav id='tax-blok'>

					$titel
					$linkblokken

				</nav>

			";
		}


	}

	public function print() {
		if (!ag_cp_truthy('html', $this)) {
			$this->maak();
		}
		echo $this->html;
	}

}

