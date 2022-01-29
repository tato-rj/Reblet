require('./bootstrap/setup');
require('./bootstrap/extensions');
require('./bootstrap/utilities');
require('./bootstrap/components');

//////////////////////////////////////
//// CUSTOM JS BELOW
//////////////////////////////////////

window.log = function(message) {
	console.log(message);
}

// SUPPORTING FILES
$(document).on('change', '.support-data-form select[name="type"]', function() {
	let $inputs = $(this).closest('form').find('.hidden-inputs')
	let $target = $(this).closest('form').find('.'+this.value);

	$inputs.find('input').prop('required', false);
	$inputs.hide();

	$target.find('input').prop('required', true);
	$target.show();
});

// SEND FILE VIA EMAIL
$(document).on('submit', 'form.share-file-form', function(e) {
	e.preventDefault();

	let recipient = $(this).find('[name="recipient"]').val();
	let subject = $(this).find('[name="subject"]').val();
	let body = $(this).find('[name="body"]').val();

	let email = 'mailto:'+recipient+'?'+subject+'&'+body;

	window.open(email, '_blank');
});

// OPEN FILE ACTION BUTTONS
$(document).on('click', '.file-action-button .btn', function() {
	let $button = $(this);
	let $panel = $('#file-panel');
	let $action = $panel.find('.panel-action[data-action="'+$button.data('action')+'"]');

	if ($panel.is(':visible') && $action.is(':visible')) {
		$panel.trigger('file-panel:close');
	} else {
		$button.disable();

		axios.get($button.data('url'))
			 .then(function(response) {
			 	$panel.html(response.data);
				$panel.trigger('file-panel:open');
			 })
			 .catch(function(error) {
			 	console.log(error);
			 })
			 .then(function() {
			 	$button.enable();
			 });
	}
});

// CLOSE FILE PANEL
$(document).on('click', '#file-panel button[data-dismiss="panel"]', function() {
	$('#file-panel').trigger('file-panel:close');
});
