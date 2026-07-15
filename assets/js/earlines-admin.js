document.addEventListener('DOMContentLoaded', function () {

  // Sidebar "New Airline" quick form
  var toggle = document.getElementById('addAirlineToggle');
  var form = document.getElementById('addAirlineForm');
  if (toggle && form) {
    toggle.addEventListener('click', function () {
      form.classList.toggle('open');
    });
  }

  // Dashboard board tabs
  var tabButtons = document.querySelectorAll('[data-tab-target]');
  if (tabButtons.length) {
    tabButtons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var targetId = btn.getAttribute('data-tab-target');

        document.querySelectorAll('[data-tab-target]').forEach(function (b) {
          b.classList.remove('active');
        });
        document.querySelectorAll('.tab-panel').forEach(function (p) {
          p.classList.remove('active');
        });

        btn.classList.add('active');
        var panel = document.getElementById(targetId);
        if (panel) panel.classList.add('active');
      });
    });
  }

  // Board row action panels (custom, replaces Bootstrap dropdown)
  document.querySelectorAll('.row-actions-toggle').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      var panel = btn.nextElementSibling;
      var isOpen = panel.classList.contains('open');
      document.querySelectorAll('.row-actions-panel.open').forEach(function (p) {
        p.classList.remove('open');
      });
      if (!isOpen) panel.classList.add('open');
    });
  });
  document.addEventListener('click', function () {
    document.querySelectorAll('.row-actions-panel.open').forEach(function (p) {
      p.classList.remove('open');
    });
  });
  document.querySelectorAll('.row-actions-panel').forEach(function (panel) {
    panel.addEventListener('click', function (e) { e.stopPropagation(); });
  });

  // Confirm before destructive actions (delete flight / delete airline)
  document.querySelectorAll('form.confirm-delete').forEach(function (f) {
    f.addEventListener('submit', function (e) {
      var msg = f.getAttribute('data-confirm') || 'Are you sure?';
      if (!window.confirm(msg)) {
        e.preventDefault();
      }
    });
  });
});