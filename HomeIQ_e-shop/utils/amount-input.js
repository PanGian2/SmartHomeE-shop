// Reduce the amount
document.querySelectorAll('.minus-btn').forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        var input = this.closest('div').querySelector('input');
        var value = parseInt(input.value);
        //value mustn't be bellow 1
        if (value > 2) {
            value = value - 1;
        } else {
            value = 1;
        }

        input.value = value;
    });
});

// Increase the amount
document.querySelectorAll('.plus-btn').forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        var input = this.closest('div').querySelector('input');
        var value = parseInt(input.value);
        //value mustn't be above input's max
        if (value < input.max) {
            value = value + 1;
        } else {
            value = input.max;
        }

        input.value = value;
    });
});