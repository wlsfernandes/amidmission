/******/ (() => { // webpackBootstrap
  var __webpack_exports__ = {};
  /*!***********************************************!*\
    !*** ./resources/js/pages/datatables.init.js ***!
    \***********************************************/
  /*
  Template Name: Minible - Admin & Dashboard Template
  Author: Themesbrand
  Website: https://themesbrand.com/
  Contact: themesbrand@gmail.com
  File: Datatables Js File
  */

  $(document).ready(function () {
    $('.datatable-buttons').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy',
        'csv',
        'excel',
        'pdf',
        'print'
      ],
      responsive: true,
      ordering: true,
      pageLength: 25,
      lengthMenu: [10, 25, 50, 100]
    });
  });

  /******/
})()
  ;