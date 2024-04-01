const ansAxios = axios.create({
    baseURL: '/api',
    timeout: 60000,
    headers: {
        'x-api-key':  $('meta[name="api-key"]').attr('content'),
        // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'X-Get-Blade': 1
    }
});

ansAxios.logError = (error) => {
    console.log('ApiError', error);
    new CustomEvent('ApiError', {
        detail: {
            error,
            type: 'error'
        }
    });
}

ansAxios.interceptors.request.use(
    function (config) {
        config.headers['X-Request-Id'] = ansCommon.uuidv4();
        const token = Cookies.get('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        ansCommon.showLoading();
        return config;
    },
    function (error) {
        ansAxios.logError(error);
        return Promise.reject(error);
    }
)

ansAxios.interceptors.response.use(
    function (response) {
        ansCommon.hideLoading();
      if (typeof ansAxios.onSuccess === 'function') {
        ansAxios.onSuccess(response.data);
        ansAxios.onSuccess = undefined;
      }
      return response.data;
    },
    function (error) {
        ansCommon.hideLoading();
        const { response } = error;
        if (response && [400, 401, 403, 406].includes(response.status)) {
            if (response.status === 400 && response.data?.invalidData) {
            if (typeof ansAxios.onValidate === 'function') {
                ansAxios.onValidate(error);
                ansAxios.onValidate = undefined;
            } else {
                ansValidate.setErrors(response.data?.invalidData)
            }
            } else {
            ansCommon.showMessage({
                type: msgType.ERROR,
                content:
                    response.status === 400
                        ? sysMsg.E400
                        : response.status === 401
                            ? sysMsg.E401
                            : response.status === 403
                                ? sysMsg.E403
                                : response.status === 406
                                    ? response.data?.message ?? sysMsg.E500
                                    : sysMsg.E500,
                callback: () => {
                    if (response.status === 401) {
                        window.location.reload();
                    }
                }
            });
            if (typeof ansAxios.onError === 'function') {
                ansAxios.onError(error);
                ansAxios.onError = onError
            }
            }
        } else {
            ansCommon.showMessage({
                type: msgType.ERROR,
                content: sysMsg.E500
            });
            if (typeof ansAxios.onError === 'function') {
                ansAxios.onError(error);
                ansAxios.onError = onError
            }
        }
        ansAxios.logError(error);
        return Promise.reject(error);
    }
)

ansAxios.settingHandle = (config) => {
    ansAxios.onSuccess = config?.onSuccess;
    ansAxios.onError = config?.onError;
    ansAxios.onValidate = config?.onValidate;
}
