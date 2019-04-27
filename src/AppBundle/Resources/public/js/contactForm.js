(function($) {
  var $newAddressBtn = $('#newAddress');
  var $wrapper = $('#contact_form_addresses');
  var $form = $('form[name="contact_form"]');
  var $addressForms = $wrapper.find('[id^="contact_form_addresses_"]');

  $wrapper.data('index', $addressForms.length);

  $addressForms.each(function() {
    var $form = $(this);
    addRemoveForumBtn($form);
    countrySelection($form);

  });

  $newAddressBtn.on('click', function(e) {
    e.preventDefault();
    addNewAddressForm();
  });

  function addNewAddressForm() {
    var prototype = $wrapper.data('prototype');
    var index = $wrapper.data('index') || 0;
    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    var $formBody = $('<div id="contact_form_addresses_' + index + '"></div>').append(newForm);

    addRemoveForumBtn($formBody);
    countrySelection($formBody);

    $wrapper.append($formBody);
    $wrapper.data('index', ++index);
  }

  function addRemoveForumBtn($form) {
    var $removeBtn = $('<button class="btn btn-danger">Remove</button>');
    var $formFooter = $('<div class="card-footer"></div>').append($removeBtn);

    $form.append($formFooter);

    $removeBtn.on('click', function(e) {
      e.preventDefault();
      $(this).parents('[id^="contact_form_addresses_"]').remove();
    });
  }

  function countrySelection($form) {
    var $countrySelect = $form.find('select.select-country');
    var $citySelect = $countrySelect.parents('[id^="contact_form_addresses_"]').find('select.select-city');

    getCitiesByCountryId($countrySelect, $citySelect);

    $countrySelect.on('change', function() {
      getCitiesByCountryId($countrySelect, $citySelect);
    });
  }

  function getCitiesByCountryId($countrySelect, $citySelect) {
    if (!$countrySelect.val()) {
      $citySelect.empty().append('<option>Please Select a Country</option>');
      return;
    }

    $.getJSON({
      url: $form.data('url-country-cities') + '/' + $countrySelect.val() + '/cities',
      async: true,
      success: function(data){
        $citySelect.empty();

        if (!data.length) {
          alert('No cities found!\nPlease select another country!');
          $countrySelect.prop('selectedIndex', 0);
          $citySelect.empty().append('<option>Please Select a Country</option>');
        }

        $.each(data, function(index, city) {
          $citySelect.append($('<option>', {
            value: city.id,
            text: city.name,
          }));
        })
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert('Something went wrong, can\'t retrieve cities for selected country!');
        console.error(textStatus, errorThrown);
      }
    });
  }
})(jQuery);
