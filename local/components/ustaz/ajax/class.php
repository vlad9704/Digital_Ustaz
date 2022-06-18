<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class AjaxComponent extends CBitrixComponent implements Controllerable
{
    public function executeComponent()
    {

    }

    /**
     * @return array
     */
    public function configureActions()
    {
        return [
            'registerByMail' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
                    new ActionFilter\Csrf(),
                ],
                'postfilters' => []
            ],
            'confirmRegister' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
                    new ActionFilter\Csrf(),
                ],
                'postfilters' => []
            ],
            'askQuestion' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
                    new ActionFilter\Csrf(),
                ],
                'postfilters' => []
            ],
            'updateProfile' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
                    new ActionFilter\Csrf(),
                ],
                'postfilters' => []
            ],
			'updateMemberType' => [
				'prefilters' => [
					new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
					new ActionFilter\Csrf(),
				],
				'postfilters' => []
			],
            'sendCompetition' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
                    new ActionFilter\Csrf(),
                ],
                'postfilters' => []
            ],
            'workRate' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
                    new ActionFilter\Csrf(),
                ],
                'postfilters' => []
            ],
            'clearWorkRate' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
                    new ActionFilter\Csrf(),
                ],
                'postfilters' => []
            ],
        ];
    }

    /**
     * Первый шаг регистрации
     *
     * @param type $email
     * @return type
     * @global type $USER
     */
    public function registerByMailAction($email)
    {
        $email = htmlspecialchars($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //Почта верная. Создаем пользователя.
            $password = randString(8);
            $confirmCode = randString(8); //код для подтверждения почты
            $arFields = [
                "EMAIL" => "$email",
                "LOGIN" => "$email",
                "LID" => SITE_ID,
                "ACTIVE" => "N",
                //"GROUP_ID"          => [3, 4],
                "PASSWORD" => $password,
                "CONFIRM_PASSWORD" => $password,
                "CONFIRM_CODE" => $confirmCode
            ];

            $user = new CUser;
            $new_user_id = $user->Add($arFields);

            if ($new_user_id === false) {
                return ['status' => 'error', 'message' => $user->LAST_ERROR];
            } else {
                $arFields['USER_ID'] = $new_user_id;
                CEvent::Send("NEW_USER_CONFIRM", SITE_ID, $arFields);
                return ['status' => 'ok', 'message' => 'ok'];
            }
            //return ['status' => 'error', 'message' => print_r($arResult, true . $email)];
        } else {
            return ['status' => 'error', 'message' => 'Неверный mail'];
        }
    }

    /**
     * Завершение регистрации
     *
     */
    public function confirmRegisterAction($userid, $code, $name, $surname, $password, $repassword)
    {
        //Возвращаемые данные
        $feedback = [
            'status' => 'ok',
            'message' => []
        ];

        //Очистить и проверить входящие переменные
        $userid = (int)$userid;
        $code = htmlspecialchars($code);
        $name = htmlspecialchars($name);
        $surname = htmlspecialchars($surname);
        $password = htmlspecialchars($password);
        $repassword = htmlspecialchars($repassword);

        if ($userid == 0) {
            $feedback['status'] = 'error';
            $feedback['message'][] = Loc::getMessage('REGISTER_STEP2_USER_NOT_FOUND');
        }

        if (mb_strlen($name) > 100) {
            $feedback['status'] = 'error';
            $feedback['message'][] = Loc::getMessage('REGISTER_STEP2_NAME_TOO_BIG');
        }

        if (mb_strlen($surname) > 100) {
            $feedback['status'] = 'error';
            $feedback['message'][] = Loc::getMessage('REGISTER_STEP2_SURNAME_TOO_BIG');
        }

        if ($password != $repassword) {
            $feedback['status'] = 'error';
            $feedback['message'][] = Loc::getMessage('REGISTER_STEP2_PASSWORD_MISSMATCH');
        }

        $rsUser = CUser::GetByID($userid);
        $arUser = $rsUser->Fetch();
        if ($arUser !== false) {
            if ($arUser['CONFIRM_CODE'] == $code) {
                //Код из письма подошел, можно продолжать
                //Активируем пользователя, удаляем код подтверждения, меняем пароль
                $obUser = new CUser;
                $uStatus = $obUser->Update($userid, [
                    "NAME" => $name,
                    "LAST_NAME" => $surname,
                    "ACTIVE" => "Y",
                    "CONFIRM_CODE" => "",
                    "PASSWORD" => $password,
                    "CONFIRM_PASSWORD" => $repassword,
                    "UF_PROFILE_STATUS" => 1//статус анкеты - Редактируется
                ]);

                if ($uStatus) {
                    //Все хорошо
                    global $USER;
                    $USER->Authorize($userid);
                    $feedback['status'] = 'ok';
                    $feedback['message'][] = 'ok';
                } else {
                    $feedback['status'] = 'error';
                    $feedback['message'][] = $obUser->LAST_ERROR;
                }

            } else {
                $feedback['status'] = 'error';
                $feedback['message'][] = Loc::getMessage('REGISTER_STEP2_CONFIRM_CODE_ERROR');
            }
        } else {
            $feedback['status'] = 'error';
            $feedback['message'][] = Loc::getMessage('REGISTER_STEP2_USER_NOT_FOUND');
        }

        return [
            'status' => $feedback['status'],
            'message' => implode('<br>', $feedback['message'])
        ];
    }

    /**
     * Форма задать вопрос
     */
    public function askQuestionAction($name, $email, $text)
    {
        //Возвращаемые данные
        $feedback = [
            'status' => 'ok',
            'message' => []
        ];

        //Очистить и проверить входящие переменные
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $text = htmlspecialchars($text);

        if (mb_strlen($name) == 0) {
            $feedback['status'] = 'error';
            $feedback['message'][] = Loc::getMessage('FEEDBACK_NAME_TOO_SMALL');
        }

        if (mb_strlen($name) > 100) {
            $feedback['status'] = 'error';
            $feedback['message'][] = Loc::getMessage('FEEDBACK_NAME_TOO_BIG');
        }

        if (mb_strlen($text) == 0) {
            $feedback['status'] = 'error';
            $feedback['message'][] = Loc::getMessage('FEEDBACK_TEXT_TOO_SMALL');
        }

        if (mb_strlen($text) > 3000) {
            $feedback['status'] = 'error';
            $feedback['message'][] = Loc::getMessage('FEEDBACK_TEXT_TOO_BIG');
        }

        if ($feedback['status'] == 'ok') {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                //Проверки пройдены можно отправить письмо
                $arFields = [
                    "AUTHOR" => $name,
                    "AUTHOR_EMAIL" => $email,
                    "TEXT" => $text,
                    "LID" => SITE_ID,
                    "EMAIL_TO" => FEEDBACK_RECIPIENT
                ];
                CEvent::Send("FEEDBACK_FORM", SITE_ID, $arFields);
                $feedback['status'] = 'ok';
                $feedback['message'][] = 'ok';
            } else {
                $feedback['status'] = 'error';
                $feedback['message'] = Loc::getMessage('FEEDBACK_EMAIL_MISSMATCH');
            }
        }
        return [
            'status' => $feedback['status'],
            'message' => implode('<br>', $feedback['message'])
        ];

    }

    /**
     * Анкета пользователя
     */
    public function updateProfileAction($data)
    {
        //Возвращаемые данные
        $feedback = [
            'status' => 'ok',
            'message' => [],
            'fields' => [] //поля с ошибками
        ];

        //$feedback['message'][] = print_r($data, 1);
        //$feedback['message'][] = print_r($_FILES, 1);

        //Поля пользователя для обновления профиля
        $arFields = [];

        //MIME типы для аватарки
        $mime = [
            'image/jpeg',
            'image/pjpeg',
            'image/png',
        ];

        $errorUploadAvatar = false;
        //Проверка аватарки на размер и тип файла
        if (isset($_FILES['file_avatar']) && $_FILES['file_avatar']['name'] && !CFile::CheckFile($_FILES['file_avatar'], 10 * 1024 * 1024, $mime, 'jpeg,jpg,png')) {
            $fileInfo = $_FILES['file_avatar'];
            $fileInfo['MODULE_ID'] = 'main';

            $fileId = CFile::SaveFile($fileInfo, 'user_photo');
            if ($fileId > 0) {
                $arFields['PERSONAL_PHOTO'] = \CFile::MakeFileArray($fileId);

                $user = new CUser;
                $user->Update($GLOBALS["USER"]->GetId(), $arFields);
                $feedback['message'][] = $user->LAST_ERROR;
            } else {
                $errorUploadAvatar = true;
                $feedback['fileds'][] = $_FILES['file_avatar'];
            }
        } elseif (isset($data['avatar_delete']) && $data['avatar_delete'] == '1') {
            //Пользователь решил удалить аватар
            $userInfo = CUser::GetByID($GLOBALS["USER"]->GetId())->Fetch();
            $arFields['PERSONAL_PHOTO'] = [
                'del' => 'Y',
                'old_file' => $userInfo['PERSONAL_PHOTO']
            ];

            $user = new CUser;
            $user->Update($GLOBALS["USER"]->GetId(), $arFields);
        } elseif (isset($_FILES['file_avatar']) && $_FILES['file_avatar']['name']) {
            $errorUploadAvatar = true;
        }

        //Если аватарка не загрузилась
        if ($errorUploadAvatar) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'file_avatar';
        }

        //Фамилия
        if (isset($data['last_name']) === false || mb_strlen($data['last_name']) < 1 || mb_strlen($data['last_name']) > 50) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'last_name';
        } else {
            $arFields['LAST_NAME'] = $data['last_name'];
        }

        //Имя
        if (isset($data['name']) === false || mb_strlen($data['name']) < 1 || mb_strlen($data['name']) > 50) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'name';
        } else {
            $arFields['NAME'] = $data['name'];
        }

        //Отчество
        if (isset($data['second_name']) === false || mb_strlen($data['second_name']) < 1 || mb_strlen($data['second_name']) > 50) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'second_name';
        } else {
            $arFields['SECOND_NAME'] = $data['second_name'];
        }

        //Дата рождения 2010-12-30 -> 10.08.2021
        $tmpVar = explode('-', $data['personal_birthday']);
        //$feedback['message'][] = print_r($tmpVar, 1);
        if ((int)$tmpVar[0] > 2006 || (int)$tmpVar[0] < 1951) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'personal_birthday';
        } else {
            $arFields['PERSONAL_BIRTHDAY'] = (int)$tmpVar[2] . "." . (int)$tmpVar[1] . "." . (int)$tmpVar[0];
        }

        //Город
        if (isset($data['personal_city']) === false || mb_strlen($data['personal_city']) < 1 || mb_strlen($data['personal_city']) > 150) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'personal_city';
        } else {
            $arFields['PERSONAL_CITY'] = $data['personal_city'];
        }

        //Название и номер школы
        if (isset($data['uf_school']) === false || mb_strlen($data['uf_school']) < 1 || mb_strlen($data['uf_school']) > 150) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_school';
        } else {
            $arFields['UF_SCHOOL'] = $data['uf_school'];
        }

        //Район
        if (isset($data['uf_school_area']) === false || mb_strlen($data['uf_school_area']) < 1 || mb_strlen($data['uf_school_area']) > 150) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_school_area';
        } else {
            $arFields['UF_SCHOOL_AREA'] = $data['uf_school_area'];
        }

        //Оработчик опшинов про Гос и не Гос школа
        switch ($data['uf_school_com']) {
            case 'USER_PROFILE_OPTION_SCHOOL_COM_GOS':
                //Гос учреждение
                $arFields['UF_SCHOOL_COM'] = 'USER_PROFILE_OPTION_SCHOOL_COM_GOS';
                break;
            case 'USER_PROFILE_OPTION_SCHOOL_COM_NEGOS':
                //Гос учреждение
                $arFields['UF_SCHOOL_COM'] = 'USER_PROFILE_OPTION_SCHOOL_COM_NEGOS';
                break;
            default:
                //
                $feedback['status'] = 'error';
                $feedback['fileds'][] = 'uf_school_com';
                break;
        }

		// Участник / Слушатель
		switch ($data['uf_member_type']) {
			case 'USER_PROFILE_OPTION_PERSON_TYPE_MEMBER':
				// Участник
				$arFields['UF_MEMBER_TYPE'] = 'USER_PROFILE_OPTION_PERSON_TYPE_MEMBER';
				break;
			case 'USER_PROFILE_OPTION_PERSON_TYPE_LISTENER':
				// Слушатель
				$arFields['UF_MEMBER_TYPE'] = 'USER_PROFILE_OPTION_PERSON_TYPE_LISTENER';
				break;
			default:
				//
				$feedback['status'] = 'error';
				$feedback['fileds'][] = 'uf_member_type';
				break;
		}

        //Тип школы
        if (isset($data['uf_school_type']) === false || mb_strlen($data['uf_school_type']) < 1 || mb_strlen($data['uf_school_type']) > 150) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_school_type';
        } else {
            $arFields['UF_SCHOOL_TYPE'] = $data['uf_school_type'];
        }

        //Ваша специализация
        if (isset($data['uf_specialty']) === false || mb_strlen($data['uf_specialty']) < 1 || mb_strlen($data['uf_specialty']) > 150) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_specialty';
        } else {
            $arFields['UF_SPECIALTY'] = $data['uf_specialty'];
        }

        //Язык преподавания
        if (is_array($data['uf_language']) && count($data['uf_language']) > 0) {
            $arFields['UF_LANGUAGE'] = implode(',', $data['uf_language']);
        } else {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_language';
        }

        //Стаж работы
        if (isset($data['uf_user_experience']) === false || mb_strlen($data['uf_user_experience']) < 1 || mb_strlen($data['uf_user_experience']) > 50) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_user_experience';
        } else {
            $arFields['UF_USER_EXPERIENCE'] = $data['uf_user_experience'];
        }

        //Какие приложения используете uf_user_im
        /**
         * if (is_array($data['uf_user_im']) && count($data['uf_user_im']) > 0){
         * $arFields['UF_IM_TYPE'] = implode(',', $data['uf_user_im']);
         * } else {
         * $feedback['status'] = 'error';
         * $feedback['fileds'][] = 'uf_user_im';
         * }
         **/
        if (isset($data['uf_user_im']) === false || mb_strlen($data['uf_user_im']) < 1 || mb_strlen($data['uf_user_im']) > 50) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_user_im';
        } else {
            $arFields['UF_IM_TYPE'] = $data['uf_user_im'];
        }

        //Ваше образование UF_EDUCATIONY
        if (isset($data['uf_education']) === false || mb_strlen($data['uf_education']) < 1 || mb_strlen($data['uf_education']) > 400) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_education';
        } else {
            $arFields['UF_EDUCATION'] = $data['uf_education'];
        }


        //Язык участия $arResult['user']['UF_PARTICIPATION_LANG']
        if (is_array($data['uf_participation_lang']) && count($data['uf_participation_lang']) > 0) {
            $tmpLang = [];
            if (in_array('USER_PROFILE_OPTION_PARTICIPATION_LANG_RU', $data['uf_participation_lang'])) {
                $tmpLang[] = 'USER_PROFILE_OPTION_PARTICIPATION_LANG_RU';
            }

            if (in_array('USER_PROFILE_OPTION_PARTICIPATION_LANG_KZ', $data['uf_participation_lang'])) {
                $tmpLang[] = 'USER_PROFILE_OPTION_PARTICIPATION_LANG_KZ';
            }

            if (count($tmpLang) > 0) {
                $arFields['UF_PARTICIPATION_LANG'] = implode(',', $tmpLang);
            } else {
                $feedback['status'] = 'error';
                $feedback['fileds'][] = 'uf_participation_lang';
            }
        } else {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_participation_lang';
        }


        //В какое время Вам было бы удобно участвовать в вебинарах и мастер-классах?
        if (is_array($data['uf_meetup_time']) && count($data['uf_meetup_time']) > 0) {
            $tmpMtime = [];
            if (in_array('USER_PROFILE_OPTION_MEETUP_TIME_1', $data['uf_meetup_time'])) {
                $tmpMtime[] = 'USER_PROFILE_OPTION_MEETUP_TIME_1';
            }

            if (in_array('USER_PROFILE_OPTION_MEETUP_TIME_2', $data['uf_meetup_time'])) {
                $tmpMtime[] = 'USER_PROFILE_OPTION_MEETUP_TIME_2';
            }

            if (count($tmpMtime) > 0) {
                $arFields['UF_MEETUP_TIME'] = implode(',', $tmpMtime);
            } else {
                $feedback['status'] = 'error';
                $feedback['fileds'][] = 'uf_meetup_time';
            }
        } else {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_meetup_time';
        }


        //Расскажите о своих особых пожеланиях или задайте вопрос
        if (isset($data['uf_user_notes']) === false || mb_strlen($data['uf_user_notes']) < 1 || mb_strlen($data['uf_user_notes']) > 1000) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'uf_user_notes';
        } else {
            $arFields['UF_USER_NOTES'] = $data['uf_user_notes'];
        }

        $filesMimeTypes = [
            'profdoc' => [
                'application/msword',
                'text/plain',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
            'experience' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'application/pdf',
            ],
        ];

        //Загружаем файл для блока "Загрузите резюме с указанием курсов повышения квалификации" UF_FILE_PROFDOC
        $ext = pathinfo($_FILES['file_profdoc']['name'], PATHINFO_EXTENSION);
        if (isset($_FILES['file_profdoc']) /* && in_array($ext, ['docx','doc','txt'] )*/) {
            if ($feedback['status'] != 'error') {
                $fileInfo = $_FILES['file_profdoc'];
                $fileInfo['MODULE_ID'] = 'main';
                $fileId = CFile::SaveFile($fileInfo, "user_data");
                if ($fileId > 0) {
                    $arFields['UF_FILE_PROFDOC'] = \CFile::MakeFileArray($fileId);
                } else {
                    $feedback['status'] = 'error';
                    $feedback['fileds'][] = 'file_profdoc';
                }
            }
        } else {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'file_profdoc';
        }

        //Загрузите скан-копию справки с места работы с указанием стажа UF_EXPERIENCE
        $ext = pathinfo($_FILES['file_experience']['name'], PATHINFO_EXTENSION);
        if (isset($_FILES['file_experience']) /* && in_array($ext, ['pdf','jpeg','jpg','png'] )*/) {
            if ($feedback['status'] != 'error') {
                $fileInfo = $_FILES['file_experience'];
                $fileInfo['MODULE_ID'] = 'main';
                $fileId = CFile::SaveFile($fileInfo, "user_data");
                if ($fileId > 0) {
                    $arFields['UF_EXPERIENCE'] = \CFile::MakeFileArray($fileId);
                } else {
                    $feedback['status'] = 'error';
                    $feedback['fileds'][] = 'file_experience';
                }
            }
        } else {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'file_experience';
        }

        //Чекбокс согласия с политикой конфиденциальности
        if (isset($data['user_agreement']) === false) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'user_agreement';
        }


        //Проводим обновление данных пользователя
        if ($feedback['status'] == 'ok') {
            //Сменим статус анкеты на "На модерации"
            $arFields['UF_PROFILE_STATUS'] = 2;

            //Обновим
            $user = new CUser;
            $user->Update($GLOBALS["USER"]->GetId(), $arFields);
            $feedback['message'][] = $user->LAST_ERROR;
        } else {
            //$feedback['message'] = Loc::getMessage('USER_PROFILE_FORM_ERROR_MSG');
        }
        //$feedback['message'][] = print_r($arFields, true);

        return [
            'status' => $feedback['status'],
            'message' => implode('<br>', $feedback['message']),
            'fields' => $feedback['fileds']
        ];
    }

    /**
     * Конкурс. Отправка работ с привязкой к Этапу.
     */
    public function sendCompetitionAction($data)
    {
        //Возвращаемые данные
        $feedback = [
            'status' => 'ok',
            'message' => [],
            'fields' => [] //поля с ошибками
        ];

        //Идентификаторы стадий. Знаю, что так себе идея, но это быстрее.
        $stageList = [
            '1' => 3,
            '2' => 4,
            '3' => 5
        ];

        //$feedback['message'][] = print_r($data, 1);
        //$feedback['message'][] = print_r($_FILES, 1);

        $data['stage'] = (int)$data['stage'];
        if ($data['stage'] <= 0 || $data['stage'] > 3) {
            throw new Exception('Неизвестный этап Конкурса ' . $data['stage']);
        } else {
            $arFields['stage'] = [
                'VALUE' => $stageList[$data['stage']]
            ];
        }

        if (in_array($data['stage'], DISABLED_STAGES)){
            throw new Exception('Работы не принимаются ' . $data['stage']);
        }

        if (in_array($data['lang'], ['ru', 'kz'])) {
            $arFields['competiton_lang'] = $data['lang'];
        } else {
            throw new Exception('Неизвестный язык ' . $data['lang']);
        }

        if (isset($data['url']) === false || mb_strlen($data['url']) < 1 || mb_strlen($data['url']) > 1000) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'url';
        } else {
            $arFields['competition_url'] = htmlentities($data['url']);
        }

        if (isset($data['text']) === false || mb_strlen($data['text']) < 1 || mb_strlen($data['text']) > 10000) {
            $feedback['status'] = 'error';
            $feedback['fileds'][] = 'text';
        } else {
            $arFields['competition_text'] = htmlentities($data['text']);
        }

        //Проводим добавление новой конкурсной работы
        if ($feedback['status'] == 'ok') {
            //Владелец работы
            $arFields['competition_user_id']['VALUE'] = $GLOBALS["USER"]->GetId();
            $userInfo = CUser::GetByID($GLOBALS["USER"]->GetId())->Fetch();


            //Обновим
            $arFields = array(
                "ACTIVE" => "Y",
                "IBLOCK_ID" => IBLOCK_COMPETITION_WORKS,
                "NAME" => $userInfo['LAST_NAME'] . ' ' . $userInfo['NAME'] . '. Этап ' . $data['stage'],
                "PROPERTY_VALUES" => $arFields
            );
            $oElement = new CIBlockElement();
            $idElement = $oElement->Add($arFields, false, false, false);
            $feedback['message'][] = $oElement->LAST_ERROR;
        } else {
            //$feedback['message'] = Loc::getMessage('USER_PROFILE_FORM_ERROR_MSG');
        }

        return [
            'status' => $feedback['status'],
            'message' => implode('<br>', $feedback['message']),
            'fields' => $feedback['fileds']
        ];

    }


    /**
     * Оценка работы экспертом
     * @param int $work_id
     * @param array $rating
     * @return array
     */
    public function workRateAction($work_id, $rating)
    {
        global $USER;
        $work_id = (int)$work_id;
        $work_experts_property_id = 69;
        //Проверка принадлежности пользователя к группе эксперты
        if (!CSite::InGroup([5])) {
            return [
                'message' => '',
            ];
        }

        if (!$work_id) {
            return [
                'message' => '',
            ];
        }

        $arSelect = ['*', 'PROPERTY_stage', 'PROPERTY_competition_user_id'];
        $arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_WORKS, 'ACTIVE' => 'Y', 'PROPERTY_experts' => $USER->GetID(), 'ID' => $work_id];
        $work = CIBlockElement::GetList([], $arFilter, false, false, $arSelect)->fetch();
        //Работа не найдена или текущий пользователь (эксперт) не привязан к ней
        if (!$work) {
            return [
                'message' => '',
            ];
        }

        $arUser = CUser::GetByID($work['PROPERTY_COMPETITION_USER_ID_VALUE'])->Fetch();

        $userFieldEnum = new CUserFieldEnum();
        $userStage = $userFieldEnum->GetList([], [
            'ID' => $arUser['UF_COMPETITION_STAGE'],
        ])->Fetch();

        if (!$userStage) {
            return [
                'message' => '',
            ];
        }

        //Если стадия работы отличается от стадии на которой находится пользователь
        if ($userStage['VALUE'] != $work['PROPERTY_STAGE_VALUE']) {
            return [
                'message' => '',
            ];
        }

        //Удаляем старые оценки эксперта
        $arSelect = ['ID', 'IBLOCK_ID'];
        $arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_WORKS_RATING, 'ACTIVE' => 'Y', 'PROPERTY_work' => $work_id, 'PROPERTY_expert' => $USER->GetID()];
        $workRatingsRes = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        while ($ob = $workRatingsRes->GetNext()) {
            CIBlockElement::Delete($ob['ID']);
        }

        //Перебираем все критерии оценок и добавляем оценки
        $arSelect = ['ID', 'IBLOCK_ID', 'NAME', 'PROPERTY_stage'];
        $arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_RATING_CRITERIA, 'ACTIVE' => 'Y'];
        $criteriaRatingRes = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        while ($ob = $criteriaRatingRes->GetNext()) {
            if ($ob['PROPERTY_STAGE_VALUE'] != $work['PROPERTY_STAGE_VALUE']) {
                continue;
            }
            $element = new CIBlockElement();
            $element->Add([
                'IBLOCK_ID' => IBLOCK_COMPETITION_WORKS_RATING,
                'NAME' => $work['NAME'] . " " . $ob['NAME'] . "[" . $ob['ID'] . "] (" . $USER->GetFullName() . ")",
                'PROPERTY_VALUES' => [
                    'criteria' => $ob['ID'],
                    'rating' => (int)($rating[$ob['ID']] ?? 0),
                    'work' => $work['ID'],
                    'expert' => $USER->GetID(),
                ],

            ]);
        }

        //Количество экспертов у работы
        /*$expertsCount = count(\Bitrix\Iblock\ElementPropertyTable::getList(['filter' => [
            'IBLOCK_PROPERTY_ID' => $work_experts_property_id,
            'IBLOCK_ELEMENT_ID' => $work['ID'],
        ], 'group' => 'VALUE'])->fetchAll());

        //Количество оценок
        $arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_WORKS_RATING, 'ACTIVE' => 'Y', 'PROPERTY_work' => $work['ID']];
        $expertRatingCount = CIBlockElement::GetList([], $arFilter, ['PROPERTY_expert'])->SelectedRowsCount();

        //Если количество экспертов больше или равно 3 и все поставили оценки, то переводим пользователя на сделующую стадию
        if ($expertsCount >= 3 && $expertRatingCount == $expertsCount) {
            $stages = ['I' => 1, 'II' => 2, 'III' => 3];
            $nextStageNum = ($stages[$work['PROPERTY_STAGE_VALUE']] ?? 0) + 1;

            if ($nextStageNum <= 3) {
                $userFieldEnum = new CUserFieldEnum();
                $userNextStage = $userFieldEnum->GetList([], [
                    'XML_ID' => 'user_stage_' . $nextStageNum,
                ])->Fetch();

                $user = new CUser();
                $user->Update($work['PROPERTY_COMPETITION_USER_ID_VALUE'], ['UF_COMPETITION_STAGE' => $userNextStage['ID']]);
            }
        }*/

        return [
            'redirect' => true,
        ];
    }


    /**
     * Удаление оценок эесперта
     * @param int $work_id
     * @param array $rating
     * @return array
     */
    public function clearWorkRateAction($work_id, $rating)
    {
        global $USER;
        $work_id = (int)$work_id;
        $work_experts_property_id = 69;
        //Проверка принадлежности пользователя к группе эксперты
        if (!CSite::InGroup([5])) {
            return [
                'message' => '',
            ];
        }

        if (!$work_id) {
            return [
                'message' => '',
            ];
        }

        $arSelect = ['*', 'PROPERTY_stage', 'PROPERTY_competition_user_id'];
        $arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_WORKS, 'ACTIVE' => 'Y', 'PROPERTY_experts' => $USER->GetID(), 'ID' => $work_id];
        $work = CIBlockElement::GetList([], $arFilter, false, false, $arSelect)->fetch();

        //Работа не найдена или текущий пользователь (эксперт) не привязан к ней
        if (!$work) {
            return [
                'message' => '',
            ];
        }

        $arUser = CUser::GetByID($work['PROPERTY_COMPETITION_USER_ID_VALUE'])->Fetch();

        $userFieldEnum = new CUserFieldEnum();
        $userStage = $userFieldEnum->GetList([], [
            'ID' => $arUser['UF_COMPETITION_STAGE'],
        ])->Fetch();

        if (!$userStage) {
            return [
                'message' => '',
            ];
        }

        //Если стадия работы отличается от стадии на которой находится пользователь
        if ($userStage['VALUE'] != $work['PROPERTY_STAGE_VALUE']) {
            return [
                'message' => '',
            ];
        }

        //Удаляем старые оценки эксперта
        $arSelect = ['ID', 'IBLOCK_ID'];
        $arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_WORKS_RATING, 'ACTIVE' => 'Y', 'PROPERTY_work' => $work_id, 'PROPERTY_expert' => $USER->GetID()];
        $workRatingsRes = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        while ($ob = $workRatingsRes->GetNext()) {
            CIBlockElement::Delete($ob['ID']);
        }

        //Количество экспертов у работы
        $expertsCount = count(\Bitrix\Iblock\ElementPropertyTable::getList(['filter' => [
            'IBLOCK_PROPERTY_ID' => $work_experts_property_id,
            'IBLOCK_ELEMENT_ID' => $work['ID'],
        ], 'group' => 'VALUE'])->fetchAll());

        return [
            'message' => Loc::getMessage('WORK_RATING_CLEARED'),
        ];
    }
}
























