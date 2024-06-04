function updateBackground(b, type, main_color) {
	var gradient = $('#' + type + '-gradient').val();
	var background1 = $('#' + type + '-background-1').val();
	var background2 = $('#' + type + '-background-2').val();
	if(main_color == 1){
		var background1 = b;
	}else{
		var background2 = b;
	}
	if(gradient != 0){
		$('.ex-' + type).css('background', 'linear-gradient(' + gradient + ', #' + background1 + ', #' + background2 + ')');
	}else{
		$('.ex-' + type).css('background', '#' + b);
	}
}

function gradientChange(value, type){
	var background1 = $('#' + type + '-background-1').val();
	var background2 = $('#' + type + '-background-2').val();
	if (value != 0){
		$('.' + type + '-background').removeClass('hidden');
		$('.ex-' + type).css('background', 'linear-gradient(' + value + ', #' + background1 + ', #' + background2 + ')');
	}else{
		$('.' + type + '-background').addClass('hidden');
		$('.ex-' + type).css('background', '#' + background1);
	}
}

function updateTextColor(color, type) {
	$('.ex-' + type).css('color', '#'+color);
}
function updateBorderColor(color, type){
	$('.ex-' + type).css('border-color', '#'+color);
}
function updateBorder(val){
	$('.ex-btn').css('border-width', val+'px');
}
function updateMinWidth(val){
	$('.ex-btn').css('min-width', val+'px');
}
function updateBorderRadius(val) {
	$('.ex-btn').css('border-radius', val+'px');
}
function updateFontSize(val) {
	$('.ex-btn').css('font-size', val+'px');
}
function updateFontWeight(val) {
	$('.ex-btn').css('font-weight', val);
}
function updatePaddngX(val) {
	$('.ex-btn').css({'padding-left': val+'px', 'padding-right': val+'px'});
}
function updatePaddngY(val) {
	$('.ex-btn').css({'padding-top': val+'px', 'padding-bottom': val+'px'});
}
function updateTextTransform(val){
	if(val.checked == true){
		$('.ex-btn').css('text-transform', 'uppercase');
	}else{
		$('.ex-btn').css('text-transform', 'none');
	}

}

var background = {
	0	:	['F7F7F7', 'F7F7F7', 'FFFFFF', 'F7F7F7'],
	1	:	['FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF'],
	2	:	['F7F7F7', 'F7F7F7', 'FFFFFF', 'F7F7F7'],
	3	:	['E3E3E3', 'E3E3E3', 'E3E3E3', '959595'],
	4	:	['FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF'],
	5	:	['FFFFFF', 'FFFFFF', 'FFFFFF', '242424'],
};

var font_color = {
	0	:	['777777', '777777', '777777', '777777'],
	1	:	['777777', '777777', '777777', '777777'],
	2	:	['777777', '777777', '777777', '777777'],
	3	:	['777777', '777777', '777777', 'FFFFFF'],
	4	:	['242424', '242424', '242424', '242424'],
	5	:	['242424', '242424', '242424', 'FFFFFF'],
};

var border_color = {
	0	:	['E8E8E8', 'E8E8E8', 'E8E8E8'],
	1	:	['E8E8E8', 'E8E8E8', 'E8E8E8'],
	2	:	['E8E8E8', 'E8E8E8', 'E8E8E8'],
	3	:	['E8E8E8', 'E8E8E8', 'E8E8E8'],
	4	:	['242424', '242424', '242424'],
	5	:	['242424', '242424', '242424'],
};

var border_width = {
	0	:	['0', '0', '0'],
	1	:	['1', '1', '1'],
	2	:	['2', '2', '2'],
	3	:	['0', '0', '0'],
	4	:	['1', '1', '1'],
	5	:	['1', '1', '1'],
};

var border_radius = {
	0	:	['2', '2', '2'],
	1	:	['0', '0', '0'],
	2	:	['14', '14', '14'],
	3	:	['0', '0', '0'],
	4	:	['0', '0', '0'],
	5	:	['0', '0', '0'],
};

var box_shadow = ['0', '1', '1', '1', '0', '0'];

var element_name = ['rating', 'form', 'box', 'box_header'];

function getStyle(element, type){

	console.log(element_name[element]);
	console.log(background[type][element]);
	console.log(box_shadow[type]);

	$('input[name=\'extended_reviews_settings[' + element_name[element] + '][background]\']').val(background[type][element]);
	$('input[name=\'extended_reviews_settings[' + element_name[element] + '][color]\']').val(font_color[type][element]);
	$('input[name=\'extended_reviews_settings[' + element_name[element] + '][border-color]\']').val(border_color[type][element]);
	$('input[name=\'extended_reviews_settings[' + element_name[element] + '][border]\']').val(border_width[type][element]);
	$('input[name=\'extended_reviews_settings[' + element_name[element] + '][border-radius]\']').val(border_radius[type][element]);
	if(box_shadow[type] == 1){
		$('input[name=\'extended_reviews_settings[' + element_name[element] + '][shadow]\']').prop('checked', true);
	} else {
		$('input[name=\'extended_reviews_settings[' + element_name[element] + '][shadow]\']').prop('checked', false);
	}

	if(element == 2){
		$('input[name=\'extended_reviews_settings[' + element_name[3] + '][background]\']').val(background[type][3]);
		$('input[name=\'extended_reviews_settings[' + element_name[3] + '][color]\']').val(font_color[type][3]);
	}



}
