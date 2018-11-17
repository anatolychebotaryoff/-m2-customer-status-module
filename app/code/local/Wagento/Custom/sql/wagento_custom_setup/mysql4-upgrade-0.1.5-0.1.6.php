<?php
try{
    $installer = $this;
    $installer->startSetup();

	/*ADD EVALUATE YOUR WATER PAGE*/

    $content = <<<EOD
<!--add Evaluate your Water -->
<div class="title">Choose your Filter</div>
<div class="content">
	<div class="para intro"?>
		You can find the impurities or contaminants in your water within the left
		column. The right column will present filtration options to reduce the
		impurities or contaminants.
	</div>

	<div class="para">
		<table align="center" class="price1" style="width: 546px;">
			<tbody>
				<tr>
					<th class="price2" width="121">Impurity</th>
	
					<th class="price2" width="418">Water Filter System:</th>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Sediment</span> (extra-fine dirt, sand,
						sediment, silt, rust particles, scale particles)<br>
						<br>
						<span style="font-weight: bold;">Point of entry</span>
						(<a href="http://www.waterfilters.net/Whole-House-Water-Filters.html">whole
							house</a>)</td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Residential (10 inch housing)</span><br>
						<span style="font-weight: bold;">a)</span> ¾ in. Standard or
						<a href=
							"http://www.waterfilters.net/Culligan-HF-360-Wholehouse-Filter-System.html">
							¾ in. Valve in Head Filter</a> Housing with sediment filter
						cartridge (eg. <a href=
							"http://www.waterfilters.net/Culligan-Pentek-S1-Sediment-Filter.html">
							S1</a> or <a href=
							"http://www.waterfilters.net/Pentek-P5-Sediment-Water-Filter.html">
							P5</a>); or<br>
						<span style="font-weight: bold;">b)</span> <a href=
							"http://www.waterfilters.net/HD-950-1-Wholehouse-Filter-System.html">
							1 in. Big Blue Filter Housing</a> with sediment cartridge (eg.
						<a href=
							"http://www.waterfilters.net/Pentek-S1-BB-Sediment-Water-Filter.html">
							S1-BB</a> or <a href=
							"http://www.waterfilters.net/Pentek-DGD-5005-Water-Filter.html">
							DGD-5005</a>).<br>
						<br>
						<span style="font-weight: bold;">Commercial (20 inch
							housing)</span><br>
						<span style="font-weight: bold;">a)</span> <a href=
							"http://www.waterfilters.net/20-Standard-Wholehouse-Water-Filter-System.html">
							¾ in. Standard Housing</a> with sediment filter cartridge (eg.
						<a href=
							"http://www.waterfilters.net/Pentek-S1-20-Water-Filters.html">S1-20</a>,
						<a href=
							"http://www.waterfilters.net/Pentek-P5-20-Sediment-Water-Filters.html">
							P5-20</a>); or<br>
						<span style="font-weight: bold;">b)</span> <a href=
							"http://www.waterfilters.net/HD-950-1-Wholehouse-Filter-System.html">
							1 in. Big Blue Filter Housing</a> with sediment cartridge (eg.
						<a href=
							"http://www.waterfilters.net/Pentek-S120-BB-Sediment-Water-Filter.html">
							S120-BB</a> or <a href=
							"http://www.waterfilters.net/Pentek-DGD-5005-20-Sediment-Filter.html">
							DGD-5005-20)</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Sediment</span> (extra-fine dirt, sand,
						sediment, silt, rust particles, scale particles)<br>
						<br>
						<span style="font-weight: bold;">Point of use</span> (eg.
						faucet, shower, ...)</td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, <a href=
							"http://www.waterfilters.net/Culligan-US-600-Under-Sink-Filter-System.html">
							US-600</a>, and easy change under sink system <a href=
							"http://www.waterfilters.net/Culligan-SY-1000-Water-Filter-System.html">
							SY-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Counter top -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-CT-2-Countertop-Water-Filter-System.html">
							CT-2</a>.<br>
						<br>
						<span style="font-weight: bold;">Faucet mount -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-FM-5-Faucet-Water-Filter-System.html">
							FM-5</a> and <a href=
							"http://www.waterfilters.net/Culligan-FM-15-Faucet-Water-Filter-System.html">
							FM-15</a>.<br>
						<br>
						<span style="font-weight: bold;">Water pitcher -</span>
						eg.<a href=
							"http://www.waterfilters.net/Water-Filtration-Pitcher.html">OP-1</a>.<br>
						<br>
						<span style="font-weight: bold;">Inline/Icemaker -</span>
						eg.<a href=
							"http://www.waterfilters.net/Culligan-IC-750-Inline-Water-Filter.html">IC-750</a>
						and <a href=
							"http://www.waterfilters.net/Culligan-IC-1000-Easy-Change-Filter-System.html">
							IC-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">RV/Marine -</span> eg.
						<a href="http://www.waterfilters.net/Culligan-US-316-RV-Marine-Water-Treatment-System.html">
							US-316</a>, <a href=
							"http://www.waterfilters.net/Culligan-RV-750-RV-Water-Filter-System.html">
							RV-750</a>, and <a href=
							"http://www.waterfilters.net/Culligan-RV-1000-RV-Water-Filter-System.html">
							RV-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Sport Bottle -</span>
						eg.<a href=
							"http://www.waterfilters.net/Water-Filter-Water-Bottle.html">SB-2</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Bad Taste and Odor, and
							Chlorine</span><br>
						<br>
						<span style="font-weight: bold;">Point of entry</span>
						(<a href="http://www.waterfilters.net/Whole-House-Water-Filters.html">whole
							house</a>)</td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Residential (10 inch housing)</span><br>
						<span style="font-weight: bold;">a)</span> ¾ in. Standard or
						<a href=
							"http://www.waterfilters.net/Culligan-HF-360-Wholehouse-Filter-System.html">
							¾ in. Valve in Head Filter</a> Housing with carbon filter
						cartridge (eg. <a href=
							"http://www.waterfilters.net/Pentek-GAC-10-Drinking-Water-Filter.html">
							GAC-10</a>); or<br>
						<span style="font-weight: bold;">b)</span> <a href=
							"http://www.waterfilters.net/HD-950-1-Wholehouse-Filter-System.html">
							1 in. Big Blue Filter Housing</a> with carbon cartridge (eg.
						<a href=
							"http://www.waterfilters.net/Pentek-Culligan-RFC-BB-Water-Filters.html"
							target="_parent">RFC-BB</a>).<br>
						<br>
						<span style="font-weight: bold;">Commercial (20 inch
							housing)</span><br>
						<span style="font-weight: bold;">a)</span> <a href=
							"http://www.waterfilters.net/20-Standard-Wholehouse-Water-Filter-System.html">
							¾ in. Standard Housing</a> with carbon filter cartridge (eg.
						<a href=
							"http://www.waterfilters.net/Pentek-RFC-20-Water-Filters.html"
							target="_parent">RFC-20</a>); or<br>
						<span style="font-weight: bold;">b)</span> <a href=
							"http://www.waterfilters.net/HD-950-1-Wholehouse-Filter-System.html">
							1 in. Big Blue Filter Housing</a> with carbon cartridge (eg.
						<a href=
							"http://www.waterfilters.net/Pentek-RFC-20BB-Water-Filters.html"
							target="_parent">RFC-20BB</a> <a href=
							"http://www.waterfilters.net/Pentek-DGD-5005-20-Sediment-Filter.html">
							)</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Bad Taste and Odor, and
							Chlorine</span><br>
						<br>
						<span style="font-weight: bold;">Point of use</span> (eg.
						faucet, shower, ...)</td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, <a href=
							"http://www.waterfilters.net/Culligan-US-600-Under-Sink-Filter-System.html">
							US-600</a>, <a href=
							"http://www.waterfilters.net/Culligan-US-550-Undersink-Filter-System.html">
							US-550</a> and easy change under sink system <a href=
							"http://www.waterfilters.net/Culligan-SY-1000-Water-Filter-System.html">
							SY-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Counter top -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-CT-2-Countertop-Water-Filter-System.html">
							CT-2</a>.<br>
						<br>
						<span style="font-weight: bold;">Faucet mount -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-FM-5-Faucet-Water-Filter-System.html">
							FM-5</a> and <a href=
							"http://www.waterfilters.net/Culligan-FM-15-Faucet-Water-Filter-System.html">
							FM-15</a>.<br>
						<br>
						<span style="font-weight: bold;">Water pitcher -</span> eg.
						<a href=
							"http://www.waterfilters.net/Water-Filtration-Pitcher.html">OP-1</a>.<br>
						<br>
						<span style="font-weight: bold;">Inline/Icemaker -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-IC-750-Inline-Water-Filter.html">
							IC-750</a>, <a href=
							"http://www.waterfilters.net/Culligan-IC-100-Inline-Water-Filter.html">
							IC-100</a>, and <a href=
							"http://www.waterfilters.net/Culligan-IC-1000-Easy-Change-Filter-System.html">
							IC-1000</a>.<br>
						<br>
						<span style="font-weight: bold;"><a href=
								"http://www.waterfilters.net/Refrigerator-Water-Filters.html">Refrigerator
								Filters</a> -</span> eg.<a href=
							"http://www.waterfilters.net/GE-Culligan-FXRC-Refrigerator-Filter.html">FXRC</a>,
						and <a href=
							"http://www.waterfilters.net/GE-Culligan-FXRT-Refrigerator-Water-Filter.html">
							FXRT</a>.<br>
						<br>
						<span style="font-weight: bold;">Shower -</span> eg. <a href=
							"http://www.waterfilters.net/Shower-Filter-Systems.html">SR-115</a>.<br>
						<br>
						<span style="font-weight: bold;">RV/Marine -</span> eg.
						<a href="http://www.waterfilters.net/Culligan-US-316-RV-Marine-Water-Treatment-System.html">
							US-316</a>, <a href=
							"http://www.waterfilters.net/Culligan-RV-750-RV-Water-Filter-System.html">
							RV-750</a>, and <a href=
							"http://www.waterfilters.net/Culligan-RV-1000-RV-Water-Filter-System.html">
							RV-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Sport Bottle -</span> eg.
						<a href=
							"http://www.waterfilters.net/Water-Filter-Water-Bottle.html">SB-2</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Asbestos</span></td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, <a href=
							"http://www.waterfilters.net/Culligan-D-40-Replacement-Water-Filter.html">
							D-40</a>, and <a href=
							"http://www.waterfilters.net/Culligan-D-30-Water-Filter-Replacement.html">
							D-30</a>.<br>
						<br>
						<span style="font-weight: bold;">Counter top -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-CT-2-Countertop-Water-Filter-System.html">
							CT-2</a>.<br>
						<br>
						<span style="font-weight: bold;">Faucet mount -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-FM-5-Faucet-Water-Filter-System.html">
							FM-5</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Atrazine</span> and Lindane (herbicides
						and pesticides)</td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, easy change under sink system <a href=
							"http://www.waterfilters.net/Culligan-SY-1000-Water-Filter-System.html">
							SY-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Faucet mount -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-FM-15-Faucet-Water-Filter-System.html">
							FM-15</a>.<br>
						<br>
						<span style="font-weight: bold;">Inline/Icemaker -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-IC-750-Inline-Water-Filter.html">
							IC-750</a> and <a href=
							"http://www.waterfilters.net/Culligan-IC-1000-Easy-Change-Filter-System.html">
							IC-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">RV/Marine -</span> eg.
						<a href="http://www.waterfilters.net/Culligan-RV-1000-RV-Water-Filter-System.html">
							RV-1000</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Bacteria</span> (Lindane, Atrazine,
						herbicides, and pesticides)</td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, <a href=
							"http://www.waterfilters.net/Culligan-US-600-Under-Sink-Filter-System.html">
							US-600</a>, and easy change <a href=
							"http://www.waterfilters.net/Culligan-SY-1000-Water-Filter-System.html">
							SY-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Faucet mount -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-FM-5-Faucet-Water-Filter-System.html">
							FM-5</a> and <a href=
							"http://www.waterfilters.net/Culligan-FM-15-Faucet-Water-Filter-System.html">
							FM-15</a>.<br>
						<br>
						<span style="font-weight: bold;">Inline/Icemaker -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-IC-750-Inline-Water-Filter.html">
							IC-750</a> and <a href=
							"http://www.waterfilters.net/Culligan-IC-1000-Easy-Change-Filter-System.html">
							IC-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">RV/Marine -</span> eg.
						<a href="http://www.waterfilters.net/Culligan-RV-1000-RV-Water-Filter-System.html">
							RV-1000</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Chemicals</span></td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, and easy change under sink system <a href=
							"http://www.waterfilters.net/Culligan-SY-1000-Water-Filter-System.html">
							SY-1000</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Chlorine: Taste and Odor</span><br>
						<br>
						<span style="font-weight: bold;">Point of entry</span>
						(<a href="http://www.waterfilters.net/Whole-House-Water-Filters.html">whole
							house</a>)</td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Residential (10 inch housing)</span><br>
						<span style="font-weight: bold;">a)</span> ¾ in. Standard or
						<a href=
							"http://www.waterfilters.net/Culligan-HF-360-Wholehouse-Filter-System.html">
							¾ in. Valve in Head Filter</a> Housing with carbon filter
						cartridge (eg. <a href=
							"http://www.waterfilters.net/Pentek-GAC-10-Drinking-Water-Filter.html">
							GAC-10</a>); or<br>
						<span style="font-weight: bold;">b)</span> <a href=
							"http://www.waterfilters.net/HD-950-1-Wholehouse-Filter-System.html">
							1 in. Big Blue Filter Housing</a> with carbon cartridge (eg.
						<a href=
							"http://www.waterfilters.net/Pentek-Culligan-RFC-BB-Water-Filters.html"
							target="_parent">RFC-BB</a>).<br>
						<br>
						<span style="font-weight: bold;">Commercial (20 inch
							housing)</span><br>
						<span style="font-weight: bold;">a)</span> <a href=
							"http://www.waterfilters.net/20-Standard-Wholehouse-Water-Filter-System.html">
							¾ in. Standard Housing</a> with carbon filter cartridge (eg.
						<a href=
							"http://www.waterfilters.net/Pentek-RFC-20-Water-Filters.html"
							target="_parent">RFC-20</a>); or<br>
						<span style="font-weight: bold;">b)</span> <a href=
							"http://www.waterfilters.net/HD-950-1-Wholehouse-Filter-System.html">
							1 in. Big Blue Filter Housing</a> with carbon cartridge (eg.
						<a href=
							"http://www.waterfilters.net/Pentek-RFC-20BB-Water-Filters.html"
							target="_parent">RFC-20BB</a> <a href=
							"http://www.waterfilters.net/Pentek-DGD-5005-20-Sediment-Filter.html">
							)</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Chlorine: Taste and Odor</span><br>
						<br>
						<span style="font-weight: bold;">Point of use</span> (eg.
						faucet, shower, ...)</td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, <a href=
							"http://www.waterfilters.net/Culligan-US-600-Under-Sink-Filter-System.html">
							US-600</a>, <a href=
							"http://www.waterfilters.net/Culligan-US-550-Undersink-Filter-System.html">
							US-550</a> and easy change under sink system <a href=
							"http://www.waterfilters.net/Culligan-US-550-Undersink-Filter-System.html">
							SY-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Counter top -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-CT-2-Countertop-Water-Filter-System.html">
							CT-2</a>.<br>
						<br>
						<span style="font-weight: bold;">Faucet mount -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-FM-5-Faucet-Water-Filter-System.html">
							FM-5</a> or <a href=
							"http://www.waterfilters.net/Culligan-FM-15-Faucet-Water-Filter-System.html">
							FM-15</a>.<br>
						<br>
						<span style="font-weight: bold;">Water pitcher -</span> eg.
						<a href=
							"http://www.waterfilters.net/Water-Filtration-Pitcher.html">OP-1</a>.<br>
						<br>
						<span style="font-weight: bold;">Inline/Icemaker -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-IC-750-Inline-Water-Filter.html">
							IC-750</a>, <a href=
							"http://www.waterfilters.net/Culligan-IC-100-Inline-Water-Filter.html">
							IC-100</a>, and <a href=
							"http://www.waterfilters.net/Culligan-IC-1000-Easy-Change-Filter-System.html">
							IC-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Fridge -</span> eg. <a href=
							"http://www.waterfilters.net/GE-Culligan-FXRC-Refrigerator-Filter.html">
							FXRC</a>, and <a href=
							"http://www.waterfilters.net/GE-Culligan-FXRT-Refrigerator-Water-Filter.html">
							FXRT</a>.<br>
						<br>
						<span style="font-weight: bold;">Shower -</span> eg. <a href=
							"http://www.waterfilters.net/Shower-Filter-Systems.html">SR-115</a>.<br>
						<br>
						<span style="font-weight: bold;">RV/Marine -</span> eg.
						<a href="http://www.waterfilters.net/Culligan-US-316-RV-Marine-Water-Treatment-System.html">
							US-316</a>, <a href=
							"http://www.waterfilters.net/Culligan-RV-750-RV-Water-Filter-System.html">
							RV-750</a>, and <a href=
							"http://www.waterfilters.net/Culligan-RV-1000-RV-Water-Filter-System.html">
							RV-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Sport Bottle -</span> eg.
						<a href=
							"http://www.waterfilters.net/Water-Filter-Water-Bottle.html">SB-2</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Copper</span></td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Water pitcher -</span> eg. <a href=
							"http://www.waterfilters.net/Water-Filtration-Pitcher.html">OP-1</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Cryptosporidium and Giardia
							Cysts</span></td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, and easy change <a href=
							"http://www.waterfilters.net/Culligan-SY-1000-Water-Filter-System.html">
							SY-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Counter top -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-CT-2-Countertop-Water-Filter-System.html">
							CT-2</a>.<br>
						<br>
						<span style="font-weight: bold;">Faucet mount -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-FM-5-Faucet-Water-Filter-System.html">
							FM-5</a> or <a href=
							"http://www.waterfilters.net/Culligan-FM-15-Faucet-Water-Filter-System.html">
							FM-15</a>.<br>
						<br>
						<span style="font-weight: bold;">Inline/Icemaker -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-IC-750-Inline-Water-Filter.html">
							IC-750</a> and <a href=
							"http://www.waterfilters.net/Culligan-IC-1000-Easy-Change-Filter-System.html">
							IC-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">RV/Marine -</span> eg.
						<a href="http://www.waterfilters.net/Culligan-RV-1000-RV-Water-Filter-System.html">
							RV-1000</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Giardia and Cryptosporidium
							Cysts</span></td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, and easy change <a href=
							"http://www.waterfilters.net/Culligan-SY-1000-Water-Filter-System.html">
							SY-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Counter top -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-CT-2-Countertop-Water-Filter-System.html">
							CT-2</a>.<br>
						<br>
						<span style="font-weight: bold;">Faucet mount -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-FM-5-Faucet-Water-Filter-System.html">
							FM-5</a> and <a href=
							"http://www.waterfilters.net/Culligan-FM-15-Faucet-Water-Filter-System.html">
							FM-15</a>.<br>
						<br>
						<span style="font-weight: bold;">Inline/Icemaker -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-IC-750-Inline-Water-Filter.html">
							IC-750</a> and <a href=
							"http://www.waterfilters.net/Culligan-IC-1000-Easy-Change-Filter-System.html">
							IC-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">RV/Marine -</span> eg.
						<a href="http://www.waterfilters.net/Culligan-RV-1000-RV-Water-Filter-System.html">
							RV-1000</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Hard Water:</span> (Calcium, magnesium,
						Lime deposits, Clear-Water, or Ferrous Iron)</td>
	
					<td class="regular" valign="top" width="418"><a href=
							"http://www.waterfilters.net/Pentek-WS-20BB-Water-Softening-Filter.html">
							Water Softener Filter</a> or Water Softener</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Lead</span></td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, and easy change <a href=
							"http://www.waterfilters.net/Culligan-SY-1000-Water-Filter-System.html">
							SY-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Counter top -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-CT-2-Countertop-Water-Filter-System.html">
							CT-2</a>.<br>
						<br>
						<span style="font-weight: bold;">Faucet mount -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-FM-5-Faucet-Water-Filter-System.html">
							FM-5</a> and <a href=
							"http://www.waterfilters.net/Culligan-FM-15-Faucet-Water-Filter-System.html">
							FM-15</a>.<br>
						<br>
						<span style="font-weight: bold;">Inline/Icemaker -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-IC-750-Inline-Water-Filter.html">
							IC-750</a> and <a href=
							"http://www.waterfilters.net/Culligan-IC-1000-Easy-Change-Filter-System.html">
							IC-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">RV/Marine -</span> eg.
						<a href="http://www.waterfilters.net/Culligan-RV-1000-RV-Water-Filter-System.html">
							RV-1000</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Lindane and Atrazine</span> (herbacides
						and pesticides)</td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, easy change under sink system <a href=
							"http://www.waterfilters.net/Culligan-SY-1000-Water-Filter-System.html">
							SY-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Faucet mount -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-FM-15-Faucet-Water-Filter-System.html">
							FM-15</a>.<br>
						<br>
						<span style="font-weight: bold;">Inline/Icemaker -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-IC-750-Inline-Water-Filter.html">
							IC-750</a> and <a href=
							"http://www.waterfilters.net/Culligan-IC-1000-Easy-Change-Filter-System.html">
							IC-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">RV/Marine -</span> eg.
						<a href="http://www.waterfilters.net/Culligan-RV-1000-RV-Water-Filter-System.html">
							RV-1000</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Mercury</span></td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"http://www.waterfilters.net/Culligan-SY-2650-Water-Filter-System.html">
							SY-2650</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2500-Undersink-Water-Filter-System.html">
							SY-2500</a>, <a href=
							"http://www.waterfilters.net/Culligan-SY-2300-Drinking-Water-Filter-System.html">
							SY-2300</a>, and easy change <a href=
							"http://www.waterfilters.net/Culligan-SY-1000-Water-Filter-System.html">
							SY-1000</a>.<br>
						<br>
						<span style="font-weight: bold;">Counter top -</span> eg.
						<a href=
							"http://www.waterfilters.net/Culligan-CT-2-Countertop-Water-Filter-System.html">
							CT-2</a>.<br>
						<br>
						<span style="font-weight: bold;">Water pitcher -</span> eg.
						<a href="Water-Filtration-Pitcher.html">OP-1</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">MTBE</span></td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"Culligan-SY-2650-Water-Filter-System.html">SY-2650</a>, and
						<a href=
							"Culligan-SY-2300-Drinking-Water-Filter-System.html">SY-2300</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Volatile Organic Chemicals
							(VOCs)</span></td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Under sink -</span> eg. 3/8 in. <a href=
							"Culligan-SY-2650-Water-Filter-System.html">SY-2650</a>,
						<a href=
							"Culligan-SY-2500-Undersink-Water-Filter-System.html">SY-2500</a>,
						and <a href=
							"Culligan-SY-2300-Drinking-Water-Filter-System.html">SY-2300</a>.</td>
				</tr>
	
				<tr>
					<td class="regular" valign="top" width="121"><span style=
							"font-weight: bold;">Zinc</span></td>
	
					<td class="regular" width="418"><span style=
							"font-weight: bold;">Water pitcher -</span> eg. <a href=
							"Water-Filtration-Pitcher.html">OP-1</a>.</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="linebreak">
		<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
	</div>
	<a class="nextpage" href="{{store url='find-your-filter.html'}}">Next Lesson: Still need help finding your filter?</a>
