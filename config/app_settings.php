<?php

return [

    // All the sections for the settings page
    'sections' => [
        'app' => [
            'title' => 'General Settings',
            'descriptions' => 'Application general settings.', // (optional)
            'icon' => 'mdi mdi-cog-outline fs-22', // (optional)

            'inputs' => [
                [
                    'name' => 'app_name', // unique key for setting
                    'type' => 'text', // type of input can be text, number, textarea, select, boolean, checkbox etc.
                    'label' => 'App Name', // label for input
                    // optional properties
                    'placeholder' => 'Application Name', // placeholder for input
                    'class' => 'form-control', // override global input_class
                    'style' => '', // any inline styles
                    'rules' => 'required|min:2|max:20', // validation rules for this input
                    'value' => 'QCode', // any default value
                    'hint' => 'You can set the app name here' // help block text for input
                ],
                [
                    'name' => 'logo',
                    'type' => 'image',
                    'label' => 'Upload logo',
                    'hint' => 'Must be an image and cropped in desired size',
                    'rules' => 'image|max:500',
                    'disk' => 'public', // which disk you want to upload
                    'path' => 'app', // path on the disk,
                    'preview_class' => 'thumbnail',
                    'preview_style' => 'height:40px'
                ],
				[
                    'name' => 'courses', // unique key for setting
                    'type' => 'text', // type of input can be text, number, textarea, select, boolean, checkbox etc.
                    'label' => 'संकाय', // label for input
                    // optional properties
                    'placeholder' => 'संकाय', // placeholder for input
                    'class' => 'form-control', // override global input_class
                    'style' => '', // any inline styles
                    'hint' => 'You can set courses/संकाय  required with comma seperated' // help block text for input
                ],
                [
                    'name' => 'fiscal_year', // unique key for setting
                    'type' => 'text', // type of input can be text, number, textarea, select, boolean, checkbox etc.
                    'label' => 'आर्थिक वर्ष', // label for input
                    // optional properties
                    'placeholder' => 'आर्थिक वर्ष', // placeholder for input
                    'class' => 'form-control', // override global input_class
                    'style' => '', // any inline styles
                    'hint' => 'You can set Fiscal year/आर्थिक वर्ष  required with comma seperated' // help block text for input
                ],
				[
                    'name' => 'designation', // unique key for setting
                    'type' => 'text', // type of input can be text, number, textarea, select, boolean, checkbox etc.
                    'label' => 'Member Designation', // label for input
                    // optional properties
                    'placeholder' => 'Member Desination', // placeholder for input
                    'class' => 'form-control', // override global input_class
                    'style' => '', // any inline styles
                    'hint' => 'You can set member designation with comma seperated' // help block text for input
                ],
				[
                    'name' => 'member_documents', // unique key for setting
                    'type' => 'text', // type of input can be text, number, textarea, select, boolean, checkbox etc.
                    'label' => 'Member Documents', // label for input
                    // optional properties
                    'placeholder' => 'Member Documents', // placeholder for input
                    'class' => 'form-control', // override global input_class
                    'style' => '', // any inline styles
                    'hint' => 'You can set type of member documents required with comma seperated' // help block text for input
                ],
            ]
        ],
        'email' => [
            'title' => 'Email Settings',
            'descriptions' => 'How app email will be sent.',
            'icon' => 'ri-mail-send-line fs-22',

                'inputs' => [
                    [
                        'name' => 'from_email',
                        'type' => 'email',
                        'label' => 'From Email',
                        'placeholder' => 'Application from email',
                        'rules' => 'required|email',
                    ],
                    [
                        'name' => 'from_name',
                        'type' => 'text',
                        'label' => 'Email from Name',
                        'placeholder' => 'Email from Name',
                    ]
                ]
            ],
		'sms' => [
            'title' => 'SMS Settings',
            'descriptions' => 'Required token for sending SMS.',
            'icon' => 'ri-mail-send-line fs-22',

                'inputs' => [
                    [
                        'name' => 'token',
                        'type' => 'text',
                        'label' => 'Auth Key',
                        'placeholder' => 'SMS AUTH KEY',
                    ],
					[
                        'name' => 'api_url',
                        'type' => 'text',
                        'label' => 'SMS Api Url',
                        'placeholder' => 'Api Url',
                    ]
                ]
            ]	
    ],
    

    // Setting page url, will be used for get and post request
    'url' => 'settings',

    // Any middleware you want to run on above route
    'middleware' => ['auth'],

    // Route Names
    'route_names' => [
        'index' => 'settings.index',
        'store' => 'settings.store',
    ],
    
    // View settings
    'setting_page_view' => 'admin_setting',
    'flash_partial' => 'app_settings::_flash',

    // Setting section class setting
    'section_class' => 'card',
    'section_heading_class' => 'card-header',
    'section_body_class' => 'card-body',

    // Input wrapper and group class setting
    'input_wrapper_class' => 'form-group',
    'input_class' => 'form-control',
    'input_error_class' => 'has-error',
    'input_invalid_class' => 'is-invalid',
    'input_hint_class' => 'form-text text-muted',
    'input_error_feedback_class' => 'text-danger',

    // Submit button
    'submit_btn_text' => 'Save Settings',
    'submit_success_message' => 'Settings has been saved.',

    // Remove any setting which declaration removed later from sections
    'remove_abandoned_settings' => false,

    // Controller to show and handle save setting
    'controller' => '\QCod\AppSettings\Controllers\AppSettingController',

    // settings group
    'setting_group' => function() {
        // return 'user_'.auth()->id();
        return 'default';
    }
];
