<style>
label{margin-top:15px;padding-right: 15px;}
.error{color:red;}
.form-check{padding-left:5px;padding-right:5px;}
.hidden{display:none;}
.has-error .invalid-feedback{
  display:block;
  font-size:16px;
}
.has-error .form-control{
border: 1px solid red;
}
@media(max-width:767px){
	.radio-inline{
  font-size:14px;
  font-weight: 600;
}
.error{font-size:10px;line-height:1.2;}
}
.card-title{
padding: 15px;
    text-align: center;}
.div-header{border-bottom: 1px solid var(--vz-border-color);margin-top:10px;}

</style>
	<div class="row">
		<div class="col-12 div-header border-bottom-dashed" style="padding-bottom: 15px;"> 
			<div class="row">
				
				<div class="col-6 listradio form-group chronic_disease">
					<label for="slug">{{ 'तपाईलाई नसर्ने तथा दीर्घरोग सम्बन्धि समस्या छ ?' }}</label><br>
								
						<label for="chronic_disease1" class="radio-inline">
							<input class="form-check-input" type="radio" name="chronic_disease" id="chronic_disease1" value="1" {{ old('chronic_disease') == 1 ? 'checked' : '' }} >
							{{ 'छ' }}
						</label>
						
						<label for="chronic_disease2" class="radio-inline">
							<input class="form-check-input" type="radio" name="chronic_disease" id="chronic_disease2" value="2" {{ old('chronic_disease') == 2 ? 'checked' : '' }}> 
							{{ 'छैन ' }}
						</label>
					@if($errors->has('chronic_disease'))
						<div class="invalid-feedback">
							{{ $errors->first('chronic_disease') }}
						</div>
					@endif
				</div>
				<div class="col-6 form-group form-check chronic_disease_name">
					<label for="chronic_disease_name">{{'कुन नसर्ने अथवा दीर्घरोग छ ?' }}</label>
					<!--<select id="chronic_disease_name" name="chronic_disease_name" class="form-control form-select">-->
					<select class="form-select " name="chronic_disease_name[]" multiple="multiple">
						<option value="">{{'चयन गर्नुहोस्'}}</option>				
						<option value='उच्च रक्तचाप '>उच्च रक्तचाप</option>
						<option value="मधुमेह">मधुमेह</option>
						<option value="दम रोग,हाडजोर्नी तथा मांसापेशी दुखाई">दम रोग,हाडजोर्नी तथा मांसापेशी दुखाई</option>
						<option value="ग्याँस्टिक">ग्याँस्टिक</option>
						<option value="आँखा सम्बन्धि समस्या">आँखा सम्बन्धि समस्या</option>
						<option value="कान सम्बन्धि समस्या">कान सम्बन्धि समस्या</option>
						<option value="मुख सम्बन्धि स्वास्थ्य समस्या">मुख सम्बन्धि स्वास्थ्य समस्या</option>
						<option value="अपाङ्गतां">अपाङ्गतां</option>
					</select>
					@if($errors->has('year_rented'))
						<div class="invalid-feedback" style="display:block;">
							{{ $errors->first(year_rented) }}
						</div>
					@endif
				</div>
				
				
				
				<div class="col-6 form-group form-check mtreatment_at">
					<label for="mtreatment_at">{{ 'विरामी हुँदा उपचार स्थान' }}<span style="color:red;">*</span></label>
					<select id="mtreatment_at" name="mtreatment_at" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="सरकारी अस्पताल ">सरकारी अस्पताल </option>
						<option value="निजि अस्पताल">निजि अस्पताल</option>
						<option value="निजि क्लिनिक">निजि क्लिनिक</option>
						<option value="नजिकैको मेडिकल ,फार्मेसी ">नजिकैको मेडिकल ,फार्मेसी </option>
						<option value="आधारभूत स्वास्थ्य केन्द्र">आधारभूत स्वास्थ्य केन्द्र</option>
					</select>
					@if($errors->has('mtreatment_at'))
						<div class="invalid-feedback" style="display:block;">
							{{ $errors->first('mtreatment_at') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check rnot_chosing_ward">
					<label for="rnot_chosing_ward">{{'वडा स्थित आधारभूत स्वास्थ्य केन्द्रमा नजानुको कारण के हो ?' }}</label>
					<select id="rnot_chosing_ward" name="rnot_chosing_ward" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="सेवा बारेमा थाहा नभएर">सेवा बारेमा थाहा नभएर</option>
						<option value="सेवा प्रति विश्वास नभएर ">सेवा प्रति विश्वास नभएर </option>
						<option value="अन्य">अन्य</option>
					</select>
					@if($errors->has('rnot_chosing_ward'))
						<div class="invalid-feedback" style="display:block;">
							{{ $errors->first('rnot_chosing_ward') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group medical_insured {{ $errors->has('medical_insured') ? 'has-error' : '' }}">
					<label for="slug">{{'स्वास्थ्य विमा गर्नु भएको छ ?' }}<span style="color:red;">*</span></label><br>
								
					<label for="medical_insured1" class="radio-inline">
						<input class="form-check-input" type="radio" name="medical_insured" id="medical_insured1" value="1" {{ old('medical_insured') == 1 ? 'checked' : '' }} >
						{{ 'छ' }}
					</label>
					
					<label for="medical_insured2" class="radio-inline">
						<input class="form-check-input" type="radio" name="medical_insured" id="medical_insured2" value="2" {{ old('medical_insured') == 2 ? 'checked' : '' }}> 
						{{ 'छैन ' }}
					</label>
					@if($errors->has('medical_insured'))
						<div class="invalid-feedback">
							{{ $errors->first('medical_insured') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group smoking_duration">
					<label for="insured_at">{{'स्वास्थ्य विमा कहाँ गर्नु भएको छ ?' }}</label>
					<select id="insured_at" name="insured_at" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="स्वास्थ्य विमा कार्यक्रम (सरकारी)">स्वास्थ्य विमा कार्यक्रम (सरकारी)</option>
						<option value="निजी विमा कम्पनी">निजी विमा कम्पनी</option>
					</select>
					@if($errors->has('insured_at'))
						<div class="invalid-feedback" style="display:block;">
							{{ $errors->first('insured_at') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check body_mass_index">
					<label for="body_mass_index">{{'बडी मास इन्डेक्स कस्तो रहेको छ ? (तौल र उचाईको हिसाब गरेर भर्ने)' }}</label>
					<select id="body_mass_index" name="body_mass_index" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="समान्य भन्दा कम ( १८.५ भन्दा कम)">समान्य भन्दा कम ( १८.५ भन्दा कम)</option>
						<option value="समान्य  ( १८ं.५ देखि २४.९९ सम्म)">समान्य  ( १८ं.५ देखि २४.९९ सम्म)</option>
						<option value="बढी तौल ( २५ देखि २९.९९)">बढी तौल ( २५ देखि २९.९९)</option>
						<option value="भद्या तौल ( ३० भन्दा बढी )">भद्या तौल ( ३० भन्दा बढी )</option>
					</select>
					@if($errors->has('body_mass_index'))
						<div class="invalid-body_mass_index" style="display:block;">
							{{ $errors->first('body_mass_index') }}
						</div>
					@endif
				</div>
			</div>
			
		</div>	
		
		<div class="col-12 div-header under_five_child border-bottom-dashed" style="padding-bottom: 15px;"> 
			<div class="row">
				<h5 class="card-title mb-0">मातृ तथा नवजात शिशु  </h5> 
				<div class="col-6 form-group">
					<label for="full_child_vaccinate">{{'बच्चालाई पूर्ण खोप लगाउनुभयो ?' }}</label>
					<select id="full_child_vaccinate" name="full_child_vaccinate" class="form-control form-select" >
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="अहिले सम्म कुनै खोप नलगाएको">अहिले सम्म कुनै खोप नलगाएको</option>
						<option value="लगाइरहेको">लगाइरहेको</option>
						<option value="पूर्ण खोप लगाएको">पूर्ण खोप लगाएको</option>
						<option value="खोप छुटेको">खोप छुटेको</option>
					</select>
					@if($errors->has('full_child_vaccinate'))
						<div class="invalid-full_child_vaccinate" style="display:block;">
							{{ $errors->first('full_child_vaccinate') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check missing_vaccine">
					<label for="missing_vaccine">{{'छुटेको खोप' }}</label>
					<input id="missing_vaccine" name="missing_vaccine" type="text" class="form-control" />
					@if($errors->has('missing_vaccine'))
						<div class="invalid-missing_vaccine" style="display:block;">
							{{ $errors->first('missing_vaccine') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group {{ $errors->has('mum_breast_fed') ? 'has-error' : '' }}">
					<label for="slug">{{'के बच्चालाई आमाको दुध खुवाउनु भयो ?' }}</label><br>
								
					<label for="mum_breast_fed1" class="radio-inline">
						<input class="form-check-input" type="radio" name="mum_breast_fed" id="mum_breast_fed1" value="1" {{ old('mum_breast_fed') == 1 ? 'checked' : '' }}>
						{{ 'खुवाए' }}
					</label>
					
					<label for="mum_breast_fed2" class="radio-inline">
						<input class="form-check-input" type="radio" name="mum_breast_fed" id="mum_breast_fed2" value="2" {{ old('mum_breast_fed') == 2 ? 'checked' : '' }}> 
						{{ 'खुवाएन ' }}
					</label>
					@if($errors->has('mum_breast_fed'))
						<div class="invalid-feedback">
							{{ $errors->first('mum_breast_fed') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check breast_unfed">
					<label for="breast_unfed">{{'किन खुवाउनु भएन ?' }}</label>
					<select id="breast_unfed" name="breast_unfed" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="दुध नआएर">दुध नआएर</option>
						<option value="कामले फुर्सद नपाएर">कामले फुर्सद नपाएर</option>
						<option value="अन्य">अन्य</option>
					</select>
					@if($errors->has('breast_unfed'))
						<div class="invalid-breast_unfed" style="display:block;">
							{{ $errors->first('breast_unfed') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check breast_fed_duration">
					<label for="breast_fed_duration">{{'बच्चालाई आमाको दुध कुन उमेर सम्म खुवाउनु भयो ?' }}</label>
					<select id="breast_fed_duration" name="breast_fed_duration" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="६ महिना सम्म">६ महिना सम्म</option>
						<option value="६ महिना देखि १ वर्षसम्म">६ महिना देखि १ वर्षसम्म</option>
						<option value="१ वर्षदेखि २ वर्षसम्म">१ वर्षदेखि २ वर्षसम्म</option>
						<option value="२ वर्षभन्दा बढी सम्म">२ वर्षभन्दा बढी सम्म</option>
					</select>
					@if($errors->has('breast_fed_duration'))
						<div class="invalid-breast_fed_duration" style="display:block;">
							{{ $errors->first('breast_fed_duration') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check additional_food">
					<label for="additional_food">{{'बच्चा कति महिनाको भएपछि आमाको दुधको अलावा थप खाना खुवाउनु भयो ?' }}</label>
					<input id="additional_food" name="additional_food" type="number" class="form-control" />
					@if($errors->has('additional_food'))
						<div class="invalid-additional_food" style="display:block;">
							{{ $errors->first('additional_food') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group {{ $errors->has('baby_wt_monitor') ? 'has-error' : '' }}">
					<label for="slug">{{' बच्चाको वजन वृद्धि अनुगमन गराउनु भयो ?' }}*</label><br>
								
					<label for="baby_wt_monitor1" class="radio-inline">
						<input class="form-check-input" type="radio" name="baby_wt_monitor" id="baby_wt_monitor1" value="1" {{ old('baby_wt_monitor') == 1 ? 'checked' : '' }} >
						{{ 'गराए' }}
					</label>
					
					<label for="baby_wt_monitor2" class="radio-inline">
						<input class="form-check-input" type="radio" name="baby_wt_monitor" id="baby_wt_monitor2" value="2" {{ old('baby_wt_monitor') == 2 ? 'checked' : '' }}> 
						{{ 'गराएन' }}
					</label>
					@if($errors->has('baby_wt_monitor'))
						<div class="invalid-feedback">
							{{ $errors->first('baby_wt_monitor') }}
						</div>
					@endif
				</div>

				<div class="col-6 form-group form-check baby_wt_monitor_time">
					<label for="baby_wt_monitor_time">{{'कति पटक बच्चाको वजन अनुगमन गराउनु भयो?' }}</label>
					<input id="baby_wt_monitor_time" name="baby_wt_monitor_time" type="number" class="form-control" />
					@if($errors->has('additional_food'))
						<div class="invalid-baby_wt_monitor_time" style="display:block;">
							{{ $errors->first('baby_wt_monitor_time') }}
						</div>
					@endif
				</div>	

				<div class="col-6 listradio form-group {{ $errors->has('pregnant_exists') ? 'has-error' : '' }}">
					<label for="pregnant_exists">{{'तपाईंको घरमा गर्भवती तथा ४५ दिन भित्रको सुत्केरी हुनुहुन्छ?' }}</label><br>
								
					<label for="pregnant_exists1" class="radio-inline">
						<input class="form-check-input" type="radio" name="pregnant_exists" value="1" {{ old('pregnancy_test') == 1 ? 'checked' : '' }} >
						{{ 'छ' }}
					</label>
					
					<label for="pregnant_exists2" class="radio-inline">
						<input class="form-check-input" type="radio" name="pregnant_exists" value="2" {{ old('pregnancy_test') == 2 ? 'checked' : '' }}> 
						{{ 'छैन ' }}
					</label>
					@if($errors->has('pregnant_exists'))
						<div class="invalid-feedback">
							{{ $errors->first('pregnant_exists') }}
						</div>
					@endif
				</div>	
				
				<div class="col-6 form-group form-check last_period_date">
					<label for="last_period_date">{{'अन्तिम महिनवरी मिती' }}</label>
					<input id="last_period_date" name="last_period_date" type="text" class="form-control" placeholder="2080-04-15" />
					@if($errors->has('last_period_date'))
						<div class="invalid-last_period_date" style="display:block;">
							{{ $errors->first('last_period_date') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group {{ $errors->has('pregnancy_test') ? 'has-error' : '' }}">
					<label for="slug">{{'तपाईँ गर्भवती हुँदा गर्भजाँच गराउनु भयो ?' }}</label><br>
								
					<label for="pregnancy_test1" class="radio-inline">
						<input class="form-check-input" type="radio" name="pregnancy_test" id="pregnancy_test1" value="1" {{ old('pregnancy_test') == 1 ? 'checked' : '' }} >
						{{ 'गराएँ' }}
					</label>
					
					<label for="pregnancy_test2" class="radio-inline">
						<input class="form-check-input" type="radio" name="pregnancy_test" id="pregnancy_test2" value="2" {{ old('pregnancy_test') == 2 ? 'checked' : '' }}> 
						{{ 'गराएन ' }}
					</label>
					@if($errors->has('pregnancy_test'))
						<div class="invalid-feedback">
							{{ $errors->first('pregnancy_test') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check pregnancy_test_times">
					<label for="pregnancy_test_times">{{'गर्भजाँच कती पटक गर्नुभयो ?' }}</label>
					<input id="pregnancy_test_times" name="pregnancy_test_times" type="number" class="form-control" />
					@if($errors->has('pregnancy_test_times'))
						<div class="invalid-pregnancy_test_times" style="display:block;">
							{{ $errors->first('pregnancy_test_times') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check why_pregnancytest_notdone">
					<label for="why_pregnancytest_notdone">{{'किन गर्भजाँच गराउनु भएन ?' }}</label>
					<select id="why_pregnancytest_notdone" name="why_pregnancytest_notdone" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="आवश्यक नभएर">आवश्यक नभएर</option>
						<option value="गर्भजाँचको महत्व बारेमा जानकारी नभएर">गर्भजाँचको महत्व बारेमा जानकारी नभएर</option>
					</select>
					@if($errors->has('why_pregnancytest_notdone'))
						<div class="invalid-why_pregnancytest_notdone" style="display:block;">
							{{ $errors->first('why_pregnancytest_notdone') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group {{ $errors->has('iron_pill_intake') ? 'has-error' : '' }}">
					<label for="slug">{{'तपाईँ गर्भवती हुँदा आइरन चक्की, जुकाको औषधी खानुभयो ?' }}</label><br>
								
					<label for="iron_pill_intake1" class="radio-inline">
						<input class="form-check-input" type="radio" name="iron_pill_intake" id="iron_pill_intake1" value="1" {{ old('iron_pill_intake') == 1 ? 'checked' : '' }}>
						{{ 'खाएँ' }}
					</label>
					
					<label for="iron_pill_intake2" class="radio-inline">
						<input class="form-check-input" type="radio" name="iron_pill_intake" id="iron_pill_intake2" value="2" {{ old('iron_pill_intake') == 2 ? 'checked' : '' }}> 
						{{ 'खाएन ' }}
					</label>
					@if($errors->has('iron_pill_intake'))
						<div class="invalid-feedback">
							{{ $errors->first('iron_pill_intake') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group one80_iron_pill{{ $errors->has('one80_iron_pill') ? 'has-error' : '' }}">
					<label for="slug">{{'तपाईँ गर्भवती हुँदा १८० चक्की आइरन खानुभयो ?' }}</label><br>
								
					<label for="one80_iron_pill1" class="radio-inline">
						<input class="form-check-input" type="radio" name="one80_iron_pill" id="one80_iron_pill1" value="1" {{ old('one80_iron_pill') == 1 ? 'checked' : '' }}>
						{{ 'खाएँ' }}
					</label>
					
					<label for="one80_iron_pill2" class="radio-inline">
						<input class="form-check-input" type="radio" name="one80_iron_pill" id="one80_iron_pill2" value="2" {{ old('one80_iron_pill') == 2 ? 'checked' : '' }}> 
						{{ 'खाएन ' }}
					</label>
					@if($errors->has('one80_iron_pill'))
						<div class="invalid-feedback">
							{{ $errors->first('one80_iron_pill') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group {{ $errors->has('pregnancy_risk') ? 'has-error' : '' }}">
					<label for="slug">{{'गर्भावस्थामा हुने खतराको लक्षण बारेमा थाहा छ ?' }}</label><br>
								
					<label for="pregnancy_risk1" class="radio-inline">
						<input class="form-check-input" type="radio" name="pregnancy_risk" id="pregnancy_risk1" value="1" {{ old('pregnancy_risk') == 1 ? 'checked' : '' }} >
						{{ 'छ' }}
					</label>
					
					<label for="pregnancy_risk2" class="radio-inline">
						<input class="form-check-input" type="radio" name="pregnancy_risk" id="pregnancy_risk2" value="2" {{ old('pregnancy_risk') == 2 ? 'checked' : '' }}> 
						{{ 'छैन ' }}
					</label>
					@if($errors->has('pregnancy_risk'))
						<div class="invalid-feedback">
							{{ $errors->first('pregnancy_risk') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check pregnancy_danger_sign">
					<label for="pregnancy_danger_sign">{{'गर्भावस्थामा हुने खतराको लक्षण के हुन ?' }}</label>
					<select id="pregnancy_danger_sign" name="pregnancy_danger_sign" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="टाउको दुख्ने">टाउको दुख्ने</option>
						<option value="हात खुट्टा सुनिने,जिउ अररो हुने">हात खुट्टा सुनिने,जिउ अररो हुने</option>
						<option value="योनीबाट रगत बग्ने">योनीबाट रगत बग्ने</option>
						<option value="वान्ता हुने">वान्ता हुने</option>
						<option value="अन्य">अन्य</option>
					</select>
					@if($errors->has('pregnancy_danger_sign'))
						<div class="invalid-pregnancy_danger_sign" style="display:block;">
							{{ $errors->first('pregnancy_danger_sign') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group {{ $errors->has('maternity_test') ? 'has-error' : '' }}">
					<label for="slug">{{'सुत्केरी अवस्थामा सुत्केरी जाँच गराउनु भयो ?' }}</label><br>
								
					<label for="maternity_test1" class="radio-inline">
						<input class="form-check-input" type="radio" name="maternity_test" id="maternity_test1" value="1" {{ old('maternity_test') == 1 ? 'checked' : '' }} >
						{{ 'गराए' }}
					</label>
					
					<label for="maternity_test2" class="radio-inline">
						<input class="form-check-input" type="radio" name="maternity_test" id="maternity_test2" value="2" {{ old('maternity_test') == 2 ? 'checked' : '' }}> 
						{{ 'गराएन ' }}
					</label>
					@if($errors->has('maternity_test'))
						<div class="invalid-feedback">
							{{ $errors->first('maternity_test') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check maternity_test_count">
					<label for="maternity_test_count">{{'सुत्केरी जाँच कती पटक गर्नुभयो ?' }}</label>
					<input id="maternity_test_count" name="maternity_test_count" type="number" class="form-control" />
					@if($errors->has('maternity_test_count'))
						<div class="invalid-maternity_test_count" style="display:block;">
							{{ $errors->first('maternity_test_count') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group {{ $errors->has('maternity_iron_pill') ? 'has-error' : '' }}">
					<label for="slug">{{'सुत्केरी भएको ४५ दिनभित्र आइरन चक्की खानु भयो?' }}</label><br>
								
					<label for="maternity_iron_pill1" class="radio-inline">
						<input class="form-check-input" type="radio" name="maternity_iron_pill" id="maternity_iron_pill1" value="1" {{ old('maternity_iron_pill') == 1 ? 'checked' : '' }} >
						{{ 'खाए' }}
					</label>
					
					<label for="maternity_iron_pill2" class="radio-inline">
						<input class="form-check-input" type="radio" name="maternity_iron_pill" id="maternity_iron_pill2" value="2" {{ old('maternity_iron_pill') == 2 ? 'checked' : '' }}> 
						{{ 'खाएन ' }}
					</label>
					@if($errors->has('maternity_iron_pill'))
						<div class="invalid-feedback">
							{{ $errors->first('maternity_iron_pill') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group {{ $errors->has('maternity_issues') ? 'has-error' : '' }}">
					<label for="slug">{{'सुत्केरी अवस्थामा तपाईलाई कुनै समस्या भयो ?' }}</label><br>
								
					<label for="maternity_issues1" class="radio-inline">
						<input class="form-check-input" type="radio" name="maternity_issues" id="maternity_issues1" value="1" {{ old('maternity_issues') == 1 ? 'checked' : '' }} >
						{{ 'भयो' }}
					</label>
					
					<label for="maternity_issues2" class="radio-inline">
						<input class="form-check-input" type="radio" name="maternity_issues" id="maternity_issues2" value="2" {{ old('maternity_issues') == 2 ? 'checked' : '' }}> 
						{{ 'भएन ' }}
					</label>
					@if($errors->has('maternity_issues'))
						<div class="invalid-feedback">
							{{ $errors->first('maternity_issues') }}
						</div>
					@endif
				</div>
				
				
			</div>
		</div>

		<div class="col-12 div-header elderly border-bottom-dashed" style="padding-bottom: 15px;">
			<div class="row">
				<div class="col-10" style="padding-bottom:15px;font-size:16px;font-weight:500;">
					<span>थप ज्येष्ठ नागरिक दाटा थप्नको लागि, कृपया 'थप्नुहोस्' बटनमा क्लिक गर्नुहोस्।</span>
				</div>

				<div class="col-2 add-less-button" style="margin-bottom:15px;text-align:right;">
					<a href="javascript:;" id="add-more" class="btn btn-soft-success" type="button"><i class="ri-add-circle-line align-middle me-1"></i> थप्नुहोस्</a> 

				</div>
				<div class="col-12">
					<div id="clone-container"> 
						<div class="clone-item employee-info-wrap">
							<div class="row">
								<div class="col-6">
									<label class="form-label" for="citizenship">{{'ज्येष्ठ नागरिकको नाम'}} </label>
									<select class="form-control form-select elderly_list" onchange="addCitizenship($(this))">
										<option value="0">Not Available</option>
									</select>
								</div>
								<div class="col-6">
									<label class="form-label" for="citizenship">{{'नागरिकता नम्बर'}} </label>
									<div class="form-icon">
										<input type="text" class="form-control form-control-icon elder_citizenship" onchange="checkMember($(this))" value="{{old('citizenship')}}" name="elder[][member][citizenship]" />
										<i class="ri-contacts-book-2-line"></i>
									</div>
									<div class="invalid-citizenship">
										
									</div>
								</div>
								<input type="hidden" class="elderly_id" name="elderly_id[]">
								<div class="col-6 form-group full_name">
									<label class="form-label" for="full_name">{{'पुरा नाम'}}  </label>
									<input type="text" class="form-control" name="elder[][member][full_name]" value="{{old('full_name')}}" />
								</div>
								<div class="col-6 form-group dob">
									<label class="form-label" for="dob_bs">{{'जन्म मिति'}}  <span style="color: red">*</span></label>
									<div class="form-icon">
										<input type="text" class="form-control form-control-icon" placeholder="1985-12-21" value="{{old('dob_bs')}}" name="elder[][member][dob_bs]" />
										<i class="bx bx-calendar"></i>
									</div>
								</div>
								<div class="col-6 form-group gender">
									<label class="form-label" for="gender">{{ 'लिङ्ग' }} <span style="color: red">*</span></label>
									<div class="form-icon">
										<select name="elder[][member][gender]" class="form-select form-control-icon">
											<option value="9">{{"लिङ्ग चयन गर्नुहोस्"}}</option>
											<option value="1" {{old("gender")==1 ? "selected" : ""}}>{{"पुरुष"}}</option>
											<option value="2" {{old("gender")==2 ? "selected" : ""}}>{{"महिला"}}</option>
											<option value="3" {{old("gender")==3 ? "selected" : ""}}>{{"अन्य"}}</option>
										</select>
										<i class="bx bx-male-female"></i>
									</div>
								</div>
								<div class="col-6 form-group mobile">
									<label for="mobile" class="form-label"> {{ 'मोबाइल' }} <span style="color: red">*</span></label>
									<div class="form-icon">
										<input type="text" name="elder[][member][mobile]" maxlength="10" class="form-control form-control-icon" value="{{ old('mobile_no') }}">
										<i class="ri-cellphone-fill"></i>
									</div>
								</div>
								
								<div class="col-6 form-group blood-grp">
									<label class="form-label" for="blood_group">{{ 'रक्त समूह' }} <span style="color: red">*</span></label>
									<div class="form-icon">
										<select name="elder[][member][blood_group]" class="form-select form-control-icon">
											<option value="">{{"रक्त समूह चयन गर्नुहोस्"}}</option>
											<option value="A+" {{old('blood_grp')=='A+' ? 'selected' : ''}}>A+</option>
											<option value="A-" {{old('blood_grp')=='A-' ? 'selected' : ''}}>A-</option>
											<option value="B+" {{old('blood_grp')=='B+' ? 'selected' : ''}}>B+</option>
											<option value="B-" {{old('blood_grp')=='B-' ? 'selected' : ''}}>B-</option>
											<option value="O+" {{old('blood_grp')=='O+' ? 'selected' : ''}}>O+</option>
											<option value="O-" {{old('blood_grp')=='O-' ? 'selected' : ''}}>O-</option>
											<option value="AB+" {{old('blood_grp')=='AB+' ? 'selected' : ''}}>AB+</option>
											<option value="AB-" {{old('blood_grp')=='AB-' ? 'selected' : ''}}>AB-</option>
											<option value="Unknown" {{old('blood_grp')=='Unknown' ? 'selected' : ''}}>Unknown</option>
										</select>
										<i class="ri-contrast-drop-2-line"></i>
									</div>
								</div>
								<div class="col-6 listradio form-group {{ $errors->has('pneumonia_vaccinated') ? 'has-error' : '' }}">
									<label for="slug">{{'के तपाईले निमोनियाको खोप लगाउनु भयो ?' }}</label><br>
												
									<label for="pneumonia_vaccinated_0" class="radio-inline">
										<input id="pneumonia_vaccinated_0" class="form-check-input pneumonia_vaccinated" type="radio" name="elder[][pneumonia_vaccinated]" value="1" >
										{{ 'छ' }}
									</label>
									
									<label for="pneumonia_vaccinated_0" class="radio-inline">
										<input id="pneumonia_vaccinated_0" class="form-check-input pneumonia_vaccinated" type="radio" name="elder[][pneumonia_vaccinated]" value="2" > 
										{{ 'छैन ' }}
									</label>
									@if($errors->has('pneumonia_vaccinated'))
										<div class="invalid-feedback">
											{{ $errors->first('pneumonia_vaccinated') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 form-group pneumonia_vacciated_counts">
									<label for="pneumonia_vacciated_count">{{'न्युमोनियाको खोप कति पटक लगाउनु भयो?' }}</label>
									<input id="pneumonia_vacciated_count" name="elder[]pneumonia_vacciated_count" type="number" class="form-control" />
									@if($errors->has('pneumonia_vacciated_count'))
										<div class="invalid-pneumonia_vacciated_count" style="display:block;">
											{{ $errors->first('pneumonia_vacciated_count') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 listradio form-group {{ $errors->has('respiratory_disease') ? 'has-error' : '' }}">
									<label for="slug">{{'स्वास प्रश्वास सम्बन्धि रोग जस्तै न्युमोनिया ,दम सम्बन्धि समस्या रहेको छ ?' }}</label><br>
												
									<label for="respiratory_disease1" class="radio-inline">
										<input class="form-check-input respiratory_disease" type="radio" name="elder[][respiratory_disease]" value="1"  >
										{{ 'छ' }}
									</label>
									
									<label for="respiratory_disease2" class="radio-inline">
										<input class="form-check-input respiratory_disease" type="radio" name="elder[][respiratory_disease]" value="2" > 
										{{ 'छैन ' }}
									</label>
									@if($errors->has('respiratory_disease'))
										<div class="invalid-feedback">
											{{ $errors->first('respiratory_disease') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 listradio form-group respiratory_medications">
									<label for="slug">{{'नियमित औषधि सेवन गरिरहनु भएको छ ?' }}</label><br>
												
									<label for="respiratory_medication1" class="radio-inline">
										<input class="form-check-input respiratory_medication" type="radio" name="elder[][respiratory_medication]" value="1" {{ old('respiratory_medication') == 1 ? 'checked' : '' }} >
										{{ 'छ' }}
									</label>
									
									<label for="respiratory_medication2" class="radio-inline">
										<input class="form-check-input respiratory_medication" type="radio" name="elder[][respiratory_medication]" value="2" {{ old('respiratory_medication') == 2 ? 'checked' : '' }}> 
										{{ 'छैन ' }}
									</label>
									@if($errors->has('regular_medication'))
										<div class="invalid-feedback">
											{{ $errors->first('regular_medication') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 form-group form-check respiratory_medication_names">
									<label for="medication_name">{{'औषधिको नाम' }}</label>
									<input class="form-control respiratory_medication_name" name="elder[][respiratory_medication_name]" type="text" />
									@if($errors->has('respiratory_medication_name'))
										<div class="invalid-respiratory_medication_name" style="display:block;">
											{{ $errors->first('respiratory_medication_name') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 listradio form-group {{ $errors->has('regular_excercise') ? 'has-error' : '' }}">
									<label for="slug">{{'दैनिक योग, ब्यायाम वा मर्निङ्ग वाक गर्नुहुन्छ ?' }}</label><br>
												
									<label for="regular_excercise1" class="radio-inline">
										<input class="form-check-input regular_excercise" type="radio" name="elder[][regular_excercise]" value="1" {{ old('regular_excercise') == 1 ? 'checked' : '' }} >
										{{ 'गर्छु' }}
									</label>
									
									<label for="regular_excercise2" class="radio-inline">
										<input class="form-check-input regular_excercise" type="radio" name="elder[][regular_excercise]" value="2" {{ old('regular_excercise') == 2 ? 'checked' : '' }}> 
										{{ 'गर्दिन ' }}
									</label>
									@if($errors->has('regular_excercise'))
										<div class="invalid-feedback">
											{{ $errors->first('regular_excercise') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 form-group form-check excerise_durations">
									<label for="excerise_duration">{{'दैनिक ब्यायाम अवधि' }}</label>
									<select name="elder[][excerise_duration]" class="form-control form-select regular_excercise">
										<option value="">{{'चयन गर्नुहोस्'}}</option>	
										<option value="३० मिनेट सम्म">३० मिनेट सम्म</option>
										<option value="३० मिनेट देखि १ घण्टा सम्म">३० मिनेट देखि १ घण्टा सम्म</option>
										<option value="१ घण्टा भन्दा बढी">१ घण्टा भन्दा बढी</option>
									</select>
									@if($errors->has('excerise_duration'))
										<div class="invalid-excerise_duration" style="display:block;">
											{{ $errors->first('excerise_duration') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 listradio form-group {{ $errors->has('sugar_check_6') ? 'has-error' : '' }}">
									<label for="slug">{{'के तपाईले ६ महिना भित्रमा सुगर जाँच गराउनु भएको छ ?' }}</label><br>
												
									<label for="sugar_check_61" class="radio-inline">
										<input class="form-check-input" type="radio" name="elder[][sugar_check_6]" value="1" {{ old('sugar_check_6') == 1 ? 'checked' : '' }} >
										{{ 'छ' }}
									</label>
									
									<label for="sugar_check_62" class="radio-inline">
										<input class="form-check-input" type="radio" name="elder[][sugar_check_6]" value="2" {{ old('sugar_check_6') == 2 ? 'checked' : '' }}> 
										{{ 'छैन ' }}
									</label>
									@if($errors->has('sugar_check_6'))
										<div class="invalid-feedback">
											{{ $errors->first('sugar_check_6') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 listradio form-group {{ $errors->has('sugar_level_stat') ? 'has-error' : '' }}">
									<label for="slug">{{'सुगर लेभल कस्तो छ ?' }}</label><br>
												
									<label for="sugar_level_stat1" class="radio-inline">
										<input class="form-check-input sugar_level_stat" type="radio" name="elder[][sugar_level_stat]" value="1" {{ old('sugar_level_stat') == 1 ? 'checked' : '' }} >
										{{ 'नर्मल छ' }}
									</label>
									
									<label for="sugar_level_stat2" class="radio-inline">
										<input class="form-check-input sugar_level_stat" type="radio" name="elder[][sugar_level_stat]" value="2" {{ old('sugar_level_stat') == 2 ? 'checked' : '' }}> 
										{{ 'नर्मल भन्दा बढी ' }}
									</label>
									@if($errors->has('sugar_level_stat'))
										<div class="invalid-feedback">
											{{ $errors->first('sugar_level_stat') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 listradio form-group sugar_medications{{ $errors->has('sugar_medication') ? 'has-error' : '' }}">
									<label for="slug">{{'सुगरको नियमित औषधि सेवन गर्नुभएको छ ?' }}</label><br>
												
									<label for="sugar_medication1" class="radio-inline">
										<input class="form-check-input sugar_medication" type="radio" name="elder[][sugar_medication]" value="1" {{ old('sugar_medication') == 1 ? 'checked' : '' }} >
										{{ 'छ' }}
									</label>
									
									<label for="sugar_medication2" class="radio-inline">
										<input class="form-check-input sugar_medication" type="radio" name="elder[][sugar_medication]" value="2" {{ old('sugar_medication') == 2 ? 'checked' : '' }}> 
										{{ 'छैन ' }}
									</label>
									@if($errors->has('sugar_medication'))
										<div class="invalid-feedback">
											{{ $errors->first('sugar_medication') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 form-group form-check sugar_medication_names">
									<label for="sugar_medication_name">{{'सुगर औषधिको नाम' }}</label>
									<input name="elder[][sugar_medication_name]" placeholder="सुगर औषधिको नाम " type="text" class="form-control sugar_medication_name" />
									@if($errors->has('sugar_medication_name'))
										<div class="invalid-sugar_medication_name" style="display:block;">
											{{ $errors->first('sugar_medication_name') }}
										</div>
									@endif
								</div> 
								
								<div class="col-6 form-group form-check sugar_medication_dosages">
									<label for="sugar_medication_dosage">{{'सुगर औषधिको  मात्रा' }}</label>
									<input name="elder[][sugar_medication_dosage]" placeholder="सुगर औषधिको मात्रा" type="text" class="form-control" />
									@if($errors->has('sugar_medication_dosage'))
										<div class="invalid-sugar_medication_dosage" style="display:block;">
											{{ $errors->first('sugar_medication_dosage') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 form-group form-check sugar_medication_whys">
									<label for="sugar_medication_why">{{'सुगरको औषधि किन नलिनुभएको ?' }}</label>
									<input id="sugar_medication_why" name="elder[][sugar_medication_why]" type="text" class="form-control" />
									@if($errors->has('sugar_medication_why'))
										<div class="invalid-sugar_medication_why" style="display:block;">
											{{ $errors->first('sugar_medication_why') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 listradio form-group {{ $errors->has('bloodpressure_check_6') ? 'has-error' : '' }}">
									<label for="slug">{{'के तपाईले ६ महिना भित्रमा रक्तचापको परिक्षण गराउनु भएको छ ?' }}</label><br>
												
									<label for="bloodpressure_check_61" class="radio-inline">
										<input class="form-check-input bloodpressure_check_6" type="radio" name="elder[][bloodpressure_check_6]" value="1" {{ old('bloodpressure_check_6') == 1 ? 'checked' : '' }} >
										{{ 'छ' }}
									</label>
									
									<label for="bloodpressure_check_62" class="radio-inline">
										<input class="form-check-input bloodpressure_check_6" type="radio" name="elder[][bloodpressure_check_6]" value="2" {{ old('bloodpressure_check_6') == 2 ? 'checked' : '' }}> 
										{{ 'छैन ' }}
									</label>
									@if($errors->has('sugar_check_6'))
										<div class="invalid-feedback">
											{{ $errors->first('sugar_check_6') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 form-group form-check bloodpressure_checked_at">
									<label for="bloodpressure_checked_at">{{'रक्तचापको परिक्षण कहाँ गराउनु भयो ?' }}</label>
									<select name="elder[][bloodpressure_checked_at]" class="form-control form-select">
										<option value="">{{'चयन गर्नुहोस्'}}</option>	
										<option value="सरकारी स्वास्थ्य संस्था">सरकारी स्वास्थ्य संस्था</option>
										<option value="निजि स्वास्थ्य संस्था">निजि स्वास्थ्य संस्था</option>
										<option value="आधारभूत स्वास्थ्य केन्द्र">आधारभूत स्वास्थ्य केन्द्र</option>
										<option value="घरमा">घरमा</option>
									</select>
									@if($errors->has('bloodpressure_checked_at'))
										<div class="invalid-bloodpressure_checked_at" style="display:block;">
											{{ $errors->first('bloodpressure_checked_at') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 listradio form-group {{ $errors->has('bloodpressure_level_stat') ? 'has-error' : '' }}">
									<label for="slug">{{'रक्तचापको अवस्था कस्तो छ ?' }}</label><br>
												
									<label for="bloodpressure_level_stat1" class="radio-inline">
										<input class="form-check-input bloodpressure_level_stat" type="radio" name="elder[][bloodpressure_level_stat]" value="1" {{ old('bloodpressure_level_stat') == 1 ? 'checked' : '' }} >
										{{ 'नर्मल छ' }}
									</label>
									
									<label for="bloodpressure_level_stat2" class="radio-inline">
										<input class="form-check-input bloodpressure_level_stat" type="radio" name="elder[][bloodpressure_level_stat]" value="2" {{ old('bloodpressure_level_stat') == 2 ? 'checked' : '' }}> 
										{{ 'उच्च रक्तचाप' }}
									</label>
									@if($errors->has('bloodsugar_level_stat'))
										<div class="invalid-feedback">
											{{ $errors->first('bloodsugar_level_stat') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 listradio form-group bloodpressure_symptoms">
									<label for="slug">{{'उच्च रक्तचाप भएको भएमा विगतमा तपाईलाई छाती दुख्ने वा हृदयघात हुने गरेको वा लक्षण देखिएको छ ?' }}</label><br>
												
									<label for="bloodpressure_symptoms1" class="radio-inline">
										<input class="form-check-input bloodpressure_symptom" type="radio" name="elder[][bloodpressure_symptoms]" value="1" {{ old('bloodpressure_symptoms') == 1 ? 'checked' : '' }} >
										{{ 'छ' }}
									</label>
									
									<label for="bloodpressure_symptoms2" class="radio-inline">
										<input class="form-check-input bloodpressure_symptom" type="radio" name="elder[][bloodpressure_symptoms]" value="2" {{ old('bloodpressure_symptoms') == 2 ? 'checked' : '' }}> 
										{{ 'छैन' }}
									</label>
									@if($errors->has('bloodpressure_symptoms'))
										<div class="invalid-feedback">
											{{ $errors->first('bloodpressure_symptoms') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 listradio form-group bloodpressure_medications">
									<label for="slug">{{'उच्च रक्तचापको नियमित औषधि सेवन गर्नु भएको छ ?' }}</label><br>
												
									<label for="bloodpressure_medication1" class="radio-inline">
										<input class="form-check-input bloodpressure_medication" type="radio" name="elder[][bloodpressure_medication]" value="1" {{ old('bloodpressure_medication') == 1 ? 'checked' : '' }} >
										{{ 'छ' }}
									</label>
									
									<label for="bloodpressure_medication2" class="radio-inline">
										<input class="form-check-input bloodpressure_medication" type="radio" name="elder[][bloodpressure_medication]" value="2" {{ old('bloodpressure_medication') == 2 ? 'checked' : '' }}> 
										{{ 'छैन ' }}
									</label>
									@if($errors->has('bloodpressure_medication'))
										<div class="invalid-feedback">
											{{ $errors->first('bloodpressure_medication') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 form-group form-check bloodpressure_medication_names">
									<label for="bloodpressure_medication_name">{{'रक्तचापको औषधिको नाम' }}</label>
									<input id="bloodpressure_medication_name" name="elder[][bloodpressure_medication_name]" placeholder="रक्तचाप औषधिको नाम " type="text" class="form-control" />
									@if($errors->has('bloodpressure_medication_name'))
										<div class="invalid-bloodpressure_medication_name" style="display:block;">
											{{ $errors->first('bloodpressure_medication_name') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 form-group form-check bloodpressure_medication_dosages">
									<label for="bloodpressure_medication_dosage">{{'रक्तचापको औषधिको  मात्रा' }}</label>
									<input name="elder[][bloodpressure_medication_dosage]" placeholder="रक्तचाप औषधिको मात्रा" type="text" class="form-control bloodpressure_medication_dosage" />
									@if($errors->has('bloodpressure_medication_dosage'))
										<div class="invalid-bloodpressure_medication_dosage" style="display:block;">
											{{ $errors->first('bloodpressure_medication_dosage') }}
										</div>
									@endif
								</div>
								
								<div class="col-6 form-group form-check family_medical_issue">
									<label for="family_medical_issue">{{'तपाईको मूख्य स्वास्थ्य समस्या के हो ?' }}</label>
									<input name="elder[][family_medical_issue]" type="text" class="form-control" />
									@if($errors->has('family_medical_issue'))
										<div class="invalid-family_medical_issue" style="display:block;">
											{{ $errors->first('family_medical_issue') }}
										</div>
									@endif
								</div>
								<div class="col-md-12" style="margin-top:15px;">
									<a href="javascript:void(0)" class="remove-item delete btn btn-soft-danger"><i class="ri-indeterminate-circle-line"></i> Remove</a>
								</div>			
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		
		<div class="col-12 div-header border-bottom-dashed family-planning" style="padding-bottom: 15px;">
			<div class="row">
			
				<h5 class="card-title mb-0">( १५ देखि ४९ वर्ष सम्मका महिला पुरुषलाई प्रश्न)</h5>
				<div class="col-6 listradio form-group {{ $errors->has('family_planning_done') ? 'has-error' : '' }}">
					<label for="slug">{{'परिवार नियोजनको साधनको प्रयोग गर्नुभएको छ?' }}<span style="color:red;">*</span></label><br>
								
					<label for="pregnancy_test1" class="radio-inline">
						<input class="form-check-input" type="radio" name="family_planning_done" value="1" {{ old('pregnancy_test') == 1 ? 'checked' : '' }} >
						{{ 'छ' }}
					</label>
					
					<label for="pregnancy_test2" class="radio-inline">
						<input class="form-check-input" type="radio" name="family_planning_done" value="2" {{ old('pregnancy_test') == 2 ? 'checked' : '' }}> 
						{{ 'छैन ' }}
					</label>
					@if($errors->has('family_planning_done'))
						<div class="invalid-feedback">
							{{ $errors->first('family_planning_done') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group listradio family_planning_device">
					<label for="family_planning_device">{{'कुन साधन प्रयोग गर्नुभएको छ ?' }}</label><br><br>
								
					<label for="family_planning_device1" class="radio-inline">
						<input class="form-check-input" type="radio" name="family_planning_device" value="1" {{ old('family_planning_device') == 1 ? 'checked' : '' }}>
						{{ 'स्थायी' }}
					</label>
					
					<label for="family_planning_device2" class="radio-inline">
						<input class="form-check-input" type="radio" name="family_planning_device" value="2" {{ old('family_planning_device') == 2 ? 'checked' : '' }}> 
						{{ 'अस्थायी ' }}
					</label>
					@if($errors->has('family_planning_device'))
						<div class="invalid-feedback">
							{{ $errors->first('family_planning_device') }}
						</div>
					@endif
				</div>
				
				<div class="col-md-6 form-group family_planning_permas">
					<label for="family_planning_perma">{{'कुन स्थायी साधनको प्रयोग गर्नुभयो? ' }}</label>
					<select name="family_planning_perma" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="मिनिल्याप">मिनिल्याप</option>
						<option value="भ्यक्सेटोमी">भ्यक्सेटोमी</option>
					</select>
					@if($errors->has('family_planning_perma'))
						<div class="invalid-family_planning_perma" style="display:block;">
							{{ $errors->first('family_planning_perma') }}
						</div>
					@endif
				</div>
				
				<div class="col-md-5 form-group family_planning_temps">
					<label for="family_planning_temp">{{'कुन अस्थायी साधनको प्रयोग गर्नुभयो?  ' }}</label>
					<select name="family_planning_temp[]" class="form-select " multiple="multiple">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="कण्दम">कण्दम</option>
						<option value="पिल्स">पिल्स</option>
						<option value="दिपो">दिपो</option>
						<option value="इम्प्लान्ट">इम्प्लान्ट</option>
						<option value="आयुसिदी">आयुसिदी</option>
						<option value="प्राकृतिक बिधी">प्राकृतिक बिधी</option>
					</select>
					@if($errors->has('family_planning_temp'))
						<div class="invalid-family_planning_temp" style="display:block;">
							{{ $errors->first('family_planning_temp') }}
						</div>
					@endif
				</div>
			</div>
		</div>		
		
		<div class="col-12 div-header border-bottom-dashed" style="padding-bottom: 15px;display:none;">
			<div class="row">
				<h5 class="card-title mb-0">वातावरणीय स्वच्छता र सरसफाई </h5> 
				
				<div class="col-6 form-group form-check rubbish_mgmt">
					<label for="rubbish_mgmt">{{'घरबाट निस्कने फोहरमैलाको ब्यवस्थापन कसरी गर्नुहुन्छ ?' }}<span style="color:red;">*</span></label>
					<select id="rubbish_mgmt" name="rubbish_mgmt" class="form-control form-select" >
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="वर्गिकरण गरेर कुहिने फोहरमैलालाई कम्पोष्टबिन बनाउँछु">वर्गिकरण गरेर कुहिने फोहरमैलालाई कम्पोष्टबिन बनाउँछु</option>
						<option value="फोहोरमैला वर्गिकरण गरेर नगरपालिकाको गाडीमा पठाउँछु">फोहोरमैला वर्गिकरण गरेर नगरपालिकाको गाडीमा पठाउँछु</option>
						<option value="हाल सम्म वर्गिकरण गरेको छैन">हाल सम्म वर्गिकरण गरेको छैन</option>
						<option value="नकुहिने फोहर जलाउँछु">नकुहिने फोहर जलाउँछु</option>
						<option value="अन्य">अन्य</option>
					</select>
					@if($errors->has('rubbish_mgmt'))
						<div class="invalid-rubbish_mgmt" style="display:block;">
							{{ $errors->first('rubbish_mgmt') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check plastic_rubbish_mgmt">
					<label for="plastic_rubbish_mgmt">{{'प्लाष्टिकजन्य फोहरमैलाको ब्यवस्थापन कसरी गर्नुभएको छ ?' }}<span style="color:red;">*</span></label>
					<select id="plastic_rubbish_mgmt" name="plastic_rubbish_mgmt" class="form-control form-select" >
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="जलाउँछु">जलाउँछु</option>
						<option value="पुन: प्रयोग गर्छु">पुन: प्रयोग गर्छु</option>
						<option value="नगरपालिकाको गाडीलाई दिने गरेको छु ।">नगरपालिकाको गाडीलाई दिने गरेको छु ।</option>
						<option value="अन्य">अन्य</option>
					</select>
					@if($errors->has('plastic_rubbish_mgmt'))
						<div class="invalid-plastic_rubbish_mgmt" style="display:block;">
							{{ $errors->first('plastic_rubbish_mgmt') }}
						</div>
					@endif
				</div> 
				
				<div class="col-6 form-group form-check drinking_water_src">
					<label for="drinking_water_src">{{'खानेपानीको कुन श्रोतको प्रयोग गर्नुभएको छ ?' }}<span style="color:red;">*</span></label>
					<select id="drinking_water_src" name="drinking_water_src" class="form-control form-select" >
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="धारा">धारा</option>
						<option value="कुवा">कुवा</option>
						<option value="जार">जार</option>
						<option value="ट्यांकर">ट्यांकर</option>
					</select>
					@if($errors->has('drinking_water_src'))
						<div class="invalid-drinking_water_src" style="display:block;">
							{{ $errors->first('drinking_water_src') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group {{ $errors->has('drinking_water_purify') ? 'has-error' : '' }}">
					<label for="slug">{{'खानेपानी शुद्धिकरण गरेर पिउनु हुन्छ ?' }}<span style="color:red;">*</span></label><br>
								
					<label for="drinking_water_purify1" class="radio-inline">
						<input class="form-check-input" type="radio" name="drinking_water_purify" id="drinking_water_purify1" value="1" {{ old('pregnancy_test') == 1 ? 'checked' : '' }} >
						{{ 'गर्छु' }}
					</label>
					
					<label for="drinking_water_purify2" class="radio-inline">
						<input class="form-check-input" type="radio" name="drinking_water_purify" id="drinking_water_purify2" value="2" {{ old('pregnancy_test') == 2 ? 'checked' : '' }}> 
						{{ 'गर्दिन ' }}
					</label>
					@if($errors->has('drinking_water_purify'))
						<div class="invalid-feedback">
							{{ $errors->first('drinking_water_purify') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 form-group form-check method_water_purify">
					<label for="method_water_purify">{{'कुन शुद्धिकरण विधि प्रयोग गर्नुहुन्छ ? ' }}</label>
					<select id="method_water_purify" name="method_water_purify" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="उमालेर">उमालेर</option>
						<option value="क्लोरिन विधि">क्लोरिन विधि</option>
						<option value="सोडिस">सोडिस</option>
						<option value="फिल्टर(नर्मल)">फिल्टर(नर्मल)</option>
						<option value="प्युरीफायर">प्युरीफायर</option>
						<option value="अन्य">अन्य</option>
					</select>
					@if($errors->has('method_water_purify'))
						<div class="invalid-method_water_purify" style="display:block;">
							{{ $errors->first('method_water_purify') }}
						</div>
					@endif
				</div>
				
				<div class="col-6 listradio form-group {{ $errors->has('rainy_season_disease') ? 'has-error' : '' }}">
					<label for="slug">{{'वर्षायाममा तपाईको परिवारमा आउँ ,झाडापखाला ,हैजा , टाइफाइड जस्ता रोगको समस्या भएको छ ?' }}<span style="color:red;">*</span></label><br>
								
					<label for="rainy_season_disease1" class="radio-inline">
						<input class="form-check-input" type="radio" name="rainy_season_disease" id="rainy_season_disease1" value="1" {{ old('rainy_season_disease') == 1 ? 'checked' : '' }} >
						{{ 'छ' }}
					</label>
					
					<label for="rainy_season_disease2" class="radio-inline">
						<input class="form-check-input" type="radio" name="rainy_season_disease" id="rainy_season_disease2" value="2" {{ old('rainy_season_disease') == 2 ? 'checked' : '' }}> 
						{{ 'छैन ' }}
					</label>
					@if($errors->has('rainy_season_disease'))
						<div class="invalid-feedback">
							{{ $errors->first('rainy_season_disease') }}
						</div>
					@endif
				</div>
			</div>
		</div>
		
		<div class="col-12 div-header border-bottom-dashed dengue_malaria" style="padding-bottom: 15px;">
			<div class="row">
				<h5 class="card-title mb-0">किटजन्य (डेँगु ,मलेरिया)</h5> 
				
				<div class="col-6 form-group listradio">
					<label for="meshed_windows">{{'घरको झ्याल ,ढोकामा जाली लगाएको छ ? (अवलोकन गरेर भर्ने)' }}<span style="color:red;">*</span></label><br>
					<label for="meshed_windows1" class="radio-inline">
						<input class="form-check-input" type="radio" name="meshed_windows" id="meshed_windows1" value="1" {{ old('meshed_windows') == 1 ? 'checked' : '' }} >
						{{ 'छ' }}
					</label>
					
					<label for="meshed_windows2" class="radio-inline">
						<input class="form-check-input" type="radio" name="meshed_windows" id="meshed_windows2" value="2" {{ old('meshed_windows') == 2 ? 'checked' : '' }}> 
						{{ 'छैन ' }}
					</label>
					@if($errors->has('meshed_windows'))
						<div class="invalid-feedback">
							{{ $errors->first('meshed_windows') }}
						</div>
					@endif
				</div>
				<div class="col-6 form-group listradio">
					<label for="pot_holes">{{'घर बाहिर खाल्डाखुल्डीमा पानी जमेको छ ? (अवलोकन गरेर भर्ने)' }}<span style="color:red;">*</span></label><br>
					<label for="pot_holes1" class="radio-inline">
						<input class="form-check-input" type="radio" name="pot_holes" id="pot_holes1" value="1" {{ old('pot_holes') == 1 ? 'checked' : '' }} >
						{{ 'छ' }}
					</label>
					
					<label for="pot_holes2" class="radio-inline">
						<input class="form-check-input" type="radio" name="pot_holes" id="pot_holes2" value="2" {{ old('pot_holes') == 2 ? 'checked' : '' }}> 
						{{ 'छैन ' }}
					</label>
					@if($errors->has('pot_holes'))
						<div class="invalid-feedback">
							{{ $errors->first('pot_holes') }}
						</div>
					@endif
				</div>
				<div class="col-6 form-group listradio">
					<label for="pot_pan_water">{{'गमला ,फुल्दानी ,भाडाकुडामा पानी जमेको छ  ? (अवलोकन गरेर भर्ने)' }}<span style="color:red;">*</span></label><br>
					<label for="pot_pan_water1" class="radio-inline">
						<input class="form-check-input" type="radio" name="pot_pan_water" id="pot_pan_water1" value="1" {{ old('pot_pan_water') == 1 ? 'checked' : '' }} >
						{{ 'छ' }}
					</label>
					
					<label for="pot_pan_water2" class="radio-inline">
						<input class="form-check-input" type="radio" name="pot_pan_water" id="pot_pan_water2" value="2" {{ old('pot_pan_water') == 2 ? 'checked' : '' }}> 
						{{ 'छैन ' }}
					</label>
					@if($errors->has('pot_pan_water'))
						<div class="invalid-feedback">
							{{ $errors->first('pot_pan_water') }}
						</div>
					@endif
				</div>
				<div class="col-6 form-group listradio">
					<label for="family_dengue">{{'तपाईको परिवारमा डेँगु ,मलेरियाको समस्या देखिएको थियो ? ' }}<span style="color:red;">*</span></label><br>
					<label for="family_dengue1" class="radio-inline">
						<input class="form-check-input" type="radio" name="family_dengue" id="family_dengue1" value="1" {{ old('family_dengue') == 1 ? 'checked' : '' }} >
						{{ 'छ' }}
					</label>
					
					<label for="family_dengue2" class="radio-inline">
						<input class="form-check-input" type="radio" name="family_dengue" id="family_dengue2" value="2" {{ old('family_dengue') == 2 ? 'checked' : '' }}> 
						{{ 'छैन ' }}
					</label>
					@if($errors->has('family_dengue'))
						<div class="invalid-feedback">
							{{ $errors->first('family_dengue') }}
						</div>
					@endif
				</div>
				<div class="col-6 form-group form-check">
					<label for="dengue_prevention">{{'तपाईको विचारमा डेँगु महामारी नियन्त्रण गर्न के गर्नुपर्ला ?' }}<span style="color:red;">*</span></label>
					<select id="dengue_prevention" name="dengue_prevention" class="form-control form-select">
						<option value="">{{'चयन गर्नुहोस्'}}</option>	
						<option value="औषधि छर्कनुपर्छ ।">औषधि छर्कनुपर्छ ।</option>
						<option value="लामखुट्टेको वृद्धि हुन नदिन पानी जम्न दिनु हुदैँन ।">लामखुट्टेको वृद्धि हुन नदिन पानी जम्न दिनु हुदैँन ।</option>
						<option value="जनचेतनामूलक कार्यक्रम सन्चालन गर्नुपर्छ ।">जनचेतनामूलक कार्यक्रम सन्चालन गर्नुपर्छ ।</option>
						<option value="अन्य">अन्य</option>
					</select>
					@if($errors->has('dengue_prevention'))
						<div class="invalid-rubbish_mgmt" style="display:block;">
							{{ $errors->first('dengue_prevention') }}
						</div>
					@endif
				</div>
			</div>
		</div>
	
		<div class="col-12 text-end"  style="padding-top: 15px;">
			<button class="btn btn-success" type="submit" id="uploadButton">
				<i class="ri-save-line"></i> Save
			</button>  
		</div>
	</div>
