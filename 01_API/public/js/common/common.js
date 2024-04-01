const ansCommon = (() => {
    const initEvents = () => {
        $(document).on('keydown', 'input.alphabet', function (e) {
            return limitInputFollowType(e, {
                type: 'alphabet'
            });
        });
        $(document).on('keydown', 'input.phone', function (e) {
            return limitInputFollowType(e, {
                type: 'tel'
            });
        });
        $(document).on('blur', 'input.katakana', function () {
            $(this).val($(this).val().replace(/[^ァ-ンーｧ-ﾝﾞﾟ0-9]/gi, ''))
        });
    }
    const isEmpty = (str, isCheckZero = false) => {
        if (
            str === undefined ||
            str === null ||
            str === '' ||
            (isCheckZero && (str === 0 || str === '0'))
        ) {
            return true;
        }
        if (typeof str === 'object' && Object.keys(str).length === 0) {
            return true;
        }
        return false;
    }
    const isMobile = () => {
        let check = false;
        try {
            try {
                check = navigator.userAgentData.mobile;
            } catch (e) {
                ;(function (a) {
                if (
                    /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(
                    a
                    ) ||
                    // eslint-disable-next-line no-useless-escape
                    /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
                    a.substr(0, 4)
                    )
                )
                    check = true;
                })(navigator.userAgent || navigator.vendor || window.opera);
            }
        } catch (ex) {}
        if (!check && window.outerWidth <= 768 && window.outerWidth > 0) {
            check = true;
        }
        return check;
    }
    const limitInputFollowType = (e, options = {
        isNegative: false,
        isDecimal: false,
        type: 'text'
    }) => {
        const val = $(e.target).val();
        if (
          !(
            (e.key >= '0' && e.key <= '9') ||
            e.key === 'F5' ||
            e.key === 'Delete' ||
            e.key === 'ArrowRight' ||
            e.key === 'ArrowLeft' ||
            e.key === 'End' ||
            e.key === 'Home' ||
            e.key === 'Backspace' ||
            e.key === 'Tab' ||
            e.key === 'Enter' ||
            (e.ctrlKey && (e.key === 'c' || e.key === 'v' || e.key === 'a')) ||
            (options.isNegative && val.indexOf('-') < 0 && e.key === '-') ||
            (options.isDecimal && val.indexOf('.') < 0 && e.key === '.') ||
            (options.type === 'tel' &&
                (e.key === '+' || e.key === '(' || e.key === ')' || e.key === '-' || e.key === ' ')) ||
            (options.type === 'alphabet' &&
                ((e.key >= 'a' && e.key <= 'z') || (e.key >= 'A' && e.key <= 'Z'))) ||
            (options.type === 'date' && (_.countBy(val)['/'] || 0) < 2  && e.key === '/') ||
            (options.type === 'month' && val.indexOf('/') < 0 && e.key === ':') ||
            (options.type === 'time' && val.indexOf(':') < 0 && e.key === ':')
          )
        ) {
          e.preventDefault()
          return false
        }
        return true
    }
    const initItems = (obj) => {
        try {
            let i = 0;
            let firstElement = '';
            $.each(obj, function (key, element) {
                let selector = '#' + key;
                if (element.attr?.isClass === true) {
                    selector = '.' + key;
                }
                if (i === 0) {
                    firstElement = selector;
                }
                i++;
                if (element.attr?.maxlength) {
                    $(selector).attr('maxlength', element.attr.maxlength);
                    $(selector).attr('real-max-length', element.attr.maxlength);
                }
                if (element.attr?.class) {
                    $(selector).addClass(element.attr.class);
                    if (element.attr.class.indexOf('required') >= 0) {
                        $(selector).attr('required', 'required');
                    }
                }
                if (element.attr?.decimal) {
                    $(selector).attr('decimal', element.attr.decimal);
                    $(selector).addClass('numeric');
                }
                if (element.attr?.readonly) {
                    $(selector).attr('readonly', element.attr.readonly);
                }
                if (element.attr?.disabled) {
                    $(selector).attr('disabled', element.attr.disabled);
                }
                if (element.attr?.tabindex) {
                    $(selector).attr('tabindex', element.attr.tabindex);
                }
                if (element.attr?.notCheck === true) {
                    $(selector).attr('not-check', element.attr.notCheck);
                    $(selector).addClass('not-check');
                }
                if (element.attr?.minlength) {
                    $(selector).attr('minlength', element.attr.minlength);
                }
                if (element.attr?.gt) {
                    $(selector).attr('gt', element.attr.gt);
                    $(selector).addClass('gt');
                }
                if (element.attr?.lt) {
                    $(selector).attr('lt', element.attr.lt);
                    $(selector).addClass('lt');
                }
                if (element.attr?.typeErr) {
                    $(selector).attr('type-err', element.attr.typeErr);
                }
                if (element.attr?.noFirstFocus === true) {
                    $(selector).attr('no-first-focus', element.attr.noFirstFocus);
                    $(selector).addClass('no-first-focus');
                }
                if (element.attr?.noRename !== true && $(selector).length > 0) {
                    $(selector).attr('name', key);
                }
            });
            if (isEmpty($(firstElement).attr('no-first-focus'))) {
                $(firstElement).first().focus();
            }
        } catch (e) {
            console.log('initItem: ' + e.message);
        }
    }
    const getData = (obj) => {
        try {
            const data = {};
            $.each(obj, function (key, element) {
                let selector = '#' + key;
                if (element.attr?.isClass === true) {
                    selector = '.' + key;
                }
                if (element.type === 'checkbox') {
                    if ($(selector).is(':checked')) {
                        data[key] = true;
                    }
                    else {
                        data[key] = false;
                    }
                } else if (element.type === 'radio') {
                    $('input[name=' + element.attr?.name + ']').each(function () {
                        if ($(this).is(':checked')) {
                            data[key] = $(this).val();
                        }
                    });
                } else if (element.type === 'listCheckbox') {
                    data[key] = [];
                    $('input[name=' + element.attr?.name + ']').each(function () {
                        if ($(this).is(':checked')) {
                            data[key].push($(this).val());
                        }
                    });
                } else {
                    data[key] = $(selector).val();
                    if ($(selector).hasClass('numeric')) {
                        data[key] = data[key].replace(/,/g, '')
                    }
                }
            });
            return data;
        }
        catch (e) {
            console.log('getData: ' + e.message);
            return {};
        }
    }
    const uuidv4 = () => {
        return "10000000-1000-4000-8000-100000000000".replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    }
    const showLoading = () => {
        $('#ansLoading').removeClass('hide');
    }
    const hideLoading = () => {
        $('#ansLoading').addClass('hide');
    }
    const showMessage = (mes) => {
        const message = {
            type: msgType.ERROR,
            title: msgTitle.E999,
            content: sysMsg.E999,
            okText: 'はい',
            cancelText: 'いいえ',
            callback: () => {},
            ...mes
        };
        const $ansMessage = $('#ansMessage');
        const $btnCancel = $ansMessage.find('.btn-cancel');
        const $btnOk = $ansMessage.find('.btn-ok');
        const $title = $ansMessage.find('.message-title');
        $btnCancel.off('click');
        $btnOk.off('click');
        if (!(message.type === msgType.CONFIRM || message.type === msgType.WARNING)) {
            $btnCancel.addClass('hide');
        } else {
            $btnCancel.removeClass('hide');
            $btnCancel.text(message.cancelText);
        }
        if (isEmpty(message.title)) {
            $title.addClass('hide');
        } else {
            $title.removeClass('hide');
            $title.html(`<span>${message.title}</span>`);
        }
        $ansMessage.find('.message-content').html(message.content);
        $btnOk.text(message.okText);
        $btnOk.on('click', () => {
            $('#ansMessage').modal('hide');
            if (typeof message.callback === 'function') {
                setTimeout(() => {
                    message.callback(true);
                }, 300);
            }
        });
        $btnCancel.on('click', () => {
            $('#ansMessage').modal('hide');
            if (typeof message.callback === 'function') {
                setTimeout(() => {
                    message.callback(false);
                }, 300);
            }
        });
        $('#ansMessage').modal('show');
    }
    return {
        initEvents,
        isEmpty,
        isMobile,
        limitInputFollowType,
        initItems,
        getData,
        uuidv4,
        showLoading,
        hideLoading,
        showMessage
    }
})();
const ansNumber = (() => {
    const _getRealMaxLength = ($input, options = {
        isNegative: false,
        isDecimal: false,
        decimal: 2,
        isNoComma: false,
        event: 'blur'
    }) => {
        let maxLength = toNumber($input.attr('real-max-length'));
        const val = $input.val();
        if (maxLength > 0) {
            if (val.indexOf('-') >= 0) {
                maxLength += 1;
            }
            if (val.indexOf('.') >= 0) {
                maxLength += 1;
            }
            if (!options.isNoComma && options.event === 'blur') {
                const length = maxLength - (options.isDecimal ? options.decimal : 0);
                maxLength += Math.floor(length / 3) + (length % 3 > 0 ? 0 : -1);
            }
            $input.attr('maxlength', maxLength);
        }
    }
    const initEvents = () => {
        $(document).on('blur', 'input.numeric', () => {
            const maxLength = toNumber($(this).attr('real-max-length'));
            const options = {
                isDecimal: $(this).hasClass('decimal'),
                decimal: toNumber($(this).attr('decimal')),
                isNegative: $(this).hasClass('negative'),
                isNoComma: $(this).hasClass('no-comma')
            }
            _getRealMaxLength($(this), {
                ...options,
                event: 'blur'
            });
            $(this).val(toNumberString($(this).val(), {
                ...options,
                maxLength: maxLength === 0 ? undefined : maxLength
            }));
        });
        $(document).on('focus', 'input.numeric', () => {
            _getRealMaxLength($(this), {
                isDecimal: $(this).hasClass('decimal'),
                decimal: toNumber($(this).attr('decimal')),
                isNegative: $(this).hasClass('negative'),
                event: 'focus'
            });
            $(this).val($(this).val().replace(/,/g, ''));
        });
        $(document).on('keydown', 'input.numeric', (e) => {
            return ansCommon.limitInputFollowType(e, {
                isDecimal: $(this).hasClass('decimal'),
                isNegative: $(this).hasClass('negative'),
                type: 'numeric'
            });
        });
        $(document).on('keyup', 'input.numeric', (e) => {
            _getRealMaxLength($(this), {
                isDecimal: $(this).hasClass('decimal'),
                decimal: toNumber($(this).attr('decimal')),
                isNegative: $(this).hasClass('negative'),
                event: 'focus'
            });
        });
        $('input.numeric').blur();
    }
    const toNumber = (str, isDefaultIsMax = false) => {
        const defaultVal = isDefaultIsMax ? 4294967295 : 0;
        if (str === undefined || str === null || str === '') {
            return defaultVal;
        }
        let result = parseInt(str ?? '0');
        if (isNaN(result)) {
            result = parseFloat(str ?? '0');
        }
        if (isNaN(result)) {
            return defaultVal;
        }
        return result;
    }
    const toNumberString = (str, options = {
        isDecimal: false,
        decimal: 2,
        isNegative: false,
        isNoComma: false,
        maxLength: undefined
    }) => {
        if (ansCommon.isEmpty(str)) {
            return '';
        }
        let value = str + '';
        let values = [];
        let negative = '';
        let dot = '';
        let afterDot = '';
        if (options.isNegative && value.startsWith('-')) {
            negative = '-';
            value = value.substring(1, value.length);
        }
        values = value.split('.');
        values[0] = values[0].replace(/\D/g, '');
        if (values.length > 1) {
            afterDot = values[1].replace(/\D/g, '');
            if (afterDot.length > options.decimal) {
                afterDot = afterDot.substring(0, options.decimal);
            }
            dot = '.';
        }
        if (ansCommon.isEmpty(values[0]) && (values.length === 1 || ansCommon.isEmpty(afterDot))) {
            return ''
        }
        if (
            options.isDecimal &&
            options.maxLength &&
            options.decimal > 0 &&
            afterDot === '' &&
            value.length > options.maxLength - options.decimal
        ) {
            dot = '.';
            afterDot = values[0].substring(options.maxLength - options.decimal, value.length);
            values[0] = values[0].substring(0, options.maxLength - options.decimal);
        }
        if (ansCommon.isEmpty(values[0])) {
            values[0] = '0';
        }
        if (!options.isNoComma) {
            values[0] = values[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }
        options.isDecimal
          ? (value = negative + values[0] + dot + afterDot)
          : (value = negative + values[0]);
        return value;
    }
    return {
        initEvents,
        toNumber,
        toNumberString
    }
})();
const ansDateTime = (() => {
    const _getAbsoluteMonths = (momentDate) => {
        if (ansCommon.isEmpty(momentDate)) {
            momentDate = moment();
        }
        if (typeof momentDate === 'string') {
            momentDate = moment(`${momentDate?.replace(/\//g, '-')} 00:00:00`);
        }
        if (momentDate.isValid()) {
            momentDate = moment();
        }
        const months = ansCommon.toNumber(momentDate?.format('MM'));
        const years = ansCommon.toNumber(momentDate?.format('YYYY'));
        return months + years * 12;
    }
    const _getRealMaxLength = ($input, options = {
        type: 'date',
        event: 'blur'
    }) => {
        let maxLength = toNumber($input.attr('real-max-length'));
        const val = $($input).val();
        if (maxLength > 0) {
            const countSplash = _.countBy(target?.value ?? '')['/'] || 0;
            if (options.type === 'date' && (countSplash > 2 || options.event === 'blur')) {
                maxLength += 2;
              } else if (options.event === 'blur' || (options.type === 'month' && countSplash > 1) || (options.type === 'time' && val.indexOf(':') >= 0)) {
                maxLength += 1;
              } else {
                maxLength += countSplash;
              }
            $input.attr('maxlength', maxLength);
        }
    }
    const initEvents = () => {
        $(document).on('blur', 'input.date', () => {
            _getRealMaxLength($(this), {
                type: 'date',
                event: 'blur'
            });
            $(this).val(toDateString($(this).val()));
        });
        $(document).on('blur', 'input.month', () => {
            _getRealMaxLength($(this), {
                type: 'month',
                event: 'blur'
            });
            $(this).val(toMonthString($(this).val()));
        });
        $(document).on('blur', 'input.time', () => {
            _getRealMaxLength($(this), {
                type: 'time',
                event: 'blur'
            });
            $(this).val(toTimeString($(this).val()));
        });
        $(document).on('focus', 'input.date', () => {
            _getRealMaxLength($(this), {
                type: 'date',
                event: 'focus'
            });
        });
        $(document).on('focus', 'input.month', () => {
            _getRealMaxLength($(this), {
                type: 'month',
                event: 'focus'
            });
        });
        $(document).on('focus', 'input.time', () => {
            _getRealMaxLength($(this), {
                type: 'time',
                event: 'focus'
            });
        });
        $(document).on('keydown', 'input.date', (e) => {
            return ansCommon.limitInputFollowType(e, {
                type: 'date'
            });
        });
        $(document).on('keydown', 'input.month', (e) => {
            return ansCommon.limitInputFollowType(e, {
                type: 'month'
            });
        });
        $(document).on('keydown', 'input.time', (e) => {
            return ansCommon.limitInputFollowType(e, {
                type: 'time'
            });
        });
        $(document).on('keyup', 'input.date', () => {
            _getRealMaxLength($(this), {
                type: 'date',
                event: 'focus'
            });
        });
        $(document).on('keyup', 'input.month', () => {
            _getRealMaxLength($(this), {
                type: 'month',
                event: 'focus'
            });
        });
        $(document).on('keyup', 'input.time', () => {
            _getRealMaxLength($(this), {
                type: 'time',
                event: 'focus'
            });
        });
        $('input.date, input.month, input.time').blur();
    }
    const initDateTimePicker = () => {
        $('.date-picker').datetimepicker({
            format: 'YYYY/MM/DD', minDate: 1975, maxDate: 9999, allowInputToggle: true
        });
        $('.month-picker').datetimepicker({
            format: 'YYYY/MM', minDate: 1975, maxDate: 9999, allowInputToggle: true
        });
        $('.time-picker').datetimepicker({
            format: 'HH:mm', allowInputToggle: true
        });
    }
    const toDateString = (str) => {
        if (str === undefined || str === null || str === '') {
            return '';
        }
        const tempStr = str.replace(/\D/g, '');
        if (tempStr.length < 5) {
            return '';
        }
        const year = tempStr.substring(0, 4);
        let month = `0${tempStr.substring(4, 5)}`;
        let day = '01';
        if (tempStr.length >= 6) {
            month = tempStr.substring(4, 6);
        }
        if (tempStr.length === 7) {
            day = `0${tempStr.substring(6, 7)}`;
        }
        if (tempStr.length >= 8) {
            day = tempStr.substring(6, 8);
        }
        const tempDate = moment(`${year}-${month}-${day}`);
        if (!tempDate.isValid()) {
            return '';
        }
        return tempDate.format('YYYY/MM/DD');
    }
    const toMonthString = (str) => {
        if (str === undefined || str === null || str === '') {
            return '';
        }
        const tempStr = str.replace(/\D/g, '');
        if (tempStr.length < 4) {
            return '';
        }
        const year = tempStr.substring(0, 4);
        let month = '01';
        if (tempStr.length == 5) {
            month = `0${tempStr.substring(4, 5)}`;
        }
        if (tempStr.length >= 6) {
            month = tempStr.substring(4, 6);
        }
        const tempDate = moment(`${year}-${month}-01`);
        if (!tempDate.isValid()) {
          return '';
        }
        return tempDate.format('YYYY/MM');
    }
    const toTimeString = (str, isOnly24h = false) => {
        if (str === undefined || str === '' || str === null) {
            return '';
        }
        const tempStr = str.replace(/\D/g, '');
        if (tempStr.length == 0) {
            return '00:00';
        }
        if (tempStr.length == 1) {
            return '00:0' + tempStr;
        }
        if (tempStr.length == 2) {
            return '00:' + tempStr;
        }
        let timeStr =
            (tempStr.substring(0, tempStr.length - 2).length == 1
                ? '0' + tempStr.substring(0, tempStr.length - 2)
                : tempStr.substring(0, tempStr.length - 2)) +
            ':' +
            tempStr.substring(tempStr.length - 2, tempStr.length);
        if (isOnly24h) {
            const tempDate = moment(
                `${moment().format('YYYY/MM/DD')} ${timeStr}:00`,
                'YYYY/MM/DD HH:mm:ss'
            );
            if (!tempDate.isValid()) {
                return '';
            }
        }
        return timeStr;
    }
    const plusTime = (time1, time2) => {
        if (ansCommon.isEmpty(time1) && ansCommon.isEmpty(time2)) {
            return '00:00';
        }
        if (ansCommon.isEmpty(time1)) {
            return ansCommon.toTimeString(time2);
        }
        if (ansCommon.isEmpty(time2)) {
            return ansCommon.toTimeString(time1);
        }
        const time1Split = ansCommon.toTimeString(time1).split(':');
        const time2Split = ansCommon.toTimeString(time2).split(':');
        const time1Minute =
            parseInt(time1Split[0].replace(/\D/g, '')) * 60 + parseInt(time1Split[1].replace(/\D/g, ''));
        const time2Minute =
            parseInt(time2Split[0].replace(/\D/g, '')) * 60 + parseInt(time2Split[1].replace(/\D/g, ''));
        const sum = time1Minute + time2Minute;
        const totalHour = Math.floor(sum / 60);
        const totalMinute = sum % 60;
        return `${totalHour < 10 ? '0' : ''}${totalHour}:${totalMinute < 10 ? '0' : ''}${totalMinute}`;
    }
    const minusTime = (time1, time2) => {
        if (ansCommon.isEmpty(time1) && ansCommon.isEmpty(time2)) {
            return '00:00';
        }
        const time1Split = ansCommon.toTimeString(time1).split(':');
        const time2Split = ansCommon.toTimeString(time2).split(':');
        const time1Minute =
            parseInt(time1Split[0].replace(/\D/g, '')) * 60 + parseInt(time1Split[1].replace(/\D/g, ''));
        const time2Minute =
            parseInt(time2Split[0].replace(/\D/g, '')) * 60 + parseInt(time2Split[1].replace(/\D/g, ''));
        const sum = time2Minute - time1Minute;
        const negative = sum < 0 ? '-' : '';
        const totalHour = Math.floor(Math.abs(sum) / 60);
        const totalMinute = Math.abs(sum) % 60;
        return `${negative}${totalHour < 10 ? '0' : ''}${totalHour}:${
            totalMinute < 10 ? '0' : ''
        }${totalMinute}`;
    }
    const compareTime = (time1, time2) => {
        if (ansCommon.isEmpty(time1) || ansCommon.isEmpty(time2)) {
            return 1;
        }
        if (time1 === time2) {
            return 0;
        }
        const time1Split = ansCommon.toTimeString(time1).split(':');
        const time2Split = ansCommon.toTimeString(time2).split(':');
        const time1Minute =
            parseInt(time1Split[0].replace(/\D/g, '')) * 60 + parseInt(time1Split[1].replace(/\D/g, ''));
        const time2Minute =
            parseInt(time2Split[0].replace(/\D/g, '')) * 60 + parseInt(time2Split[1].replace(/\D/g, ''));
        const minus = time2Minute - time1Minute;
        return minus > 0 ? 1 : minus === 0 ? 0 : -1;
    }
    const compareDate = (date1, date2) => {
        if (ansCommon.isEmpty(date1) || ansCommon.isEmpty(date2)) {
            return 1;
        }
        if (date1 === date2) {
            return 0;
        }
        const from = moment(`${date1?.replace(/\//g, '-')} 00:00:00`);
        const to = moment(`${date2?.replace(/\//g, '-')} 00:00:00`);
        if (from < to) {
            return 1;
        }
        if (from === to) {
            return 1;
        }
        return -1;
    }
    const compareMonth = (month1, month2) => {
        if (ansCommon.isEmpty(month1) || ansCommon.isEmpty(month2)) {
            return 1;
        }
        if (month1 === month2) {
            return 0;
        }
        const from = moment(`${month1?.replace(/\//g, '-')}-01 00:00:00`);
        const to = moment(`${month2?.replace(/\//g, '-')}-01 00:00:00`);
        if (from < to) {
            return 1;
        }
        if (from === to) {
            return 0;
        }
        return -1;
    }
    const getDayOfWeek = (day) => {
        try {
            if (!day) {
                day = moment().day();
            }
            return ['日', '月', '火', '水', '木', '金', '土'][day];
        } catch (e) {
            console.log('getDayOfWeek' + e.message);
        }
        return '';
    }
    const monthDiff = (start, end) => {
        const startMonths = _getAbsoluteMonths(start);
        const endMonths = _getAbsoluteMonths(end);
        return endMonths - startMonths;
    }
    return {
        initEvents,
        initDateTimePicker,
        toDateString,
        toMonthString,
        toTimeString,
        plusTime,
        minusTime,
        compareDate,
        compareMonth,
        compareTime,
        getDayOfWeek,
        monthDiff
    }
})();

$(() => {
    ansCommon.initEvents();
    ansNumber.initEvents();
    ansDateTime.initEvents();
    ansDateTime.initDateTimePicker();
});
