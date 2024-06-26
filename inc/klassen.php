<?php

use agitatie\taal as taal;

class Ag_basis_class
{
    public function __construct($a = array())
    {
        if (is_array($a)) {
            foreach ($a as $k => $v) {
                $this->$k = $v;
            }
        } else {
            $this->naam = $a;
        }
    }
}

class Ag_knop extends Ag_basis_class
{
    public $class;
    public $link;
    public $tekst;
    public $extern;
    public $schakel;
    public $html;

    public function __construct($a = array())
    {
        parent::__construct($a);
        $this->klaar = false;
    }

    public function nalopen()
    {
        if (!ag_cp_truthy('ikoon', $this)) {
            $this->ikoon = "arrow-right-thick";
        }
        if (!ag_cp_truthy('link', $this)) {
            $this->link = "#";
        }
        if (!ag_cp_truthy('geen_ikoon', $this)) {
            $this->geen_ikoon = false;
        }
        $this->class = $this->class . ($this->geen_ikoon ? " geen-ikoon" : "");
        $this->klaar = true;
    }

    public function print_ikoon()
    {
        return $this->geen_ikoon ? "" : "</span><i class='mdi mdi-{$this->ikoon}'></i>";
    }

    public function maak()
    {
        if (!$this->klaar) {
            $this->nalopen();
        }

        $e = $this->extern ? " target='_blank' " : "";
        $this->html = "<a {$e}
				class='knop {$this->class}'
				href='{$this->link}'
				{$this->schakel}
			><span>{$this->tekst}{$this->print_ikoon()}</a>";
        return $this->html;
    }

    public function print()
    {
        $this->maak();
        echo $this->html;
    }
}

class Ag_Widget_M extends Ag_basis_class
{
    public $naam;
    public $verp_open;
    public $verp_sluit;
    public $gemaakt;
    public $css_klassen;
    public $vernietigd;

    public function __construct($a)
    {
        parent::__construct($a);
    }

    public function maak()
    {
        if (!$this->css_klassen) {
            $this->css_klassen = preg_replace('~[^\p{L}\p{N}]++~u', '', strtolower($this->naam));
        }
        $this->extra_voor_verp();
        $this->verp_open = "<section class='widget $this->css_klassen'>";
        $this->verp_sluit = "</section>";
        $this->zet_inhoud();
        $this->gemaakt = true;
    }

    public function zet_inhoud()
    {
        $this->inhoud = "lege widget";
    }

    public function extra_voor_verp()
    {
        //voor kinderen om na te bewerken
    }

    public function vernietig()
    {
        $this->vernietigd = true;
    }

    public function print()
    {
        if ($this->vernietigd) {
            return;
        }

        if (!$this->inhoud || $this->inhoud === '') {
            return;
        }

        if (!$this->gemaakt) {
            $this->maak();
        }

        echo $this->verp_open;
        echo
        "<header><h2>{$this->naam}</h2></header>

			{$this->inhoud}

		";

        echo $this->verp_sluit;
    }
}

class Ag_Zijbalk_Posts extends Ag_Widget_M
{
    public function __construct($a = array())
    {
        parent::__construct($a);
    }

    public function zet_inhoud()
    {
        //
    }
}

class Ag_article_c extends Ag_basis_class
{
    public $art;
    public $gecontroleerd;
    public $data_src;

    public function __construct($config, $post)
    {
        parent::__construct($config);
        $this->art = $post;
    }

    public function test()
    {
        return "test";
    }

    public function controleer()
    {
        if ($this->gecontroleerd) {
            return;
        }

        //initialiseer negatieve waarden hier
        $c = array(
            'is_categorie',
            'geen_afb',
            'geen_meer_tekst',
            'geen_tekst',
            'class',
            'geen_datum',
            'taxonomieen',
            'korte_titel',
            'target_blank',
            'download_link'
        );

        foreach ($c as $cc) {
            $this->$cc = property_exists($this, $cc) ? $this->$cc : false;
        }

        $this->zet_permalink();
        $this->maak_titel();

        $this->htype = ag_cp_truthy('htype', $this) ? $this->htype : "3";
        $this->exc_lim = ag_cp_truthy('exc_lim', $this) ? $this->exc_lim : "300";
        $this->afb_formaat = ag_cp_truthy('afb_formaat', $this) ? $this->afb_formaat : "lijst";

        $this->gecontroleerd = true;
    }

