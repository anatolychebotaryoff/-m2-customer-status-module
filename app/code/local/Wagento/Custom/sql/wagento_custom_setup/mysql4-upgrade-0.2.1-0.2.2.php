<?php
try{
    $installer = $this;
    $installer->startSetup();

	/*ADD WATER GLOSSARY PAGE*/

    $content = <<<EOD
<!--add page-->
<div class="content">
	<div style="margin: 2px; padding: 2px; text-align: left; width: 100%">
		<a href="#A" class="carousel-jumper" rel="slide-1"><strong>A</strong></a>
		|          
		<a href="#B" class="carousel-jumper" rel="slide-2"><strong>B</strong></a>
		|          
		<a href="#C" class="carousel-jumper" rel="slide-3"><strong>C</strong></a>
		|          
		<a href="#D" class="carousel-jumper" rel="slide-4"><strong>D</strong></a>
		|          
		<a href="#E" class="carousel-jumper" rel="slide-5"><strong>E</strong></a>
		|          
		<a href="#F" class="carousel-jumper" rel="slide-6"><strong>F</strong></a>
		|          
		<a href="#G" class="carousel-jumper" rel="slide-7"><strong>G</strong></a>
		|          
		<a href="#H" class="carousel-jumper" rel="slide-8"><strong>H</strong></a>
		|          
		<a href="#I" class="carousel-jumper" rel="slide-9"><strong>I</strong></a>
		|          
		<a href="#J" class="carousel-jumper" rel="slide-10"><strong>J</strong></a>
		|          
		<a href="#K" class="carousel-jumper" rel="slide-11"><strong>K</strong></a>
		|          
		<a href="#L" class="carousel-jumper" rel="slide-12"><strong>L</strong></a>
		|          
		<a href="#M" class="carousel-jumper" rel="slide-13"><strong>M</strong></a>
		|          
		<a href="#N" class="carousel-jumper" rel="slide-14"><strong>N</strong></a>
		|          
		<a href="#O" class="carousel-jumper" rel="slide-15"><strong>O</strong></a>
		|          
		<a href="#P" class="carousel-jumper" rel="slide-16"><strong>P</strong></a>
		|          
		<a href="#Q" class="carousel-jumper" rel="slide-17"><strong>Q</strong></a>
		|          
		<a href="#R" class="carousel-jumper" rel="slide-18"><strong>R</strong></a>
		|          
		<a href="#S" class="carousel-jumper" rel="slide-19"><strong>S</strong></a>
		|          
		<a href="#T" class="carousel-jumper" rel="slide-20"><strong>T</strong></a>
		|          
		<a href="#U" class="carousel-jumper" rel="slide-21"><strong>U</strong></a>
		|          
		<a href="#V" class="carousel-jumper" rel="slide-22"><strong>V</strong></a>
		|          
		<a href="#W" class="carousel-jumper" rel="slide-23"><strong>W</strong></a>
		|          
		<a href="#X" class="carousel-jumper" rel="slide-24"><strong>X</strong></a>
		|          
		<a href="#Y" class="carousel-jumper" rel="slide-25"><strong>Y</strong></a>
		|          
		<a href="#Z" class="carousel-jumper" rel="slide-26"><strong>Z</strong></a>
		<br>
		<hr class="gray">
		<div class="para" style="display:none;">
			Click on a letter above to see the Water University Glossary.<br>
		</div>
		<div id="glossary-container" style="">
			<div id="carousel-wrapper">
				<div id="carousel-content">
					<div class="slide" id="slide-1">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">ABS</td>
									<td width="372" style="width:539pt">See Alkyl Benzene Sulfonate</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Absorbent</td>

									<td width="372" style="width:539pt">A material, usually a
										porous solid, which takes another material into its interior. When rain
										soaks into soil, the soil is an absorbent.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Absorption</td>
									<td width="372" style="width:539pt">The process in which one
										substance is taken into the body of an absorbent.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Acid</td>
									<td width="372" style="width:539pt">A substance which increases
										the concentration of hydrogen ions when dissolved in water. Most acids
										will dissolve the common metals and will react with a base to form a
										neutral salt and water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Acidity</td>
									<td width="372" style="width:539pt">The quantitative capacity
										of water or a water solution to neutralize an alkali or base. It is
										usually measured by titration with a standard solution of sodium hydroxide
										and expressed in terms of its calcium carbonate equivalent. (See mineral
										acidity, total acidity, carbon dioxide.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Acre-Foot</td>

									<td width="372" style="width:539pt">The volume of water which
										would cover an area of one acre to a depth of one foot. It is equal to
										43,560 cubic feet (1,233 cubic meters) or 325,851 gallons (1,233,L).</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Action Level</td>
									<td width="372" style="width:539pt">The level of lead or copper
										which, if exceeded, triggers treatment or other requirements that a water
										system must follow.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Activated Carbon</td>
									<td width="372" style="width:539pt">A granular material usually
										produced by roasting various grades of coal in the absence of air. It has
										a very porous structure and it is used in water conditioning as an
										adsorbent (see "adsorption") for organic matter and certain
										dissolved gases. Sometimes called "activated charcoal".</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Activated Silica</td>

									<td width="372" style="width:539pt">A material usually formed
										from the reaction of a dilute silicate solution with a dilute acid. It is
										used as a coagulant aid.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Acute Health Effect</td>
									<td width="372" style="width:539pt">An immediate (i.e. within
										hours or days) effect that may result from exposure to certain drinking
										water contaminants (e.g., pathogens).</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Adsorbent</td>
									<td width="372" style="width:539pt">A material, usually solid,
										capable of holding gases, liquids and/or suspended matter at its surface
										and in exposed pores. Activated carbon is a common adsorbent used in water
										treatment.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Adsorption</td>
									<td width="372" style="width:539pt">The process in which matter
										adheres to the surface of an adsorbent.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Aeration</td>

									<td width="372" style="width:539pt">The process in which air is
										brought into intimate contact with water, often by spraying water through
										air, or by bubbling air through water. Aeration may be used to add oxygen
										to the water for the oxidation of matter such as iron, or to cause the
										release of dissolved gases such as carbon dioxide or hydrogen sulfide from
										the water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Aerobic</td>
									<td width="372" style="width:539pt">An action or process
										conducted in the presence of air, such as aerobic digestion of organic
										matter by bacteria.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Air Gap</td>
									<td width="372" style="width:539pt">A clear vertical space
										between a water or drain line and the flood level of a receptacle to
										prevent back-flow or siphoning from the receptacle in the event of
										negative pressure or vacuum. Most plumbing codes require the air gap to be
										at least twice the diameter of the water or drain line, with a minimum of
										1-1/2 inches (3.8 cm). (See vacuum breaker or back-flow presenter.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Algae</td>
									<td width="372" style="width:539pt">Small primitive plants
										containing chlorophyll, commonly found in surface water. Excessive growths
										may create taste and odor problems, and consume dissolved oxygen during
										decay.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Alkali</td>

									<td width="372" style="width:539pt">A group of water soluble
										mineral compounds, usually considered to have moderate strengths as bases
										(as opposed to the caustic or strongly basic hydroxides, although this
										differentiation is not always made). In general, the term is applied to
										bicarbonate and carbonate compounds when they are present in the water or
										solution. (See alkali, base.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Alkalinity</td>
									<td width="372" style="width:539pt">The quantitative capacity
										of a water or water solution to neutralize an acid. It is usually measured
										by titration with a standard acid solution of sulfuric acid and is
										expressed in terms of its calcium carbonate equivalent. (See alkali,
										base.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Alkyl Benzene Sulfonate</td>
									<td width="372" style="width:539pt">A term applied to a family
										of branched chain chemical compounds, formerly used as detergents,.
										Sometimes called "hard" detergents, because of their resistance
										to biological degradation, these compounds have been largely replaced with
										linear alkyl sulfonate (LAS) which are more readily degraded to simpler
										substances. (See detergent, linear alkyl sulfonate.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Alum</td>

									<td width="372" style="width:539pt">A common name for aluminum
										sulfate, used as a coagulant.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Amoeba</td>
									<td width="372" style="width:539pt">A small, single-celled
										animal or protozoan.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Anaerobic</td>
									<td width="372" style="width:539pt">An action or process
										conducted in the absence of air, such as the anaerobic digestion of
										organic matter by bacteria in a septic tank.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Angstrom Unit</td>
									<td width="372" style="width:539pt">A unit of length equal to
										one ten-billionth of a meter.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Anion</td>

									<td width="372" style="width:539pt">A negatively charged ion in
										solution, such as bicarbonate, chloride, nitrate or sulfate.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:45.0pt">

									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Anion Exchange</td>
									<td width="372" style="width:539pt">An ion exchange process in
										which anions in solution are exchanged for other anions from an ion
										exchanger. In demineralization, for example, bicarbonate, chloride and
										sulfate anions are removed from solution in exchange for a chemically
										equivalent number of hydroxide anions from the anion exchange resin. (See
										ion exchange, demineralization.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Anode</td>
									<td width="372" style="width:539pt">The positive pole of an
										electrolytic system meter when oxidation occurs. Anodes made of magnesium
										or zinc are sometimes installed in water heaters or other tanks to
										deliberately establish galvanic cells to control corrosion of the tank
										through the sacrifice of the anode.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Aquifer</td>
									<td width="372" style="width:539pt">A natural underground
										layer, often of sand or gravel, that contains water.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:51.0pt">
									<td width="20" height="68" style="height:51.0pt"></td>
									<td height="68" style="height:51.0pt">Arsenic</td>

									<td width="372" style="width:539pt">A
										natural element of the earth's crust, arsenic enters water supplies either
										through natural deposition or agricultural and industrial pollution.
										According to the Environmental Protection Agency (EPA), Office of Ground
										Water and Drinking Water, health effects of arsenic include skin damage,
										circulatory system problems and an increased risk of various cancers.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:38.25pt">

									<td width="20" height="51" style="height:38.25pt"></td>
									<td height="51" style="height:38.25pt">Asbestos</td>
									<td width="372" style="width:539pt">A
										fibrous mineral, asbestos can enter water naturally or through the decay
										of asbestos cement in water mains. According to the Environmental
										Protection Agency (EPA), Office of Ground Water and Drinking Water, this
										contaminant may increase the risk of developing benign intestinal polyps
										and has been linked to cancer.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Atom</td>
									<td width="372" style="width:539pt">The smallest particle of an
										element that can exist either alone or in combination.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Atrazine</td>
									<td width="372" style="width:539pt">Atrazine is an herbicide
										contaminant which has been in the news lately after, being upgrade from a
										"possible" to a "likely" carcinogen. according to USA
										Today, atrazine is the most commonly used herbicide. Atrazine enters water
										supplies as runoff from farmers' fields. According to the EPA, atrazine
										causes cardiovascular system problems and reproductive difficulties.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Attrition</td>

									<td width="372" style="width:539pt">In water treatment, the
										process in which solids are worn down or ground down by friction, often
										between particles of the same material. Filter media and ion exchange
										materials are subject to attrition during backwashing, regeneration and
										service.</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-2">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Back-Flow</td>
									<td width="372" style="width:539pt">Flow of water in a pipe or
										line in a direction opposite to normal flow. Often associated with back
										siphonage or the flow of possibly contaminated water into a potable water
										system.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Back-Flow Preventer</td>

									<td width="372" style="width:539pt">A device or system
										installed in a water line to stop back-flow. (See vacuum breaker, air
										gap.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Backwash</td>
									<td width="372" style="width:539pt">The process in which beds
										of filter or ion exchange media are subjected to flow opposite to the
										service flow direction to loosen the bed and to flush suspended matter
										collected during the service run.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Bacteria</td>
									<td width="372" style="width:539pt">Unicellular prokaryotic
										microorganisms which typically reproduce by cell division.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Base</td>
									<td width="372" style="width:539pt">A substance which releases
										hydroxyl ions when dissolved in water. Bases react with acids to form a
										neutral salt and water. (See alkali.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Base Exchange</td>

									<td width="372" style="width:539pt">Synonymous with cation
										exchange.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Batch</td>
									<td width="372" style="width:539pt">A quantity of material
										treated or produced as a unit.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Batch Operation</td>
									<td width="372" style="width:539pt">A process method in which a
										quantity of material is processed or treated usually with a single charge
										of reactant in a single vessel, and often involving stirring. Example: The
										neutralization of a specific volume of an acid with a base in a vessel,
										with stirring or mixing, is a batch operation.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Bed</td>
									<td width="372" style="width:539pt">The ion exchanger or filter
										media in a column or other tank or operational vessel.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Bed Depth</td>

									<td width="372" style="width:539pt">The height of the ion
										exchanger or filter media in the vessel after preparation for service.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Bed Expansion</td>
									<td width="372" style="width:539pt">The increase in the volume
										of a bed of ion exchange or filter media during upflow operations, such as
										backwashing, caused by lifting and separation of the media. Usually
										expressed as the percent of increase of bed depth.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Best Available
										Technology</td>
									<td width="372" style="width:539pt">The water treatment(s) that
										EPA certifies to be the most effective for removing a contaminant.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Bicarbonate Alkalinity</td>
									<td width="372" style="width:539pt">The alkalinity of a water
										due to the presence of bicarbonate ions (HCO3).</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Biochemical Oxygen Demand
										(Bod)</td>

									<td width="372" style="width:539pt">The amount of oxygen
										consumed in the oxidation of organic matter by biological action under
										specific standard test conditions. Widely used as a measure of the
										strength of sewage and waste water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Biodegradable</td>
									<td width="372" style="width:539pt">Subject to degradation to
										simpler substances by biological action, such as the bacterial breakdown
										of detergents, sewage wastes and other organic matter.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Bleach</td>
									<td width="372" style="width:539pt">An oxidizing agent
										formulated to break down colored matter. Includes the widely used
										hypochlorites, as well as perborates and other special purpose materials.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Bod</td>
									<td width="372" style="width:539pt">Abbreviation for
										"Biochemical Oxygen Demand".</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Brackish Water</td>

									<td width="372" style="width:539pt">Water having salinity
										values ranging from approximately 500 to 5,000 parts per million
										(milligrams per liter).</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Breakpoint Chlorination</td>
									<td width="372" style="width:539pt">A chlorination procedure in
										which chlorine is added until the chlorine demand is satisfied and a dip
										(breakpoint) in the chlorine residual occurs. Further additions of
										chlorine produce a chlorine residual proportional to the amount added.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Breakthrough</td>
									<td width="372" style="width:539pt">The appearance in the
										effluent from a water conditioner of the material being removed by the
										conditioner, such as hardness in the effluent of a softener, or turbidity
										in the effluent of a mechanical filter; an indication that regeneration,
										backwashing, or other treatment is necessary for further service.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Brine</td>
									<td width="372" style="width:539pt">A strong solution of salt(s),
										such as sodium chloride used in the regeneration of ion exchange water
										softeners, but also applied to the mixed sodium, calcium and magnesium
										chloride waste solution from regeneration.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Buffer</td>

									<td width="372" style="width:539pt">A chemical which causes a
										solution to resist changes in pH, or to shift the pH to a specific value.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Builder</td>
									<td width="372" style="width:539pt">A chemical incorporated in
										a detergent formulation to produce a desired alkalinity level and improve
										the ability to suspend soil. The alkaline phosphates are widely used for
										this purpose.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Bypass</td>
									<td width="372" style="width:539pt">A connection or a valve
										system that allows untreated water to flow through a water system while a
										water treatment unit is being regenerated, backwashed or serviced; also
										applied to a special water line installed to provide untreated water to a
										particular tap, such as a sill cock.</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-3">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Calcium</td>
									<td width="372" style="width:539pt">One of the principal
										elements in the earth's crust. When dissolved, in water, calcium is a
										factor contributing to the formation of scale and insoluble soap curds
										which are a means of clearly identifying hard water.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Calcium Carbonate
										Equivalent</td>

									<td width="372" style="width:539pt">A common basis for
										expressing the concentration of hardness and other salts in chemically
										equivalent terms to simplify certain calculations; signifies that the
										concentration of a dissolved mineral is chemically equivalent to the
										stated concentration of calcium carbonate.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Calcium Hypochlorite</td>
									<td width="372" style="width:539pt">A chemical compound, [Ca(Cl
										0)24H2O], used as a bleach and as a source of chlorine in water treatment;
										specifically useful because it is stable as a dry powder and can be formed
										into tablets.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:56.25pt">
									<td width="20" height="75" style="height:56.25pt"></td>
									<td height="75" style="height:56.25pt">Capacity</td>
									<td width="372" style="width:539pt">An expression of the
										quantity of an undesirable material which can be removed from water by a
										water conditioning medium, i.e., cleaning, regeneration or replacement, as
										determined under standard test conditions. For ion exchange water
										softeners, the capacity is expressed in grains of hardness removed between
										successive regenerations and is related to the pounds of salt used in
										regeneration. For filters, the capacity may be expressed in the length of
										time or total gallons delivered between servicing.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Capacity Curve</td>
									<td width="372" style="width:539pt">A graph of the capacity
										versus regenerant levels for an ion exchange unit or system.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Capillary Action</td>

									<td width="372" style="width:539pt">A phenomenon in which water
										or many other liquids will rise above the normal liquid level in a tiny
										tube or capillary, due to attraction between molecules of the liquid for
										each other and the walls of the tube.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Carbon Chloroform Extract</td>
									<td width="372" style="width:539pt">The matter adsorbed from a
										stream of water by activated carbon, and then extracted from the activated
										carbon with chloroform, using a specific standardized procedure; a measure
										of the organic matter in a water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Carbon Dioxide</td>
									<td width="372" style="width:539pt">A gas present in the
										atmosphere and formed by the decay of organic matter; the gas in
										carbonated beverages; in water it forms carbonic acid.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Carbonaceous</td>
									<td width="372" style="width:539pt">Materials of or derived
										from organic substances such as coal, lignite, peat, etc.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Carbonaceous Exchanger</td>

									<td width="372" style="width:539pt">Ion exchange material
										produced by the sulfonation of carbonaceous matter.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Carbonate</td>
									<td width="372" style="width:539pt">The CO32 ion.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Carbonate Alkalinity</td>
									<td width="372" style="width:539pt">Alkalinity due to the
										presence of the carbonate ion (CO32).</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Carbonate Hardness</td>
									<td width="372" style="width:539pt">Hardness due to the
										presence of calcium and magnesium bicarbonates and carbonates in water;
										the smaller of the total hardness and the total alkalinity. (See temporary
										hardness.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Carbonic Acid Formed</td>

									<td width="372" style="width:539pt">It does not contribute to
										total dissolved solids, but does have a pronounced effect on specific
										resistance. This effect must be included when estimating the water quality
										from a weak base deionizer. Carbonate and bicarbonate alkalinity are
										destroyed by cation resin and converted to carbonic acid. To calculate
										carbonic acid formed add the carbonates, bicarbonates, and twice the
										carbon dioxide.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Carboxylic</td>
									<td width="372" style="width:539pt">An organic acidic group (COOH)
										which contributes cation exchange ability to some resins.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Cartridge</td>
									<td width="372" style="width:539pt">Any removable preformed or
										prepackaged component containing a filtering media or ion exchanger.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Cathode</td>
									<td width="372" style="width:539pt">The negative pole of an
										electrolytic system; an electrode where reduction occurs. (See anode.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Cathodic Protection</td>

									<td width="372" style="width:539pt">A corrosion control system
										in which the metal to be protected is made to serve as a cathode, either
										by the deliberate establishment of a galvanic cell or by impressed
										current. (See anode.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Cation</td>
									<td width="372" style="width:539pt">An ion with a positive
										electrical charge. Calcium, magnesium and sodium are cations.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Cation Exchange</td>
									<td width="372" style="width:539pt">Ion exchange process in
										which cations in solution are exchanged for other cations from an ion
										exchanger.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Cation Load Factory</td>
									<td width="372" style="width:539pt">This is the sum of calcium,
										magnesium, sodium, and potassium. It is the sum of all cations.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Caustic</td>

									<td width="372" style="width:539pt">Any substance capable of
										burning or destroying animal flesh or tissue. The term is usually applied
										to strong bases.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Caustic Soda</td>
									<td width="372" style="width:539pt">The common name for sodium
										hydroxide.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Cc</td>
									<td width="372" style="width:539pt">Abbreviation for
										"carbon chloroform extract".</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Channeling</td>
									<td width="372" style="width:539pt">The flow of water or other
										solution through a limited number of passages in a filter or ion exchanger
										bed, instead of distributed flow through all passages in the bed. May be
										due to fouling of the bed and plugging of many passages, poor distributor
										design, flow rates which are too low, faulty operational procedures, or
										other causes.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Chelate</td>

									<td width="372" style="width:539pt">To form a complex chemical
										compound in which an ion, usually metallic, is bound into a stable ring
										structure.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Chelating Agent</td>
									<td width="372" style="width:539pt">A chemical compound
										sometimes fed to water to tie up undesirable metal ions, keep them in
										solution, and eliminate or reduce the normal effects of the ion. (See
										sequestering agent.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Chemical Stability</td>
									<td width="372" style="width:539pt">Resistance to attach by
										chemical action.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Chlorides</td>
									<td width="372" style="width:539pt">Salts of chloride are
										generally soluble. High concentrations contribute to corrosion problems.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Chlorinator</td>

									<td width="372" style="width:539pt">A device designed to feed
										chlorine gas or solutions of its compounds, such as hypochlorite, into a
										water supply.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Chlorine</td>
									<td width="372" style="width:539pt">A gas, C2, widely used in
										the disinfection of water and an oxidizing agent for organic matter, iron,
										etc.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Chlorine Demand</td>
									<td width="372" style="width:539pt">A measure of the amount of
										chlorine consumed by oxidizable substances in a water before a chlorine
										residual will be found.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Chronic Health Effect</td>
									<td width="372" style="width:539pt">The possible result of
										exposure over many years to a drinking water contaminant at levels above
										its MCL.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Coagulant</td>

									<td width="372" style="width:539pt">A material, such as alum,
										which will cause the agglomeration of finely divided particles into larger
										particles which can then be removed by settling and/or filtration.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Coagulant Aid</td>
									<td width="372" style="width:539pt">A material which is not a
										coagulant, but which improves the effectiveness of a coagulant by forming
										larger or heavier particles, speeding the reactions, or by permitting
										reduced coagulant dosage.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Coagulation</td>
									<td width="372" style="width:539pt">The process in which very
										small, finely divided solid particles are agglomerated into larger
										particles.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Cod</td>
									<td width="372" style="width:539pt">The abbreviation for
										"Chemical Oxygen Demand".</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Coliform Bacteria</td>

									<td width="372" style="width:539pt">A group of microorganisms
										used as indicators of water contamination, and the possible presence of
										pathogenic (disease producing) bacteria.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Coliform</td>
									<td width="372" style="width:539pt">A group of related bacteria
										whose presence in drinking water may indicate contamination by
										disease-causing microorganisms.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Collector</td>
									<td width="372" style="width:539pt">A device or system designed
										to collect backwash water from a filter or ion exchange bed. May also be
										used as an upper distributor to spread the flow of water in downflow
										column operation. (See distributor.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Colloid</td>
									<td width="372" style="width:539pt">Very finely divided solid
										particles which do not settle out of a solution; intermediate between a
										true dissolved particle and a suspended solid which will settle out of
										solution. The removal of colloidal particles usually requires coagulation.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Color</td>

									<td width="372" style="width:539pt">The shade or tint imparted
										to water by substances in true solution, and thus not removed by
										mechanical filtration; most commonly caused by dissolved organic matter,
										but may be produced by dissolved mineral matter. As measured in a water
										analysis, only the intensity of yellow color is reported.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Color Throw</td>
									<td width="372" style="width:539pt">The discharge of color to
										the effluent of a filter or ion exchange system by any component. It
										usually occurs after a period of standing which allows slowly soluble
										colored matter to accumulate in the system.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Column Operation</td>
									<td width="372" style="width:539pt">The process in which the
										solution to be treated is passed through a bed, or column (as in a tank),
										of filter media or ion exchanger; may be either upflow or downflow.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Combined Available
										Chlorine</td>
									<td width="372" style="width:539pt">The chlorine present as
										chloramine or other chlorine derivatives in a water, but still available
										for disinfection and the oxidation of organic matter. Combined chlorine
										compounds are more stable than free chlorine forms, but are somewhat
										slower in disinfection action.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Community Water System</td>

									<td width="372" style="width:539pt">A water system which
										supplies drinking water to 25 or more of the same people year-round in
										their residences.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Compensated Hardness</td>
									<td width="372" style="width:539pt">A calculated value based on
										the total hardness, the magnesium to calcium ratio and the sodium
										concentration of a water. It is used to correct for the reductions in
										hardness removal capacity caused by these factors in zeolite exchange
										water softeners. No single method of calculation has been widely accepted.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Compliance</td>
									<td width="372" style="width:539pt">The act of meeting all
										state and federal drinking water regulations.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Composite Sample</td>
									<td width="372" style="width:539pt">A mixture of a number of
										single or "grab" samples, intended to produce a typical or
										average sample. May be made up of equal volumes of individual samples, or
										of single samples proportioned to variations in flow or usage.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Concentration Factor</td>

									<td width="372" style="width:539pt">A number used to estimate
										the scaling potential in reverse osmosis systems when the TADS rejection
										is expected to exceed 90%; equal to the reciprocal of 1 minus the recovery
										ratio. When multiplied by the feed TADS, the result is the approximate
										waste water TADS. (See recovery, rejection.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Conductance</td>
									<td width="372" style="width:539pt">In water conditioning, the
										readiness of water to carry electricity; the reciprocal of electrical
										resistance. The unit of measure for conductance is the mho (reciprocal
										ohm). Used to approximate the dissolved solids content of water. (See
										conductivity, resistance, specific conductance.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Conductivity</td>
									<td width="372" style="width:539pt">The quality or power to
										carry electrical current; in water; related to the concentration of ions
										capable of carrying electrical current. (See conductance, electrolyte.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Connate Water</td>
									<td width="372" style="width:539pt">Water deposited
										simultaneously with rock and held with essentially no flow; usually occurs
										deep in the earth, and usually is high in minerals due to long contact.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Contaminant</td>

									<td width="372" style="width:539pt">Anything found in water
										(including microorganisms, minerals, chemicals, radionuclides, etc.) which
										may be harmful to human health.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Contamination</td>
									<td width="372" style="width:539pt">The presence of foreign
										matter in a substance which reduces the value of the substance, or
										interferes with its intended use.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Conversion</td>
									<td width="372" style="width:539pt">See "recovery".</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Corrosion</td>
									<td width="372" style="width:539pt">The disintegration of a
										metal by electrochemical means.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Crenothrix Polyspora</td>

									<td width="372" style="width:539pt">A genus of filamentous
										bacteria which utilize iron in their metabolism, and cause staining,
										plugging and taste and odor problems in water systems. (See iron
										bacteria.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Cross Connection</td>
									<td width="372" style="width:539pt">A direct link between a
										potable water system and a non-potable water system, which permits
										undesirable substances to be drawn into the potable water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Cross-Sectional Area</td>
									<td width="372" style="width:539pt">The area of a plane at a
										right angle to the direction of flow through a tank or vessel; often
										expressed in square feet, and related to the flow rate. (Example: 5
										gallons per minute per square foot of ion exchanger bed area.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Cryptosporidium</td>
									<td width="372" style="width:539pt">A common intestinal
										parasite found in waters contaminated by sewerage or runoff containing
										animal waste. It causes diarrhea, nausea, and cramps. Individuals with
										weakened immune systems are at particular risk. Although resistant to
										chlorine and most oxidizing agents, it is effectively removed by
										filtration to 1 micrometer, and can be destroyed by boiling.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Cryptosporidium</td>

									<td width="372" style="width:539pt">A microorganism commonly
										found in lakes and rivers which is highly resistant to disinfection.
										Cryptosporidium has caused several large outbreaks of gastrointestinal
										illness, with symptoms that include diarrhea, nausea, and/or stomach
										cramps. People with severely weakened immune systems (that is, severely
										immuno-compromised) are likely to have more severe and more persistent
										symptoms than healthy individuals.  </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Cube</td>
									<td width="372" style="width:539pt">A slang expression
										sometimes used to mean a cubic foot of ion exchanger or filter media.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Cubic Foot</td>
									<td width="372" style="width:539pt">The volume of a cube whose
										sides have the length of one foot. The common basis for the measurement of
										the volume of ion exchangers or loose filter media.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Cycle</td>
									<td width="372" style="width:539pt">A series of events or steps
										which ultimately lead back to the starting point, such as the
										exhaustion-regeneration cycle of an ion exchange system.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Cysts</td>

									<td width="372" style="width:539pt">Common cysts include
										Cryptosporidia and Giardia. Because cysts have a "hard shell,"
										they are able to survive in hostile environments, such as the presence of
										chlorine or absence of water. It is because of this hard shell that they
										are hard to kill. Once the cyst is ingested, the shell is discarded and
										the organisims infect the intestines, causing diarrhea, headaches,
										abdominal cramps, nausea and vomiting.</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-4">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">D.I. Or Di</td>
									<td width="372" style="width:539pt">Abbreviation for "deionization".</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Dechlorination</td>

									<td width="372" style="width:539pt">The removal of chlorine
										residual.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:67.5pt">

									<td width="20" height="90" style="height:67.5pt"></td>
									<td height="90" style="height:67.5pt">Deionization</td>
									<td width="372" style="width:539pt">The removal of all ionized
										minerals and salts from a solution by a two-phase ion exchange process.
										First, positively charged ions are removed by a cation exchange resin in
										exchange for a chemically equivalent amount of hydrogen ions. Second,
										negatively charged ions are removed by an anion exchange resin for a
										chemically equivalent amount of hydroxide ions. The hydrogen and hydroxide
										ions introduced in this process unite to form water molecules. The term,
										commonly abbreviated as DI, is often used interchangeably with
										demineralization. (See demineralization, ion exchange.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Demineralization</td>
									<td width="372" style="width:539pt">The removal of ionized
										minerals and salts from a solution by a two-phase ion exchange procedure,
										similar to deionization, and the two terms are often used interchangeably.
										(See deionization, ion exchange.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Density</td>
									<td width="372" style="width:539pt">The mass of a substance per
										specified unit of volume; for example, pounds per cubic foot. True density
										is the mass per unit volume excluding pores; apparent density is the mass
										per unit volume including pores. (See specific gravity.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Detergent</td>

									<td width="372" style="width:539pt">Any material with cleaning
										powers, including soaps, synthetic detergents, many alkaline materials and
										solvents, and abrasives. In popular usage the term is often used to mean
										the synthetic detergents such as ABS of LAS. (See alkyl benzene sulfonate,
										linear alkyl sulfonate, soap.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Dialysis</td>
									<td width="372" style="width:539pt">The separation of
										components of a solution by diffusion through a semi-permeable membrane
										which is capable of passing certain ions or molecules while rejecting
										others. (See electrodialysis, semi-permeable membrane.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Diaphragm Pump</td>
									<td width="372" style="width:539pt">A type of positive
										displacement pump in which the reciprocating piston is separated from the
										solution by a flexible diaphragm, thus protecting the piston from
										corrosion and erosion, and avoiding problems with packing and seals.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Diatomaceous Earth</td>
									<td width="372" style="width:539pt">A processed natural
										material, the skeletons of diatoms, used as a filter medium.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Diatomite</td>

									<td width="372" style="width:539pt">Another name for
										diatomaceous earth.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Dielectric Fitting</td>
									<td width="372" style="width:539pt">A plumbing fitting made of,
										or containing, an electrical nonconductor, such as plastic; used to
										separate dissimilar metals in a plumbing system to control galvanic
										corrosion.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Differential Pressure</td>
									<td width="372" style="width:539pt">See pressure differential.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Digestion</td>
									<td width="372" style="width:539pt">The process in which
										complex materials are broken down into simpler substances; may be due to
										chemical, biological or a combination of reactions. (See sterilization.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Disinfectant</td>

									<td width="372" style="width:539pt">A chemical (commonly
										chlorine, chloramine, or ozone) or physical process (e.g., ultraviolet
										light) that kills microorganisms such as bacteria, viruses, and protozoa.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Disinfection</td>
									<td width="372" style="width:539pt">A process in which
										vegetative bacteria are killed; may involve disinfecting agents such as
										chlorine, or physical processes such as heating. (See aerobic, anaerobic.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Dissociation</td>
									<td width="372" style="width:539pt">The separation of molecules
										into positively and negatively charged ions; occurs when salts dissolve in
										water. (See ionization.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Dissolved Solids</td>
									<td width="372" style="width:539pt">The weight of matter in
										true solution in a stated volume of water; includes both inorganic and
										organic matter; usually determined by weighing the residue after
										evaporation of the water at 105 or 180oC.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Distillation</td>

									<td width="372" style="width:539pt">The process in which a
										liquid, such as water, is converted into its vapor state by heating, and
										the vapor cooled and condensed to the liquid state and collected; used to
										remove solids and other impurities from water; multiple distillations are
										required for extreme purity.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Distribution System</td>
									<td width="372" style="width:539pt">A network of pipes leading
										from a treatment plant to customers' plumbing systems.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Distributor</td>
									<td width="372" style="width:539pt">A device or system designed
										to produce even flow through all sections of an ion exchanger or filter
										bed, and to retain the media in the tank or vessel; usually installed at
										the top and bottom of loose media systems. (See collector.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Dolomite</td>
									<td width="372" style="width:539pt">A specific form of
										limestone containing chemically equivalent concentrations of calcium and
										magnesium carbonates; the term is sometimes applied to limestones with
										compositions similar to true dolomite.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Domestic</td>

									<td width="372" style="width:539pt">A term sometimes applied to
										water conditioning equipment designed for household use.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Downflow</td>
									<td width="372" style="width:539pt">A term designating the
										direction (down) in which water or a regenerant flows through an ion
										exchanger or filter during any phase of the operating cycle.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Drain</td>
									<td width="372" style="width:539pt">A pipe or conduit in a
										building plumbing system which carries liquids to waste by gravity;
										sometimes the term is limited to liquids other than sewage.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Drain Line</td>
									<td width="372" style="width:539pt">A tube or pipe from a water
										conditioning unit that carries backwash water, regeneration wastes and/or
										rinse water to a drain or waste system.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Dynamic</td>

									<td width="372" style="width:539pt">Active, alive, or tending
										to produce motion, as opposed to static, resting or fixed.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Dynamic System</td>
									<td width="372" style="width:539pt">A system or process in
										which motion occurs, or includes active forces, as opposed to static
										conditions with no motion.</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-5">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">E. Coli</td>
									<td width="372" style="width:539pt">The common abbreviation of
										Escherichia Coli.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Eductor</td>

									<td width="372" style="width:539pt">A device utilizing a nozzle
										and throat, installed in a stream of water to create a partial vacuum to
										draw air or liquid into the stream; commonly used to draw regeneration
										chemicals into an ion exchange water treatment system, such a softener or
										deionizer.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Effective Size</td>
									<td width="372" style="width:539pt">A measure of the size of
										particles of ion exchanger or filter medium; defined as the diameter of a
										specific particle in a bed, batch or lot which has 10 percent smaller and
										90 percent larger particles.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Efficiency</td>
									<td width="372" style="width:539pt">The ratio of output per
										unit input or the effectiveness of performance of a system; in an ion
										exchange system, often expressed as the amount of regenerant required to
										produce a unit of capacity, such as the pounds of salt per kilograin of
										hardness removal.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Effluent</td>
									<td width="372" style="width:539pt">The stream emerging from a
										unit, system or process, such as the softened water from an ion exchange
										softener.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Ejector</td>

									<td width="372" style="width:539pt">A device which used a high
										velocity jet to entrain a gas or liquid in a stream of air or liquid. (See
										eductor.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Electrodialysis</td>
									<td width="372" style="width:539pt">A process in which a direct
										current is applied to a cell to draw charged ions through ion selective
										semipermeable membranes, thus removing the ions from the solution.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Electrolysis</td>
									<td width="372" style="width:539pt">In general, the chemical
										change caused by the passage of an electric current, often a decomposition
										of a material; the decomposition of water into oxygen and hydrogen by the
										application of a direct current; the action in which one metal goes into
										solution in a galvanic cell at the junction between dissimilar metals in a
										water system. (See galvanic corrosion.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Electrolyte</td>
									<td width="372" style="width:539pt">A nonmetallic substance
										that carries an electric current, or a substance which, when dissolved in
										water, separates into ions which can carry an electric current. (See
										conductance, ionization.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Electron</td>

									<td width="372" style="width:539pt">A fundamental particle
										found in the atom which carries a single negative charge.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Elution</td>
									<td width="372" style="width:539pt">The stripping of ions from
										an ion exchange material by other ions, either because of greater affinity
										or because of much higher concentration.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Endpoint</td>
									<td width="372" style="width:539pt">The point at which a
										process is stopped because a predetermined value of a measurable variable
										is reached.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Equilibrium</td>
									<td width="372" style="width:539pt">The state in which the
										action of multiple forces produce a stead balance.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Equilibrium Reaction</td>

									<td width="372" style="width:539pt">A chemical reaction which
										proceeds primarily in one direction until the concentrations of reactants
										and products reach an equilibrium.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Equivalent Weight</td>
									<td width="372" style="width:539pt">The weight in grams of an
										element, compound or ion which would react with or replace 1 gram of
										hydrogen; the molecular weight in grams divided by the valence.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Erosion</td>
									<td width="372" style="width:539pt">The process in which
										material is worn away by a stream of air or liquid, often due to the
										presence of abrasive particles in the stream; a physical or mechanical
										wearing process rather than a chemical solution process.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Escherichia Coli</td>
									<td width="372" style="width:539pt">One of the members of the
										coliform groups of bacteria indicating fecal contamination. (See fecal,
										coliform.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Exchange Velocity</td>

									<td width="372" style="width:539pt">The rate with which one ion
										is displaced from an ion exchange material in exchange for another ion.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:78.75pt">

									<td width="20" height="105" style="height:78.75pt"></td>
									<td height="105" style="height:78.75pt">Exemption</td>
									<td width="372" style="width:539pt">State or EPA permission for
										a water system not to meet a certain drinking water standard. An exemption
										allows a system additional time to obtain financial assistance or make
										improvements in order to come into compliance with the standard. The
										system must prove that: (1) there are compelling reasons (including
										economic factors) why it cannot meet a MCL or Treatment Technique; (2) it
										was in operation on the effective date of the requirement, and (3) the
										exemption will not create an unreasonable risk to public health. The state
										must set a schedule under which the water system will comply with the
										standard for which it received an exemption. </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Exhaustion</td>
									<td width="372" style="width:539pt">The state of an ion
										exchange material that is no longer capable of effective function due to
										the depletion of the initial supply of exchangeable ions. (See ion
										exchange, endpoint.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Exposure</td>
									<td width="372" style="width:539pt">Contact between a person
										and a chemical. Exposures are calculated as the amount of chemical
										available for absorption by a person.</td>
								</tr>

						</tbody></table>
					</div>
					<div class="slide" id="slide-6">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Fecal</td>
									<td width="372" style="width:539pt">Matter containing or
										derived from animal or human wastes or feces.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Filter</td>

									<td width="372" style="width:539pt">A device or system for the
										removal of solid particles (suspended solids).</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Filter Area</td>
									<td width="372" style="width:539pt">The effective area through
										which water passes through filter media, often expressed in square feet.
										(See cross sectional area.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Filter Medium</td>
									<td width="372" style="width:539pt">(See medium.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Filtrate</td>
									<td width="372" style="width:539pt">The effluent liquid from a
										filter.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Fines</td>

									<td width="372" style="width:539pt">Extremely small particles
										of filter media or ion exchange material, often the result of breakage or
										chemical or physical deterioration.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Finished Water</td>
									<td width="372" style="width:539pt">Water that has been treated
										and is ready to be delivered to customers.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Fixed Solids</td>
									<td width="372" style="width:539pt">The suspended or dissolved
										solids remaining after ignition, usually at 600oCl; usually due to
										inorganic matter which is not volatilized at the ignition temperature.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Fixture</td>
									<td width="372" style="width:539pt">In plumbing, a permanently
										installed device in which water is used, such as a faucet or toilet.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Fixture Unit</td>

									<td width="372" style="width:539pt">An arbitrary unit assigned
										to different types of plumbing fixtures, and used to estimate flow rate
										requirements and drain capacity requirements.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Floc</td>
									<td width="372" style="width:539pt">An agglomeration of finely
										divided suspended particles in a larger, usually gelatinous particle the
										result of physical attraction or adhesion to a coagulant compound.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Flocculation</td>
									<td width="372" style="width:539pt">The process of causing a
										"floc" to form after treatment with a coagulant by gentle
										stirring or mixing. (See coagulation.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Flow Control</td>

									<td width="372" style="width:539pt">A device designed to limit
										or restrict the flow of water or regenerant; may include a throttling
										valve, an orifice of fixed diameter, or a pressure compensating orifice.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Flow Rate</td>
									<td width="372" style="width:539pt">The quantity of water or
										regenerant which passes a given point in a specified unit of time, often
										expressed in gallons per minute.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Fluoridation</td>
									<td width="372" style="width:539pt">The addition of a fluoride
										compound to a water supply for the reduction in incidence of dental
										caries.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Flush Tank</td>
									<td width="372" style="width:539pt">A tank or chamber in which
										water is stored for rapid release.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Flush Valve</td>

									<td width="372" style="width:539pt">A self-closing valve
										designed to release a large volume of water when tripped.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Fma</td>
									<td width="372" style="width:539pt">Abbreviation for free
										mineral acidity (see mineral acidity).</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Fouling</td>
									<td width="372" style="width:539pt">The process in which
										undesirable foreign matter accumulates in a bed of water conditioning
										media, clogging pores and coating surfaces and thus inhibiting or
										retarding the proper operation of the bed.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Free Available Chlorine</td>
									<td width="372" style="width:539pt">The concentration of
										residual chlorine present as dissolved gas, hypochlorous acid or
										hypochlorite, not combined with ammonia or in other less readily available
										form.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Free Carbon Dioxide</td>

									<td width="372" style="width:539pt">Carbon dioxide present in
										water as the gas, or as carbonic acid, but not that combined in carbonates
										or bicarbonates.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Free Chlorine</td>
									<td width="372" style="width:539pt">See free available
										chlorine.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Free Mineral Acidity</td>
									<td width="372" style="width:539pt">See mineral acidity.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Freeboard</td>
									<td width="372" style="width:539pt">The vertical distance
										between a bed of filter media or ion exchange material and the overflow or
										collector for backwash water; the height above the bed of granular media
										available for bed expansion during backwashing; may be expressed either as
										a linear distance or a percentage of bed depth.</td>
								</tr>

						</tbody></table>
					</div>
					<div class="slide" id="slide-7">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Gallionella Ferruginea</td>
									<td width="372" style="width:539pt">A genus of stalked,
										ribbon-like bacteria which utilize iron in their metabolism, and cause
										staining, plugging and odor problems in water systems. (See iron
										bacteria.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Gallon</td>

									<td width="372" style="width:539pt">A unit of liquid volume;
										the U.S. gallon has a volume of 231 cubic inches or 3.78533 liters; the
										British (Imperial) gallon has a volume of 277.418 cubic inches or 4.54596
										liters.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Galvanic Cell</td>
									<td width="372" style="width:539pt">A cell which generates an
										electrical current, consisting of dissimilar metals in contact with each
										other and with an electrolyte.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Galvanic Corrosion</td>
									<td width="372" style="width:539pt">The form of corrosion which
										occurs in a galvanic cell, in which one of the metals goes into solution;
										accelerated by high concentrations of dissolved minerals in water, which
										increases the electrical conductance; and elevated temperatures. (See
										corrosion, electrolyte.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Gate Valve</td>
									<td width="372" style="width:539pt">A valve with the closing
										element that is a disc which is moved across the stream, often in a groove
										or slot, for support against pressure.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Gel Zeolite</td>

									<td width="372" style="width:539pt">A synthetic sodium
										aluminoscilicate ion exchanger.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:56.25pt">

									<td width="20" height="75" style="height:56.25pt"></td>
									<td height="75" style="height:56.25pt">Giardia Lamblia</td>
									<td width="372" style="width:539pt">An intestinal parasite
										commonly found in water supplies originating in mountainous or wooded
										watersheds. It exists as a free-swimming protozoan-like organism in
										warm-blooded animals' intestines, causing chronic diarrhea, cramps,
										bloating and weight loss. Outside of the intestines, it forms a tough cyst
										that protects it until it finds a new host. Resistant to chlorine and most
										oxidizing agents, Giardia can be removed effectively through filtration
										below 1 micrometer.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Giardia Lamblia</td>
									<td width="372" style="width:539pt">A protozoan frequently
										found in rivers and lakes, which can survive in water for 1 to 3 months,
										associated with the disease giardiasis. Ingestion of this protozoan in
										contaminated drinking water, exposure from person-to-person contact, and
										other exposure routes may cause giardiasis. The symptoms of this
										gastrointestinal disease may persist for weeks or months and include
										diarrhea, fatigue, and cramps.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Globe Valve</td>
									<td width="372" style="width:539pt">A valve in which the
										closing element is a sphere, or a flat or rounded gasket, which is moved
										into or onto a round port.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Gpg</td>

									<td width="372" style="width:539pt">Abbreviation for "grain(s)
										per gallon".</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Grab Sample</td>
									<td width="372" style="width:539pt">A single sample of material
										collected at one place and one time.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>

									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Grain (Gr.)</td>
									<td width="372" style="width:539pt">A unit of eight equal to
										1/7000th of a pound, or 0.0648 gram.</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Grain(S) Per Gallon (Gpg)</td>
									<td width="372" style="width:539pt">A common basis for
										reporting water analyses in the United States and Canada; one grain per
										U.S. gallon equals 17.12 milligrams per liter (mg/l) or parts per million
										(ppm). One grain per British (Imperial) gallon equals 14.3 milligrams per
										liter or parts per million.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Gram (G)</td>

									<td width="372" style="width:539pt">The basic unit of weight
										(mass) of the metric system, originally intended to be the weight of 1
										cubic centimeter of water at 4oC. (One pound is 454 grams.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Gram-Milliequivalent</td>
									<td width="372" style="width:539pt">The equivalent weight of a
										substance in grams, divided by one thousand.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Gravimetric</td>
									<td width="372" style="width:539pt">Measurement of matter on
										the basis of weight.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Greensand</td>
									<td width="372" style="width:539pt">A natural mineral,
										primarily composed of complex silicates, which possess ion exchange
										properties. (See manganese greensand, zeolite.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Ground Water</td>

									<td width="372" style="width:539pt">The water that systems pump
										and treat from aquifers (natural reservoirs below the earth's surface). </td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-8">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:56.25pt">
									<td width="20" height="75" style="height:56.25pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Hardness</td>
									<td width="372" style="width:539pt">A characteristic of natural
										water due primarily to the presence of dissolved polyvalent (valence
										greater than 1) cations, such as calcium (Ca+2) and magnesium (Mg+2).
										Water hardness is responsible for most scale formation in pipes and water
										heaters, and forms insoluble "curd" when it reacts with soaps.
										Hardness is usually expressed in grains per gallon, parts per million, or
										milligrams per liter, all as calcium carbonate equivalent.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Head</td>

									<td width="372" style="width:539pt">A measure of the pressure
										at a point in a water system, expressed in pounds per square inch, or in
										the height of a column of water which would produce the pressure. 1 psi
										equals 2.31 feet of head (water).</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Head Loss</td>
									<td width="372" style="width:539pt">The same as "pressure
										drop".</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>

									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Health Advisory</td>
									<td width="372" style="width:539pt">An EPA document that
										provides guidance and information on contaminants that can affect human
										health and that may occur in drinking water, but which EPA does not
										currently regulate in drinking water. </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">High-Test Hypochlorite</td>
									<td width="372" style="width:539pt">A dry solid, largely
										calcium hypochlorite, used as a disinfecting agent; has excellent
										stability as long as kept dry.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Home-Owned</td>

									<td width="372" style="width:539pt">A slang term sometimes
										applied to permanently installed household water conditioning equipment,
										as opposed to rental or portable exchange equipment.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Hydration</td>
									<td width="372" style="width:539pt">The chemical combination of
										water into a substance.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Hydraulic</td>
									<td width="372" style="width:539pt">Referring to water or other
										fluids in motion.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Hydraulic Classification</td>
									<td width="372" style="width:539pt">A process in which
										particles of the same specific gravity may be graded according to size by
										backwashing or other relative upward flow of water, with the smallest
										particles tending to rise to the top of the bed, and largest particles
										tending to sink to the bottom, because of variations in weight to sur area
										ratios.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Hydrogen Cycle</td>

									<td width="372" style="width:539pt">The cation exchange cycle
										in which the cation exchanger is regenerated with acid, and cations are
										removed from the solution treated, in exchange for hydrogen ions.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Hydrogen Ion
										Concentration</td>
									<td width="372" style="width:539pt">The concentration of
										hydrogen ions in moles per liter of solution; often expressed as pH. (See
										pH.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Hydrogen Sulfide</td>
									<td width="372" style="width:539pt">This is not a routine test
										but is determined only upon request and on a separate special sample. It
										is a poisonous gas and will cause headache and nausea. It smells like
										"rotten eggs". It causes a black precipitate with many metals.</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:56.25pt">
									<td width="20" height="75" style="height:56.25pt"></td>
									<td height="75" style="height:56.25pt">Hydrologic Cycle</td>
									<td width="372" style="width:539pt">The water cycle, including
										precipitation of water from the atmosphere as rain or snow, flow of water
										over or through the earth, and evaporation or transpiration to water vapor
										in the atmosphere. Water evaporates from the earth and rises into the
										atmosphere where it forms clouds. In nature, this is where water is in its
										purest form. However, it does not stay that way for long. Its stay in the
										air is short. Water droplets forming in clouds, absorb particles and
										impurities found floating in the air.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Hydrolysis</td>

									<td width="372" style="width:539pt">The reaction of a salt with
										water to form an acid and a base.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Hydropneumatic System</td>
									<td width="372" style="width:539pt">A system utilizing both air
										and water in its operation, such as the pressure tank used with many well
										systems, which utilizes an air chamber to maintain pressure on the water
										when the pump is not operating.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Hydrostatic Test</td>
									<td width="372" style="width:539pt">A pressure test procedure
										in which a vessel or system is filled with water, purged of air, sealed,
										subjected to water pressure, and examined for leaks, distortion and/or
										mechanical failure.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Hydroxide</td>
									<td width="372" style="width:539pt">A chemical compound
										containing hydroxyl (OH) ion. (See hydroxyl.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Hydroxyl</td>

									<td width="372" style="width:539pt">The OH anion which has a
										single negative charge, and provides the characteristics common to bases.
										(See base.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Hypochlorite</td>
									<td width="372" style="width:539pt">The OCL anion; calcium and
										sodium hypochlorite are commonly used as bleaches and disinfecting agents.</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-9">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Indicator</td>
									<td width="372" style="width:539pt">A material which can be
										used to show the endpoint of a chemical reaction, usually by a color
										change, or a chemical concentration by a depth or shade of color.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Influent</td>

									<td width="372" style="width:539pt">The stream entering a unit,
										stream or process, such as the hard water entering an ion exchange water
										softener.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Inorganic Contaminants</td>
									<td width="372" style="width:539pt">Mineral-based compounds
										such as metals, nitrates, and asbestos. These contaminants are
										naturally-occurring in some water, but can also get into water through
										farming, chemical manufacturing, and other human activities. EPA has set
										legal limits on 15 inorganic contaminants. &nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Inorganic Matter</td>
									<td width="372" style="width:539pt">Matter which is not derived
										from living organisms and contains no organically produced carbon;
										includes rocks, minerals and metals.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Installation</td>
									<td width="372" style="width:539pt">The process in which water
										conditioning equipment is connected into the water system, and a drain
										line provided where necessary. The term is also used to refer to the
										complete assembly of piping, valves, drain line, water conditioning unit
										and related equipment.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Intermittent Flow</td>

									<td width="372" style="width:539pt">The term usually applied to
										the interrupted patterns of water usage; also used in reference to
										specific on-off flow patterns selected to test the performance of water
										conditioning equipment under standard conditions, which may or may not be
										similar to actual patterns of use of installed equipment.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Ion</td>
									<td width="372" style="width:539pt">An atom or group of atoms
										which function as a unit, and have a positive (cation) or negative (anion)
										electrical charge, due to the gain or loss of one or more electrons. (See
										ionization.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Ion Exchange</td>
									<td width="372" style="width:539pt">A reversible process in
										which ions are released from an insoluble permanent material in exchange
										for other ions in a surrounding solution; the direction of the exchange
										depends upon the affinities of the ion exchanger for the ions present, and
										the concentrations of the ions in the solution. (See base exchange.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Ion Exchanger</td>
									<td width="372" style="width:539pt">A permanent, insoluble
										material which contains ions that will exchange reversibly with other ions
										in a surrounding solution. Both cation and anion exchangers are used in
										water conditioning. (See anion, cation, ion.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Ionization</td>

									<td width="372" style="width:539pt">The process in which atoms
										gain or lose electrons; sometimes used as synonymous with dissociation,
										the separation of molecules into charged ions in solution.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Ionization Constant</td>
									<td width="372" style="width:539pt">A constant specific for
										each partially ionizable chemical compound to express the ratio of the
										concentration of ions from the compound to the concentration of un-ionized
										compound.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Iron</td>
									<td width="372" style="width:539pt">An element often found in
										ground water. It is objectionable in water supplies because of the
										staining caused after oxidation (bleach) and precipitation, tastes, and
										unsightly colors produced when iron reacts with tannin in beverages such
										as coffee and tea.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Iron Bacteria</td>
									<td width="372" style="width:539pt">Microorganisms which are
										capable of utilizing ferrous iron, either from the water or from steel
										pipe, in their metabolism, and precipating ferric hydroxide in the sheaths
										and gelatinous deposits. These organisms tend to collect in pipe lines and
										tanks during periods of low flow, and to break loose in slugs of turbid
										water to create staining, taste and odor problems. (See Crenothrix
										polyspora, Gallionella ferruginea.)</td>
								</tr>

						</tbody></table>
					</div>
					<div class="slide" id="slide-10">
						<table cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Jackson Turbidity<br>Unit</td>
									<td width="372" style="width:539pt">An obsolete unit of
										turbidity measurement based on a suspension of a specific type of silica
										with the turbidity measured in a Jackson Candle Turbidimeter (contract to
										"Nephelometric Turbidity Unit").</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Jtu</td>

									<td width="372" style="width:539pt">The abbreviation for
										"Jackson Turbidity Unit".</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-11">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Kilo</td>
									<td width="372" style="width:539pt">A prefix used to indicate
										1000 of the succeeding unit. (Kilo is also sometimes used as an
										abbreviation for kilogram.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Kilograin(Kgr.)</td>

									<td width="372" style="width:539pt">One thousand grains. (See
										grain.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Kilogram (Kg.)</td>
									<td width="372" style="width:539pt">One thousand grams. (See
										gram.)</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-12">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Laminar Flow</td>    
									<td width="372" style="width:539pt">The flow of fluid in which
										the flow paths are in smooth, parallel lines, with essentially no mixing
										and no turbulence.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Langelier's Index</td>

									<td width="372" style="width:539pt">A calculated number used to
										predict whether or not a water will precipitate, be in equilibrium with,
										or dissolve calcium carbonate. It is sometimes erroneously assumed that
										any water which tends to dissolve calcium carbonate is automatically
										corrosive.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Las</td>
									<td width="372" style="width:539pt">Abbreviation for
										"Linear Alkyl Sulfonate".</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>

									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Lead</td>
									<td width="372" style="width:539pt">This odorless and tasteless
										chemical can leach into water from the corrosion of household plumbing
										systems or from the erosion of natural deposits. According to the
										definition in California Proposition 65, may lead to elevated blood
										pressure levels and/or kidney damage in adults. If ingested regularly by
										children, lead may cause delays in physical or mental development.</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Leakage</td>
									<td width="372" style="width:539pt">The presence of a
										consistent concentration of ions in the effluent of an ion exchange system
										due to incomplete removal of the ions; caused by incomplete regeneration,
										excessive flow rates, low temperatures, the concentration or
										characteristics of the influent ions, or other factors. (See hardness
										leakage.)</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Lime</td>

									<td width="372" style="width:539pt">The common name for calcium
										oxide (CAO); hydrated lime is calcium hydroxide, Ca(OH)2.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Lime Scale</td>
									<td width="372" style="width:539pt">Hard water scale containing
										a high percentage of calcium carbonate.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Limestone</td>
									<td width="372" style="width:539pt">A sedimentary rock, largely
										calcium carbonate, and usually also containing significant amounts of
										magnesium carbonate.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Linear Alkyl Sulfonate</td>
									<td width="372" style="width:539pt">A term applied to a family
										of straight chain chemical compounds, widely used as detergents; sometimes
										called "soft" detergents because they are more readily degraded
										to simpler substances by biological action than the previously used alkyl
										benzene sulfonate. (See detergent, alkyl benzene sulfonate.)</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Liter</td>

									<td width="372" style="width:539pt">The basic metric unit of
										volume; 3.785 liters equal 1 U.S. gallon; 1 liter of water weighs 1000
										grams.</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-13">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">M Alkalinity</td>    
									<td width="372" style="width:539pt">Methyl orange alkalinity.
										(See total alkalinity.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Macroreticular</td>

									<td width="372" style="width:539pt">A term applied to ion
										exchange resins that have a rigid polymer porous network in which there
										exists a true pore structure even after drying. The pores are larger than
										atomic distances and are not a part of the gel structure.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Magnesium</td>
									<td width="372" style="width:539pt">One of the elements in the
										earth's crust, the compounds of which when dissolved in water make the
										water hard. The presence of magnesium in water is a factor contributing to
										the formation of scale and insoluble soap curds.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Manganese</td>
									<td width="372" style="width:539pt">An element sometimes found
										dissolved in ground water, usually with dissolved iron but in lower
										concentration; causes black stains and other problems similar to iron. It
										can be removed by a water softener or it can be precipitated by chlorine
										at a pH of 9.5 or above.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Manganese Greensand</td>
									<td width="372" style="width:539pt">Greensand which has been
										processed to incorporate in its pores and on its surface the higher oxides
										of manganese. The product has a mild oxidizing power, and is often used in
										the oxidation and precipitation of iron, manganese and/or hydrogen
										sulfide, and their removal from water (see greensand, manganese zeolite).</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Manganese Zeolite</td>

									<td width="372" style="width:539pt">Synthetic gel zeolite which
										has been processed in the same manner as manganese greensand, and used for
										similar purposes.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Maximum Contaminant
										Level (Mcl)</td>
									<td width="372" style="width:539pt">The highest level of a
										contaminant that EPA allows in drinking water. MCLs ensure that drinking
										water does not pose either a short-term or long-term health risk. EPA sets
										MCLs at levels that are economically and technologically feasible. Some
										states set MCLs which are more strict than EPA's.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Maximum Contaminant Level
										Goal (Mclg)</td>
									<td width="372" style="width:539pt">The level of a contaminant
										at which there would be no risk to human health. This goal is not always
										economically or technologically feasible, and the goal is not legally
										enforceable.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Mbas</td>
									<td width="372" style="width:539pt">Abbreviation for "Methylene
										Blue active Substance".</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Mcl</td>

									<td width="372" style="width:539pt">Abbreviation for
										"Maximum Contaminant Level"; the maximum allowable concentration
										of a contaminant in water as established in the U.S. EPA Drinking Water
										Regulations.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>

								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Mechanical Filter</td>
									<td width="372" style="width:539pt">A filter primarily designed
										for the removal of suspended solid particles, as opposed to filters with
										additional capabilities.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>

									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Media</td>
									<td width="372" style="width:539pt">The plural form of
										"medium".</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Medium</td>

									<td width="372" style="width:539pt">A material used in a filter
										bed to form a barrier to the passage of certain suspended solids or
										dissolved molecules.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">

									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Methylene Blue Active
										Substances</td>
									<td width="372" style="width:539pt">Chemical compounds which
										react with methylene blue to form a blue compound which can be used to
										estimate the concentration by measurement of the depth of color.
										Substances measured include ABS and LAS types of detergents, thus the term
										is commonly used as an expression of detergent concentration. (See
										detergent.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Mg/L</td>
									<td width="372" style="width:539pt">The abbreviation for
										milligrams per liter.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Micrometer</td>
									<td width="372" style="width:539pt">Formally known as micron. A
										linear measure equal to one millionth of a meter or .00003937 inch. The
										symbol for the micrometer is "um".</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Micron</td>

									<td width="372" style="width:539pt">See micrometer.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Micron Rating</td>
									<td width="372" style="width:539pt">The term applied to a
										filter medium to indicate the particle size above which all suspended
										solids will be removed throughout the rated capacity. As used in industry
										standards, this is an "absolute" not "nominal" rating.</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Microorganisms</td>
									<td width="372" style="width:539pt">Tiny living organisms that
										can be seen only with the aid of a microscope. Some microorganisms can
										cause acute health problems when consumed in drinking water. Also known as
										microbes.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Mil</td>

									<td width="372" style="width:539pt">One thousandth of an inch.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Milli</td>
									<td width="372" style="width:539pt">The prefix used with units
										of measure to indicate one thousandth of the unit. Example: a milliliter
										is one thousandth of a liter.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Milligram Per Liter
										(Mg/L)</td>
									<td width="372" style="width:539pt">A unit concentration of
										matter used in reporting the results of water and waste water analyses. In
										dilute water solutions, it is practically equal to the part per million,
										but varies from the ppm in concentrated solutions such as brine. As most
										analyses are performed on measured volumes of water, the mg/l is a more
										accurate expression of the concentration, and is the preferred unit of
										measure.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Millimicron</td>
									<td width="372" style="width:539pt">(archaic) See
										"nanometer".</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:56.25pt">
									<td width="20" height="75" style="height:56.25pt"></td>
									<td height="75" style="height:56.25pt">Mineral</td>

									<td width="372" style="width:539pt">A term applied to inorganic
										substances such as rocks and similar matter found in the earth strata, as
										opposed to organic substances such as plant and animal matter. Minerals
										normally have definite chemical composition and crystal structure. The
										term is also applied to matter derived from minerals, such as the
										inorganic ions found in water. The term has been applied to ion
										exchangers, stemming from the early use of natural zeolite. The term is
										inappropriate to the modern organic ion exchange resins.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Mineral Acidity</td>
									<td width="372" style="width:539pt">Acidity due to the presence
										of inorganic acids such hydrochloric, sulfuric and nitric acids, as
										opposed to acidity due to carbonic acid or organic acids.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Mole</td>
									<td width="372" style="width:539pt">6.02 x 1023 atoms of an
										element or 6.02 x 1023 molecules of a chemical compound. The weight of one
										mole of an element is equal to its atomic weight in grams; the weight of
										one mole of a compound is equal to its molecular weight in grams.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Molecule</td>
									<td width="372" style="width:539pt">The simplest combination of
										atoms that will form a specific chemical compound; the smallest particle
										of a substance which will still retain the essential composition and
										properties of that substance, and which can be broken down only into atoms
										and simpler substances.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Monitoring</td>

									<td width="372" style="width:539pt">Testing that water systems
										must perform to detect and measure contaminants. A water system that does
										not follow EPA's monitoring methodology or schedule is in violation, and
										may be subject to legal action.&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Most Probable Number (Mpn)</td>
									<td width="372" style="width:539pt">The term used to indicate
										the number of microorganisms which, according to statistical theory, would
										be most likely to produce the results observed in certain bacteriological
										tests; usually expressed as a number per 100 ml of water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Mpn</td>
									<td width="372" style="width:539pt">The abbreviation for
										"most probable number".</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-14">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:150pt">Nanometer</td>
									<td width="372" style="width:539pt">Abbreviated "nm",
										a unit of length equal to one thousandth of a micrometer. Often used to
										express the wavelength of ultraviolet light and the colors of visible
										light in colorimetric analytical procedures.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Negative Charge</td>

									<td width="372" style="width:539pt">The electrical charge on an
										electrode or ion in solution, due to the presence of an excess of
										electrons. (See electron, anion.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Negative Head</td>
									<td width="372" style="width:539pt">A condition of negative
										pressure or partial vacuum.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Negative Pressure</td>
									<td width="372" style="width:539pt">A pressure below that of
										the surrounding atomspheric pressure at a specific point; a partial
										vacuum.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Nephelometric Turbidity
										Unit</td>
									<td width="372" style="width:539pt">An arbitrary unit of
										measuring the turbidity in water by the light scattering effect of fine
										suspended particles in a light beam (contrast to "Jackson Turbidity
										Unit").</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Neutral</td>

									<td width="372" style="width:539pt">In electrical systems, the
										term used to indicate neither an excess nor a lack of electrons; a
										condition of balance between positive and negative charges. In chemistry,
										the term used to indicate a balance between acids and bases; the neutral
										point on the pH scale is 7.0, indicating the presence of equal numbers of
										free hydrogen (acidic) and hydroxide (basic) ions.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Neutralization</td>
									<td width="372" style="width:539pt">The addition of either an
										acid or a base to a solution as required to produce a neutral solution.
										The use of alkaline or basic materials to neutralize the acidity of some
										waters is a common practice in water conditioning.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Neutralizer</td>
									<td width="372" style="width:539pt">A common designation for
										alkaline materials such as calcite (calcium carbonate) or magnesia
										(magnesium oxide) used in the neutralization of acid waters.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Nitrates</td>
									<td width="372" style="width:539pt">Inorganic compounds that
										can enter water supplies from fertilizer runoff and sanitary wastewater
										discharges. Nitrates in drinking water are associated with
										methemoglobinemia, or blue baby syndrome, which results from interferences
										in the bloods ability to carry oxygen.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Noncarbonate Hardness</td>

									<td width="372" style="width:539pt">Water hardness due to the
										presence of compounds such as calcium and magnesium chlorides, sulfates or
										nitrates; the excess of total hardness over total alkalinity.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Non-Transient,<br>
										Non-Community Water System</td>
									<td width="372" style="width:539pt">A water system which
										supplies water to 25 or more of the same people at least six months per
										year in places other than their residences. Some examples are schools,
										factories, office buildings, and hospitals which have their own water
										systems.&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Normal Solution</td>
									<td width="372" style="width:539pt">A solution containing a
										gram equivalent weight of a substance in one liter of solution. (See
										equivalent weight.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Ntu</td>

									<td width="372" style="width:539pt">Abbreviation for "Nephelometric
										Turbidity Unit".</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-15">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Odors</td>
									<td width="372" style="width:539pt">Are self-descriptive. Odors
										are sometimes transmitted to the sample by the shipping container when it
										is not a standard Culligan sample bottle.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Operating Pressure</td>

									<td width="372" style="width:539pt">The range of pressure,
										usually expressed in pounds per square inch, over which a water
										conditioning device or water system is designed to function.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Organic Contaminants</td>
									<td width="372" style="width:539pt">Carbon-based chemicals,
										such as chlorohydrocarbons, solvents and pesticides, which can get into
										water through runoff from cropland or discharge from factories. EPA has
										set legal limits on 56 organic contaminants.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Organic Matter</td>
									<td width="372" style="width:539pt">Substances of or derived
										from plant or animal matter. Organic matter is characterized by its
										carbon-hydrogen structure.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Osmosis</td>
									<td width="372" style="width:539pt">A process of diffusion of a
										solvent such as water through a semipermeable membranae which will
										transmit the solvent but impede most dissolved substances. The normal flow
										of solvent is from the dilute solution to the concentrated solution in an
										attempt to bring the solutions on both sides of the membranae to
										equilibrium. (See equilibrium, reverse osmosis.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Oxidation</td>

									<td width="372" style="width:539pt">A chemical process in which
										electrons are removed from an atom, ion, or compound; causing the
										substance's valence to increase. The addition of oxygen is a specific form
										of oxidation; combustion is an extremely rapid form of oxidation, while
										the rusting of iron is a slow form. Whenever oxidation occurs, an
										offsetting reduction reaction must occur. (See reduction.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Ozone</td>
									<td width="372" style="width:539pt">An unstable form of oxygen
										(O3), which can be generated by an electrical discharge through air or
										regular oxygen. It is a strong oxidizing agent and has been used in water
										conditioning as a disinfectant.</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-16">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:150pt">P Alkalinity</td>
									<td width="372" style="width:539pt">Phenolphthalein alkalinity
										of a water as determined by titration with standard acid solution to the
										phenolphthalein endpoint (pH approx. 8.3). Includes carbonate and
										hydroxide alkalinity. (See total alkalinity.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">P.E.</td>

									<td width="372" style="width:539pt">The abbreviation for
										"portable exchange".</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>

								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Particle Size</td>
									<td width="372" style="width:539pt">As used in industry
										standards, the size of a particle suspended in water as determined by its
										smallest dimension, usually expressed in micrometers.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>

									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Parts Per Million (Ppm)</td>
									<td width="372" style="width:539pt">A common basis for
										reporting the results of water and waste water analyses, indicating the
										number of parts by weight of a dissolved or suspended constituent, per
										million parts by weight of water or other solvent. In dilute water
										solutions, one part per million is practically equal to one milligram per
										liter, which is the preferred unit. 17.12 ppm equals one grain per U.S.
										gallon.</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Pathogen</td>
									<td width="372" style="width:539pt">An organism which may cause
										disease.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Per Capita</td>

									<td width="372" style="width:539pt">Per person; generally used
										in expressions of water use, gallons per capita per day (gpcd).</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Percentage Values</td>
									<td width="372" style="width:539pt">These are needed to
										calculate specific resin capacities for this water supply. They are also
										to calculate DI water quality.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Permanent Hardness</td>
									<td width="372" style="width:539pt">Water hardness due to the
										presence of the chlorides and sulfates of calcium and magnesium, which
										will not precipitate by boiling. This term is largely replaced by "noncarbonate
										hardness". (See noncarbonate hardness.)</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Permanganate</td>
									<td width="372" style="width:539pt">Generally refers to
										potassium permanganate, a chemical compound used in water treatment. (See
										potassium permanganate.)</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Ph</td>

									<td width="372" style="width:539pt">The negative logarithm of
										the hydrogen ion concentration. The pH scale ranges from zero to 14 with 7
										as the neutral point, indicating the presence of equal concentrations of
										free hydrogen and hydroxide ions. pH values below 7.0 indicate acidity,
										with 0 most acid; pH values above 7 indicate basicity, with 14 most basic,
										or alkaline.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Phreatophyte</td>
									<td width="372" style="width:539pt">A plant which takes its
										water from the zone of saturation or the capillary fringe of ground water.
										Excessive growths of phreatophytes are undesirable in some areas since
										they may consume large quantities of scarce water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Physical Stability</td>
									<td width="372" style="width:539pt">A measure of the ability of
										an ion exchanger or filter medium to resist breakdown by physical forces
										such as friction, high temperatures and crushing to which it may be
										subjected in use.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Pk</td>
									<td width="372" style="width:539pt">The reciprocal of the
										logarithm of the ionization constant of a chemical compound.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Poh</td>

									<td width="372" style="width:539pt">The negative logarithm of
										the hydroxyl ion concentration. The pOH is related to pH by the
										expression: pH + pOH = 14. (See pH.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Point-Of-Entry Water
										Treatment</td>
									<td width="372" style="width:539pt">Refers
										to devices used in the home where water pipes enter to provide additional
										treatment of drinking water used throughout the home.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Point-Of-Use Water
										Treatment</td>
									<td width="372" style="width:539pt">Refers to devices used in
										the home or office on a specific tap to provide additional drinking water
										treatment.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Pollution</td>
									<td width="372" style="width:539pt">"Pollution is an
										impairment of quality such that it interferes with the intended
										usages." (House Report 2021.)</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Population Equivalent</td>

									<td width="372" style="width:539pt">A unit of measure used to
										express the strength of waste water from any source by comparison to the
										strength and volume of normal household waste water. The figure of 0.17
										pound of BOD per capita per day is often used as a base figure for
										calculations.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Porosity</td>
									<td width="372" style="width:539pt">A measure of the volume of
										internal pores, or voids, in ion exchangers and filter media; sometimes
										expressed as a ratio to the total volume of the medium. (See void volume.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Positive Charge</td>
									<td width="372" style="width:539pt">The net electrical charge
										on an electrode or ion in solution due to the removal of electrons. (See
										electron, cation.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Postchlorination</td>
									<td width="372" style="width:539pt">The application of chlorine
										to a water following other water treatment processes. (See prechlorination.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Potable Water</td>

									<td width="372" style="width:539pt">Water which is suitable for
										human consumption.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Potassium Permanganate</td>
									<td width="372" style="width:539pt">An oxidizing chemical
										commonly used in processes for removing iron, hydrogen sulfide and
										manganese.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Ppm</td>
									<td width="372" style="width:539pt">The abbreviation for
										"parts per million".</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Prechlorination</td>
									<td width="372" style="width:539pt">The application of chlorine
										to a water prior to other water treatment processes. (See postchlorination.)</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Precipitate</td>

									<td width="372" style="width:539pt">To cause a dissolved
										substance to form a solid particle which can be removed by settling or
										filtering, such as in the removal of dissolved iron by oxidation,
										precipitation and filtration. The term is also used to refer to the solid
										formed, and to the condensation of water in the atmosphere to form rain or
										snow.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Precoat</td>
									<td width="372" style="width:539pt">The application of a
										granular filter medium, such as diatomaceous earth or powdered activated
										carbon to a membrane or screen or other filtration surface, prior to the
										service cycle of a filter.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Pressure Differential</td>
									<td width="372" style="width:539pt">A difference or change in
										pressure detected between two points in a system due to differences in
										elevation and/or pressure drop due to flow.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Pressure Drop</td>
									<td width="372" style="width:539pt">A decrease in water
										pressure during flow due to internal friction between molecules of water,
										and external friction due to irregularities or roughness in surfaces past
										which the water flows.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Primacy State</td>

									<td width="372" style="width:539pt">A State that has the
										responsibility and authority to administer EPA's drinking water
										regulations within its borders. The State must have rules at least as
										stringent as EPA's.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Public Notification</td>
									<td width="372" style="width:539pt">An advisory that EPA
										requires a water system to distribute to affected consumers when the
										system has violated MCLs or other regulations. The notice advises
										consumers what precautions, if any, they should take to protect their
										health.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Public Water System (Pws)</td>
									<td width="372" style="width:539pt">Any water system which
										provides water to at least 25 people for at least 60 days annually. There
										are more than 170,000 PWSs providing water from wells, rivers and other
										sources to about 250 million Americans. The others drink water from
										private wells. There are differing standards for PWSs of different sizes
										and types.</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-17">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Quaternary Ammonium</td>
									<td width="372" style="width:539pt">A basic chemical group
										[N(CH3)3+] which provides the site of activity of certain anion exchange
										resins.</td>
								</tr>

						</tbody></table>
					</div>
					<div class="slide" id="slide-18">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">R. O.</td>    
									<td width="372" style="width:539pt">The abbreviation for
										"reverse osmosis".</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Radionuclides</td>

									<td width="372" style="width:539pt">Elements that undergo a
										process of natural decay. As radionuclides decay, they emit radiation in
										the form of alpha or beta particles and gamma photons. Radiation can cause
										adverse health effects, such as cancer, so limits are placed on
										radionuclide concentrations in drinking water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Rated Capacity</td>
									<td width="372" style="width:539pt">The basis for calculating
										the period of time, or number of gallons delivered by a water softener,
										filter, or deionizer, between regenerations or servicing, as determined
										under specific test conditions. (See rated in-service life, rated softener
										capacity.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Rated In-Service Life</td>
									<td width="372" style="width:539pt">The length of time or total
										gallons delivered between servicing of the media in a filter as determined
										under standard test conditions.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Rated Pressure Drop</td>
									<td width="372" style="width:539pt">The pressure drop of a
										water softener or filter at the rated service flow, with clean water at a
										temperature of 60oF, with a freshly regenerated and/or backwashed softener
										or filter, as determined under standard test conditions.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Rated Service Flow</td>

									<td width="372" style="width:539pt">The manufacturer's
										specified maximum flow rate at which a water softener will deliver soft
										water, or a filter will deliver quality water as specified for its type,
										as determined under standard test conditions. A manufacturer may also
										specify a minimum flow rate or a range of service flows.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Rated Softener Capacity</td>
									<td width="372" style="width:539pt">A water softener capacity
										rating based on grains of hardness removed while producing soft water
										between successive regenerations, and related to the pounds of salt
										required for each regeneration, as determined under standard test
										conditions.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Raw Water</td>
									<td width="372" style="width:539pt">Untreated water, or any
										water before it reaches a specific water treatment device or process.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Raw Water</td>
									<td width="372" style="width:539pt">Water in its natural state,
										prior to any treatment for drinking.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Recovery</td>

									<td width="372" style="width:539pt">In reverse osmosis
										processes, indicates the amount of product water taken from the feed water
										stream; expressed as a percentage of product water flow rate to feed water
										flow rate. (See concentration factor.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Red Water</td>
									<td width="372" style="width:539pt">Water which has a reddish
										or brownish appearance due to the presence of precipitated iron and/or
										iron bacteria.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Reduction</td>
									<td width="372" style="width:539pt">A chemical process in which
										electrons are added to an atom, ion or compound, causing the substance's
										valence to decrease. Whenever reduction occurs, an off-setting oxidation
										reaction must occur. (See oxidation.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Regenerant</td>
									<td width="372" style="width:539pt">A solution of a chemical
										compound used to restore the capacity of an ion exchange system. Sodium
										chloride brine is used as a regenerant for ion exchange water softeners,
										and acids and bases are used as regenerants for the cation and anion
										resins used in demineralization.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Regeneration</td>

									<td width="372" style="width:539pt">The process of restoring an
										ion exchange medium to a usable state after exhaustion. In general, it
										includes the backwash, regenerant introduction and fresh water rinse steps
										necessary to prepare a water softener exchange bed for service.
										Specifically, the term may be applied to the step in which the regenerant
										solution is passed through the exchanger bed (salt brine for softeners,
										acid and bases for deionizers.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Regeneration Level</td>
									<td width="372" style="width:539pt">The quantity of regenerant
										used in the regeneration of an ion exchange unit or system, usually
										expressed in pounds per regeneration and/or pounds per regeneration per
										cubic foot of ion exchanger.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Rejection</td>
									<td width="372" style="width:539pt">In reverse osmosis
										processes, the degree of removal of dissolved salts from the feed water as
										it passed through a semipermeable membrane (also called "salt
										rejection"); expressed as a percentage of the feed water TDS. (See
										total dissolved solids.)</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Residual</td>
									<td width="372" style="width:539pt">The amount of a specific
										material remaining in the water following a water treatment process; may
										refer to material remaining as a result of incomplete removal (see
										leakage), or to material meant to remain in the treated water. (See
										residual chlorine.)</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Residual Chlorine</td>

									<td width="372" style="width:539pt">Chlorine remaining in a
										treated water after a specified period of contact time to provide
										continuing protection throughout a distribution system; the difference
										between the total chlorine added, and that consumed by oxidizable matter.
										(See combined available chlorine, free available chlorine.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Resin</td>
									<td width="372" style="width:539pt">Synthetic organic ion
										exchange material, such as the high capacity cation exchange resin widely
										used in water softeners.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Resistance</td>
									<td width="372" style="width:539pt">In water conditioning, the
										opposition offered by water to the flow of electricity through it; the
										reciprocal of electrical conductance. The unit of measurement for
										electrical resistance is the Ohm. Electrical resistance can be used to
										approximate the mineral content, or lack of it, in high quality water.
										(See conductance.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Resistivity</td>
									<td width="372" style="width:539pt">A capacity for resisting
										the flow of electricity. (See resistance.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Reverse Deionization</td>

									<td width="372" style="width:539pt">The use of the anion
										exchange resin ahead of the cation exchange resin (the reverse of the
										usual order), in a deionization system.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Reverse Osmosis</td>
									<td width="372" style="width:539pt">(R.O.) A process that
										reverses, by the application of pressure, the natural process of osmosis
										so that water passed from the more concentrated to the more dilute
										solution through a semipermeable membrane, thus producing a stream of
										water up to 98% free of dissolved solids.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Rinse</td>
									<td width="372" style="width:539pt">That portion of the
										regeneration cycle of an ion exchanger in which fresh water is passed
										through the column to remove spent and excess regenerant, prior to placing
										the system in service.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Risk</td>
									<td width="372" style="width:539pt">The
										potential for harm to people exposed to chemicals. In order for there to
										be risk, there must be hazard and there must be exposure.</td>
								</tr>

						</tbody></table>
					</div>
					<div class="slide" id="slide-19">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Saline Water</td>
									<td width="372" style="width:539pt">Water containing an
										excessive amount of dissolved salts, usually over 5,000 mg/l.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Salt</td>

									<td width="372" style="width:539pt">In chemistry, the term is
										applied to a class of chemical compounds which can be formed by the
										neutralization of an acid with a with a base; the common name for the
										specific chemical compound sodium chloride used in the regeneration of ion
										exchange water softeners.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Salt Splitting</td>
									<td width="372" style="width:539pt">The process in which
										neutral salts in water are converted to their corresponding acids or bases
										by ion exchange resins containing strongly acidic or strongly basic
										functional groups.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Sample</td>
									<td width="372" style="width:539pt">The water that is analyzed
										for the presence of EPA-regulated drinking water contaminants. Depending
										on the regulation, EPA requires water systems and states to take samples
										from source water, from water leaving the treatment facility, or from the
										taps of selected consumers.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Sanitary Survey</td>
									<td width="372" style="width:539pt">An on-site review of the
										water sources, facilities, equipment, operation, and maintenance of a
										public water systems for the purpose of evaluating the adequacy of the
										facilities for producing and distributing safe drinking water.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Saponification</td>

									<td width="372" style="width:539pt">The process in which a
										fatty acid is neutralized with an alkali or base to form a soap.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Scale</td>
									<td width="372" style="width:539pt">A deposit of mineral solids
										on the interior surfaces of water lines and containers, often formed when
										water containing the carbonates or bicarbonates of calcium and magnesium
										is heated.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Secondary Drinking Water
										Standards</td>
									<td width="372" style="width:539pt">Non-enforceable federal
										guidelines regarding cosmetic effects (such as tooth or skin
										discoloration) or aesthetic effects (such as taste, odor, or color) of
										drinking water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Sedimentation</td>
									<td width="372" style="width:539pt">The process in which solid
										suspended particles settle out of water, usually when the water has little
										or no movement. Also called "settling".</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Semipermeable Membrane</td>

									<td width="372" style="width:539pt">Typically a thin, organic
										film which allows the passage of some ions or materials while preventing
										the passage of others. Some membranes will only allow the passage of
										cations. (See electrodialysis.) Some membranes reject most dissolved
										substances, but allow the passage of water. (See reverse osmosis.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Septic</td>
									<td width="372" style="width:539pt">A condition existing during
										the digestion of organic matter, such as in sewage, by anaerobic bacteria
										in the absence of air. A common process for the treatment of household
										sewage in septic tanks, and in municipal sewage treatment in specially
										designed digester.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Sequestering Agent</td>
									<td width="372" style="width:539pt">A chemical compound
										sometimes fed into water to tie up undesirable ions, keep them in
										solution, and eliminate or reduce the normal effects of the ions. For
										example, polyphosphate can sequester hardness and prevent reactions with
										soap. (See cheating agent.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Sequestration</td>
									<td width="372" style="width:539pt">A chemical reaction in
										which certain ions are bound into a stable, water soluble compound, thus
										preventing undesirable action by the ions. (See chelate.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Service Run</td>

									<td width="372" style="width:539pt">That portion of the
										operating cycle of a water conditioning unit in which treated water is
										being delivered, as opposed to the period when the unit is being
										backwashed, recharged or regenerated.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Service Unit</td>
									<td width="372" style="width:539pt">A term sometimes applied to
										softeners or filters which are regenerated or backwashed at a central
										point, then transported to the point of use for connection to the water
										system. (See portable exchange.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Shielded</td>
									<td width="372" style="width:539pt">The separation of metallic
										parts by an electrical nonconductor; insulated by other than an air gap.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Silica Gel Or Siliceous
										Gel</td>
									<td width="372" style="width:539pt">A synthetic hydrated sodium
										aluminosilicate with ion exchange properties, once widely used in ion
										exchange water softeners. (See zeolite, gel zeolite.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Sludge</td>

									<td width="372" style="width:539pt">The semi-fluid solid matter
										collected at the bottom of a system tank or watercourse, as a result of
										the sedimentation or settling of suspended solids or precipitates.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Slug</td>
									<td width="372" style="width:539pt">An abnormally high
										concentration of an undesirable substance which passes through a water
										system, usually brief or intermittent in nature, and often related to an
										upset of a system. For example, a slug of iron may occur during high flow
										which disturbs and suspends previously deposited iron precipitates.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Soap</td>
									<td width="372" style="width:539pt">One of a class of chemical
										compounds which possesses cleansing properties; formed by the reaction of
										a fatty acid with a base or alkali. Sodium and potassium soaps are soluble
										and useful, but can be converted to insoluble calcium and magnesium soaps
										(curd) by the presence of these hardness ions in water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Soda Ash</td>
									<td width="372" style="width:539pt">the common name for sodium
										carbonate, Na2CO3, a chemical compound used as an alkalinity builder in
										some soap and detergent formulations to neutralize acid water, and in the
										lime-soda water treatment process.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Sodium</td>

									<td width="372" style="width:539pt">An ion found in natural
										water supplies, and introduced to water in the ion exchange water
										softening process. Sodium compounds are highly soluble, and do not react
										with soaps or detergents.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Sodium Chloride</td>
									<td width="372" style="width:539pt">The chemical name for
										common salt, widely used in the regeneration of ion exchange water
										softeners.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Sodium Cycle</td>
									<td width="372" style="width:539pt">the cation exchange process
										in which sodium on the ion exchange resin is exchanged for hardness and
										other ions in water. Sodium chloride is the common regenerant used in this
										process.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Soft Water</td>
									<td width="372" style="width:539pt">Any water which contains
										less than 1.0 gpg (17.1 mg/l) of hardness minerals, expressed as calcium
										carbonate.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Softened Water</td>

									<td width="372" style="width:539pt">Any water that is treated
										to reduce hardness minerals to 1.0 gpg (17.1 mg/l) or less, expressed as
										calcium carbonate.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Sole Source Aquifer</td>
									<td width="372" style="width:539pt">An aquifer that supplies 50
										percent or more of the drinking water of an area.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Solute</td>
									<td width="372" style="width:539pt">The substance which is
										dissolved in and by a solvent. Dissolved solids, such as the minerals
										found in water, are solutes.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Solution Feeder</td>
									<td width="372" style="width:539pt">A device, such as a power
										driven pump or an eductor system, designed to feed a solution of a water
										treatment chemical into the water system, usually in proportion to flow.
										(See chemical feeder.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Solvent</td>

									<td width="372" style="width:539pt">The liquid, such as water,
										in which other materials (solutes) are dissolved. (See solute.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Source Water</td>
									<td width="372" style="width:539pt">Water in its natural state,
										prior to any treatment for drinking.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Specific Conductance</td>
									<td width="372" style="width:539pt">The measure of the
										electrical conductance of water or a water solution at a specific
										temperature, usually 25oC. (See resistance.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Specific Gravity</td>
									<td width="372" style="width:539pt">The ratio of the weight of
										a specific volume of a substance compared to the weight of the same volume
										of pure water at 4oC.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Specific Resistance</td>

									<td width="372" style="width:539pt">The measure of the
										electrical resistance of water or a water solution at a specific
										temperature, usually 25oC. (See resistance.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Sphericity</td>
									<td width="372" style="width:539pt">A measure of the roundness
										and wholeness of an ion exchange resin bead.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Spore</td>
									<td width="372" style="width:539pt">In general, specialized
										reproductive bodies or resting cells. In water bacterial
										"spores" resist adverse conditions which would readily destroy
										the parent organism.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Stability Index</td>

									<td width="372" style="width:539pt">See Langelier's Index.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Standard Methods</td>
									<td width="372" style="width:539pt">The abbreviation for the
										name of the reference book "Standard Methods for the Examination of
										Water and Wastewater", widely used in water and waste water testing
										and analysis.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>

									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Static</td>
									<td width="372" style="width:539pt">Fixed in position, resting,
										or without motion, as opposed to dynamic or moving.</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Static System</td>
									<td width="372" style="width:539pt">A system or process in
										which the reactants are not flowing or moving. (See dynamic system.)</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Sterilization</td>

									<td width="372" style="width:539pt">A process in which all
										living organisms are destroyed. (See disinfection.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Strong Base Load Factor Z</td>
									<td width="372" style="width:539pt">Is the total exchangeable
										anions. Thus it is the sum of total anions (which equals the Y factor)
										plus silica, plus carbon dioxide (not carbonic acid formed). 35 gpg is
										considered upper limit for DI applications.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Sulfate</td>
									<td width="372" style="width:539pt">In the range of 30 gpg,
										sulfate salts can cause laxative effects and medicinal taste. In high
										concentration with high calcium hardness, a white insoluble compound is
										formed that is difficult to remove.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Sulfate-Reducing
										Bacteria</td>
									<td width="372" style="width:539pt">A group of bacteria which
										are capable of reducing sulfates in water to hydrogen sulfide gas, thus
										producing obnoxious tastes and odors. These bacteria have no sanitary
										significance, and are classed as nuisance organisms.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Sulfonic Acid</td>

									<td width="372" style="width:539pt">A specific acidic group
										(SO3H) which gives certain cation exchange resins their ion exchange
										capability.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Sulfur</td>
									<td width="372" style="width:539pt">A yellowish solid element.
										The term is also commonly used to refer to water containing hydrogen
										sulfide gas.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Superchlorination</td>
									<td width="372" style="width:539pt">The addition of excess
										amounts of chlorine to a water supply to speed chemical reactions or
										insure disinfection with short contact time. The chlorine residual
										following superchlorination is high enough to be unpalatable, and thus
										dechlorination is commonly employed before the water is used.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Supernatant</td>
									<td width="372" style="width:539pt">The clear liquid lying
										above a sediment or precipitate.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Surface Tension</td>

									<td width="372" style="width:539pt">The result of attraction
										between molecules of a liquid which causes the surface of the liquid to
										act as a thin elastic film under tension. Surface tension causes water to
										form spherical drops, and to reduce penetration into fabrics. Soaps,
										detergents and wetting agents reduce surface tension and increase
										penetration by water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Surface Water</td>
									<td width="372" style="width:539pt">The water that systems pump
										and treat from sources open to the atmosphere, such as rivers, lakes, and
										reservoirs.&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Surface-Active Agent</td>
									<td width="372" style="width:539pt">The material in a soap or
										detergent formulation which promotes the penetration of the fabric by
										water, the loosening of the soil from surfaces, and the suspension of many
										soils; the actual cleaning agent in soap and detergent formulations.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Surfactant</td>
									<td width="372" style="width:539pt">A contraction of the term
										"surface-active agent".</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Suspended Solids</td>

									<td width="372" style="width:539pt">Solid particles in water
										which are not in solution.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Swelling</td>
									<td width="372" style="width:539pt">In the water treatment
										context, the expansion of certain ion exchange resins when converted into
										specific ionic states.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Syndet</td>
									<td width="372" style="width:539pt">A contraction of the term
										"synthetic detergent".</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Synthetic Detergent</td>
									<td width="372" style="width:539pt">A synthetic cleaning agent,
										such as linear alkyl sulfonate and alkyl benzene sulfonate. Synthetic
										detergents react with water hardness, but the products are soluble.</td>

								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-20">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Tds</td>
									<td width="372" style="width:539pt">The abbreviation for
										"total dissolved solids".</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Temporary Hardness</td>

									<td width="372" style="width:539pt">Water hardness due to the
										presence of calcium and magnesium carbonates and bicarbonates, which can
										be precipitated by heating the water. Now largely replaced by the term
										"carbonate hardness". (See carbonate hardness, permanent
										hardness.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>

								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Threshold</td>
									<td width="372" style="width:539pt">A very low concentration of
										a substance in water. The term is sometimes used to indicate the
										concentration which can just be detected.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>

									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Throughput Volume</td>
									<td width="372" style="width:539pt">The amount of solution
										passed through an ion exchange bed before the ion exchanger is exhausted.</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Titration</td>
									<td width="372" style="width:539pt">An analytical process in
										which a standard solution in a calibrated vessel is added to a measured
										volume of sample until an endpoint, such as a color change, is reached.
										From the volume of the sample and the volume of standard solution used,
										the concentration of a specific material may be calculated.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Total Acidity</td>

									<td width="372" style="width:539pt">The total of all forms of
										acidity, including mineral acidity, carbon dioxide, and acid salts. Total
										acidity is usually determined by titration with a standard base solution
										to the phenolphthalein endpoint (pH 8.3). (See acidity.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">

									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Total Alkalinity</td>
									<td width="372" style="width:539pt">The alkalinity of a water
										as determined by titration with standard acid solution to the methyl
										orange endpoint (pH approximately 4.5); sometimes abbreviated as
										"M" alkalinity". Total alkalinity includes many alkalinity
										components, such as hydroxides, carbonates, and bicarbonates. (see
										alkalinity.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Total Cations</td>
									<td width="372" style="width:539pt">This is the sum of Ca + Mg
										_ Na + K all reported in gpg as CaCO3. These are "positive" ions
										and are generally metals. Total cations should always equal total anions.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Total Chlorine</td>

									<td width="372" style="width:539pt">The total concentration of
										chlorine in a water, including combined and free chlorine. (See combined
										available chlorine, free available chlorine.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Total Coliform</td>
									<td width="372" style="width:539pt">Bacteria that are used as
										indicators of fecal contaminants in drinking water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Total Dissolved Solids (Tds)</td>
									<td width="372" style="width:539pt">The weight of solids per
										unit volume of water which are in true solution, usually determined by the
										evaporation of a measured volume of filtered water, and determination of
										the residue weight.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Total Hardness</td>
									<td width="372" style="width:539pt">The sum of all hardness
										constituents in a water, expressed as their equivalent concentration of
										calcium carbonate. Primarily due to calcium and magnesium in solution, but
										may include small amounts of metals such as iron, which can act like
										calcium and magnesium in certain reactions. (See hardness.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Total Solids</td>

									<td width="372" style="width:539pt">the weight of all solids,
										dissolved and suspended, organic and inorganic, per unit volume of water;
										usually determined by the evaporation of a measured volume of water at
										105oC in a pre-weighted dish.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Toxic</td>
									<td width="372" style="width:539pt">Having an adverse
										physiological effect on humans or other desirable organisms.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Toxicity</td>
									<td width="372" style="width:539pt">The
										property of a chemical to harm people who come into contact with it.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Trace</td>
									<td width="372" style="width:539pt">A very small concentration
										of a material, high enough to be detected but too low to be measured by
										standard analytical methods.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:45.0pt">
									<td width="20" height="60" style="height:45.0pt"></td>
									<td height="60" style="height:45.0pt">Transient, Non-Community
										Water System</td>

									<td width="372" style="width:539pt">A water system which
										provides water in a place such as a gas station or campground where people
										do not remain for long periods of time. These systems do not have to test
										or treat their water for contaminants which pose long-term health risks
										because fewer than 25 people drink the water over a long period. They
										still must test their water for microbes and several chemicals.&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Transpiration</td>
									<td width="372" style="width:539pt">The process in which living
										plants release water vapor into the atmosphere, a significant part of the
										hydrologic cycle.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Treatment Technique</td>
									<td width="372" style="width:539pt">A specific treatment method
										required by EPA to be used to control the level of a contaminant in
										drinking water. In specific cases where EPA has determined it is not
										technically or economically feasible to establish an MCL, EPA can instead
										specify a treatment technique.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Tuberculation</td>
									<td width="372" style="width:539pt">The process in which
										blister-like growths of metal oxides develop in pipes as a result of the
										corrosion of the pipe metal. Iron oxide tubercles often develop over pits
										in iron or steel pipe, and can seriously restrict the flow of water.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Turbidity</td>

									<td width="372" style="width:539pt">A measure of the cloudiness
										in water, the result of finely divided particulate matter suspended in
										water; usually reported in arbitrary units determined by measurements of
										light scattering. (See Nephelometric Turbidity Unit.)</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Turbidity</td>
									<td width="372" style="width:539pt">The cloudy appearance of
										water caused by the presence of tiny particles. High levels of turbidity
										may interfere with proper water treatment and monitoring.&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Turbulent Flow</td>
									<td width="372" style="width:539pt">A type of flow
										characterized by cross currents and eddies, as opposed to laminar or
										streamlined flow. Turbulence may be caused by surface roughness or
										protrusions in pipes, bends and fittings, changes in channel size, or
										excessive flow rates; turbulence significantly increases pressure drops.</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-21">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center"><tbody><tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Unaccounted-For Water</td>
									<td width="372" style="width:539pt">A term used in municipal
										water systems to describe the difference between the water produced and
										that metered and sold. It usually includes losses due to leakage, water
										used for fire fighting, public sprinkling and other municipal purposes,
										and usually ranges from 10 to 35 percent of the water produced.</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Uniformity<br>Coefficient</td>
									<td width="372" style="width:539pt">A measure of the variation
										in particle sizes of ion exchange resins and filter media. It is defined
										as the ratio of the size of particle which has 60 percent of the material
										finer than itself, to the size of the particle which has 10 percent finer
										than itself.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Upflow</td>

									<td width="372" style="width:539pt">A term used to indicate the
										direction (up) in which water or regenerant flows through an ion exchanger
										or filter media bed during any phase of the operating cycle.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Usepa</td>
									<td width="372" style="width:539pt">The abbreviation for
										"United States Environmental Protection Agency".</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>

									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Usphs</td>
									<td width="372" style="width:539pt">The abbreviation for
										"United States Public Health Service".</td>
								</tr>

						</tbody></table>
					</div>
					<div class="slide" id="slide-22">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:155pt">Vacuum Breaker</td>
									<td width="372" style="width:539pt">A mechanical device which
										automatically vents a water line to the atmosphere when subjected to a
										partial vacuum, thus preventing back-flow. (See back-flow, air gap,
										back-flow preventer.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:56.25pt">
									<td width="20" height="75" style="height:56.25pt"></td>
									<td height="75" style="height:56.25pt">Valence</td>

									<td width="372" style="width:539pt">A small positive or
										negative whole number, also called oxidation number, which indicates the
										net number of electrons gained or lost in the formation of an ion, or the
										number of electrons the substance can donate or accept in a chemical
										reaction, and thus the numbers of each kind of ion necessary for a
										balanced chemical reaction. For example, two hydrogen ions (each with a
										valence of +1) must be present for each ion of oxygen (-2) to form a
										molecule of water (H2O).</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:67.5pt">

									<td width="20" height="90" style="height:67.5pt"></td>
									<td height="90" style="height:67.5pt">Variance</td>
									<td width="372" style="width:539pt">State or EPA permission not
										to meet a certain drinking water standard. The water system must prove
										that: (1) it cannot meet a MCL, even while using the best available
										treatment method, because of the characteristics of the raw water, and (2)
										the variance will not create an unreasonable risk to public health. The
										State or EPA must review, and allow public comment on, a variance every
										three years. States can also grant variances to water systems that serve
										small populations and which prove that they are unable to afford the
										required treatment, an alternative water source, or otherwise comply with
										the standard.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Viable</td>
									<td width="372" style="width:539pt">Alive and capable of
										continued life.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Violation</td>
									<td width="372" style="width:539pt">A failure to meet any state
										or federal drinking water regulation.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Virus</td>

									<td width="372" style="width:539pt">The smallest form of life
										known to be capable of producing disease or infection, usually considered
										to be of large molecular size. They multiply by assembly of component
										fragments in living cells, rather than by cell division, as do most
										bacteria.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Viscosity</td>
									<td width="372" style="width:539pt">The resistance of fluids to
										flow, due to internal forces and friction between molecules, which
										increases as temperature decreases.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Void Volume&nbsp;</td>
									<td width="372" style="width:539pt">The volume of the spaces
										between particles of ion exchanger, filter media, or other granular
										material; often expressed as a percentage of the total volume occupied by
										the material.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Volatile</td>
									<td width="372" style="width:539pt">Capable of vaporization at
										a relatively low temperature.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Volatile Organic
										Chemicals (V.O.C.'S)</td>

									<td width="372" style="width:539pt">Chemicals
										that, as liquid, evaporate into the air.<span style="mso-spacerun:yes">&nbsp;</span></td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Volatile Solids</td>
									<td width="372" style="width:539pt">Matter which remains as a
										residue after evaporation at 105 or 180oC, but which is lost after
										ignition at 600oC. Includes most forms of organic matter.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:56.25pt">
									<td width="20" height="75" style="height:56.25pt"></td>
									<td height="75" style="height:56.25pt">Volitile Organic
										Chemicals (Voc)</td>
									<td width="372" style="width:539pt">VOCs are a category of
										cantaminants. These chemicals, which include tetrachloroethylene, benzene
										and xylenes, are used in solvents, cleaners and degreasers used in many
										industrial and household products. When spilled or dumped, a portion of
										VOCs enter the ground and may eventually reach the water table. According
										to the EPA, health effects of VOCs include liver, kidney or central
										nervous system problems. Some VOCs are also suspected carcinogens.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Volumetric</td>
									<td width="372" style="width:539pt">Referring to measurement by
										volume rather than weight. (See gravimetric.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Vulnerability Assessment&nbsp;</td>

									<td width="372" style="width:539pt">An evaluation of drinking
										water source quality and its vulnerability to contamination by pathogens
										and toxic chemicals.</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-23">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Water Conditioning</td>
									<td width="372" style="width:539pt">Virtually any form of water
										treatment designed to improve the aesthetic quality of water by the
										neutralization, inhibition or removal of undesirable substances. (Not
										health related.)</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Water Cycle</td>

									<td width="372" style="width:539pt">See hydrologic cycle.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Water Hammer</td>
									<td width="372" style="width:539pt">A shock wave or series of
										waves produced by the abrupt acceleration or deceleration of water flow,
										due to inertia. Water hammer may produce instantaneous pressures many
										times the normal pressure.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Water Softening</td>
									<td width="372" style="width:539pt">The removal of calcium and
										magnesium, the ions which are the principle cause of hardness, from water.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>

									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Water Table</td>
									<td width="372" style="width:539pt">The level of the top of the
										zone of saturation, in which free water exists in the pores and crevices
										of rocks and other earth strata.</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Watershed</td>

									<td width="372" style="width:539pt">The land area from which
										water drains into a stream, river, or reservoir.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Weak Base Load Faction X</td>
									<td width="372" style="width:539pt">Is referred to as the
										"Theoretical Mineral Acidity (TMA). It is the sum of the chloride,
										sulfate, and nitrate.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>

									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
								<tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Wellhead Protection Area</td>
									<td width="372" style="width:539pt">The
										area surrounding a drinking water well or well field which is protected to
										prevent contamination of the well(s).<span style="mso-spacerun:yes">&nbsp;</span></td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-24">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt">&nbsp;</td>
									<td width="196" height="15" style="height:11.25pt;width:147pt"></td>
									<td width="372" style="width:539pt">No terms starting with X</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">&nbsp;</td>
									<td width="372" style="width:539pt">&nbsp;</td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-25">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center">
							<tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt"> </td>
									<td width="372" style="width:539pt">No terms starting with Y</td>
								</tr>

								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
						</tbody></table>
					</div>
					<div class="slide" id="slide-26">
						<table width="500" cellspacing="0" cellpadding="8" border="0" align="center"><tbody><tr style="height:22.5pt">
									<td width="20" height="30" style="height:22.5pt"></td>
									<td width="196" height="15" style="height:11.25pt;width:147pt">Zeolite</td>    
									<td width="372" style="width:539pt">A group of hydrated sodium
										aluminosilicates, either natural or synthetic, with ion exchange
										properties. (See gel zeolite, greensand.)</td>
								</tr>
								<tr style="height:11.25pt">

									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:33.75pt">
									<td width="20" height="45" style="height:33.75pt"></td>
									<td height="45" style="height:33.75pt">Zeolite Softening</td>
									<td width="372" style="width:539pt">The removal of calcium and
										magnesium by ion exchange using natural or synthetic zeolite. The term is
										sometimes used to refer to all ion exchange softening processes, even
										though organic ion exchange resins, not inorganic zeolites, are in most
										common use today.</td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Zero Soft</td>

									<td width="372" style="width:539pt">Water with a total hardness
										less than 1.0 grain per U.S. gallon, as calcium carbonate.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>
								</tr>
								<tr style="height:22.5pt">

									<td width="20" height="30" style="height:22.5pt"></td>
									<td height="30" style="height:22.5pt">Zone Of Aeration</td>
									<td width="372" style="width:539pt">The layer in the ground
										above an aquifer where the available voids are filled with air. Water
										falling on the ground percolates through this zone on its way to the
										aquifer.</td>
								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt"> </td>
									<td width="372" style="width:539pt"> </td>

								</tr>
								<tr style="height:11.25pt">
									<td width="20" height="15" style="height:11.25pt"></td>
									<td height="15" style="height:11.25pt">Zone Of Saturation</td>
									<td width="372" style="width:539pt">The layer in the ground in
										which all of the available voids are filled with water.</td>
								</tr>
						</tbody></table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="linebreak style2"><img src="{{skin url='images/media/separator2.png'}}" alt="" /></div>
</div>
<script type="text/javascript">
	var glossary = new Carousel('carousel-wrapper', $$('#carousel-content .slide'), $$('a.carousel-jumper'));
	$$('.carousel-jumper').each(function(page){
		//set new height for document
		$(page).observe('click',function(){
			var newHeight = glossary.current.offsetHeight+'px';
			$('carousel-wrapper').setStyle({height:newHeight});
		});
	});
</script>
<!--end of page-->
EOD;

	$root_template = 'two_columns_left';

	$title = 'Water Glossary';

	$identifier = 'water-filtration-glossary.html';

	$layout_update = <<<EOD
<reference name="left">
<block type="cms/block" name="water.university.navigation">
    <action method="setBlockId"><block_id>water-university-navigation</block_id></action>
</block>
</reference>
<reference name="head">
	<action method="addCss"><stylesheet>css/cmspage.css</stylesheet></action>
	<action method="addJs"><script>scriptaculous/scriptaculous.js</script></action>
	<action method="addJs"><script>prototype/carousel.js</script></action>
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

/*MERGED CONTENT : ADD NEW PAGE*/
/*ADD WATER NEWS*/

    $content = <<<EOD
<!--add water-filters-blog-->
<div class="content">
	<!--START: feeds_index-->
	<table style="width: 95%;" border="0" cellspacing="0" cellpadding="0"><!--START: feeds_index_link-->
		<tbody>
			<tr>
				<td><a href="#71">10 American Cities With the Worst Drinking Water</a></td>
			</tr>
			<tr>
				<td><a href="#68">2011 EWG (Environmental Working Group) Bottled Water Scorecard</a></td>
			</tr>
			<tr>
				<td><a href="#70">Chromium-6 Is Widespread in US Tap Water</a></td>
			</tr>
			<tr>
				<td><a href="#69">Probable carcinogen hexavalent chromium found in drinking water of 31 U.S. cities</a></td>
			</tr>
			<tr>
				<td><a href="#72">Pharmaceuticals in our Water</a></td>
			</tr>
			<tr>
				<td><a href="#65">New York Drinking Water Program GWUDI NSF 53</a></td>
			</tr>
			<tr>
				<td><a href="#64">Complaints Over 'Musty' Water In St. Cloud and Minneapolis</a></td>
			</tr>
			<tr>
				<td><a href="#63">Minnesota PFC Contaminants</a></td>
			</tr>
			<tr>
				<td><a href="#60">Tap Water Contaminants</a></td>
			</tr>
			<tr>
				<td><a href="#61">Bottled Water Contaminants</a></td>
			</tr>
			<tr>
				<td><a href="#62">U.S. News Report</a></td>
			</tr>
			<!--END: feeds_index_link--></tbody>
	</table>
	<!--END: feeds_index-->
	<p><br /><br /></p>
	<table style="width: 95%;" border="0" cellspacing="1" cellpadding="0"><!--START: feedblock-->
		<tbody>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="71"></a><strong>10 American Cities With the Worst Drinking Water</strong></td>
								<td align="right">1/31/2011 <!--START: feed_author-->by DOUGLAS MCINTYRE<!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">Unknown to most Americans, a surprising number of U.S. cities have drinking water with unhealthy levels of chemicals and contaminants.</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="10-American-Cities-With-the-Worst-Drinking-Water_df_71.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="68"></a><strong>2011 EWG (Environmental Working Group) Bottled Water Scorecard</strong></td>
								<td align="right">1/11/2011 <!--START: feed_author--><!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">With stunningly ambiguous labeling, and powerfully deceptive marketing, the bottled water companies continue to provide a sub standard product at extortionary prices to an uninformed public.</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="2011-EWG-Environmental-Working-Group-Bottled-Water-Scorecard_df_68.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="70"></a><strong>Chromium-6 Is Widespread in US Tap Water</strong></td>
								<td align="right">1/11/2011 <!--START: feed_author--><!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">Laboratory tests commissioned Environmental Working Group (EWG) have detected hexavalent chromium, the carcinogenic &ldquo;Erin Brockovich chemical,&rdquo; in tap water from 31 of 35 American cities.</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="Chromium-6-Is-Widespread-in-US-Tap-Water_df_70.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="69"></a><strong>Probable carcinogen hexavalent chromium found in drinking water of 31 U.S. cities</strong></td>
								<td align="right">12/19/2010 <!--START: feed_author-->by Lyndsey Layton Washington Post Staff Writer<!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">An environmental group that analyzed the drinking water in 35 cities across the United States found that most contained hexavalent chromium, a probable carcinogen that was made famous by the film "Erin Brockovich."</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="Probable-carcinogen-hexavalent-chromium-found-in-drinking-water-of-31-US-cities_df_69.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="72"></a><strong>Pharmaceuticals in our Water</strong></td>
								<td align="right">3/11/2008 <!--START: feed_author-->by The Water Quality Association<!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">The Water Quality Association has issued a fact sheet on the pharmaceuticals in our water problem.</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="Pharmaceuticals-in-our-Water_df_72.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="65"></a><strong>New York Drinking Water Program GWUDI NSF 53</strong></td>
								<td align="right">7/5/2007 <!--START: feed_author--><!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">GWUDI Ground Water Under Direct Inflow of Surface water must now be treated under New York Regulations NSF approved water filtration systems.</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="New-York-Drinking-Water-Program-GWUDI-NSF-53_df_65.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="64"></a><strong>Complaints Over 'Musty' Water In St. Cloud and Minneapolis</strong></td>
								<td align="right">4/10/2007 <!--START: feed_author--><!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">Tannic acid from decaying leaves and bark led to bad taste and odor in the water.</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="Complaints-Over-Musty-Water-In-St-Cloud-and-Minneapolis_df_64.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="63"></a><strong>Minnesota PFC Contaminants</strong></td>
								<td align="right">3/1/2007 <!--START: feed_author--><!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">Minnesota PFC Contaminants Issue</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="Minnesota-PFC-Contaminants_df_63.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="60"></a><strong>Tap Water Contaminants</strong></td>
								<td align="right">10/30/2002 <!--START: feed_author-->by Los Angeles Times<!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">A LA Times article confronts the myth that tap water is safe.</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="Tap-Water-Contaminants_df_60.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="61"></a><strong>Bottled Water Contaminants</strong></td>
								<td align="right">10/30/2002 <!--START: feed_author-->by Greg Lucas, Sacramento Bureau Chief<!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">An article written by Bureau Chief Greg Lucas of Sacramento, refutes the claims by bottled water companies that bottled water is necessarily safe.</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="Bottled-Water-Contaminants_df_61.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="page-headers" width="70%"><a name="62"></a><strong>U.S. News Report</strong></td>
								<td align="right">8/12/2002 <!--START: feed_author--><!--END: feed_author--></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="font1" colspan="2" align="left">A U.S. News Report about the coming water crisis.</td>
							</tr>
							<!--START: feed_description-->
							<tr class="font2">
								<td colspan="2" align="right"><a href="US-News-Report_df_62.html">More Info</a></td>
							</tr>
							<!--END: feed_description--></tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="gray" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<!--END: feedblock--> <!--START: rss_link-->
			<tr>
				<td align="right"><a type="application/rss+xml" href="rssfeed.asp?pageid=48" target="_blank">RSS FEED</a></td>
			</tr>
			<!--END: rss_link--></tbody>
	</table>
	<div class="linebreak">
			<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
	</div>
</div>
<!--end of page-->
EOD;

	$root_template = 'two_columns_left';

	$title = 'Water News';

	$identifier = 'water-news.html';

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
