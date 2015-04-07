function show_lightbox(location) {
   $('#player').attr('src', location);
   $('#lightbox').fadeIn(500);
}

function hide_lightbox() {
   $('#lightbox').fadeOut(500);
   $('#player').attr('src', '');
}
