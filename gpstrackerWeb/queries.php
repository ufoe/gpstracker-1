<?php

$queries=array();


$queries["qta"]="SELECT * FROM atp_magazzino inner join  atp_davista_anagrafica using (item_no)  inner join atp_anagrafica_plus on (atp_davista_anagrafica.item_no=atp_anagrafica_plus.item_no) WHERE prima=1";// and atp_magazzino.stato='{stato}'
$queries["qta_jqgrid"]="SELECT * FROM atp_magazzino inner join atp_davista_anagrafica using (item_no) inner join atp_anagrafica_plus on (atp_davista_anagrafica.item_no=atp_anagrafica_plus.item_no)  WHERE prima=1 {FILTROJQGRID}";
$queries["qta_jqgrid_count"]="SELECT count(*) FROM atp_magazzino inner join  atp_davista_anagrafica using (item_no) inner join atp_anagrafica_plus on (atp_davista_anagrafica.item_no=atp_anagrafica_plus.item_no)  WHERE prima=1 {FILTROJQGRID}";
