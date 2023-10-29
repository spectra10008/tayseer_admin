$(document).ready(function () {
  "use strict";

  setInterval(() => $(".loading").fadeOut("slow", "linear"), 3000);
  // Adjust Slider Height
  var winH = $(window).height(),
    navH = $(".navbar").innerHeight();
  $(".hero").height(winH - navH);
});
