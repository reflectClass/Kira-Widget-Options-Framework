## Kira Widget Options Framework
There are 2 ways to include **Kira** into your project. First is by using it as a plugin; second is by embedding it in your project.

#### Available Fields

 - Text
 - Textarea
 - Color
 - Select
 - Radio
 - Checkbox

#### Creating Options
Use the following fields inside `form` method like this:

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
	
	// Select
	echo $kira_widget_options_framework->select(array(
		'name' => esc_attr($this->get_field_name('select')),
		'label' => __('Select Field', 'kira'),
		'description' => __('This is a select field', 'kira'),
		'options' => array(
			'one' => 'One',
			'two' => 'Two'
		), // array, post, page, menu, user
		'value' => @$instance['select'],
	));
	
	// Radio
	echo $kira_widget_options_framework->radio(array(
		'name' => esc_attr($this->get_field_name('radio')),
		'label' => __('Radio Field', 'kira'),
		'description' => __('This is a radio field', 'kira'),
		'options' => array(
			'one' => 'One',
			'two' => 'Two'
		), // array, post, page, menu, user
		'value' => @$instance['radio'],
	));
	
	// Checkbox
	echo $kira_widget_options_framework->checkbox(array(
		'name' => esc_attr($this->get_field_name('checkbox')),
		'label' => __('Checkbox Field', 'kira'),
		'description' => __('This is a checkbox field', 'kira'),
		'options' => array(
			'one' => 'One',
			'two' => 'Two'
		), // array, post, page, menu, user
		'value' => @$instance['checkbox'],
	));
