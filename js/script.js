jQuery(function() {
    jQuery("#slides").slidesjs({
        width: 600,
        height: 280,
        play: {
                  active: false,
                  auto: true,
                  interval: 4000,
                  swap: true,
                  pauseOnHover: false,
                  restartDelay: 2500
                }
    });
});