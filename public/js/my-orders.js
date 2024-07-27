$(document).ready(function() {
    // When the modal is shown
    $('.modal').on('show.bs.modal', function () {
        $('body').addClass('allow-scroll'); // Add class to allow scrolling
    });

    // When the modal is hidden
    $('.modal').on('hidden.bs.modal', function () {
        $('body').removeClass('allow-scroll'); // Remove class to restore default behavior
    });
});