<?

use \Bitrix\Main\Loader;
use Bitrix\Main;
use Bitrix\Main\Application;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class AmigolabNotificationForm extends CBitrixComponent
{

    private $_request;

    private function chekModules()
    {
        if (Loader::includeModule('iblock')) {
            return true;
        }
        return false;
    }


    /**
     * Обертка над глобальной переменной
     * @return CAllMain|CMain
     */
    private function _app()
    {
        global $APPLICATION;
        return $APPLICATION;
    }

    /**
     * Обертка над глобальной переменной
     * @return CAllUser|CUser
     */
    private function _user()
    {
        global $USER;
        return $USER;
    }

    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return mixed
     */
    public function onPrepareComponentParams($arParams)
    {
        $result = [];
        foreach ($arParams as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    protected function addResult($email = null)
    {
        $result = ["RESULT" => false];
        if ($email == null) return $result = ["RESULT" => false, "ERROR_MESSAGE" => "E-mail не может быть пустым"];
        $el = new CIBlockElement;
        $PROPS = [
            "PRODUCT_ID" => $this->arParams["PRODUCT_ID"],
            "PRODUCT_NAME" => $this->arParams["PRODUCT_NAME"],
            "USER_ID" => $this->_user()->GetID(),
            "USER_EMAIL" => $email
        ];
        $arLoadProductArray = [
            "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
            "PROPERTY_VALUES" => $PROPS,
            "NAME" => $PROPS["USER_EMAIL"] . ' | ' . $PROPS["PRODUCT_NAME"],
            "ACTIVE" => "Y"
        ];
        if ($newId = $el->Add($arLoadProductArray)) {
            $result = ["RESULT" => true, "NEW_ID" => $newId];
        } else {
            $result = ["RESULT" => false, "ERROR_MESSAGE" => $el->LAST_ERROR];
        }
        return $result;
    }


    public function executeComponent()
    {
        $this->chekModules();
        $this->arResult["ERROR"] = [];
        $this->_request = Application::getInstance()->getContext()->getRequest();

        $this->arResult["RESULT"] = false;
        $this->arResult["SEND"] = false;

        try {

            if ($this->_request["AJAX_CALL"] == "Y" && $this->_request[$this->arParams["FORM_ID"]]) {

                $this->arResult["EMAIL"] = trim($this->_request[$this->arParams["FORM_ID"]]["EMAIL"]);
                $this->arResult["LEGAL"] = trim($this->_request[$this->arParams["FORM_ID"]]["LEGAL"]);

                if ($this->arResult["EMAIL"] == "") {
                    $this->arResult["ERROR"]["EMAIL"] = "Поле E-mail не может быть пустым";
                } else {
                    if (!check_email($this->arResult["EMAIL"]))
                        $this->arResult["ERROR"]["EMAIL"] = "Не верный формат E-mail";
                }

                if ($this->arResult["LEGAL"] != "Y") {
                    $this->arResult["ERROR"]["LEGAL"] = "Вы должны согласиться с правилами";
                }

                if (count($this->arResult["ERROR"]) === 0) {
                    $addResult = $this->addResult($this->arResult["EMAIL"]);
                    $this->arResult["TEMP"] = $addResult;
                    if (!$addResult["RESULT"]) {
                        $this->arResult["EMAIL"]["MAIN"] = $addResult["ERROR_MESSAGE"];
                        $this->arResult["SEND"] = true;
                    } else {
                        $this->arResult["SEND"] = true;
                        $this->arResult["RESULT"] = true;
                    }
                }else{
                    $this->arResult["SEND"] = true;
                }
                $this->_app()->RestartBuffer();

            }
            $this->includeComponentTemplate();
        } catch (Exception $e) {         //Если произошла к-л ошибка, выводим ошибку
            $this->arResult['ERROR'] = $e->getMessage();
        }
    }
}

?>