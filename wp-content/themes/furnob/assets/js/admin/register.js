/* KLB Registration Check */

(function($) {

    'use strict';

    $(document).ready(function() {

        var $wrapper = $('#klb-theme-registration');

        if ($wrapper.length === 0) {
            return;
        }

        var $termsInput         = $wrapper.find('#klb-accept-license-terms');
        var $registerButton     = $wrapper.find('#klb-register-theme');

        $termsInput.on('change', function(e) {
            if ($(this).is(':checked')) {
                $registerButton.removeAttr('disabled');
            } else {
                $registerButton.attr('disabled', 'disabled');
            }
        });

    });

})(jQuery);

