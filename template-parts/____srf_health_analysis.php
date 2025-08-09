<?php

/**
 * template Name: 
 */
get_header();

/** ../css/srf.css file connected */
$srf_css = home_url('/').'wp-content/themes/veggie-lite-child/css/srf.css';
wp_enqueue_style('srf', $srf_css, array(), '2.0');

/** ../js/srf.js file connected */
$homeUrl = home_url('/').'wp-content/themes/veggie-lite-child/js/srf.js';
wp_enqueue_script( 'srf', $homeUrl, array(), '16.06');
?>
<!-- <link rel="stylesheet" href="<?php echo get_stylesheet_directory(); ?>/css/health-analysis.css" /> -->
 <style>
   .title {
  margin-bottom: 35px;
}
.form-group {
  margin-bottom: 25px;
  border-top: 1px solid #ddd;
  clear: both;
  padding-top: 15px;
}
.form-control, .inputs input[type="text"], .inputs input[type="email"] {
   display: inline-block; width: 100%;
   border:1px solid #666;
   padding: 5px 10px;
   -webkit-box-shadow: none;
}

.btn {
   box-shadow: 0 0 5px;
   border:1px solid #666;
   padding: 5px 10px;
}

@media screen and (min-width: 768px) {
  .form-group .inputs,
  .form-group label {
    width: 50%;
    float: left;
  }
}

 </style>
<div class="title">
  <h3>Find Out How Healthy You Are</h3>
</div>

