<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Fonts {

	const SYSTEM = 'system';
	const GOOGLE = 'googlefonts';
	const EARLYACCESS = 'earlyaccess';
	const LOCAL = 'local';

	public static function get_fonts() {
		return [
			// System fonts.
			'Arial' => self::SYSTEM,
			'Tahoma' => self::SYSTEM,
			'Verdana' => self::SYSTEM,
			'Helvetica' => self::SYSTEM,
			'Times New Roman' => self::SYSTEM,
			'Trebuchet MS' => self::SYSTEM,
			'Georgia' => self::SYSTEM,

			// Google Fonts (last update: 04/08/2016).
			'ABeeZee' => self::GOOGLE,
			'Abel' => self::GOOGLE,
			'Abril Fatface' => self::GOOGLE,
			'Aclonica' => self::GOOGLE,
			'Acme' => self::GOOGLE,
			'Actor' => self::GOOGLE,
			'Adamina' => self::GOOGLE,
			'Advent Pro' => self::GOOGLE,
			'Aguafina Script' => self::GOOGLE,
			'Akronim' => self::GOOGLE,
			'Aladin' => self::GOOGLE,
			'Aldrich' => self::GOOGLE,
			'Alef' => self::GOOGLE,
			'Alef Hebrew' => self::EARLYACCESS, // Hack for Google Early Access.
			'Alegreya' => self::GOOGLE,
			'Alegreya SC' => self::GOOGLE,
			'Alegreya Sans' => self::GOOGLE,
			'Alegreya Sans SC' => self::GOOGLE,
			'Alex Brush' => self::GOOGLE,
			'Alfa Slab One' => self::GOOGLE,
			'Alice' => self::GOOGLE,
			'Alike' => self::GOOGLE,
			'Alike Angular' => self::GOOGLE,
			'Allan' => self::GOOGLE,
			'Allerta' => self::GOOGLE,
			'Allerta Stencil' => self::GOOGLE,
			'Allura' => self::GOOGLE,
			'Almendra' => self::GOOGLE,
			'Almendra Display' => self::GOOGLE,
			'Almendra SC' => self::GOOGLE,
			'Amarante' => self::GOOGLE,
			'Amaranth' => self::GOOGLE,
			'Amatic SC' => self::GOOGLE,
			'Amatica SC' => self::GOOGLE,
			'Amethysta' => self::GOOGLE,
			'Amiko' => self::GOOGLE,
			'Amiri' => self::GOOGLE,
			'Amita' => self::GOOGLE,
			'Anaheim' => self::GOOGLE,
			'Andada' => self::GOOGLE,
			'Andika' => self::GOOGLE,
			'Angkor' => self::GOOGLE,
			'Annie Use Your Telescope' => self::GOOGLE,
			'Anonymous Pro' => self::GOOGLE,
			'Antic' => self::GOOGLE,
			'Antic Didone' => self::GOOGLE,
			'Antic Slab' => self::GOOGLE,
			'Anton' => self::GOOGLE,
			'Arapey' => self::GOOGLE,
			'Arbutus' => self::GOOGLE,
			'Arbutus Slab' => self::GOOGLE,
			'Architects Daughter' => self::GOOGLE,
			'Archivo Black' => self::GOOGLE,
			'Archivo Narrow' => self::GOOGLE,
			'Aref Ruqaa' => self::GOOGLE,
			'Arima Madurai' => self::GOOGLE,
			'Arimo' => self::GOOGLE,
			'Arizonia' => self::GOOGLE,
			'Armata' => self::GOOGLE,
			'Artifika' => self::GOOGLE,
			'Arvo' => self::GOOGLE,
			'Arya' => self::GOOGLE,
			'Asap' => self::GOOGLE,
			'Asar' => self::GOOGLE,
			'Asset' => self::GOOGLE,
			'Assistant' => self::GOOGLE,
			'Astloch' => self::GOOGLE,
			'Asul' => self::GOOGLE,
			'Athiti' => self::GOOGLE,
			'Atma' => self::GOOGLE,
			'Atomic Age' => self::GOOGLE,
			'Aubrey' => self::GOOGLE,
			'Audiowide' => self::GOOGLE,
			'Autour One' => self::GOOGLE,
			'Average' => self::GOOGLE,
			'Average Sans' => self::GOOGLE,
			'Averia Gruesa Libre' => self::GOOGLE,
			'Averia Libre' => self::GOOGLE,
			'Averia Sans Libre' => self::GOOGLE,
			'Averia Serif Libre' => self::GOOGLE,
			'Bad Script' => self::GOOGLE,
			'Baloo' => self::GOOGLE,
			'Baloo Bhai' => self::GOOGLE,
			'Baloo Da' => self::GOOGLE,
			'Baloo Thambi' => self::GOOGLE,
			'Balthazar' => self::GOOGLE,
			'Bangers' => self::GOOGLE,
			'Basic' => self::GOOGLE,
			'Battambang' => self::GOOGLE,
			'Baumans' => self::GOOGLE,
			'Bayon' => self::GOOGLE,
			'Belgrano' => self::GOOGLE,
			'Belleza' => self::GOOGLE,
			'BenchNine' => self::GOOGLE,
			'Bentham' => self::GOOGLE,
			'Berkshire Swash' => self::GOOGLE,
			'Bevan' => self::GOOGLE,
			'Bigelow Rules' => self::GOOGLE,
			'Bigshot One' => self::GOOGLE,
			'Bilbo' => self::GOOGLE,
			'Bilbo Swash Caps' => self::GOOGLE,
			'BioRhyme' => self::GOOGLE,
			'BioRhyme Expanded' => self::GOOGLE,
			'Biryani' => self::GOOGLE,
			'Bitter' => self::GOOGLE,
			'Black Ops One' => self::GOOGLE,
			'Bokor' => self::GOOGLE,
			'Bonbon' => self::GOOGLE,
			'Boogaloo' => self::GOOGLE,
			'Bowlby One' => self::GOOGLE,
			'Bowlby One SC' => self::GOOGLE,
			'Brawler' => self::GOOGLE,
			'Bree Serif' => self::GOOGLE,
			'Bubblegum Sans' => self::GOOGLE,
			'Bubbler One' => self::GOOGLE,
			'Buda' => self::GOOGLE,
			'Buenard' => self::GOOGLE,
			'Bungee' => self::GOOGLE,
			'Bungee Hairline' => self::GOOGLE,
			'Bungee Inline' => self::GOOGLE,
			'Bungee Outline' => self::GOOGLE,
			'Bungee Shade' => self::GOOGLE,
			'Butcherman' => self::GOOGLE,
			'Butterfly Kids' => self::GOOGLE,
			'Cabin' => self::GOOGLE,
			'Cabin Condensed' => self::GOOGLE,
			'Cabin Sketch' => self::GOOGLE,
			'Caesar Dressing' => self::GOOGLE,
			'Cagliostro' => self::GOOGLE,
			'Cairo' => self::GOOGLE,
			'Calligraffitti' => self::GOOGLE,
			'Cambay' => self::GOOGLE,
			'Cambo' => self::GOOGLE,
			'Candal' => self::GOOGLE,
			'Cantarell' => self::GOOGLE,
			'Cantata One' => self::GOOGLE,
			'Cantora One' => self::GOOGLE,
			'Capriola' => self::GOOGLE,
			'Cardo' => self::GOOGLE,
			'Carme' => self::GOOGLE,
			'Carrois Gothic' => self::GOOGLE,
			'Carrois Gothic SC' => self::GOOGLE,
			'Carter One' => self::GOOGLE,
			'Catamaran' => self::GOOGLE,
			'Caudex' => self::GOOGLE,
			'Caveat' => self::GOOGLE,
			'Caveat Brush' => self::GOOGLE,
			'Cedarville Cursive' => self::GOOGLE,
			'Ceviche One' => self::GOOGLE,
			'Changa' => self::GOOGLE,
			'Changa One' => self::GOOGLE,
			'Chango' => self::GOOGLE,
			'Chathura' => self::GOOGLE,
			'Chau Philomene One' => self::GOOGLE,
			'Chela One' => self::GOOGLE,
			'Chelsea Market' => self::GOOGLE,
			'Chenla' => self::GOOGLE,
			'Cherry Cream Soda' => self::GOOGLE,
			'Cherry Swash' => self::GOOGLE,
			'Chewy' => self::GOOGLE,
			'Chicle' => self::GOOGLE,
			'Chivo' => self::GOOGLE,
			'Chonburi' => self::GOOGLE,
			'Cinzel' => self::GOOGLE,
			'Cinzel Decorative' => self::GOOGLE,
			'Clicker Script' => self::GOOGLE,
			'Coda' => self::GOOGLE,
			'Coda Caption' => self::GOOGLE,
			'Codystar' => self::GOOGLE,
			'Coiny' => self::GOOGLE,
			'Combo' => self::GOOGLE,
			'Comfortaa' => self::GOOGLE,
			'Coming Soon' => self::GOOGLE,
			'Concert One' => self::GOOGLE,
			'Condiment' => self::GOOGLE,
			'Content' => self::GOOGLE,
			'Contrail One' => self::GOOGLE,
			'Convergence' => self::GOOGLE,
			'Cookie' => self::GOOGLE,
			'Copse' => self::GOOGLE,
			'Corben' => self::GOOGLE,
			'Cormorant' => self::GOOGLE,
			'Cormorant Garamond' => self::GOOGLE,
			'Cormorant Infant' => self::GOOGLE,
			'Cormorant SC' => self::GOOGLE,
			'Cormorant Unicase' => self::GOOGLE,
			'Cormorant Upright' => self::GOOGLE,
			'Courgette' => self::GOOGLE,
			'Cousine' => self::GOOGLE,
			'Coustard' => self::GOOGLE,
			'Covered By Your Grace' => self::GOOGLE,
			'Crafty Girls' => self::GOOGLE,
			'Creepster' => self::GOOGLE,
			'Crete Round' => self::GOOGLE,
			'Crimson Text' => self::GOOGLE,
			'Croissant One' => self::GOOGLE,
			'Crushed' => self::GOOGLE,
			'Cuprum' => self::GOOGLE,
			'Cutive' => self::GOOGLE,
			'Cutive Mono' => self::GOOGLE,
			'Damion' => self::GOOGLE,
			'Dancing Script' => self::GOOGLE,
			'Dangrek' => self::GOOGLE,
			'David Libre' => self::GOOGLE,
			'Dawning of a New Day' => self::GOOGLE,
			'Days One' => self::GOOGLE,
			'Dekko' => self::GOOGLE,
			'Delius' => self::GOOGLE,
			'Delius Swash Caps' => self::GOOGLE,
			'Delius Unicase' => self::GOOGLE,
			'Della Respira' => self::GOOGLE,
			'Denk One' => self::GOOGLE,
			'Devonshire' => self::GOOGLE,
			'Dhurjati' => self::GOOGLE,
			'Didact Gothic' => self::GOOGLE,
			'Diplomata' => self::GOOGLE,
			'Diplomata SC' => self::GOOGLE,
			'Domine' => self::GOOGLE,
			'Donegal One' => self::GOOGLE,
			'Doppio One' => self::GOOGLE,
			'Dorsa' => self::GOOGLE,
			'Dosis' => self::GOOGLE,
			'Dr Sugiyama' => self::GOOGLE,
			'Droid Sans' => self::GOOGLE,
			'Droid Sans Mono' => self::GOOGLE,
			'Droid Serif' => self::GOOGLE,
			'Droid Arabic Kufi' => self::EARLYACCESS,
			'Droid Arabic Naskh' => self::EARLYACCESS,
			'Duru Sans' => self::GOOGLE,
			'Dynalight' => self::GOOGLE,
			'EB Garamond' => self::GOOGLE,
			'Eagle Lake' => self::GOOGLE,
			'Eater' => self::GOOGLE,
			'Economica' => self::GOOGLE,
			'Eczar' => self::GOOGLE,
			'Ek Mukta' => self::GOOGLE,
			'El Messiri' => self::GOOGLE,
			'Electrolize' => self::GOOGLE,
			'Elsie' => self::GOOGLE,
			'Elsie Swash Caps' => self::GOOGLE,
			'Emblema One' => self::GOOGLE,
			'Emilys Candy' => self::GOOGLE,
			'Engagement' => self::GOOGLE,
			'Englebert' => self::GOOGLE,
			'Enriqueta' => self::GOOGLE,
			'Erica One' => self::GOOGLE,
			'Esteban' => self::GOOGLE,
			'Euphoria Script' => self::GOOGLE,
			'Ewert' => self::GOOGLE,
			'Exo' => self::GOOGLE,
			'Exo 2' => self::GOOGLE,
			'Expletus Sans' => self::GOOGLE,
			'Fanwood Text' => self::GOOGLE,
			'Farsan' => self::GOOGLE,
			'Fascinate' => self::GOOGLE,
			'Fascinate Inline' => self::GOOGLE,
			'Faster One' => self::GOOGLE,
			'Fasthand' => self::GOOGLE,
			'Fauna One' => self::GOOGLE,
			'Federant' => self::GOOGLE,
			'Federo' => self::GOOGLE,
			'Felipa' => self::GOOGLE,
			'Fenix' => self::GOOGLE,
			'Finger Paint' => self::GOOGLE,
			'Fira Mono' => self::GOOGLE,
			'Fira Sans' => self::GOOGLE,
			'Fjalla One' => self::GOOGLE,
			'Fjord One' => self::GOOGLE,
			'Flamenco' => self::GOOGLE,
			'Flavors' => self::GOOGLE,
			'Fondamento' => self::GOOGLE,
			'Fontdiner Swanky' => self::GOOGLE,
			'Forum' => self::GOOGLE,
			'Francois One' => self::GOOGLE,
			'Frank Ruhl Libre' => self::GOOGLE,
			'Freckle Face' => self::GOOGLE,
			'Fredericka the Great' => self::GOOGLE,
			'Fredoka One' => self::GOOGLE,
			'Freehand' => self::GOOGLE,
			'Fresca' => self::GOOGLE,
			'Frijole' => self::GOOGLE,
			'Fruktur' => self::GOOGLE,
			'Fugaz One' => self::GOOGLE,
			'GFS Didot' => self::GOOGLE,
			'GFS Neohellenic' => self::GOOGLE,
			'Gabriela' => self::GOOGLE,
			'Gafata' => self::GOOGLE,
			'Galada' => self::GOOGLE,
			'Galdeano' => self::GOOGLE,
			'Galindo' => self::GOOGLE,
			'Gentium Basic' => self::GOOGLE,
			'Gentium Book Basic' => self::GOOGLE,
			'Geo' => self::GOOGLE,
			'Geostar' => self::GOOGLE,
			'Geostar Fill' => self::GOOGLE,
			'Germania One' => self::GOOGLE,
			'Gidugu' => self::GOOGLE,
			'Gilda Display' => self::GOOGLE,
			'Give You Glory' => self::GOOGLE,
			'Glass Antiqua' => self::GOOGLE,
			'Glegoo' => self::GOOGLE,
			'Gloria Hallelujah' => self::GOOGLE,
			'Goblin One' => self::GOOGLE,
			'Gochi Hand' => self::GOOGLE,
			'Gorditas' => self::GOOGLE,
			'Goudy Bookletter 1911' => self::GOOGLE,
			'Graduate' => self::GOOGLE,
			'Grand Hotel' => self::GOOGLE,
			'Gravitas One' => self::GOOGLE,
			'Great Vibes' => self::GOOGLE,
			'Griffy' => self::GOOGLE,
			'Gruppo' => self::GOOGLE,
			'Gudea' => self::GOOGLE,
			'Gurajada' => self::GOOGLE,
			'Habibi' => self::GOOGLE,
			'Halant' => self::GOOGLE,
			'Hammersmith One' => self::GOOGLE,
			'Hanalei' => self::GOOGLE,
			'Hanalei Fill' => self::GOOGLE,
			'Handlee' => self::GOOGLE,
			'Hanuman' => self::GOOGLE,
			'Happy Monkey' => self::GOOGLE,
			'Harmattan' => self::GOOGLE,
			'Headland One' => self::GOOGLE,
			'Heebo' => self::GOOGLE,
			'Henny Penny' => self::GOOGLE,
			'Herr Von Muellerhoff' => self::GOOGLE,
			'Hind' => self::GOOGLE,
			'Hind Guntur' => self::GOOGLE,
			'Hind Madurai' => self::GOOGLE,
			'Hind Siliguri' => self::GOOGLE,
			'Hind Vadodara' => self::GOOGLE,
			'Holtwood One SC' => self::GOOGLE,
			'Homemade Apple' => self::GOOGLE,
			'Homenaje' => self::GOOGLE,
			'IM Fell DW Pica' => self::GOOGLE,
			'IM Fell DW Pica SC' => self::GOOGLE,
			'IM Fell Double Pica' => self::GOOGLE,
			'IM Fell Double Pica SC' => self::GOOGLE,
			'IM Fell English' => self::GOOGLE,
			'IM Fell English SC' => self::GOOGLE,
			'IM Fell French Canon' => self::GOOGLE,
			'IM Fell French Canon SC' => self::GOOGLE,
			'IM Fell Great Primer' => self::GOOGLE,
			'IM Fell Great Primer SC' => self::GOOGLE,
			'Iceberg' => self::GOOGLE,
			'Iceland' => self::GOOGLE,
			'Imprima' => self::GOOGLE,
			'Inconsolata' => self::GOOGLE,
			'Inder' => self::GOOGLE,
			'Indie Flower' => self::GOOGLE,
			'Inika' => self::GOOGLE,
			'Inknut Antiqua' => self::GOOGLE,
			'Irish Grover' => self::GOOGLE,
			'Istok Web' => self::GOOGLE,
			'Italiana' => self::GOOGLE,
			'Italianno' => self::GOOGLE,
			'Itim' => self::GOOGLE,
			'Jacques Francois' => self::GOOGLE,
			'Jacques Francois Shadow' => self::GOOGLE,
			'Jaldi' => self::GOOGLE,
			'Jim Nightshade' => self::GOOGLE,
			'Jockey One' => self::GOOGLE,
			'Jolly Lodger' => self::GOOGLE,
			'Jomhuria' => self::GOOGLE,
			'Josefin Sans' => self::GOOGLE,
			'Josefin Slab' => self::GOOGLE,
			'Joti One' => self::GOOGLE,
			'Judson' => self::GOOGLE,
			'Julee' => self::GOOGLE,
			'Julius Sans One' => self::GOOGLE,
			'Junge' => self::GOOGLE,
			'Jura' => self::GOOGLE,
			'Just Another Hand' => self::GOOGLE,
			'Just Me Again Down Here' => self::GOOGLE,
			'Kadwa' => self::GOOGLE,
			'Kalam' => self::GOOGLE,
			'Kameron' => self::GOOGLE,
			'Kanit' => self::GOOGLE,
			'Kantumruy' => self::GOOGLE,
			'Karla' => self::GOOGLE,
			'Karma' => self::GOOGLE,
			'Katibeh' => self::GOOGLE,
			'Kaushan Script' => self::GOOGLE,
			'Kavivanar' => self::GOOGLE,
			'Kavoon' => self::GOOGLE,
			'Kdam Thmor' => self::GOOGLE,
			'Keania One' => self::GOOGLE,
			'Kelly Slab' => self::GOOGLE,
			'Kenia' => self::GOOGLE,
			'Khand' => self::GOOGLE,
			'Khmer' => self::GOOGLE,
			'Khula' => self::GOOGLE,
			'Kite One' => self::GOOGLE,
			'Knewave' => self::GOOGLE,
			'Kotta One' => self::GOOGLE,
			'Koulen' => self::GOOGLE,
			'Kranky' => self::GOOGLE,
			'Kreon' => self::GOOGLE,
			'Kristi' => self::GOOGLE,
			'Krona One' => self::GOOGLE,
			'Kumar One' => self::GOOGLE,
			'Kumar One Outline' => self::GOOGLE,
			'Kurale' => self::GOOGLE,
			'La Belle Aurore' => self::GOOGLE,
			'Laila' => self::GOOGLE,
			'Lakki Reddy' => self::GOOGLE,
			'Lalezar' => self::GOOGLE,
			'Lancelot' => self::GOOGLE,
			'Lateef' => self::GOOGLE,
			'Lato' => self::GOOGLE,
			'League Script' => self::GOOGLE,
			'Leckerli One' => self::GOOGLE,
			'Ledger' => self::GOOGLE,
			'Lekton' => self::GOOGLE,
			'Lemon' => self::GOOGLE,
			'Lemonada' => self::GOOGLE,
			'Libre Baskerville' => self::GOOGLE,
			'Libre Franklin' => self::GOOGLE,
			'Life Savers' => self::GOOGLE,
			'Lilita One' => self::GOOGLE,
			'Lily Script One' => self::GOOGLE,
			'Limelight' => self::GOOGLE,
			'Linden Hill' => self::GOOGLE,
			'Lobster' => self::GOOGLE,
			'Lobster Two' => self::GOOGLE,
			'Londrina Outline' => self::GOOGLE,
			'Londrina Shadow' => self::GOOGLE,
			'Londrina Sketch' => self::GOOGLE,
			'Londrina Solid' => self::GOOGLE,
			'Lora' => self::GOOGLE,
			'Love Ya Like A Sister' => self::GOOGLE,
			'Loved by the King' => self::GOOGLE,
			'Lovers Quarrel' => self::GOOGLE,
			'Luckiest Guy' => self::GOOGLE,
			'Lusitana' => self::GOOGLE,
			'Lustria' => self::GOOGLE,
			'Macondo' => self::GOOGLE,
			'Macondo Swash Caps' => self::GOOGLE,
			'Mada' => self::GOOGLE,
			'Magra' => self::GOOGLE,
			'Maiden Orange' => self::GOOGLE,
			'Maitree' => self::GOOGLE,
			'Mako' => self::GOOGLE,
			'Mallanna' => self::GOOGLE,
			'Mandali' => self::GOOGLE,
			'Marcellus' => self::GOOGLE,
			'Marcellus SC' => self::GOOGLE,
			'Marck Script' => self::GOOGLE,
			'Margarine' => self::GOOGLE,
			'Marko One' => self::GOOGLE,
			'Marmelad' => self::GOOGLE,
			'Martel' => self::GOOGLE,
			'Martel Sans' => self::GOOGLE,
			'Marvel' => self::GOOGLE,
			'Mate' => self::GOOGLE,
			'Mate SC' => self::GOOGLE,
			'Maven Pro' => self::GOOGLE,
			'McLaren' => self::GOOGLE,
			'Meddon' => self::GOOGLE,
			'MedievalSharp' => self::GOOGLE,
			'Medula One' => self::GOOGLE,
			'Meera Inimai' => self::GOOGLE,
			'Megrim' => self::GOOGLE,
			'Meie Script' => self::GOOGLE,
			'Merienda' => self::GOOGLE,
			'Merienda One' => self::GOOGLE,
			'Merriweather' => self::GOOGLE,
			'Merriweather Sans' => self::GOOGLE,
			'Metal' => self::GOOGLE,
			'Metal Mania' => self::GOOGLE,
			'Metamorphous' => self::GOOGLE,
			'Metrophobic' => self::GOOGLE,
			'Michroma' => self::GOOGLE,
			'Milonga' => self::GOOGLE,
			'Miltonian' => self::GOOGLE,
			'Miltonian Tattoo' => self::GOOGLE,
			'Miniver' => self::GOOGLE,
			'Miriam Libre' => self::GOOGLE,
			'Mirza' => self::GOOGLE,
			'Miss Fajardose' => self::GOOGLE,
			'Mitr' => self::GOOGLE,
			'Modak' => self::GOOGLE,
			'Modern Antiqua' => self::GOOGLE,
			'Mogra' => self::GOOGLE,
			'Molengo' => self::GOOGLE,
			'Molle' => self::GOOGLE,
			'Monda' => self::GOOGLE,
			'Monofett' => self::GOOGLE,
			'Monoton' => self::GOOGLE,
			'Monsieur La Doulaise' => self::GOOGLE,
			'Montaga' => self::GOOGLE,
			'Montez' => self::GOOGLE,
			'Montserrat' => self::GOOGLE,
			'Montserrat Alternates' => self::GOOGLE,
			'Montserrat Subrayada' => self::GOOGLE,
			'Moul' => self::GOOGLE,
			'Moulpali' => self::GOOGLE,
			'Mountains of Christmas' => self::GOOGLE,
			'Mouse Memoirs' => self::GOOGLE,
			'Mr Bedfort' => self::GOOGLE,
			'Mr Dafoe' => self::GOOGLE,
			'Mr De Haviland' => self::GOOGLE,
			'Mrs Saint Delafield' => self::GOOGLE,
			'Mrs Sheppards' => self::GOOGLE,
			'Mukta Vaani' => self::GOOGLE,
			'Muli' => self::GOOGLE,
			'Mystery Quest' => self::GOOGLE,
			'NTR' => self::GOOGLE,
			'Neucha' => self::GOOGLE,
			'Neuton' => self::GOOGLE,
			'New Rocker' => self::GOOGLE,
			'News Cycle' => self::GOOGLE,
			'Niconne' => self::GOOGLE,
			'Nixie One' => self::GOOGLE,
			'Nobile' => self::GOOGLE,
			'Nokora' => self::GOOGLE,
			'Norican' => self::GOOGLE,
			'Nosifer' => self::GOOGLE,
			'Nothing You Could Do' => self::GOOGLE,
			'Noticia Text' => self::GOOGLE,
			'Noto Sans' => self::GOOGLE,
			'Noto Sans Hebrew' => self::EARLYACCESS,
			'Noto Serif' => self::GOOGLE,
			'Noto Kufi Arabic' => self::EARLYACCESS,
			'Noto Naskh Arabic' => self::EARLYACCESS,
			'Nova Cut' => self::GOOGLE,
			'Nova Flat' => self::GOOGLE,
			'Nova Mono' => self::GOOGLE,
			'Nova Oval' => self::GOOGLE,
			'Nova Round' => self::GOOGLE,
			'Nova Script' => self::GOOGLE,
			'Nova Slim' => self::GOOGLE,
			'Nova Square' => self::GOOGLE,
			'Numans' => self::GOOGLE,
			'Nunito' => self::GOOGLE,
			'Odor Mean Chey' => self::GOOGLE,
			'Offside' => self::GOOGLE,
			'Old Standard TT' => self::GOOGLE,
			'Oldenburg' => self::GOOGLE,
			'Oleo Script' => self::GOOGLE,
			'Oleo Script Swash Caps' => self::GOOGLE,
			'Open Sans' => self::GOOGLE,
			'Open Sans Hebrew' => self::EARLYACCESS,
			'Open Sans Condensed' => self::GOOGLE,
			'Open Sans Hebrew Condensed' => self::EARLYACCESS,
			'Oranienbaum' => self::GOOGLE,
			'Orbitron' => self::GOOGLE,
			'Oregano' => self::GOOGLE,
			'Orienta' => self::GOOGLE,
			'Original Surfer' => self::GOOGLE,
			'Oswald' => self::GOOGLE,
			'Over the Rainbow' => self::GOOGLE,
			'Overlock' => self::GOOGLE,
			'Overlock SC' => self::GOOGLE,
			'Ovo' => self::GOOGLE,
			'Oxygen' => self::GOOGLE,
			'Oxygen Mono' => self::GOOGLE,
			'PT Mono' => self::GOOGLE,
			'PT Sans' => self::GOOGLE,
			'PT Sans Caption' => self::GOOGLE,
			'PT Sans Narrow' => self::GOOGLE,
			'PT Serif' => self::GOOGLE,
			'PT Serif Caption' => self::GOOGLE,
			'Pacifico' => self::GOOGLE,
			'Palanquin' => self::GOOGLE,
			'Palanquin Dark' => self::GOOGLE,
			'Paprika' => self::GOOGLE,
			'Parisienne' => self::GOOGLE,
			'Passero One' => self::GOOGLE,
			'Passion One' => self::GOOGLE,
			'Pathway Gothic One' => self::GOOGLE,
			'Patrick Hand' => self::GOOGLE,
			'Patrick Hand SC' => self::GOOGLE,
			'Pattaya' => self::GOOGLE,
			'Patua One' => self::GOOGLE,
			'Pavanam' => self::GOOGLE,
			'Paytone One' => self::GOOGLE,
			'Peddana' => self::GOOGLE,
			'Peralta' => self::GOOGLE,
			'Permanent Marker' => self::GOOGLE,
			'Petit Formal Script' => self::GOOGLE,
			'Petrona' => self::GOOGLE,
			'Philosopher' => self::GOOGLE,
			'Piedra' => self::GOOGLE,
			'Pinyon Script' => self::GOOGLE,
			'Pirata One' => self::GOOGLE,
			'Plaster' => self::GOOGLE,
			'Play' => self::GOOGLE,
			'Playball' => self::GOOGLE,
			'Playfair Display' => self::GOOGLE,
			'Playfair Display SC' => self::GOOGLE,
			'Podkova' => self::GOOGLE,
			'Poiret One' => self::GOOGLE,
			'Poller One' => self::GOOGLE,
			'Poly' => self::GOOGLE,
			'Pompiere' => self::GOOGLE,
			'Pontano Sans' => self::GOOGLE,
			'Poppins' => self::GOOGLE,
			'Port Lligat Sans' => self::GOOGLE,
			'Port Lligat Slab' => self::GOOGLE,
			'Pragati Narrow' => self::GOOGLE,
			'Prata' => self::GOOGLE,
			'Preahvihear' => self::GOOGLE,
			'Press Start 2P' => self::GOOGLE,
			'Pridi' => self::GOOGLE,
			'Princess Sofia' => self::GOOGLE,
			'Prociono' => self::GOOGLE,
			'Prompt' => self::GOOGLE,
			'Prosto One' => self::GOOGLE,
			'Proza Libre' => self::GOOGLE,
			'Puritan' => self::GOOGLE,
			'Purple Purse' => self::GOOGLE,
			'Quando' => self::GOOGLE,
			'Quantico' => self::GOOGLE,
			'Quattrocento' => self::GOOGLE,
			'Quattrocento Sans' => self::GOOGLE,
			'Questrial' => self::GOOGLE,
			'Quicksand' => self::GOOGLE,
			'Quintessential' => self::GOOGLE,
			'Qwigley' => self::GOOGLE,
			'Racing Sans One' => self::GOOGLE,
			'Radley' => self::GOOGLE,
			'Rajdhani' => self::GOOGLE,
			'Rakkas' => self::GOOGLE,
			'Raleway' => self::GOOGLE,
			'Raleway Dots' => self::GOOGLE,
			'Ramabhadra' => self::GOOGLE,
			'Ramaraja' => self::GOOGLE,
			'Rambla' => self::GOOGLE,
			'Rammetto One' => self::GOOGLE,
			'Ranchers' => self::GOOGLE,
			'Rancho' => self::GOOGLE,
			'Ranga' => self::GOOGLE,
			'Rasa' => self::GOOGLE,
			'Rationale' => self::GOOGLE,
			'Ravi Prakash' => self::GOOGLE,
			'Redressed' => self::GOOGLE,
			'Reem Kufi' => self::GOOGLE,
			'Reenie Beanie' => self::GOOGLE,
			'Revalia' => self::GOOGLE,
			'Rhodium Libre' => self::GOOGLE,
			'Ribeye' => self::GOOGLE,
			'Ribeye Marrow' => self::GOOGLE,
			'Righteous' => self::GOOGLE,
			'Risque' => self::GOOGLE,
			'Roboto' => self::GOOGLE,
			'Roboto Condensed' => self::GOOGLE,
			'Roboto Mono' => self::GOOGLE,
			'Roboto Slab' => self::GOOGLE,
			'Rochester' => self::GOOGLE,
			'Rock Salt' => self::GOOGLE,
			'Rokkitt' => self::GOOGLE,
			'Romanesco' => self::GOOGLE,
			'Ropa Sans' => self::GOOGLE,
			'Rosario' => self::GOOGLE,
			'Rosarivo' => self::GOOGLE,
			'Rouge Script' => self::GOOGLE,
			'Rozha One' => self::GOOGLE,
			'Rubik' => self::GOOGLE,
			'Rubik Mono One' => self::GOOGLE,
			'Rubik One' => self::GOOGLE,
			'Ruda' => self::GOOGLE,
			'Rufina' => self::GOOGLE,
			'Ruge Boogie' => self::GOOGLE,
			'Ruluko' => self::GOOGLE,
			'Rum Raisin' => self::GOOGLE,
			'Ruslan Display' => self::GOOGLE,
			'Russo One' => self::GOOGLE,
			'Ruthie' => self::GOOGLE,
			'Rye' => self::GOOGLE,
			'Sacramento' => self::GOOGLE,
			'Sahitya' => self::GOOGLE,
			'Sail' => self::GOOGLE,
			'Salsa' => self::GOOGLE,
			'Sanchez' => self::GOOGLE,
			'Sancreek' => self::GOOGLE,
			'Sansita One' => self::GOOGLE,
			'Sarala' => self::GOOGLE,
			'Sarina' => self::GOOGLE,
			'Sarpanch' => self::GOOGLE,
			'Satisfy' => self::GOOGLE,
			'Scada' => self::GOOGLE,
			'Scheherazade' => self::GOOGLE,
			'Schoolbell' => self::GOOGLE,
			'Scope One' => self::GOOGLE,
			'Seaweed Script' => self::GOOGLE,
			'Secular One' => self::GOOGLE,
			'Sevillana' => self::GOOGLE,
			'Seymour One' => self::GOOGLE,
			'Shadows Into Light' => self::GOOGLE,
			'Shadows Into Light Two' => self::GOOGLE,
			'Shanti' => self::GOOGLE,
			'Share' => self::GOOGLE,
			'Share Tech' => self::GOOGLE,
			'Share Tech Mono' => self::GOOGLE,
			'Shojumaru' => self::GOOGLE,
			'Short Stack' => self::GOOGLE,
			'Shrikhand' => self::GOOGLE,
			'Siemreap' => self::GOOGLE,
			'Sigmar One' => self::GOOGLE,
			'Signika' => self::GOOGLE,
			'Signika Negative' => self::GOOGLE,
			'Simonetta' => self::GOOGLE,
			'Sintony' => self::GOOGLE,
			'Sirin Stencil' => self::GOOGLE,
			'Six Caps' => self::GOOGLE,
			'Skranji' => self::GOOGLE,
			'Slabo 13px' => self::GOOGLE,
			'Slabo 27px' => self::GOOGLE,
			'Slackey' => self::GOOGLE,
			'Smokum' => self::GOOGLE,
			'Smythe' => self::GOOGLE,
			'Sniglet' => self::GOOGLE,
			'Snippet' => self::GOOGLE,
			'Snowburst One' => self::GOOGLE,
			'Sofadi One' => self::GOOGLE,
			'Sofia' => self::GOOGLE,
			'Sonsie One' => self::GOOGLE,
			'Sorts Mill Goudy' => self::GOOGLE,
			'Source Code Pro' => self::GOOGLE,
			'Source Sans Pro' => self::GOOGLE,
			'Source Serif Pro' => self::GOOGLE,
			'Space Mono' => self::GOOGLE,
			'Special Elite' => self::GOOGLE,
			'Spicy Rice' => self::GOOGLE,
			'Spinnaker' => self::GOOGLE,
			'Spirax' => self::GOOGLE,
			'Squada One' => self::GOOGLE,
			'Sree Krushnadevaraya' => self::GOOGLE,
			'Sriracha' => self::GOOGLE,
			'Stalemate' => self::GOOGLE,
			'Stalinist One' => self::GOOGLE,
			'Stardos Stencil' => self::GOOGLE,
			'Stint Ultra Condensed' => self::GOOGLE,
			'Stint Ultra Expanded' => self::GOOGLE,
			'Stoke' => self::GOOGLE,
			'Strait' => self::GOOGLE,
			'Sue Ellen Francisco' => self::GOOGLE,
			'Suez One' => self::GOOGLE,
			'Sumana' => self::GOOGLE,
			'Sunshiney' => self::GOOGLE,
			'Supermercado One' => self::GOOGLE,
			'Sura' => self::GOOGLE,
			'Suranna' => self::GOOGLE,
			'Suravaram' => self::GOOGLE,
			'Suwannaphum' => self::GOOGLE,
			'Swanky and Moo Moo' => self::GOOGLE,
			'Syncopate' => self::GOOGLE,
			'Tangerine' => self::GOOGLE,
			'Taprom' => self::GOOGLE,
			'Tauri' => self::GOOGLE,
			'Taviraj' => self::GOOGLE,
			'Teko' => self::GOOGLE,
			'Telex' => self::GOOGLE,
			'Tenali Ramakrishna' => self::GOOGLE,
			'Tenor Sans' => self::GOOGLE,
			'Text Me One' => self::GOOGLE,
			'The Girl Next Door' => self::GOOGLE,
			'Tienne' => self::GOOGLE,
			'Tillana' => self::GOOGLE,
			'Timmana' => self::GOOGLE,
			'Tinos' => self::GOOGLE,
			'Titan One' => self::GOOGLE,
			'Titillium Web' => self::GOOGLE,
			'Trade Winds' => self::GOOGLE,
			'Trirong' => self::GOOGLE,
			'Trocchi' => self::GOOGLE,
			'Trochut' => self::GOOGLE,
			'Trykker' => self::GOOGLE,
			'Tulpen One' => self::GOOGLE,
			'Ubuntu' => self::GOOGLE,
			'Ubuntu Condensed' => self::GOOGLE,
			'Ubuntu Mono' => self::GOOGLE,
			'Ultra' => self::GOOGLE,
			'Uncial Antiqua' => self::GOOGLE,
			'Underdog' => self::GOOGLE,
			'Unica One' => self::GOOGLE,
			'UnifrakturCook' => self::GOOGLE,
			'UnifrakturMaguntia' => self::GOOGLE,
			'Unkempt' => self::GOOGLE,
			'Unlock' => self::GOOGLE,
			'Unna' => self::GOOGLE,
			'VT323' => self::GOOGLE,
			'Vampiro One' => self::GOOGLE,
			'Varela' => self::GOOGLE,
			'Varela Round' => self::GOOGLE,
			'Vast Shadow' => self::GOOGLE,
			'Vesper Libre' => self::GOOGLE,
			'Vibur' => self::GOOGLE,
			'Vidaloka' => self::GOOGLE,
			'Viga' => self::GOOGLE,
			'Voces' => self::GOOGLE,
			'Volkhov' => self::GOOGLE,
			'Vollkorn' => self::GOOGLE,
			'Voltaire' => self::GOOGLE,
			'Waiting for the Sunrise' => self::GOOGLE,
			'Wallpoet' => self::GOOGLE,
			'Walter Turncoat' => self::GOOGLE,
			'Warnes' => self::GOOGLE,
			'Wellfleet' => self::GOOGLE,
			'Wendy One' => self::GOOGLE,
			'Wire One' => self::GOOGLE,
			'Work Sans' => self::GOOGLE,
			'Yanone Kaffeesatz' => self::GOOGLE,
			'Yantramanav' => self::GOOGLE,
			'Yatra One' => self::GOOGLE,
			'Yellowtail' => self::GOOGLE,
			'Yeseva One' => self::GOOGLE,
			'Yesteryear' => self::GOOGLE,
			'Yrsa' => self::GOOGLE,
			'Zeyada' => self::GOOGLE,
		];
	}

	public static function get_font_type( $name ) {
		if ( empty( self::get_fonts()[ $name ] ) )
			return false;

		return self::get_fonts()[ $name ];
	}

	public static function get_fonts_by_groups( $groups = [] ) {
		return array_filter( self::get_fonts(), function( $font ) use ( $groups ) {
			return in_array( $font, $groups );
		} );
	}
}
