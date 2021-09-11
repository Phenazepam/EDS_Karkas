
$(document).ready(function(){
	
	$('.datepicker').datepicker();
	
	/*$.validator.addMethod("valueNotEquals", function(value, element, arg){
		return arg !== value;
	}, "");*/
	
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();
	
	$("#agent_validate").validate({
		rules:{
			"agent[title]":{
				required:true
			},
			"agent[params][category_id]":{
				required:true
			},
			"agent[params][site]":{
				required:true,
			},
			"agent[params][bank_schet]":{
				required:true,
				rangelength: [20, 20],
				number:true
			},
			"agent[params][bank_title]":{
				required:true
			},
			"agent[params][bank_bik]":{
				required:true,
				rangelength: [9, 9],
				number:true
			},
			"agent[params][full_title]":{
				required:true
			},
			"agent[params][short_title]":{
				required:true
			},
			"agent[params][inn]":{
				required:true,
				rangelength: [9, 12],
				number:true
			},
			"agent[params][kpp]":{
				required:false,
				rangelength: [9, 9],
				number:true
			},
			"agent[params][address]":{
				required:true
			}
		},
		ignore: ".ignore",
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	
	$("#contract_validate").validate({
		rules:{
			"contract[title]":{
				required:true
			},
			"contract[agent_id]":{
				required:true
			},
			"contract[params][type]":{
				required:true
			},
			"contract[number]":{
				required:true
			},
			"contract[params][begin_date]":{
				required:true
			},
			"contract[params][end_date]":{
				required:true
			},
		},
		ignore: ".ignore",
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
});
