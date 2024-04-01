const ansValidate = (() => {
    jQuery.fn.extend({
        setError: function(message, type) {
            return this.each((index, dom) => {
                try {
                    if (ansCommon.isEmpty(message)) {
                        return false;
                    }
                    var typeErr = $(this).attr('type-err');
                    if (!ansCommon.isEmpty(typeErr)) {
                        type = typeErr;
                    }
                    $(this).addClass('item-error');
                    if (ansCommon.isEmpty(type) || type === 'tooltip') {
                        $(this).tooltip({
                            title: message,
                            animation: false,
                            placement: 'top',
                            container: $(this).closest('.have-error'),
                            customClass: 'custom-error'
                        });
                        $(this).off('show.bs.tooltip');
                        $(this).off('shown.bs.tooltip');
                        $(this).off('hide.bs.tooltip');
                        $(this).on('show.bs.tooltip', function () {
                            $('.show-error').tooltip('hide');
                        });
                        $(this).on('shown.bs.tooltip', function () {
                            setTimeout(() => {
                                $(this).addClass('show-error');
                            }, 10);
                        });
                        $(this).on('hide.bs.tooltip', function () {
                            $(this).removeClass('show-error');
                        });
                    } else {
                        var parent = $(this).closest('.have-error');
                        if (parent.length > 0) {
                            parent.append('<p class="msg-err">' + message + '</p>');
                        }
                    }
                } catch (e) {
                    console.log(`SetError[${index}]: ${e.message}`);
                    return false;
                }
            });
        },
        removeError: function() {
            return this.each((index, dom) => {
                $(this).tooltip('dispose');
                $(this).removeClass('item-error');
            });
        }
    });
    $(function() {
        $(document).on('change', '.item-error', function (e) {
            $(this).removeError();
        });
    });
    const _validateByObject = (obj) => {
        try {
            let error = 0;
            removeAllErrors();
            $.each(obj, function (key, element) {
                if (element.attr?.notCheck !== true) {
                    let selector = '#' + key;
                    if (element.attr?.isClass === true) {
                        selector = '.' + key;
                    }
                    $(selector).each(function () {
                        if (!$(this).is(':disabled')) {
                            const val = $(this).val()?.trim().replace(/　/g, '');
                            if ($(this).hasClass('required') && (ansCommon.isEmpty(val) || (element.type === 'select' && val === '0'))) {
                                $(this).setError(sysMsg.E001);
                                error++;
                            }
                            if (!ansCommon.isEmpty(val)) {
                                if (($(this).hasClass('email') || element.type === 'email') && !isEmail(val)) {
                                    $(this).ItemError(sysMsg.E002);
                                    error++;
                                }
                                if ($(this).hasClass('phone') && !isPhone(val)) {
                                    $(this).ItemError(sysMsg.E003);
                                    error++;
                                }
                                if ($(this).hasClass('zip-code') && !isZipCode(val)) {
                                    $(this).ItemError(sysMsg.E004);
                                    error++;
                                }
                                if ($(this).hasClass('katakana') && !isKatakana(val)) {
                                    $(this).ItemError(sysMsg.E005);
                                    error++;
                                }
                                if (!ansCommon.isEmpty($(this).attr('gt')) && ansNumber.toNumber(val) < ansNumber.toNumber($(this).attr('gt'))) {
                                    $(this).ItemError(sysMsg.E006.replace('{0}', $(this).attr('gt')));
                                    error++;
                                }
                                if (!ansCommon.isEmpty($(this).attr('lt')) && ansNumber.toNumber(val) > ansNumber.toNumber($(this).attr('lt'))) {
                                    $(this).ItemError(sysMsg.E007.replace('{0}', $(this).attr('lt')));
                                    error++;
                                }
                            }

                        }
                    });
                }
            });
            if (error > 0) {
                focusFirstError();
                return false;
            }
            else {
                return true;
            }
        } catch (e) {
            console.log('_validateByObject: ' + e.message);
        }
    }
    const _validateBySelector = (selector) => {
        try {
            var error = 0;
            var noCheck = ':not([disabled="disabled"]):not([not-check="true"])';
            removeAllErrors();
            $(selector).find('.required' + noCheck).each(function () {
                const val = $(this).val()?.trim().replace(/　/g, '');
                if (ansCommon.isEmpty(val) || (element.type === 'select' && val === '0')) {
                    $(this).setError(sysMsg.E001);
                    error++;
                }
            });
            $(selector).find('input[type=email]' + noCheck + ',.email' + noCheck).each(function () {
                if (!isEmail($(this).val()?.trim().replace(/　/g, ''))) {
                    $(this).ItemError(sysMsg.E002);
                    error++;
                }
            });
            $(selector).find('.phone' + noCheck).each(function () {
                if (!isPhone($(this).val()?.trim().replace(/　/g, ''))) {
                    $(this).ItemError(sysMsg.E003);
                    error++;
                }
            });
            $(selector).find('.zip-code' + noCheck).each(function () {
                if (!isZipCode($(this).val()?.trim().replace(/　/g, ''))) {
                    $(this).ItemError(sysMsg.E004);
                    error++;
                }
            });
            $(selector).find('.katakana' + noCheck).each(function () {
                if (!isKatakana($(this).val()?.trim().replace(/　/g, ''))) {
                    $(this).ItemError(sysMsg.E005);
                    error++;
                }
            });
            $(selector).find('.gt' + noCheck).each(function () {
                if (!ansCommon.isEmpty($(this).attr('gt')) && ansNumber.toNumber($(this).val()?.trim().replace(/　/g, '')) < ansNumber.toNumber($(this).attr('gt'))) {
                    $(this).ItemError(sysMsg.E006.replace('{0}', $(this).attr('gt')));
                    error++;
                }
            });
            $(selector).find('.lt' + noCheck).each(function () {
                if (!ansCommon.isEmpty($(this).attr('lt')) && ansNumber.toNumber($(this).val()?.trim().replace(/　/g, '')) > ansNumber.toNumber($(this).attr('lt'))) {
                    $(this).ItemError(sysMsg.E007.replace('{0}', $(this).attr('lt')));
                    error++;
                }
            });
            if (error > 0) {
                focusFirstError();
                return false;
            }
            else {
                return true;
            }
        } catch (e) {
            console.log('_validateBySelector: ' + e.message);
        }
    }
    const isEmail = (str) => {
        if (ansCommon.isEmpty(str)) {
            return true;
        }
        return str
          ?.toLowerCase()
          .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          );
    }
    const isPhone = (str) => {
        if (ansCommon.isEmpty(str)) {
            return true;
        }
        return str?.toLowerCase().match(/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})$/);
    }
    const isZipCode = (str) => {
        if (ansCommon.isEmpty(str)) {
            return true;
        }
        return str?.toLowerCase().match(/^\d{3}-\d{4}$/);
    }
    const isKatakana = (str) => {
        if (ansCommon.isEmpty(str)) {
            return true;
        }
        return str?.toLowerCase().match(/[ァ-ンｧ-ﾝﾞﾟ0-9ー]$/);
    }

    const isValid = (obj) => {
        try {
            if (typeof obj === 'object') {
                return _validateByObject(obj);
            }
            else {
                return _validateBySelector(obj);
            }
        } catch (e) {
            console.log('Validate: ' + e.message);
            return false;
        }
    }

    const setErrors = (obj) => {
        $.each(obj, function (key, element) {
            const errorCodePatterns = element[0].split('|');
            let message = _.get(sysMsg, errorCodePatterns[0], errorCodePatterns[0]);
            if (errorCodePatterns.length > 1) {
                for (let j = 0; j < errorCodePatterns.length - 1; j++) {
                  message = message.replace(`{${j}}`, errorCodePatterns[j + 1])
                }
            }
            $(`[name=${key}]`).setError(message);
        });
        focusFirstError();
    }

    const removeAllErrors = () => {
        $('.item-error').tooltip('dispose');
        $('.item-error').removeClass('item-error');
    }

    const focusFirstError = () => {
        $('.item-error').first().focus();
    }

    return {
        isEmail,
        isPhone,
        isZipCode,
        isKatakana,
        isValid,
        setErrors,
        focusFirstError,
        removeAllErrors
    }
})();
