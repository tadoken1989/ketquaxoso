var fade_duration=500;$(document).ready(function(){$('#first-digit-switch').change(function(){console.log($(this).onstyle);if($(this).prop('checked'))
$('span.first-digit').fadeIn(fade_duration);else
$('span.first-digit').fadeOut(fade_duration);});$('#last-digit-switch').change(function(){if($(this).prop('checked'))
$('span.last-digit').fadeIn(fade_duration);else
$('span.last-digit').fadeOut(fade_duration);});$('#last-2-switch').change(function(){if($(this).prop('checked'))
$('span.last-2-digit').fadeIn(fade_duration);else
$('span.last-2-digit').fadeOut(fade_duration);});$('#sum-switch').change(function(){if($(this).prop('checked'))
$('span.sum-2-digit').fadeIn(fade_duration);else
$('span.sum-2-digit').fadeOut(fade_duration);});});