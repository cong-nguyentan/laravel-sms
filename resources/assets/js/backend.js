(function($) {
    $(document).ready(function () {
        try{
            $('input[type="checkbox"].custom-checkbox, input[type="radio"].custom-radio').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue',
                increaseArea: '20%'
            });
        } catch(e) {

        }

        $(".btn-reset").click(function () {
            var linkReset = $(this).attr('data-reset-link');
            window.location.href = linkReset;
        })

        try{
            var nestableUpdateOutput = function(e)
            {
                var list   = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            }

            $(".nestable-lists").each( function(index, element) {
                var $parent = $(this);
                var $nestable = $(".dd", $parent);
                var $nestableStore = $(".nestable-output", $parent);

                $nestable.nestable({
                    maxDepth: 2
                }).on('change', function () {
                    nestableUpdateOutput($nestable.data('output', $nestableStore));
                    nestableUpdateOutput($nestable.data('output', $("#nestable-output")));
                });

                if (!$nestable.hasClass('disable-nestable-lists')) {
                    nestableUpdateOutput($nestable.data('output', $nestableStore));
                    nestableUpdateOutput($nestable.data('output', $("#nestable-output")));
                }
            })
        } catch(e) {

        }

        $(".sidebar #menu .sub-menu li").each(function (index, element) {
            var $liParent = $(this).parents("li");
            if ($(this).hasClass("active")) {
                $liParent.addClass("active");
            }
        })

        $(".checkbox-group-wrap").each(function (index, element) {
            var $parent = $(this);
            var $masterCheckbox = $(".master-checkbox", $parent);

            $(".child-checkbox", $parent).click(function () {
                if ($(this).is(":checked")) {
                    $masterCheckbox.prop('checked', true);
                }
            });
        })
    })
})(jQuery);