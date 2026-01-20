<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<a class="btn btn--green-outline size-full" data-popup-init="enrollment-notification">Сообщить о поступлении</a>
<div class="popup-holder <?= $arResult["SEND"] ? "active" : false; ?>">
    <div class="popup-scroller">
        <div class="popup-wrapper w-[67rem] xl:w-[67%] mb-0 md:mb-auto pt-15 md:pt-0 popup-enrollment-notification <?= $arResult["SEND"] ? "active" : false; ?>"
             data-popup-name="enrollment-notification">
            <div class="popup__container p-0 md:p-8">
                <button class="absolute -top-15 md:top-8 right-0 md:right-8 flex size-15 md:size-6 bg-loko-green md:bg-white text-white md:text-black group"
                        data-popup-close>
                    <svg class="w-6 h-6 m-auto group-hover:rotate-90 transition-transform">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH_DEFAULT_SHOP ?>dist/img/icons.svg#cross"></use>
                    </svg>
                </button>


                <div class="grid grid-cols-[140px_minmax(0,1fr)] md:grid-cols-[minmax(0,1fr)_minmax(0,2fr)] lg:grid-cols-1 md:grid-rows-[auto_minmax(0,1fr)] md:gap-x-8"
                     id="enrollment-notification-form_content">
                    <form method="POST" action="<?= $_SERVER["PHP_SELF"] ?>" id="<?= $arParams["FORM_ID"]; ?>"
                          name="<?= $arParams["FORM_ID"]; ?>">
                        <?= bitrix_sessid_post() ?>
                        <?
                        if ($arResult["RESULT"] == false) {
                            ?>
                            <div>
                                <div class="title-1">
                                    <span class="text-loko-blue-green text-enrollment-notification">Сообщить о поступлении товара</span>
                                </div>
                                <div class="pt-1-enrollment-notification">
                                    <p>Напишите здесь свой Email </p>
                                    <p>и вам придет автоматическое оповещение,</p>
                                    <p>когда новые размеры поступят в продажу</p>
                                </div>
                            </div>
                            <br>
                            <div>
                                <input class="print-input" name="<?= $arParams["FORM_ID"]; ?>[EMAIL]" type="email"
                                       placeholder="EMAIL@EXAMPLE.COM" required value="<?=$arResult["EMAIL"];?>">
                                <div class="termo__item-inputs">
                                    <div class="print-input__bot">
                                        Введите ваш E-mail*
                                    </div>
                                    <div class="termo__item-inputs-error">
                                        <?= $arResult["ERROR"]["EMAIL"]; ?>
                                    </div>
                                </div>

                                <div class="sm:mt-6 text-sm text-loko-gray font-medium checkbox-enrollment-notification">
                                    <label class="group input-checkbox shrink-0 mt-2">
                                        <input type="checkbox" name="<?= $arParams["FORM_ID"]; ?>[LEGAL]"
                                               id="<?= $arParams["FORM_ID"]; ?>-legal" value="Y" class="legal">
                                        <div class="input-checkbox__ico text-loko-blue-green">
                                            <svg width="19" height="14" viewBox="0 0 19 14" fill="none">
                                                <path d="M2 7L7 12L17 2" stroke="currentColor" stroke-width="2"
                                                      stroke-linecap="square"></path>
                                            </svg>
                                        </div>
                                        <div class="input-checkbox__text">
                                            Согласен с правилами <a target="_blank"
                                                                    href="<?= $arParams["LEGAL_LINK"]; ?>">
                                                обработки персональных данных</a>
                                        </div>
                                    </label>
                                    <div class="termo__item-inputs-error">
                                        <?= $arResult["ERROR"]["LEGAL"]; ?>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn--special w-full btn-enrollment-notification"
                                        data-save-button="true" disabled="">
                                    <span>Отправить</span>
                                    <div class="btn--special__line"></div>
                                </button>

                            </div>
                        <? } else {
                            ?>
                            <div>
                                <div class="title-1">
                                    <?

                                    ?>
                                    <span class="text-loko-blue-green text-enrollment-notification">
                                        <?= $arResult["ERROR"]["MAIN"] ? "Ошибка при отправке" : "Заявка отправлена" ?>
                                    </span>
                                </div>
                                <div class="pt-1-enrollment-notification">
                                    <?
                                    if ($arResult["ERROR"]["MAIN"]) {
                                        ?>
                                        <p><?= $arResult["ERROR"]["MAIN"]; ?></p>
                                    <? } else {
                                        ?>
                                        <p>Ваша заявка отправлена, при поступлении товара, мы Вас оповестим!</p>
                                    <? } ?>
                                </div>
                            </div>
                            <?
                        } ?>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!--<script>-->
<!--    $(document).ready(function() {-->
<!--        $("#enrollment-notification-form").submit(-->
<!--            function(){-->
<!--                sendAjaxForm("enrollment-notification-form_content", "enrollment-notification-form", "/local/components/amigolab/form.enrollment.notification/templates/.default/ajax.php");-->
<!--                return false;-->
<!--            });-->
<!--    });-->
<!--</script>-->