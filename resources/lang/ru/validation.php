<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Последующие языковые строки содержат сообщения по-умолчанию, используемые
    | классом, проверяющим значения (валидатором).Некоторые из правил имеют
    | несколько версий, например, size. Вы можете поменять их на любые
    | другие, которые лучше подходят для вашего приложения.
    |
    */

    "accepted"             => "Вы должны принять :attribute.",
    "active_url"           => "Поле :attribute недействительный URL.",
    "after"                => "В поле :attribute должна быть дата после :date.",
    "alpha"                => "Поле :attribute может содержать только буквы.",
    "alpha_dash"           => "Поле :attribute может содержать только буквы, цифры и дефис.",
    "alpha_num"            => "Поле :attribute может содержать только буквы и цифры.",
    "array"                => "Поле :attribute должно быть массивом.",
    "before"               => "В поле :attribute должна быть дата до :date.",
    "between"              => [
        "numeric" => "Поле :attribute должно быть между :min и :max.",
        "file"    => "Размер файла в поле :attribute должен быть между :min и :max Килобайт(а).",
        "string"  => "Количество символов в поле :attribute должно быть между :min и :max.",
        "array"   => "Количество элементов в поле :attribute должно быть между :min и :max."
    ],
    "boolean"              => "Поле :attribute должно иметь значение логического типа.", // калька 'истина' или 'ложь' звучала бы слишком неестественно
    "confirmed"            => "Поле :attribute не совпадает с подтверждением.",
    "date"                 => "Поле :attribute не является датой.",
    "date_format"          => "Поле :attribute не соответствует формату :format.",
    "different"            => "Поля :attribute и :other должны различаться.",
    "digits"               => "Длина цифрового поля :attribute должна быть :digits.",
    "digits_between"       => "Длина цифрового поля :attribute должна быть между :min и :max.",
    "email"                => "Поле :attribute должно быть действительным электронным адресом.",
    "exists"               => "Выбранное значение для :attribute некорректно.",
    "filled"               => "Поле :attribute обязательно для заполнения.",
    "image"                => "Поле :attribute должно быть изображением.",
    "in"                   => "Выбранное значение для :attribute ошибочно.",
    "integer"              => "Поле :attribute должно быть целым числом.",
    "ip"                   => "Поле :attribute должно быть действительным IP-адресом.",
    "max"                  => [
        "numeric" => "Поле :attribute не может быть более :max.",
        "file"    => "Размер файла в поле :attribute не может быть более :max Кб.",
        "string"  => "Количество символов в поле :attribute не может превышать :max.",
        "array"   => "Количество элементов в поле :attribute не может превышать :max."
    ],
    "mimes"                => "Поле :attribute должно быть файлом одного из следующих типов: :values.",
    "min"                  => [
        "numeric" => "Поле :attribute должно быть не менее :min.",
        "file"    => "Размер файла в поле :attribute должен быть не менее :min Килобайт(а).",
        "string"  => "Количество символов в поле :attribute должно быть не менее :min.",
        "array"   => "Количество элементов в поле :attribute должно быть не менее :min."
    ],
    "not_in"               => "Выбранное значение для :attribute ошибочно.",
    "numeric"              => "Поле :attribute должно быть числом.",
    "regex"                => "Поле :attribute имеет ошибочный формат.",
    "required"             => "Поле :attribute обязательно для заполнения.",
    "required_if"          => "Поле :attribute обязательно для заполнения, когда :other равно :value.",
    "required_with"        => "Поле :attribute обязательно для заполнения, когда :values указано.",
    "required_with_all"    => "Поле :attribute обязательно для заполнения, когда :values указано.",
    "required_without"     => "Поле :attribute обязательно для заполнения, когда :values не указано.",
    "required_without_all" => "Поле :attribute обязательно для заполнения, когда ни одно из :values не указано.",
    "same"                 => "Значение :attribute должно совпадать с :other.",
    "size"                 => [
        "numeric" => "Поле :attribute должно быть равным :size.",
        "file"    => "Размер файла в поле :attribute должен быть равен :size Килобайт(а).",
        "string"  => "Количество символов в поле :attribute должно быть равным :size.",
        "array"   => "Количество элементов в поле :attribute должно быть равным :size."
    ],
    "timezone"             => "Поле :attribute должно быть действительным часовым поясом.",
    "unique"               => "Такое значение поля :attribute уже существует.",
    "url"                  => "Поле :attribute имеет ошибочный формат.",

    /*
    |--------------------------------------------------------------------------
    | Собственные языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Здесь Вы можете указать собственные сообщения для атрибутов.
    | Это позволяет легко указать свое сообщение для заданного правила атрибута.
    |
    | http://laravel.com/docs/validation#custom-error-messages
    | Пример использования
    |
    |   'custom' => [
    |       'email' => [
    |           'required' => 'Нам необходимо знать Ваш электронный адрес!',
    |       ],
    |   ],
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'Специальное сообщение',
        ],
        'capabilities' => [
            'required' => 'Вы должны выбрать хотя бы одно разрешение.',
        ],
        'folder_import' => [
            'required_if' => 'Вы должны указать существующую папку, чтобы начать импорт.',
        ],
        'remote_import' => [
            'required_if' => 'Вы должны указать существующий url страницы, чтобы начать импорт.',
        ],
        'users' => [
			'required' => 'Пожалуйста, выберите хотя бы одного пользователя.',
		],
        'document' => [
			'required' => 'Загружаемый Вами документ превышает максимально допустимый размер ' .\Config::get('dms.max_upload_size') . 'KB',
		],
        'slug' => [
            // used when the microsite slug fails to validate
			'regex' => 'The slug must be made of lower case characters with dashes. Must not contain numbers or start with "create".',
		]
    ],


    /*
    |--------------------------------------------------------------------------
    | Собственные названия атрибутов
    |--------------------------------------------------------------------------
    |
    | Последующие строки используются для подмены программных имен элементов
    | пользовательского интерфейса на удобочитаемые. Например, вместо имени
    | поля "email" в сообщениях будет выводиться "электронный адрес".
    |
    | Пример использования
    |
    |   'attributes' => [
    |       'email' => 'электронный адрес',
    |   )
    |
    */

    'attributes' => [],

];