    public function maak_titel()
    {
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


    public function zet_permalink()
    {
        if ($this->is_categorie) {
            $this->permalink = get_category_link($this->art->term_id);
        } elseif ($this->art->post_type === 'download') {
            $this->target_blank = true;
            $bestand_of_url = get_field('bestand_of_url', $this->art->ID);
            if ($bestand_of_url === 'bestand') {
                $this->permalink = get_field('bestand', $this->art->ID);
                $this->download_link = true;
            } else {
                $this->permalink = get_field('url', $this->art->ID);
            }
        } else {
            $this->permalink = get_permalink($this->art->ID);
        }
    }

    public function print_afb()
    {
        if ($this->is_categorie) {
            $afb_verz = get_field('cat_afb', 'category_' . $this->art->term_id);

            $aw = $this->afb_formaat.'-width';
            $ah = $this->afb_formaat.'-height';

            if ($afb_verz) {
                $img = "<img
					src='{$afb_verz['sizes'][$this->afb_formaat]}'
					alt='{$this->art->term_name}'
					height='{$afb_verz['sizes'][$aw]}'
					width='{$afb_verz['sizes'][$ah]}'
                    class='is-categorie-afb'
				/>";
            } else {
                $img = '';
            }
        } else {
            if (has_post_thumbnail($this->art->ID)) {
                $img = get_the_post_thumbnail($this->art, $this->afb_formaat, array('class'=>'is-post-thumbnail-afb'));
            } else {
                $img_f = get_field('ta_afbeelding', 'option');
                if ($img_f) {
                    $w = $this->afb_formaat . '-width';
                    $h = $this->afb_formaat . '-height';
                    $img = "
						<img
                        class='is-terugval-afbeelding'
							src='{$img_f['sizes'][$this->afb_formaat]}'
							alt='{$img_f['alt']}'
							width='{$img_f['sizes'][$w]}'
							height='{$img_f['sizes'][$h]}'
						/>";
                } else {
                    $img =  '';
                }
            }
        }

        echo $img;
    }

    public function maak_tekst()
    {
        $heeft_meer = property_exists($this, 'geen_meer_tekst')
            ? !$this->geen_meer_tekst
            : true;

        $meer = taal\streng('meer');
        //als geen afbeelding, dan pijltje achter tekst zodat klikbaarheid duidelijker is.
        $meer_html = (($this->geen_afb && $heeft_meer)
            ? "<span class='lees-meer'>$meer" . ag_mdi('arrow-right-bold-circle', false) . "</span>"
            : '');

        $l = ag_maak_excerpt($this->art, $this->exc_lim);
        $ingekort = $l[0];
        $ingekort_class = $l[1] ? 'ingekort' : 'oningekort';
        return "<p class='tekst-zwart $ingekort_class'>" . $ingekort .

            $meer_html
            .

            "</p>";
    }

    public function datum()
    {
        if ($this->geen_datum || $this->is_categorie) {
            return;
        }

        echo "<time class='post-datum tekst-grijs kleine-letter'>" . get_the_date(get_option('date_format'), $this->art->ID) . "</time>";
    }

    public function maak_taxlijst()
    {
        $uitsluiten = array(
            'post_format', 'post_tag'
        );

        $lijst = agitatie\taal\verwijder_meertaligheids_tax(
            get_object_taxonomies($this->art)
        );

        $p_lijst = array();

        foreach ($lijst as $l) {
            if (!in_array($l, $uitsluiten)) {
                $p_lijst[] = $l;
            }
        }

        $GLOBALS[$this->art->post_type . '-taxlijst'] = $p_lijst;
    }

    public function taxonomieen()
    {
        // slaat in globale variabele op hoe de taxonomieen heten van deze posttype, als dat niet reeds gedaan is
        // bepaalde waarden worden opgeslagen
        // verwerkt de taxonomieen tot bv "categorie"
        // @TODO meervoud van taxonomieen dient nog correct ingesteld te worden in posttypes.php en die hier uitgedraaid te worden via
        // https://developer.wordpress.org/reference/functions/get_taxonomy_labels/

        if (!$this->taxonomieen || $this->is_categorie) {
            return;
        }


        $tl_str = $this->art->post_type . '-taxlijst';
        //niet iedere keer opnieuw doen.
        if (!array_key_exists($tl_str, $GLOBALS)) {
            $this->maak_taxlijst();
        }


        $terms = wp_get_post_terms($this->art->ID, $GLOBALS[$tl_str]);

        $overslaan = array('Geen categorie', 'Uncategorized');

        $print_ar = array();

        if (count($terms)) :

            foreach ($terms as $term) :

                if (in_array($term->name, $overslaan)) {
                    continue;
                }

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

                if ($tax_naam === 'category') {
                    $tax_naam = 'categorie';
                }

                //als geen datum, dan eerste tax waarde geen streepje links.

                $str = "- ";

                if ($this->geen_datum && $teller < 1) {
                    $str = "";
                    $teller++;
                }

                echo "<span class='tax tekst-zwart'> $str" . strtolower(implode(', ', $tax_waarden)) . "</span>";


            endforeach; //iedere print_ar
        }
        endif; //als count terms
    }

