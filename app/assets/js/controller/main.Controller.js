const iconBars = window.document.getElementById('linkIconBar');
const dropdownContent = document.getElementById('dropdownContent');
const topNav = document.getElementById('topNav');
const topNavMobile = document.getElementById('topNavMobile');
const prev = window.document.getElementById('prev');
const next = window.document.getElementById('next');
let slideIndex = 1;

window.onload = function() {
    showSlides(slideIndex);
};

next.addEventListener('click', () => {
    showSlides((slideIndex += 1));
});

prev.addEventListener('click', () => {
    showSlides((slideIndex += -1));
});

iconBars.addEventListener('click', () => {
    dropdownContent.className === 'row-flex flex-direction-column dropdown-visible'
        ? noVisibleDropDown(dropdownContent)
        : visibleDropDown(dropdownContent);
});

const noVisibleDropDown = function(dropdownContent) {
    dropdownContent.classList.remove('dropdown-visible');
    dropdownContent.classList.add('dropdown-no-visible');
};

const visibleDropDown = function(dropdownContent) {
    dropdownContent.classList.remove('dropdown-no-visible');
    dropdownContent.classList.add('dropdown-visible');
};

const showSlides = function(n) {
    const slides = document.getElementsByClassName('mySlides');
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }
    slides[slideIndex - 1].style.display = 'grid';
};

function myMap() {
    myCenter = new google.maps.LatLng(36.906019, -4.371339);
    const mapOptions = {
        center: myCenter,
        zoom: 15,
        scrollwheel: false,
        draggable: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    const map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

    const marker = new google.maps.Marker({
        position: myCenter,
    });
    marker.setMap(map);
}

window.onscroll = function() {
    if (document.documentElement.scrollTop > 100) {
        topNav.className = 'top-nav hide-in-movil-only show-in-elsewhere appear-sand-changes-color';
        topNavMobile.className =
            'top-nav top-nav-mobile show-in-movil-only hide-in-elsewhere font-resize appear-sand-changes-color';
        return;
    }

    topNav.className = 'top-nav hide-in-movil-only show-in-elsewhere';
    topNavMobile.className = 'top-nav top-nav-mobile show-in-movil-only hide-in-elsewhere font-resize';
};
