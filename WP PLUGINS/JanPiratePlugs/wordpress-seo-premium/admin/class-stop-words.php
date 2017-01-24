<?php
/**
 * @package WPSEO\Admin
 */

/**
 * Manages stop words and filtering stop words from slugs
 */
class WPSEO_Admin_Stop_Words {
	/**
	 * Removes stop words in a slug
	 *
	 * @param string $original_slug The slug to remove stop words in.
	 *
	 * @return string
	 */
	public function remove_in( $original_slug ) {
		// Turn it to an array and strip stop words by comparing against an array of stopwords.
		$new_slug_parts = array_diff( explode( '-', $original_slug ), $this->list_stop_words() );

		// Don't change the slug if there are less than 3 words left.
		if ( count( $new_slug_parts ) < 3 ) {
			return $original_slug;
		}

		// Turn the sanitized array into a string.
		$new_slug = join( '-', $new_slug_parts );

		return $new_slug;
	}

	/**
	 * Returns a translated, filtered list of stop words
	 *
	 * @return array An array of stop words.
	 */
	public function list_stop_words() {
		/* translators: this should be an array of stop words for your language, separated by comma's. */
		$stopwords = explode( ',', __( "a,abia,about,above,acea,aceasta,aceea,aceeasi,aceia,acel,acela,acelasi,acelea,acest,acesta,aceste,acestea,acestei,acestia,acestui,acolo,acum,adica,after,again,against,ai,aia,aici,aiurea,al,ala,alaturi,ale,all,alt,alta,altceva,alte,altfel,alti,altii,altul,am,an,and,anume,any,apoi,ar,are,as,asa,asemenea,asta,astazi,astfel,asupra,at,atare,ati,atit,atita,atitea,atitia,atunci,au,avea,avem,avut,azi,b,ba,be,because,been,before,being,below,between,bine,both,but,by,c,ca,cam,capat,care,careia,carora,caruia,catre,ce,cea,ceea,cei,ceilalti,cel,cele,celor,ceva,chiar,ci,cind,cine,cineva,cit,cita,cite,citeva,citi,citiva,conform,could,cu,cui,cum,cumva,d,da,daca,dar,dat,de,deasupra,deci,decit,degraba,deja,desi,despre,did,din,dintr,dintre,do,doar,does,doing,down,dupa,during,e,ea,each,ei,el,ele,era,este,eu,exact,f,face,fara,fata,fel,few,fi,fie,foarte,for,fost,from,further,g,geaba,h,had,has,have,having,he'd,he'll,he's,he,her,here's,here,hers,herself,him,himself,his,how's,how,i'd,i'll,i'm,i've,i,ia,iar,if,ii,il,imi,in,inainte,inapoi,inca,incit,insa,into,intr,intre,is,isi,it's,it,iti,its,itself,j,k,l,la,le,let's,li,lor,lui,m,ma,mai,mare,me,mi,mod,more,most,mult,multa,multe,multi,my,myself,n,ne,ni,nici,niciodata,nimeni,nimic,niste,noi,nor,nostri,nou,noua,nu,numai,o,of,on,once,only,or,ori,orice,oricum,other,ought,our,ours,ourselves,out,over,own,p,pai,parca,pe,pentru,peste,pina,plus,prea,prin,putini,r,s,sa,sai,sale,same,sau,se,she'd,she'll,she's,she,should,si,sint,sintem,so,some,spre,sub,such,sus,t,te,than,that's,that,the,their,theirs,them,themselves,then,there's,there,these,they'd,they'll,they're,they've,they,this,those,through,ti,to,toata,toate,tocmai,too,tot,toti,totul,totusi,tu,tuturor,u,un,una,unde,under,unei,unele,uneori,unii,unor,until,unui,unul,up,v,va,very,voi,vom,vor,vreo,vreun,was,we'd,we'll,we're,we've,we,were,what's,what,when's,when,where's,where,which,while,who's,who,whom,why's,why,with,would,x,you'd,you'll,you're,you've,you,your,yours,yourself,yourselves,z", 'wordpress-seo' ) );

		/**
		 * Allows filtering of the stop words list
		 * Especially useful for users on a language in which WPSEO is not available yet
		 * and/or users who want to turn off stop word filtering
		 *
		 * @api  array  $stopwords  Array of all lowercase stop words to check and/or remove from slug
		 */
		$stopwords = apply_filters( 'wpseo_stopwords', $stopwords );

		return $stopwords;
	}
}
