var $star_rating = $('.star-rating .fa');

var SetRatingStar = function() {
    return $star_rating.each(function() {
        if (parseInt($(this).siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
            return $(this).removeClass('fa-star-o').addClass('fa-star');
        } else {
            return $(this).removeClass('fa-star').addClass('fa-star-o');
        }
    });
};

$star_rating.on('click', function(e) {
    e.target.parentElement.children[5].value = $(this).data('rating');
    var $star = $('#' + e.target.id + '.fa');
    return $star.each(function() {
        if (parseInt($star.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
            return $(this).removeClass('fa-star-o').addClass('fa-star');
        } else {
            return $(this).removeClass('fa-star').addClass('fa-star-o');
        }
    });
});

SetRatingStar();
$(document).ready(function() {

});