<div class="question_answer">
  <div class="ethnic_info">
    <div class="form-group">
      <label for="">What is your name?</label>
      <div class="inputs">
         <input type="text" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label for="">Please provide your email address to receive Health Score to the email.</label>
      <div class="inputs">
         <input type="email" name="email" class="form-control" />
      </div>
    </div>
    <div class="form-group">
      <label for="">What is your age in years</label>
      <div class="inputs">
         <input type="number" name="age" placeholder="in years" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label for="">What is your gender</label>
      <div class="inputs">
         <input type="radio" name="gender" value="Male" /> Male 
         <input type="radio" name="gender" value="Female" /> Female
      </div>
    </div>
    <div class="form-group">
      <label for="">What is your zodiac sign (star sign)</label>
      <div class="inputs">
         <select id="choice11137" name="questionradio1137" class="form-control">
            <option value="-1">Select</option>
            <option value="18681">Aquarius</option>
            <option value="18682">Pisces</option>
            <option value="18683">Aries</option>
            <option value="18684">Taurus</option>
            <option value="18685">Gemini</option>
            <option value="18686">Cancer</option>
            <option value="18687">Leo</option>
            <option value="18688">Virgo</option>
            <option value="18689">Libra</option>
            <option value="18690">Scorpio</option>
            <option value="18691">Sagittarius</option>
            <option value="18692">Capricorn</option>
         </select>
      </div>
    </div>
    <div class="form-group">
      <label for="">Regarding your looks, are you</label>
      <div class="inputs">
         <input type="radio" name="looks" value="Extremely Good looking" /> Extremely Good looking <br>
         <input type="radio" name="looks" value="Good looking" /> Good looking <br>
         <input type="radio" name="looks" value="Average/Normal" /> Average/Normal <br>
         <input type="radio" name="looks" value="Below average" /> Below average
      </div>
      
    </div>
    <div class="form-group">
      <label for="">Where do you live?</label>
      <div class="inputs">
      <select id="choice11046" name="questionradio1046" class="form-control">  <option value="-1">Select</option><option value="6162">Afghanistan</option><option value="6163">Albania</option><option value="6164">Algeria</option><option value="6165">Andorra</option><option value="6166">Angola</option><option value="6168">Antigua and  Barbuda</option><option value="6169">Argentina</option><option value="6167">Anguilla</option><option value="6170">Armenia</option><option value="6171">Aruba</option><option value="6172">Australia</option><option value="6173">Austria</option><option value="6174">Azerbaijan</option><option value="6175">Bahamas</option><option value="6176">Bahrain</option><option value="6177">Bangladesh</option><option value="6178">Barbados</option><option value="6179">Belarus</option><option value="6180">Belgium</option><option value="6181">Belize</option><option value="6182">Benin</option><option value="6183">Bhutan</option><option value="6184">Bolivia</option><option value="6185">Bosnia &amp; Hercegovina</option><option value="6186">Botswana</option><option value="6187">Brazil</option><option value="6188">Brunei</option><option value="6189">Bulgaria</option><option value="6190">Burkina Faso</option><option value="6191">Burma
      </option><option value="6192">Burundi</option><option value="6193">Cambodia</option><option value="6194">Cameroon</option><option value="6195">Canada</option><option value="6196">Cape Verde</option><option value="6197">Central African Republic</option><option value="6198">Chad</option><option value="6199">Chile</option><option value="6200">China</option><option value="6201">Colombia</option><option value="6202">Comoros</option><option value="6203">Congo</option><option value="6204">Costa Rica</option><option value="6205">Cote Ivoire</option><option value="6206">Croatia</option><option value="6207">Cuba</option><option value="6208">Curacao</option><option value="6209">Cyprus</option><option value="6210">Czechia</option><option value="6211">Denmark</option><option value="6212">Djibouti</option><option value="6213">Dominica</option><option value="6214">Dominican Republic</option><option value="6215">East Timor</option><option value="6216">Ecuador</option><option value="6217">Egypt</option><option value="6218">El Salvador</option><option value="6219">Equatorial Guinea</option><option value="6220">Eritrea</option><option value="6221">Estonia</option><option value="6222">Eswatini</option><option value="6223">Ethiopia</option><option value="6224">Fiji</option><option value="6225">Finland</option><option value="6226">France</option><option value="6227">Gabon</option><option value="6228">Gambia</option><option value="6229">Georgia</option><option value="6230">Germany</option><option value="6231">Ghana</option><option value="6232">Greece</option><option value="6236">Grenada</option><option value="6233">Guatemala</option><option value="6234">Guinea</option><option value="6235">Guinea Bissau</option><option value="6237">Guyana</option><option value="6238">Haiti</option><option value="6239">Holy See</option><option value="6240">Honduras</option><option value="6241">Hong Kong</option><option value="6242">Hungary</option><option value="6243">Iceland</option><option value="6244">India</option><option value="6245">Indonesia</option><option value="6246">Iran</option><option value="6247">Iraq</option><option value="6248">Ireland</option><option value="6249">Israel</option><option value="6250">Italy</option><option value="6251">Jamaica</option><option value="6252">Japan</option><option value="6253">Jordan</option><option value="6254">Kazakhstan</option><option value="6255">Kenya</option><option value="6256">Kiribati</option><option value="6257">Korea, North</option><option value="6258">Korea, South</option><option value="6259">Kosovo</option><option value="6260">Kuwait</option><option value="6261">Kyrgyzstan</option><option value="6262">Laos</option><option value="6263">Latvia</option><option value="6264">Lebanon</option><option value="6265">Lesotho</option><option value="6266">Liberia</option><option value="6267">Libya</option><option value="6268">Liechtenstein</option><option value="6269">Lithuania</option><option value="6270">Luxembourg</option><option value="6271">Macau</option><option value="6272">Macedonia</option><option value="6273">Madagascar</option><option value="6274">Malawi</option><option value="6275">Malaysia</option><option value="6276">Maldives</option><option value="6277">Mali</option><option value="6278">Malta</option><option value="6279">Marshall Islands</option><option value="6280">Mauritania</option><option value="6281">Mauritius</option><option value="6282">Mexico</option><option value="6283">Micronesia</option><option value="6284">Moldova</option><option value="6285">Monaco</option><option value="6286">Mongolia</option><option value="6287">Montenegro</option><option value="6288">Morocco</option><option value="6289">Mozambique</option><option value="6290">Namibia</option><option value="6291">Nauru</option><option value="6292">Nepal</option><option value="6293">Netherlands</option><option value="6294">New Zealand</option><option value="6295">Nicaragua</option><option value="6296">Niger</option><option value="6297">Nigeria</option><option value="6298">North Korea</option><option value="6299">Norway</option><option value="6300">Oman</option><option value="6301">Pakistan</option><option value="6302">Palau</option><option value="6303">Palestinian Territories</option><option value="6304">Panama</option><option value="6305">Papua New Guinea</option><option value="6306">Paraguay</option><option value="6307">Peru</option><option value="6308">Philippines</option><option value="6309">Poland</option><option value="6310">Portugal</option><option value="6311">Qatar</option><option value="6312">Romania</option><option value="6313">Russia</option><option value="6314">Rwanda</option><option value="6315">Saint Kitts and Nevis</option><option value="6316">Saint Lucia</option><option value="6317">Saint Vincent and the Grenadines</option><option value="6318">Samoa</option><option value="6319">San Marino</option><option value="6320">Sao Tome and Principe</option><option value="6321">Saudi Arabia</option><option value="6322">Senegal</option><option value="6323">Serbia</option><option value="6324">Seychelles</option><option value="6325">Sierra Leone</option><option value="6326">Singapore</option><option value="6327">Sint Maarten</option><option value="6328">Slovakia</option><option value="6329">Slovenia</option><option value="6330">Solomon Islands</option><option value="6331">Somalia</option><option value="6332">South Africa</option><option value="6333">South Korea</option><option value="6334">South Sudan</option><option value="6335">Spain</option><option value="6336">Sri Lanka</option><option value="6337">Sudan</option><option value="6338">Suriname</option><option value="6339">Swaziland</option><option value="6340">Sweden</option><option value="6341">Switzerland</option><option value="6342">Syria</option><option value="6343">Taiwan</option><option value="6344">Tajikistan</option><option value="6345">Tanzania</option><option value="6346">Thailand</option><option value="6347">Timor Leste</option><option value="6348">Togo</option><option value="6349">Tonga</option><option value="6350">Trinidad and Tobago</option><option value="6351">Tunisia</option><option value="6352">Turkey</option><option value="6353">Turkmenistan</option><option value="6354">Tuvalu</option><option value="6355">Uganda</option><option value="6356">Ukraine</option><option value="6357">United Arab Emirates</option><option value="6358">United Kingdom</option><option value="6359">United States of America</option><option value="6360">Uruguay</option><option value="6361">Uzbekistan</option><option value="6362">Vanuatu</option><option value="6363">Venezuela</option><option value="6364">Vietnam</option><option value="6365">Yemen</option><option value="6366">Zambia</option><option value="6367">Zimbabwe</option></select>
      </div>
    </div>
    <div class="form-group">
      <label for="">What is your ethnicity</label>
      <div class="inputs">
         <input type="radio" name="ethnicity" value="Asian" /> Asian
         <input type="radio" name="ethnicity" value="Black" /> Black
         <input type="radio" name="ethnicity" value="White" /> White
         <input type="radio" name="ethnicity" value="Other" /> Other
      </div>      
    </div>
    <div class="form-group">
      <label for="">As part of your profession, do you mostly do</label>
      <div class="inputs">
         <input type="radio" name="profession" value="Indoors/Office work" /> Indoors/Office work <br>
         <input type="radio" name="profession" value="Outdoors/Field work" /> Outdoors/Field work <br>
         <input type="radio" name="profession" value="Home maker/Stay Home" /> Home maker/Stay Home <br>
         <input type="radio" name="profession" value="Other" /> Other
      </div>
    </div>
    <div class="form-group">
      <label for="">Have you been taking any traditional (allopathic) medicines regularly, if yes, for how many years</label>
      <div class="inputs">
         <input type="number" name="allopathic" class="form-control" />
      </div>
    </div>

    <!-- Health Score questions -->
         <div class="form-group">
            <label>What is your weight &amp; height</label>
            <div class="inputs">
               <input type="radio" name="questionradio1101" value="5942" onclick=""> Imperial Units (lbs &amp; ft) <br>
               <input type="radio" name="questionradio1101" value="17660" onclick=""> Metric Units (kgs &amp; cm)
               </div>
            </div>
         </div>
         <div class="form-group">
            <label>Lbs</label>
            <div class="inputs">
               <input type="number" name="" class="form-control" />
               </div>
            </div>
         </div>
         <div class="form-group">
            <label>Ft</label>
            <div class="inputs">
               <select id="choice11115" name="questionradio1115" class="form-control">
                  <option value="-1">Select</option>
                  <option value="18118">1</option>
                  <option value="18119">2</option>
                  <option value="18120">3</option>
                  <option value="18121">4</option>
                  <option value="18122">5</option>
                  <option value="18123">6</option>
                  <option value="18124">7</option>
                  <option value="18125">Don't know</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>Inches</label>
            <div class="inputs">
               <select id="choice11116" class="form-control" name="questionradio1116">
                  <option value="-1">Select</option>
                  <option value="18126">1</option>
                  <option value="18127">2</option>
                  <option value="18128">3</option>
                  <option value="18129">4</option>
                  <option value="18130">5</option>
                  <option value="18131">6</option>
                  <option value="18132">7</option>
                  <option value="18133">8</option>
                  <option value="18134">9</option>
                  <option value="18135">10</option>
                  <option value="18136">11</option>
                  <option value="18138">Don't know</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>Kgs</label>
            <div class="inputs">
               <input type="number" name="" class="form-control" />
            </div>
         </div>
         <div class="form-group">
            <label>Centimeters</label>
            <div class="inputs">
               <input type="number" name="" class="form-control" />
            </div>
         </div>
         <div class="form-group">
            <label>Based on your weight &amp; height, you BMI is <br>(BMI: Body Mass Index, good range is 22-25)</label>
            <div class="inputs">
               <input type="number" name="questioncomment1119" value="18290" onclick="" class="form-control">
            </div>
         </div>
         <div class="form-group">
            <label>What is your waist size in inches</label>
            <div class="inputs">
               <select  class="form-control" name="questionradio1095">
                  <option value="-1">Select</option>
                  <option value="6407">27 or less</option>
                  <option value="6408">28</option>
                  <option value="6409">29</option>
                  <option value="6410">30</option>
                  <option value="6411">31</option>
                  <option value="6412">32</option>
                  <option value="6413">33</option>
                  <option value="6414">34</option>
                  <option value="6415">35</option>
                  <option value="6416">36</option>
                  <option value="6417">37</option>
                  <option value="6418">38</option>
                  <option value="6419">39</option>
                  <option value="6420">40</option>
                  <option value="6421">Over 40</option>
                  <option value="6441">Don't know</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>What is your neck size in inches</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1096">
                  <option value="-1">Select</option>
                  <option value="6376">13 or less</option>
                  <option value="6377">14</option>
                  <option value="6378">15</option>
                  <option value="6379">16</option>
                  <option value="6380">17</option>
                  <option value="6381">Over 17</option>
                  <option value="6389">Don't know</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>How many days in a week do you do aerobic exercise e.g. walking, jogging, swimming etc.</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1097">
                  <option value="-1">Select</option>
                  <option value="6493">0</option>
                  <option value="6494">1</option>
                  <option value="6495">2</option>
                  <option value="6496">3</option>
                  <option value="6497">4</option>
                  <option value="6498">5</option>
                  <option value="6499">6</option>
                  <option value="6500">7</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>How long, in minutes, is each of your aerobic exercise session</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1098">
                  <option value="-1">Select</option>
                  <option value="6501">0</option>
                  <option value="6502">10</option>
                  <option value="6503">20</option>
                  <option value="6504">30</option>
                  <option value="6505">40</option>
                  <option value="6506">50</option>
                  <option value="6507">60</option>
                  <option value="6508">70</option>
                  <option value="6509">80</option>
                  <option value="6510">90</option>
                  <option value="6511">100</option>
                  <option value="6512">110</option>
                  <option value="6513">120</option>
                  <option value="6514">Over 120</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>How many days in a week do you do weight/strength training</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1099">
                  <option value="-1">Select</option>
                  <option value="6520">0</option>
                  <option value="6521">1</option>
                  <option value="6522">2</option>
                  <option value="6523">3</option>
                  <option value="6524">4</option>
                  <option value="6525">5</option>
                  <option value="6526">6</option>
                  <option value="6527">7</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>How long, in minutes, is each of your weight/strength exercise session</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1100">
                  <option value="-1">Select</option>
                  <option value="6528">0</option>
                  <option value="6529">10</option>
                  <option value="6530">20</option>
                  <option value="6531">30</option>
                  <option value="6532">40</option>
                  <option value="6533">50</option>
                  <option value="6534">60</option>
                  <option value="6535">70</option>
                  <option value="6536">80</option>
                  <option value="6537">90</option>
                  <option value="6538">100</option>
                  <option value="6539">110</option>
                  <option value="6540">120</option>
                  <option value="6541">Over 120</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>What is your diastolic (low side) blood pressure without taking any medicines</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1103">
                  <option value="-1">Select</option>
                  <option value="17515">Less than 60</option>
                  <option value="17516">60</option>
                  <option value="17517">65</option>
                  <option value="17518">70</option>
                  <option value="17519">75</option>
                  <option value="17520">80</option>
                  <option value="17521">85</option>
                  <option value="17522">90</option>
                  <option value="17523">95</option>
                  <option value="17524">100</option>
                  <option value="17525">105</option>
                  <option value="17526">More than 105</option>
                  <option value="17535">Don't know</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>What is your systolic (high side) blood pressure without taking any medicines</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1104" onclick="">
                  <option value="-1">Select</option>
                  <option value="17653">Less than 100</option>
                  <option value="17536">100</option>
                  <option value="17537">105</option>
                  <option value="17538">110</option>
                  <option value="17539">115</option>
                  <option value="17540">120</option>
                  <option value="17541">125</option>
                  <option value="17542">130</option>
                  <option value="17543">135</option>
                  <option value="17544">140</option>
                  <option value="17545">145</option>
                  <option value="17546">150</option>
                  <option value="17547">155</option>
                  <option value="17548">More than 155</option>
                  <option value="17577">Don't know</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>What is your resting heart rate without taking any medicines (while sittng, doing nothing for at least 15 minutes)</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1105" onclick="">
                  <option value="-1">Select</option>
                  <option value="17587">Below 60</option>
                  <option value="17579">61-65</option>
                  <option value="17580">66-70</option>
                  <option value="17581">71-75</option>
                  <option value="17582">76-79</option>
                  <option value="17583">80-84</option>
                  <option value="17584">85-89</option>
                  <option value="17585">Above 90</option>
                  <option value="17649">Don't know</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>What is your HbA1C (mmol/L), it gives your average blood sugar over 3 months</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1106" onclick="">
                  <option value="-1">Select</option>
                  <option value="17657">Less than 4.2</option>
                  <option value="17658">4.2-4.6</option>
                  <option value="17659">4.7-5.1</option>
                  <option value="17656">5.2-5.7</option>
                  <option value="17655">5.8-6.4</option>
                  <option value="17654">6.5-8.9</option>
                  <option value="5939">Over 9</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>How many allopathic medicines do you take daily</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1109" onclick="">
                  <option value="-1">Select</option>
                  <option value="18406">None</option>
                  <option value="17499">1</option>
                  <option value="17500">2</option>
                  <option value="17501">3</option>
                  <option value="17502">4</option>
                  <option value="17503">5</option>
                  <option value="17504">More than 5</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>What illness have you been taking these medicines for</label>
            <div class="inputs">
               <input type="checkbox" name="questioncheckbox1108[]" value="5946" onclick=""> Diabetes<br>
               <input type="checkbox" name="questioncheckbox1108[]" value="5947" onclick=""> Hypertension <br>
               <input type="checkbox" name="questioncheckbox1108[]" value="18405" onclick=""> No illness <br>
               <input type="checkbox" name="questioncheckbox1108[]" value="5949" onclick=""> Other <br>
               <input type="checkbox" name="questioncheckbox1108[]" value="5948" onclick=""> Thyroid
            </div>
         </div>
         <div class="form-group">
            <label>Approximately, how many hours do you sleep everyday including naps/siesta</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1120" onclick="">
                  <option value="-1">Select</option>
                  <option value="18396">4-5</option>
                  <option value="18397">5-6</option>
                  <option value="18398">6-7</option>
                  <option value="18399">7-8</option>
                  <option value="18395">Less than 4</option>
                  <option value="18400">More than 8</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>What does your tongue look like <br>(select strongest options only, not more than 3)</label>
            <div class="inputs">
               <select class="form-control" name="questionradio880" onclick="">
                  <option value="-1">Select</option>
                  <option value="4409">Dirty white</option>
                  <option value="4410">Dirty yellow</option>
                  <option value="4411">Gray all over</option>
                  <option value="4412">Thick yellow-white</option>
                  <option value="4413">White all over</option>
                  <option value="4414">White in center</option>
                  <option value="4415">White patches</option>
                  <option value="4416">Yellow all over</option>
                  <option value="4417">Yellow at base</option>
                  <option value="4418">Yellow at center</option>
                  <option value="5631">Mapped</option>
                  <option value="4419">Other</option>
                  <option value="5444">Healthy no coating</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>Do your teeth have any of these issues<br>(select strongest options only, not more than 3)</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1035" onclick="">
                  <option value="-1">Select</option>
                  <option value="5294">Abscess of roots</option>
                  <option value="5295">Damaged enamel</option>
                  <option value="5296">Decay</option>
                  <option value="5297">Looseness</option>
                  <option value="5299">Sensitive to air</option>
                  <option value="5300">Sensitive to cold water</option>
                  <option value="5301">Sleep grinding</option>
                  <option value="5302">Yellow tint</option>
                  <option value="5389">Other</option>
                  <option value="5632">No issues</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label>What portion of your daily food is uncooked, fresh vegetables &amp; fruits</label>
            <div class="inputs">
               <select class="form-control" name="questionradio1121" onclick="">
                  <option value="-1">Select</option>
                  <option value="18402">1/4 to 2/4</option>
                  <option value="18403">2/4 to 3/4</option>
                  <option value="18401">Less than 1/4</option>
                  <option value="18404">More than 3/4</option>
               </select>
            </div>
         </div>
         
      <div class="form-group">
         <button class="btn">Next</button>
      </div>
   </div>
</div> 

 <?php get_footer(); ?>