
import "./styles/app.scss";

// start the Stimulus application
import "./bootstrap";

import Bulma from '@vizuaalog/bulmajs';

import $ from "jquery";
import bulmaSlider from "bulma-extensions/bulma-slider/src/js";
$(document).ready(function () {

  $('.fa-eye').on("click", function () {
    var passInput = $("#password");
    if (passInput.attr('type') === 'password') {
      $(this).removeClass('fa-eye');
      $(this).addClass('fa-eye-slash');
      passInput.attr('type', 'text');
    } else {
      passInput.attr('type', 'password');
      $(this).addClass('fa-eye');
      $(this).removeClass('fa-eye-slash');
    }
  });

});