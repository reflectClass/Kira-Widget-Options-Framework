## Kira Widget Options Framework
There are 2 ways to include **Kira** into your project. First is by using it as a plugin; second is by embedding it in your project.

#### Creating Options
    global $kira_widget_options_framework;
    
    // Text
	echo $kira_widget_options_framework->text(array(
		'name' => esc_attr($this->get_field_name('text')),
		'label' => __('Text Field', 'kira'),
		'description' => __('This is a text field', 'kira'),
		'value' => @$instance['text'],
	));
	
	// Textarea
	echo $kira_widget_options_framework->textarea(array(
		'name' => esc_attr($this->get_field_name('textarea')),
		'label' => __('Textarea Field', 'kira'),
		'description' => __('This is a textarea field', 'kira'),
		'value' => @$instance['textarea'],
	));
	
	// Color
	echo $kira_widget_options_framework->color(array(
		'name' => esc_attr($this->get_field_name('color')),
		'label' => __('Color Field', 'kira'),
		'description' => __('This is a color field', 'kira'),
		'value' => @$instance['color'],
		'default' => '#ffffff',
	));
