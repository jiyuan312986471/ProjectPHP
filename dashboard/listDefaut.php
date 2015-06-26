<?php

	// defaut list
	$listDefautConfig = array(
												998 => array(
																"Nom" 			 => "Ressort",
																"Nom Abrege" => "Ressort",
																"Status"		 => "K"
															 ),
												985 => array(
																"Nom" 			 => "2 Circuit Mobile",
																"Nom Abrege" => "2 Circ",
																"Status"		 => "K"
															 ),
												201 => array(
																"Nom" 			 => "Battement",
																"Nom Abrege" => "Bat",
																"Status"		 => "D12"
															 ),
												 32 => array(
																"Nom" 			 => "Impedance",
																"Nom Abrege" => "Impe",
																"Status"		 => "D12"
															 ),
												211 => array(
																"Nom" 			 => "Defaut Appel Maintien",
																"Nom Abrege" => "Defaut Appel",
																"Status"		 => "D3"
															 ),
												282 => array(
																"Nom" 			 => "Courant Appel Trop Long",
																"Nom Abrege" => "Appel Trop Long",
																"Status"		 => "D3"
															 )
											);
	$listCodeDefaut = array_keys($listDefautConfig);

?>