/**
 * Main
 */

'use strict';

let menu, animate;

(function () {
  // Button & Pagination Waves effect
  if (typeof Waves !== 'undefined') {
    Waves.init();
    Waves.attach(
      ".btn[class*='btn-']:not(.position-relative):not([class*='btn-outline-']):not([class*='btn-label-'])",
      ['waves-light']
    );
    Waves.attach("[class*='btn-outline-']:not(.position-relative)");
    Waves.attach('.pagination .page-item .page-link');
    Waves.attach('.dropdown-menu .dropdown-item');
    Waves.attach('.light-style .list-group .list-group-item-action');
    Waves.attach('.dark-style .list-group .list-group-item-action', ['waves-light']);
    Waves.attach('.nav-tabs:not(.nav-tabs-widget) .nav-item .nav-link');
    Waves.attach('.nav-pills .nav-item .nav-link', ['waves-light']);
    Waves.attach('.menu-vertical .menu-item .menu-link.menu-toggle');
  }

  // costume
  document.addEventListener('DOMContentLoaded', function () {
    const toastContainer = document.getElementById('toast-container');
    const toastElements = toastContainer.querySelectorAll('.toast');

    // Initialize all toasts
    toastElements.forEach(function (toastElement) {
      const toastInstance = new bootstrap.Toast(toastElement);
      toastInstance.show();
    });

    const greetingElement = document.getElementById('greeting');
    const currentHour = new Date().getHours();

    let greetingText;
    if (currentHour >= 5 && currentHour < 11) {
      greetingText = "Selamat Pagi";
    } else if (currentHour >= 11 && currentHour < 15) {
      greetingText = "Selamat Siang";
    } else if (currentHour >= 15 && currentHour < 18) {
      greetingText = "Selamat Sore";
    } else {
      greetingText = "Selamat Malam";
    }

    greetingElement ? greetingElement.innerHTML = `<span class="nav-link">${greetingText},</span>` : '';

    let minDate, maxDate;

    DataTable.ext.search.push(function (settings, data, dataIndex) {
      let min = minDate.val();
      let max = maxDate.val();
      let date = new Date(data[5]);

      if (
        (min === null && max === null) ||
        (min === null && date <= max) ||
        (min <= date && max === null) ||
        (min <= date && date <= max)
      ) {
        return true;
      }
      return false;
    });

    minDate = new DateTime('#min', {
      format: 'YYYY-MM-DD'
    });
    maxDate = new DateTime('#max', {
      format: 'YYYY-MM-DD'
    });

    $('.dataTable').each(function () {
      let table = new DataTable(this, {
        language: {
          search: '',
          searchPlaceholder: 'Cari Data...',
          emptyTable: 'Tidak ada data yang ditemukan',
          info: 'Menampilkan _START_ hingga _END_ dari _TOTAL_ data',
          infoEmpty: 'Menampilkan 0 hingga 0 dari 0 data',
          infoFiltered: '(difilter dari _MAX_ total data)',
          lengthMenu: 'Menampilkan _MENU_ data',
          loadingRecords: "Sedang Memuat...",
          zeroRecords: "Tidak ada data yang sesuai",
        },
        layout: {
          topStart: {
            buttons: [
              {
                extend: 'pageLength',
                text: function (dt) {
                  const pageLength = dt.page.len();
                  return `<i class="ri-file-list-3-line me-2"></i>${pageLength} Data`;
                },
                className: 'btn btn-primary dropdown-toggle me-2',
              },
              {
                text: '<i class="ri-external-link-line me-2"></i>Export Data',
                extend: 'collection',
                className: 'btn btn-primary dropdown-toggle me-2',
                buttons: [
                  {
                    extend: 'print',
                    text: '<i class="ri-printer-line me-4"></i>Print',
                    className: 'dropdown-item',
                    exportOptions: { columns: ':not(:last-child)', stripHtml: false }
                  },
                  {
                    extend: 'excel',
                    text: '<i class="ri-file-excel-line me-4"></i>Excel',
                    className: 'dropdown-item',
                    exportOptions: { columns: ':not(:last-child)', stripHtml: true }
                  },
                  {
                    extend: 'pdf',
                    text: '<i class="ri-file-pdf-line me-4"></i>Pdf',
                    className: 'dropdown-item',
                    exportOptions: { columns: ':not(:last-child)', stripHtml: true }
                  },
                  {
                    extend: 'csv',
                    text: '<i class="ri-file-text-line me-4"></i>Csv',
                    className: 'dropdown-item',
                    exportOptions: { columns: ':not(:last-child)', stripHtml: true }
                  },
                  {
                    extend: 'copy',
                    text: '<i class="ri-file-copy-line me-4"></i>Copy',
                    className: 'dropdown-item',
                    exportOptions: { columns: ':not(:last-child)', stripHtml: true }
                  }
                ]
              }
            ]
          }
        }
      })
      document.querySelectorAll('#min, #max').forEach((el) => {
        el.addEventListener('change', () => table.draw());
      });
    });
  });

  // end costume

  // Window scroll function for navbar
  function onScroll() {
    var layoutPage = document.querySelector('.layout-page');
    if (layoutPage) {
      if (window.pageYOffset > 0) {
        layoutPage.classList.add('window-scrolled');
      } else {
        layoutPage.classList.remove('window-scrolled');
      }
    }
  }
  // On load time out
  setTimeout(() => {
    onScroll();
  }, 200);

  // On window scroll
  window.onscroll = function () {
    onScroll();
  };

  // Initialize menu
  //-----------------

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive((animate = false));
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }

  // Display in main menu when menu scrolls
  let menuInnerContainer = document.getElementsByClassName('menu-inner'),
    menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  if (menuInnerContainer.length > 0 && menuInnerShadow) {
    menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
      if (this.querySelector('.ps__thumb-y').offsetTop) {
        menuInnerShadow.style.display = 'block';
      } else {
        menuInnerShadow.style.display = 'none';
      }
    });
  }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class and previous-active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
      e.target.closest('.accordion-item').previousElementSibling?.classList.add('previous-active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
      e.target.closest('.accordion-item').previousElementSibling?.classList.remove('previous-active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Nav tabs animation
  window.Helpers.navTabsAnimation();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
  window.Helpers.setCollapsed(true, false);
})();
