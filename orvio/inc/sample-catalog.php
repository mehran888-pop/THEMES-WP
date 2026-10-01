<?php
/**
 * Demo catalog shared by the importer and the fallback homepage.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function orvio_sample_catalog() {
	return array(
		array( 'sku' => 'ORV-KT-014', 'fa' => 'کتری سرامیکی نُوا', 'en' => 'Nova Ceramic Kettle', 'cat' => 'home', 'price' => 2200000, 'sale' => 1890000, 'img' => 'assets/images/products/kettle.jpg', 'gallery' => array( 'assets/images/products/kettle-detail.jpg', 'assets/images/products/kettle-life.jpg' ), 'stock' => 8, 'rating' => true ),
		array( 'sku' => 'ORV-TP-008', 'fa' => 'قوری سرامیکی آرام', 'en' => 'Aram Ceramic Teapot', 'cat' => 'home', 'price' => 1420000, 'sale' => 0, 'img' => 'assets/images/products/kettle-side.jpg', 'gallery' => array(), 'stock' => 14 ),
		array( 'sku' => 'ORV-LP-021', 'fa' => 'چراغ رومیزی بلوط', 'en' => 'Oak Table Lamp', 'cat' => 'home', 'price' => 1650000, 'sale' => 0, 'img' => 'assets/images/products/lamp.jpg', 'gallery' => array(), 'stock' => 11 ),
		array( 'sku' => 'ORV-TW-033', 'fa' => 'سرویس سنگی میز', 'en' => 'Stoneware Table Set', 'cat' => 'home', 'price' => 2980000, 'sale' => 0, 'img' => 'assets/images/products/tableware.jpg', 'gallery' => array(), 'stock' => 6 ),
		array( 'sku' => 'ORV-CT-102', 'fa' => 'پالتو پشمی زغالی', 'en' => 'Charcoal Wool Coat', 'cat' => 'fashion', 'price' => 7900000, 'sale' => 6800000, 'img' => 'assets/images/products/coat.jpg', 'gallery' => array(), 'stock' => 4 ),
		array( 'sku' => 'ORV-SN-077', 'fa' => 'کتانی چرم کرم', 'en' => 'Cream Leather Sneaker', 'cat' => 'fashion', 'price' => 2240000, 'sale' => 0, 'img' => 'assets/images/products/sneaker.jpg', 'gallery' => array(), 'stock' => 18 ),
		array( 'sku' => 'ORV-HP-019', 'fa' => 'هدفون بی‌سیم آرام', 'en' => 'Aram Wireless Headphones', 'cat' => 'audio', 'price' => 3150000, 'sale' => 0, 'img' => 'assets/images/products/headphones.jpg', 'gallery' => array(), 'stock' => 9 ),
		array( 'sku' => 'ORV-CD-055', 'fa' => 'ست شمع دست‌ساز', 'en' => 'Handmade Candle Set', 'cat' => 'scent', 'price' => 920000, 'sale' => 780000, 'img' => 'assets/images/products/candle.jpg', 'gallery' => array(), 'stock' => 3 ),
		array( 'sku' => 'ORV-BG-004', 'fa' => 'کیف چرم هفته', 'en' => 'Weekender Leather Bag', 'cat' => 'travel', 'price' => 4200000, 'sale' => 0, 'img' => 'assets/images/products/bag.jpg', 'gallery' => array(), 'stock' => 5 ),
	);
}

function orvio_sample_categories() {
	return array(
		'home'    => array( 'fa' => 'خانه و دکور', 'en' => 'Home', 'img' => 'assets/images/categories/home.jpg' ),
		'fashion' => array( 'fa' => 'پوشاک', 'en' => 'Apparel', 'img' => 'assets/images/categories/fashion.jpg' ),
		'audio'   => array( 'fa' => 'صدا', 'en' => 'Audio', 'img' => 'assets/images/categories/audio.jpg' ),
		'scent'   => array( 'fa' => 'رایحه', 'en' => 'Scent', 'img' => 'assets/images/categories/scent.jpg' ),
		'travel'  => array( 'fa' => 'سفر', 'en' => 'Travel', 'img' => 'assets/images/categories/travel.jpg' ),
	);
}
