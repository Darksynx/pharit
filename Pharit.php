<?php
  
  /* 
  création d'un phar qui va contenir des fichier d'installation 
  le format phar et un format natif de PHP et compatible
  */

	echo 'Archivage des fichiers conetenu dans le dossier \'phar\' ', PHP_EOL;
	
  
	$p = new Phar('data.phar', FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, 'data.phar');	
	$p->hasMetadata();
	$p->startBuffering();
	// cette section indique le prmier fichier à executé si on appel le phar avec un include comme un fichier .php
	$p->setStub('<? Phar::mapPhar(); phar://data.phar/index.php; __HALT_COMPILER(); ?>');
	$p->buildFromDirectory('phar'); // le dossier qui contient les fichiers à ajouter dans le .phar
	$p->compressFiles(Phar::GZ); // le system de compression
	
	// la signature pour un contenu pro il est préférable Phar::OPENSSL  
	// voir la doc http://php.net/manual/fr/phar.setsignaturealgorithm.php
	$p->setSignatureAlgorithm(Phar::SHA512); 
	$p->stopBuffering();
	
	
	echo 'Wait sec ...', PHP_EOL;

	echo PHP_EOL,PHP_EOL, '=== FINISH PHARIT ! ===', PHP_EOL,PHP_EOL;
	
	include 'data.phar';
	
	
	sleep(5);
	exit();
?>
