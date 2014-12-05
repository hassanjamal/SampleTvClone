$(document).ready(function () {
    $('#userWizard').bootstrapWizard({
        onTabShow: function (tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;
            //var $percent = ($current / $total) * 100;
            //$('#userWizard').find('.bar').css({width: $percent + '%'});

            // If it's the last tab then hide the last button and show the finish instead
            if ($current >= $total) {
                $('#userWizard').find('.pager .next').hide();
                $('#userWizard').find('.pager .finish').show();
                $('#userWizard').find('.pager .finish').removeClass('disabled');
                $('#userSubmit').show();
                $('#userSubmit').removeClass('disabled');

            } else {

                $('#userWizard').find('.pager .next').show();
                $('#userWizard').find('.pager .finish').hide();
                $('#userSubmit').hide();
            }

        }
    });
    //$('#userWizard .finish').click(function () {
    //    alert('Finished!, Starting over!');
    //    $('#userWizard').find("a[href*='tab1']").trigger('click');
    //});
});