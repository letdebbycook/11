<?php
if (!class_exists('Barter_Skt13Framework_Uni')) {
class Barter_Skt13Framework_Uni{
	function __construct(){
		add_filter( 'barter_docs_address', array( $this, 'docs_link' ), 10, 2 );
	}

	function docs_link() {
		return 'https://www.sktthemesdemo.net/documentation/barter-doc';
	}
}
}

new Barter_Skt13Framework_Uni();






