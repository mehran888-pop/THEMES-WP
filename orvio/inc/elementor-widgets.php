<?php
/**
 * Orvio Elementor widgets.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Orvio_Widget_Base extends \Elementor\Widget_Base {
	public function get_categories() {
		return array( 'orvio' );
	}
	public function get_icon() {
		return 'eicon-star';
	}

	protected function orvio_register_style( $selector = '{{WRAPPER}}' ) {
		$text = $selector . ', ' . $selector . ' p, ' . $selector . ' li, ' . $selector . ' a, ' . $selector . ' span';
		$btn  = $selector . ' .orvio-btn, ' . $selector . ' button';
		$this->start_controls_section( 'orvio_style', array(
			'label' => orvio_t( 'Box', 'جعبه' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );
		if ( class_exists( '\Elementor\Group_Control_Typography' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
				'name'     => 'orvio_typo',
				'label'    => orvio_t( 'Typography', 'تایپوگرافی' ),
				'selector' => $text,
			) );
		}
		$this->add_control( 'orvio_color', array(
			'label'     => orvio_t( 'Text color', 'رنگ متن' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $text => 'color: {{VALUE}};' ),
		) );
		$this->add_responsive_control( 'orvio_align', array(
			'label'     => orvio_t( 'Alignment', 'تراز' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => array(
				'right'  => array( 'title' => orvio_t( 'Right', 'راست' ), 'icon' => 'eicon-text-align-right' ),
				'center' => array( 'title' => orvio_t( 'Center', 'وسط' ), 'icon' => 'eicon-text-align-center' ),
				'left'   => array( 'title' => orvio_t( 'Left', 'چپ' ), 'icon' => 'eicon-text-align-left' ),
			),
			'selectors' => array( $selector => 'text-align: {{VALUE}};' ),
		) );
		if ( class_exists( '\Elementor\Group_Control_Background' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
				'name'     => 'orvio_background',
				'label'    => orvio_t( 'Background', 'پس‌زمینه' ),
				'selector' => $selector,
			) );
		}
		if ( class_exists( '\Elementor\Group_Control_Border' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
				'name'     => 'orvio_border',
				'selector' => $selector,
			) );
		}
		if ( class_exists( '\Elementor\Group_Control_Box_Shadow' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
				'name'     => 'orvio_shadow',
				'selector' => $selector,
			) );
		}
		$this->add_responsive_control( 'orvio_pad', array(
			'label'      => orvio_t( 'Padding', 'فاصله داخلی' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em', '%' ),
			'selectors'  => array( $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
		) );
		$this->add_responsive_control( 'orvio_margin', array(
			'label'      => orvio_t( 'Margin', 'فاصله بیرونی' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em', '%' ),
			'selectors'  => array( $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
		) );
		$this->add_responsive_control( 'orvio_radius', array(
			'label'      => orvio_t( 'Radius', 'گردی گوشه' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px', '%' ),
			'range'      => array( 'px' => array( 'min' => 0, 'max' => 48 ) ),
			'selectors'  => array( $selector => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;' ),
		) );
		$this->end_controls_section();

		$this->start_controls_section( 'orvio_style_hover', array(
			'label' => orvio_t( 'Hover', 'هاور' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );
		$this->add_control( 'orvio_hover_color', array(
			'label'     => orvio_t( 'Text', 'متن' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $selector . ':hover, ' . $selector . ':hover a' => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'orvio_hover_bg', array(
			'label'     => orvio_t( 'Background', 'پس‌زمینه' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $selector . ':hover' => 'background-color: {{VALUE}};' ),
		) );
		$this->add_control( 'orvio_hover_border', array(
			'label'     => orvio_t( 'Border', 'حاشیه' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $selector . ':hover' => 'border-color: {{VALUE}};' ),
		) );
		$this->end_controls_section();

		$this->start_controls_section( 'orvio_style_heading', array(
			'label' => orvio_t( 'Heading', 'عنوان' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );
		if ( class_exists( '\Elementor\Group_Control_Typography' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
				'name'     => 'orvio_head_typo',
				'selector' => $selector . ' h1, ' . $selector . ' h2, ' . $selector . ' h3, ' . $selector . ' .orvio-card__title',
			) );
		}
		$this->add_control( 'orvio_head_color', array(
			'label'     => orvio_t( 'Color', 'رنگ' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $selector . ' h1, ' . $selector . ' h2, ' . $selector . ' h3, ' . $selector . ' .orvio-card__title' => 'color: {{VALUE}};' ),
		) );
		$this->add_responsive_control( 'orvio_head_space', array(
			'label'      => orvio_t( 'Spacing', 'فاصله' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 0, 'max' => 48 ) ),
			'selectors'  => array( $selector . ' h1, ' . $selector . ' h2, ' . $selector . ' h3' => 'margin-bottom: {{SIZE}}{{UNIT}};' ),
		) );
		$this->end_controls_section();

		$this->start_controls_section( 'orvio_style_btn', array(
			'label' => orvio_t( 'Button', 'دکمه' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );
		if ( class_exists( '\Elementor\Group_Control_Typography' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
				'name'     => 'orvio_btn_typo',
				'selector' => $btn,
			) );
		}
		$this->start_controls_tabs( 'orvio_btn_tabs' );
		$this->start_controls_tab( 'orvio_btn_normal', array( 'label' => orvio_t( 'Normal', 'عادی' ) ) );
		$this->add_control( 'orvio_btn_color', array(
			'label'     => orvio_t( 'Text', 'متن' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $btn => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'orvio_btn_bg', array(
			'label'     => orvio_t( 'Background', 'پس‌زمینه' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $btn => 'background-color: {{VALUE}};' ),
		) );
		$this->end_controls_tab();
		$this->start_controls_tab( 'orvio_btn_hover', array( 'label' => orvio_t( 'Hover', 'هاور' ) ) );
		$this->add_control( 'orvio_btn_color_h', array(
			'label'     => orvio_t( 'Text', 'متن' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $btn . ':hover' => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'orvio_btn_bg_h', array(
			'label'     => orvio_t( 'Background', 'پس‌زمینه' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $btn . ':hover' => 'background-color: {{VALUE}};' ),
		) );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control( 'orvio_btn_pad', array(
			'label'      => orvio_t( 'Padding', 'فاصله داخلی' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em' ),
			'selectors'  => array( $btn => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			'separator'  => 'before',
		) );
		$this->add_responsive_control( 'orvio_btn_radius', array(
			'label'      => orvio_t( 'Radius', 'گردی' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
			'selectors'  => array( $btn => 'border-radius: {{SIZE}}{{UNIT}};' ),
		) );
		$this->end_controls_section();
	}

	protected function orvio_register_header_button_style( $selector = '{{WRAPPER}} .orvio-tool' ) {
		$this->start_controls_section( 'orvio_header_button_style', array(
			'label' => orvio_t( 'Button preset', 'قالب دکمه' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );
		$this->add_control( 'orvio_button_preset', array(
			'label'   => orvio_t( 'Preset', 'قالب آماده' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''        => orvio_t( 'Use button setting', 'استفاده از تنظیمات دکمه' ),
				'minimal' => orvio_t( 'Minimal', 'مینیمال' ),
				'pill'    => orvio_t( 'Pill', 'گرد' ),
				'solid'   => orvio_t( 'Solid', 'پر' ),
				'outline' => orvio_t( 'Outline', 'خطی' ),
				'soft'    => orvio_t( 'Soft', 'نرم' ),
			),
		) );
		if ( class_exists( '\Elementor\Group_Control_Typography' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'orvio_header_button_typo', 'selector' => $selector ) );
		}
		$this->add_control( 'orvio_header_button_color', array( 'label' => orvio_t( 'Text color', 'رنگ متن' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $selector => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'orvio_header_button_bg', array( 'label' => orvio_t( 'Background', 'پس‌زمینه' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $selector => 'background-color: {{VALUE}};' ) ) );
		$this->add_control( 'orvio_header_button_border', array( 'label' => orvio_t( 'Border', 'حاشیه' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $selector => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'orvio_header_button_radius', array( 'label' => orvio_t( 'Radius', 'گردی' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( $selector => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function orvio_register_part( $id, $label, $selector ) {
		$this->start_controls_section( 'orvio_part_' . $id, array(
			'label' => $label,
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );
		if ( class_exists( '\Elementor\Group_Control_Typography' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
				'name'     => 'orvio_part_typo_' . $id,
				'selector' => $selector,
			) );
		}
		$this->add_control( 'orvio_part_color_' . $id, array(
			'label'     => orvio_t( 'Color', 'رنگ' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $selector => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'orvio_part_bg_' . $id, array(
			'label'     => orvio_t( 'Background', 'پس‌زمینه' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $selector => 'background-color: {{VALUE}};' ),
		) );
		$this->add_responsive_control( 'orvio_part_pad_' . $id, array(
			'label'      => orvio_t( 'Padding', 'فاصله داخلی' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em' ),
			'selectors'  => array( $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
		) );
		$this->end_controls_section();
	}
}

class Orvio_Widget_Products extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-products'; }
	public function get_title() { return orvio_t( 'Product display', 'نمایش کالا' ); }
	public function get_icon() { return 'eicon-products'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Products', 'کالاها' ) ) );
		$this->add_control( 'heading', array( 'label' => orvio_t( 'Heading', 'عنوان' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'The edit', 'ویترین' ) ) );
		$this->add_control( 'source', array(
			'label'   => orvio_t( 'Source', 'منبع' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'latest',
			'options' => array(
				'latest'      => orvio_t( 'Latest', 'جدیدترین' ),
				'recommended' => orvio_t( 'Recommended', 'پیشنهادی' ),
				'featured'    => orvio_t( 'Featured', 'ویژه' ),
				'best'        => orvio_t( 'Best rated', 'پربازدید و امتیاز بالا' ),
				'sale'        => orvio_t( 'Sale / deals', 'تخفیف و پیشنهاد ویژه' ),
				'category'    => orvio_t( 'Category', 'دسته' ),
			),
		) );
		$this->add_control( 'category', array( 'label' => orvio_t( 'Category slug', 'نامک دسته' ), 'type' => \Elementor\Controls_Manager::TEXT, 'condition' => array( 'source' => 'category' ) ) );
		$this->add_control( 'limit', array( 'label' => orvio_t( 'Count', 'تعداد' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 8, 'min' => 1, 'max' => 36 ) );
		$this->add_control( 'columns', array( 'label' => orvio_t( 'Columns', 'ستون' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'options' => array( '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' ) ) );
		$this->add_control( 'layout', array(
			'label'   => orvio_t( 'Layout', 'چیدمان' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'grid',
			'options' => array(
				'grid'      => orvio_t( 'Grid', 'شبکه' ),
				'bento'     => orvio_t( 'Bento editorial', 'بنتو ادیتوریال' ),
				'masonry'   => orvio_t( 'Masonry', 'ماسونری' ),
				'showcase'  => orvio_t( 'Featured showcase', 'نمایش ویژه' ),
				'list'      => orvio_t( 'List', 'فهرست' ),
				'compact'   => orvio_t( 'Compact', 'فشرده' ),
				'grouped'   => orvio_t( 'Grouped by category', 'گروه‌بندی بر اساس دسته' ),
				'carousel'  => orvio_t( 'Carousel', 'چرخ فلک' ),
			),
		) );
		$this->add_control( 'card', array(
			'label'   => orvio_t( 'Card style', 'مدل کارت' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'classic',
			'options' => array(
				'classic'   => orvio_t( 'Classic', 'کلاسیک' ),
				'minimal'   => orvio_t( 'Minimal', 'مینیمال' ),
				'overlay'   => orvio_t( 'Overlay', 'روی تصویر' ),
				'editorial' => orvio_t( 'Editorial', 'ادیتوریال' ),
				'deal'      => orvio_t( 'Deal', 'تخفیف' ),
				'polaroid'  => orvio_t( 'Polaroid', 'پولاروید' ),
				'magazine'  => orvio_t( 'Magazine', 'مجله‌ای' ),
			),
		) );
		$this->add_control( 'atc', array(
			'label'   => orvio_t( 'Add to cart button', 'دکمه افزودن به سبد' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''        => orvio_t( 'Theme default', 'پیش‌فرض قالب' ),
				'pill'    => orvio_t( 'Pill', 'گرد' ),
				'block'   => orvio_t( 'Full width', 'تمام‌عرض' ),
				'outline' => orvio_t( 'Outline', 'خطی' ),
				'soft'    => orvio_t( 'Soft', 'نرم' ),
			),
		) );
		$this->add_control( 'atc_visual', array(
			'label'   => orvio_t( 'Add-to-cart visual', 'حالت نمایش افزودن به سبد' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => array( '' => orvio_t( 'Theme default', 'پیش‌فرض قالب' ), 'text' => orvio_t( 'Text', 'متن' ), 'icon' => orvio_t( 'Icon + text', 'آیکن و متن' ), 'hover' => orvio_t( 'Text on hover', 'متن در هاور' ), 'tile' => orvio_t( 'Tile below image', 'کاشی زیر تصویر' ), 'icon-only' => orvio_t( 'Icon only', 'فقط آیکن' ) ),
		) );
		$this->add_control( 'atc_behavior', array(
			'label'   => orvio_t( 'After add to cart', 'رفتار بعد از افزودن به سبد' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => array( '' => orvio_t( 'Theme default', 'پیش‌فرض قالب' ), 'ajax-stay' => orvio_t( 'Stay on page', 'ماندن در صفحه' ), 'cart' => orvio_t( 'Go to cart', 'انتقال به سبد' ), 'checkout' => orvio_t( 'Go to checkout', 'انتقال به تسویه حساب' ) ),
		) );
		$this->add_control( 'card_content', array(
			'label'   => orvio_t( 'Product information layout', 'چیدمان اطلاعات محصول' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'below',
			'options' => array( 'below' => orvio_t( 'Name, price and button below image', 'نام، قیمت و دکمه زیر تصویر' ), 'tile' => orvio_t( 'Tile', 'کاشی' ), 'hover-info' => orvio_t( 'Information on hover', 'اطلاعات در هاور' ), 'hover-overlay' => orvio_t( 'Overlay information on hover', 'اطلاعات روی تصویر در هاور' ) ),
		) );
		$this->add_control( 'hover_effect', array(
			'label'   => orvio_t( 'Card hover effect', 'افکت هاور کارت' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'lift',
			'options' => array(
				'none'    => orvio_t( 'None', 'بدون افکت' ),
				'lift'    => orvio_t( 'Lift + shadow', 'بالا آمدن و سایه' ),
				'zoom'    => orvio_t( 'Image zoom', 'زوم تصویر' ),
				'reveal'  => orvio_t( 'Reveal action', 'نمایش دکمه' ),
				'glow'    => orvio_t( 'Accent glow', 'درخشش رنگ تأکید' ),
				'overlay' => orvio_t( 'Image overlay', 'روکش تصویر' ),
			),
		) );
		$this->add_control( 'media_ratio', array(
			'label'   => orvio_t( 'Image ratio', 'نسبت تصویر' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'square',
			'options' => array(
				'square'    => orvio_t( 'Square', 'مربع' ),
				'portrait'  => orvio_t( 'Portrait', 'عمودی' ),
				'landscape' => orvio_t( 'Landscape', 'افقی' ),
				'auto'      => orvio_t( 'Theme default', 'پیش‌فرض قالب' ),
			),
		) );
		$this->add_control( 'sale_end', array( 'label' => orvio_t( 'Deal ends', 'پایان پیشنهاد' ), 'type' => \Elementor\Controls_Manager::DATE_TIME, 'condition' => array( 'source' => 'sale' ) ) );
		$this->add_control( 'car_cols', array( 'label' => orvio_t( 'Visible slides', 'تعداد اسلاید قابل نمایش' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 4, 'min' => 1, 'max' => 6, 'condition' => array( 'layout' => 'carousel' ) ) );
		$this->add_control( 'car_gap', array( 'label' => orvio_t( 'Carousel gap', 'فاصله کروسل' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 16, 'min' => 0, 'max' => 48, 'condition' => array( 'layout' => 'carousel' ) ) );
		$this->add_control( 'car_auto', array( 'label' => orvio_t( 'Autoplay milliseconds', 'پخش خودکار (میلی‌ثانیه)' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 0, 'min' => 0, 'max' => 12000, 'condition' => array( 'layout' => 'carousel' ) ) );
		$this->add_control( 'car_loop', array( 'label' => orvio_t( 'Loop', 'حلقه' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes', 'condition' => array( 'layout' => 'carousel' ) ) );
		$this->add_control( 'car_arrows', array( 'label' => orvio_t( 'Show arrows', 'نمایش فلش‌ها' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes', 'condition' => array( 'layout' => 'carousel' ) ) );
		$this->add_control( 'car_dots', array( 'label' => orvio_t( 'Show dots', 'نمایش نقطه‌ها' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes', 'condition' => array( 'layout' => 'carousel' ) ) );
		$this->end_controls_section();
		$this->start_controls_section( 'orvio_products_surface', array(
			'label' => orvio_t( 'Product cards', 'کارت‌های محصول' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );
		if ( class_exists( '\Elementor\Group_Control_Background' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
				'name'     => 'orvio_products_section_background',
				'label'    => orvio_t( 'Section background', 'پس‌زمینه بخش' ),
				'selector' => '{{WRAPPER}} .orvio-el-products',
			) );
			$this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
				'name'     => 'orvio_products_card_background',
				'label'    => orvio_t( 'Card background', 'پس‌زمینه کارت' ),
				'selector' => '{{WRAPPER}} .orvio-el-products .orvio-card',
			) );
			$this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
				'name'     => 'orvio_products_card_hover_background',
				'label'    => orvio_t( 'Card hover background', 'پس‌زمینه کارت در هاور' ),
				'selector' => '{{WRAPPER}} .orvio-el-products .orvio-card:hover',
			) );
		}
		if ( class_exists( '\Elementor\Group_Control_Border' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
				'name'     => 'orvio_products_card_border',
				'label'    => orvio_t( 'Card border', 'حاشیه کارت' ),
				'selector' => '{{WRAPPER}} .orvio-el-products .orvio-card',
			) );
		}
		if ( class_exists( '\Elementor\Group_Control_Box_Shadow' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
				'name'     => 'orvio_products_card_shadow',
				'label'    => orvio_t( 'Card shadow', 'سایه کارت' ),
				'selector' => '{{WRAPPER}} .orvio-el-products .orvio-card',
			) );
			$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
				'name'     => 'orvio_products_card_hover_shadow',
				'label'    => orvio_t( 'Hover shadow', 'سایه در هاور' ),
				'selector' => '{{WRAPPER}} .orvio-el-products .orvio-card:hover',
			) );
		}
		$this->add_control( 'orvio_products_card_text', array(
			'label'     => orvio_t( 'Card text color', 'رنگ متن کارت' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .orvio-el-products .orvio-card__body, {{WRAPPER}} .orvio-el-products .orvio-card__title a' => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'orvio_products_card_hover_text', array(
			'label'     => orvio_t( 'Hover text color', 'رنگ متن در هاور' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .orvio-el-products .orvio-card:hover .orvio-card__body, {{WRAPPER}} .orvio-el-products .orvio-card:hover .orvio-card__title a' => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'orvio_products_media_overlay', array(
			'label'     => orvio_t( 'Image overlay color', 'رنگ روکش تصویر' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .orvio-el-products .orvio-card__media::after' => 'background-color: {{VALUE}};' ),
		) );
		$this->add_responsive_control( 'orvio_products_card_radius', array(
			'label'      => orvio_t( 'Card radius', 'گردی کارت' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px', '%' ),
			'range'      => array( 'px' => array( 'min' => 0, 'max' => 48 ) ),
			'selectors'  => array( '{{WRAPPER}} .orvio-el-products .orvio-card' => 'border-radius: {{SIZE}}{{UNIT}};' ),
		) );
		$this->add_responsive_control( 'orvio_products_card_gap', array(
			'label'      => orvio_t( 'Card gap', 'فاصله کارت‌ها' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 0, 'max' => 64 ) ),
			'selectors'  => array(
				'{{WRAPPER}} .orvio-el-products .orvio-grid'           => 'gap: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .orvio-el-products .orvio-carousel__track' => 'gap: {{SIZE}}{{UNIT}};',
			),
		) );
		$this->add_responsive_control( 'orvio_products_card_padding', array(
			'label'      => orvio_t( 'Card content padding', 'فاصله داخلی محتوای کارت' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em', '%' ),
			'selectors'  => array( '{{WRAPPER}} .orvio-el-products .orvio-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
		) );
		$this->add_responsive_control( 'orvio_products_card_align', array(
			'label'     => orvio_t( 'Card content alignment', 'تراز محتوای کارت' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => array(
				'left'   => array( 'title' => orvio_t( 'Left', 'چپ' ), 'icon' => 'eicon-text-align-left' ),
				'center' => array( 'title' => orvio_t( 'Center', 'وسط' ), 'icon' => 'eicon-text-align-center' ),
				'right'  => array( 'title' => orvio_t( 'Right', 'راست' ), 'icon' => 'eicon-text-align-right' ),
			),
			'selectors' => array( '{{WRAPPER}} .orvio-el-products .orvio-card__body' => 'text-align: {{VALUE}};' ),
		) );
		$this->end_controls_section();
		$this->orvio_register_style();
		$this->orvio_register_part( 'title', orvio_t( 'Card title', 'عنوان کارت' ), '{{WRAPPER}} .orvio-card__title, {{WRAPPER}} .orvio-card__title a' );
		$this->orvio_register_part( 'price', orvio_t( 'Price', 'قیمت' ), '{{WRAPPER}} .orvio-price' );
	}
	protected function render() {
		if ( ! function_exists( 'wc_get_product' ) ) {
			echo '<p class="orvio-note">' . esc_html( orvio_t( 'WooCommerce is required.', 'ووکامرس لازم است.' ) ) . '</p>';
			return;
		}
		$s = $this->get_settings_for_display();
		$source = $s['source'] ?? 'latest';
		if ( 'orvio-deals' === $this->get_name() ) {
			$source = 'sale';
		} elseif ( 'orvio-recommended' === $this->get_name() ) {
			$source = 'recommended';
		}
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => max( 1, (int) ( $s['limit'] ?? 8 ) ),
			'post_status'    => 'publish',
		);
		if ( in_array( $source, array( 'featured', 'recommended' ), true ) ) {
			$args['tax_query'] = array( array( 'taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured' ) );
		} elseif ( 'best' === $source ) {
			$args['meta_key'] = '_wc_average_rating';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
		} elseif ( 'sale' === $source ) {
			$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
			$args['orderby']  = 'post__in';
		} elseif ( 'category' === $source && ! empty( $s['category'] ) ) {
			$args['tax_query'] = array( array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => sanitize_title( $s['category'] ) ) );
		}
		$q = new WP_Query( $args );
		$products = array();
		foreach ( $q->posts as $post ) {
			$product = wc_get_product( $post->ID );
			if ( $product && $product->is_visible() ) {
				$products[] = $product;
			}
		}
		wp_reset_postdata();
		$layouts = array( 'grid', 'bento', 'masonry', 'showcase', 'list', 'compact', 'grouped', 'carousel' );
		$hover_effects = array( 'none', 'lift', 'zoom', 'reveal', 'glow', 'overlay' );
		$media_ratios = array( 'square', 'portrait', 'landscape', 'auto' );
		$layout = in_array( $s['layout'] ?? '', $layouts, true ) ? $s['layout'] : 'grid';
		$hover  = in_array( $s['hover_effect'] ?? '', $hover_effects, true ) ? $s['hover_effect'] : 'lift';
		$ratio  = in_array( $s['media_ratio'] ?? '', $media_ratios, true ) ? $s['media_ratio'] : 'square';
		$card   = in_array( $s['card'] ?? '', array( 'classic', 'minimal', 'overlay', 'editorial', 'deal', 'polaroid', 'magazine' ), true ) ? $s['card'] : 'classic';
		$content = in_array( $s['card_content'] ?? '', array( 'below', 'tile', 'hover-info', 'hover-overlay' ), true ) ? $s['card_content'] : 'below';
		$visual = in_array( $s['atc_visual'] ?? '', array( 'text', 'icon', 'hover', 'tile', 'icon-only' ), true ) ? $s['atc_visual'] : '';
		$behavior = in_array( $s['atc_behavior'] ?? '', array( 'ajax-stay', 'cart', 'checkout' ), true ) ? $s['atc_behavior'] : '';
		$atc    = in_array( $s['atc'] ?? '', array( 'pill', 'block', 'outline', 'soft' ), true ) ? $s['atc'] : '';
		$sale_end = ! empty( $s['sale_end'] ) ? $s['sale_end'] : ( $s['deal_end'] ?? '' );
		$classes = array( 'orvio-section', 'orvio-el-products', 'orvio-cards-' . $card, 'orvio-products-layout-' . $layout, 'orvio-products-hover-' . $hover, 'orvio-products-ratio-' . $ratio, 'orvio-products-card-content-' . $content, 'orvio-products-atc-visual-' . ( $visual ?: 'theme' ) );
		if ( $atc ) {
			$classes[] = 'orvio-atc-' . $atc;
		}
		echo '<section class="' . esc_attr( implode( ' ', $classes ) ) . '">';
		if ( ! empty( $s['heading'] ) || ( 'sale' === $source && ! empty( $sale_end ) ) ) {
			echo '<div class="orvio-section__head"><h2>' . esc_html( $s['heading'] ?? '' ) . '</h2>';
			if ( 'sale' === $source && ! empty( $sale_end ) ) {
				echo '<span class="orvio-section__timer">' . esc_html( orvio_t( 'Ends in', 'پایان پیشنهاد' ) ) . ' <span class="orvio-timer" data-orvio-timer="' . esc_attr( $sale_end ) . '">' . esc_html( $sale_end ) . '</span></span>';
			}
			echo '</div>';
		}
		$render_grid = function ( $items, $extra = '' ) use ( $s, $content, $visual, $behavior ) {
			$cols = max( 1, min( 6, (int) ( $s['columns'] ?? 4 ) ) );
			echo '<div class="orvio-grid' . esc_attr( $extra ) . '" style="--cols:' . esc_attr( $cols ) . '">';
			foreach ( $items as $product ) {
				orvio_wc_card( $product, array( 'card_content' => $content, 'atc_visual' => $visual, 'atc_behavior' => $behavior ) );
			}
			echo '</div>';
		};
		if ( 'carousel' === $layout ) {
			$cols = max( 1, min( 6, (int) ( $s['car_cols'] ?? 4 ) ) );
			$gap = max( 0, min( 48, (int) ( $s['car_gap'] ?? 16 ) ) );
			$loop = ! empty( $s['car_loop'] ) && 'no' !== $s['car_loop'];
			echo '<div class="orvio-carousel" data-carousel data-cols="' . esc_attr( $cols ) . '" data-gap="' . esc_attr( $gap ) . '" data-autoplay="' . esc_attr( (int) ( $s['car_auto'] ?? 0 ) ) . '" data-loop="' . ( $loop ? '1' : '0' ) . '" style="--carousel-cols:' . esc_attr( $cols ) . ';--carousel-gap:' . esc_attr( $gap ) . 'px;">';
			if ( empty( $s['car_arrows'] ) || 'yes' === $s['car_arrows'] ) {
				echo '<div class="orvio-carousel__nav"><button type="button" data-prev aria-label="' . esc_attr( orvio_t( 'Previous', 'قبلی' ) ) . '">' . orvio_icon( 'chev' ) . '</button><button type="button" data-next aria-label="' . esc_attr( orvio_t( 'Next', 'بعدی' ) ) . '">' . orvio_icon( 'chev' ) . '</button></div>';
			}
			echo '<div class="orvio-carousel__view"><div class="orvio-carousel__track">';
			foreach ( $products as $product ) {
				orvio_wc_card( $product, array( 'card_content' => $content, 'atc_visual' => $visual, 'atc_behavior' => $behavior ) );
			}
			echo '</div></div>';
			if ( empty( $s['car_dots'] ) || 'yes' === $s['car_dots'] ) {
				echo '<div class="orvio-carousel__dots" data-dots></div>';
			}
			echo '</div>';
		} elseif ( 'showcase' === $layout && ! empty( $products ) ) {
			$featured = $products[0];
			echo '<div class="orvio-products-showcase"><div class="orvio-products-showcase__feature">';
			orvio_wc_card( $featured, array( 'card_content' => $content, 'atc_visual' => $visual, 'atc_behavior' => $behavior ) );
			echo '</div><div class="orvio-products-showcase__grid-wrap">';
			$render_grid( array_slice( $products, 1 ), ' orvio-products-showcase__grid' );
			echo '</div></div>';
		} elseif ( 'grouped' === $layout ) {
			$groups = array();
			foreach ( $products as $product ) {
				$terms = get_the_terms( $product->get_id(), 'product_cat' );
				$name = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : orvio_t( 'Products', 'محصولات' );
				$groups[ $name ][] = $product;
			}
			echo '<div class="orvio-group">';
			foreach ( $groups as $name => $items ) {
				echo '<section><div class="orvio-group__head"><h3>' . esc_html( $name ) . '</h3></div>';
				$render_grid( $items );
				echo '</section>';
			}
			echo '</div>';
		} else {
			$extra = 'list' === $layout ? ' is-list' : ( 'compact' === $layout ? ' is-compact' : '' );
			$render_grid( $products, $extra );
		}
		echo '</section>';
	}
}

class Orvio_Widget_Deals extends Orvio_Widget_Products {
	public function get_name() { return 'orvio-deals'; }
	public function get_title() { return orvio_t( 'Sale products with timer', 'محصولات تخفیف‌دار با تایمر' ); }
	public function get_icon() { return 'eicon-countdown'; }
	protected function register_controls() {
		parent::register_controls();
		$this->start_controls_section( 'deal_settings', array( 'label' => orvio_t( 'Deal timer', 'تایمر پیشنهاد' ) ) );
		$this->add_control( 'deal_end', array( 'label' => orvio_t( 'Deal ends', 'پایان پیشنهاد' ), 'type' => \Elementor\Controls_Manager::DATE_TIME ) );
		$this->end_controls_section();
	}
}

class Orvio_Widget_Recommended extends Orvio_Widget_Products {
	public function get_name() { return 'orvio-recommended'; }
	public function get_title() { return orvio_t( 'Recommended products', 'محصولات پیشنهادی' ); }
	public function get_icon() { return 'eicon-star'; }
}

class Orvio_Widget_Banner extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-product-banner'; }
	public function get_title() { return orvio_t( 'Creative product banner', 'بنر خلاق محصول' ); }
	public function get_icon() { return 'eicon-banner'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Banner', 'بنر' ) ) );
		$this->add_control( 'model', array( 'label' => orvio_t( 'Model', 'مدل' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'split', 'options' => array( 'split' => orvio_t( 'Split', 'اسپلیت' ), 'overlay' => orvio_t( 'Overlay', 'پوششی' ), 'duo' => orvio_t( 'Duo', 'دوگانه' ), 'card' => orvio_t( 'Card', 'کارتی' ), 'ribbon' => orvio_t( 'Ribbon', 'نواری' ), 'product' => orvio_t( 'Product spotlight', 'محصول ویژه' ) ) ) );
		$this->add_control( 'size', array( 'label' => orvio_t( 'Banner size', 'سایز بنر' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'full', 'options' => array( 'full' => orvio_t( 'Full', 'کامل' ), 'wide' => orvio_t( 'Wide', 'عریض' ), 'medium' => orvio_t( 'Medium', 'متوسط' ), 'small' => orvio_t( 'Small strip', 'نواری کوچک' ) ) ) );
		$product_options = array( '' => orvio_t( 'Choose a product', 'انتخاب محصول' ) );
		if ( function_exists( 'wc_get_products' ) ) {
			foreach ( wc_get_products( array( 'status' => 'publish', 'limit' => 80, 'return' => 'objects' ) ) as $product ) {
				$product_options[ (string) $product->get_id() ] = $product->get_name();
			}
		}
		$this->add_control( 'product_id', array( 'label' => orvio_t( 'Product', 'محصول' ), 'type' => \Elementor\Controls_Manager::SELECT2, 'options' => $product_options, 'condition' => array( 'model' => 'product' ) ) );
		$this->add_control( 'image', array( 'label' => orvio_t( 'Image', 'تصویر' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
		$this->add_control( 'image_2', array( 'label' => orvio_t( 'Second image', 'تصویر دوم' ), 'type' => \Elementor\Controls_Manager::MEDIA, 'condition' => array( 'model' => 'duo' ) ) );
		$this->add_control( 'kicker', array( 'label' => orvio_t( 'Kicker', 'برچسب' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Edit', 'مجموعه' ) ) );
		$this->add_control( 'title', array( 'label' => orvio_t( 'Title', 'عنوان' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Made to remain', 'ساخته‌شده برای ماندن' ) ) );
		$this->add_control( 'text', array( 'label' => orvio_t( 'Text', 'متن' ), 'type' => \Elementor\Controls_Manager::TEXTAREA ) );
		$this->add_control( 'button', array( 'label' => orvio_t( 'Button', 'دکمه' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Shop', 'فروشگاه' ) ) );
		$this->add_control( 'link', array( 'label' => orvio_t( 'Link', 'پیوند' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'title_2', array( 'label' => orvio_t( 'Second title', 'عنوان دوم' ), 'type' => \Elementor\Controls_Manager::TEXT, 'condition' => array( 'model' => 'duo' ) ) );
		$this->add_control( 'link_2', array( 'label' => orvio_t( 'Second link', 'پیوند دوم' ), 'type' => \Elementor\Controls_Manager::URL, 'condition' => array( 'model' => 'duo' ) ) );
		$this->end_controls_section();
		$this->orvio_register_style();
		$this->orvio_register_part( 'btitle', orvio_t( 'Banner title', 'عنوان بنر' ), '{{WRAPPER}} h2, {{WRAPPER}} h3' );
		$this->orvio_register_part( 'kicker', orvio_t( 'Kicker', 'برچسب' ), '{{WRAPPER}} .orvio-kicker' );
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		$model = in_array( $s['model'] ?? '', array( 'split', 'overlay', 'duo', 'card', 'ribbon', 'product' ), true ) ? $s['model'] : 'split';
		$size = in_array( $s['size'] ?? '', array( 'full', 'wide', 'medium', 'small' ), true ) ? $s['size'] : 'full';
		$img = ! empty( $s['image']['url'] ) ? $s['image']['url'] : ORVIO_URI . '/assets/images/hero.jpg';
		$img2 = ! empty( $s['image_2']['url'] ) ? $s['image_2']['url'] : ORVIO_URI . '/assets/images/products/headphones.jpg';
		$url = ! empty( $s['link']['url'] ) ? $s['link']['url'] : '#';
		$url2 = ! empty( $s['link_2']['url'] ) ? $s['link_2']['url'] : '#';
		$product = ( ! empty( $s['product_id'] ) && function_exists( 'wc_get_product' ) ) ? wc_get_product( (int) $s['product_id'] ) : false;
		if ( 'product' === $model && $product ) {
			$img = wp_get_attachment_image_url( $product->get_image_id(), 'large' ) ?: $img;
			$url = $product->get_permalink();
			$title = $product->get_name();
			$price = $product->get_price_html();
			echo '<article class="orvio-banner orvio-product-banner orvio-banner--product orvio-banner--size-' . esc_attr( $size ) . '"><div class="orvio-product-banner__media"><img src="' . esc_url( $img ) . '" alt="' . esc_attr( $title ) . '"></div><div class="orvio-banner__copy">';
			if ( ! empty( $s['kicker'] ) ) {
				echo '<p class="orvio-kicker">' . esc_html( $s['kicker'] ) . '</p>';
			}
			echo '<h2>' . esc_html( $title ) . '</h2><div class="orvio-product-banner__price">' . wp_kses_post( $price ) . '</div>';
			if ( ! empty( $s['text'] ) ) {
				echo '<p>' . esc_html( $s['text'] ) . '</p>';
			}
			if ( ! empty( $s['button'] ) ) {
				echo '<a class="orvio-btn orvio-btn--dark" href="' . esc_url( $url ) . '">' . esc_html( $s['button'] ) . '</a>';
			}
			echo '</div></article>';
			return;
		}
		if ( 'duo' === $model ) {
			echo '<div class="orvio-duo orvio-banner--size-' . esc_attr( $size ) . '"><a href="' . esc_url( $url ) . '"><img src="' . esc_url( $img ) . '" alt=""><span class="cap"><strong>' . esc_html( $s['title'] ) . '</strong></span></a><a href="' . esc_url( $url2 ) . '"><img src="' . esc_url( $img2 ) . '" alt=""><span class="cap"><strong>' . esc_html( $s['title_2'] ?? '' ) . '</strong></span></a></div>';
			return;
		}
		if ( 'ribbon' === $model ) {
			echo '<div class="orvio-ribbon orvio-banner--size-' . esc_attr( $size ) . '"><img src="' . esc_url( $img ) . '" alt=""><p><strong>' . esc_html( $s['title'] ) . '</strong><span>' . esc_html( $s['text'] ) . '</span></p><a class="orvio-btn orvio-btn--light" href="' . esc_url( $url ) . '">' . esc_html( $s['button'] ) . '</a></div>';
			return;
		}
		$cls = 'orvio-banner orvio-banner--' . sanitize_html_class( $model ) . ' orvio-banner--size-' . sanitize_html_class( $size );
		echo '<article class="' . esc_attr( $cls ) . '"><img src="' . esc_url( $img ) . '" alt=""><div class="orvio-banner__copy">';
		if ( ! empty( $s['kicker'] ) ) {
			echo '<p class="orvio-kicker">' . esc_html( $s['kicker'] ) . '</p>';
		}
		echo '<h2>' . esc_html( $s['title'] ) . '</h2>';
		if ( ! empty( $s['text'] ) ) {
			echo '<p>' . esc_html( $s['text'] ) . '</p>';
		}
		if ( ! empty( $s['button'] ) ) {
			$btn = 'overlay' === $model ? 'orvio-btn orvio-btn--ghost-light' : ( 'card' === $model ? 'orvio-btn orvio-btn--dark' : 'orvio-btn orvio-btn--light' );
			echo '<a class="' . esc_attr( $btn ) . '" href="' . esc_url( $url ) . '">' . esc_html( $s['button'] ) . '</a>';
		}
		echo '</div></article>';
	}
}

class Orvio_Widget_Contact extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-contact'; }
	public function get_title() { return orvio_t( 'Contact', 'ارتباط با ما' ); }
	public function get_icon() { return 'eicon-mail'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Contact', 'تماس' ) ) );
		$this->add_control( 'title', array( 'label' => orvio_t( 'Title', 'عنوان' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Contact', 'ارتباط با ما' ) ) );
		$this->add_control( 'show_info', array( 'label' => orvio_t( 'Show studio info', 'نمایش اطلاعات استودیو' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ) );
		$this->end_controls_section();
		$this->orvio_register_style();
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		$o = orvio_settings();
		echo '<section class="orvio-contact">';
		if ( 'yes' === $s['show_info'] ) {
			echo '<div class="orvio-info">';
			echo '<article><strong>' . esc_html( orvio_t( 'Studio', 'استودیو' ) ) . '</strong><span>' . esc_html( $o['address'] ) . '</span></article>';
			echo '<article><strong>' . esc_html( orvio_t( 'Phone', 'تلفن' ) ) . '</strong><a href="tel:' . esc_attr( preg_replace( '/\s+/', '', $o['phone'] ) ) . '">' . esc_html( $o['phone'] ) . '</a></article>';
			echo '<article><strong>' . esc_html( orvio_t( 'Email', 'ایمیل' ) ) . '</strong><a href="mailto:' . esc_attr( $o['email'] ) . '">' . esc_html( $o['email'] ) . '</a></article>';
			echo '<article><strong>' . esc_html( orvio_t( 'Hours', 'ساعت' ) ) . '</strong><span>' . esc_html( $o['hours'] ) . '</span></article>';
			echo '</div>';
		}
		echo '<form class="orvio-panel" data-orvio-contact>';
		echo '<h2 style="font-size:22px;letter-spacing:0;margin-bottom:12px">' . esc_html( $s['title'] ) . '</h2>';
		echo '<div class="orvio-fields">';
		echo '<label class="orvio-field"><span>' . esc_html( orvio_t( 'Name', 'نام' ) ) . '</span><input name="name" required></label>';
		echo '<label class="orvio-field"><span>' . esc_html( orvio_t( 'Phone', 'موبایل' ) ) . '</span><input name="phone"></label>';
		echo '<label class="orvio-field orvio-field--full"><span>' . esc_html( orvio_t( 'Email', 'ایمیل' ) ) . '</span><input type="email" name="email" required></label>';
		echo '<label class="orvio-field orvio-field--full"><span>' . esc_html( orvio_t( 'Message', 'پیام' ) ) . '</span><textarea name="message" required></textarea></label>';
		echo '<input type="text" name="orvio_hp" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">';
		echo '</div><button class="orvio-btn orvio-btn--primary" style="margin-top:12px" type="submit">' . esc_html( orvio_t( 'Send', 'ارسال پیام' ) ) . '</button></form></section>';
	}
}

class Orvio_Widget_About extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-about'; }
	public function get_title() { return orvio_t( 'About', 'درباره ما' ); }
	public function get_icon() { return 'eicon-person'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'About', 'درباره' ) ) );
		$this->add_control( 'image', array( 'label' => orvio_t( 'Image', 'تصویر' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
		$this->add_control( 'kicker', array( 'label' => orvio_t( 'Kicker', 'برچسب' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'About', 'درباره ما' ) ) );
		$this->add_control( 'title', array( 'label' => orvio_t( 'Title', 'عنوان' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'From a worktable to a shop', 'از یک میز کار تا یک ویترین' ) ) );
		$this->add_control( 'text', array( 'label' => orvio_t( 'Text', 'متن' ), 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => orvio_t( 'Everyday objects should be beautiful, and they should last.', 'اشیاء روزمره باید زیبا باشند و سال‌ها بمانند.' ) ) );
		$this->add_control( 'button', array( 'label' => orvio_t( 'Button', 'دکمه' ), 'type' => \Elementor\Controls_Manager::TEXT ) );
		$this->add_control( 'link', array( 'label' => orvio_t( 'Link', 'پیوند' ), 'type' => \Elementor\Controls_Manager::URL ) );
		$rep = new \Elementor\Repeater();
		$rep->add_control( 'num', array( 'label' => orvio_t( 'Number', 'عدد' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '18' ) );
		$rep->add_control( 'label', array( 'label' => orvio_t( 'Label', 'برچسب' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Workshops', 'کارگاه' ) ) );
		$this->add_control( 'stats', array( 'label' => orvio_t( 'Stats', 'آمار' ), 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ label }}}' ) );
		$this->end_controls_section();
		$this->orvio_register_style();
	}
	protected function render() {
		$s   = $this->get_settings_for_display();
		$img = ! empty( $s['image']['url'] ) ? $s['image']['url'] : ORVIO_URI . '/assets/images/about.jpg';
		echo '<section class="orvio-about"><img src="' . esc_url( $img ) . '" alt="">';
		echo '<div><p class="orvio-kicker">' . esc_html( $s['kicker'] ) . '</p><h2>' . esc_html( $s['title'] ) . '</h2><div class="orvio-prose">' . wp_kses_post( $s['text'] ) . '</div>';
		if ( ! empty( $s['stats'] ) ) {
			echo '<div class="orvio-stats">';
			foreach ( $s['stats'] as $stat ) {
				echo '<div><strong>' . esc_html( $stat['num'] ) . '</strong><span>' . esc_html( $stat['label'] ) . '</span></div>';
			}
			echo '</div>';
		}
		if ( ! empty( $s['button'] ) ) {
			$url = ! empty( $s['link']['url'] ) ? $s['link']['url'] : '#';
			echo '<a class="orvio-btn orvio-btn--dark" style="margin-top:16px" href="' . esc_url( $url ) . '">' . esc_html( $s['button'] ) . '</a>';
		}
		echo '</div></section>';
	}
}

class Orvio_Widget_Cart_Button extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-cart-button'; }
	public function get_title() { return orvio_t( 'Header cart button', 'دکمه سبد هدر' ); }
	public function get_icon() { return 'eicon-cart'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Cart button', 'دکمه سبد' ) ) );
		$this->add_control( 'show_total', array( 'label' => orvio_t( 'Show total', 'نمایش مبلغ' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ) );
		$this->add_control( 'label', array( 'label' => orvio_t( 'Label', 'برچسب' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Bag', 'سبد' ) ) );
		$this->add_control( 'preset', array( 'label' => orvio_t( 'Button preset', 'قالب آماده دکمه' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'pill', 'options' => array( 'minimal' => orvio_t( 'Minimal', 'مینیمال' ), 'pill' => orvio_t( 'Pill', 'گرد' ), 'solid' => orvio_t( 'Solid', 'پر' ), 'outline' => orvio_t( 'Outline', 'خطی' ), 'soft' => orvio_t( 'Soft', 'نرم' ) ) ) );
		$this->end_controls_section();
		$this->orvio_register_style();
		$this->orvio_register_header_button_style();
	}
	protected function render() {
		$s     = $this->get_settings_for_display();
		$count = orvio_cart_count();
		$tag   = 'page' === orvio_opt( 'cart_type' ) ? 'a' : 'button';
		$attr  = 'page' === orvio_opt( 'cart_type' )
			? ' href="' . esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ) . '"'
			: ' type="button" data-open="cart"';
		$presets = array( 'minimal', 'pill', 'solid', 'outline', 'soft' );
		$preset = in_array( $s['orvio_button_preset'] ?? '', $presets, true ) ? $s['orvio_button_preset'] : ( in_array( $s['preset'] ?? '', $presets, true ) ? $s['preset'] : 'pill' );
		echo '<' . $tag . ' class="orvio-tool orvio-cartbtn orvio-headerbtn--' . esc_attr( $preset ) . '"' . $attr . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<span class="orvio-tool__icon">' . orvio_icon( 'bag' ) . '<span class="orvio-count' . ( $count ? '' : ' is-zero' ) . '" data-cart-count>' . esc_html( (string) $count ) . '</span></span>';
		echo '<span class="orvio-tool__meta"><span class="orvio-tool__label">' . esc_html( $s['label'] ) . '</span>';
		if ( 'yes' === $s['show_total'] ) {
			echo '<span class="orvio-cartbtn__total" data-cart-total>' . wp_kses_post( orvio_cart_total_html() ) . '</span>';
		}
		echo '</span></' . $tag . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

class Orvio_Widget_Category_Menu extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-category-menu'; }
	public function get_title() { return orvio_t( 'Category menu', 'منوی دسته‌بندی' ); }
	public function get_icon() { return 'eicon-nav-menu'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Menu', 'منو' ) ) );
		$this->add_control( 'style', array(
			'label'   => orvio_t( 'Style', 'مدل' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'bar',
			'options' => array(
				'bar'  => orvio_t( 'Mega bar', 'نوار مگا' ),
				'list' => orvio_t( 'List only', 'فقط فهرست' ),
			),
		) );
		$this->end_controls_section();
		$this->orvio_register_style();
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		echo '<nav class="orvio-catbar" style="display:block;border:0"><div class="orvio-catbar__row">';
		get_template_part( 'template-parts/header/category-menu', null, array( 'style' => $s['style'] ) );
		echo '</div></nav>';
	}
}

class Orvio_Widget_Header extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-header'; }
	public function get_title() { return orvio_t( 'Header', 'هدر' ); }
	public function get_icon() { return 'eicon-header'; }
	public function get_keywords() { return array( 'header', 'logo', 'search', 'cart' ); }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Header elements', 'المان‌های هدر' ) ) );
		$this->add_control( 'layout', array(
			'label'   => orvio_t( 'Layout', 'چیدمان' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'classic',
			'options' => array(
				'classic'  => orvio_t( 'Standard', 'استاندارد' ),
				'centered' => orvio_t( 'Centered logo', 'لوگوی وسط' ),
				'split'    => orvio_t( 'Split search', 'جستجوی دوطرفه' ),
				'minimal'  => orvio_t( 'Minimal', 'مینیمال' ),
			),
		) );
		$this->add_control( 'cart_style', array( 'label' => orvio_t( 'Cart button preset', 'قالب دکمه سبد' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'pill', 'options' => array( 'minimal' => orvio_t( 'Minimal', 'مینیمال' ), 'pill' => orvio_t( 'Pill', 'گرد' ), 'solid' => orvio_t( 'Solid', 'پر' ), 'outline' => orvio_t( 'Outline', 'خطی' ), 'soft' => orvio_t( 'Soft', 'نرم' ) ) ) );
		$this->add_control( 'account_style', array( 'label' => orvio_t( 'Account button preset', 'قالب دکمه حساب' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'minimal', 'options' => array( 'minimal' => orvio_t( 'Minimal', 'مینیمال' ), 'pill' => orvio_t( 'Pill', 'گرد' ), 'solid' => orvio_t( 'Solid', 'پر' ), 'outline' => orvio_t( 'Outline', 'خطی' ), 'soft' => orvio_t( 'Soft', 'نرم' ) ) ) );
		foreach ( array(
			'show_search'  => orvio_t( 'Search', 'جستجو' ),
			'show_account' => orvio_t( 'Account', 'حساب' ),
			'show_wish'    => orvio_t( 'Wishlist', 'علاقه‌مندی' ),
			'show_cart'    => orvio_t( 'Cart', 'سبد' ),
			'show_cats'    => orvio_t( 'Category menu', 'منوی دسته‌ها' ),
			'show_bar'     => orvio_t( 'Announcement', 'نوار اعلان' ),
		) as $key => $label ) {
			$this->add_control( $key, array(
				'label'   => $label,
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			) );
		}
		$this->end_controls_section();
		$this->orvio_register_style( '{{WRAPPER}} .orvio-header, {{WRAPPER}} .orvio-catbar, {{WRAPPER}} .orvio-announce' );
		$this->orvio_register_header_button_style( '{{WRAPPER}} .orvio-tool' );
	}
	protected function render() {
		$s    = $this->get_settings_for_display();
		$map  = array(
			'show_search'  => 'is-hide-search',
			'show_account' => 'is-hide-account',
			'show_wish'    => 'is-hide-wish',
			'show_cart'    => 'is-hide-cart',
			'show_cats'    => 'is-hide-cats',
			'show_bar'     => 'is-hide-announce',
		);
		$header_layouts = array( 'classic', 'centered', 'split', 'minimal' );
		$header_layout  = in_array( $s['layout'] ?? '', $header_layouts, true ) ? $s['layout'] : 'classic';
		$classes = array( 'orvio-el-header', 'orvio-el-header-layout-' . $header_layout );
		if ( 'centered' === $header_layout ) {
			$classes[] = 'orvio-h-centered';
		}
		foreach ( $map as $key => $class ) {
			if ( isset( $s[ $key ] ) && 'yes' !== $s[ $key ] ) {
				$classes[] = $class;
			}
		}
		$header_styles = array( 'minimal', 'pill', 'solid', 'outline', 'soft' );
		$classes[] = 'orvio-header-cart-' . ( in_array( $s['cart_style'] ?? '', $header_styles, true ) ? $s['cart_style'] : 'pill' );
		$classes[] = 'orvio-header-account-' . ( in_array( $s['account_style'] ?? '', $header_styles, true ) ? $s['account_style'] : 'minimal' );
		echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
		get_template_part( 'template-parts/header/site-header', null, array( 'layout' => $header_layout ) );
		echo '</div>';
	}
}

class Orvio_Widget_Footer extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-footer'; }
	public function get_title() { return orvio_t( 'Footer', 'فوتر' ); }
	public function get_icon() { return 'eicon-footer'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Footer elements', 'المان‌های فوتر' ) ) );
		$this->add_control( 'layout', array( 'label' => orvio_t( 'Footer layout', 'چیدمان فوتر' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'classic', 'options' => array( 'classic' => orvio_t( 'Classic', 'کلاسیک' ), 'centered' => orvio_t( 'Centered', 'مرکزی' ), 'minimal' => orvio_t( 'Minimal', 'مینیمال' ), 'editorial' => orvio_t( 'Editorial', 'ادیتوریال' ) ) ) );
		$this->add_control( 'note', array( 'type' => \Elementor\Controls_Manager::RAW_HTML, 'raw' => esc_html( orvio_t( 'Columns, newsletter text and payment marks come from Orvio settings.', 'ستون‌ها، متن و نشان پرداخت از تنظیمات اُرویو می‌آیند.' ) ) ) );
		$this->end_controls_section();
		$this->orvio_register_style();
	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		$layouts  = array( 'classic', 'centered', 'minimal', 'editorial' );
		$layout   = in_array( $settings['layout'] ?? '', $layouts, true ) ? $settings['layout'] : 'classic';
		get_template_part( 'template-parts/footer/site-footer', null, array( 'layout' => $layout ) );
	}
}

class Orvio_Widget_Logo extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-logo'; }
	public function get_title() { return orvio_t( 'Logo', 'لوگو' ); }
	public function get_icon() { return 'eicon-site-logo'; }
	protected function register_controls() { $this->orvio_register_style(); }
	protected function render() {
		if ( has_custom_logo() ) {
			the_custom_logo();
			return;
		}
		echo '<a class="orvio-logo" href="' . esc_url( home_url( '/' ) ) . '">' . orvio_logo_mark() . '<span class="orvio-logo__word"><strong>' . esc_html( get_bloginfo( 'name' ) ) . '</strong></span></a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

class Orvio_Widget_Search extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-search'; }
	public function get_title() { return orvio_t( 'Search', 'جستجو' ); }
	public function get_icon() { return 'eicon-search'; }
	protected function register_controls() { $this->orvio_register_style(); }
	protected function render() {
		echo '<form class="orvio-search" style="display:flex" role="search" method="get" action="' . esc_url( home_url( '/' ) ) . '">';
		echo '<span class="orvio-search__icon">' . orvio_icon( 'search' ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<input type="search" name="s" placeholder="' . esc_attr( orvio_t( 'Search…', 'جستجو…' ) ) . '">';
		if ( class_exists( 'WooCommerce' ) ) {
			echo '<input type="hidden" name="post_type" value="product">';
		}
		echo '<button type="submit">' . esc_html( orvio_t( 'Search', 'جستجو' ) ) . '</button><div class="orvio-suggest" data-suggest hidden></div></form>';
	}
}

class Orvio_Widget_Account extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-account'; }
	public function get_title() { return orvio_t( 'Account button', 'دکمه حساب' ); }
	public function get_icon() { return 'eicon-user-circle-o'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Account button', 'دکمه حساب' ) ) );
		$this->add_control( 'label', array( 'label' => orvio_t( 'Label', 'برچسب' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Account', 'حساب' ) ) );
		$this->add_control( 'preset', array( 'label' => orvio_t( 'Button preset', 'قالب آماده دکمه' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'minimal', 'options' => array( 'minimal' => orvio_t( 'Minimal', 'مینیمال' ), 'pill' => orvio_t( 'Pill', 'گرد' ), 'solid' => orvio_t( 'Solid', 'پر' ), 'outline' => orvio_t( 'Outline', 'خطی' ), 'soft' => orvio_t( 'Soft', 'نرم' ) ) ) );
		$this->end_controls_section();
		$this->orvio_register_style();
		$this->orvio_register_header_button_style();
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		$presets = array( 'minimal', 'pill', 'solid', 'outline', 'soft' );
		$preset = in_array( $s['orvio_button_preset'] ?? '', $presets, true ) ? $s['orvio_button_preset'] : ( in_array( $s['preset'] ?? '', $presets, true ) ? $s['preset'] : 'minimal' );
		echo '<a class="orvio-tool orvio-accountbtn orvio-headerbtn--' . esc_attr( $preset ) . '" href="' . esc_url( orvio_account_url() ) . '"><span class="orvio-tool__icon">' . orvio_icon( 'user' ) . '</span><span class="orvio-tool__label">' . esc_html( $s['label'] ?? orvio_t( 'Account', 'حساب' ) ) . '</span></a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

class Orvio_Widget_Wishlist extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-wishlist'; }
	public function get_title() { return orvio_t( 'Wishlist button', 'دکمه علاقه‌مندی' ); }
	public function get_icon() { return 'eicon-heart-o'; }
	protected function register_controls() { $this->orvio_register_style(); }
	protected function render() {
		echo '<button type="button" class="orvio-tool" data-open="wish"><span class="orvio-tool__icon">' . orvio_icon( 'heart' ) . '<span class="orvio-count is-zero" data-wish-count>0</span></span><span class="orvio-tool__label">' . esc_html( orvio_t( 'Saved', 'علاقه‌مندی' ) ) . '</span></button>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

class Orvio_Widget_Announce extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-announce'; }
	public function get_title() { return orvio_t( 'Announcement', 'نوار اعلان' ); }
	public function get_icon() { return 'eicon-alert'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Text', 'متن' ) ) );
		$this->add_control( 'text', array( 'label' => orvio_t( 'Text', 'متن' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_announcement_text() ) );
		$this->end_controls_section();
		$this->orvio_register_style();
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		echo '<div class="orvio-announce" data-announce><div class="orvio-container orvio-announce__inner"><p>' . esc_html( $s['text'] ) . '</p><button type="button" class="orvio-announce__x" data-announce-close>×</button></div></div>';
	}
}

class Orvio_Widget_Newsletter extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-newsletter'; }
	public function get_title() { return orvio_t( 'Newsletter', 'خبرنامه' ); }
	public function get_icon() { return 'eicon-mail'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Newsletter', 'خبرنامه' ) ) );
		$this->add_control( 'title', array( 'label' => orvio_t( 'Title', 'عنوان' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'A short letter', 'نامه‌های کوتاه' ) ) );
		$this->add_control( 'text', array( 'label' => orvio_t( 'Text', 'متن' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => orvio_t( 'Only when something is worth saying.', 'فقط وقتی چیزی ارزش گفتن دارد.' ) ) );
		$this->end_controls_section();
		$this->orvio_register_style();
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		echo '<div class="orvio-news"><div><h2>' . esc_html( $s['title'] ) . '</h2><p>' . esc_html( $s['text'] ) . '</p></div>';
		echo '<form data-orvio-news><input type="email" name="email" required placeholder="email@example.com" aria-label="email"><button class="orvio-btn orvio-btn--light" type="submit">' . esc_html( orvio_t( 'Subscribe', 'عضویت' ) ) . '</button></form></div>';
	}
}

class Orvio_Widget_Features extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-features'; }
	public function get_title() { return orvio_t( 'Trust row', 'نوار اعتماد' ); }
	public function get_icon() { return 'eicon-check-circle'; }
	protected function register_controls() { $this->orvio_register_style(); }
	protected function render() {
		$items = array(
			array( 'truck', orvio_t( 'Shipping', 'ارسال سراسری' ), orvio_t( 'Most cities in 48 hours', 'بیشتر شهرها تا ۴۸ ساعت' ) ),
			array( 'back', orvio_t( 'Returns', 'بازگشت آسان' ), orvio_t( '30 days', 'تا ۳۰ روز' ) ),
			array( 'shield', orvio_t( 'Secure payment', 'پرداخت امن' ), orvio_t( 'Gateway, transfer, on delivery', 'درگاه، کارت‌به‌کارت، در محل' ) ),
			array( 'check', orvio_t( 'Checked by hand', 'بررسی دستی' ), orvio_t( 'Before it ships', 'پیش از ارسال' ) ),
		);
		echo '<div class="orvio-trust">';
		foreach ( $items as $item ) {
			echo '<div class="orvio-trust__item"><span class="orvio-trust__ico">' . orvio_icon( $item[0] ) . '</span><div><strong>' . esc_html( $item[1] ) . '</strong><span>' . esc_html( $item[2] ) . '</span></div></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '</div>';
	}
}

class Orvio_Widget_Hero extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-hero'; }
	public function get_title() { return orvio_t( 'Hero', 'هیرو خلاق' ); }
	public function get_icon() { return 'eicon-banner'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Hero', 'هیرو' ) ) );
		$this->add_control( 'model', array( 'label' => orvio_t( 'Hero model', 'مدل هیرو' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'split', 'options' => array( 'split' => orvio_t( 'Split showcase', 'نمایش دو بخشی' ), 'poster' => orvio_t( 'Poster overlay', 'پوستر پوششی' ), 'fullscreen' => orvio_t( 'Full screen', 'تمام‌صفحه' ), 'editorial' => orvio_t( 'Editorial', 'ادیتوریال' ) ) ) );
		$this->add_control( 'kicker', array( 'label' => orvio_t( 'Kicker', 'برچسب' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Autumn edit', 'مجموعه پاییز' ) ) );
		$this->add_control( 'title', array( 'label' => orvio_t( 'Title', 'عنوان' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => orvio_t( 'Objects for a quieter house', 'اشیائی برای خانه‌ای که آرام است' ) ) );
		$this->add_control( 'lead', array( 'label' => orvio_t( 'Lead', 'متن' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => orvio_t( 'A considered shop of ceramic, leather, wool and light.', 'ویترینی از سرامیک، چرم، پشم و نور.' ) ) );
		$this->add_control( 'badge', array( 'label' => orvio_t( 'Badge', 'نشان' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'New collection', 'کالکشن جدید' ) ) );
		$this->add_control( 'button', array( 'label' => orvio_t( 'Button', 'دکمه' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Enter the shop', 'ورود به فروشگاه' ) ) );
		$this->add_control( 'link', array( 'label' => orvio_t( 'Link', 'پیوند' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '' ) ) );
		$this->add_control( 'image', array( 'label' => orvio_t( 'Image', 'تصویر' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
		$rep = new \Elementor\Repeater();
		$rep->add_control( 'num', array( 'label' => orvio_t( 'Number', 'عدد' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '18' ) );
		$rep->add_control( 'label', array( 'label' => orvio_t( 'Label', 'برچسب' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Objects', 'شیء' ) ) );
		$this->add_control( 'stats', array( 'label' => orvio_t( 'Stats', 'آمار' ), 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ label }}}', 'condition' => array( 'model' => 'split' ) ) );
		$this->add_responsive_control( 'image_height', array( 'label' => orvio_t( 'Image height', 'ارتفاع تصویر' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 220, 'max' => 900 ) ), 'selectors' => array( '{{WRAPPER}} .orvio-hero__media > img' => 'height: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
		$this->orvio_register_style( '{{WRAPPER}} .orvio-hero' );
		$this->orvio_register_part( 'htitle', orvio_t( 'Title', 'عنوان' ), '{{WRAPPER}} h1' );
		$this->orvio_register_part( 'lead', orvio_t( 'Lead', 'متن' ), '{{WRAPPER}} .orvio-lead' );
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		$model = in_array( $s['model'] ?? '', array( 'split', 'poster', 'fullscreen', 'editorial' ), true ) ? $s['model'] : 'split';
		$url = ! empty( $s['link']['url'] ) ? $s['link']['url'] : ( function_exists( 'orvio_shop_url' ) ? orvio_shop_url() : '#' );
		$img = ! empty( $s['image']['url'] ) ? $s['image']['url'] : ORVIO_URI . '/assets/images/hero.jpg';
		echo '<section class="orvio-hero orvio-hero--' . esc_attr( $model ) . '"><div class="orvio-container orvio-hero__grid"><div class="orvio-hero__copy">';
		if ( ! empty( $s['kicker'] ) ) {
			echo '<p class="orvio-kicker">' . esc_html( $s['kicker'] ) . '</p>';
		}
		echo '<h1>' . esc_html( $s['title'] ) . '</h1>';
		if ( ! empty( $s['lead'] ) ) {
			echo '<p class="orvio-lead">' . esc_html( $s['lead'] ) . '</p>';
		}
		if ( ! empty( $s['button'] ) ) {
			echo '<div class="orvio-hero__actions"><a class="orvio-btn orvio-btn--primary" href="' . esc_url( $url ) . '">' . esc_html( $s['button'] ) . '</a></div>';
		}
		if ( 'split' === $model && ! empty( $s['stats'] ) ) {
			echo '<div class="orvio-hero__stats">';
			foreach ( $s['stats'] as $stat ) {
				echo '<div><strong>' . esc_html( $stat['num'] ) . '</strong><span>' . esc_html( $stat['label'] ) . '</span></div>';
			}
			echo '</div>';
		}
		echo '</div><div class="orvio-hero__media"><img src="' . esc_url( $img ) . '" alt="" width="1600" height="900">';
		if ( ! empty( $s['badge'] ) ) {
			echo '<span class="orvio-hero__badge">' . esc_html( $s['badge'] ) . '</span>';
		}
		echo '</div></div></section>';
	}
}

class Orvio_Widget_Categories extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-categories'; }
	public function get_title() { return orvio_t( 'Category showcase', 'نمایش حرفه‌ای دسته‌بندی' ); }
	public function get_icon() { return 'eicon-gallery-grid'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Categories', 'دسته‌ها' ) ) );
		$this->add_control( 'heading', array( 'label' => orvio_t( 'Heading', 'عنوان' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => orvio_t( 'Shop by room', 'خرید بر اساس فضا' ) ) );
		$this->add_control( 'limit', array( 'label' => orvio_t( 'Count', 'تعداد' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 6, 'min' => 2, 'max' => 18 ) );
		$this->add_control( 'layout', array( 'label' => orvio_t( 'Layout', 'چیدمان' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'mosaic', 'options' => array( 'mosaic' => orvio_t( 'Mosaic', 'موزاییکی' ), 'cards' => orvio_t( 'Cards', 'کارتی' ), 'pills' => orvio_t( 'Pills', 'برچسبی' ), 'carousel' => orvio_t( 'Carousel', 'کروسل' ) ) ) );
		$this->add_control( 'columns', array( 'label' => orvio_t( 'Columns', 'ستون' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'options' => array( '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' ), 'condition' => array( 'layout!' => 'carousel' ) ) );
		$this->add_control( 'sort', array( 'label' => orvio_t( 'Order', 'ترتیب' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'name', 'options' => array( 'name' => orvio_t( 'Name', 'نام' ), 'count' => orvio_t( 'Product count', 'تعداد کالا' ), 'date' => orvio_t( 'Newest', 'جدیدترین' ) ) ) );
		$this->add_control( 'show_count', array( 'label' => orvio_t( 'Show product count', 'نمایش تعداد کالا' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ) );
		$this->add_control( 'car_cols', array( 'label' => orvio_t( 'Visible slides', 'اسلاید قابل نمایش' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 4, 'min' => 1, 'max' => 6, 'condition' => array( 'layout' => 'carousel' ) ) );
		$this->add_control( 'car_auto', array( 'label' => orvio_t( 'Autoplay milliseconds', 'پخش خودکار (میلی‌ثانیه)' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 0, 'min' => 0, 'max' => 12000, 'condition' => array( 'layout' => 'carousel' ) ) );
		$this->end_controls_section();
		$this->orvio_register_style();
		$this->orvio_register_part( 'label', orvio_t( 'Label', 'برچسب' ), '{{WRAPPER}} .orvio-catcard span' );
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		$limit = max( 2, (int) ( $s['limit'] ?? 6 ) );
		$items = array();
		if ( taxonomy_exists( 'product_cat' ) ) {
			$order = 'name' === ( $s['sort'] ?? 'name' ) ? 'name' : ( 'count' === ( $s['sort'] ?? '' ) ? 'count' : 'term_id' );
			$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'number' => $limit, 'orderby' => $order, 'order' => 'DESC', 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
			if ( ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$thumb = (int) get_term_meta( $term->term_id, 'thumbnail_id', true );
					$items[] = array( 'name' => $term->name, 'count' => (int) $term->count, 'url' => get_term_link( $term ), 'img' => $thumb ? wp_get_attachment_image_url( $thumb, 'large' ) : '' );
				}
			}
		}
		if ( ! $items && function_exists( 'orvio_sample_categories' ) ) {
			foreach ( array_slice( orvio_sample_categories(), 0, $limit, true ) as $cat ) {
				$items[] = array( 'name' => is_rtl() ? $cat['fa'] : $cat['en'], 'count' => 0, 'url' => function_exists( 'orvio_shop_url' ) ? orvio_shop_url() : '#', 'img' => ORVIO_URI . '/' . $cat['img'] );
			}
		}
		$layout = $s['layout'] ?? 'mosaic';
		$classes = array( 'orvio-section', 'orvio-el-categories', 'orvio-categories--' . sanitize_html_class( $layout ) );
		echo '<section class="' . esc_attr( implode( ' ', $classes ) ) . '"><div class="orvio-container">';
		if ( ! empty( $s['heading'] ) ) {
			echo '<div class="orvio-section__head"><h2>' . esc_html( $s['heading'] ) . '</h2></div>';
		}
		if ( 'carousel' === $layout ) {
			$cols = max( 1, min( 6, (int) ( $s['car_cols'] ?? 4 ) ) );
			echo '<div class="orvio-carousel orvio-carousel--categories" data-carousel data-cols="' . esc_attr( $cols ) . '" data-gap="14" data-autoplay="' . esc_attr( (int) ( $s['car_auto'] ?? 0 ) ) . '" data-loop="1" style="--carousel-cols:' . esc_attr( $cols ) . ';--carousel-gap:14px;"><div class="orvio-carousel__nav"><button type="button" data-prev aria-label="' . esc_attr( orvio_t( 'Previous', 'قبلی' ) ) . '">' . orvio_icon( 'chev' ) . '</button><button type="button" data-next aria-label="' . esc_attr( orvio_t( 'Next', 'بعدی' ) ) . '">' . orvio_icon( 'chev' ) . '</button></div><div class="orvio-carousel__view"><div class="orvio-carousel__track">';
		} else {
			$cols = max( 2, min( 6, (int) ( $s['columns'] ?? 4 ) ) );
			echo '<div class="orvio-cats" style="--cat-cols:' . esc_attr( $cols ) . '">';
		}
		foreach ( $items as $i => $item ) {
			$feature = ( 'mosaic' === $layout && 0 === $i ) ? ' orvio-catcard--feature' : '';
			$count = ! empty( $s['show_count'] ) && $item['count'] ? '<small>' . esc_html( (string) $item['count'] ) . ' ' . esc_html( orvio_t( 'items', 'کالا' ) ) . '</small>' : '';
			echo '<a class="orvio-catcard' . esc_attr( $feature ) . '" href="' . esc_url( $item['url'] ) . '">';
			if ( $item['img'] ) {
				echo '<img src="' . esc_url( $item['img'] ) . '" alt="">';
			}
			echo '<span>' . esc_html( $item['name'] ) . $count . '</span></a>';
		}
		if ( 'carousel' === $layout ) {
			echo '</div></div><div class="orvio-carousel__dots" data-dots></div></div>';
		} else {
			echo '</div>';
		}
		echo '</div></section>';
	}
}

function orvio_elementor_widget_list() {
	return array(
		'Orvio_Widget_Hero',
		'Orvio_Widget_Categories',
		'Orvio_Widget_Products',
		'Orvio_Widget_Deals',
		'Orvio_Widget_Recommended',
		'Orvio_Widget_Banner',
		'Orvio_Widget_Contact',
		'Orvio_Widget_About',
		'Orvio_Widget_Cart_Button',
		'Orvio_Widget_Category_Menu',
		'Orvio_Widget_Header',
		'Orvio_Widget_Footer',
		'Orvio_Widget_Logo',
		'Orvio_Widget_Search',
		'Orvio_Widget_Account',
		'Orvio_Widget_Wishlist',
		'Orvio_Widget_Announce',
		'Orvio_Widget_Newsletter',
		'Orvio_Widget_Features',
	);
}
