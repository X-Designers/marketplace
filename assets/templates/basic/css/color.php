<?php
header("Content-Type:text/css");
$color1 = $_GET['color1']; // Change your Color Here
$color2 = $_GET['color2']; // Change your Color Here

function checkhexcolor($color1){
    return preg_match('/^#[a-f0-9]{6}$/i', $color1);
}

if (isset($_GET['color1']) AND $_GET['color1'] != '') {
    $color1 = "#" . $_GET['color1'];
}

if (!$color1 OR !checkhexcolor($color1)) {
    $color1 = "#336699";
}

function checkhexcolor2($color2){
    return preg_match('/^#[a-f0-9]{6}$/i', $color2);
}

if (isset($_GET['color2']) AND $_GET['color2'] != '') {
    $color2 = "#" . $_GET['color2'];
}

if (!$color2 OR !checkhexcolor2($color2)) {
    $color2 = "#336699";
}
?>


a:hover, .custom--dropdown .dropdown-menu li .dropdown-item:hover, .page-breadcrumb li:first-child::before, .page-breadcrumb li a:hover, .cmn-list li::before, .read-btn, .read-btn:hover i, .btn-outline--base, .custom--checkbox input:checked ~ label::before, .header .main-menu li.menu_has_children:hover > a::before, .header .main-menu li a:hover, .header .main-menu li a:focus, .header .main-menu li .sub-menu li a:hover, .header .nav-right .header-serch-btn, .product-card__content p a:hover, .socail-list li a:hover, .product-details-meta.style--two li a:hover, .post-meta li a:hover, .read-more, .reply-btn, .user-nav-tabs .nav-item .nav-link.active, .sidebar .widget .search-form .search-btn, .sidebar .archive__list li a:hover, .product-price-form #product-price, .short-link-list li a:hover, .attachment-list a, .dropdown .dropdown-menu li .dropdown-item:hover {
    color: <?= $color1 ?>;
}

.text--base, a.text-white:hover,
.product-card.style--two .product-title a:hover,
.product-card.style--two .product-price {
    color: <?= $color1 ?> !important;
}


.preloader .preloader-container .animated-preloader, .preloader .preloader-container .animated-preloader:before, .ui-slider-range, .hero-search-form .hero-search-btn {
    background: <?= $color1 ?>;
}

.section-subtitle.border-left::before, .custom--accordion .accordion-button:not(.collapsed), .custom--nav-tabs.style--two .nav-item .nav-link.active::after, .pagination .page-item.active .page-link, .pagination .page-item .page-link:hover, .video--btn, .btn--base, .btn--base:hover, .read-btn:hover, .read-btn i, .btn-outline--base:hover, .icon-btn, .input-group .input-group-text, .custom-radio label::after, .select2-container--default .select2-results__option--highlighted[aria-selected], .header__top, .header .nav-right .header-top-search-area .header-search-form .header-search-btn, .product-card .tending-badge, .cart-btn, .card-view-btn-area button.active, .search-tab-menu li button.active, .product-thumb-slider-area .product-details-thumb .tending-badge-two, .subscribe-form button, .blog-details__thumb .post__date .date, .blog-details__footer .social__links li a:hover, .reply-btn:hover, .contact-form select option, .profile-thumb .avatar-edit label, .sidebar .widget .widget__title::after, .sidebar .tags a:hover, .action-sidebar-close, .action-sidebar-open, .product-widget-tags a:hover, .footer-widget .social-links li a:hover, .subscribe-form button, .cart-total-box, .custom--file-upload::before, .scroll-to-top, .ui-state-default, .testimonial-slider .slick-dots li.slick-active button, .action-widget.top-widget .action-widget__title {
    background-color: <?= $color1 ?>;
}

.bg--base {
    background-color: <?= $color1 ?> !important;
}

.custom--nav-tabs .nav-item .nav-link.active, .pagination .page-item .page-link:hover, .input-group .input-group-text, .custom-radio input[type=radio]:checked ~ label::before, .sidebar .tags a:hover, .footer-widget .social-links li a:hover, .it .form-control:focus, .custom--nav-tabs .nav-item .nav-link:hover {
    border-color :<?= $color1 ?>;
}

.border--base, .form--control:focus {
    border-color :<?= $color1 ?> !important;
}


.badge--base, .form--control, .btn-outline--base {
    border: 1px solid <?= $color1 ?>;
}

.d-widget {
    border-left: 3px solid <?= $color1 ?>;
}


.section--bg2, .custom--table thead, .select2-dropdown ::-webkit-scrollbar-thumb, .header__bottom, .laguage-select option, .hero::after, .serach-area, blockquote, .single-info__icon,  .footer-section, .withdraw-card, .withdraw-preview-sidebar {
    background-color: <?= $color2 ?>;
}

.user-area, .dashboard-area .tab-content-area, .user-sidebar {
    background-color: <?= $color2 ?>08;
}
.category-item:hover, .box--border {
    border-color: <?= $color1 ?>;
}

.box--shadow {
    box-shadow: 0 10px 25px <?= $color1 ?>15;
}

.custom--accordion .accordion-button {
    background-color: <?= $color1 ?>05;
}

.custom--accordion .accordion-item {
    border-color: <?= $color1 ?>50;
}

.btn--base2 {
    background-color: <?= $color1 ?>25;
    color: <?= $color1 ?> !important;
}

.btn--base2:hover {
    background-color: <?= $color1 ?>;
    color: #fff !important;
}

.feature-product-slider .slick-arrow:hover,
.product-card.style--two {
    background-color: <?= $color1 ?>;
}
.cart-btn {
    box-shadow: 0 5px 10px <?= $color1 ?>25;
}

.cart-btn:hover {
    box-shadow: 0 5px 10px <?= $color1 ?>35;
}
.product-card.style--two:hover {
    box-shadow: 0 0 15px 2px <?= $color1 ?>;
}