
$(document).ready(function()
{
    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
		if(output != undefined)
		{
			if (window.JSON) {
				output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
			} else {
				output.val('JSON browser support required for this demo.');
			}
		}
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1,
		maxDepth: 1
    })
    .on('change', updateOutput);

    // activate Nestable for list 2
    $('#nestable2').nestable({
        group: 1,
		maxDepth: 1
    })
    .on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    updateOutput($('#nestable2').data('output', $('#nestable2-output')));
	
	
	// activate Nestable for list 1
    $('#nestable_category').nestable({
        group: 1,
		maxDepth: 1
    })
    .on('change', updateOutput);

    // activate Nestable for list 2
    $('#nestable_category2').nestable({
        group: 1,
		maxDepth: 1
    })
    .on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable_category').data('output', $('#nestable_category-output')));
    updateOutput($('#nestable_category2').data('output', $('#nestable_category2-output')));

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('#nestable3').nestable();

});