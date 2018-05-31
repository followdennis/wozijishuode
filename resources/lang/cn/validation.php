<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ' :attribute 必须是可接收的.',
    'active_url'           => ' :attribute 不是一个有效的url.',
    'after'                => ' :attribute 必须是大于 :date 的日期.',
    'after_or_equal'       => ':attribute 必须是大于或等于 :date 的日期.',
    'alpha'                => ' :attribute 只能包含字符.',
    'alpha_dash'           => ' :attribute 只能包含字符、数字和破折号.',
    'alpha_num'            => ' :attribute 只能包含字符和数字.',
    'array'                => ' :attribute 必须是数组.',
    'before'               => ' :attribute 必须是一个 :date 之前的日期.',
    'before_or_equal'      => ' :attribute 必须是小于或等于 :date 的日期.',
    'between'              => [
        'numeric' => ' :attribute 必须在 :min 和 :max 之间.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => '、 :attribute 字符数必须介于 :min 和 :max 之间.',
        'array'   => ' :attribute 条数必须在 :min 和 :max 之间.',
    ],
    'boolean'              => ' :attribute 字段必须是布尔类型.',
    'confirmed'            => ' :attribute 不匹配.',
    'date'                 => ' :attribute 不是一个有效的日期.',
    'date_format'          => ' :attribute 不匹配 :format 格式.',
    'different'            => ' :attribute 和 :other 必须不同.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => ' :attribute 必须介于 :min ， :max 之间.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => ' :attribute 有冲突.',
    'email'                => ' :attribute 必须是一个有效的 email 地址.',
    'exists'               => '选中的 :attribute 无效.',
    'file'                 => ' :attribute 必须是一个文件.',
    'filled'               => ' :attribute 字段必填.',
    'image'                => ' :attribute 必须是图片.',
    'in'                   => '选中的 :attribute 无效.',
    'in_array'             => '  :other 中不存在 :attribute .',
    'integer'              => ' :attribute 必须是整型.',
    'ip'                   => ' :attribute 必须是一个有效的 IP 地址.',
    'json'                 => ' :attribute 必须是一个有效的 JSON 字符串.',
    'max'                  => [
        'numeric' => ' :attribute 不能大于 :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => ' :attribute 不能大于 :max 个字符.',
        'array'   => ' :attribute 不能多余 :max 条.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ' :attribute 最少是 :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => ' :attribute 必须最少 :min 个字符.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => '选中的 :attribute 不存在.',
    'numeric'              => ' :attribute 必须是数字类型.',
    'present'              => ' :attribute 必须出现.',
    'regex'                => ' :attribute 格式不存在.',
    'required'             => ' :attribute 必填.',
    'required_if'          => '当 :other 等于 :value :attribute 必填.',
    'required_unless'      => ' 除非 :other 存在于  :values 否则 :attribute  必填.',
    'required_with'        => '当 :values 存在时，:attribute 必填.',
    'required_with_all'    => '当 :values 存在时，:attribute 必填.',
    'required_without'     => '当 :values 不存在时，:attribute必填.',
    'required_without_all' => ' 当 :values 没有时，:attribute 字段必填.',
    'same'                 => 'The :attribute 和 :other 必须一致.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute 必须是 :size 字符.',
        'array'   => 'The :attribute 必须包含 :size 项.',
    ],
    'string'               => ' :attribute 必须是一个字符串.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute 已经存在.',
    'uploaded'             => 'The :attribute 上传失败.',
    'url'                  => 'The :attribute 格式存在.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
