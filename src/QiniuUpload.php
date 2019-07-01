<?php

namespace Princeh\QiniuUpload;

use Laravel\Nova\Fields\Field;

class QiniuUpload extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'qiniu-upload';
}
