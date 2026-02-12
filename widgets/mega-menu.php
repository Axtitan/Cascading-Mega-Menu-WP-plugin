<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMM_Mega_Menu extends \Elementor\Widget_Base {

    public function get_name() {
        return 'cmm_mega_menu';
    }

    public function get_title() {
        return 'Cascading Mega Menu';
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
        return [ 'cmm-style' ];
    }

    public function get_script_depends() {
        return [ 'cmm-script' ];
    }

    protected function register_controls() {

        /* ───────── CONTENT: Menu Items ───────── */

        $this->start_controls_section(
            'section_menu_items',
            [
                'label' => 'Menu Items',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label'       => 'Title',
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'Menu Item',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label'   => 'Link',
                'type'    => \Elementor\Controls_Manager::URL,
                'default' => [ 'url' => '#' ],
            ]
        );

        $repeater->add_control(
            'item_parent',
            [
                'label'       => 'Parent Item Title',
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => '',
                'label_block' => true,
                'description' => 'Leave empty for top-level items. Type the exact title of the parent item to nest under it.',
            ]
        );

        $this->add_control(
            'menu_items',
            [
                'label'   => 'Items',
                'type'    => \Elementor\Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [ 'item_title' => 'Menu Item 1', 'item_link' => [ 'url' => '#' ], 'item_parent' => '' ],
                    [ 'item_title' => 'Menu Item 2', 'item_link' => [ 'url' => '#' ], 'item_parent' => '' ],
                    [ 'item_title' => 'Menu Item 3', 'item_link' => [ 'url' => '#' ], 'item_parent' => '' ],
                ],
                'title_field' => '{{{ item_parent ? "↳ " + item_title : "● " + item_title }}}',
            ]
        );

        $this->end_controls_section();

        /* ───────── CONTENT: Column Headings ───────── */

        $this->start_controls_section(
            'section_column_headings',
            [
                'label' => 'Column Headings',
            ]
        );

        $this->add_control(
            'first_column_heading',
            [
                'label'       => 'First Column Heading',
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => '',
                'label_block' => true,
                'description' => 'Optional heading displayed above the top-level items. Leave empty to hide.',
            ]
        );

        $this->add_control(
            'show_child_headings',
            [
                'label'        => 'Show Parent Title as Heading',
                'description'  => 'Automatically shows the parent item\'s name as a heading in child columns.',
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Yes',
                'label_off'    => 'No',
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();

        /* ───────── CONTENT: Submenu Indicator ───────── */

        $this->start_controls_section(
            'section_submenu_indicator',
            [
                'label' => 'Submenu Indicator',
            ]
        );

        $this->add_control(
            'submenu_icon',
            [
                'label'   => 'Indicator Icon',
                'type'    => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-chevron-right',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'chevron-right',
                        'angle-right',
                        'arrow-right',
                        'caret-right',
                        'long-arrow-alt-right',
                    ],
                ],
            ]
        );

        $this->add_control(
            'submenu_icon_size',
            [
                'label'      => 'Icon Size',
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 6, 'max' => 30 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 12 ],
                'selectors'  => [
                    '{{WRAPPER}} .cmm-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .cmm-arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ───────── STYLE: Items ───────── */

        $this->start_controls_section(
            'section_style_items',
            [
                'label' => 'Item Styling',
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'item_typography',
                'label'    => 'Typography',
                'selector' => '{{WRAPPER}} .cmm-item a',
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'label'     => 'Text Color',
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#374151',
                'selectors' => [
                    '{{WRAPPER}} .cmm-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_hover_bg',
            [
                'label'     => 'Hover Background',
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#f3f4f6',
                'selectors' => [
                    '{{WRAPPER}} .cmm-item a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_active_bg',
            [
                'label'     => 'Active Background',
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#eff6ff',
                'selectors' => [
                    '{{WRAPPER}} .cmm-item.is-active > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_active_accent',
            [
                'label'     => 'Active Accent (Left Border)',
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#2563eb',
                'selectors' => [
                    '{{WRAPPER}} .cmm-item.is-active > a' => 'border-left-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_active_text_color',
            [
                'label'     => 'Active Text Color',
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1d4ed8',
                'selectors' => [
                    '{{WRAPPER}} .cmm-item.is-active > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => 'Item Padding',
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [
                    'top'    => '10',
                    'right'  => '20',
                    'bottom' => '10',
                    'left'   => '20',
                    'unit'   => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .cmm-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ───────── STYLE: Panel ───────── */

        $this->start_controls_section(
            'section_style_panel',
            [
                'label' => 'Panel Styling',
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'panel_bg',
            [
                'label'     => 'Background',
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cmm-root' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'column_separator_color',
            [
                'label'     => 'Column Separator Color',
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#e5e7eb',
                'selectors' => [
                    '{{WRAPPER}} .cmm-col + .cmm-col' => 'border-left-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'column_min_width',
            [
                'label'      => 'Column Min Width',
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 150, 'max' => 400 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 220 ],
                'selectors'  => [
                    '{{WRAPPER}} .cmm-col' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label'     => 'Arrow Color',
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9ca3af',
                'selectors' => [
                    '{{WRAPPER}} .cmm-arrow'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cmm-arrow svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ───────── STYLE: Column Headings ───────── */

        $this->start_controls_section(
            'section_style_headings',
            [
                'label' => 'Column Headings',
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'label'    => 'Typography',
                'selector' => '{{WRAPPER}} .cmm-group-heading',
            ]
        );

        $this->add_control(
            'heading_text_color',
            [
                'label'     => 'Text Color',
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .cmm-group-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_border_color',
            [
                'label'     => 'Bottom Border Color',
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#e5e7eb',
                'selectors' => [
                    '{{WRAPPER}} .cmm-group-heading' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items    = ! empty( $settings['menu_items'] ) ? $settings['menu_items'] : [];

        if ( empty( $items ) ) {
            echo '<p style="padding:20px;color:#666;">Please add menu items in the widget settings.</p>';
            return;
        }

        // ── 1. Build lookup: title → index (first occurrence wins) ──
        $title_to_index = [];
        foreach ( $items as $index => $item ) {
            $title = trim( $item['item_title'] ?? '' );
            if ( $title !== '' && ! isset( $title_to_index[ $title ] ) ) {
                $title_to_index[ $title ] = $index;
            }
        }

        // ── 2. Group children by parent key ──
        $children_of = [];
        foreach ( $items as $index => $item ) {
            $parent_title = isset( $item['item_parent'] ) ? trim( $item['item_parent'] ) : '';
            if ( $parent_title === '' || ! isset( $title_to_index[ $parent_title ] ) ) {
                $children_of['__root__'][] = $index;
            } else {
                $parent_key = 'item-' . $title_to_index[ $parent_title ];
                $children_of[ $parent_key ][] = $index;
            }
        }

        if ( empty( $children_of['__root__'] ) ) {
            echo '<p style="padding:20px;color:#666;">No top-level items found. Make sure some items have an empty Parent field.</p>';
            return;
        }

        // ── 3. Determine depth of every item via BFS ──
        $depth_of      = [];
        $items_at_depth = [];
        $queue          = [];

        foreach ( $children_of['__root__'] as $idx ) {
            $depth_of[ $idx ]    = 0;
            $items_at_depth[0][] = $idx;
            $queue[]             = $idx;
        }

        while ( ! empty( $queue ) ) {
            $current     = array_shift( $queue );
            $current_key = 'item-' . $current;
            if ( isset( $children_of[ $current_key ] ) ) {
                foreach ( $children_of[ $current_key ] as $child_idx ) {
                    $d                        = $depth_of[ $current ] + 1;
                    $depth_of[ $child_idx ]   = $d;
                    $items_at_depth[ $d ][]   = $child_idx;
                    $queue[]                  = $child_idx;
                }
            }
        }

        $max_depth = ! empty( $items_at_depth ) ? max( array_keys( $items_at_depth ) ) : 0;

        // ── 4. Compute "default active path" (first child chain) ──
        $active_ids  = []; // item-{index} => true
        $active_cols = [ 0 => true ]; // depth => true (which columns are visible initially)
        $current_key = '__root__';
        while ( isset( $children_of[ $current_key ] ) && ! empty( $children_of[ $current_key ] ) ) {
            $first_idx                = $children_of[ $current_key ][0];
            $active_ids[ 'item-' . $first_idx ] = true;
            $current_key              = 'item-' . $first_idx;

            // The children of this active item live one depth deeper
            if ( isset( $children_of[ $current_key ] ) ) {
                $child_depth = $depth_of[ $children_of[ $current_key ][0] ];
                $active_cols[ $child_depth ] = true;
            }
        }

        // Get submenu icon setting
        $submenu_icon = ! empty( $settings['submenu_icon'] ) ? $settings['submenu_icon'] : null;

        // Heading settings
        $first_heading      = isset( $settings['first_column_heading'] ) ? trim( $settings['first_column_heading'] ) : '';
        $show_child_headings = ! empty( $settings['show_child_headings'] ) && $settings['show_child_headings'] === 'yes';

        // ── 5. Render ──
        echo '<div class="cmm-root">';

        for ( $d = 0; $d <= $max_depth; $d++ ) {
            if ( ! isset( $items_at_depth[ $d ] ) ) break;

            // Add cmm-col-visible class if this column is in the active path
            $col_classes = 'cmm-col';
            if ( isset( $active_cols[ $d ] ) ) {
                $col_classes .= ' cmm-col-visible';
            }

            echo '<div class="' . esc_attr( $col_classes ) . '" data-depth="' . $d . '">';

            if ( $d === 0 ) {
                echo '<ul class="cmm-group is-visible" data-parent="__root__">';
                // First column heading
                if ( $first_heading !== '' ) {
                    echo '<li class="cmm-group-heading">' . esc_html( $first_heading ) . '</li>';
                }
                foreach ( $children_of['__root__'] as $idx ) {
                    $this->render_item( $items[ $idx ], $idx, $children_of, $active_ids, $submenu_icon );
                }
                echo '</ul>';
            } else {
                // Group items at this depth by their parent
                $groups = [];
                foreach ( $items_at_depth[ $d ] as $idx ) {
                    $parent_title = isset( $items[ $idx ]['item_parent'] ) ? trim( $items[ $idx ]['item_parent'] ) : '';
                    $parent_idx   = $title_to_index[ $parent_title ] ?? null;
                    $parent_key   = $parent_idx !== null ? 'item-' . $parent_idx : '__root__';
                    $groups[ $parent_key ][] = $idx;
                }

                foreach ( $groups as $parent_key => $child_indices ) {
                    $visible = isset( $active_ids[ $parent_key ] ) ? ' is-visible' : '';
                    echo '<ul class="cmm-group' . $visible . '" data-parent="' . esc_attr( $parent_key ) . '">';

                    // Child column heading = parent item's title
                    if ( $show_child_headings ) {
                        // Extract parent index from key like "item-3"
                        $p_idx = intval( str_replace( 'item-', '', $parent_key ) );
                        if ( isset( $items[ $p_idx ] ) ) {
                            echo '<li class="cmm-group-heading">' . esc_html( $items[ $p_idx ]['item_title'] ?? '' ) . '</li>';
                        }
                    }

                    foreach ( $child_indices as $idx ) {
                        $this->render_item( $items[ $idx ], $idx, $children_of, $active_ids, $submenu_icon );
                    }
                    echo '</ul>';
                }
            }

            echo '</div>';
        }

        echo '</div>';
    }

    /**
     * Render a single menu item <li>.
     */
    private function render_item( $item, $index, $children_of, $active_ids, $submenu_icon ) {
        $item_id      = 'item-' . $index;
        $has_children = isset( $children_of[ $item_id ] );
        $is_active    = isset( $active_ids[ $item_id ] );

        $classes = 'cmm-item';
        if ( $is_active )    $classes .= ' is-active';

        $link = isset( $item['item_link'] ) && is_array( $item['item_link'] ) ? $item['item_link'] : [];
        $url  = ! empty( $link['url'] ) ? $link['url'] : '#';

        $attrs = '';
        if ( ! empty( $link['is_external'] ) ) {
            $attrs .= ' target="' . esc_attr( '_blank' ) . '"';
        }
        if ( ! empty( $link['nofollow'] ) ) {
            $attrs .= ' rel="' . esc_attr( 'nofollow' ) . '"';
        }

        // Build the arrow/icon markup
        $arrow = '';
        if ( $has_children ) {
            if ( $submenu_icon && ! empty( $submenu_icon['value'] ) ) {
                ob_start();
                \Elementor\Icons_Manager::render_icon( $submenu_icon, [ 'aria-hidden' => 'true' ] );
                $icon_html = ob_get_clean();
                $arrow = '<span class="cmm-arrow">' . $icon_html . '</span>';
            } else {
                $arrow = '<span class="cmm-arrow">&#10095;</span>';
            }
        }

        echo '<li class="' . esc_attr( $classes ) . '" data-id="' . esc_attr( $item_id ) . '">';
        echo '<a href="' . esc_url( $url ) . '"' . $attrs . '>'
             . esc_html( $item['item_title'] ?? 'Menu Item' )
             . $arrow
             . '</a>';
        echo '</li>';
    }
}