    public function extra_class()
    {
        $r = '';
        if ($this->geen_afb) {
            $r .= 'geen-afb ';
        }
        if ($this->geen_tekst) {
            $r .= 'geen-tekst ';
        }
        if ($this->geen_datum) {
            $r .= 'geen-datum ';
        }
        return trim($r);
    }

    public function maak_artikel($maak_html = false)
    {
        if (!$this->gecontroleerd) {
            $this->controleer();
        }

        if ($maak_html) {
            ob_start();
        }

        $link_target = $this->target_blank ? "_blank" : "_self";
        $download_attr = $this->download_link ? "download" : "";

        ?>

		<article id='<?= $this->art->post_name ?>' class="flex art-c <?= $this->class ?> <?= $this->extra_class() ?>" <?= $this->data_src ?>>

			<?php if (!$this->geen_afb) : ?>
				<div class='art-links'>
					<a tabindex='-1' href='<?= $this->permalink ?>' target="<?= $link_target ?>" <?= $download_attr ?>>
						<?php $this->print_afb(); ?>
					</a>
				</div>
			<?php endif; ?>

			<div class='art-rechts'>
				<a class='tekst-zwart' href='<?= $this->permalink ?>' target="<?= $link_target ?>" <?= $download_attr ?>>
					<header>
						<h<?= $this->htype ?> class='tekst-hoofdkleur'>
							<?= $this->art->post_title ?>
						</h<?= $this->htype ?>>
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

    public function print()
    {
        $this->maak_artikel(false);
    }
}

class Ag_pag_fam extends Ag_Zijbalk_Posts
{
    public $inhoud;

    public function __construct($a = array())
    {
        parent::__construct($a);
    }

    public function extra_voor_verp()
    {
        $this->css_klassen = $this->css_klassen . " pag-fam";
    }

    public function zet_inhoud()
    {
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
        $this->kinderen = get_page_children($this->ouder, $alle_paginas);

        //als er geen kinderen zijn (0 of alleen zichzelf) dan zit deze pagina niet in een familie.
        if (count($this->kinderen) < 2) {
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
                'geen_datum' => true,
            ),
            get_post($this->ouder)
        );

        $art->print();


        foreach ($this->kinderen as $k) {
            $hui = ($k->ID === $post->ID ? 'huidige' : "");

            $art = new Ag_article_c(
                array(
                    'class' => "in-lijst $hui",
                    'htype' => 3,
                    'geen_afb'	=> true,
                    'geen_tekst' => true,
                    'geen_datum' => true,
                    'in_zijbalk' => true
                ),
                get_post($k)
            );

            $art->print();
        }

