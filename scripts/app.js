(function () {


    
    document.addEventListener("DOMContentLoaded", function() {
        var btn = document.querySelector('#btn');
        var sidebar = document.querySelector('.sidebar');
        var pressstart = document.querySelector('.pressstart');

        btn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            pressstart.classList.toggle('opened');
        });
    });



})();



let marketButton =document.getElementById('market');


marketButton.addEventListener('click', () =>{
window.open('https://www.pricecharting.com/category/video-games', '_blank')
});