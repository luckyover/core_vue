$(() => {
    login.initData();
    login.initEvents();
});

const login = (() => {
    const screenObj = {
        username: {type: 'text', attr: {class: 'required', maxlength: 50}},
        password: {type: 'text', attr: {class: 'required', maxlength: 50}}
    };
    const initData = () => {
        ansCommon.initItems(screenObj);
    }
    const initEvents = () => {
        $('#btn-login').on('click', () => {
            login();
        });
    }
    const login = () => {
        if (ansValidate.isValid(screenObj)) {
            ansAxios.post(urls.login, ansCommon.getData(screenObj))
            .then((res) => {
                Cookies.set('token', res.data?.token ?? '', {
                    path: '/'
                });
                sessionStorage.setItem(
                    'tokenTimeout',
                    moment()
                    .add(res.data?.timeout ?? 0, 'minute')
                    .format('YYYY-MM-DD HH:mm:ss')
                );
                window.location.href = res.data?.urlBefore ?? '/';
            });
        }
    }
    return {
        initData,
        initEvents
    }
})();
