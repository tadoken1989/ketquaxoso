/*
 * balloon.js
 *
 * Assign the code to baloon toggle button
 */

/*
 * Toggle the status of baloon based on the input number
 * 0 - left, 1 - right
 */
function balloon_toggle(num)
{
    if (0 == num)
    {
        ds = '#baloon-left';
        as = '#toggle-bl-left';
    }
    else if (1 == num)
    {
        ds = '#baloon-right';
        as = '#toggle-bl-right';
    }
    else
    {
        return false;
    }

    $(ds).toggleClass('inactive');
    $(as).text($(ds).hasClass('inactive')? '' : 'Ẩn quảng cáo');

    return true;
}
