<?php
class MY_Form_validation extends CI_Form_validation
{
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->set_custom_error_messages();
    }

    public function set_custom_error_messages()
    {
        $this->set_message('required', '%s欄位為必填');
        $this->set_message('max_length', '%s 長度不可超過 %s 個字元');
        $this->set_message('min_length', '%s 長度不可少於 %s 個字元');
        $this->set_message('matches', '%s 與密碼不一致');
    }
}
