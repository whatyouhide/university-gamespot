$(function () {
  // How many time has to pass before the flashes fade out.
  var FADE_OUT_AFTER = 7000;

  // Fade out time.
  var FADE_OUT_IN = 1000;

  $('.flashes').delay(FADE_OUT_AFTER).fadeOut(FADE_OUT_IN);
});
