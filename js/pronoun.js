(function($) {
  let pronoun_custom_field = $('.pronoun_custom_field_text_box').parent().parent();
  pronoun_custom_field.wrap('<div id="pronoun_custom_options"></div>');
  $('#pronoun_custom_options').append('<div id="pronoun_custom_field"></div>');
  $('#pronoun_custom_field').append(pronoun_custom_field);
  let pronoun_options = $('.editrow_pronoun_options');
  $('#pronoun_custom_options').prepend(pronoun_options);
  $('#pronoun_custom_field').hide();
  let pronoun_options_input_field = $('.editrow_pronoun_options').find('input[name=pronoun_options]');
  pronoun_options_input_field.on('change', function() {
    let pronoun = $('.editrow_pronoun_options').find('.select2-chosen').text();
    if (pronoun == "Other") {
      $('#pronoun_custom_field').show();
      $('.pronoun_custom_field_text_box').val('').trigger('change');
    }
    else {
      $('#pronoun_custom_field').hide();
      $('.pronoun_custom_field_text_box').val(pronoun).trigger('change');
    }
  });
})(CRM.$);
