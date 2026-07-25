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

  // Destination slideshow
  var slides = document.querySelectorAll('.el-slide');
  var dots = document.querySelectorAll('.el-slide-dots button');
  if (slides.length) {
    var current = 0;
    var timer;
    function showSlide(i) {
      slides.forEach(function (s) { s.classList.remove('active'); });
      dots.forEach(function (d) { d.classList.remove('active'); });
      slides[i].classList.add('active');
      if (dots[i]) dots[i].classList.add('active');
      current = i;
    }
    function nextSlide() { showSlide((current + 1) % slides.length); }
    function startTimer() { timer = setInterval(nextSlide, 4000); }
    function stopTimer() { clearInterval(timer); }
    dots.forEach(function (d, i) {
      d.addEventListener('click', function () { showSlide(i); stopTimer(); startTimer(); });
    });
    var slideshow = document.querySelector('.el-slideshow');
    if (slideshow) {
      slideshow.addEventListener('mouseenter', stopTimer);
      slideshow.addEventListener('mouseleave', startTimer);
    }
    showSlide(0);
    startTimer();
  }

  // Destination cards: reveal on scroll
  var destCards = document.querySelectorAll('.el-dest-card');
  if (destCards.length && 'IntersectionObserver' in window) {
    var destObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
          destObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });
    destCards.forEach(function (card) { destObserver.observe(card); });
  } else {
    destCards.forEach(function (card) { card.classList.add('in-view'); });
  }

  // Destination "search flights" buttons prefill the hero search
  document.querySelectorAll('.el-dest-cta').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var city = btn.getAttribute('data-city');
      var sel = document.getElementById('arr_city_r');
      if (sel) {
        for (var i = 0; i < sel.options.length; i++) {
          if (sel.options[i].value === city) { sel.selectedIndex = i; break; }
        }
      }
      window.scrollTo({ top: 0, behavior: 'smooth' });
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