</div>
<!--end of page-->
EOD;

	$root_template = 'two_columns_left';

	$title = 'Choose your Filter';

	$identifier = 'choose-your-filter.html';

	$layout_update = <<<EOD
<reference name="left">
<block type="cms/block" name="water.university.navigation">
    <action method="setBlockId"><block_id>water-university-navigation </block_id></action>
</block> 
</reference>
<reference name="head">
	<action method="addCss"><stylesheet>css/cmspage.css</stylesheet></action>
</reference>
EOD;

	$meta_keywords = <<<EOD
	Water Filters for Charity, Improving Water and the World, water charity,
    charity: water, corporate philanthropy, social entrepeneur, safe water,
    clean water, water education, servant leadership, water quality
EOD;

	$meta_description = <<<EOD
	Water Filters for Charity Improves Water and the World with a Ripple Effect
    of WaterFilters.NET serving customers and coworkers as well as people in
    need
EOD;

    $cmspage = array(
        'title' => $title,
        'identifier' => $identifier,
        'content' => $content,
        'sort_order' => 0,
		'stores' => array(0),
		'root_template' => $root_template,
		'layout_update_xml' => $layout_update,
		'meta_keywords' => $meta_keywords,
		'meta_description' => $meta_description
    );
	if (Mage::getModel('cms/page')->load($identifier)->getPageId())
	{
		Mage::getModel('cms/page')->load($identifier)->delete();
	}

	Mage::getModel('cms/page')->setData($cmspage)->save();
    $installer->endSetup();

}catch(Excpetion $e){
    Mage::logException($e);
    Mage::log("ERROR IN SETUP ".$e->getMessage());
}




