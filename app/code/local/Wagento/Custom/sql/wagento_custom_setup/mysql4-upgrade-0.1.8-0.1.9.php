<?php
try{
    $installer = $this;
    $installer->startSetup();

	/*ADD EVALUATE YOUR WATER PAGE*/

    $content = <<<EOD
<!--add water contaminants-->
<div class="title">Water Contaminants</div>
<div class="content">
	<div class="para">
		<table class="price1" style="width: 553px;">
			<tbody>
				<tr>
					<th class="price2" scope="col" width="112">Contaminant</th>

					<th class="price2" scope="col" width="57">MCLG<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="57">MCL or TT<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="181">Potential Health
						Effects from Ingestion of Water</th>

					<th class="price2" scope="col" width="116">Sources of
						Contaminant in Drinking Water</th>
				</tr>

				<tr>
					<td class="regular" valign="top" width="112"><a href=
							"http://www.waterfilters.net/Cryptosporidium-Cysts-Water-Contaminant.html">
							Cryptosporidium</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							TT <a href="#3"><sup>3</sup></a>
						</div>
					</td>

					<td class="regular" valign="top" width="181">Gastrointestinal
						illness (e.g., diarrhea, vomiting, cramps)</td>

					<td align="left" class="regular" valign="top" width="116">Human
						and fecal animal waste</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="112"><a href=
							"http://www.waterfilters.net/Giardia-Lamblia-Cysts-Water-Contaminant.html">
							Giardia Lamblia</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							TT<a href="#3"><sup>3</sup></a>
						</div>
					</td>

					<td align="left" class="regular" valign="top" width="181">
						Gastrointestinal illness (e.g., diarrhea, vomiting,
						cramps)</td>

					<td align="left" class="regular" valign="top" width="116">Human
						and animal fecal waste</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="112">Heterotrophic
						plate count</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							n/a
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							TT<a href="#3"><sup>3</sup></a>
						</div>
					</td>

					<td align="left" class="regular" valign="top" width="181">HPC
						has no health effects; it is an analytic method used to measure
						the variety of bacteria that are common in water. The lower the
						concentration of bacteria in drinking water, the better
						maintained the water system is.</td>

					<td align="left" class="regular" valign="top" width="116">HPC
						measures a range of bacteria that are naturally present in the
						environment</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="112">Legionella</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							TT<a href="#3"><sup>3</sup></a>
						</div>
					</td>

					<td align="left" class="regular" valign="top" width="181">
						Legionnaire's Disease, a type of pneumonia</td>

					<td align="left" class="regular" valign="top" width="116">Found
						naturally in water; multiplies in heating systems</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="112"><a href=
							"http://www.waterfilters.net/E-Coli-Water-Contaminant.html">Total
							Coliforms (including fecal coliform and <em>E.
								Coli</em>)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							5.0%<a href="#4"><sup>4</sup></a>
						</div>
					</td>

					<td align="left" class="regular" valign="top" width="181">Not a
						health threat in itself; it is used to indicate whether other
						potentially harmful bacteria may be present<sup>5</sup></td>

					<td align="left" class="regular" valign="top" width="116">
						Coliforms are naturally present in the environment; as well as
						feces; fecal coliforms and <em>E. coli</em> only come from
						human and animal fecal waste.</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="112">Turbidity</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							n/a
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							TT<a href="#3"><sup>3</sup></a>
						</div>
					</td>

					<td align="left" class="regular" valign="top" width="181">
						Turbidity is a measure of the cloudiness of water. It is used
						to indicate water quality and filtration effectiveness (e.g.,
						whether disease-causing organisms are present). Higher
						turbidity levels are often associated with higher levels of
						disease-causing microorganisms such as viruses, parasites and
						some bacteria. These organisms can cause symptoms such as
						nausea, cramps, diarrhea, and associated headaches.</td>

					<td align="left" class="regular" valign="top" width="116">Soil
						runoff</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="112">Viruses
						(enteric)</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							TT<a href="#3"><sup>3</sup></a>
						</div>
					</td>

					<td align="left" class="regular" valign="top" width="181">
						Gastrointestinal illness (e.g., diarrhea, vomiting,
						cramps)</td>

					<td align="left" class="regular" valign="top" width="116">Human
						and animal fecal waste</td>
				</tr>
			</tbody>
		</table><br>
		<div class="linebreak">
			<img src="{{skin url='images/media/separator.png'}}" alt=""/>
		</div>

		<h2>Disinfection Byproducts</h2>

		<table class="price1" style="width: 552px;">
			<tbody>
				<tr>
					<th class="price2" scope="col" width="112">Contaminant</th>

					<th class="price2" scope="col" width="57">MCLG<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="57">MCL or TT<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="181">Potential Health
						Effects from Ingestion of Water</th>

					<th class="price2" scope="col" width="115">Sources of
						Contaminant in Drinking Water</th>
				</tr>

				<tr>
					<td class="regular" valign="top" width="112"><a href=
							"http://www.waterfilters.net/Bromate-Water-Contaminant.html">Bromate</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.010
						</div>
					</td>

					<td class="regular" valign="top" width="181">Increased risk of
						cancer</td>

					<td class="regular" valign="top" width="115">Byproduct of
						drinking water disinfection</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="112"><a href=
							"http://www.waterfilters.net/Chlorite-Water-Contaminant.html">Chlorite</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.8
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							1.0
						</div>
					</td>

					<td class="regular" valign="top" width="181">Anemia; infants
						&amp; young children: nervous system effects</td>

					<td class="regular" valign="top" width="115">Byproduct of
						drinking water disinfection</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="112"><a href=
							"http://www.waterfilters.net/Haloacetic-Acids-HAA5-Water-Contaminant.html">
							Haloacetic acids (HAA5)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							n/a<a href="#6"><sup>6</sup></a>
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.060
						</div>
					</td>

					<td class="regular" valign="top" width="181">Increased risk of
						cancer</td>

					<td class="regular" valign="top" width="115">Byproduct of
						drinking water disinfection</td>
				</tr>

				<tr>
					<td class="regular" height="55" valign="top" width="112">
						<a href=
							"http://www.waterfilters.net/Trihalomethanes-TTHM-Water-Contaminant.html">
							Total Trihalomethanes (TTHMs)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							none<a href="#7"><sup>7</sup></a><br>
							----------<br>
							n/a<a href="#6"><sup>6</sup></a>
						</div>
					</td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.10<br>
							----------<br>
							0.080
						</div>
					</td>

					<td class="regular" valign="top" width="181">Liver, kidney or
						central nervous system problems; increased risk of cancer</td>

					<td class="regular" valign="top" width="115">Byproduct of
						drinking water disinfection</td>
				</tr>
			</tbody>
		</table><br>
		<div class="linebreak">
			<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
		</div>

		<h2>Disinfectants</h2>

		<table class="price1" style="width: 552px;">
			<tbody>
				<tr>
					<th class="price2" scope="col" width="98">Contaminant</th>

					<th class="price2" scope="col" width="79">MRDLG<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="70">MRDL<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="159">Potential Health
						Effects from Ingestion of Water</th>

					<th class="price2" scope="col" width="116">Sources of
						Contaminant in Drinking Water</th>
				</tr>

				<tr>
					<td class="regular" valign="top" width="98"><a href=
							"http://www.waterfilters.net/Chloramines-Water-Contaminant.html">
							Chloramines (as Cl<sub>2</sub>)</a></td>

					<td class="regular" valign="top" width="79">MRDLG=4<a href=
							"#1"><sup>1</sup></a></td>

					<td class="regular" valign="top" width="70">MRDL=4.0<a href=
							"#1"><sup>1</sup></a></td>

					<td class="regular" valign="top" width="159">Eye/nose
						irritation; stomach discomfort, anemia</td>

					<td class="regular" valign="top" width="116">Water additive
						used to control microbes</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="98"><a href=
							"http://www.waterfilters.net/Chlorine-Taste-Odor-Water-Contaminant.html">
							Chlorine (as Cl<sub>2</sub>)</a></td>

					<td class="regular" valign="top" width="79">MRDLG=4<a href=
							"#1"><sup>1</sup></a></td>

					<td class="regular" valign="top" width="70">MRDL=4.0<a href=
							"#1"><sup>1</sup></a></td>

					<td class="regular" valign="top" width="159">Eye/nose
						irritation; stomach discomfort</td>

					<td class="regular" valign="top" width="116">Water additive
						used to control microbes</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="98"><a href=
							"http://www.waterfilters.net/Chlorine-Dioxide-Water-Contaminant.html">
							Chlorine dioxide (as ClO<sub>2</sub>)</a></td>

					<td class="regular" valign="top" width="79">MRDLG=0.8<a href=
							"#1"><sup>1</sup></a></td>

					<td class="regular" valign="top" width="70">MRDL=0.8<a href=
							"#1"><sup>1</sup></a></td>

					<td class="regular" valign="top" width="159">Anemia; infants
						&amp; young children: nervous system effects</td>

					<td class="regular" valign="top" width="116">Water additive
						used to control microbes</td>
				</tr>
			</tbody>
		</table><br>
		<div class="linebreak">
			<img src="{{skin url='images/media/separator.png'}}" alt=""/>
		</div>

		<h2>Inorganic Chemicals</h2>

		<table class="price1" style="width: 552px;">
			<tbody>
				<tr>
					<th class="price2" scope="col" width="101">Contaminant</th>

					<th class="price2" scope="col" width="57">MCLG<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="78">MCL or TT<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="164">Potential Health
						Effects from Ingestion of Water</th>

					<th class="price2" scope="col" width="134">Sources of
						Contaminant in Drinking Water</th>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Antimony-Water-Contaminant.html">Antimony</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.006
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							0.006
						</div>
					</td>

					<td class="regular" valign="top" width="164">Increase in blood
						cholesterol; decrease in blood sugar</td>

					<td class="regular" valign="top" width="134">Discharge from
						petroleum refineries; fire retardants; ceramics; electronics;
						solder</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Arsenic-Water-Contaminant.html">Arsenic</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0<a href="#7"><sup>7</sup></a>
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							0.010<br>
							as of 01/23/06
						</div>
					</td>

					<td class="regular" valign="top" width="164">Skin damage or
						problems with circulatory systems, and may have increased risk
						of getting cancer</td>

					<td class="regular" valign="top" width="134">Erosion of natural
						deposits; runoff from orchards, runoff from glass &amp;
						electronics production wastes</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Asbestos-Water-Contaminant.html">Asbestos<br>
							(fiber &gt;10 micrometers)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							7 million fibers per liter
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							7 MFL
						</div>
					</td>

					<td class="regular" valign="top" width="164">Increased risk of
						developing benign intestinal polyps</td>

					<td class="regular" valign="top" width="134">Decay of asbestos
						cement in water mains; erosion of natural deposits</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Barium-Water-Contaminant.html">Barium</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							2
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							2
						</div>
					</td>

					<td class="regular" valign="top" width="164">Increase in blood
						pressure</td>

					<td class="regular" valign="top" width="134">Discharge of
						drilling wastes; discharge from metal refineries; erosion of
						natural deposits</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Beryllium-Water-Contaminant.html">Beryllium</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.004
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							0.004
						</div>
					</td>

					<td class="regular" valign="top" width="164">Intestinal
						lesions</td>

					<td class="regular" valign="top" width="134">Discharge from
						metal refineries and coal-burning factories; discharge from
						electrical, aerospace, and defense industries</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Cadmium-Water-Contaminant.html">Cadmium</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.005
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							0.005
						</div>
					</td>

					<td class="regular" valign="top" width="164">Kidney damage</td>

					<td class="regular" valign="top" width="134">Corrosion of
						galvanized pipes; erosion of natural deposits; discharge from
						metal refineries; runoff from waste batteries and paints</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Chromium-Water-Contaminant.html">Chromium
							(total)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.1
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							0.1
						</div>
					</td>

					<td class="regular" valign="top" width="164">Allergic
						dermatitis</td>

					<td class="regular" valign="top" width="134">Discharge from
						steel and pulp mills; erosion of natural deposits</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Copper-Water-Contaminant.html">Copper</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							1.3
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							TT<a href="#8"><sup>8</sup></a>;<br>
							Action Level=1.3
						</div>
					</td>

					<td class="regular" valign="top" width="164">
						Short term exposure: Gastrointestinal distress

						<p>Long term exposure: Liver or kidney damage</p>

						<p>People with Wilson's Disease should consult their
						personal doctor if the amount of copper in their water
						exceeds the action level</p>
					</td>

					<td class="regular" valign="top" width="134">Corrosion of
						household plumbing systems; erosion of natural deposits</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Cyanide-Water-Contaminant.html">Cyanide
							(as free cyanide)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.2
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							0.2
						</div>
					</td>

					<td class="regular" valign="top" width="164">Nerve damage or
						thyroid problems</td>

					<td class="regular" valign="top" width="134">Discharge from
						steel/metal factories; discharge from plastic and fertilizer
						factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Fluoride-Water-Contaminant.html">Fluoride</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							4.0
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							4.0
						</div>
					</td>

					<td class="regular" valign="top" width="164">Bone disease (pain
						and tenderness of the bones); Children may get mottled
						teeth</td>

					<td class="regular" valign="top" width="134">Water additive
						which promotes strong teeth; erosion of natural deposits;
						discharge from fertilizer and aluminum factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Lead-Water-Contaminant.html">Lead</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							TT<a href="#8"><sup>8</sup></a>;<br>
							Action Level=0.015
						</div>
					</td>

					<td class="regular" valign="top" width="164">
						Infants and children: Delays in physical or mental
						development; children could show slight deficits in
						attention span and learning abilities

						<p>Adults: Kidney problems; high blood pressure</p>
					</td>

					<td class="regular" valign="top" width="134">Corrosion of
						household plumbing systems; erosion of natural deposits</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Mercury-Water-Contaminant.html">Mercury
							(inorganic)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.002
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							0.002
						</div>
					</td>

					<td class="regular" valign="top" width="164">Kidney damage</td>

					<td class="regular" valign="top" width="134">Erosion of natural
						deposits; discharge from refineries and factories; runoff from
						landfills and croplands</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Nitrates-Nitrites-Water-Contaminant.html">
							Nitrate (measured as Nitrogen)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							10
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							10
						</div>
					</td>

					<td class="regular" valign="top" width="164">Infants below the
						age of six months who drink water containing nitrate in excess
						of the MCL could become seriously ill and, if untreated, may
						die. Symptoms include shortness of breath and blue-baby
						syndrome.</td>

					<td class="regular" valign="top" width="134">Runoff from
						fertilizer use; leaching from septic tanks, sewage; erosion of
						natural deposits</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Nitrates-Nitrites-Water-Contaminant.html">
							Nitrite (measured as Nitrogen)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							1
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							1
						</div>
					</td>

					<td class="regular" valign="top" width="164">Infants below the
						age of six months who drink water containing nitrite in excess
						of the MCL could become seriously ill and, if untreated, may
						die. Symptoms include shortness of breath and blue-baby
						syndrome.</td>

					<td class="regular" valign="top" width="134">Runoff from
						fertilizer use; leaching from septic tanks, sewage; erosion of
						natural deposits</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="101"><a href=
							"http://www.waterfilters.net/Selenium-Water-Contaminant.html">Selenium</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.05
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							0.05
						</div>
					</td>

					<td class="regular" valign="top" width="164">Hair or fingernail
						loss; numbness in fingers or toes; circulatory problems</td>

					<td class="regular" valign="top" width="134">Discharge from
						petroleum refineries; erosion of natural deposits; discharge
						from mines</td>
				</tr>

				<tr>
					<td class="regular" height="70" valign="top" width="101">
						<a href=
							"http://www.waterfilters.net/Thallium-Water-Contaminant.html">Thallium</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.0005
						</div>
					</td>

					<td class="regular" valign="top" width="78">
						<div style="text-align: center">
							0.002
						</div>
					</td>

					<td class="regular" valign="top" width="164">Hair loss; changes
						in blood; kidney, intestine, or liver problems</td>

					<td class="regular" valign="top" width="134">Leaching from
						ore-processing sites; discharge from electronics, glass, and
						drug factories</td>
				</tr>
			</tbody>
		</table><br>
		<div class="linebreak">
			<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
		</div>

		<h2>Organic Chemicals</h2>

		<table class="price1" style="width: 516px;">
			<tbody>
				<tr>
					<th class="price2" scope="col" width="172">Contaminant</th>

					<th class="price2" scope="col" width="57">MCLG<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="76">MCL or TT<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="148">Potential Health
						Effects from Ingestion of Water</th>

					<th class="price2" scope="col" width="149">Sources of
						Contaminant in Drinking Water</th>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Acrylamide-Water-Contaminant.html">
							Acrylamide</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							TT<a href="#9"><sup>9</sup></a>
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Nervous system or blood
						problems; increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Added to water
						during sewage/wastewater treatment</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Alachlor-Water-Contaminant.html">Alachlor</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.002
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Eye, liver, kidney or spleen
						problems; anemia; increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff from
						herbicide used on row crops</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Atrazine-Water-Contaminant.html">Atrazine</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.003
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.003
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Cardiovascular system or
						reproductive problems</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff from
						herbicide used on row crops</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Benzene-Water-Contaminant.html">Benzene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.005
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Anemia; decrease in blood
						platelets; increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						factories; leaching from gas storage tanks and landfills</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Benzoapyrene-Water-Contaminant.html">
							Benzo(a)pyrene (PAHs)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.0002
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Reproductive difficulties;
						increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Leaching from
						linings of water storage tanks and distribution lines</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Carbofuran-Water-Contaminant.html">
							Carbofuran</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.04
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.04
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Problems with blood, nervous
						system, or reproductive system</p>
					</td>

					<td class="regular" valign="top" width="149">Leaching of soil
						fumigant used on rice and alfalfa</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Carbon-Tetrachloride-Water-Contaminant.html">
							Carbon<br>
							tetrachloride</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.005
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver problems; increased risk
						of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						chemical plants and other industrial activities</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Chlordane-Water-Contaminant.html">Chlordane</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.002
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver or nervous system
						problems; increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Residue of banned
						termiticide</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Chlorobenzene-Water-Contaminant.html">
							Chlorobenzene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.1
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.1
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver or kidney problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						chemical and agricultural chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/2-4-D-Water-Contaminant.html">2,4-D</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.07
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.07
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Kidney, liver, or adrenal gland
						problems</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff from
						herbicide used on row crops</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Dalapon-Water-Contaminant.html">Dalapon</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.2
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.2
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Minor kidney changes</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff from
						herbicide used on rights of way</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Dibromochloropropane-Water-Contaminant.html">
							1,2-Dibromo-3-chloropropane (DBCP)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.0002
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Reproductive difficulties;
						increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff/leaching
						from soil fumigant used on soybeans, cotton, pineapples, and
						orchards</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Ortho-Dichlorobenzene-Water-Contaminant.html">
							o-Dichlorobenzene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.6
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.6
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver, kidney, or circulatory
						system problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						industrial chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Para-Dichlorobenzene-Water-Contaminant.html">
							p-Dichlorobenzene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.075
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.075
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Anemia; liver, kidney or spleen
						damage; changes in blood</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						industrial chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/1-2-Dichloroethane-Water-Contaminant.html">
							1,2-Dichloroethane</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.005
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						industrial chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/1-1-Dichloroethylene-Water-Contaminant.html">
							1,1-Dichloroethylene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.007
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.007
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						industrial chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/1-2-Dichloroethylene-Water-Contaminant.html">
							cis-1,2-Dichloroethylene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.07
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.07
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						industrial chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/1-2-Dichloroethylene-Water-Contaminant.html">
							trans-1,2-Dichloroethylene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.1
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.1
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						industrial chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Dichloromethane-Water-Contaminant.html">
							Dichloromethane</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.005
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver problems; increased risk
						of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						drug and chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/1-2-Dichloropropane-Water-Contaminant.html">
							1,2-Dichloropropane</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.005
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						industrial chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Adipate-Water-Contaminant.html">Di(2-ethylhexyl)
							adipate</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.4
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.4
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Weight loss, liver problems, or
						possible reproductive difficulties.</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Di-2-ethylhexyl-Phthalate-Water-Contaminant.html">
							Di(2-ethylhexyl) phthalate</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.006
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Reproductive difficulties;
						liver problems; increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						rubber and chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Dinoseb-Water-Contaminant.html">Dinoseb</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.007
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.007
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Reproductive difficulties</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff from
						herbicide used on soybeans and vegetables</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Dioxin-Water-Contaminant.html">Dioxin
							(2,3,7,8-TCDD)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.00000003
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Reproductive difficulties;
						increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Emissions from
						waste incineration and other combustion; discharge from
						chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Diquat-Water-Contaminant.html">Diquat</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.02
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.02
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Cataracts</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff from
						herbicide use</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Endothall-Water-Contaminant.html">Endothall</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.1
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.1
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Stomach and intestinal
						problems</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff from
						herbicide use</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Endrin-Water-Contaminant.html">Endrin</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.002
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.002
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver problems</p>
					</td>

					<td class="regular" valign="top" width="149">Residue of banned
						insecticide</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Epichlorohydrin-Water-Contaminant.html">
							Epichlorohydrin</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							TT<a href="#9"><sup>9</sup></a>
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Increased cancer risk, and over
						a long period of time, stomach problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						industrial chemical factories; an impurity of some water
						treatment chemicals</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Ethylbenzene-Water-Contaminant.html">
							Ethylbenzene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.7
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.7
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver or kidneys problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						petroleum refineries</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Ethylene-Dibromide-Water-Contaminant.html">
							Ethylene dibromide</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.00005
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Problems with liver, stomach,
						reproductive system, or kidneys; increased risk of
						cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						petroleum refineries</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Glyphosate-Water-Contaminant.html">
							Glyphosate</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.7
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.7
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Kidney problems; reproductive
						difficulties</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff from
						herbicide use</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Heptachlor-Water-Contaminant.html">
							Heptachlor</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.0004
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver damage; increased risk of
						cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Residue of banned
						termiticide</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Heptachlor-Epoxide-Water-Contaminant.html">
							Heptachlor epoxide</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.0002
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver damage; increased risk of
						cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Breakdown of
						heptachlor</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Hexachlorobenzene-Water-Contaminant.html">
							Hexachlorobenzene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.001
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver or kidney problems;
						reproductive difficulties; increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						metal refineries and agricultural chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Hexachlorocyclopentadiene-Water-Contaminant.html">
							Hexachlorocyclopentadiene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.05
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.05
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Kidney or stomach problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Lindane-Water-Contaminant.html">Lindane</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.0002
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.0002
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver or kidney problems</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff/leaching
						from insecticide used on cattle, lumber, gardens</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Methoxychlor-Water-Contaminant.html">
							Methoxychlor</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.04
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.04
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Reproductive difficulties</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff/leaching
						from insecticide used on fruits, vegetables, alfalfa,
						livestock</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Oxamyl-Vydate-Water-Contaminant.html">
							Oxamyl (Vydate)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.2
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.2
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Slight nervous system
						effects</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff/leaching
						from insecticide used on apples, potatoes, and tomatoes</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Polychlorinated-Biphenyls-Water-Contaminant.html">
							Polychlorinated<br>
							biphenyls (PCBs)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.0005
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Skin changes; thymus gland
						problems; immune deficiencies; reproductive or nervous
						system difficulties; increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff from
						landfills; discharge of waste chemicals</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Pentachlorophenol-Water-Contaminant.html">
							Pentachlorophenol</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.001
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver or kidney problems;
						increased cancer risk</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						wood preserving factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Picloram-Water-Contaminant.html">Picloram</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.5
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.5
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver problems</p>
					</td>

					<td class="regular" valign="top" width="149">Herbicide
						runoff</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Simazine-Water-Contaminant.html">Simazine</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.004
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.004
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Problems with blood</p>
					</td>

					<td class="regular" valign="top" width="149">Herbicide
						runoff</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Styrene-Water-Contaminant.html">Styrene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.1
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.1
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver, kidney, or circulatory
						system problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						rubber and plastic factories; leaching from landfills</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Tetrachloroethylene-Water-Contaminant.html">
							Tetrachloroethylene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.005
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver problems; increased risk
						of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						factories and dry cleaners</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Toluene-Water-Contaminant.html">Toluene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							1
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							1
						</div>
					</td>

					<td class="regular" height="22" valign="top" width="148">
						<p style="text-align: left">Nervous system, kidney, or
						liver problems</p>
					</td>

					<td class="regular" height="22" valign="top" width="149">
						Discharge from petroleum factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Toxaphene-Water-Contaminant.html">Toxaphene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.003
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Kidney, liver, or thyroid
						problems; increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Runoff/leaching
						from insecticide used on cotton and cattle</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Silvex-Water-Contaminant.html">2,4,5-TP
							(Silvex)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.05
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.05
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver problems</p>
					</td>

					<td class="regular" valign="top" width="149">Residue of banned
						herbicide</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/1-2-4-Trichlorobenzene-Water-Contaminant.html">
							1,2,4-Trichlorobenzene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.07
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.07
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Changes in adrenal glands</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						textile finishing factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/1-1-1-Trichloroethane-Water-Contaminants.html">
							1,1,1-Trichloroethane</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.20
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.2
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver, nervous system, or
						circulatory problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						metal degreasing sites and other factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/1-1-2-Trichloroethane-Water-Contaminant.html">
							1,1,2-Trichloroethane</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							0.003
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.005
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver, kidney, or immune system
						problems</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						industrial chemical factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Trichloroethylene-Water-Contaminant.html">
							Trichloroethylene</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.005
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Liver problems; increased risk
						of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						metal degreasing sites and other factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Vinyl-Chloride-Water-Contaminants.html">
							Vinyl chloride</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							0.002
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Increased risk of cancer</p>
					</td>

					<td class="regular" valign="top" width="149">Leaching from PVC
						pipes; discharge from plastic factories</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="172"><a href=
							"http://www.waterfilters.net/Xylenes-Water-Contaminant.html">Xylenes
							(total)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							10
						</div>
					</td>

					<td class="regular" valign="top" width="76">
						<div style="text-align: center">
							10
						</div>
					</td>

					<td class="regular" valign="top" width="148">
						<p style="text-align: left">Nervous system damage</p>
					</td>

					<td class="regular" valign="top" width="149">Discharge from
						petroleum factories; discharge from chemical factories</td>
				</tr>
			</tbody>
		</table><br>
		<div class="linebreak">
			<img src="{{skin url='images/media/separator.png'}}" alt=""/>
		</div>

		<h2><a href="http://www.epa.gov/safewater/rads/quickguide.pdf" target=
				"_blank">Radionuclides</a></h2>

		<table class="price1" style="width: 558px;">
			<tbody>
				<tr>
					<th class="price2" scope="col" width="111">Contaminant</th>

					<th class="price2" scope="col" width="57">MCLG<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="62">MCL or TT<a href=
							"#1"><sup>1</sup></a><br>
						(mg/L)<a href="#2"><sup>2</sup></a></th>

					<th class="price2" scope="col" width="167">Potential Health
						Effects from Ingestion of Water</th>

					<th class="price2" scope="col" width="131">Sources of
						Contaminant in Drinking Water</th>
				</tr>

				<tr>
					<td class="regular" valign="top" width="111"><a href=
							"http://www.waterfilters.net/Alpha-Particles-Water-Contaminant.html">
							Alpha particles</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							none<a href="#7"><sup>7</sup></a><br>
							----------<br>
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="62">
						<div style="text-align: center">
							15 picocuries per Liter (pCi/L)
						</div>
					</td>

					<td class="regular" valign="top" width="167">Increased risk of
						cancer</td>

					<td class="regular" valign="top" width="131">Erosion of natural
						deposits of certain minerals that are radioactive and may emit
						a form of radiation known as alpha radiation</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="111"><a href=
							"http://www.waterfilters.net/Beta-Particles-Water-Contaminant.html">
							Beta particles and photon emitters</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							none<a href="#7"><sup>7</sup></a><br>
							----------<br>
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="62">
						<div style="text-align: center">
							4 millirems per year
						</div>
					</td>

					<td class="regular" valign="top" width="167">Increased risk of
						cancer</td>

					<td class="regular" valign="top" width="131">
						Decay of natural and man-made deposits of

						<p>certain minerals that are radioactive and may emit forms
						of radiation known as photons and beta radiation</p>
					</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="111"><a href=
							"http://www.waterfilters.net/Radium-Water-Contaminant.html">Radium
							226 and Radium 228 (combined)</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							none<a href="#7"><sup>7</sup></a><br>
							----------<br>
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="62">
						<div style="text-align: center">
							5 pCi/L
						</div>
					</td>

					<td class="regular" valign="top" width="167">Increased risk of
						cancer</td>

					<td class="regular" valign="top" width="131">Erosion of natural
						deposits</td>
				</tr>

				<tr>
					<td class="regular" valign="top" width="111"><a href=
							"http://www.waterfilters.net/Radon-Water-Contaminant.html">Radon</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							&nbsp;
						</div>
					</td>

					<td class="regular" valign="top" width="62">&nbsp;</td>

					<td class="regular" valign="top" width="167">Increased risk of
						cancer</td>

					<td class="regular" valign="top" width="131">&nbsp;</td>
				</tr>

				<tr>
					<td class="regular" height="57" valign="top" width="111">
						<a href=
							"http://www.waterfilters.net/Uranium-Water-Contaminant.html">Uranium</a></td>

					<td class="regular" valign="top" width="57">
						<div style="text-align: center">
							zero
						</div>
					</td>

					<td class="regular" valign="top" width="62">
						<div style="text-align: center">
							30 ug/L<br>
							as of 12/08/03
						</div>
					</td>

					<td class="regular" valign="top" width="167">Increased risk of
						cancer, kidney toxicity</td>

					<td class="regular" valign="top" width="131">Erosion of natural
						deposits</td>
				</tr>
			</tbody>
		</table>
		<div class="linebreak">
			<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
		</div>

		<p><strong>Source</strong>: <em>"Sensitivity: A Key Water Conditioning
			Skill" written by Wes McGowan and published in <span style=
				"text-decoration: underline;">Water Technology</span>, September/October
			1982.</em></p>

		<span style=
			"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
			<strong>Notes:</strong><br>
			<a id="1" name="1"></a><sup>1</sup>
			Definitions:<br>
			<strong>Maximum Contaminant Level
				(MCL)</strong> - The highest level of a
			contaminant that is allowed in drinking
			water. MCLs are set as close to MCLGs as
			feasible using the best available treatment
			technology and taking cost into
			consideration. MCLs are enforceable
			standards.<strong><br>
				<br>
				Treatment Technique</strong> - A required
			process intended to reduce the level of a
			contaminant in drinking water.</span>

		<p><a id="2" name="2"></a>
		<sup><span style="font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				2</span></sup> <span style=
			"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
			Units are in milligrams per liter (mg/L)
			unless otherwise noted. Milligrams per
			liter are equivalent to parts per
			million.</span></p>

		<p><span style=
			"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
			<a id="3" name="3"></a><sup>3</sup> EPA's
			surface water treatment rules require
			systems using surface water or ground water
			under the direct influence of surface water
			to (1) disinfect their water, and (2)
			filter their water or meet criteria for
			avoiding filtration so that the following
			contaminants are controlled at the
			following levels:</span></p>

		<ul>
			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				Cryptosporidium (as of1/1/02 for
				systems serving &gt;10,000 and 1/14/05
				for systems serving</span></li>

			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				<em>Giardia lamblia:</em> 99.9%
				removal/inactivation</span></li>

			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				Viruses: 99.99%
				removal/inactivation</span></li>

			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				<em>Legionella:</em> No limit, but EPA
				believes that if <em>Giardia</em> and
				viruses are removed/inactivated,
				<em>Legionella</em> will also be
				controlled.</span></li>

			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				Turbidity: At no time can turbidity
				(cloudiness of water) go above 5
				nephelolometric turbidity units (NTU);
				systems that filter must ensure that
				the turbidity go no higher than 1 NTU
				(0.5 NTU for conventional or direct
				filtration) in at least 95% of the
				daily samples in any month. As of
				January 1, 2002, turbidity may never
				exceed 1 NTU, and must not exceed 0.3
				NTU in 95% of daily samples in any
				month.</span></li>

			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				HPC: No more than 500 bacterial
				colonies per milliliter.</span></li>

			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				Long Term 1 Enhanced Surface Water
				Treatment (Effective Date: January 14,
				2005); Surface water systems or (GWUDI)
				systems serving fewer than 10,000
				people must comply with the applicable
				Long Term 1 Enhanced Surface Water
				Treatment Rule provisions (e.g.
				turbidity standards, individual filter
				monitoring, Cryptosporidium removal
				requirements, updated watershed control
				requirements for unfiltered
				systems).</span></li>

			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				Filter Backwash Recycling; The Filter
				Backwash Recycling Rule requires
				systems that recycle to return specific
				recycle flows through all processes of
				the system's existing conventional or
				direct filtration system or at an
				alternate location approved by the
				state.<br></span></li>
		</ul>

		<p><span style=
			"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
			<a id="4" name="4"></a><sup>4</sup> more
			than 5.0% samples total coliform-positive
			in a month. (For water systems that collect
			fewer than 40 routine samples per month, no
			more than one sample can be total
			coliform-positive per month.) Every sample
			that has total coliform must be analyzed
			for either fecal coliforms or <em>E.
				coli</em> if two consecutive TC-positive
			samples, and one is also positive for
			<em>E.coli</em> fecal coliforms, system has
			an acute MCL violation.</span></p>

		<p><span style=
			"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
			<a id="5" name="5"></a><sup>5</sup> Fecal
			coliform and <em>E. coli</em> are bacteria
			whose presence indicates that the water may
			be contaminated with human or animal
			wastes. Disease-causing microbes
			(pathogens) in these wastes can cause
			diarrhea, cramps, nausea, headaches, or
			other symptoms. These pathogens may pose a
			special health risk for infants, young
			children, and people with severely
			compromised immune systems.</span></p>

		<p><span style=
			"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
			<a id="6" name="6"></a><sup>6</sup>
			Although there is no collective MCLG for
			this contaminant group, there are
			individual MCLGs for some of the individual
			contaminants:</span></p>

		<ul>
			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				Trihalomethanes: bromodichloromethane
				(zero); bromoform (zero);
				dibromochloromethane (0.06 mg/L).
				Chloroform is regulated with this group
				but has no MCLG.</span></li>

			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				Haloacetic acids: dichloroacetic acid
				(zero); trichloroacetic acid (0.3
				mg/L). Monochloroacetic acid,
				bromoacetic acid, and dibromoacetic
				acid are regulated with this group but
				have no MCLGs.</span></li>
		</ul>

		<p><span style=
			"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
			<a id="7" name="7"></a><sup>7</sup> MCLGs
			were not established before the 1986
			Amendments to the Safe Drinking Water Act.
			Therefore, there is no MCLG for this
			contaminant.</span></p>

		<p><span style=
			"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
			<a id="8" name="8"></a><sup>8</sup> Lead
			and copper are regulated by a Treatment
			Technique that requires systems to control
			the corrosiveness of their water. If more
			than 10% of tap water samples exceed the
			action level, water systems must take
			additional steps. For copper, the action
			level is 1.3 mg/L, and for lead is 0.015
			mg/L.</span></p>

		<p><span style=
			"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
			<a id="9" name="9"></a><sup>9</sup> Each
			water system must certify, in writing, to
			the state (using third-party or
			manufacturer's certification) that when
			acrylamide and epichlorohydrin are used in
			drinking water systems, the combination (or
			product) of dose and monomer level does not
			exceed the levels specified, as
			follows:</span></p>

		<ul>
			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				Acrylamide = 0.05% dosed at 1 mg/L (or
				equivalent)</span></li>

			<li><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
				Epichlorohydrin = 0.01% dosed at 20
				mg/L (or equivalent)</span></li>
		</ul>
		<hr style="text-align: center;" width=
		"95%">

		<h2><span style=
				"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: medium;">
				National Secondary Drinking Water
				Regulations</span></h2>

		<p><span style=
			"font-family: Verdana,Arial,Helvetica,sans-serif; font-size: small;">
			National Secondary Drinking Water
			Regulations (NSDWRs or secondary standards)
			are non-enforceable guidelines regulating
			contaminants that may cause cosmetic
			effects (such as skin or tooth
			discoloration) or aesthetic effects (such
			as taste, odor, or color) in drinking
			water. EPA recommends secondary standards
			to water systems but does not require
			systems to comply. However, states may
			choose to adopt them as enforceable
			standards.</span></p>

		<div style="text-align: center">
			<table class="price1" style=
				"width: 450px;">
				<tbody>
					<tr>
						<th class="price2" width=
							"42%">Contaminant</th>

						<th class="price2" valign=
							"middle" width="58%">
							<div style=
								"text-align: right">
								Secondary Standard
							</div>
						</th>
					</tr>

					<tr>
						<td class="price3">
							Aluminum</td>

						<td class="price3">
							<div style=
								"text-align: right">
								0.05 to 0.2 mg/L
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Chloride</td>

						<td class="price3">
							<div style=
								"text-align: right">
								250 mg/L
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Color</td>

						<td class="price3">
							<div style=
								"text-align: right">
								15 (color units)
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Copper</td>

						<td class="price3">
							<div style=
								"text-align: right">
								1.0 mg/L
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Corrosivity</td>

						<td class="price3">
							<div style=
								"text-align: right">
								noncorrosive
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Fluoride</td>

						<td class="price3">
							<div style=
								"text-align: right">
								2.0 mg/L
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">Foaming
							Agents</td>

						<td class="price3">
							<div style=
								"text-align: right">
								0.5 mg/L
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Iron</td>

						<td class="price3">
							<div style=
								"text-align: right">
								0.3 mg/L
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Manganese</td>

						<td class="price3">
							<div style=
								"text-align: right">
								0.05 mg/L
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Odor</td>

						<td class="price3">
							<div style=
								"text-align: right">
								3 threshold odor
								number
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">pH</td>

						<td class="price3">
							<div style=
								"text-align: right">
								6.5-8.5
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Silver</td>

						<td class="price3">
							<div style=
								"text-align: right">
								0.10 mg/L
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Sulfate</td>

						<td class="price3">
							<div style=
								"text-align: right">
								250 mg/L
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">Total
							Dissolved Solids</td>

						<td class="price3">
							<div style=
								"text-align: right">
								500 mg/L
							</div>
						</td>
					</tr>

					<tr>
						<td class="price3">
							Zinc</td>

						<td class="price3">
							<div style=
								"text-align: right">
								5 mg/L
							</div>
						</td>
					</tr>
				</tbody>
			</table><br>
		</div>

		<p><strong>Source</strong>: EPA
		816-F-02-013</p>
	</div>
	<div class="linebreak">
		<img src="{{skin url='images/media/separator.png'}}" alt=""/>
	</div>
</div>
<!--end of page-->
EOD;

	$root_template = 'two_columns_left';

	$title = 'Water Contaminants';

	$identifier = 'water-contaminants.html';

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





