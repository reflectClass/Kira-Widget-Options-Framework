<?php

/**
 * Plugin Name: Kira Widget Options Framework
 * Description: A framework for creating WordPress widget options.
 * Version: 1.0
 * Author: Nazmul Sabuz
 * Author URI: https://profiles.wordpress.org/nazsabuz/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

class Kira_Widget_Options_Framework
{
    public function __construct()
    {
        add_action('admin_head-widgets.php', array($this, 'header_scripts'), 99);
        add_action('admin_footer-widgets.php', array($this, 'footer_scripts'), 99);
    }

    /**
     * Header scripts
     *
     * @since 1.0
     */
    public function header_scripts()
    {
        echo '<style>
            .kira-widget-control-group-wrap {
                display: block;
                width: 100%;
                clear: both;
                margin-bottom: 5px;
            }
            .kira-widget-control-group-wrap label {
                display: block;
                clear: both;
            }
        </style>';
    }

    /**
     * Footer scripts
     *
     * @since 1.0
     */
    public function footer_scripts()
    {
        echo '<script>
            (function($) {
                function initColorPicker(widget) {
                    $(".color-picker", widget).wpColorPicker({
                        change: function(e, ui) {
                            $(e.target).val(ui.color.toString());
                            $(e.target).trigger("change");
                        },
                        clear: function(e, ui) {
                            $(e.target).trigger("change");
                        }
                    });
                }

                $(document).ready(function() {
                    $("#widgets-right .widget:has(.color-picker)").each(function() {
                        initColorPicker($(this));
                    });
                });

                $(document).on("widget-added widget-updated", function(event, widget) {
                    initColorPicker(widget);
                });
            })(jQuery);
		</script>';
    }

    /**
     * Helper functions
     *
     * @since 1.0
     */
    protected function _helper($args)
    {
        $arr = array();

        switch ($args) {
            case 'page':
                if ($pages = get_posts(array('post_type' => 'page', 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => -1))) {
                    foreach ($pages as $page) {
                        $arr[$page->ID] = $page->post_title;
                    }
                }

                break;

            case 'post':
                if ($posts = get_posts(array('post_type' => 'post', 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => -1))) {
                    foreach ($posts as $post) {
                        $arr[$post->ID] = $post->post_title;
                    }
                }

                break;

            case 'menu':
                if ($menus = wp_get_nav_menus()) {
                    foreach ($menus as $menu) {
                        $arr[$menu->term_id] = $menu->name;
                    }
                }

                break;

            case 'user':
                if ($users = get_users()) {
                    foreach ($users as $user) {
                        $arr[$user->ID] = $user->display_name;
                    }
                }

                break;
        }

        return $arr;
    }

    /**
     * Field: Text
     *
     * @since 1.0
     */
    public function text($args)
    {
        $defaults = array(
            'name' => '',
            'label' => '',
            'description' => '',
            'value' => '',
            'html_class' => '',
            'html_id' => '',
        );

        $args = wp_parse_args($args, $defaults);

        $html = '<p>
			<label for="' . $args['name'] . '" class="widefat">' . $args['label'] . '</label>
            <input type="text" name="' . $args['name'] . '" class="widefat" value="' . $args['value'] . '">';

        if (!empty($args['description'])) {
            $html .= '<span class="description">' . $args['description'] . '</span>';
        }

        $html .= '</p>';

        return $html;
    }

    /**
     * Field: Textarea
     *
     * @since 1.0
     */
    public function textarea($args)
    {
        $defaults = array(
            'name' => '',
            'label' => '',
            'description' => '',
            'value' => '',
            'html_class' => '',
            'html_id' => '',
        );

        $args = wp_parse_args($args, $defaults);

        $html = '<p>
			<label for="' . $args['name'] . '" class="widefat">' . $args['label'] . '</label>
            <textarea name="' . $args['name'] . '" class="widefat">' . $args['value'] . '</textarea>';

        if (!empty($args['description'])) {
            $html .= '<span class="description">' . $args['description'] . '</span>';
        }

        $html .= '</p>';

        return $html;
    }

    /**
     * Field: Select
     *
     * @since 1.0
     */
    public function select($args)
    {
        $defaults = array(
            'name' => '',
            'label' => '',
            'description' => '',
            'options' => array(),
            'value' => '',
            'html_class' => '',
            'html_id' => '',
        );

        $args = wp_parse_args($args, $defaults);

        if (is_string($args['options'])) {
            $args['options'] = $this->_helper($args['options']);
        }

        $html = '<p>
			<label for="' . $args['name'] . '" class="widefat">' . $args['label'] . '</label>
			<select name="' . $args['name'] . '" class="widefat">';

        if (!empty($args['options'])) {
            foreach ($args['options'] as $key => $value) {
                $html .= '<option value="' . esc_html($key) . '" ' . (esc_html($args['value']) == esc_html($key) ? 'selected' : '') . '>' . esc_html($value) . '</option>';
            }
        }

        $html .= '</select>';

        if (!empty($args['description'])) {
            $html .= '<span class="description">' . $args['description'] . '</span>';
        }

        $html .= '</p>';

        return $html;
    }

    /**
     * Field: Radio
     *
     * @since 1.0
     */
    public function radio($args)
    {
        $defaults = array(
            'name' => '',
            'label' => '',
            'description' => '',
            'options' => array(),
            'value' => '',
            'html_class' => '',
            'html_id' => '',
        );

        $args = wp_parse_args($args, $defaults);

        if (is_string($args['options'])) {
            $args['options'] = $this->_helper($args['options']);
        }

        $html = '<p>
			<label for="' . $args['name'] . '" class="widefat">' . $args['label'] . '</label>
			<span class="kira-widget-control-group-wrap">';

        if (!empty($args['options'])) {
            foreach ($args['options'] as $key => $value) {
                $uid = uniqid(null, $args['name']);
                $html .= '<label for="' . $uid . '"><input type="radio" name="' . $args['name'] . '" id="' . $uid . '" value="' . esc_html($key) . '" ' . (esc_html($args['value']) == esc_html($key) ? 'checked' : '') . '>' . esc_html($value) . '</label>';
            }
        }

        $html .= '</span>';

        if (!empty($args['description'])) {
            $html .= '<span class="description">' . $args['description'] . '</span>';
        }

        $html .= '</p>';

        return $html;
    }

    /**
     * Field: Checkbox
     *
     * @since 1.0
     */
    public function checkbox($args)
    {
        $defaults = array(
            'name' => '',
            'label' => '',
            'description' => '',
            'options' => array(),
            'value' => '',
            'html_class' => '',
            'html_id' => '',
        );

        $args = wp_parse_args($args, $defaults);

        if (is_string($args['options'])) {
            $args['options'] = $this->_helper($args['options']);
        }

        $html = '<p>
			<label for="' . $args['name'] . '" class="widefat">' . $args['label'] . '</label>
			<span class="kira-widget-control-group-wrap">';

        if (!empty($args['options'])) {
            foreach ($args['options'] as $key => $value) {
                $uid = uniqid(null, $args['name']);
                $html .= '<label for="' . $uid . '"><input type="checkbox" name="' . $args['name'] . '[]" id="' . $uid . '" value="' . esc_html($key) . '" ' . (in_array(esc_html($key), $args['value']) ? 'checked' : '') . '>' . esc_html($value) . '</label>';
            }
        }

        $html .= '</span>';

        if (!empty($args['description'])) {
            $html .= '<span class="description">' . $args['description'] . '</span>';
        }

        $html .= '</p>';

        return $html;
    }

    /**
     * Field: Color
     * @since 1.0
     */

    public function color($args)
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        $defaults = array(
            'name' => '',
            'label' => '',
            'description' => '',
            'value' => '#ffffff',
            'default' => '#ffffff',
        );

        $args = wp_parse_args($args, $defaults);

        $html = '<p>
			<label for="' . $args['name'] . '" class="widefat">' . $args['label'] . '</label>
            <input type="text" name="' . $args['name'] . '" class="color-picker" value="' . $args['value'] . '" data-default-color="' . $args['default'] . '">';

        if (!empty($args['description'])) {
            $html .= '<span class="description">' . $args['description'] . '</span>';
        }

        $html .= '</p>';

        return $html;
    }
}

add_action('admin_init', function () {
    $GLOBALS['kira_widget_options_framework'] = new Kira_Widget_Options_Framework;
});
