/* 
 * Fichier JS pour les modules dev par Marc 
 * Actuellement:
 *		-Module pagination
 * 
 */


function paginationIsMax(x) {
	var max = parseInt($("#prs-pagination-bar").children().last().prev().attr('data-changepage'));
	if (max < x)
		return true;
	return false;
}

function setPaginationBar(x) {
	$(".prs-pagination-changepage").each(function () {
		if (parseInt($(this).attr('data-changepage')) == x) {
			$(this).css({
					'color' : 'red',
					'cursor' : 'pointer'
			    });
		}
		else {
			$(this).css({
				'color' : 'blue',
				'cursor' : 'pointer'
				});
		}
	});
	$(".prs-pagination-changepage-prev, .prs-pagination-changepage-next").css({
		'cursor' : 'pointer'
		});
}

function changePagination(x) {
	x = parseInt(x);
	if (paginationIsMax(x))
		x = 1;
	else if (x < 1)
		x = parseInt($("#prs-pagination-bar").children().last().prev().attr('data-changepage'));
	$(".prs-pagination-item").each(function () {
		if (!$(this).hasClass("prs-pagination-item-" + x)) {
			$(this).fadeOut(400, function(){
				$(this).hide();
			});
		}
	}).delay(400).each(function () {
			if ($(this).hasClass("prs-pagination-item-" + x)) {
				$(this).fadeIn(400, function(){
					$(this).show();
				});
			}
	});
	setPaginationBar(x);
	$("#prs-pagination-bar").attr('data-current-pagination', x);
}

$( document ).ready(function() {
	var x = 1;
	$(".prs-pagination-item").each(function () {
		if ($(this).hasClass("prs-pagination-item-" + x))
			$(this).show();
		else
			$(this).hide();
	});
	setPaginationBar(1);
	$(".prs-pagination-changepage").on("click", function () {
		changePagination($(this).attr('data-changepage'));
	});
	$(".prs-pagination-changepage-next").on("click", function () {
		changePagination(parseInt($("#prs-pagination-bar").attr('data-current-pagination')) + 1);
	});
	$(".prs-pagination-changepage-prev").on("click", function () {
		changePagination(parseInt($("#prs-pagination-bar").attr('data-current-pagination') - 1));
	});
});