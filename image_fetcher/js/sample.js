$(function()
{
        // Hide ajax indicator and make it show during activity
        $('#ajax-indicator')
                .css({opacity: 0})
                .bind(
                {
                        ajaxStart: function() 
                                { 
                                        $(this).stop(true).animate({opacity: 1}, 'fast');
                                },
                        ajaxStop: function()
                                {
                                        $(this).stop(true, true).animate({opacity: 0}, 'slow');
                                },
                });

        $('.link-list-button')
                .click(toggleList);

        $('.link-list')
                .hide();
});

function toggleList()
{
        var menu = $(this).data('menu');

        $('.link-list')
                .not(menu)
                .slideUp();

        $(menu)
                .slideToggle();

        return false;
}