$(function () {
  'use strict';

  var pageLoginForm = $('.auth-login-form');

  // jQuery Validation
  // --------------------------------------------------------------------
  if (pageLoginForm.length) {
    pageLoginForm.validate({
      rules: {
        'email': {
          required: true,
          email: true
        },
        'password': {
          required: true
        }
      }
    });
  }
});