        $this->inhoud .= ob_get_clean();
    }
}

class Ag_tax_blok extends Ag_basis_class
{
    //aantal uitgesloten tax namen, post_tag en post_format
    public $uitgesloten = array();

    public function __construct($a = array())
    {
        parent::__construct($a);
    }

    public function nalopen()
    {
        if (!ag_cp_truthy('post', $this)) {
            die();
        }
        if (!ag_cp_truthy('titel', $this)) {
            $this->titel = "";
        }
        if (!ag_cp_truthy('html', $this)) {
            $this->html = "";
        }
        if (!ag_cp_truthy('basis', $this)) {
            $this->basis = $this->zet_basis();
        }
        if (!ag_cp_truthy('reset', $this)) {
            $this->reset = false;
        }
        if (!ag_cp_truthy('archief', $this)) {
            $this->archief = is_archive();
        }
    }


    public function zet_basis()
    {
        $this->basis = get_post_type_archive_link($this->post->post_type);
    }

    public function verwerk_tax_naam($a)
    {
        //LEGACY ?

        if ($this->archief) {
            return $a;
        } else {
            return "_$a";
        }
    }

    public function maak_li($tax_term)
    {
        $href = get_term_link($tax_term->term_id);
        return "<li><a href='$href'>" . ucfirst($tax_term->name) . "</a></li>";
    }

    public function controleer_tax_titel($str)
    {
        //vervangt tax titel namen

        $controle = array(
            'category'		=> taal\streng('categorie'),
        );

        if (array_key_exists($str, $controle)) {
            return $controle[$str];
        } else {
            return $str;
        }
    }

    public function uitsluiten($naam)
    {
        //sluit bepaalde namen uit en slaat dit op in uitgesloten.

        $exclude = ['post_format', 'post_tag', 'language', 'post_translations'];

        if (in_array($naam, $exclude)) {
            if (!in_array($naam, $this->uitgesloten)) {
                $this->uitgesloten[] = $naam;
            }
            return true;
        } else {
            return false;
        }
    }

    public function maak()
    {
        $this->nalopen();

        $titel = $this->titel !== '' ? "<h2>{$this->titel}</h2>" : "";

        $taxs = get_object_taxonomies($this->post, 'objects');
        $tax_en_terms = array();

        foreach ($taxs as $t) :
            $tax_en_terms[$t->name] = get_terms($t->name, array('hide_empty' => true,));
        endforeach;

        $linkblokken = '';

        //eerst mogelijk maken te berekenen of we meer dan 1 tax krijgen...hoeveel sluiten we uit.
        foreach ($tax_en_terms as $naam => $waarden) :
            $this->uitsluiten($naam);
        endforeach;

        foreach ($tax_en_terms as $naam => $waarden) :

            if ($this->uitsluiten($naam)) {
                continue;
            }

            $linkblokken .= "<section>";
            if ((count($tax_en_terms) - count($this->uitgesloten)) > 1) {
                $linkblokken .= "<h3>" . ucfirst($this->controleer_tax_titel($naam)) . "</h3>";
            }
            if (count($waarden)) :
                $linkblokken .= "<ul class='reset'>";
                if ($this->reset) {
                    $alles = taal\streng('alles');
                    $linkblokken .= "<li><a href='{$this->basis}'>$alles</a></li>";
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

            $vertaal = array(
                'post'	=> 'berichten',
                'page'  => 'pagina\'s'
            );

            global $wp_query;


            $this->html.= "<footer class='archief-footer'>";
            $terug = new Ag_knop(array(
                'class' 	=> 'in-wit ikoon-links',
                'link' 		=> get_post_type_archive_link(POST_TYPE_NAAM),
                'tekst'		=> 'Alle ' . $vertaal[($wp_query->posts[0]->post_type)],
                'ikoon'		=> 'arrow-left-thick'
            ));

            $terug->print();

            $this->html.= "<footer>";
        }
    }

    public function print()
    {
        if (!ag_cp_truthy('html', $this)) {
            $this->maak();
        }
        echo $this->html;
    }
}
