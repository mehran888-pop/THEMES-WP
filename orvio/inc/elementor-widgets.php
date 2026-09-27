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
		$text = $selector . ', ' . $selector . ' h1, ' . $selector . ' h2, ' . $selector . ' h3, ' . $selector . ' h4, ' . $selector . ' p, ' . $selector . ' a, ' . $selector . ' button, ' . $selector . ' span, ' . $selector . ' strong';
		$this->start_controls_section( 'orvio_style', array(
			'label' => orvio_t( 'Style', 'استایل' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );
		if ( class_exists( '\Elementor\Group_Control_Typography' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
				'name'     => 'orvio_typo',
				'label'    => orvio_t( 'Font', 'فونت' ),
				'selector' => $text,
			) );
		}
		$this->add_control( 'orvio_color', array(
			'label'     => orvio_t( 'Text color', 'رنگ متن' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $text => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'orvio_bg', array(
			'label'     => orvio_t( 'Background', 'پس‌زمینه' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $selector => 'background-color: {{VALUE}};' ),
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
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
			'selectors'  => array( $selector => 'border-radius: {{SIZE}}{{UNIT}};' ),
		) );
		$this->end_controls_section();

		$this->start_controls_section( 'orvio_style_btn', array(
			'label' => orvio_t( 'Button', 'دکمه' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );
		if ( class_exists( '\Elementor\Group_Control_Typography' ) ) {
			$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
				'name'     => 'orvio_btn_typo',
				'label'    => orvio_t( 'Button font', 'فونت دکمه' ),
				'selector' => $selector . ' .orvio-btn, ' . $selector . ' button',
			) );
		}
		$this->add_control( 'orvio_btn_color', array(
			'label'     => orvio_t( 'Button text', 'متن دکمه' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $selector . ' .orvio-btn, ' . $selector . ' button' => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'orvio_btn_bg', array(
			'label'     => orvio_t( 'Button background', 'پس‌زمینه دکمه' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( $selector . ' .orvio-btn, ' . $selector . ' button' => 'background-color: {{VALUE}};' ),
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
				'latest'   => orvio_t( 'Latest', 'جدیدترین' ),
				'featured' => orvio_t( 'Featured', 'ویژه' ),
				'sale'     => orvio_t( 'On sale', 'تخفیف‌دار' ),
				'category' => orvio_t( 'Category', 'دسته' ),
			),
		) );
		$this->add_control( 'category', array( 'label' => orvio_t( 'Category slug', 'نامک دسته' ), 'type' => \Elementor\Controls_Manager::TEXT ) );
		$this->add_control( 'limit', array( 'label' => orvio_t( 'Count', 'تعداد' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 8, 'min' => 1, 'max' => 24 ) );
		$this->add_control( 'columns', array( 'label' => orvio_t( 'Columns', 'ستون' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'options' => array( '2' => '2', '3' => '3', '4' => '4', '5' => '5' ) ) );
		$this->add_control( 'layout', array(
			'label'   => orvio_t( 'Layout', 'چیدمان' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'grid',
			'options' => array(
				'grid'     => orvio_t( 'Grid', 'شبکه' ),
				'list'     => orvio_t( 'List', 'فهرست' ),
				'carousel' => orvio_t( 'Carousel', 'چرخ فلک' ),
				'compact'  => orvio_t( 'Compact', 'فشرده' ),
			),
		) );
		$this->add_control( 'card', array(
			'label'   => orvio_t( 'Card style', 'مدل کارت' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''        => orvio_t( 'Theme default', 'پیش‌فرض قالب' ),
				'classic' => orvio_t( 'Classic', 'کلاسیک' ),
				'minimal' => orvio_t( 'Minimal', 'مینیمال' ),
				'overlay' => orvio_t( 'Overlay', 'روی تصویر' ),
			),
		) );
		$this->end_controls_section();
		$this->orvio_register_style();
	}
	protected function render() {
		if ( ! function_exists( 'wc_get_product' ) ) {
			echo '<p class="orvio-note">' . esc_html( orvio_t( 'WooCommerce is required.', 'ووکامرس لازم است.' ) ) . '</p>';
			return;
		}
		$s    = $this->get_settings_for_display();
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => max( 1, (int) $s['limit'] ),
			'post_status'    => 'publish',
		);
		if ( 'featured' === $s['source'] ) {
			$args['tax_query'] = array( array( 'taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured' ) );
		} elseif ( 'sale' === $s['source'] ) {
			$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
		} elseif ( 'category' === $s['source'] && ! empty( $s['category'] ) ) {
			$args['tax_query'] = array( array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => sanitize_title( $s['category'] ) ) );
		}
		$q      = new WP_Query( $args );
		$layout = $s['layout'] ?: 'grid';
		$card   = $s['card'] ? ' orvio-cards-' . sanitize_html_class( $s['card'] ) : '';
		$cols   = (int) $s['columns'];
		echo '<section class="orvio-section orvio-el-products' . esc_attr( $card ) . '">';
		if ( ! empty( $s['heading'] ) ) {
			echo '<div class="orvio-section__head"><h2>' . esc_html( $s['heading'] ) . '</h2></div>';
		}
		if ( 'carousel' === $layout ) {
			echo '<div class="orvio-carousel" data-carousel><div class="orvio-carousel__view"><div class="orvio-carousel__track">';
		} else {
			$list = 'list' === $layout ? ' is-list' : '';
			$compact = 'compact' === $layout ? ' is-list' : '';
			echo '<div class="orvio-grid' . esc_attr( $list . $compact ) . '" style="--cols:' . esc_attr( $cols ) . '">';
		}
		while ( $q->have_posts() ) {
			$q->the_post();
			orvio_wc_card( wc_get_product( get_the_ID() ) );
		}
		wp_reset_postdata();
		echo 'carousel' === $layout ? '</div></div></div>' : '</div>';
		echo '</section>';
	}
}

class Orvio_Widget_Banner extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-product-banner'; }
	public function get_title() { return orvio_t( 'Product banner', 'بنر محصول' ); }
	public function get_icon() { return 'eicon-banner'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Banner', 'بنر' ) ) );
		$this->add_control( 'model', array(
			'label'   => orvio_t( 'Model', 'مدل' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'split',
			'options' => array(
				'split'   => orvio_t( 'Split', 'اسپلیت' ),
				'overlay' => orvio_t( 'Overlay', 'پوششی' ),
				'duo'     => orvio_t( 'Duo', 'دوگانه' ),
				'card'    => orvio_t( 'Card', 'کارتی' ),
				'ribbon'  => orvio_t( 'Ribbon', 'نواری' ),
			),
		) );
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
	}
	protected function render() {
		$s   = $this->get_settings_for_display();
		$img = ! empty( $s['image']['url'] ) ? $s['image']['url'] : ORVIO_URI . '/assets/images/hero.jpg';
		$img2 = ! empty( $s['image_2']['url'] ) ? $s['image_2']['url'] : ORVIO_URI . '/assets/images/products/headphones.jpg';
		$url = ! empty( $s['link']['url'] ) ? $s['link']['url'] : '#';
		$url2 = ! empty( $s['link_2']['url'] ) ? $s['link_2']['url'] : '#';
		$model = $s['model'] ?: 'split';
		if ( 'duo' === $model ) {
			echo '<div class="orvio-duo">';
			echo '<a href="' . esc_url( $url ) . '"><img src="' . esc_url( $img ) . '" alt=""><span class="cap"><strong>' . esc_html( $s['title'] ) . '</strong></span></a>';
			echo '<a href="' . esc_url( $url2 ) . '"><img src="' . esc_url( $img2 ) . '" alt=""><span class="cap"><strong>' . esc_html( $s['title_2'] ) . '</strong></span></a>';
			echo '</div>';
			return;
		}
		if ( 'ribbon' === $model ) {
			echo '<div class="orvio-ribbon"><img src="' . esc_url( $img ) . '" alt=""><p><strong>' . esc_html( $s['title'] ) . '</strong><span>' . esc_html( $s['text'] ) . '</span></p><a class="orvio-btn orvio-btn--light" href="' . esc_url( $url ) . '">' . esc_html( $s['button'] ) . '</a></div>';
			return;
		}
		$cls = 'orvio-banner orvio-banner--' . sanitize_html_class( $model );
		echo '<article class="' . esc_attr( $cls ) . '"><img src="' . esc_url( $img ) . '" alt="">';
		echo '<div class="orvio-banner__copy">';
		if ( $s['kicker'] ) {
			echo '<p class="orvio-kicker">' . esc_html( $s['kicker'] ) . '</p>';
		}
		echo '<h2>' . esc_html( $s['title'] ) . '</h2>';
		if ( $s['text'] ) {
			echo '<p>' . esc_html( $s['text'] ) . '</p>';
		}
		if ( $s['button'] ) {
			$btn = 'overlay' === $model ? 'orvio-btn orvio-btn--ghost-light' : 'orvio-btn orvio-btn--light';
			if ( 'card' === $model ) {
				$btn = 'orvio-btn orvio-btn--dark';
			}
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
		$this->end_controls_section();
		$this->orvio_register_style();
	}
	protected function render() {
		$s     = $this->get_settings_for_display();
		$count = orvio_cart_count();
		$tag   = 'page' === orvio_opt( 'cart_type' ) ? 'a' : 'button';
		$attr  = 'page' === orvio_opt( 'cart_type' )
			? ' href="' . esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ) . '"'
			: ' type="button" data-open="cart"';
		echo '<' . $tag . ' class="orvio-tool orvio-cartbtn"' . $attr . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
			),
		) );
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
		$classes = array( 'orvio-el-header' );
		if ( 'centered' === ( $s['layout'] ?? '' ) ) {
			$classes[] = 'orvio-h-centered';
		}
		foreach ( $map as $key => $class ) {
			if ( isset( $s[ $key ] ) && 'yes' !== $s[ $key ] ) {
				$classes[] = $class;
			}
		}
		echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
		get_template_part( 'template-parts/header/site-header' );
		echo '</div>';
	}
}

class Orvio_Widget_Footer extends Orvio_Widget_Base {
	public function get_name() { return 'orvio-footer'; }
	public function get_title() { return orvio_t( 'Footer', 'فوتر' ); }
	public function get_icon() { return 'eicon-footer'; }
	protected function register_controls() {
		$this->start_controls_section( 's', array( 'label' => orvio_t( 'Footer elements', 'المان‌های فوتر' ) ) );
		$this->add_control( 'note', array( 'type' => \Elementor\Controls_Manager::RAW_HTML, 'raw' => esc_html( orvio_t( 'Columns, newsletter text and payment marks come from Orvio settings.', 'ستون‌ها، متن و نشان پرداخت از تنظیمات اُرویو می‌آیند.' ) ) ) );
		$this->end_controls_section();
		$this->orvio_register_style();
	}
	protected function render() {
		get_template_part( 'template-parts/footer/site-footer' );
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
	protected function register_controls() { $this->orvio_register_style(); }
	protected function render() {
		echo '<a class="orvio-tool" href="' . esc_url( orvio_account_url() ) . '"><span class="orvio-tool__icon">' . orvio_icon( 'user' ) . '</span><span class="orvio-tool__label">' . esc_html( orvio_t( 'Account', 'حساب' ) ) . '</span></a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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

function orvio_elementor_widget_list() {
	return array(
		'Orvio_Widget_Products',
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
