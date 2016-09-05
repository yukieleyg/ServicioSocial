<?php
header("Content-disposition: attachment; filename=documento.txt");
header("Content-type: application/txt");
readfile("documento.txt");
?>