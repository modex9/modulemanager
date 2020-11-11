<?php

class AdminModuleManagerSettingsController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->display = 'edit';
        $this->submit_action = 'submitAddconfigurationAndStay';
        $this->fields_form = 
        [
            'input' => 
            [
                [
                    'type' => 'switch',
                    'label' => 'Translation links',
                    'name' => 'MM_TRANS_LINKS',
                    'is_bool' => true,
                        'values' =>
                        [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->module->getTranslator()->trans('Yes', [], 'Admin.Global')
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->module->getTranslator()->trans('No', [], 'Admin.Global')
                            ]
                        ],
                ],
                [
                    'type' => 'text',
                    'label' => 'Custom Information',
                    'name' => 'MM_CUSTOM_INFO',
                ],
                [
                    'type' => 'color',
                    'label' => 'Background Color',
                    'name' => 'MM_BACKGROUND_COLOR',
                ], 

            ],
            'submit' => [
                'title' => $this->l('Save'),
                'name'=>'submitSettings',
            ]
        ];

        $this->fields_value = 
        [
            'MM_TRANS_LINKS' => Configuration::get('MM_TRANS_LINKS'),
            'MM_CUSTOM_INFO' => Configuration::get('MM_CUSTOM_INFO'),
            'MM_BACKGROUND_COLOR' => Configuration::get('MM_BACKGROUND_COLOR'),
        ];
    }

    public function processSave()
    {
        $res = true;
        foreach(Tools::getAllValues() as $key => $value)
        {
            if(strpos($key, 'MM_') == 0)
            {
                $res &= Configuration::updateValue($key, $value);
                if($res) 
                    $this->fields_value[$key] = $value;
            }
        }
        if($res)
            $this->confirmations[] = $this->trans('Update Sucessful', array(), 'Admin.Notifications.Error');
        else
            $this->errors[] = $this->trans('Updating Settings failed.', array(), 'Admin.Notifications.Error');
    }
}