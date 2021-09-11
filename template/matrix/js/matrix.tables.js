
$(document).ready(function(){
	
	$('.data-table').dataTable({
		"aLengthMenu": [ 50, 100, "All"],
		"iDisplayLength": 50,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"sDom": '<""l>t<"F"fp>',
		"oLanguage": {
			"sProcessing":   "Подождите...",
			"sLengthMenu":   "Показать _MENU_ записей",
			"sZeroRecords":  "Записи отсутствуют.",
			"sInfo":         "Записи с _START_ до _END_ из _TOTAL_ записей",
			"sInfoEmpty":    "Записи с 0 до 0 из 0 записей",
			"sInfoFiltered": "(отфильтровано из _MAX_ записей)",
			"sInfoPostFix":  "",
			"sSearch":       "Поиск:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst": "Первая",
				"sPrevious": "Предыдущая",
				"sNext": "Следующая",
				"sLast": "Последняя"
			},
			"oAria": {
				"sSortAscending":  ": активировать для сортировки столбца по возрастанию",
				"sSortDescending": ": активировать для сортировки столбцов по убыванию"
			}
		}
	});
	
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();
	
	$("span.icon input:checkbox, th input:checkbox").click(function() {
		var checkedStatus = this.checked;
		var checkbox = $(this).parents('.widget-box').find('tr td:first-child input:checkbox');		
		checkbox.each(function() {
			this.checked = checkedStatus;
			if (checkedStatus == this.checked) {
				$(this).closest('.checker > span').removeClass('checked');
			}
			if (this.checked) {
				$(this).closest('.checker > span').addClass('checked');
			}
		});
	});	
});
