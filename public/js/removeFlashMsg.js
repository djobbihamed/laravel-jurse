window.onload = function () {
    var alerts = document.querySelectorAll(".alert");
    function hideElement(element) {
        element.style.display = "none";
    }
    alerts.forEach(function (alert) {
        setTimeout(function () {
            hideElement(alert);
        }, 4000); // 4 seconds
    });
};
