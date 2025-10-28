
/**
 * Plugin Name: Elementor - Animated Bubbles
 * Description: Self-contained Elementor widget with animated bubbles, clickable large bubbles opening modals with per-bubble WYSIWYG content.
 * Author: developersharf
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// Ensure Elementor is active.
add_action('plugins_loaded', function () {
    if ( ! did_action('elementor/loaded') ) { return; }
});

/**
 * Register Widget
 */
add_action('elementor/widgets/register', function( $widgets_manager ) {

    if ( ! class_exists('\Elementor\Widget_Base') ) { return; }

    class Animated_Bubbles_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'animated_bubbles_widget'; }
        public function get_title() { return __('Animated Bubbles', 'animated-bubbles'); }
        public function get_icon() { return 'eicon-circle-o'; }
        public function get_categories() { return ['general']; }

        protected function register_controls() {
            // ====== CONTENT TAB ======
            $this->start_controls_section(
                'section_content',
                [ 'label' => __('Content', 'animated-bubbles') ]
            );

            $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => 'was wir bieten',
                    'placeholder' => __('Enter center title...', 'animated-bubbles')
                ]
            );


            // Repeater for Large Bubbles: Title + Modal WYSIWYG
            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'bubble_label',
                [
                    'label' => __('Bubble Label', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => 'Large Bubble',
                ]
            );

            $repeater->add_control(
                'bubble_modal_content',
                [
                    'label' => __('Modal Content', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                    'default' => '<h3>Modal Title</h3><p>Describe details for this item here.</p>',
                ]
            );

            $this->add_control(
                'large_bubbles',
                [
                    'label' => __('Large Bubbles', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [ 'bubble_label' => '80 Gäste', 'bubble_modal_content' => '<p>Bis zu 80 Gäste für Ihre Veranstaltung.</p>' ],
                        [ 'bubble_label' => 'Parkplätze', 'bubble_modal_content' => '<p>Ausreichend Parkmöglichkeiten vor Ort.</p>' ],
                        [ 'bubble_label' => '2 Venues', 'bubble_modal_content' => '<p>Zwei unterschiedliche Räumlichkeiten verfügbar.</p>' ],
                        [ 'bubble_label' => '3 Caterer', 'bubble_modal_content' => '<p>Drei sorgfältig kuratierte Catering-Partner.</p>' ],
                        [ 'bubble_label' => 'Text', 'bubble_modal_content' => '<p>Individuelle Leistung 1</p>' ],
                        [ 'bubble_label' => 'Text', 'bubble_modal_content' => '<p>Individuelle Leistung 2</p>' ],
                    ],
                    'title_field' => '{{{ bubble_label }}}',
                ]
            );

            $this->add_control(
                'small_bubbles_count',
                [
                    'label' => __('Number of Small Bubbles', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 4,
                    'min' => 0,
                    'max' => 30,
                    'step' => 1,
                ]
            );

            $this->end_controls_section();

            // ====== STYLE: Section Background & Title ======
            $this->start_controls_section(
                'section_style',
                [ 'label' => __('Section & Title', 'animated-bubbles'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ]
            );

            $this->add_control(
                'section_bg_color',
                [
                    'label' => __('Section Background', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#ffffff'
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => __('Title Color', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#666666'
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __('Title Typography', 'animated-bubbles'),
                    'selector' => '{{WRAPPER}} .ab-center-text',
                ]
            );

            $this->end_controls_section();

            // ====== STYLE: Bubbles ======
            $this->start_controls_section(
                'bubble_style',
                [ 'label' => __('Bubbles', 'animated-bubbles'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ]
            );

            $this->add_control(
                'bubble_text_color',
                [
                    'label' => __('Bubble Text Color', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#526946'
                ]
            );

            // Gradient colors
            $this->add_control(
                'grad_c1',
                [ 'label' => __('Gradient 1 (center highlight)', 'animated-bubbles'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0.95)' ]
            );
            $this->add_control(
                'grad_c2',
                [ 'label' => __('Gradient 2', 'animated-bubbles'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0.7)' ]
            );
            $this->add_control(
                'grad_c3',
                [ 'label' => __('Gradient 3', 'animated-bubbles'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(162,185,142,0.15)' ]
            );
            $this->add_control(
                'grad_c4',
                [ 'label' => __('Gradient 4', 'animated-bubbles'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(82,105,70,0.10)' ]
            );
            $this->add_control(
                'grad_c5',
                [ 'label' => __('Gradient 5', 'animated-bubbles'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(82,105,70,0.06)' ]
            );
            $this->add_control(
                'grad_c6',
                [ 'label' => __('Gradient 6 (edge)', 'animated-bubbles'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(82,105,70,0.025)' ]
            );

            $this->add_control(
                'bubble_border_color',
                [ 'label' => __('Bubble Border', 'animated-bubbles'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(162,185,142,0.18)' ]
            );

            // Sizes (responsive sliders)
            $this->add_responsive_control(
                'large_bubble_base',
                [
                    'label' => __('Large Bubble Base Size (px)', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [ 'px' => ['min' => 80, 'max' => 400] ],
                    'default' => [ 'size' => 140, 'unit' => 'px' ],
                ]
            );
            $this->add_responsive_control(
                'small_bubble_base',
                [
                    'label' => __('Small Bubble Base Size (px)', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [ 'px' => ['min' => 20, 'max' => 200] ],
                    'default' => [ 'size' => 60, 'unit' => 'px' ],
                ]
            );

            $this->end_controls_section();

            // ====== STYLE: Modal ======
            $this->start_controls_section(
                'modal_style',
                [ 'label' => __('Modal', 'animated-bubbles'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ]
            );

            $this->add_control(
                'modal_bg',
                [ 'label' => __('Modal Background', 'animated-bubbles'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#ffffff' ]
            );

            $this->add_control(
                'modal_text',
                [ 'label' => __('Modal Text Color', 'animated-bubbles'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#222222' ]
            );

            $this->add_control(
                'modal_overlay_bg',
                [ 'label' => __('Overlay Color', 'animated-bubbles'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(0,0,0,0.45)' ]
            );

            $this->end_controls_section();

            // ====== SETTINGS: Animation ======
            $this->start_controls_section(
                'animation_settings',
                [ 'label' => __('Animation', 'animated-bubbles') ]
            );

            $this->add_control(
                'movement_speed_multiplier',
                [
                    'label' => __('Movement Speed Multiplier', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['custom'],
                    'range' => [ 'custom' => ['min' => 0.2, 'max' => 3, 'step' => 0.05] ],
                    'default' => [ 'size' => 1, 'unit' => 'x' ],
                ]
            );

            $this->add_control(
                'growth_speed',
                [
                    'label' => __('Breathing Speed', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['custom'],
                    'range' => [ 'custom' => ['min' => 0.002, 'max' => 0.05, 'step' => 0.001] ],
                    'default' => [ 'size' => 0.012, 'unit' => '' ],
                ]
            );

            $this->add_control(
                'growth_amount',
                [
                    'label' => __('Breathing Amount', 'animated-bubbles'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['custom'],
                    'range' => [ 'custom' => ['min' => 0.01, 'max' => 0.2, 'step' => 0.005] ],
                    'default' => [ 'size' => 0.08, 'unit' => '' ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
            $s = $this->get_settings_for_display();
            $uid = 'ab-' . $this->get_id();

            // Prepare arrays for JS
            $large_bubbles = isset($s['large_bubbles']) && is_array($s['large_bubbles']) ? $s['large_bubbles'] : [];
            $labels = array_map(function($b){ return $b['bubble_label']; }, $large_bubbles);
            $modals = array_map(function($b){ return $b['bubble_modal_content']; }, $large_bubbles);

            // Sizes (fallbacks)
            $large_base = (isset($s['large_bubble_base']['size']) && $s['large_bubble_base']['size']) ? floatval($s['large_bubble_base']['size']) : 140;
            $small_base = (isset($s['small_bubble_base']['size']) && $s['small_bubble_base']['size']) ? floatval($s['small_bubble_base']['size']) : 60;

            $move_mult = isset($s['movement_speed_multiplier']['size']) ? floatval($s['movement_speed_multiplier']['size']) : 1.0;
            $grow_speed = isset($s['growth_speed']['size']) ? floatval($s['growth_speed']['size']) : 0.012;
            $grow_amount = isset($s['growth_amount']['size']) ? floatval($s['growth_amount']['size']) : 0.08;

            // Colors
            $c1 = $s['grad_c1'] ?? 'rgba(255,255,255,0.95)';
            $c2 = $s['grad_c2'] ?? 'rgba(255,255,255,0.7)';
            $c3 = $s['grad_c3'] ?? 'rgba(162,185,142,0.15)';
            $c4 = $s['grad_c4'] ?? 'rgba(82,105,70,0.10)';
            $c5 = $s['grad_c5'] ?? 'rgba(82,105,70,0.06)';
            $c6 = $s['grad_c6'] ?? 'rgba(82,105,70,0.025)';
            $border = $s['bubble_border_color'] ?? 'rgba(162,185,142,0.18)';
            $title_color = $s['title_color'] ?? '#666666';
            $section_bg = $s['section_bg_color'] ?? '#ffffff';
            $bubble_text = $s['bubble_text_color'] ?? '#526946';

            $modal_bg = $s['modal_bg'] ?? '#ffffff';
            $modal_text = $s['modal_text'] ?? '#222222';
            $overlay_bg = $s['modal_overlay_bg'] ?? 'rgba(0,0,0,0.45)';

            $small_count = intval($s['small_bubbles_count'] ?? 4);

            // Output HTML + CSS + JS
            ?>
            <style>
                /* Container */
                #<?php echo esc_attr($uid); ?> .ab-bubble-section {
                    position: relative;
                    width: 100%;
                    height: 80vh;
                    overflow: hidden;
                    background: <?php echo esc_attr($section_bg); ?>;
                }

                /* Title */
    #<?php echo esc_attr($uid); ?> .ab-center-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    /* font-family: Georgia, serif;  <- entfernen */
    /* font-size: clamp(2rem, 5vw, 3.5rem); <- entfernen */
    color: <?php echo esc_attr($title_color); ?>;
    text-align: center;
    z-index: 10;
    pointer-events: none;
    /* font-weight: 300; <- entfernen */
}


                /* Bubbles */
                #<?php echo esc_attr($uid); ?> .ab-bubble {
                    position: absolute;
                    border-radius: 50%;
                    background: radial-gradient(circle at 35% 30%,
                        <?php echo esc_attr($c1); ?> 0%,
                        <?php echo esc_attr($c2); ?> 10%,
                        <?php echo esc_attr($c3); ?> 30%,
                        <?php echo esc_attr($c4); ?> 55%,
                        <?php echo esc_attr($c5); ?> 75%,
                        <?php echo esc_attr($c6); ?> 100%);
                    -webkit-backdrop-filter: blur(2px);
                    backdrop-filter: blur(2px);
                    border: 1px solid <?php echo esc_attr($border); ?>;
                    box-shadow:
                        inset 0 0 12px rgba(162,185,142,0.08),
                        0 0 10px rgba(0,0,0,0.04),
                        inset -6px -6px 12px rgba(162,185,142,0.06);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-family: Georgia, serif;
                    color: <?php echo esc_attr($bubble_text); ?>;
                    text-align: center;
                    font-size: clamp(0.8rem, 1.5vw, 1.1rem);
                    font-weight: 400;
                    will-change: transform, width, height;
                    overflow: hidden;
                    user-select: none;
                }
                #<?php echo esc_attr($uid); ?> .ab-bubble.small { pointer-events: none; }
                #<?php echo esc_attr($uid); ?> .ab-bubble.large { cursor: pointer; pointer-events: auto; }

                #<?php echo esc_attr($uid); ?> .ab-bubble::before {
                    content: "";
                    position: absolute;
                    top: 15%;
                    left: 15%;
                    width: 35%;
                    height: 35%;
                    background: radial-gradient(ellipse at center,
                        rgba(255,255,255,0.8) 0%,
                        rgba(255,255,255,0.05) 100%);
                    border-radius: 50%;
                    transform: rotate(-20deg);
                    pointer-events: none;
                    z-index: 2;
                    filter: blur(1px);
                    opacity: 0.8;
                }
                #<?php echo esc_attr($uid); ?> .ab-bubble::after {
                    content: "";
                    position: absolute;
                    top: 5%;
                    left: 5%;
                    width: 100%;
                    height: 100%;
                    background: conic-gradient(from 0deg,
                        rgba(255, 0, 150, 0.1),
                        rgba(0, 255, 255, 0.08),
                        rgba(255, 255, 0, 0.1),
                        rgba(255, 0, 150, 0.1));
                    mix-blend-mode: screen;
                    border-radius: 50%;
                    filter: blur(8px);
                    opacity: 0.3;
                    pointer-events: none;
                    z-index: 1;
                }

                /* Modal */
                #<?php echo esc_attr($uid); ?> .ab-modal-overlay {
                    position: fixed;
                    inset: 0;
                    background: <?php echo esc_attr($overlay_bg); ?>;
                    display: none;
                    align-items: center;
                    justify-content: center;
                    z-index: 9999;
                    opacity: 0;
                    transition: opacity .25s ease;
                }
                #<?php echo esc_attr($uid); ?> .ab-modal-overlay.is-open {
                    display: flex;
                    opacity: 1;
                }
                #<?php echo esc_attr($uid); ?> .ab-modal {
                    background: <?php echo esc_attr($modal_bg); ?>;
                    color: <?php echo esc_attr($modal_text); ?>;
                    width: min(90vw, 800px);
                    max-height: 80vh;
                    border-radius: 14px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
                    transform: translateY(10px);
                    opacity: 0;
                    transition: transform .25s ease, opacity .25s ease;
                    position: relative;
                    overflow: hidden;
                }
                #<?php echo esc_attr($uid); ?> .ab-modal-overlay.is-open .ab-modal {
                    transform: translateY(0);
                    opacity: 1;
                }
                #<?php echo esc_attr($uid); ?> .ab-modal-header {
                    padding: 14px 18px;
                    border-bottom: 1px solid rgba(0,0,0,0.06);
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                #<?php echo esc_attr($uid); ?> .ab-modal-title {
                    margin: 0;
                    font-size: 18px;
                    font-weight: 600;
                }
                #<?php echo esc_attr($uid); ?> .ab-modal-close {
                    border: none;
                    background: transparent;
                    font-size: 22px;
                    line-height: 1;
                    cursor: pointer;
                    color: #000; /* <- hier hinzugefuegt */
                }
                #<?php echo esc_attr($uid); ?> .ab-modal-body {
                    padding: 18px;
                    overflow: auto;
                    max-height: calc(80vh - 60px);
                        text-align: justify;            /* <- hinzugefuegt */
    hyphens: auto;                  /* optional */
    -webkit-hyphens: auto;          /* optional */
    -ms-hyphens: auto;              /* optional */

                }

                /* Wrapper for bubbles (positioning context) */
                #<?php echo esc_attr($uid); ?> .ab-bubbles-wrap {
                    position: relative;
                    width: 100%;
                    height: 100%;
                }

                /* Typography from Elementor */
                <?php // Typography selector already applied via Group_Control_Typography ?>

                /* Responsive tweaks can be handled by base sizes/physics in JS */
            </style>

            <div id="<?php echo esc_attr($uid); ?>" class="ab-widget">
                <div class="ab-bubble-section">
                    <div class="ab-center-text"><?php echo esc_html($s['section_title']); ?></div>
                    <div class="ab-bubbles-wrap" data-uid="<?php echo esc_attr($uid); ?>"></div>
                </div>

                <!-- Modal (single, content swapped per bubble) -->
                <div class="ab-modal-overlay" data-uid="<?php echo esc_attr($uid); ?>">
                    <div class="ab-modal" role="dialog" aria-modal="true" aria-labelledby="<?php echo esc_attr($uid); ?>-modal-title">
                        <div class="ab-modal-header">
                            <h3 id="<?php echo esc_attr($uid); ?>-modal-title" class="ab-modal-title"></h3>
                            <button class="ab-modal-close" aria-label="<?php esc_attr_e('Close', 'animated-bubbles'); ?>">&times;</button>
                        </div>
                        <div class="ab-modal-body"></div>
                    </div>
                </div>
            </div>

            <script>
            (function(){
                const uid = <?php echo wp_json_encode($uid); ?>;
                const wrapper = document.querySelector('#'+uid+' .ab-bubbles-wrap');
                if (!wrapper) return;

                // Data from PHP
                const largeLabels = <?php echo wp_json_encode($labels); ?>;
                const largeModalHTML = <?php
                    // sanitize modal HTML allowing typical WYSIWYG tags
                    $allowed = wp_kses_allowed_html('post');
                    echo wp_json_encode(array_map(function($html) use ($allowed) {
                        return wp_kses($html, $allowed);
                    }, $modals));
                ?>;

                const smallCount = <?php echo (int) $small_count; ?>;
                const baseLarge = <?php echo (float) $large_base; ?>;
                const baseSmall = <?php echo (float) $small_base; ?>;

                const moveMult = <?php echo (float) $move_mult; ?>;
                const growthSpeedSetting = <?php echo (float) $grow_speed; ?>;
                const growthAmountSetting = <?php echo (float) $grow_amount; ?>;

                // Modal refs
                const overlay = document.querySelector('#'+uid+' .ab-modal-overlay');
                const modalTitle = document.querySelector('#'+uid+' .ab-modal-title');
                const modalBody  = document.querySelector('#'+uid+' .ab-modal-body');
                const closeBtn   = document.querySelector('#'+uid+' .ab-modal-close');

                const centerEl = document.querySelector('#'+uid+' .ab-center-text');

                const bubbles = [];
                let animationId;

                // ---- helpers for center-text collision ----
                function clamp(v, min, max){ return Math.max(min, Math.min(max, v)); }

                function getCenterRect() {
                    // rect relative to wrapper
                    const wrapRect = wrapper.getBoundingClientRect();
                    const cRect = centerEl.getBoundingClientRect();
                    return {
                        x: cRect.left - wrapRect.left,
                        y: cRect.top - wrapRect.top,
                        w: cRect.width,
                        h: cRect.height
                    };
                }

                function bounceBubbleOffRect(b, rect) {
                    // Circle-rect collision, b is Bubble
                    const r = b.currentSize / 2;
                    const cx = b.x + r;
                    const cy = b.y + r;

                    const nearestX = clamp(cx, rect.x, rect.x + rect.w);
                    const nearestY = clamp(cy, rect.y, rect.y + rect.h);

                    const dx = cx - nearestX;
                    const dy = cy - nearestY;
                    const dist = Math.hypot(dx, dy);

                    if (dist < r) {
                        let nx, ny;
                        if (dist > 0) {
                            nx = dx / dist;
                            ny = dy / dist;
                        } else {
                            // We're exactly on an edge/corner; pick normal by smallest penetration axis
                            const leftPen   = Math.abs((cx - r) - rect.x);
                            const rightPen  = Math.abs((rect.x + rect.w) - (cx + r));
                            const topPen    = Math.abs((cy - r) - rect.y);
                            const bottomPen = Math.abs((rect.y + rect.h) - (cy + r));
                            const minPen = Math.min(leftPen, rightPen, topPen, bottomPen);
                            if (minPen === leftPen)  { nx = -1; ny = 0; }
                            else if (minPen === rightPen) { nx = 1; ny = 0; }
                            else if (minPen === topPen)   { nx = 0; ny = -1; }
                            else { nx = 0; ny = 1; }
                        }

                        // Push circle out of the rect along the normal
                        const overlap = r - dist + 0.5; // small bias to avoid sticking
                        b.x += nx * overlap;
                        b.y += ny * overlap;

                        // Reflect velocity across the collision normal (with slight damping)
                        const dot = b.vx * nx + b.vy * ny;
                        if (dot < 0) {
                            b.vx -= 2 * dot * nx;
                            b.vy -= 2 * dot * ny;
                            b.vx *= 0.98;
                            b.vy *= 0.98;
                        }
                    }
                }
                // ------------------------------------------

                class Bubble {
                    constructor(text, isLarge, index) {
                        this.isLarge = isLarge;
                        this.index = index;

                        this.el = document.createElement('div');
                        this.el.className = 'ab-bubble ' + (isLarge ? 'large' : 'small');
                        this.el.textContent = text || '';

                        this.baseSize = isLarge ? baseLarge : baseSmall;
                        this.currentSize = this.baseSize;
                        this.mass = this.baseSize * this.baseSize;
                        this.growthPhase = Math.random() * Math.PI * 2;
                        this.growthSpeed = growthSpeedSetting + Math.random() * 0.01;
                        this.growthAmount = 0.05 + (growthAmountSetting - 0.05);

                        // random position within viewport
                        const rect = wrapper.getBoundingClientRect();
                        const W = rect.width || window.innerWidth;
                        const H = rect.height || window.innerHeight;

                        this.x = Math.random() * (W - this.baseSize);
                        this.y = Math.random() * (H - this.baseSize);

                        const speed = 1.2 * moveMult;
                        this.vx = (Math.random() - 0.5) * speed;
                        this.vy = (Math.random() - 0.5) * speed;

                        this.updateStyle();
                        wrapper.appendChild(this.el);

                        if (isLarge) {
                            // Click opens modal
                            this.el.addEventListener('click', () => {
                                const label = largeLabels[this.index] || '';
                                const html = largeModalHTML[this.index] || '';
                                modalTitle.textContent = label;
                                modalBody.innerHTML = html;
                                overlay.classList.add('is-open');
                            });
                        }
                    }

                    updateStyle() {
                        const wobble = 1 + Math.sin(Date.now() * 0.003 + this.growthPhase) * 0.05;
                        this.el.style.width = this.currentSize + 'px';
                        this.el.style.height = this.currentSize + 'px';
                        this.el.style.transform = 'translate3d(' + this.x + 'px,' + this.y + 'px,0) scale('+ wobble +')';
                    }

                    update(boundsW, boundsH) {
                        this.growthPhase += this.growthSpeed;
                        const growth = 1 + Math.sin(this.growthPhase) * this.growthAmount;
                        this.currentSize = this.baseSize * growth;

                        this.x += this.vx;
                        this.y += this.vy;

                        if (this.x <= 0 || this.x >= boundsW - this.currentSize) this.vx *= -1;
                        if (this.y <= 0 || this.y >= boundsH - this.currentSize) this.vy *= -1;

                        this.updateStyle();
                    }

                    checkCollision(other) {
                        const dx = (this.x + this.currentSize/2) - (other.x + other.currentSize/2);
                        const dy = (this.y + this.currentSize/2) - (other.y + other.currentSize/2);
                        const dist = Math.hypot(dx, dy);
                        const minDist = (this.currentSize + other.currentSize) / 2;

                        if (dist < minDist && dist > 0) {
                            const overlap = minDist - dist;
                            const nx = dx / dist;
                            const ny = dy / dist;

                            const totalMass = this.mass + other.mass;
                            const correction = overlap / 2;
                            this.x += nx * correction * (other.mass / totalMass);
                            this.y += ny * correction * (other.mass / totalMass);
                            other.x -= nx * correction * (this.mass / totalMass);
                            other.y -= ny * correction * (this.mass / totalMass);

                            const dvx = this.vx - other.vx;
                            const dvy = this.vy - other.vy;
                            const dot = dvx * nx + dvy * ny;

                            if (dot < 0) {
                                const coeff = (2 * dot) / totalMass;
                                this.vx -= coeff * other.mass * nx;
                                this.vy -= coeff * other.mass * ny;
                                other.vx += coeff * this.mass * nx;
                                other.vy += coeff * this.mass * ny;
                            }
                        }
                    }
                }

                let centerRect = getCenterRect();

                function init() {
                    // Create large bubbles from repeater
                    largeLabels.forEach((label, i) => {
                        bubbles.push(new Bubble(label, true, i));
                    });
                    // Create small bubbles (no label)
                    for (let i=0;i<smallCount;i++) {
                        bubbles.push(new Bubble('', false, -1));
                    }

                    animate();
                    window.addEventListener('resize', handleResize);
                }

                function animate() {
                    const rect = wrapper.getBoundingClientRect();
                    const W = rect.width || window.innerWidth;
                    const H = rect.height || window.innerHeight;

                    // Update center rect each frame in case of responsive changes / Elementor editor
                    centerRect = getCenterRect();

                    for (let b of bubbles) {
                        b.update(W, H);
                        // Bounce off the center title
                        bounceBubbleOffRect(b, centerRect);
                    }
                    for (let i = 0; i < bubbles.length; i++) {
                        for (let j = i + 1; j < bubbles.length; j++) {
                            bubbles[i].checkCollision(bubbles[j]);
                        }
                    }
                    animationId = requestAnimationFrame(animate);
                }

                function handleResize() {
                    const rect = wrapper.getBoundingClientRect();
                    const W = rect.width || window.innerWidth;
                    const H = rect.height || window.innerHeight;
                    bubbles.forEach(b => {
                        b.x = Math.min(Math.max(0, b.x), W - b.currentSize);
                        b.y = Math.min(Math.max(0, b.y), H - b.currentSize);
                    });
                    centerRect = getCenterRect();
                }

                // Modal events
                function closeModal() {
                    overlay.classList.remove('is-open');
                }
                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) closeModal();
                });
                closeBtn.addEventListener('click', closeModal);
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') closeModal();
                });

                init();

                // Cleanup if Elementor hot reloads preview
                window.addEventListener('unload', function(){
                    cancelAnimationFrame(animationId);
                    window.removeEventListener('resize', handleResize);
                    wrapper.innerHTML = '';
                });
            })();
            </script>
            <?php
        }
    }

    $widgets_manager->register( new Animated_Bubbles_Widget() );
});
