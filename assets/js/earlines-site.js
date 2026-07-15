document.addEventListener('DOMContentLoaded', function () {

  // Round-trip / one-way search tabs
  document.querySelectorAll('[data-el-tab-target]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var targetId = btn.getAttribute('data-el-tab-target');
      document.querySelectorAll('[data-el-tab-target]').forEach(function (b) { b.classList.remove('active'); });
      document.querySelectorAll('.el-search-panel').forEach(function (p) { p.classList.remove('active'); });
      btn.classList.add('active');
      var panel = document.getElementById(targetId);
      if (panel) panel.classList.add('active');
    });
  });

  // Passenger count steppers
  document.querySelectorAll('.el-stepper').forEach(function (stepper) {
    var input = stepper.querySelector('input[type=hidden]');
    var display = stepper.querySelector('.el-stepper-value');
    var minus = stepper.querySelector('.el-stepper-minus');
    var plus = stepper.querySelector('.el-stepper-plus');
    if (!input || !display) return;

    minus.addEventListener('click', function () {
      var val = parseInt(input.value, 10);
      if (val > 1) {
        val -= 1;
        input.value = val;
        display.textContent = val;
      }
    });
    plus.addEventListener('click', function () {
      var val = parseInt(input.value, 10) + 1;
      input.value = val;
      display.textContent = val;
    });
  });

  // Floating-label style focus toggling (kept from the original UX)
  document.querySelectorAll('.input-group input').forEach(function (inp) {
    inp.addEventListener('focus', function () {
      var lbl = document.querySelector("label[for='" + inp.id + "']");
      if (lbl) lbl.classList.add('animate-label');
    });
    inp.addEventListener('blur', function () {
      if (inp.value === '') {
        var lbl = document.querySelector("label[for='" + inp.id + "']");
        if (lbl) lbl.classList.remove('animate-label');
      }
    });
  });

  // Confirm before destructive actions (cancel ticket)
  document.querySelectorAll('form.confirm-delete').forEach(function (f) {
    f.addEventListener('submit', function (e) {
      var msg = f.getAttribute('data-confirm') || 'Are you sure?';
      if (!window.confirm(msg)) e.preventDefault();
    });
  });
});