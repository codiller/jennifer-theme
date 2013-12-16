jQuery(document).ready(function(e) {
  e(".menu-toggle").click(function() {
    e("#menu-primary-menu").slideToggle("fast", function() {
      return !1;
    });
  });
  e(".menu-toggle a").click(function(e) {
    e.preventDefault();
  });
});