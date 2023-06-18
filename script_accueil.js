document.querySelector('.nav-links ul li:nth-child(3) a').addEventListener('click', function (event) {
    event.preventDefault();
    var banner = document.getElementById('tempBanner');
    banner.classList.toggle('show');
});

/* -> Select the consultation link
    -> event listener at link
    -> prevent the default action of a link (goes to URL)
    -> get the tempBanner element
    -> add the .show class to it or remove it (toggle mode)
    -> for the effect of making the banner appear
*/

